<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            JurusanSeeder::class,
            KelasSeeder::class,
            DummyGuruSiswaSeeder::class,
            DummyNilaiUjianSeeder::class,
            DummyTugasSiswaSeeder::class,
        ]);
    }

}
