<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SawController;
use App\Http\Controllers\IzinController;

// ==================================================================
// 🚪 ROUTE OTENTIKASI & LANDING PAGE
// ==================================================================

Route::get('/', function () {
    return view('landpage');
});

// Halaman Form Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Proses Validasi Login (Dilindungi rate limiting anti brute-force)
Route::post('/login', function (Illuminate\Http\Request $request) {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->with('loginError', 'Username atau password yang Anda masukkan salah!');
})->middleware('throttle:5,1');

// Proses Keluar Sistem (Logout)
Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});

// Halaman Utama Dashboard (Dipakai bersama Admin & Guru via logika @if di view)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// ==================================================================
// 🛠️ GROUP ROUTE: ROLE ADMIN (HAK AKSES MASTER & PENGATURAN)
// ==================================================================
Route::middleware(['auth', 'role:admin'])->group(function () {

// Manajemen Profil Admin
Route::get('/admin/profil', [App\Http\Controllers\AuthController::class, 'profil'])->name('admin.profil');
Route::get('/admin/profil/edit', [App\Http\Controllers\AuthController::class, 'editProfil'])->name('admin.profil.edit');
Route::put('/admin/profil/update', [App\Http\Controllers\AuthController::class, 'updateProfil'])->name('admin.profil.update');

// Pengaturan Lokasi Sekolah (Ujian)
Route::get('/admin/settings/lokasi', [AdminController::class, 'settingLokasi'])->name('admin.settings.lokasi');
Route::put('/admin/settings/lokasi', [AdminController::class, 'updateSettingLokasi'])->name('admin.settings.lokasi.update');

// Master Data Jurusan, Kelas, & Mapel
Route::prefix('admin/master')->group(function () {
    // CRUD Jurusan
    Route::get('/jurusan', [AdminController::class, 'indexJurusan'])->name('admin.jurusan');
    Route::get('/jurusan/create', [AdminController::class, 'createJurusan'])->name('admin.jurusan.create');
    Route::post('/jurusan', [AdminController::class, 'storeJurusan'])->name('admin.jurusan.store');
    Route::get('/jurusan/{id}/edit', [AdminController::class, 'editJurusan'])->name('admin.jurusan.edit');
    Route::get('/jurusan/{id}', [AdminController::class, 'showJurusan'])->name('admin.jurusan.show');
    Route::put('/jurusan/{id}', [AdminController::class, 'updateJurusan'])->name('admin.jurusan.update');
    Route::delete('/jurusan/{id}', [AdminController::class, 'destroyJurusan'])->name('admin.jurusan.destroy');

    // CRUD Kelas
    Route::get('/kelas', [AdminController::class, 'indexKelas'])->name('admin.kelas');
    Route::get('/kelas/create', [AdminController::class, 'createKelas'])->name('admin.kelas.create');
    Route::post('/kelas', [AdminController::class, 'storeKelas'])->name('admin.kelas.store');
    Route::get('/kelas/{id}/edit', [AdminController::class, 'editKelas'])->name('admin.kelas.edit');
    Route::get('/kelas/{id}', [AdminController::class, 'showKelas'])->name('admin.kelas.show');
    Route::put('/kelas/{id}', [AdminController::class, 'updateKelas'])->name('admin.kelas.update');
    Route::delete('/kelas/{id}', [AdminController::class, 'destroyKelas'])->name('admin.kelas.destroy');

    // CRUD Mapel
    Route::get('/mapel', [AdminController::class, 'indexMapel'])->name('admin.mapel');
    Route::get('/mapel/create', [AdminController::class, 'createMapel'])->name('admin.mapel.create');
    Route::post('/mapel', [AdminController::class, 'storeMapel'])->name('admin.mapel.store');
    Route::get('/mapel/{id}/edit', [AdminController::class, 'editMapel'])->name('admin.mapel.edit');
    Route::get('/mapel/{id}', [AdminController::class, 'showMapel'])->name('admin.mapel.show');
    Route::put('/mapel/{id}', [AdminController::class, 'updateMapel'])->name('admin.mapel.update');
    Route::delete('/mapel/{id}', [AdminController::class, 'destroyMapel'])->name('admin.mapel.destroy');

    // Halaman Master Data Guru
    Route::get('/guru', [AdminController::class, 'indexMasterGuru'])->name('admin.master.guru');
    Route::get('/guru/create', [AdminController::class, 'createMasterGuru'])->name('admin.master.guru.create');
    Route::get('/guru/download-template', [AdminController::class, 'downloadTemplateGuru'])->name('admin.master.guru.download-template');
    Route::post('/guru/import', [AdminController::class, 'importMasterGuru'])->name('admin.master.guru.import');
    Route::post('/guru', [AdminController::class, 'storeMasterGuru'])->name('admin.master.guru.store');
    Route::get('/guru/{id}/edit', [AdminController::class, 'editMasterGuru'])->name('admin.master.guru.edit');
    Route::get('/guru/{id}', [AdminController::class, 'showMasterGuru'])->name('admin.master.guru.show');
    Route::put('/guru/{id}', [AdminController::class, 'updateMasterGuru'])->name('admin.master.guru.update');
    Route::delete('/guru/{id}', [AdminController::class, 'destroyMasterGuru'])->name('admin.master.guru.destroy');

    // Halaman Master Data Siswa
    // CRUD Siswa
    Route::get('/siswa', [AdminController::class, 'indexMasterSiswa'])->name('admin.master.siswa');
    Route::get('/siswa/create', [AdminController::class, 'createMasterSiswa'])->name('admin.master.siswa.create');
    Route::get('/siswa/download-template', [AdminController::class, 'downloadTemplateSiswa'])->name('admin.master.siswa.download-template');
    Route::post('/siswa/import', [AdminController::class, 'importMasterSiswa'])->name('admin.master.siswa.import');
    Route::post('/siswa', [AdminController::class, 'storeMasterSiswa'])->name('admin.master.siswa.store');
    Route::get('/siswa/{id}/edit', [AdminController::class, 'editMasterSiswa'])->name('admin.master.siswa.edit');
    Route::get('/siswa/{id}', [AdminController::class, 'showMasterSiswa'])->name('admin.master.siswa.show');
    Route::put('/siswa/{id}', [AdminController::class, 'updateMasterSiswa'])->name('admin.master.siswa.update');
    Route::delete('/siswa/{id}', [AdminController::class, 'destroyMasterSiswa'])->name('admin.master.siswa.destroy');

    });
// Master Data Pengguna (Guru & Siswa)
Route::prefix('admin/pengguna')->group(function () {
    // CRUD Guru
    Route::get('/guru/download-template', [AdminController::class, 'downloadTemplateGuruAccount'])->name('admin.guru.download-template');
    Route::post('/guru/import', [AdminController::class, 'importGuruAccount'])->name('admin.guru.import');
    Route::get('/guru', [AdminController::class, 'indexGuru'])->name('admin.guru');
    Route::get('/guru/create', [AdminController::class, 'createGuru'])->name('admin.guru.create');
    Route::post('/guru', [AdminController::class, 'storeGuru'])->name('admin.guru.store');
    Route::get('/guru/{id}/edit', [AdminController::class, 'editGuru'])->name('admin.guru.edit');
    Route::put('/guru/{id}', [AdminController::class, 'updateGuru'])->name('admin.guru.update');
    Route::delete('/guru/{id}', [AdminController::class, 'destroyGuru'])->name('admin.guru.destroy');

    // CRUD Siswa
    Route::get('/siswa/download-template', [AdminController::class, 'downloadTemplateSiswaAccount'])->name('admin.siswa.download-template');
    Route::post('/siswa/import', [AdminController::class, 'importSiswaAccount'])->name('admin.siswa.import');
    Route::get('/siswa', [AdminController::class, 'indexSiswa'])->name('admin.siswa');
    Route::get('/siswa/create', [AdminController::class, 'createSiswa'])->name('admin.siswa.create');
    Route::post('/siswa', [AdminController::class, 'storeSiswa'])->name('admin.siswa.store');
    Route::get('/siswa/{id}/edit', [AdminController::class, 'editSiswa'])->name('admin.siswa.edit');
    Route::put('/siswa/{id}', [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');
    Route::delete('/siswa/{id}', [AdminController::class, 'destroySiswa'])->name('admin.siswa.destroy');
});

// Akademik Jadwal Pelajaran
Route::prefix('admin/akademik')->group(function () {
    Route::get('/jadwal', [AdminController::class, 'indexJadwal'])->name('admin.jadwal');
    Route::get('/jadwal/create', [AdminController::class, 'createJadwal'])->name('admin.jadwal.create');
    Route::post('/jadwal', [AdminController::class, 'storeJadwal'])->name('admin.jadwal.store');
    Route::get('/jadwal/{id}/edit', [AdminController::class, 'editJadwal'])->name('admin.jadwal.edit');
    Route::put('/jadwal/{id}', [AdminController::class, 'updateJadwal'])->name('admin.jadwal.update');
    Route::delete('/jadwal/{id}', [AdminController::class, 'destroyJadwal'])->name('admin.jadwal.destroy');
});

// Pengaturan Konfigurasi Parameter Kriteria SAW
Route::prefix('admin/saw')->group(function () {
    // Kriteria
    Route::get('/kriteria', [AdminController::class, 'indexSaw'])->name('admin.saw');
    Route::post('/kriteria', [AdminController::class, 'storeKriteria'])->name('admin.kriteria.store');
    Route::get('/kriteria/{id}/edit', [AdminController::class, 'editKriteria'])->name('admin.kriteria.edit');
    Route::put('/kriteria/{id}', [AdminController::class, 'updateKriteria'])->name('admin.kriteria.update');
    Route::delete('/kriteria/{id}', [AdminController::class, 'destroyKriteria'])->name('admin.kriteria.destroy');

    // Sub-Kriteria
    Route::get('/sub_kriteria', [AdminController::class, 'indexSubKriteria'])->name('admin.subkriteria');
    Route::get('/sub_kriteria/create', [AdminController::class, 'createSubKriteria'])->name('admin.subkriteria.create');
    Route::post('/sub_kriteria', [AdminController::class, 'storeSubKriteria'])->name('admin.subkriteria.store');
    Route::get('/sub_kriteria/{id}/edit', [AdminController::class, 'editSubKriteria'])->name('admin.subkriteria.edit');
    Route::put('/sub_kriteria/{id}', [AdminController::class, 'updateSubKriteria'])->name('admin.subkriteria.update');
    Route::delete('/sub_kriteria/{id}', [AdminController::class, 'destroySubKriteria'])->name('admin.subkriteria.destroy');
});

// Modul Laporan & Monitoring Sisi Admin/Operator
Route::prefix('admin/laporan')->group(function () {
    Route::get('/absensi', [AdminController::class, 'indexLaporanAbsensi'])->name('admin.laporan.absensi');
    Route::get('/absensi/export', [AdminController::class, 'exportLaporanAbsensi'])->name('admin.laporan.absensi.export');

    Route::get('/absensi/pdf', [AdminController::class, 'exportPdfAbsensi'])->name('admin.laporan.absensi.pdf');
});

Route::prefix('admin/manajemen')->group(function () {
    Route::get('/izin', [IzinController::class, 'index'])->name('admin.izin.index');
    Route::post('/izin/{id}/verifikasi', [IzinController::class, 'verifikasi'])->name('admin.izin.verifikasi');
});
});

/// Rute Download Materi (Hanya dapat diakses user yang sudah login)
Route::get('/download-materi/{id}', [App\Http\Controllers\DashboardController::class, 'downloadMateri'])
    ->middleware('auth')
    ->name('materi.download');

// ==================================================================
// 👨‍🏫 GROUP ROUTE ROLE GURU
// ==================================================================
Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {

    // RPP AI Routes (Dilindungi rate limiting kuota API)
    Route::post('/rpp/generate-ai', [App\Http\Controllers\RppController::class, 'generateAi'])
        ->middleware('throttle:10,1')
        ->name('guru.rpp.generate-ai');
    Route::resource('rpp', App\Http\Controllers\RppController::class, ['as' => 'guru']);

    // E-Modul Routes
    Route::resource('modul', App\Http\Controllers\ModulController::class, ['as' => 'guru']);

    // Dashboard (TETAP SEPERTI SEMULA - JANGAN DIUBAH)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('guru.dashboard');

    // 1. Modul Input Presensi Harian
    Route::get('/input-absen', [GuruController::class, 'indexJadwal'])->name('guru.jadwal');
    Route::get('/input-absen/kelas/{id}', [GuruController::class, 'lembarAbsen'])->name('guru.absen.kelas');
    Route::post('/input-absen/simpan/{jadwal_id}', [GuruController::class, 'simpanAbsen'])->name('guru.absen.simpan');
    Route::get('/input-absen/surat/{siswa_id}', [GuruController::class, 'downloadSuratPanggilan'])->name('guru.absen.surat');

    // 2. Modul Rekapitulasi
    Route::get('/rekap-kehadiran', [GuruController::class, 'rekapBulanan'])->name('guru.rekap');
    Route::get('/rekap-kehadiran/export', [GuruController::class, 'exportRekap'])->name('guru.rekap.export');
    Route::get('/rekap-kehadiran/pdf', [GuruController::class, 'exportPdf'])->name('guru.rekap.pdf');

    // 2.1 Ruang Materi & Tugas (Placeholder)
    Route::get('/ruang-materi/{jadwal_id}', [GuruController::class, 'ruangMateri'])->name('guru.materi');
    Route::post('/ruang-materi/{jadwal_id}', [GuruController::class, 'storeMateri'])->name('guru.materi.store');
    Route::put('/ruang-materi/{id}', [GuruController::class, 'updateMateri'])->name('guru.materi.update');
    Route::delete('/ruang-materi/{id}', [GuruController::class, 'destroyMateri'])->name('guru.materi.destroy');
    
    Route::get('/ruang-tugas/{jadwal_id}', [GuruController::class, 'ruangTugas'])->name('guru.tugas');
    Route::post('/ruang-tugas/{jadwal_id}', [GuruController::class, 'storeTugas'])->name('guru.tugas.store');
    Route::put('/ruang-tugas/{id}', [GuruController::class, 'updateTugas'])->name('guru.tugas.update');
    Route::delete('/ruang-tugas/{id}', [GuruController::class, 'destroyTugas'])->name('guru.tugas.destroy');
    Route::get('/ruang-tugas/pengumpulan/{tugas_id}', [GuruController::class, 'daftarPengumpulan'])->name('guru.tugas.pengumpulan');
    Route::post('/ruang-tugas/nilai-massal/{tugas_id}', [GuruController::class, 'updateNilaiMassal'])->name('guru.tugas.nilai_massal');
    Route::post('/ruang-tugas/nilai/{tugas_id}/{siswa_id}', [GuruController::class, 'updateNilai'])->name('guru.tugas.nilai');

    // 3. Modul SAW (Diarahkan ke SawController)
    Route::get('/analisis-siswa', [SawController::class, 'index'])->name('guru.saw.index');
    Route::post('/analisis-siswa/hitung', [SawController::class, 'hitungSaw'])->name('guru.saw.hitung');
    Route::post('/presensi/saw/rilis', [SawController::class, 'rilisJuara'])->name('guru.saw.rilis');
    
    // 6. Modul Persetujuan Izin (Diarahkan ke IzinController)
    Route::get('/pengajuan-masuk', [IzinController::class, 'index'])->name('guru.izin.index');
    Route::post('/pengajuan/validasi/{id}', [IzinController::class, 'verifikasi'])->name('guru.izin.verifikasi');

    // 7. Modul Ujian Online
    Route::prefix('ujian')->group(function () {
        Route::get('/', [\App\Http\Controllers\UjianController::class, 'index'])->name('guru.ujian.index');
        Route::get('/create', [\App\Http\Controllers\UjianController::class, 'create'])->name('guru.ujian.create');
        Route::post('/store', [\App\Http\Controllers\UjianController::class, 'store'])->name('guru.ujian.store');
        Route::get('/{id}/edit', [\App\Http\Controllers\UjianController::class, 'edit'])->name('guru.ujian.edit');
        Route::put('/{id}/update', [\App\Http\Controllers\UjianController::class, 'update'])->name('guru.ujian.update');
        Route::delete('/{id}/destroy', [\App\Http\Controllers\UjianController::class, 'destroy'])->name('guru.ujian.destroy');
        
        Route::get('/{id}/soal', [\App\Http\Controllers\UjianController::class, 'soal'])->name('guru.ujian.soal');
        Route::post('/{id}/soal/store', [\App\Http\Controllers\UjianController::class, 'storeSoal'])->name('guru.ujian.soal.store');
        Route::delete('/soal/{id}/destroy', [\App\Http\Controllers\UjianController::class, 'destroySoal'])->name('guru.ujian.soal.destroy');
        
        Route::get('/{id}/rekap', [\App\Http\Controllers\UjianController::class, 'rekap'])->name('guru.ujian.rekap');
    });
});

// ==================================================================
// 🎓 GROUP ROUTE ROLE SISWA
// ==================================================================
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/modul', [\App\Http\Controllers\SiswaModulController::class, 'index'])->name('siswa.modul.index');
    Route::get('/dashboard', [\App\Http\Controllers\SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/jadwal', [\App\Http\Controllers\SiswaController::class, 'jadwal'])->name('siswa.jadwal');
    Route::get('/riwayat', [\App\Http\Controllers\SiswaController::class, 'riwayat'])->name('siswa.riwayat');
    
    // Modul Presensi Mandiri
    Route::post('/presensi', [\App\Http\Controllers\SiswaController::class, 'submitPresensi'])->name('siswa.presensi.submit');
    
    // Modul Pengajuan Izin
    Route::get('/izin', [\App\Http\Controllers\SiswaController::class, 'izin'])->name('siswa.izin');
    Route::post('/izin', [\App\Http\Controllers\SiswaController::class, 'simpanIzin'])->name('siswa.izin.simpan');
    
    // Modul Profil
    Route::get('/profil', [\App\Http\Controllers\SiswaController::class, 'profil'])->name('siswa.profil');
    Route::post('/profil', [\App\Http\Controllers\SiswaController::class, 'updateProfil'])->name('siswa.profil.update');

    // Ruang Materi & Tugas
    Route::get('/materi/{jadwal_id}', [\App\Http\Controllers\SiswaController::class, 'ruangMateri'])->name('siswa.materi');
    Route::get('/tugas/{jadwal_id}', [\App\Http\Controllers\SiswaController::class, 'ruangTugas'])->name('siswa.tugas');
    Route::get('/tugas/form/{tugas_id}', [\App\Http\Controllers\SiswaController::class, 'formTugas'])->name('siswa.tugas.form');
    Route::post('/tugas/submit/{tugas_id}', [\App\Http\Controllers\SiswaController::class, 'submitTugas'])->name('siswa.tugas.submit');

    // Modul Ujian Online
    Route::prefix('ujian')->group(function () {
        Route::get('/', [\App\Http\Controllers\SiswaUjianController::class, 'index'])->name('siswa.ujian.index');
        Route::get('/{id}/kerjakan', [\App\Http\Controllers\SiswaUjianController::class, 'kerjakan'])->name('siswa.ujian.kerjakan');
        Route::post('/{id}/submit', [\App\Http\Controllers\SiswaUjianController::class, 'submit'])->name('siswa.ujian.submit');
        Route::get('/{id}/download', [\App\Http\Controllers\SiswaUjianController::class, 'download'])->name('siswa.ujian.download');
    });

});

// Route penampil berkas storage (Wajib login & dilindungi dari Path Traversal)
Route::middleware('auth')->get('/storage/{path}', function ($path) {
    if (str_contains($path, '..') || str_contains($path, "\0")) {
        abort(403, 'Akses ditolak.');
    }

    $storageBase = realpath(storage_path('app/public'));
    $publicBase  = realpath(public_path('storage'));

    $resolvedPath = null;
    if ($storageBase) {
        $candidate = realpath($storageBase . DIRECTORY_SEPARATOR . $path);
        if ($candidate && is_file($candidate) && str_starts_with($candidate, $storageBase . DIRECTORY_SEPARATOR)) {
            $resolvedPath = $candidate;
        }
    }

    if (!$resolvedPath && $publicBase) {
        $candidate = realpath($publicBase . DIRECTORY_SEPARATOR . $path);
        if ($candidate && is_file($candidate) && str_starts_with($candidate, $publicBase . DIRECTORY_SEPARATOR)) {
            $resolvedPath = $candidate;
        }
    }

    if (!$resolvedPath) {
        abort(404, 'Berkas tidak ditemukan.');
    }

    $mimeType = mime_content_type($resolvedPath) ?: 'application/octet-stream';
    if (str_ends_with(strtolower($resolvedPath), '.pdf')) {
        $mimeType = 'application/pdf';
    }

    return response()->file($resolvedPath, [
        'Content-Type' => $mimeType,
        'Content-Disposition' => 'inline; filename="' . basename($resolvedPath) . '"'
    ]);
})->where('path', '.*')->name('storage.file');



