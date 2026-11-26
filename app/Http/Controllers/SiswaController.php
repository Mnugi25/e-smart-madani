<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\PengajuanIzin;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            abort(403, 'Anda tidak memiliki profil siswa.');
        }
        return $siswa;
    }

    public function dashboard(Request $request)
    {
        $siswa = $this->getSiswa();
        $selectedMapel = $request->input('mapel_id');
        
        // Ambil daftar mata pelajaran unik yang ada di jadwal kelas siswa tersebut atau riwayat absensinya
        $mapelList = MataPelajaran::where(function($query) use ($siswa) {
            $query->whereHas('jadwal', function($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id);
            })->orWhereHas('jadwal.absensi', function($q) use ($siswa) {
                $q->where('siswa_id', $siswa->id);
            });
        })->orderBy('nama_mapel')->get();

        $queryHadir = Absensi::where('siswa_id', $siswa->id)->whereRaw('LOWER(status) = ?', ['hadir']);
        $queryTerlambat = Absensi::where('siswa_id', $siswa->id)->whereRaw('LOWER(status) = ?', ['terlambat']);
        $queryIzin = Absensi::where('siswa_id', $siswa->id)->whereRaw('LOWER(status) = ?', ['izin']);
        $querySakit = Absensi::where('siswa_id', $siswa->id)->whereRaw('LOWER(status) = ?', ['sakit']);
        $queryAlpa = Absensi::where('siswa_id', $siswa->id)->whereRaw('LOWER(status) = ?', ['alpa']);

        // Jika ada filter mapel, saring berdasarkan jadwal yang terkait dengan mapel tersebut
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

        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hariIni = $days[now()->dayOfWeek];
        $jamSekarang = now()->format('H:i:s');
        $today = now()->toDateString();

        // Ambil izin yang disetujui hari ini untuk pencocokan status jadwal
        $izinHariIni = PengajuanIzin::where('siswa_id', $siswa->id)
            ->where('status', 'disetujui')
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->get()
            ->keyBy('mapel_id');

        // Eager-load absensi hari ini milik siswa tersebut
        $jadwalHariIni = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->with(['mataPelajaran', 'guru', 'absensi' => function($q) use ($siswa, $today) {
                $q->where('siswa_id', $siswa->id)->where('tanggal', $today);
            }])
            ->get();

        // Cari jadwal yang sedang berlangsung sekarang
        $jadwalSekarang = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->where('jam_mulai', '<=', $jamSekarang)
            ->where('jam_selesai', '>=', $jamSekarang)
            ->first();

        $sudahAbsen = false;
        if ($jadwalSekarang) {
            $sudahAbsen = Absensi::where('siswa_id', $siswa->id)
                ->where('jadwal_id', $jadwalSekarang->id)
                ->where('tanggal', $today)
                ->exists();
        }

        $izinTerbaru = PengajuanIzin::where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Ambil tugas terbaru
        $tugasTerbaru = Tugas::whereHas('jadwal', function($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id);
            })
            ->with(['jadwal.mataPelajaran', 'pengumpulan' => function($q) use ($siswa) {
                $q->where('siswa_id', $siswa->id);
            }])
            ->latest()
            ->take(3)
            ->get();

        // Ambil materi terbaru
        $materiTerbaru = Materi::whereHas('jadwal', function($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id);
            })
            ->with(['jadwal.mataPelajaran'])
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'siswa', 'statistikSiswa', 'jadwalHariIni', 'jadwalSekarang', 'sudahAbsen', 
            'izinTerbaru', 'mapelList', 'selectedMapel', 'izinHariIni', 'tugasTerbaru', 'materiTerbaru', 'hariIni'
        ));
    }

    public function jadwal()
    {
        $siswa = $this->getSiswa();
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hariIni = $days[now()->dayOfWeek];
        $jamSekarang = now()->format('H:i:s');
        $tanggalHariIni = now()->toDateString();

        $jadwal = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->with(['mataPelajaran', 'guru'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai')
            ->get();

        // Ambil data absensi siswa hari ini untuk semua jadwal kelasnya
        $absensiSiswa = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $tanggalHariIni)
            ->pluck('jadwal_id')
            ->toArray();

        // Proses data untuk menandai mana yang aktif
        $jadwal = $jadwal->map(function ($item) use ($hariIni, $jamSekarang, $absensiSiswa) {
            $isAktif = ($item->hari == $hariIni && $item->jam_mulai <= $jamSekarang && $item->jam_selesai >= $jamSekarang);
            $sudahAbsen = in_array($item->id, $absensiSiswa);
            
            $item->is_aktif = $isAktif;
            $item->sudah_absen = $sudahAbsen;
            return $item;
        })->groupBy('hari');

        return view('siswa.jadwal', compact('jadwal', 'hariIni', 'siswa'));
    }

    public function submitPresensi(Request $request)
    {
        $siswa = $this->getSiswa();
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hariIni = $days[now()->dayOfWeek];
        $jamSekarang = now()->format('H:i:s');

        $jadwalSekarang = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->where('jam_mulai', '<=', $jamSekarang)
            ->where('jam_selesai', '>=', $jamSekarang)
            ->first();

        if (!$jadwalSekarang) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Tidak ada jadwal pelajaran aktif saat ini.'], 400);
            }
            return back()->with('error', 'Tidak ada jadwal pelajaran aktif saat ini.');
        }

        $exist = Absensi::where('siswa_id', $siswa->id)
            ->where('jadwal_id', $jadwalSekarang->id)
            ->where('tanggal', now()->toDateString())
            ->exists();

        if ($exist) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Anda sudah melakukan absensi untuk mata pelajaran ini.'], 400);
            }
            return back()->with('info', 'Anda sudah melakukan absensi untuk mata pelajaran ini.');
        }

        $image = $request->input('image');
        $path = null;
        if ($image) {
            // Remove the base64 prefix if exists
            if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
                $image = substr($image, strpos($image, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, etc.
            } else {
                $type = 'jpg';
            }
            
            $decodedImage = base64_decode($image);
            if ($decodedImage === false) {
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'Format gambar tidak valid.'], 400);
                }
                return back()->with('error', 'Format gambar tidak valid.');
            }
            
            $imageName = time() . '_' . $siswa->id . '_' . $jadwalSekarang->id . '.' . $type;
            Storage::disk('public')->put('absensi_selfie/' . $imageName, $decodedImage);
            $path = 'absensi_selfie/' . $imageName;
        }

        $statusAbsen = 'hadir';
        $keteranganDetail = 'Absen mandiri dengan deteksi keaktifan (Liveness) pada ' . now()->format('H:i:s');

        $jamMulai = \Carbon\Carbon::createFromFormat('H:i:s', $jadwalSekarang->jam_mulai);
        $jamAbsen = \Carbon\Carbon::createFromFormat('H:i:s', $jamSekarang);
        $selisihMenit = $jamMulai->diffInMinutes($jamAbsen, false);

        if ($selisihMenit > 15) {
            $statusAbsen = 'terlambat';
            $keteranganDetail .= ' (Terlambat ' . $selisihMenit . ' menit)';
        }

        Absensi::create([
            'siswa_id' => $siswa->id,
            'jadwal_id' => $jadwalSekarang->id,
            'tanggal' => now()->toDateString(),
            'status' => $statusAbsen,
            'foto' => $path,
            'keterangan' => $keteranganDetail
        ]);

        $pesanSukses = $statusAbsen == 'terlambat' 
            ? 'Absensi berhasil! Anda tercatat TERLAMBAT.' 
            : 'Absensi berhasil! Anda tercatat HADIR.';

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $pesanSukses,
                'redirect' => route('siswa.riwayat')
            ]);
        }

        return redirect()->route('siswa.riwayat')->with('success', $pesanSukses);
    }

    public function riwayat(Request $request)
    {
        $siswa = $this->getSiswa();
        $selectedMapel = $request->input('mapel_id');
        
        $mapelList = MataPelajaran::where(function($query) use ($siswa) {
            $query->whereHas('jadwal', function($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id);
            })->orWhereHas('jadwal.absensi', function($q) use ($siswa) {
                $q->where('siswa_id', $siswa->id);
            });
        })->orderBy('nama_mapel')->get();

        $baseQuery = Absensi::where('siswa_id', $siswa->id);

        if ($selectedMapel) {
            $baseQuery->whereHas('jadwal', function($q) use ($selectedMapel) {
                $q->where('mapel_id', $selectedMapel);
            });
        }

        // Hitung statistik kehadiran
        $counts = (clone $baseQuery)
            ->selectRaw('LOWER(TRIM(status)) as st, count(*) as total')
            ->groupBy('st')
            ->pluck('total', 'st');

        $hadir = (int)($counts['hadir'] ?? 0);
        $terlambat = (int)($counts['terlambat'] ?? 0);
        $izin = (int)($counts['izin'] ?? 0);
        $sakit = (int)($counts['sakit'] ?? 0);
        $alpa = (int)($counts['alpa'] ?? 0);
        $total = $hadir + $terlambat + $izin + $sakit + $alpa;
        $persentase = $total > 0 ? round((($hadir + $terlambat) / $total) * 100, 1) : 0;

        $stats = [
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpa' => $alpa,
            'total' => $total,
            'persentase' => $persentase,
        ];

        $riwayat = (clone $baseQuery)
            ->with(['jadwal.mataPelajaran', 'jadwal.guru'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('siswa.riwayat', compact('riwayat', 'mapelList', 'selectedMapel', 'siswa', 'stats'));
    }

    public function izin()
    {
        $siswa = $this->getSiswa();
        $daftarIzin = PengajuanIzin::where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Ambil mata pelajaran dan guru pengampunya
        $jadwalData = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->with(['mataPelajaran', 'guru'])
            ->get();
            
        $mapelList = $jadwalData->unique('mapel_id')->map(function($jadwal) {
            return [
                'id' => $jadwal->mapel_id,
                'nama' => $jadwal->mataPelajaran ? $jadwal->mataPelajaran->nama_mapel : 'N/A',
                'guru' => $jadwal->guru ? $jadwal->guru->nama_lengkap : 'N/A'
            ];
        });

        return view('siswa.izin', compact('daftarIzin', 'mapelList'));
    }

    public function simpanIzin(Request $request)
    {
        $siswa = $this->getSiswa();

        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis' => 'required|in:sakit,izin',
            'alasan' => 'required|string',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'file_bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('file_bukti')) {
            $path = $request->file('file_bukti')->store('bukti_izin', 'public');
        }

        $izin = PengajuanIzin::create([
            'siswa_id' => $siswa->id,
            'mapel_id' => $request->mapel_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis' => $request->jenis,
            'alasan' => $request->alasan,
            'file_bukti' => $path,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    public function profil()
    {
        $user = Auth::user();
        return view('siswa.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->nama = $request->nama;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function ruangMateri($jadwal_id)
    {
        $siswa = $this->getSiswa();
        $jadwal = Jadwal::where('kelas_id', $siswa->kelas_id)->with(['mataPelajaran', 'guru'])->findOrFail($jadwal_id);
        $materis = Materi::where('jadwal_id', $jadwal_id)->latest()->get();
        return view('siswa.materi.index', compact('jadwal', 'materis'));
    }

    public function ruangTugas($jadwal_id)
    {
        $siswa = $this->getSiswa();
        $jadwal = Jadwal::where('kelas_id', $siswa->kelas_id)->with(['mataPelajaran', 'guru'])->findOrFail($jadwal_id);
        
        $tugas = Tugas::where('jadwal_id', $jadwal_id)
            ->with(['pengumpulan' => function($q) use ($siswa) {
                $q->where('siswa_id', $siswa->id);
            }])
            ->latest()
            ->get();

        return view('siswa.tugas.index', compact('jadwal', 'tugas'));
    }

    public function formTugas($tugas_id)
    {
        $siswa = $this->getSiswa();
        $tugas = Tugas::with('jadwal.mataPelajaran')->findOrFail($tugas_id);
        
        // Verifikasi apakah tugas untuk kelas siswa tersebut
        if ($tugas->jadwal->kelas_id != $siswa->kelas_id) {
            abort(403, 'Tugas ini bukan untuk kelas Anda.');
        }

        $pengumpulan = PengumpulanTugas::where('tugas_id', $tugas_id)
            ->where('siswa_id', $siswa->id)
            ->first();

        return view('siswa.tugas.form', compact('tugas', 'pengumpulan'));
    }

    public function submitTugas(Request $request, $tugas_id)
    {
        $siswa = $this->getSiswa();
        $tugas = Tugas::with('jadwal')->findOrFail($tugas_id);

        if (!$tugas->jadwal || $tugas->jadwal->kelas_id != $siswa->kelas_id) {
            abort(403, 'Tugas ini bukan untuk kelas Anda.');
        }

        // Cek deadline
        if ($tugas->deadline && \Carbon\Carbon::now()->isAfter($tugas->deadline)) {
            return back()->with('error', 'Batas waktu pengumpulan telah berakhir.');
        }

        $request->validate([
            'link_tugas' => 'required|url',
            'catatan' => 'nullable|string',
        ], [
            'link_tugas.required' => 'Tautan tugas wajib diisi.',
            'link_tugas.url' => 'Format tautan tugas tidak valid. Pastikan diawali dengan http:// atau https://',
            'catatan.string' => 'Catatan harus berupa teks.',
        ]);

        PengumpulanTugas::updateOrCreate(
            ['tugas_id' => $tugas_id, 'siswa_id' => $siswa->id],
            ['link_tugas' => $request->link_tugas, 'catatan' => $request->catatan]
        );

        return redirect()->route('siswa.tugas', $tugas->jadwal_id)->with('success', 'Tugas berhasil dikumpulkan!');
    }
}
