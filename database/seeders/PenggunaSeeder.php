<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ==========================================
        // 1. SEEDER DATA GURU (Username menggunakan Email)
        // ==========================================

        // Guru 1
        $emailGuru1 = 'budi@gmail.com';
        $userGuru1 = User::updateOrCreate([
            'username' => $emailGuru1,
        ],[
            'nama'     => 'BUDI SETIAWAN, S.PD.',
            'email'    => $emailGuru1,
            'password' => Hash::make('sekolah'),
            'role'     => 'guru'
        ]);

        $guru1 = Guru::updateOrCreate([
            'kode_guru' => 'GR-01',
        ],[
            'nama_lengkap' => 'BUDI SETIAWAN, S.PD.',
            'jk'           => 'L',
            'no_hp'        => '081234567890',
            'alamat'       => 'JL. MERDEKA NO. 1, KOTA CONTOH',
            'tanggal_lahir'=> '1985-05-15',
            'jabatan'      => 'KEPALA SEKOLAH',
        ]);

        $userGuru1->update(['guru_id' => $guru1->id]);

        // Guru 2
        $emailGuru2 = 'siti.aminah@sekolah.sch.id';
        $userGuru2 = User::updateOrCreate([
            'username' => $emailGuru2,
        ],[
            'nama'     => 'SITI AMINAH, M.PD.',
            'email'    => $emailGuru2,
            'password' => Hash::make('password'),
            'role'     => 'guru'
        ]);

        $guru2 = Guru::updateOrCreate([
            'kode_guru' => 'GR-02',
        ],[
            'nama_lengkap' => 'SITI AMINAH, M.PD.',
            'jk'           => 'P',
            'no_hp'        => '082198765432',
            'alamat'       => 'JL. MERPATI NO. 10, KOTA CONTOH',
            'tanggal_lahir'=> '1989-11-20',
            'jabatan'      => 'GURU MAPEL',
        ]);

        $userGuru2->update(['guru_id' => $guru2->id]);


        // ==========================================
        // 2. SEEDER DATA SISWA (Username menggunakan NISN)
        // ==========================================

        // Ambil ID kelas pertama dari database secara dinamis agar tidak error Foreign Key
        $kelas = Kelas::first();
        $kelasId = $kelas ? $kelas->id : 1;

        // Siswa 1
        $nisnSiswa1 = '0054321098';
        $userSiswa1 = User::updateOrCreate([
            'username' => $nisnSiswa1,
        ],[
            'nama'     => 'RIAN HIDAYAT',
            'email'    => $nisnSiswa1 . '@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role'     => 'siswa'
        ]);

        $siswa1 = Siswa::updateOrCreate([
            'nisn' => $nisnSiswa1,
        ],[
            'kelas_id'        => $kelasId,
            'nama_lengkap'    => 'RIAN HIDAYAT',
            'jk'              => 'L',
            'tanggal_lahir'   => '2008-03-10',
            'nama_orang_tua'  => 'SUWARNO',
        ]);

        $userSiswa1->update(['siswa_id' => $siswa1->id]);

        // Siswa 2
        $nisnSiswa2 = '0069876543';
        $userSiswa2 = User::updateOrCreate([
            'username' => $nisnSiswa2,
        ],[
            'nama'     => 'AMELIA PUTRI',
            'email'    => $nisnSiswa2 . '@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role'     => 'siswa'
        ]);

        $siswa2 = Siswa::updateOrCreate([
            'nisn' => $nisnSiswa2,
        ],[
            'kelas_id'        => $kelasId,
            'nama_lengkap'    => 'AMELIA PUTRI',
            'jk'              => 'P',
            'tanggal_lahir'   => '2009-07-22',
            'nama_orang_tua'  => 'NINA PUTRI',
        ]);

        $userSiswa2->update(['siswa_id' => $siswa2->id]);
    }
}
