<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataMapel = [
            [
                'kode_mapel' => 'BIN',
                'nama_mapel' => 'Bahasa Indonesia',
            ],
            [
                'kode_mapel' => 'BIG',
                'nama_mapel' => 'Bahasa Inggris',
            ],
            [
                'kode_mapel' => 'MTK',
                'nama_mapel' => 'Matematika',
            ],
            [
                'kode_mapel' => 'PAI',
                'nama_mapel' => 'Pendidikan Agama Islam',
            ],
            [
                'kode_mapel' => 'PPKN',
                'nama_mapel' => 'Pendidikan Pancasila dan Kewarganegaraan',
            ],
            [
                'kode_mapel' => 'PJOK',
                'nama_mapel' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan',
            ],
            [
                'kode_mapel' => 'SI',
                'nama_mapel' => 'Sejarah Indonesia',
            ],
            [
                'kode_mapel' => 'KK-RPL',
                'nama_mapel' => 'Kompetensi Keahlian Rekayasa Perangkat Lunak',
            ],
            [
                'kode_mapel' => 'KK-TKJ',
                'nama_mapel' => 'Kompetensi Keahlian Teknik Komputer dan Jaringan',
            ],
        ];

        foreach ($dataMapel as $mapel) {
            MataPelajaran::firstOrCreate([
                'kode_mapel' => $mapel['kode_mapel'],
            ], $mapel);
        }
    }
}
