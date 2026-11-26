<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Absensi;
use Carbon\Carbon;

class AttendanceAnalysisSeeder extends Seeder
{
    public function run(): void
    {
        $siswas = Siswa::all();
        if ($siswas->count() < 2) {
            $this->command->info('Not enough students to seed attendance.');
            return;
        }

        $jadwals = Jadwal::all();
        if ($jadwals->isEmpty()) {
            $this->command->info('No schedules found to seed attendance.');
            return;
        }

        $siswaHadir = $siswas->first();
        $siswaAlpa = $siswas->last();

        // Seed 20 hadir for siswaHadir
        for ($i = 1; $i <= 20; $i++) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswaHadir->id,
                    'jadwal_id' => $jadwals->random()->id,
                    'tanggal' => Carbon::today()->subDays($i)->toDateString(),
                ],
                [
                    'status' => 'hadir',
                    'keterangan' => 'Hadir tepat waktu',
                ]
            );
        }

        // Seed 15 alpa for siswaAlpa
        for ($i = 1; $i <= 15; $i++) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswaAlpa->id,
                    'jadwal_id' => $jadwals->random()->id,
                    'tanggal' => Carbon::today()->subDays($i)->toDateString(),
                ],
                [
                    'status' => 'alpa',
                    'keterangan' => 'Absen tanpa keterangan',
                ]
            );
        }

        $this->command->info('Attendance analysis data seeded successfully.');
    }
}
