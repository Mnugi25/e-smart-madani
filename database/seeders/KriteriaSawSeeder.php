<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KriteriaSawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Matikan pengecekan foreign key agar bisa truncate
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan tabel kriteria_saw beserta child tables
        DB::table('kriteria_saw')->truncate();
        DB::table('sub_kriteria_saw')->truncate();
        DB::table('penilaian_saw')->truncate();

        // 3. Masukkan data sesuai dengan struktur kolom migration kamu
        DB::table('kriteria_saw')->insert([
            [
                'kode'          => 'C1',
                'nama_kriteria' => 'Pengumpulan Tugas',
                'tipe'          => 'benefit',
                'bobot'         => 0.50,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'kode'          => 'C2',
                'nama_kriteria' => 'Kehadiran',
                'tipe'          => 'benefit',
                'bobot'         => 0.20,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'kode'          => 'C3',
                'nama_kriteria' => 'Keterlambatan',
                'tipe'          => 'cost',
                'bobot'         => 0.30,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);

        // 4. Hidupkan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();
    }
}
