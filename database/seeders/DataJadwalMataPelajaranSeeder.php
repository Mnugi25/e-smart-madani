<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Hash;

class DataJadwalMataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        // 1. DATA JURUSAN
        $rpl = Jurusan::firstOrCreate(
            ['kode_jurusan' => 'RPL'],
            ['nama_jurusan' => 'Rekayasa Perangkat Lunak']
        );

        $tkj = Jurusan::firstOrCreate(
            ['kode_jurusan' => 'TKJ'],
            ['nama_jurusan' => 'Teknik Komputer dan Jaringan']
        );


        // 2. DATA KELAS (Ambil data yang sudah ada, tidak perlu dibuat ulang)
        $kelasXI_Rpl = Kelas::where('nama_kelas', 'XI RPL')->first();
        $kelasX_Tkj = Kelas::where('nama_kelas', 'X TKJ')->first();


        // 3. DATA MATA PELAJARAN
        $pbo = MataPelajaran::firstOrCreate(
            ['kode_mapel' => 'MP-001'],
            ['nama_mapel' => 'Pemrograman Berorientasi Objek']
        );

        $web = MataPelajaran::firstOrCreate(
            ['kode_mapel' => 'MP-002'],
            ['nama_mapel' => 'Pemrograman Web dan Perangkat Bergerak']
        );

        $jaringan = MataPelajaran::firstOrCreate(
            ['kode_mapel' => 'MP-003'],
            ['nama_mapel' => 'Administrasi Infrastruktur Jaringan']
        );


        // 4. DATA GURU & AKUN USER (Kode Guru Otomatis Berdasarkan Inisial)

        // --- Guru 1: Budi Setiawan ---
        $namaGuru1 = 'BUDI SETIAWAN, S.KOM';
        $emailGuru1 = 'budi1@gmail.com';
        $userGuru1 = User::updateOrCreate(
            ['username' => $emailGuru1],
            ['nama' => $namaGuru1, 'email' => $emailGuru1, 'password' => Hash::make('password'), 'role' => 'guru']
        );

        // Logic pencarian inisial (Membersihkan gelar, lalu ambil huruf pertama tiap kata)
        $namaMurni1 = explode(',', $namaGuru1)[0];
        preg_match_all('/\b\w/', $namaMurni1, $inisial1);
        $kodeGuru1 = strtoupper(implode('', $inisial1[0])); // Hasilnya: BS

        $guru1 = Guru::updateOrCreate(
            ['kode_guru' => $kodeGuru1],
            [
                'nama_lengkap' => $namaGuru1,
                'jk'           => 'L',
                'no_hp'        => '081234567890',
                'alamat'       => 'JL. MELATI NO. 2, DESA CONTOH',
                'tanggal_lahir'=> '1980-08-12',
                'jabatan'      => 'WALI KELAS'
            ]
        );

        $userGuru1->update(['guru_id' => $guru1->id]);

        // Tambahkan: Hubungkan Guru 1 sebagai Wali Kelas di tabel Kelas
        $kelasXI_Rpl->update(['wali_kelas_id' => $guru1->id]);

        // --- Guru 2: Siti Aminah ---
        $namaGuru2 = 'SITI AMINAH, M.PD';
        $emailGuru2 = 'siti.aminah@sekolah.sch.id';
        $userGuru2 = User::updateOrCreate(
            ['username' => $emailGuru2],
            ['nama' => $namaGuru2, 'email' => $emailGuru2, 'password' => Hash::make('password'), 'role' => 'guru']
        );

        // Logic pencarian inisial
        $namaMurni2 = explode(',', $namaGuru2)[0];
        preg_match_all('/\b\w/', $namaMurni2, $inisial2);
        $kodeGuru2 = strtoupper(implode('', $inisial2[0])); // Hasilnya: SA

        $guru2 = Guru::updateOrCreate(
            ['kode_guru' => $kodeGuru2],
            [
                'nama_lengkap' => $namaGuru2,
                'jk'           => 'P',
                'no_hp'        => '082198765432',
                'alamat'       => 'JL. KENANGA NO. 8, KOTA CONTOH',
                'tanggal_lahir'=> '1983-04-25',
                'jabatan'      => 'GURU MAPEL'
            ]
        );

        $userGuru2->update(['guru_id' => $guru2->id]);


        // 5. DATA SISWA & AKUN USER
        $userSiswa = User::updateOrCreate(
            ['username' => '0054321001'],
            ['nama' => 'ANDI WIJAYA', 'email' => '0054321001@sekolah.sch.id', 'password' => Hash::make('password'), 'role' => 'siswa']
        );

        $siswa = Siswa::updateOrCreate(
            ['nisn' => '0054321001'],
            [
                'kelas_id'        => $kelasXI_Rpl->id,
                'nama_lengkap'    => 'ANDI WIJAYA',
                'jk'              => 'L',
                'tanggal_lahir'   => '2008-01-15',
                'nama_orang_tua'  => 'SLAMET WIJAYA',
            ]
        );

        $userSiswa->update(['siswa_id' => $siswa->id]);


        // 6. DATA JADWAL PELAJARAN
        Jadwal::updateOrCreate(
            ['kelas_id' => $kelasXI_Rpl->id, 'mapel_id' => $web->id, 'hari' => 'Senin', 'jam_mulai' => '07:30:00'],
            ['guru_id' => $guru1->id, 'jam_selesai' => '09:45:00']
        );

        Jadwal::updateOrCreate(
            ['kelas_id' => $kelasXI_Rpl->id, 'mapel_id' => $pbo->id, 'hari' => 'Selasa', 'jam_mulai' => '10:00:00'],
            ['guru_id' => $guru2->id, 'jam_selesai' => '12:15:00']
        );

        Jadwal::updateOrCreate(
            ['kelas_id' => $kelasX_Tkj->id, 'mapel_id' => $jaringan->id, 'hari' => 'Rabu', 'jam_mulai' => '08:00:00'],
            ['guru_id' => $guru1->id, 'jam_selesai' => '11:00:00']
        );
    }
}
