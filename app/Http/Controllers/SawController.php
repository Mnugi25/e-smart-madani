<?php

namespace App\Http\Controllers;

use App\Models\Siswa; // Pastikan model Siswa ada
use App\Models\Absensi; // Pastikan model Absensi ada
use App\Models\KriteriaSaw;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SawController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;

        // Cek apakah guru adalah Wali Kelas (memiliki kelas perwalian di database)
        $kelasWali = \App\Models\Kelas::where('wali_kelas_id', $guru->id)->first();
        
        if (!$kelasWali) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Fitur ini hanya untuk Wali Kelas (Anda belum ditunjuk untuk kelas manapun).');
        }

        $semester = $request->get('semester', (date('n') <= 6 ? 'genap' : 'ganjil'));
        $tahun = $request->get('tahun', date('Y'));

        $startDate = $semester == 'ganjil' ? "$tahun-07-01" : "$tahun-01-01";
        $endDate = $semester == 'ganjil' ? "$tahun-12-31" : "$tahun-06-30";

        // 1. Ambil data siswa dan absensinya untuk perhitungan SAW perwalian kelas
        $siswaList = Siswa::where('kelas_id', $kelasWali->id)
            ->with(['absensi' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            }])
            ->get();
        
        // Ambil ID semua tugas kelas ini pada semester & tahun yang dipilih
        $tugasIds = \App\Models\Tugas::whereIn('jadwal_id', \App\Models\Jadwal::where('kelas_id', $kelasWali->id)->pluck('id'))
            ->whereBetween('waktu_mulai', [$startDate, $endDate])
            ->pluck('id');

        // Hitung total tugas kelas
        $totalTugas = $tugasIds->count();

        // Hitung jumlah pengumpulan per siswa di kelas ini (hanya untuk tugas pada semester & tahun tersebut yang memiliki link_tugas / benar-benar mengumpulkan)
        $pengumpulanCounts = \App\Models\PengumpulanTugas::whereIn('siswa_id', $siswaList->pluck('id'))
            ->whereIn('tugas_id', $tugasIds)
            ->whereNotNull('link_tugas')
            ->where('link_tugas', '!=', '')
            ->select('siswa_id', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('siswa_id')
            ->pluck('total', 'siswa_id');

        $matrixX = [];
        foreach ($siswaList as $s) {
            $abs = $s->absensi;
            $totalAbsen = $abs->count();
            
            // C1: Pengumpulan Tugas (Benefit)
            $totalKumpul = $pengumpulanCounts[$s->id] ?? 0;
            $c1 = $totalTugas > 0 ? min(1.0, $totalKumpul / $totalTugas) : 1.0;
            
            // C2: Kehadiran (Benefit: hadir = 1.0, izin/sakit = 0.8, alpa = 0, terlambat diabaikan)
            $hadirCount = $abs->where('status', 'hadir')->count();
            $terlambatCount = $abs->where('status', 'terlambat')->count();
            $izinCount = $abs->where('status', 'izin')->count();
            $sakitCount = $abs->where('status', 'sakit')->count();
            $alpaCount = $abs->where('status', 'alpa')->count();
            $totalAbsenC2 = $hadirCount + $izinCount + $sakitCount + $alpaCount;
            
            $c2Score = ($hadirCount * 1.0) + ($izinCount * 0.8) + ($sakitCount * 0.8);
            $c2 = $totalAbsenC2 > 0 ? ($c2Score / $totalAbsenC2) : 0;
            
            // C3: Keterlambatan (Cost, status 'terlambat' saja)
            $terlambat = $abs->where('status', 'terlambat')->count();
            $c3 = $totalAbsen > 0 ? ($terlambat / $totalAbsen) : 0;
            
            $matrixX[$s->id] = [
                'siswa' => $s,
                'counts' => [
                    'tugas_dikumpul' => $totalKumpul,
                    'total_tugas' => $totalTugas,
                    'hadir' => $hadirCount,
                    'terlambat' => $terlambatCount,
                    'izin' => $izinCount,
                    'sakit' => $sakitCount,
                    'alpa' => $alpaCount,
                    'c2_score' => $c2Score,
                    'total_absen' => $totalAbsen,
                ],
                'c1' => $c1,
                'c2' => $c2,
                'c3' => $c3,
            ];
        }

        // 2. Cari Nilai Max untuk Normalisasi dalam lingkup kelas
        $maxC1 = collect($matrixX)->max('c1') ?: 1;
        $maxC2 = collect($matrixX)->max('c2') ?: 1;
        $maxC3 = collect($matrixX)->max('c3') ?: 1;

        // 3. Normalisasi (Matrix R) dan Hitung Preferensi (Skor V)
        $rankings = [];
        $wC1 = 0.50; // Tugas (Benefit)
        $wC2 = 0.20; // Kehadiran (Benefit)
        $wC3 = 0.30; // Keterlambatan (Cost)

        foreach ($matrixX as $siswaId => $data) {
            $r1 = $maxC1 > 0 ? ($data['c1'] / $maxC1) : 0;
            $r2 = $maxC2 > 0 ? ($data['c2'] / $maxC2) : 0;
            $r3 = $data['c3'] == 0 ? 1 : 1 - ($data['c3'] / $maxC3);
            
            $skorV = ($r1 * $wC1) + ($r2 * $wC2) + ($r3 * $wC3);
            
            $rankings[] = [
                'siswa_id' => $siswaId,
                'siswa' => $data['siswa'],
                'counts' => $data['counts'],
                'raw' => [
                    'c1' => $data['c1'],
                    'c2' => $data['c2'],
                    'c3' => $data['c3'],
                ],
                'normalized' => [
                    'r1' => $r1,
                    'r2' => $r2,
                    'r3' => $r3,
                ],
                'skor_v' => $skorV,
            ];
        }

        // Urutkan perankingan secara descending
        usort($rankings, function($a, $b) {
            return $b['skor_v'] <=> $a['skor_v'];
        });

        // 4. Ambil siswa tidak disiplin (atRisk) untuk kelas ini (alpa > 12)
        $atRisk = Siswa::where('kelas_id', $kelasWali->id)
            ->whereHas('absensi', function ($query) use ($startDate, $endDate) {
                $query->where('status', 'alpa')
                      ->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->withCount(['absensi' => function ($query) use ($startDate, $endDate) {
                $query->where('status', 'alpa')
                      ->whereBetween('tanggal', [$startDate, $endDate]);
            }])
            ->having('absensi_count', '>', 12)
            ->get();

        return view('guru.saw.index', compact('rankings', 'matrixX', 'maxC1', 'maxC2', 'maxC3', 'atRisk', 'kelasWali', 'semester', 'tahun'));
    }

    public function hitungSaw(Request $request, \App\Services\SawService $saw)
    {
        $semester = $request->get('semester', (date('n') <= 6 ? 'genap' : 'ganjil'));
        $tahun = $request->get('tahun', date('Y'));

        $startDate = $semester == 'ganjil' ? "$tahun-07-01" : "$tahun-01-01";
        $endDate = $semester == 'ganjil' ? "$tahun-12-31" : "$tahun-06-30";

        $saw->calculate($startDate, $endDate);
        return redirect()->route('guru.saw.index', ['semester' => $semester, 'tahun' => $tahun])->with('success', 'Analisis SAW berhasil diperbarui!');
    }

    public function rilisJuara(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'skor' => 'required'
        ]);

        $siswa = Siswa::findOrFail($request->siswa_id);

        // Simpan hasil ke cache agar data rilis terdisiplin bisa dipakai di halaman lain jika dibutuhkan
        cache()->put('siswa_terdisiplin', [
            'nama' => $siswa->nama_lengkap,
            'nisn' => $siswa->nisn,
            'skor' => $request->skor,
            'tanggal' => now()->toDateString()
        ], now()->addDays(7));

        return redirect()->back()->with('success', 'Rekomendasi siswa terdisiplin (' . $siswa->nama_lengkap . ') dengan skor ' . number_format($request->skor, 4) . ' berhasil dirilis.');
    }
}
