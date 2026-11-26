<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\KriteriaSaw;
use App\Models\SubKriteriaSaw;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // ================= 🏢 1. JURUSAN =================
    public function indexJurusan() {
        $jurusan = Jurusan::all();
        return view('admin.master.jurusan.index', compact('jurusan'));
    }

    public function createJurusan() {
        return view('admin.master.jurusan.create');
    }

    public function storeJurusan(Request $request) {
        $request->validate([
            'kode_jurusan' => 'required|unique:jurusan,kode_jurusan',
            'nama_jurusan' => 'required'
        ]);

        Jurusan::create($request->only(['kode_jurusan', 'nama_jurusan']));
        return redirect('/admin/master/jurusan')->with('success', 'Jurusan berhasil ditambah');
    }

    public function showJurusan($id) {
        $jurusan = Jurusan::findOrFail($id);
        return view('admin.master.jurusan.detail', compact('jurusan'));
    }

    public function editJurusan($id) {
        $jurusan = Jurusan::findOrFail($id);
        return view('admin.master.jurusan.edit', compact('jurusan'));
    }

    public function updateJurusan(Request $request, $id) {
        $jurusan = Jurusan::findOrFail($id);
        $request->validate([
            'kode_jurusan' => 'required|unique:jurusan,kode_jurusan,' . $id,
            'nama_jurusan' => 'required'
        ]);

        $jurusan->update($request->only(['kode_jurusan', 'nama_jurusan']));
        return redirect('/admin/master/jurusan')->with('success', 'Jurusan berhasil diperbarui');
    }

    public function destroyJurusan($id) {
        Jurusan::destroy($id);
        return redirect('/admin/master/jurusan')->with('success', 'Jurusan berhasil dihapus');
    }


    // ================= 🏫 2. KELAS =================
    public function indexKelas() {
        $kelas = Kelas::with('jurusan')->get();
        return view('admin.master.kelas.index', compact('kelas'));
    }

    public function createKelas() {
        $jurusan = Jurusan::all();
        $guru = Guru::all();
        return view('admin.master.kelas.create', compact('jurusan', 'guru'));
    }

    public function storeKelas(Request $request) {
        $request->validate([
            'jurusan_id'     => 'required|exists:jurusan,id',
            'tingkat'        => 'required',
            'nama_kelas'     => 'required',
            'wali_kelas_id'  => 'nullable|exists:guru,id'
        ]);

        Kelas::create($request->only(['jurusan_id', 'tingkat', 'nama_kelas', 'wali_kelas_id']));
        return redirect('/admin/master/kelas')->with('success', 'Kelas berhasil ditambah');
    }

    public function showKelas($id) {
        $kelas = Kelas::with(['jurusan', 'waliKelas'])->findOrFail($id);
        return view('admin.master.kelas.detail', compact('kelas'));
    }

    public function editKelas($id) {
        $kelas = Kelas::findOrFail($id);
        $jurusan = Jurusan::all();
        $guru = Guru::all();
        return view('admin.master.kelas.edit', compact('kelas', 'jurusan', 'guru'));
    }

    public function updateKelas(Request $request, $id) {
        $kelas = Kelas::findOrFail($id);
        $request->validate([
            'jurusan_id'     => 'required|exists:jurusan,id',
            'tingkat'        => 'required',
            'nama_kelas'     => 'required',
            'wali_kelas_id'  => 'nullable|exists:guru,id'
        ]);

        $kelas->update($request->only(['jurusan_id', 'tingkat', 'nama_kelas', 'wali_kelas_id']));
        return redirect('/admin/master/kelas')->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroyKelas($id) {
        Kelas::destroy($id);
        return redirect('/admin/master/kelas')->with('success', 'Kelas berhasil dihapus');
    }


    // ================= 📖 3. MATA PELAJARAN =================
    public function indexMapel() {
        $mapel = MataPelajaran::all();
        return view('admin.master.mapel.index', compact('mapel'));
    }

    public function createMapel() {
        return view('admin.master.mapel.create');
    }

    public function indexMasterGuru() {
        $guru = Guru::all();
        return view('admin.master.guru.index', compact('guru'));
    }

    public function createMasterGuru() {
        return view('admin.master.guru.create');
    }

    public function storeMasterGuru(Request $request) {
        $request->validate([
            'kode_guru'    => 'required|unique:guru,kode_guru',
            'nama_lengkap' => 'required',
            'jk'           => 'nullable|in:L,P',
            'tanggal_lahir'=> 'nullable|date',
            'no_hp'        => 'required',
            'alamat'       => 'nullable',
            'jabatan'      => 'nullable|string|max:255'
        ]);

        Guru::create($request->only(['kode_guru', 'nama_lengkap', 'jk', 'tanggal_lahir', 'no_hp', 'alamat', 'jabatan']));
        return redirect('/admin/master/guru')->with('success', 'Guru berhasil ditambahkan');
    }

    public function showMasterGuru($id) {
        $guru = Guru::findOrFail($id);
        return view('admin.master.guru.detail', compact('guru'));
    }

    public function editMasterGuru($id) {
        $guru = Guru::findOrFail($id);
        return view('admin.master.guru.edit', compact('guru'));
    }

    public function updateMasterGuru(Request $request, $id) {
        $guru = Guru::findOrFail($id);
        $request->validate([
            'kode_guru'    => 'required|unique:guru,kode_guru,' . $id,
            'nama_lengkap' => 'required',
            'jk'           => 'nullable|in:L,P',
            'tanggal_lahir'=> 'nullable|date',
            'no_hp'        => 'required',
            'alamat'       => 'nullable',
            'jabatan'      => 'nullable|string|max:255'
        ]);

        $guru->update($request->only(['kode_guru', 'nama_lengkap', 'jk', 'tanggal_lahir', 'no_hp', 'alamat', 'jabatan']));
        return redirect('/admin/master/guru')->with('success', 'Data guru berhasil diperbarui');
    }

    public function destroyMasterGuru($id) {
        Guru::destroy($id);
        return redirect('/admin/master/guru')->with('success', 'Guru berhasil dihapus');
    }

    /**
     * BAGIAN YANG DIPERBAIKI (Master Data Siswa Admin)
     * Mengirim variabel $kelas_list dan menambahkan fitur filter
     */
    public function indexMasterSiswa(Request $request) {
        // 1. Mengambil data kelas untuk dropdown di file Blade index master siswa
        $kelas_list = Kelas::orderBy('nama_kelas', 'asc')->get();

        // 2. Mengambil data siswa lengkap dengan filter kelas_id (jika dipilih oleh admin)
        $siswa = Siswa::with('kelas.jurusan')
            ->when($request->kelas_id, function($query, $kelas_id) {
                return $query->where('kelas_id', $kelas_id);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Memastikan pagination halaman 2,3 dst tetap mempertahankan filter kelas

        // 3. Melempar data siswa dan kelas_list ke view index master siswa
        return view('admin.master.siswa.index', compact('siswa', 'kelas_list'));
    }

    public function createMasterSiswa() {
        $kelas = Kelas::with('jurusan')->get();
        return view('admin.master.siswa.create', compact('kelas'));
    }

    public function storeMasterSiswa(Request $request) {
        $request->validate([
            'kelas_id'         => 'required|exists:kelas,id',
            'nisn'             => 'required|unique:siswa,nisn',
            'nama_siswa'       => 'required',
            'jenis_kelamin'    => 'required|in:L,P',
            'tanggal_lahir'    => 'required|date|after:1990-01-01|before:today',
            'nama_orang_tua'   => 'nullable',
        ]);

        $data = $request->only(['kelas_id', 'nisn', 'nama_siswa', 'jenis_kelamin', 'tanggal_lahir', 'nama_orang_tua']);
        // Mapping untuk kompatibilitas database lama
        $data['nama_lengkap'] = $request->nama_siswa;
        $data['jk'] = $request->jenis_kelamin;

        Siswa::create($data);
        return redirect('/admin/master/siswa')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function showMasterSiswa($id) {
        $siswa = Siswa::with('kelas.jurusan')->findOrFail($id);
        return view('admin.master.siswa.detail', compact('siswa'));
    }

    public function editMasterSiswa($id) {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::with('jurusan')->get();
        return view('admin.master.siswa.edit', compact('siswa', 'kelas'));
    }

    public function updateMasterSiswa(Request $request, $id) {
        $siswa = Siswa::findOrFail($id);
        $request->validate([
            'kelas_id'         => 'required|exists:kelas,id',
            'nisn'             => 'required|unique:siswa,nisn,' . $id,
            'nama_siswa'       => 'required',
            'jenis_kelamin'    => 'required|in:L,P',
            'tanggal_lahir'    => 'required|date|after:1990-01-01|before:today',
            'nama_orang_tua'   => 'nullable',
        ]);

        $data = $request->only(['kelas_id', 'nisn', 'nama_siswa', 'jenis_kelamin', 'tanggal_lahir', 'nama_orang_tua']);
        // Mapping untuk kompatibilitas database lama
        $data['nama_lengkap'] = $request->nama_siswa;
        $data['jk'] = $request->jenis_kelamin;

        $siswa->update($data);
        return redirect('/admin/master/siswa')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroyMasterSiswa($id) {
        Siswa::destroy($id);
        return redirect('/admin/master/siswa')->with('success', 'Siswa berhasil dihapus');
    }

    public function storeMapel(Request $request) {
        $request->validate([
            'kode_mapel' => 'required|unique:mata_pelajaran,kode_mapel',
            'nama_mapel' => 'required'
        ]);

        MataPelajaran::create($request->only(['kode_mapel', 'nama_mapel']));
        return redirect('/admin/master/mapel')->with('success', 'Mata Pelajaran berhasil ditambah');
    }

    public function editMapel($id) {
        $mapel = MataPelajaran::findOrFail($id);
        return view('admin.master.mapel.edit', compact('mapel'));
    }

    public function showMapel($id) {
        $mapel = MataPelajaran::findOrFail($id);
        return view('admin.master.mapel.detail', compact('mapel'));
    }

    public function updateMapel(Request $request, $id) {
        $mapel = MataPelajaran::findOrFail($id);

        $request->validate([
            'kode_mapel' => 'required|unique:mata_pelajaran,kode_mapel,' . $id,
            'nama_mapel' => 'required'
        ]);

        $mapel->update($request->only(['kode_mapel', 'nama_mapel']));
        return redirect('/admin/master/mapel')->with('success', 'Mata Pelajaran berhasil diperbarui');
    }

    public function destroyMapel($id) {
        MataPelajaran::destroy($id);
        return redirect('/admin/master/mapel')->with('success', 'Mata Pelajaran berhasil dihapus');
    }


    // ================= 👨‍🏫 4. GURU =================
    public function indexGuru() {
        $guru = Guru::has('user')->with('user')->get();
        return view('admin.pengguna.guru.index', compact('guru'));
    }

    public function createGuru() {
        $guru = Guru::doesntHave('user')->get();
        return view('admin.pengguna.guru.create', compact('guru'));
    }

    public function storeGuru(Request $request) {
        $request->validate([
            'guru_id'      => 'required|exists:guru,id',
            'email'        => 'required|email|unique:users,email|unique:users,username',
            'password'     => 'required|min:6'
        ]);

        $guru = Guru::with('user')->findOrFail($request->guru_id);

        if ($guru->user) {
            return redirect()->back()->withErrors(['guru_id' => 'Akun untuk guru ini sudah dibuat.'])->withInput();
        }

        $user = User::create([
            'nama'     => $guru->nama_lengkap,
            'username' => $request->email,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'guru',
            'guru_id'  => $guru->id
        ]);

        return redirect('/admin/pengguna/guru')->with('success', 'Akun guru berhasil ditambahkan dari data master.');
    }

    public function editGuru($id) {
        $guru = Guru::with('user')->findOrFail($id);
        return view('admin.pengguna.guru.edit', compact('guru'));
    }

    public function updateGuru(Request $request, $id) {
        $guru = Guru::findOrFail($id);

        $userId = $guru->user?->id ?? 0;

        $request->validate([
            'email'        => 'required|email|unique:users,email,' . $userId . '|unique:users,username,' . $userId,
            'password'     => 'nullable|min:6'
        ]);

        if ($guru->user) {
            $userData = [
                'nama'     => $guru->nama_lengkap,
                'username' => $request->email,
                'email'    => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->password);
            }

            $guru->user->update($userData);
        }

        return redirect('/admin/pengguna/guru')->with('success', 'Data Guru dan Kredensial Login berhasil diperbarui');
    }

    public function destroyGuru($id) {
        $guru = Guru::findOrFail($id);

        if ($guru->user) {
            User::destroy($guru->user->id);
        }

        return redirect('/admin/pengguna/guru')->with('success', 'Akun login Guru berhasil dihapus');
    }


    // ================= 🧑‍🎓 5. SISWA =================
    public function indexSiswa(Request $request) {
        $kelas_list = Kelas::orderBy('nama_kelas', 'asc')->get();

        $siswa = Siswa::has('user')
            ->with(['user', 'kelas.jurusan'])
            ->when($request->kelas_id, function($query, $kelas_id) {
                return $query->where('kelas_id', $kelas_id);
            })
            ->get();

        return view('admin.pengguna.siswa.index', compact('siswa', 'kelas_list'));
    }

    public function createSiswa() {
        $siswa = Siswa::doesntHave('user')->with('kelas.jurusan')->get();
        return view('admin.pengguna.siswa.create', compact('siswa'));
    }

    public function storeSiswa(Request $request) {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'password' => 'required|min:6'
        ]);

        $siswa = Siswa::with('user')->findOrFail($request->siswa_id);

        if ($siswa->user) {
            return redirect()->back()->withErrors(['siswa_id' => 'Akun untuk siswa ini sudah dibuat.'])->withInput();
        }

        $user = User::create([
            'nama'     => $siswa->nama_lengkap,
            'username' => $siswa->nisn,
            'email'    => $siswa->nisn . '@sekolah.sch.id',
            'password' => bcrypt($request->password),
            'role'     => 'siswa',
            'siswa_id' => $siswa->id
        ]);

        return redirect('/admin/pengguna/siswa')->with('success', 'Akun siswa berhasil ditambahkan dari data master.');
    }

    public function editSiswa($id) {
        $siswa = Siswa::with('user')->findOrFail($id);
        $kelas = Kelas::with('jurusan')->get();
        return view('admin.pengguna.siswa.edit', compact('siswa', 'kelas'));
    }

    public function updateSiswa(Request $request, $id) {
        $siswa = Siswa::findOrFail($id);

        $userId = $siswa->user?->id ?? 0;

        $request->validate([
            'nisn'         => 'required|unique:siswa,nisn,' . $id . '|unique:users,username,' . $userId,
            'nama_lengkap' => 'required',
            'kelas_id'     => 'required|exists:kelas,id',
            'password'     => 'nullable|min:6'
        ]);

        $siswa->update([
            'kelas_id'     => $request->kelas_id,
            'nisn'         => $request->nisn,
            'nama_lengkap' => $request->nama_lengkap
        ]);

        if ($siswa->user) {
            $userData = [
                'nama'     => $request->nama_lengkap,
                'username' => $request->nisn,
                'email'    => $request->nisn . '@sekolah.sch.id',
            ];

            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->password);
            }

            $siswa->user->update($userData);
        }

        return redirect('/admin/pengguna/siswa')->with('success', 'Data Siswa dan Kredensial Login berhasil diperbarui');
    }

       public function destroySiswa($id) {
        $siswa = Siswa::findOrFail($id);

        if ($siswa->user) {
            User::destroy($siswa->user->id);
        }

        return redirect('/admin/pengguna/siswa')->with('success', 'Akun login Siswa berhasil dihapus');
    }



    // ================= 📅 6. JADWAL PELAJARAN (SINKRONISASI MASTER ID) =================
    public function indexJadwal(Request $request) {
        $kelas_list = Kelas::orderBy('nama_kelas', 'asc')->get();
        $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        $jadwal = Jadwal::with(['kelas', 'mataPelajaran', 'guru'])
            ->when($request->kelas_id, function($query, $kelas_id) {
                return $query->where('kelas_id', $kelas_id);
            })
            ->when($request->hari, function($query, $hari) {
                return $query->where('hari', $hari);
            })
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('kelas_id')
            ->orderBy('jam_mulai')
            ->get();

        return view('admin.akademik.jadwal.index', compact('jadwal', 'kelas_list', 'hari_list'));
    }

    public function createJadwal() {
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();
        $guru = Guru::all();
        return view('admin.akademik.jadwal.create', compact('kelas', 'mapel', 'guru'));
    }

    public function storeJadwal(Request $request) {
        $request->validate([
            'kelas_id'    => 'required|exists:kelas,id',
            'mapel_id'    => 'required|exists:mata_pelajaran,id',
            'guru_id'     => 'required|exists:guru,id',
            'hari'        => 'required',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i'
        ]);

        Jadwal::create($request->only(['kelas_id', 'mapel_id', 'guru_id', 'hari', 'jam_mulai', 'jam_selesai']));
        return redirect('/admin/akademik/jadwal')->with('success', 'Jadwal Pelajaran berhasil ditambahkan');
    }

    public function editJadwal($id) {
        $jadwal = Jadwal::findOrFail($id);
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();
        $guru = Guru::all();
        return view('admin.akademik.jadwal.edit', compact('jadwal', 'kelas', 'mapel', 'guru'));
    }

    public function updateJadwal(Request $request, $id) {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'kelas_id'    => 'required|exists:kelas,id',
            'mapel_id'    => 'required|exists:mata_pelajaran,id',
            'guru_id'     => 'required|exists:guru,id',
            'hari'        => 'required',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i'
        ]);

        $jadwal->update($request->only(['kelas_id', 'mapel_id', 'guru_id', 'hari', 'jam_mulai', 'jam_selesai']));
        return redirect('/admin/akademik/jadwal')->with('success', 'Jadwal Pelajaran berhasil diperbarui');
    }

    public function destroyJadwal($id) {
        Jadwal::destroy($id);
        return redirect('/admin/akademik/jadwal')->with('success', 'Jadwal Pelajaran berhasil dihapus');
    }


    // ================= 📊 7. KRITERIA & SUB-KRITERIA SAW =================

    // --- A. CRUD KRITERIA ---
    public function indexSaw() {
        $kriteria = KriteriaSaw::all();
        return view('admin.saw.kriteria.index', compact('kriteria'));
    }

    

    public function storeKriteria(Request $request) {
        $request->validate([
            'kode'          => 'required|unique:kriteria_saw,kode',
            'nama_kriteria' => 'required',
            'tipe'          => 'required|in:benefit,cost',
            'bobot'         => 'required|numeric'
        ]);

        KriteriaSaw::create($request->only(['kode', 'nama_kriteria', 'tipe', 'bobot']));
        return redirect('/admin/saw/kriteria')->with('success', 'Kriteria SAW berhasil ditambahkan');
    }

    public function editKriteria($id) {
        $kcriteria = KriteriaSaw::findOrFail($id);
        return view('admin.saw.kriteria.edit', compact('kcriteria'));
    }

    public function updateKriteria(Request $request, $id) {
        $kcriteria = KriteriaSaw::findOrFail($id);

        $request->validate([
            'nama_kriteria' => 'required',
            'tipe'          => 'required|in:benefit,cost',
            'bobot'         => 'required|numeric'
        ]);

        $kcriteria->update([
            'nama_kriteria' => $request->nama_kriteria,
            'tipe'          => $request->tipe,
            'bobot'         => $request->bobot,
        ]);

        return redirect('/admin/saw/kriteria')->with('success', 'Data kriteria berhasil diperbarui!');
    }

    public function destroyKriteria($id) {
        KriteriaSaw::destroy($id);
        return redirect('/admin/saw/kriteria')->with('success', 'Kriteria berhasil dihapus');
    }


    // --- B. CRUD SUB-KRITERIA ---
    public function indexSubKriteria() {
        $subKriteria = SubKriteriaSaw::with('kriteriaSaw')->get();
        return view('admin.saw.sub_kriteria.index', compact('subKriteria'));
    }

    public function createSubKriteria() {
        $kriteria = KriteriaSaw::all();
        return view('admin.saw.sub_kriteria.create', compact('kriteria'));
    }

    public function storeSubKriteria(Request $request) {
        $request->validate([
            'kriteria_saw_id' => 'required|exists:kriteria_saw,id',
            'keterangan'      => 'required',
            'nilai'           => 'required|numeric'
        ]);

        SubKriteriaSaw::create($request->only(['kriteria_saw_id', 'keterangan', 'nilai']));
        return redirect('/admin/saw/sub_kriteria')->with('success', 'Sub-Kriteria berhasil ditambahkan');
    }

    public function editSubKriteria($id) {
        $subKriteria = SubKriteriaSaw::findOrFail($id);
        $kriteria = KriteriaSaw::all();
        return view('admin.saw.sub_kriteria.edit', compact('subKriteria', 'kriteria'));
    }

    public function updateSubKriteria(Request $request, $id) {
        $subKriteria = SubKriteriaSaw::findOrFail($id);

        $request->validate([
            'kriteria_saw_id' => 'required|exists:kriteria_saw,id',
            'keterangan'      => 'required',
            'nilai'           => 'required|numeric'
        ]);

        $subKriteria->update($request->only(['kriteria_saw_id', 'keterangan', 'nilai']));
        return redirect('/admin/saw/sub_kriteria')->with('success', 'Data Sub-Kriteria berhasil diperbarui!');
    }

    public function destroySubKriteria($id) {
        SubKriteriaSaw::destroy($id);
        return redirect('/admin/saw/sub_kriteria')->with('success', 'Sub-Kriteria berhasil dihapus');
    }


    // ================= 📈 8. LAPORAN & REKAPITULASI =================
    public function indexLaporanAbsensi(Request $request)
    {
        $absensi = $this->getAbsensiQuery($request)->get();
        $daftarKelas = Kelas::all();

        return view('admin.laporan.absensi.index', compact('absensi', 'daftarKelas'));
    }

    public function exportLaporanAbsensi(Request $request)
    {
        $absensi = $this->getAbsensiQuery($request)->get();
        $filename = "Laporan_Absensi_" . date('d-m-Y') . ".xls";

        return response()->view('admin.laporan.absensi.export', [
            'absensi' => $absensi
        ])
        ->header('Content-Type', 'application/vnd.ms-excel')
        ->header('Content-Disposition', "attachment; filename=\"$filename\"");  
    }
    // --- TAMBAHAN: EKSPOR PDF (Hanya tambahkan ini) ---
    public function exportPdfAbsensi(Request $request)
    {
        $absensi = $this->getAbsensiQuery($request)->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.absensi.pdf', compact('absensi'));
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('Laporan_Absensi_' . ($request->tanggal ?? date('Y-m-d')) . '.pdf');
    }

    // Helper (pastikan diletakkan di paling bawah class)
    private function getAbsensiQuery(Request $request)
    {
        $query = Absensi::with(['siswa.kelas', 'jadwal.mataPelajaran']);
        
        if ($request->filled('kelas')) {
            $query->whereHas('siswa.kelas', function($q) use ($request) {
                $q->where('nama_kelas', $request->kelas);
            });
        }
        
        $filterType = $request->get('filter_type', 'mingguan');

        if ($filterType == 'mingguan') {
            $minggu = $request->get('minggu', date('Y').'-W'.date('W'));
            $date = \Carbon\Carbon::parse($minggu);
            $query->whereBetween('tanggal', [
                $date->startOfWeek()->format('Y-m-d'),
                $date->endOfWeek()->format('Y-m-d')
            ]);
        } elseif ($filterType == 'bulanan' && $request->filled('bulan')) {
            $date = \Carbon\Carbon::parse($request->bulan . '-01');
            $query->whereMonth('tanggal', $date->month)
                  ->whereYear('tanggal', $date->year);
        } elseif ($filterType == 'semester' && $request->filled('tahun_semester') && $request->filled('semester_pilihan')) {
            $tahun = $request->tahun_semester;
            $semester = $request->semester_pilihan;
            
            if ($semester == 'ganjil') {
                $query->whereBetween('tanggal', ["$tahun-07-01", "$tahun-12-31"]);
            } else {
                $query->whereBetween('tanggal', ["$tahun-01-01", "$tahun-06-30"]);
            }
        } else {
            // Fallback default jika tipe tidak dikenal
            $date = \Carbon\Carbon::now();
            $query->whereBetween('tanggal', [
                $date->startOfWeek()->format('Y-m-d'),
                $date->endOfWeek()->format('Y-m-d')
            ]);
        }
        
        return $query->latest();
    }

    // ================= 🌐 PENGATURAN LOKASI SEKOLAH =================
    public function settingLokasi() {
        $latitude = \App\Models\Setting::get('school_latitude', '-6.175392');
        $longitude = \App\Models\Setting::get('school_longitude', '106.827153');
        $radius = \App\Models\Setting::get('school_radius', '100');

        return view('admin.settings.lokasi', compact('latitude', 'longitude', 'radius'));
    }

    public function updateSettingLokasi(Request $request) {
        $request->validate([
            'school_latitude' => 'required|numeric',
            'school_longitude' => 'required|numeric',
            'school_radius' => 'required|integer|min:1',
        ]);

        \App\Models\Setting::set('school_latitude', $request->school_latitude);
        \App\Models\Setting::set('school_longitude', $request->school_longitude);
        \App\Models\Setting::set('school_radius', $request->school_radius);

        return redirect()->route('admin.settings.lokasi')->with('success', 'Konfigurasi lokasi sekolah berhasil diperbarui.');
    }

    // ================= 📤 IMPORT EXCEL SISWA =================
    public function downloadTemplateSiswa() {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header columns
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nisn');
        $sheet->setCellValue('C1', 'Nama Siswa');
        $sheet->setCellValue('D1', 'Jenis Kelamin');
        $sheet->setCellValue('E1', 'Kelas');
        $sheet->setCellValue('F1', 'Tanggal Lahir');
        $sheet->setCellValue('G1', 'Nama Orang Tua');

        // Add a sample row
        // Add sample rows matching user format
        $sheet->setCellValue('A2', 1);
        $sheet->setCellValue('B2', '0086920305');
        $sheet->setCellValue('C2', 'CHERYL AZZAHRA RIZER');
        $sheet->setCellValue('D2', 'Perempuan');
        $sheet->setCellValue('E2', '12 RPL');
        $sheet->setCellValue('F2', 'PONTIANAK, 13 June 2008');
        $sheet->setCellValue('G2', 'SYAFRIZAL');

        $sheet->setCellValue('A3', 2);
        $sheet->setCellValue('B3', '83940800');
        $sheet->setCellValue('C3', 'DENIS VITORIANSYAH');
        $sheet->setCellValue('D3', 'Laki-laki');
        $sheet->setCellValue('E3', '12 RPL');
        $sheet->setCellValue('F3', 'PONTIANAK, 12 March 2008');
        $sheet->setCellValue('G3', 'TRISNA APRIANSYAH');

        // Format NISN column as text so leading zeros are preserved
        $sheet->getStyle('B')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        // Styling
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        // Apply styles to range
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);
        $sheet->getStyle('A2:G3')->applyFromArray($dataStyle);

        // Adjust column widths automatically
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        $filename = 'template_import_siswa.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function importMasterSiswa(Request $request) {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $file = $request->file('excel_file');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            if (count($rows) <= 1) {
                return redirect()->back()->with('error', 'File Excel kosong atau tidak memiliki data.');
            }

            // Find the header row dynamically by searching for the row containing 'nisn' and 'nama'
            $headerRowIndex = -1;
            for ($rowIdx = 0; $rowIdx < count($rows); $rowIdx++) {
                $row = $rows[$rowIdx];
                if (!$row) continue;
                
                $rowValues = array_map(function($val) {
                    return strtolower(trim($val ?? ''));
                }, $row);

                if (in_array('nisn', $rowValues) && (in_array('nama siswa', $rowValues) || in_array('nama lengkap', $rowValues) || in_array('nama', $rowValues))) {
                    $headerRowIndex = $rowIdx;
                    break;
                }
            }

            // Fallback to first row if not found
            if ($headerRowIndex === -1) {
                $headerRowIndex = 0;
            }

            // Map columns dynamically based on the header row found
            $headerRow = $rows[$headerRowIndex];
            $colMap = [];
            foreach ($headerRow as $idx => $cellValue) {
                $cleanVal = strtolower(trim($cellValue ?? ''));
                if (str_contains($cleanVal, 'nisn')) {
                    $colMap['nisn'] = $idx;
                } elseif (str_contains($cleanVal, 'nama') && (str_contains($cleanVal, 'siswa') || str_contains($cleanVal, 'lengkap'))) {
                    $colMap['nama'] = $idx;
                } elseif (str_contains($cleanVal, 'kelamin') || str_contains($cleanVal, 'jk') || $cleanVal === 'gender') {
                    $colMap['jk'] = $idx;
                } elseif (str_contains($cleanVal, 'kelas')) {
                    $colMap['kelas'] = $idx;
                } elseif (str_contains($cleanVal, 'lahir') || str_contains($cleanVal, 'tanggal')) {
                    $colMap['tanggal_lahir'] = $idx;
                } elseif (str_contains($cleanVal, 'orang') || str_contains($cleanVal, 'tua') || str_contains($cleanVal, 'ortu')) {
                    $colMap['ortu'] = $idx;
                }
            }

            // Set column indices with defaults if not matched
            $nisnCol  = isset($colMap['nisn']) ? $colMap['nisn'] : 1;
            $namaCol  = isset($colMap['nama']) ? $colMap['nama'] : 2;
            $jkCol    = isset($colMap['jk']) ? $colMap['jk'] : 3;
            $kelasCol = isset($colMap['kelas']) ? $colMap['kelas'] : 4;
            $dobCol   = isset($colMap['tanggal_lahir']) ? $colMap['tanggal_lahir'] : 5;
            $ortuCol  = isset($colMap['ortu']) ? $colMap['ortu'] : 6;

            $successCount = 0;
            $failedRows = [];

            // Loop starting from the row after headers
            for ($i = $headerRowIndex + 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                if (!$row) continue;

                // Skip if both NISN and Nama Siswa are empty
                $nisnRaw = isset($row[$nisnCol]) ? trim($row[$nisnCol] ?? '') : '';
                $namaRaw = isset($row[$namaCol]) ? trim($row[$namaCol] ?? '') : '';
                
                // Also skip if it seems to repeat headers (e.g. if the row's NISN is the string "nisn")
                if (strtolower($nisnRaw) === 'nisn' || strtolower($namaRaw) === 'nama siswa') {
                    continue;
                }

                if (empty($nisnRaw) && empty($namaRaw)) {
                    continue;
                }

                $nisn = $nisnRaw;
                $namaSiswa = $namaRaw;
                $jkInput = isset($row[$jkCol]) ? trim($row[$jkCol] ?? '') : '';
                $kelasName = isset($row[$kelasCol]) ? trim($row[$kelasCol] ?? '') : '';
                $dobInput = isset($row[$dobCol]) ? trim($row[$dobCol] ?? '') : null;
                $namaOrangTua = isset($row[$ortuCol]) ? trim($row[$ortuCol] ?? '') : null;

                if (empty($namaSiswa)) {
                    $failedRows[] = "Baris " . ($i + 1) . ": Nama Siswa wajib diisi.";
                    continue;
                }

                if (empty($nisn)) {
                    // Cari berdasarkan nama terlebih dahulu jika ada yang cocok
                    $existingSiswa = Siswa::where('nama_siswa', $namaSiswa)
                        ->orWhere('nama_lengkap', $namaSiswa)
                        ->first();
                    
                    if ($existingSiswa) {
                        $nisn = $existingSiswa->nisn;
                    } else {
                        // Generate dummy NISN unik 10 digit (misal diawali '99')
                        do {
                            $nisn = '99' . str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
                        } while (Siswa::where('nisn', $nisn)->exists());
                    }
                }

                // Normalize Kelas name (e.g. "12 RPL" -> "XII RPL")
                $kelasNameNormalized = $kelasName;
                $kelasNameNormalized = preg_replace('/^12\s*/i', 'XII ', $kelasNameNormalized);
                $kelasNameNormalized = preg_replace('/^11\s*/i', 'XI ', $kelasNameNormalized);
                $kelasNameNormalized = preg_replace('/^10\s*/i', 'X ', $kelasNameNormalized);
                $kelasNameNormalized = trim($kelasNameNormalized);

                // Find class
                $kelas = Kelas::where('nama_kelas', $kelasNameNormalized)->first();
                if (!$kelas) {
                    $failedRows[] = "Baris " . ($i + 1) . ": Kelas '" . $kelasName . "' (dikonversi ke '" . $kelasNameNormalized . "') tidak ditemukan. Silakan tambahkan kelas ini terlebih dahulu.";
                    continue;
                }

                // Standardize Gender
                $gender = 'L';
                if (!empty($jkInput)) {
                    $jkInputLower = strtolower($jkInput);
                    if (str_starts_with($jkInputLower, 'p') || str_starts_with($jkInputLower, 'w') || str_contains($jkInputLower, 'perempuan') || str_contains($jkInputLower, 'wanita')) {
                        $gender = 'P';
                    }
                }

                // Parse Date of Birth safely (handles "PONTIANAK, 13 June 2008" or Indonesian month names)
                $dob = null;
                if (!empty($dobInput)) {
                    if (is_numeric($dobInput)) {
                        try {
                            $dateObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dobInput);
                            $dob = $dateObj->format('Y-m-d');
                        } catch (\Exception $e) {
                            $dob = null;
                        }
                    } else {
                        // Explode comma to strip place name (e.g., "PONTIANAK, 13 June 2008")
                        $parts = explode(',', $dobInput);
                        $datePart = count($parts) > 1 ? trim($parts[1]) : trim($dobInput);

                        // Translate Indonesian month names to English
                        $indoMonths = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember', 'jan', 'feb', 'mar', 'apr', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
                        $engMonths  = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december', 'jan', 'feb', 'mar', 'apr', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
                        $datePartLower = str_replace($indoMonths, $engMonths, strtolower($datePart));

                        $time = strtotime($datePartLower);
                        if ($time !== false) {
                            $dob = date('Y-m-d', $time);
                        } else {
                            try {
                                $dob = \Carbon\Carbon::parse($datePartLower)->format('Y-m-d');
                            } catch (\Exception $e) {
                                $dob = null;
                            }
                        }
                    }
                }

                if (empty($dob)) {
                    $dob = '2008-01-01'; // Default fallback
                }

                // Create or update Siswa record
                Siswa::updateOrCreate(
                    ['nisn' => $nisn],
                    [
                        'kelas_id' => $kelas->id,
                        'nama_siswa' => $namaSiswa,
                        'nama_lengkap' => $namaSiswa,
                        'jk' => $gender,
                        'jenis_kelamin' => $gender,
                        'tanggal_lahir' => $dob,
                        'nama_orang_tua' => $namaOrangTua,
                        'status' => 'aktif'
                    ]
                );

                $successCount++;
            }

            $message = "Berhasil mengimpor " . $successCount . " data siswa.";
            if (count($failedRows) > 0) {
                $message .= " Beberapa baris gagal: " . implode(', ', $failedRows);
                return redirect()->back()->with('warning', $message);
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage());
        }
    }

    // ================= 📤 IMPORT EXCEL GURU =================
    public function downloadTemplateGuru() {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header columns
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Guru');
        $sheet->setCellValue('C1', 'Nama Lengkap');
        $sheet->setCellValue('D1', 'Jenis Kelamin');
        $sheet->setCellValue('E1', 'Jabatan');
        $sheet->setCellValue('F1', 'Tanggal Lahir');
        $sheet->setCellValue('G1', 'No Hp');
        $sheet->setCellValue('H1', 'Alamat');

        // Add sample rows
        $sheet->setCellValue('A2', 1);
        $sheet->setCellValue('B2', 'GR-01');
        $sheet->setCellValue('C2', 'BUDI SETIAWAN, S.PD.');
        $sheet->setCellValue('D2', 'Laki-laki');
        $sheet->setCellValue('E2', 'KEPALA SEKOLAH');
        $sheet->setCellValue('F2', 'PONTIANAK, 15 May 1985');
        $sheet->setCellValue('G2', '081234567890');
        $sheet->setCellValue('H2', 'JL. MERDEKA NO. 1');

        $sheet->setCellValue('A3', 2);
        $sheet->setCellValue('B3', 'GR-02');
        $sheet->setCellValue('C3', 'SITI AMINAH, M.PD.');
        $sheet->setCellValue('D3', 'Perempuan');
        $sheet->setCellValue('E3', 'GURU MAPEL');
        $sheet->setCellValue('F3', 'PONTIANAK, 20 November 1989');
        $sheet->setCellValue('G3', '082198765432');
        $sheet->setCellValue('H3', 'JL. MERPATI NO. 10');

        // Format Kode Guru and No HP columns as text so leading zeros or codes are preserved
        $sheet->getStyle('B')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $sheet->getStyle('G')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        // Styling
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        // Apply styles to range
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
        $sheet->getStyle('A2:H3')->applyFromArray($dataStyle);

        // Adjust column widths automatically
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        $filename = 'template_import_guru.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function importMasterGuru(Request $request) {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $file = $request->file('excel_file');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            if (count($rows) <= 1) {
                return redirect()->back()->with('error', 'File Excel kosong atau tidak memiliki data.');
            }

            // Find the header row dynamically
            $headerRowIndex = -1;
            for ($rowIdx = 0; $rowIdx < count($rows); $rowIdx++) {
                $row = $rows[$rowIdx];
                if (!$row) continue;
                
                $rowValues = array_map(function($val) {
                    return strtolower(trim($val ?? ''));
                }, $row);

                if (in_array('nama lengkap', $rowValues) || in_array('nama', $rowValues) || in_array('kode guru', $rowValues)) {
                    $headerRowIndex = $rowIdx;
                    break;
                }
            }

            // Fallback to first row if not found
            if ($headerRowIndex === -1) {
                $headerRowIndex = 0;
            }

            // Map columns dynamically based on the header row found
            $headerRow = $rows[$headerRowIndex];
            $colMap = [];
            foreach ($headerRow as $idx => $cellValue) {
                $cleanVal = strtolower(trim($cellValue ?? ''));
                if (str_contains($cleanVal, 'kode') || str_contains($cleanVal, 'nip')) {
                    $colMap['kode_guru'] = $idx;
                } elseif (str_contains($cleanVal, 'nama') || str_contains($cleanVal, 'lengkap')) {
                    $colMap['nama_lengkap'] = $idx;
                } elseif (str_contains($cleanVal, 'kelamin') || str_contains($cleanVal, 'jk') || $cleanVal === 'gender') {
                    $colMap['jk'] = $idx;
                } elseif (str_contains($cleanVal, 'jabatan')) {
                    $colMap['jabatan'] = $idx;
                } elseif (str_contains($cleanVal, 'lahir') || str_contains($cleanVal, 'tanggal')) {
                    $colMap['tanggal_lahir'] = $idx;
                } elseif (str_contains($cleanVal, 'hp') || str_contains($cleanVal, 'telp') || str_contains($cleanVal, 'telepon') || str_contains($cleanVal, 'kontak')) {
                    $colMap['no_hp'] = $idx;
                } elseif (str_contains($cleanVal, 'alamat')) {
                    $colMap['alamat'] = $idx;
                }
            }

            // Set column indices with defaults if not matched
            $kodeCol   = isset($colMap['kode_guru']) ? $colMap['kode_guru'] : 1;
            $namaCol   = isset($colMap['nama_lengkap']) ? $colMap['nama_lengkap'] : 2;
            $jkCol     = isset($colMap['jk']) ? $colMap['jk'] : 3;
            $jabatanCol = isset($colMap['jabatan']) ? $colMap['jabatan'] : 4;
            $dobCol    = isset($colMap['tanggal_lahir']) ? $colMap['tanggal_lahir'] : 5;
            $hpCol     = isset($colMap['no_hp']) ? $colMap['no_hp'] : 6;
            $alamatCol = isset($colMap['alamat']) ? $colMap['alamat'] : 7;

            $successCount = 0;
            $failedRows = [];

            // Loop starting from the row after headers
            for ($i = $headerRowIndex + 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                if (!$row) continue;

                $kodeRaw = isset($row[$kodeCol]) ? trim($row[$kodeCol] ?? '') : '';
                $namaRaw = isset($row[$namaCol]) ? trim($row[$namaCol] ?? '') : '';

                // Also skip if it seems to repeat headers
                if (strtolower($kodeRaw) === 'kode guru' || strtolower($namaRaw) === 'nama lengkap') {
                    continue;
                }

                if (empty($kodeRaw) && empty($namaRaw)) {
                    continue;
                }

                $kodeGuru = $kodeRaw;
                $namaLengkap = $namaRaw;
                $jkInput = isset($row[$jkCol]) ? trim($row[$jkCol] ?? '') : '';
                $jabatan = isset($row[$jabatanCol]) ? trim($row[$jabatanCol] ?? '') : '';
                $dobInput = isset($row[$dobCol]) ? trim($row[$dobCol] ?? '') : null;
                $noHp = isset($row[$hpCol]) ? trim($row[$hpCol] ?? '') : '';
                $alamat = isset($row[$alamatCol]) ? trim($row[$alamatCol] ?? '') : '';

                if (empty($namaLengkap)) {
                    $failedRows[] = "Baris " . ($i + 1) . ": Nama Lengkap wajib diisi.";
                    continue;
                }

                // If Kode Guru is empty, generate a unique one
                if (empty($kodeGuru)) {
                    do {
                        $kodeGuru = 'GR-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                    } while (Guru::where('kode_guru', $kodeGuru)->exists());
                }

                // Standardize Gender
                $gender = 'L';
                if (!empty($jkInput)) {
                    $jkInputLower = strtolower($jkInput);
                    if (str_starts_with($jkInputLower, 'p') || str_starts_with($jkInputLower, 'w') || str_contains($jkInputLower, 'perempuan') || str_contains($jkInputLower, 'wanita')) {
                        $gender = 'P';
                    }
                }

                // Parse Date of Birth safely
                $dob = null;
                if (!empty($dobInput)) {
                    if (is_numeric($dobInput)) {
                        try {
                            $dateObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dobInput);
                            $dob = $dateObj->format('Y-m-d');
                        } catch (\Exception $e) {
                            $dob = null;
                        }
                    } else {
                        // Explode comma to strip place name (e.g., "PONTIANAK, 15 May 1985")
                        $parts = explode(',', $dobInput);
                        $datePart = count($parts) > 1 ? trim($parts[1]) : trim($dobInput);

                        // Translate Indonesian month names to English
                        $indoMonths = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember', 'jan', 'feb', 'mar', 'apr', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
                        $engMonths  = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december', 'jan', 'feb', 'mar', 'apr', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
                        $datePartLower = str_replace($indoMonths, $engMonths, strtolower($datePart));

                        $time = strtotime($datePartLower);
                        if ($time !== false) {
                            $dob = date('Y-m-d', $time);
                        } else {
                            try {
                                $dob = \Carbon\Carbon::parse($datePartLower)->format('Y-m-d');
                            } catch (\Exception $e) {
                                $dob = null;
                            }
                        }
                    }
                }

                if (empty($dob)) {
                    $dob = '1985-01-01'; // Default fallback
                }

                // Create or update Guru record
                Guru::updateOrCreate(
                    ['kode_guru' => $kodeGuru],
                    [
                        'nama_lengkap' => $namaLengkap,
                        'jk' => $gender,
                        'jabatan' => $jabatan,
                        'tanggal_lahir' => $dob,
                        'no_hp' => $noHp,
                        'alamat' => $alamat
                    ]
                );

                $successCount++;
            }

            $message = "Berhasil mengimpor " . $successCount . " data guru.";
            if (count($failedRows) > 0) {
                $message .= " Beberapa baris gagal: " . implode(', ', $failedRows);
                return redirect()->back()->with('warning', $message);
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage());
        }
    }

    public function downloadTemplateGuruAccount() {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header columns
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Guru');
        $sheet->setCellValue('C1', 'Nama Lengkap');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Password');

        // Fetch all teachers from DB
        $teachers = \App\Models\Guru::with('user')->orderBy('kode_guru', 'asc')->get();

        $rowIdx = 2;
        foreach ($teachers as $idx => $teacher) {
            $sheet->setCellValue('A' . $rowIdx, $idx + 1);
            $sheet->setCellValue('B' . $rowIdx, $teacher->kode_guru);
            $sheet->setCellValue('C' . $rowIdx, $teacher->nama_lengkap);
            $sheet->setCellValue('D' . $rowIdx, $teacher->user?->email ?? '');
            $sheet->setCellValue('E' . $rowIdx, ''); // Password empty
            $rowIdx++;
        }

        // Format columns
        $sheet->getStyle('B')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $sheet->getStyle('D')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $sheet->getStyle('E')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        // Styling
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        // Apply styles to range
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);
        
        $totalRows = $rowIdx - 1;
        if ($totalRows >= 2) {
            $sheet->getStyle('A2:E' . $totalRows)->applyFromArray($dataStyle);
        }

        // Adjust column widths automatically
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        $filename = 'template_import_akun_guru.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function importGuruAccount(Request $request) {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $file = $request->file('excel_file');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            if (count($rows) <= 1) {
                return redirect()->back()->with('error', 'File Excel kosong atau tidak memiliki data.');
            }

            // Find the header row dynamically
            $headerRowIndex = -1;
            for ($rowIdx = 0; $rowIdx < count($rows); $rowIdx++) {
                $row = $rows[$rowIdx];
                if (!$row) continue;
                
                $rowValues = array_map(function($val) {
                    return strtolower(trim($val ?? ''));
                }, $row);

                if (in_array('kode guru', $rowValues) || in_array('email', $rowValues) || in_array('password', $rowValues)) {
                    $headerRowIndex = $rowIdx;
                    break;
                }
            }

            // Fallback to first row if not found
            if ($headerRowIndex === -1) {
                $headerRowIndex = 0;
            }

            // Map columns dynamically based on the header row found
            $headerRow = $rows[$headerRowIndex];
            $colMap = [];
            foreach ($headerRow as $idx => $cellValue) {
                $cleanVal = strtolower(trim($cellValue ?? ''));
                if (str_contains($cleanVal, 'kode') || str_contains($cleanVal, 'nip')) {
                    $colMap['kode_guru'] = $idx;
                } elseif (str_contains($cleanVal, 'nama') || str_contains($cleanVal, 'lengkap')) {
                    $colMap['nama_lengkap'] = $idx;
                } elseif (str_contains($cleanVal, 'email') || str_contains($cleanVal, 'username')) {
                    $colMap['email'] = $idx;
                } elseif (str_contains($cleanVal, 'password') || str_contains($cleanVal, 'sandi')) {
                    $colMap['password'] = $idx;
                }
            }

            // Set column indices with defaults if not matched
            $kodeCol   = isset($colMap['kode_guru']) ? $colMap['kode_guru'] : 1;
            $namaCol   = isset($colMap['nama_lengkap']) ? $colMap['nama_lengkap'] : 2;
            $emailCol  = isset($colMap['email']) ? $colMap['email'] : 3;
            $passCol   = isset($colMap['password']) ? $colMap['password'] : 4;

            $successCount = 0;
            $failedRows = [];

            // Loop starting from the row after headers
            for ($i = $headerRowIndex + 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                if (!$row) continue;

                $kodeRaw = isset($row[$kodeCol]) ? trim($row[$kodeCol] ?? '') : '';
                $namaRaw = isset($row[$namaCol]) ? trim($row[$namaCol] ?? '') : '';
                $emailRaw = isset($row[$emailCol]) ? trim($row[$emailCol] ?? '') : '';
                $passRaw = isset($row[$passCol]) ? trim($row[$passCol] ?? '') : '';

                // Also skip if it seems to repeat headers
                if (strtolower($kodeRaw) === 'kode guru' || strtolower($emailRaw) === 'email') {
                    continue;
                }

                if (empty($kodeRaw) && empty($emailRaw)) {
                    continue;
                }

                if (empty($kodeRaw)) {
                    $failedRows[] = "Baris " . ($i + 1) . ": Kode Guru wajib diisi.";
                    continue;
                }

                // Find Guru by Kode Guru
                $guru = Guru::where('kode_guru', $kodeRaw)->first();
                if (!$guru) {
                    $failedRows[] = "Baris " . ($i + 1) . ": Guru dengan Kode Guru '" . $kodeRaw . "' tidak ditemukan.";
                    continue;
                }

                // Check if account already exists
                $existingUser = User::where('guru_id', $guru->id)->first();

                if (empty($emailRaw)) {
                    $failedRows[] = "Baris " . ($i + 1) . ": Email wajib diisi.";
                    continue;
                }

                if (!$existingUser && empty($passRaw)) {
                    $failedRows[] = "Baris " . ($i + 1) . ": Password wajib diisi untuk akun baru.";
                    continue;
                }

                // Check email uniqueness, but ignore if it belongs to the current guru
                $existingUserByEmail = User::where('email', $emailRaw)->first();
                if ($existingUserByEmail && $existingUserByEmail->guru_id !== $guru->id) {
                    $failedRows[] = "Baris " . ($i + 1) . ": Email '" . $emailRaw . "' sudah digunakan oleh pengguna lain.";
                    continue;
                }

                // Create or update User
                $userData = [
                    'nama'     => $guru->nama_lengkap,
                    'email'    => $emailRaw,
                    'username' => $emailRaw,
                    'role'     => 'guru',
                ];

                if (!empty($passRaw)) {
                    $userData['password'] = \Illuminate\Support\Facades\Hash::make($passRaw);
                }

                User::updateOrCreate(
                    ['guru_id' => $guru->id],
                    $userData
                );

                $successCount++;
            }

            $message = "Berhasil mengimpor " . $successCount . " akun guru.";
            if (count($failedRows) > 0) {
                $message .= " Beberapa baris gagal: " . implode(', ', $failedRows);
                return redirect()->back()->with('warning', $message);
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage());
        }
    }

    public function downloadTemplateSiswaAccount() {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header columns
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NISN');
        $sheet->setCellValue('C1', 'Nama Lengkap');
        $sheet->setCellValue('D1', 'Password');

        // Fetch all students from DB
        $students = \App\Models\Siswa::with('user')->orderBy('nisn', 'asc')->get();

        $rowIdx = 2;
        foreach ($students as $idx => $student) {
            $sheet->setCellValue('A' . $rowIdx, $idx + 1);
            $sheet->setCellValue('B' . $rowIdx, $student->nisn);
            $sheet->setCellValue('C' . $rowIdx, $student->nama_lengkap);
            $sheet->setCellValue('D' . $rowIdx, ''); // Password empty
            $rowIdx++;
        }

        // Format columns
        $sheet->getStyle('B')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $sheet->getStyle('D')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        // Styling
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        // Apply styles to range
        $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);
        
        $totalRows = $rowIdx - 1;
        if ($totalRows >= 2) {
            $sheet->getStyle('A2:D' . $totalRows)->applyFromArray($dataStyle);
        }

        // Adjust column widths automatically
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        $filename = 'template_import_akun_siswa.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function importSiswaAccount(Request $request) {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $file = $request->file('excel_file');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            if (count($rows) <= 1) {
                return redirect()->back()->with('error', 'File Excel kosong atau tidak memiliki data.');
            }

            // Find the header row dynamically
            $headerRowIndex = -1;
            for ($rowIdx = 0; $rowIdx < count($rows); $rowIdx++) {
                $row = $rows[$rowIdx];
                if (!$row) continue;
                
                $rowValues = array_map(function($val) {
                    return strtolower(trim($val ?? ''));
                }, $row);

                if (in_array('nisn', $rowValues) || in_array('password', $rowValues)) {
                    $headerRowIndex = $rowIdx;
                    break;
                }
            }

            // Fallback to first row if not found
            if ($headerRowIndex === -1) {
                $headerRowIndex = 0;
            }

            // Map columns dynamically based on the header row found
            $headerRow = $rows[$headerRowIndex];
            $colMap = [];
            foreach ($headerRow as $idx => $cellValue) {
                $cleanVal = strtolower(trim($cellValue ?? ''));
                if (str_contains($cleanVal, 'nisn')) {
                    $colMap['nisn'] = $idx;
                } elseif (str_contains($cleanVal, 'nama') || str_contains($cleanVal, 'lengkap')) {
                    $colMap['nama_lengkap'] = $idx;
                } elseif (str_contains($cleanVal, 'password') || str_contains($cleanVal, 'sandi')) {
                    $colMap['password'] = $idx;
                }
            }

            // Set column indices with defaults if not matched
            $nisnCol   = isset($colMap['nisn']) ? $colMap['nisn'] : 1;
            $namaCol   = isset($colMap['nama_lengkap']) ? $colMap['nama_lengkap'] : 2;
            $passCol   = isset($colMap['password']) ? $colMap['password'] : 3;

            $successCount = 0;
            $failedRows = [];

            // Loop starting from the row after headers
            for ($i = $headerRowIndex + 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                if (!$row) continue;

                $nisnRaw = isset($row[$nisnCol]) ? trim($row[$nisnCol] ?? '') : '';
                $passRaw = isset($row[$passCol]) ? trim($row[$passCol] ?? '') : '';

                // Also skip if it seems to repeat headers
                if (strtolower($nisnRaw) === 'nisn') {
                    continue;
                }

                if (empty($nisnRaw)) {
                    continue;
                }

                // Find Siswa by NISN
                $siswa = Siswa::where('nisn', $nisnRaw)->first();
                if (!$siswa) {
                    $failedRows[] = "Baris " . ($i + 1) . ": Siswa dengan NISN '" . $nisnRaw . "' tidak ditemukan.";
                    continue;
                }

                // Check if account already exists
                $existingUser = User::where('siswa_id', $siswa->id)->first();

                if (!$existingUser && empty($passRaw)) {
                    $failedRows[] = "Baris " . ($i + 1) . ": Password wajib diisi untuk akun baru.";
                    continue;
                }

                // Create or update User
                $userData = [
                    'nama'     => $siswa->nama_lengkap,
                    'email'    => $siswa->nisn . '@sekolah.sch.id',
                    'username' => $siswa->nisn,
                    'role'     => 'siswa',
                ];

                if (!empty($passRaw)) {
                    $userData['password'] = bcrypt($passRaw);
                }

                User::updateOrCreate(
                    ['siswa_id' => $siswa->id],
                    $userData
                );

                $successCount++;
            }

            $message = "Berhasil mengimpor " . $successCount . " akun siswa.";
            if (count($failedRows) > 0) {
                $message .= " Beberapa baris gagal: " . implode(', ', $failedRows);
                return redirect()->back()->with('warning', $message);
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage());
        }
    }
}
