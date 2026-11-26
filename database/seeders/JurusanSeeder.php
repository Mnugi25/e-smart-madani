<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan; // <-- Pastikan namespace model Jurusan sudah benar

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kode_jurusan' => 'RPL',
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_jurusan' => 'TKJ',
                'nama_jurusan' => 'Teknik Komputer Jaringan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($data as $item) {
            Jurusan::firstOrCreate([
                'kode_jurusan' => $item['kode_jurusan'],
            ], $item);
        }
    }
}
