<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class GuruController extends Controller
{
    // Mengambil profil guru yang sedang login
    private function getGuru()
    {
        $guru = Auth::user()->guru;
        if (!$guru) {
            abort(403, 'Anda tidak memiliki profil guru.');
        }
        return $guru;
    }

    public function dashboard()
    {
        $guru = $this->getGuru();
        $jadwalIds = Jadwal::where('guru_id', $guru->id)->pluck('id');

        $statistik = [
            'hadir_hari_ini' => Absensi::whereIn('jadwal_id', $jadwalIds)
                ->where('tanggal', now()->toDateString())
                ->whereRaw('LOWER(TRIM(status)) = ?', ['hadir'])
                ->count(),
            'alpa_hari_ini' => Absensi::whereIn('jadwal_id', $jadwalIds)
                ->where('tanggal', now()->toDateString())
                ->whereRaw('LOWER(TRIM(status)) = ?', ['alpa'])
                ->count(),
        ];

        // Optimasi: Gunakan query database untuk menghitung top siswa daripada filter di collection
        $topSiswa = Absensi::whereIn('jadwal_id', $jadwalIds)
            ->whereNotNull('siswa_id')
            ->whereRaw('LOWER(TRIM(status)) = ?', ['hadir'])
            ->selectRaw('siswa_id, count(*) as total_hadir')
            ->groupBy('siswa_id')
            ->orderByDesc('total_hadir')
            ->limit(5)
            ->with('siswa')
            ->get();

        return view('dashboard', compact('statistik', 'topSiswa'));
    }

    public function indexJadwal()
    {
        $guru = $this->getGuru();
        $jadwal = Jadwal::where('guru_id', $guru->id)
                        ->with(['kelas', 'mataPelajaran'])
                        ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
                        ->orderBy('jam_mulai')
                        ->get();

        return view('guru.presensi.index', compact('jadwal'));
    }

    public function lembarAbsen($id)
    {
        $guru = $this->getGuru();
        // Pastikan jadwal yang dibuka milik guru tersebut
        $jadwal = Jadwal::where('guru_id', $guru->id)->with(['kelas', 'mataPelajaran'])->findOrFail($id);
        $siswa = Siswa::where('kelas_id', $jadwal->kelas_id)->get();
        $tanggal = date('Y-m-d');

        // Mengambil data absensi hari ini agar form terisi jika sudah pernah disimpan
        $absensi = Absensi::where('jadwal_id', $id)
            ->where('tanggal', $tanggal)
            ->get()
            ->keyBy('siswa_id');

        // Cek izin yang disetujui untuk hari ini
        $izinDisetujui = \App\Models\PengajuanIzin::where('status', 'disetujui')
            ->where('tanggal_mulai', '<=', $tanggal)
            ->where('tanggal_selesai', '>=', $tanggal)
            ->whereIn('siswa_id', $siswa->pluck('id'))
            ->get()
            ->keyBy('siswa_id');

        return view('guru.presensi.kelas', compact('jadwal', 'siswa', 'tanggal', 'absensi', 'izinDisetujui'));
    }

    public function simpanAbsen(Request $request, $jadwal_id)
    {
        $guru = $this->getGuru();
        // Verifikasi kepemilikan jadwal
        Jadwal::where('id', $jadwal_id)->where('guru_id', $guru->id)->firstOrFail();

        $request->validate(['status' => 'required|array']);

        foreach ($request->status as $siswa_id => $status) {
            Absensi::updateOrCreate(
                ['siswa_id' => $siswa_id, 'jadwal_id' => $jadwal_id, 'tanggal' => $request->tanggal],
                ['status' => $status, 'keterangan' => $request->keterangan[$siswa_id] ?? null]
            );
        }
        return redirect()->route('guru.jadwal')->with('success', 'Data absensi tersimpan.');
    }

    public function rekapBulanan(Request $request)
    {
        $guru = $this->getGuru();
        // Ambil bulan dan tahun (default ke bulan & tahun berjalan jika tidak ada filter)
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);
        $jadwal_id = $request->input('jadwal_id');

        // Ambil semua jadwal/kelas yang diajar guru tersebut, buat unik berdasarkan kelas dan mata pelajaran
        $daftarJadwal = Jadwal::where('guru_id', $guru->id)
            ->with(['kelas', 'mataPelajaran'])
            ->get()
            ->unique(function ($item) {
                return $item->kelas_id . '-' . $item->mapel_id;
            });
 
        // Tentukan jadwal yang aktif (default ke yang pertama jika tidak ada input)
        if ($jadwal_id) {
            $jadwalAktif = Jadwal::where('guru_id', $guru->id)->with(['kelas', 'mataPelajaran'])->find($jadwal_id);
        } else {
            $jadwalAktif = $daftarJadwal->first();
        }
 
        $semuaSiswa = collect();
        $rekapSiswa = collect();
        $showTerlambat = true;
 
        if ($jadwalAktif) {
            $semuaSiswa = Siswa::where('kelas_id', $jadwalAktif->kelas_id)->get();
 
            // Kumpulkan semua jadwal yang mengajar kelas dan mapel yang sama
            $semuaJadwalIds = Jadwal::where('guru_id', $guru->id)
                ->where('kelas_id', $jadwalAktif->kelas_id)
                ->where('mapel_id', $jadwalAktif->mapel_id)
                ->pluck('id');

            $dataAbsensi = Absensi::whereIn('jadwal_id', $semuaJadwalIds)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();
 
            $rekapSiswa = $semuaSiswa->map(function ($siswa) use ($dataAbsensi) {
                $items = $dataAbsensi->where('siswa_id', $siswa->id);
                return [
                    'nama' => $siswa->nama_lengkap,
                    'nisn' => $siswa->nisn,
                    'c1'   => $items->where('status', 'hadir')->count(),
                    'terlambat' => $items->where('status', 'terlambat')->count(),
                    'c2'   => $items->where('status', 'izin')->count(),
                    'c3'   => $items->where('status', 'sakit')->count(),
                    'c4'   => $items->where('status', 'alpa')->count(),
                ];
            });
        }
 
        return view('guru.presensi.rekap', compact('rekapSiswa', 'bulan', 'tahun', 'daftarJadwal', 'jadwalAktif', 'showTerlambat'));
    }

    public function exportRekap(Request $request)
    {
        $guru = $this->getGuru();
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);
        $jadwal_id = $request->input('jadwal_id');

        $jadwalAktif = Jadwal::where('guru_id', $guru->id)->with(['kelas', 'mataPelajaran'])->findOrFail($jadwal_id);
        
        $semuaSiswa = Siswa::where('kelas_id', $jadwalAktif->kelas_id)->get();

        // Kumpulkan semua jadwal yang mengajar kelas dan mapel yang sama
        $semuaJadwalIds = Jadwal::where('guru_id', $guru->id)
            ->where('kelas_id', $jadwalAktif->kelas_id)
            ->where('mapel_id', $jadwalAktif->mapel_id)
            ->pluck('id');

        $dataAbsensi = Absensi::whereIn('jadwal_id', $semuaJadwalIds)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();
 
        $namaFile = "Rekap_Presensi_" . str_replace(' ', '_', $jadwalAktif->kelas->nama_kelas) . "_" . date('F_Y', mktime(0, 0, 0, $bulan, 1, $tahun)) . ".xls";
 
        $headers = [
            "Content-type"        => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$namaFile",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
 
        $showTerlambat = true;
 
        return response()->view('guru.presensi.export_excel', [
            'semuaSiswa' => $semuaSiswa,
            'dataAbsensi' => $dataAbsensi,
            'jadwalAktif' => $jadwalAktif,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'showTerlambat' => $showTerlambat
        ], 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $guru = $this->getGuru();
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);
        $jadwal_id = $request->input('jadwal_id');

        $jadwalAktif = Jadwal::where('guru_id', $guru->id)->with(['kelas', 'mataPelajaran'])->findOrFail($jadwal_id);
        
        $semuaSiswa = Siswa::where('kelas_id', $jadwalAktif->kelas_id)->get();

        // Kumpulkan semua jadwal yang mengajar kelas dan mapel yang sama
        $semuaJadwalIds = Jadwal::where('guru_id', $guru->id)
            ->where('kelas_id', $jadwalAktif->kelas_id)
            ->where('mapel_id', $jadwalAktif->mapel_id)
            ->pluck('id');

        $dataAbsensi = Absensi::whereIn('jadwal_id', $semuaJadwalIds)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();
 
        $rekapSiswa = $semuaSiswa->map(function ($siswa) use ($dataAbsensi) {
            $items = $dataAbsensi->where('siswa_id', $siswa->id);
            return [
                'nama' => $siswa->nama_lengkap,
                'nisn' => $siswa->nisn,
                'c1'   => $items->where('status', 'hadir')->count(),
                'terlambat' => $items->where('status', 'terlambat')->count(),
                'c2'   => $items->where('status', 'izin')->count(),
                'c3'   => $items->where('status', 'sakit')->count(),
                'c4'   => $items->where('status', 'alpa')->count(),
            ];
        });
 
        $showTerlambat = true;

        $pdf = Pdf::loadView('guru.presensi.rekap_pdf', compact('rekapSiswa', 'bulan', 'tahun', 'jadwalAktif', 'showTerlambat'));
        $pdf->setPaper('a4', 'portrait');

        $namaFile = "Rekap_Presensi_" . str_replace(' ', '_', $jadwalAktif->kelas->nama_kelas) . "_" . date('F_Y', mktime(0, 0, 0, $bulan, 1, $tahun)) . ".pdf";
        return $pdf->download($namaFile);
    }

    public function ruangMateri($jadwal_id)
    {
        $guru = $this->getGuru();
        $jadwal = Jadwal::where('guru_id', $guru->id)->with(['kelas', 'mataPelajaran'])->findOrFail($jadwal_id);
        $materis = Materi::where('jadwal_id', $jadwal_id)->latest()->get();
        return view('guru.materi.index', compact('jadwal', 'materis'));
    }

    public function storeMateri(Request $request, $jadwal_id)
    {
        $guru = $this->getGuru();
        Jadwal::where('guru_id', $guru->id)->findOrFail($jadwal_id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'video_url' => 'nullable|url',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:10240', // Max 10MB
        ]);

        $data = [
            'jadwal_id' => $jadwal_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'video_url' => $request->video_url,
        ];

        if ($request->hasFile('file_materi')) {
            $file = $request->file('file_materi');
            $path = $file->store('materi', 'public');

            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
        }

        Materi::create($data);

        return back()->with('success', 'Materi berhasil diunggah!');

        return back()->with('error', 'Gagal mengunggah materi.');
    }

    public function updateMateri(Request $request, $id)
    {
        $guru = $this->getGuru();
        $materi = Materi::findOrFail($id);
        
        // Verifikasi kepemilikan via jadwal
        Jadwal::where('guru_id', $guru->id)->findOrFail($materi->jadwal_id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'video_url' => 'nullable|url',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:10240',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'video_url' => $request->video_url,
        ];

        if ($request->hasFile('file_materi')) {
            // Hapus file lama
            Storage::disk('public')->delete($materi->file_path);

            // Simpan file baru
            $file = $request->file('file_materi');
            $path = $file->store('materi', 'public');

            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
        }

        $materi->update($data);

        return back()->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroyMateri($id)
    {
        $guru = $this->getGuru();
        $materi = Materi::findOrFail($id);
        
        // Verifikasi kepemilikan via jadwal
        Jadwal::where('guru_id', $guru->id)->findOrFail($materi->jadwal_id);

        Storage::disk('public')->delete($materi->file_path);
        $materi->delete();

        return back()->with('success', 'Materi berhasil dihapus!');
    }

    public function ruangTugas($jadwal_id)
    {
        $guru = $this->getGuru();
        $jadwal = Jadwal::where('guru_id', $guru->id)->with(['kelas', 'mataPelajaran'])->findOrFail($jadwal_id);
        $tugas = Tugas::where('jadwal_id', $jadwal_id)->latest()->get();
        return view('guru.tugas.index', compact('jadwal', 'tugas'));
    }

    public function storeTugas(Request $request, $jadwal_id)
    {
        $guru = $this->getGuru();
        Jadwal::where('guru_id', $guru->id)->findOrFail($jadwal_id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_mulai' => 'required|date',
            'deadline' => 'nullable|date|after:waktu_mulai',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:10240',
        ]);

        $data = [
            'jadwal_id' => $jadwal_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'waktu_mulai' => $request->waktu_mulai,
            'deadline' => $request->deadline,
        ];

        if ($request->hasFile('file_tugas')) {
            $file = $request->file('file_tugas');
            $path = $file->store('tugas', 'public');

            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
        }

        $createdTugas = Tugas::create($data);

        return back()->with('success', 'Tugas berhasil dibuat!');
    }

    public function updateTugas(Request $request, $id)
    {
        $guru = $this->getGuru();
        $tugas = Tugas::findOrFail($id);
        
        // Verifikasi kepemilikan via jadwal
        Jadwal::where('guru_id', $guru->id)->findOrFail($tugas->jadwal_id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_mulai' => 'required|date',
            'deadline' => 'nullable|date|after:waktu_mulai',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:10240',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'waktu_mulai' => $request->waktu_mulai,
            'deadline' => $request->deadline,
        ];

        if ($request->hasFile('file_tugas')) {
            // Hapus file lama jika ada
            if ($tugas->file_path) {
                Storage::disk('public')->delete($tugas->file_path);
            }

            $file = $request->file('file_tugas');
            $path = $file->store('tugas', 'public');

            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
        }

        $tugas->update($data);

        return back()->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroyTugas($id)
    {
        $guru = $this->getGuru();
        $tugas = Tugas::findOrFail($id);
        
        // Verifikasi kepemilikan via jadwal
        Jadwal::where('guru_id', $guru->id)->findOrFail($tugas->jadwal_id);

        if ($tugas->file_path) {
            Storage::disk('public')->delete($tugas->file_path);
        }

        $tugas->delete();

        return back()->with('success', 'Tugas berhasil dihapus!');
    }

    public function daftarPengumpulan($tugas_id)
    {
        $guru = $this->getGuru();
        $tugas = Tugas::with('jadwal.kelas')->findOrFail($tugas_id);

        // Verifikasi kepemilikan
        Jadwal::where('guru_id', $guru->id)->findOrFail($tugas->jadwal_id);

        // Ambil semua siswa di kelas tersebut
        $siswas = Siswa::where('kelas_id', $tugas->jadwal->kelas_id)
            ->with(['pengumpulan' => function($q) use ($tugas_id) {
                $q->where('tugas_id', $tugas_id);
            }])
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        return view('guru.tugas.pengumpulan', compact('tugas', 'siswas'));
    }
    public function updateNilaiMassal(Request $request, $tugas_id)
    {
        $guru = $this->getGuru();
        $tugas = Tugas::with('jadwal')->findOrFail($tugas_id);

        // Verifikasi kepemilikan via jadwal
        Jadwal::where('guru_id', $guru->id)->findOrFail($tugas->jadwal_id);

        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|integer|min:0|max:100',
        ]);

        foreach ($request->nilai as $siswa_id => $nilai) {
            // Kita hanya simpan jika nilai tidak null (agar tidak menimpa nilai yang sudah ada dengan null jika input kosong)
            // Namun karena permintaan "otomatis 0", kita bisa simpan semuanya.
            PengumpulanTugas::updateOrCreate(
                ['tugas_id' => $tugas_id, 'siswa_id' => $siswa_id],
                ['nilai' => $nilai ?? 0]
            );
        }

        return back()->with('success', 'Seluruh nilai berhasil diperbarui!');
    }

    public function updateNilai(Request $request, $tugas_id, $siswa_id)
    {
        $guru = $this->getGuru();
        $tugas = Tugas::with('jadwal')->findOrFail($tugas_id);

        // Verifikasi kepemilikan via jadwal
        Jadwal::where('guru_id', $guru->id)->findOrFail($tugas->jadwal_id);

        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
        ]);

        PengumpulanTugas::updateOrCreate(
            ['tugas_id' => $tugas_id, 'siswa_id' => $siswa_id],
            ['nilai' => $request->nilai]
        );

        // Simpan daftar ID siswa yang baru saja dinilai ke dalam session (array)
        $savedSiswaIds = session('saved_siswa_ids', []);
        if (!in_array($siswa_id, $savedSiswaIds)) {
            $savedSiswaIds[] = $siswa_id;
        }
        session(['saved_siswa_ids' => $savedSiswaIds]);

        return back()->with('success', 'Nilai berhasil diperbarui!');
    }
    public function downloadSuratPanggilan($siswa_id)
    {
        $siswa = Siswa::with('kelas')->findOrFail($siswa_id);
        
        // Menghitung total alpa
        $totalAlpa = Absensi::where('siswa_id', $siswa_id)
            ->where('status', 'alpa')
            ->count();

        if ($totalAlpa < 12) {
            return back()->with('error', 'Siswa belum mencapai batas 12 alpa.');
        }

        $data = [
            'siswa' => $siswa,
            'tanggal' => date('d-m-Y'),
            'totalAlpa' => $totalAlpa
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('guru.presensi.surat_panggilan', $data);
        return $pdf->download('Surat_Panggilan_Ortu_'.$siswa->nama_lengkap.'.pdf');
    }
}
