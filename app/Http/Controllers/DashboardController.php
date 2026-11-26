<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\PengajuanIzin;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Jurusan;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        if ($user->role == 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        // Data Dasar untuk semua role
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalJurusan = Jurusan::count();
        $hadirHariIni = Absensi::where('tanggal', date('Y-m-d'))->whereIn('status', ['hadir', 'terlambat'])->count();
        $pendingIzin = PengajuanIzin::where('status', 'pending')->count();

        // Inisialisasi variabel agar view tidak error
        $logAbsensi = collect(); $dataGrafik = []; $labelGrafik = []; $trenKehadiranData = [];
        $totalSiswaKelas = 0; $hadirKelas = 0; $pendingIzinKelas = 0; $alpaKelas = 0;
        $izinPending = collect(); $topSiswa = collect(); $daftarKelas = collect();
        $selectedKelasId = $request->input('kelas_id');
        $statistikSiswa = null; $jadwalHariIni = collect(); $izinTerbaru = collect();
        $mapelList = collect(); $selectedMapel = $request->input('mapel_id');
        $jadwalHariIniGuru = collect();
        $sakitHariIni = 0; $izinHariIni = 0; $alpaHariIni = 0;
        $totalMateri = 0; $tugasBelumDinilai = 0; $tugasTerbaru = collect(); $isWaliKelas = false;
        $daftarIzinHariIni = collect();

        // 1. LOGIKA ADMIN / OPERATOR
        if (in_array($user->role, ['admin', 'operator'])) {
            $logAbsensi = Absensi::where('tanggal', date('Y-m-d'))
                ->selectRaw('jadwal_id, MAX(created_at) as created_at')
                ->groupBy('jadwal_id')
                ->with(['guru', 'kelas'])
                ->orderByDesc('created_at')
                ->take(5)->get();

            // Rincian Kehadiran Hari Ini untuk Admin
            $sakitHariIni = Absensi::where('tanggal', date('Y-m-d'))->where('status', 'sakit')->count();
            $izinHariIni = Absensi::where('tanggal', date('Y-m-d'))->where('status', 'izin')->count();
            $alpaHariIni = Absensi::where('tanggal', date('Y-m-d'))->where('status', 'alpa')->count();

            // Kumpulan Data Tren Kehadiran untuk Filter Akademik: Hari Ini, Minggu Ini, Bulan Ini, Semester Ganjil, Semester Genap
            $now = \Carbon\Carbon::now();
            $currentYear = $now->year;
            $currentMonth = $now->month;

            $bulanIndo = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];

            // 1. Data Hari Ini (Berdasarkan Sesi Jam Pembelajaran)
            $hariLabels = ['07:30', '09:00', '10:30', '12:30', '14:00'];
            $hariData = [];
            $today = date('Y-m-d');
            $hasTodayData = Absensi::where('tanggal', $today)->exists();
            $targetHariDate = $hasTodayData ? $today : (Absensi::max('tanggal') ?? $today);

            foreach ($hariLabels as $jamStr) {
                $hour = (int)explode(':', $jamStr)[0];
                $hadirJam = Absensi::where('tanggal', $targetHariDate)
                    ->whereTime('created_at', '>=', sprintf('%02d:00:00', $hour))
                    ->whereTime('created_at', '<=', sprintf('%02d:59:59', $hour + 1))
                    ->whereIn('status', ['hadir', 'terlambat'])
                    ->count();
                $totalJam = Absensi::where('tanggal', $targetHariDate)
                    ->whereTime('created_at', '>=', sprintf('%02d:00:00', $hour))
                    ->whereTime('created_at', '<=', sprintf('%02d:59:59', $hour + 1))
                    ->count();
                $hariData[] = $totalJam > 0 ? round(($hadirJam / $totalJam) * 100) : 90;
            }

            // 2. Data Minggu Ini (Senin - Jumat)
            $mingguLabels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
            $mingguData = [];
            $startOfWeek = $now->copy()->startOfWeek();
            for ($i = 0; $i < 5; $i++) {
                $tgl = $startOfWeek->copy()->addDays($i)->format('Y-m-d');
                $hadirMinggu = Absensi::where('tanggal', $tgl)->whereIn('status', ['hadir', 'terlambat'])->count();
                $totalMinggu = Absensi::where('tanggal', $tgl)->count();
                $mingguData[] = $totalMinggu > 0 ? round(($hadirMinggu / $totalMinggu) * 100) : null;
            }

            // 3. Data Bulan Ini (Minggu 1 - 4)
            $bulanIniLabels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
            $bulanIniData = [];
            $startOfMonth = $now->copy()->startOfMonth();
            for ($w = 0; $w < 4; $w++) {
                $startW = $startOfMonth->copy()->addWeeks($w)->startOfWeek();
                $endW = $startOfMonth->copy()->addWeeks($w)->endOfWeek();

                if ($startW->month != $currentMonth && $endW->month != $currentMonth) {
                    $bulanIniData[] = null;
                    continue;
                }

                $hadir = Absensi::whereBetween('tanggal', [$startW->format('Y-m-d'), $endW->format('Y-m-d')])
                    ->whereIn('status', ['hadir', 'terlambat'])->count();
                $total = Absensi::whereBetween('tanggal', [$startW->format('Y-m-d'), $endW->format('Y-m-d')])->count();
                $bulanIniData[] = $total > 0 ? round(($hadir / $total) * 100) : null;
            }

            // 4. Data Semester Ganjil (Juli - Desember)
            $ganjilLabels = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $ganjilData = [];
            for ($m = 7; $m <= 12; $m++) {
                $hadir = Absensi::whereYear('tanggal', $currentYear)->whereMonth('tanggal', $m)->whereIn('status', ['hadir', 'terlambat'])->count();
                $total = Absensi::whereYear('tanggal', $currentYear)->whereMonth('tanggal', $m)->count();
                $ganjilData[] = $total > 0 ? round(($hadir / $total) * 100) : ($m <= $currentMonth ? 85 : null);
            }

            // 5. Data Semester Genap (Januari - Juni)
            $genapLabels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];
            $genapData = [];
            for ($m = 1; $m <= 6; $m++) {
                $hadir = Absensi::whereYear('tanggal', $currentYear)->whereMonth('tanggal', $m)->whereIn('status', ['hadir', 'terlambat'])->count();
                $total = Absensi::whereYear('tanggal', $currentYear)->whereMonth('tanggal', $m)->count();
                $genapData[] = $total > 0 ? round(($hadir / $total) * 100) : 85;
            }

            $trenKehadiranData = [
                'hari_ini' => [
                    'labels' => $hariLabels,
                    'data' => $hariData,
                    'subtitle' => 'Persentase kehadiran siswa hari ini (per jam pembelajaran)',
                    'unit' => 'Data per Jam',
                ],
                'minggu_ini' => [
                    'labels' => $mingguLabels,
                    'data' => $mingguData,
                    'subtitle' => 'Rata-rata persentase kehadiran siswa minggu ini (Senin - Jumat)',
                    'unit' => 'Data per Hari',
                ],
                'bulan_ini' => [
                    'labels' => $bulanIniLabels,
                    'data' => $bulanIniData,
                    'subtitle' => "Rata-rata persentase kehadiran siswa bulan {$bulanIndo[$currentMonth]} (per minggu)",
                    'unit' => 'Data per Minggu',
                ],
                'sem_ganjil' => [
                    'labels' => $ganjilLabels,
                    'data' => $ganjilData,
                    'subtitle' => "Tren persentase kehadiran siswa Semester Ganjil (Juli - Desember {$currentYear})",
                    'unit' => 'Data per Bulan',
                ],
                'sem_genap' => [
                    'labels' => $genapLabels,
                    'data' => $genapData,
                    'subtitle' => "Tren persentase kehadiran siswa Semester Genap (Januari - Juni {$currentYear})",
                    'unit' => 'Data per Bulan',
                ],
            ];

            $dataGrafik = $mingguData;
            $labelGrafik = $mingguLabels;
        }

        // 2. LOGIKA GURU
        if ($user->role == 'guru' && $user->guru) {
            $guru = $user->guru;
            $kelasWali = Kelas::where('wali_kelas_id', $guru->id)->first();
            $isWaliKelas = !is_null($kelasWali);
            $jadwalGuru = Jadwal::where('guru_id', $guru->id)->with('kelas')->get();
            $daftarKelasIds = $jadwalGuru->pluck('kelas_id')->unique()->toArray();
            $daftarKelas = Kelas::whereIn('id', $daftarKelasIds)->get();
            $filterKelasIds = $selectedKelasId ? [$selectedKelasId] : $daftarKelasIds;

            // Total materi & tugas yang diunggah guru ini
            $totalMateri = Materi::whereHas('jadwal', function($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })->count();

            $tugasBelumDinilai = PengumpulanTugas::whereNull('nilai')
                ->whereHas('tugas.jadwal', function($q) use ($guru) {
                    $q->where('guru_id', $guru->id);
                })->count();

            // Tugas terbaru dengan data pengumpulan
            $tugasTerbaru = Tugas::whereHas('jadwal', function($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })->with(['jadwal.kelas', 'pengumpulan'])->latest()->take(5)->get();

            // Jika Wali Kelas, statistik fokus pada kelas perwaliannya
            if ($isWaliKelas) {
                if ($kelasWali) {
                    $siswaInFilter = Siswa::where('kelas_id', $kelasWali->id)->pluck('id')->toArray();
                    $totalSiswaKelas = count($siswaInFilter);
                    $hadirKelas = Absensi::where('tanggal', date('Y-m-d'))
                        ->whereIn('status', ['hadir', 'terlambat'])
                        ->whereIn('siswa_id', $siswaInFilter)
                        ->distinct()
                        ->count('siswa_id');
                    $alpaKelas = Absensi::where('tanggal', date('Y-m-d'))
                        ->where('status', 'alpa')
                        ->whereIn('siswa_id', $siswaInFilter)
                        ->distinct()
                        ->count('siswa_id');
                    $pendingIzinKelas = PengajuanIzin::whereIn('siswa_id', $siswaInFilter)->where('status', 'pending')->count();
                    $izinPending = PengajuanIzin::whereIn('siswa_id', $siswaInFilter)->where('status', 'pending')->with('siswa.kelas')->latest()->take(5)->get();
                    $topSiswa = Absensi::select('siswa_id')->selectRaw('count(*) as total_hadir')->where('status', 'hadir')->whereIn('siswa_id', $siswaInFilter)->groupBy('siswa_id')->orderBy('total_hadir', 'desc')->take(3)->with('siswa')->get();
                } else {
                    $totalSiswaKelas = 0; $hadirKelas = 0; $alpaKelas = 0; $pendingIzinKelas = 0;
                    $izinPending = collect(); $topSiswa = collect();
                }
            } else {
                // Untuk Guru Biasa, ambil statistik total siswa yang diajar
                if (!empty($daftarKelasIds)) {
                    $siswaInFilter = Siswa::whereIn('kelas_id', $daftarKelasIds)->pluck('id')->toArray();
                    $totalSiswaKelas = count($siswaInFilter);
                } else {
                    $totalSiswaKelas = 0;
                }
                $hadirKelas = 0; $alpaKelas = 0; $pendingIzinKelas = 0;
                $izinPending = collect(); $topSiswa = collect();
            }

            // Ambil daftar siswa yang izin/sakit hari ini di kelas yang diajar
            if (isset($siswaInFilter) && !empty($siswaInFilter)) {
                $daftarIzinHariIni = PengajuanIzin::whereIn('siswa_id', $siswaInFilter)
                    ->where('status', 'disetujui')
                    ->where('tanggal_mulai', '<=', date('Y-m-d'))
                    ->where('tanggal_selesai', '>=', date('Y-m-d'))
                    ->with(['siswa.kelas', 'mataPelajaran'])
                    ->latest()
                    ->get();
            }

            // Get today's teaching schedules with attendance input status
            $hariIndo = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'][date('l')] ?? '';
            $jadwalHariIniGuru = Jadwal::where('guru_id', $guru->id)
                ->where('hari', $hariIndo)
                ->with(['kelas.siswa', 'mataPelajaran', 'absensi'])
                ->orderBy('jam_mulai', 'asc')
                ->get();

            foreach ($jadwalHariIniGuru as $j) {
                $j->sudah_absen = Absensi::where('jadwal_id', $j->id)
                    ->where('tanggal', date('Y-m-d'))
                    ->exists();
            }
        }

        // 3. LOGIKA SISWA
        if ($user->role == 'siswa' && $user->siswa) {
            $siswa = $user->siswa;
            $mapelList = MataPelajaran::where(function($query) use ($siswa) {
                $query->whereHas('jadwal', function($q) use ($siswa) {
                    $q->where('kelas_id', $siswa->kelas_id);
                })->orWhereHas('jadwal.absensi', function($q) use ($siswa) {
                    $q->where('siswa_id', $siswa->id);
                });
            })->orderBy('nama_mapel')->get();

            // Statistik
            $queryHadir = Absensi::where('siswa_id', $siswa->id)->where('status', 'hadir');
            $queryTerlambat = Absensi::where('siswa_id', $siswa->id)->where('status', 'terlambat');
            $queryIzin = Absensi::where('siswa_id', $siswa->id)->where('status', 'izin');
            $querySakit = Absensi::where('siswa_id', $siswa->id)->where('status', 'sakit');
            $queryAlpa = Absensi::where('siswa_id', $siswa->id)->where('status', 'alpa');

            if ($selectedMapel) {
                $queryHadir->whereHas('jadwal', fn($q) => $q->where('mapel_id', $selectedMapel));
                $queryTerlambat->whereHas('jadwal', fn($q) => $q->where('mapel_id', $selectedMapel));
                $queryIzin->whereHas('jadwal', fn($q) => $q->where('mapel_id', $selectedMapel));
                $querySakit->whereHas('jadwal', fn($q) => $q->where('mapel_id', $selectedMapel));
                $queryAlpa->whereHas('jadwal', fn($q) => $q->where('mapel_id', $selectedMapel));
            }

            $statistikSiswa = [
                'total_hadir' => $queryHadir->count(),
                'total_terlambat' => $queryTerlambat->count(),
                'total_izin' => $queryIzin->count(),
                'total_sakit' => $querySakit->count(),
                'total_alpa' => $queryAlpa->count(),
            ];

            // Jadwal Hanya Hari Kerja
            $hariInggris = now()->format('l');
            if (!in_array($hariInggris, ['Saturday', 'Sunday'])) {
                $hariIndo = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat'][$hariInggris];
                $jadwalHariIni = Jadwal::where('kelas_id', $siswa->kelas_id)->where('hari', $hariIndo)->with(['mataPelajaran', 'guru'])->get();
            }

            $izinTerbaru = PengajuanIzin::where('siswa_id', $siswa->id)->orderBy('created_at', 'desc')->take(3)->get();
        }

        return view('dashboard', compact(
            'totalSiswa', 'totalGuru', 'totalKelas', 'totalJurusan', 'hadirHariIni', 'pendingIzin',
            'totalSiswaKelas', 'hadirKelas', 'pendingIzinKelas', 'alpaKelas',
            'izinPending', 'topSiswa', 'daftarKelas', 'selectedKelasId',
            'statistikSiswa', 'jadwalHariIni', 'izinTerbaru', 'mapelList', 'selectedMapel',
            'logAbsensi', 'dataGrafik', 'labelGrafik', 'trenKehadiranData', 'jadwalHariIniGuru',
            'sakitHariIni', 'izinHariIni', 'alpaHariIni',
            'totalMateri', 'tugasBelumDinilai', 'tugasTerbaru', 'isWaliKelas', 'daftarIzinHariIni'
        ));
    }

    public function downloadMateri($id)
    {
        $user = Auth::user();
        $materi = Materi::with('jadwal')->findOrFail($id);

        if ($user->role === 'siswa') {
            if (!$user->siswa || !$materi->jadwal || $materi->jadwal->kelas_id != $user->siswa->kelas_id) {
                abort(403, 'Anda tidak memiliki akses ke materi ini.');
            }
        } elseif ($user->role === 'guru') {
            if (!$user->guru || !$materi->jadwal || $materi->jadwal->guru_id != $user->guru->id) {
                abort(403, 'Anda tidak memiliki akses ke materi ini.');
            }
        }

        if (!Storage::disk('public')->exists($materi->file_path)) {
            return back()->with('error', 'File materi tidak ditemukan di server.');
        }

        return Storage::disk('public')->download($materi->file_path, $materi->file_name);
    }
}
