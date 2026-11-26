<?php

namespace App\Services;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\HasilSaw;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use App\Models\Jadwal;
use App\Models\Kelas;

class SawService {
    // Bobot (Total 1.0)
    const W_C1 = 0.50; // Tugas (Benefit)
    const W_C2 = 0.20; // Kehadiran (Benefit)
    const W_C3 = 0.30; // Keterlambatan (Cost)

    public function calculate($startDate = null, $endDate = null) {
        // Eager load absensi to prevent N+1 queries
        $siswaList = Siswa::with(['absensi' => function($q) use ($startDate, $endDate) {
            if ($startDate && $endDate) {
                $q->whereBetween('tanggal', [$startDate, $endDate]);
            }
        }])->get();

        // Hitung total tugas per kelas dan simpan ID tugasnya
        $kelasTugasCount = [];
        $kelasTugasIds = [];
        $kelasIds = Kelas::pluck('id');
        foreach ($kelasIds as $kId) {
            $jadwalIds = Jadwal::where('kelas_id', $kId)->pluck('id');
            $tQuery = Tugas::whereIn('jadwal_id', $jadwalIds);
            if ($startDate && $endDate) {
                $tQuery->whereBetween('waktu_mulai', [$startDate, $endDate]);
            }
            $kelasTugasIds[$kId] = $tQuery->pluck('id')->toArray();
            $kelasTugasCount[$kId] = count($kelasTugasIds[$kId]);
        }

        // Hitung jumlah pengumpulan per siswa (hanya untuk tugas yang sesuai di kelas & rentang waktu tersebut yang memiliki link_tugas / benar-benar mengumpulkan)
        $pengumpulanCount = [];
        foreach ($siswaList as $s) {
            $tIds = $kelasTugasIds[$s->kelas_id] ?? [];
            if (empty($tIds)) {
                $pengumpulanCount[$s->id] = 0;
            } else {
                $pengumpulanCount[$s->id] = PengumpulanTugas::where('siswa_id', $s->id)
                    ->whereIn('tugas_id', $tIds)
                    ->whereNotNull('link_tugas')
                    ->where('link_tugas', '!=', '')
                    ->count();
            }
        }

        $rawData = [];

        // 1. Ambil data mentah dan hitung persentase kriteria
        foreach ($siswaList as $s) {
            $absensi = $s->absensi;
            $totalAbsen = $absensi->count();

            // C1: Pengumpulan Tugas (Benefit)
            $totalTugas = $kelasTugasCount[$s->kelas_id] ?? 0;
            $totalKumpul = $pengumpulanCount[$s->id] ?? 0;
            $c1 = $totalTugas > 0 ? min(1.0, $totalKumpul / $totalTugas) : 1.0;

            // C2: Kehadiran (Benefit: hadir = 1.0, izin/sakit = 0.8, alpa = 0, terlambat diabaikan)
            $hadirCount = $absensi->where('status', 'hadir')->count();
            $izinCount = $absensi->where('status', 'izin')->count();
            $sakitCount = $absensi->where('status', 'sakit')->count();
            $alpaCount = $absensi->where('status', 'alpa')->count();
            $totalAbsenC2 = $hadirCount + $izinCount + $sakitCount + $alpaCount;
            
            $c2Score = ($hadirCount * 1.0) + ($izinCount * 0.8) + ($sakitCount * 0.8);
            $c2 = $totalAbsenC2 > 0 ? ($c2Score / $totalAbsenC2) : 0;

            // C3: Keterlambatan (Cost, hanya status 'terlambat')
            $terlambat = $absensi->where('status', 'terlambat')->count();
            $c3 = $totalAbsen > 0 ? ($terlambat / $totalAbsen) : 0;

            // Hitung persentase alpa untuk skor risiko
            $alpa = $absensi->where('status', 'alpa')->count();
            $alpaPct = $totalAbsen > 0 ? ($alpa / $totalAbsen) : 0;

            $rawData[$s->id] = [
                'c1' => $c1,
                'c2' => $c2,
                'c3' => $c3,
                'alpa_pct' => $alpaPct,
            ];
        }

        // 2. Cari Nilai Max untuk Normalisasi
        $maxC1 = collect($rawData)->max('c1') ?: 1;
        $maxC2 = collect($rawData)->max('c2') ?: 1;
        $maxC3 = collect($rawData)->max('c3') ?: 1;
        $maxAlpa = collect($rawData)->max('alpa_pct') ?: 1;

        // 3. Hitung Skor & Simpan
        foreach ($rawData as $siswaId => $data) {
            // Normalisasi Benefit (C1, C2)
            $r1 = $maxC1 > 0 ? ($data['c1'] / $maxC1) : 0;
            $r2 = $maxC2 > 0 ? ($data['c2'] / $maxC2) : 0;
            
            // Normalisasi Cost (C3)
            // Jika 0, maka mendapatkan nilai optimal (1) untuk cost
            $r3 = $data['c3'] == 0 ? 1 : (1 - ($data['c3'] / $maxC3));

            // Hitung skor preferensi V (skor_prestasi)
            $skorPrestasi = ($r1 * self::W_C1) + 
                            ($r2 * self::W_C2) + 
                            ($r3 * self::W_C3);

            // Skor Risiko (Semakin tinggi persentase alpa, semakin tinggi risiko)
            $skorRisiko = ($maxAlpa > 0) ? ($data['alpa_pct'] / $maxAlpa) : 0;

            HasilSaw::updateOrCreate(
                ['siswa_id' => $siswaId],
                ['skor_prestasi' => $skorPrestasi, 'skor_risiko' => $skorRisiko]
            );
        }
    }
}
