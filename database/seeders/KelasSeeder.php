<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;   // <-- Pastikan namespace model Kelas sudah benar
use App\Models\Jurusan;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data jurusan yang baru saja dibuat untuk relasi foreign key
        $rpl = Jurusan::where('kode_jurusan', 'RPL')->first();
        $tkj = Jurusan::where('kode_jurusan', 'TKJ')->first();

        $data = [
            // Kelas X
            ['tingkat' => 'X', 'nama_kelas' => 'X RPL', 'jurusan_id' => $rpl->id, 'created_at' => now(), 'updated_at' => now()],
            ['tingkat' => 'X', 'nama_kelas' => 'X TKJ', 'jurusan_id' => $tkj->id, 'created_at' => now(), 'updated_at' => now()],
            // Kelas XI
            ['tingkat' => 'XI', 'nama_kelas' => 'XI RPL', 'jurusan_id' => $rpl->id, 'created_at' => now(), 'updated_at' => now()],
            ['tingkat' => 'XI', 'nama_kelas' => 'XI TKJ', 'jurusan_id' => $tkj->id, 'created_at' => now(), 'updated_at' => now()],
            // Kelas XII
            ['tingkat' => 'XII', 'nama_kelas' => 'XII RPL', 'jurusan_id' => $rpl->id, 'created_at' => now(), 'updated_at' => now()],
            ['tingkat' => 'XII', 'nama_kelas' => 'XII TKJ', 'jurusan_id' => $tkj->id, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($data as $item) {
            Kelas::firstOrCreate([
                'nama_kelas' => $item['nama_kelas'],
            ], $item);
        }
    }
}
