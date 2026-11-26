<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Siswa;
use App\Models\NilaiUjian;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use Carbon\Carbon;

class DummyNilaiUjianSeeder extends Seeder
{
    public function run()
    {
        $kelasXRPL = Kelas::where('nama_kelas', 'like', '%X%RPL%')->first() ?? Kelas::first();
        $siswasXRPL = Siswa::where('kelas_id', $kelasXRPL->id)->get();
        $hafiz = Siswa::where('nama_lengkap', 'like', '%HAFIZ%')->first();

        echo "Target Kelas: {$kelasXRPL->nama_kelas} (Total Siswa: " . $siswasXRPL->count() . ")" . PHP_EOL;

        // =========================================================================
        // 1. PASTIKAN UJIAN 1 (Bahasa Indonesia) MEMILIKI 5 SOAL LENGKAP
        // =========================================================================
        $ujian1 = Ujian::find(1);
        if ($ujian1) {
            $ujian1->update([
                'status'      => 'Aktif',
                'durasi'      => 60,
                'semester'    => 'Ganjil',
                'waktu_mulai' => Carbon::now()->subDays(2)->setTime(8, 0, 0),
            ]);

            // Tambahkan soal tambahan jika belum ada
            $soalTambahan = [
                [
                    'pertanyaan'    => 'Kalimat definisi dalam teks laporan hasil observasi umumnya ditandai dengan penggunaan kata kerja relasional, seperti...',
                    'opsi_a'        => 'ialah, adalah, yaitu, merupakan',
                    'opsi_b'        => 'membuat, memasak, menulis, membaca',
                    'opsi_c'        => 'tetapi, melainkan, sedangkan, namun',
                    'opsi_d'        => 'karena, sebab, oleh karena itu',
                    'opsi_e'        => 'jika, apabila, andaikata, sekiranya',
                    'jawaban_benar' => 'a',
                ],
                [
                    'pertanyaan'    => 'Bagian dalam struktur teks laporan hasil observasi yang memaparkan manfaat dari sesuatu yang diamati dinamakan...',
                    'opsi_a'        => 'Pernyataan Umum',
                    'opsi_b'        => 'Deskripsi Bagian',
                    'opsi_c'        => 'Deskripsi Manfaat',
                    'opsi_d'        => 'Orientasi Masalah',
                    'opsi_e'        => 'Penegasan Ulang',
                    'jawaban_benar' => 'c',
                ],
                [
                    'pertanyaan'    => 'Teks laporan hasil observasi harus disajikan dengan informasi yang bersifat objektif. Maksud dari objektif adalah...',
                    'opsi_a'        => 'Berdasarkan opini dan perasaan pribadi penulis',
                    'opsi_b'        => 'Sesuai dengan fakta dan kenyataan hasil pengamatan nyata',
                    'opsi_c'        => 'Mengandung unsur imajinasi dan fiksi pengarang',
                    'opsi_d'        => 'Disusun berdasarkan perkiraan atau asumsi umum',
                    'opsi_e'        => 'Mengikuti selera pembaca masa kini',
                    'jawaban_benar' => 'b',
                ]
            ];

            foreach ($soalTambahan as $st) {
                Soal::firstOrCreate([
                    'ujian_id'   => $ujian1->id,
                    'pertanyaan' => $st['pertanyaan'],
                ], array_merge($st, ['ujian_id' => $ujian1->id]));
            }

            echo "✓ Soal Ujian 1 berhasil dilengkapi. Total soal: " . $ujian1->soal()->count() . PHP_EOL;

            // =====================================================================
            // 2. INPUT DATA NILAI UJIAN 1 (SUDAH SELESAI & SUDAH KELUAR NILAI)
            // =====================================================================
            // Untuk HAFIZ AL-FATHIR: Nilai 95.00 (Selesai!)
            if ($hafiz) {
                NilaiUjian::updateOrCreate([
                    'ujian_id' => $ujian1->id,
                    'siswa_id' => $hafiz->id,
                ], [
                    'total_benar' => 5,
                    'total_salah' => 0,
                    'nilai'       => 95.00,
                    'created_at'  => Carbon::now()->subDay()->setTime(9, 15, 0),
                ]);
                echo "✓ Nilai Ujian 1 untuk HAFIZ AL-FATHIR berhasil diset: 95.00 (SELESAI)" . PHP_EOL;
            }

            // Untuk seluruh siswa kelas X RPL lainnya
            $sampleScores = [
                ['benar' => 5, 'salah' => 0, 'nilai' => 100.00],
                ['benar' => 4, 'salah' => 1, 'nilai' => 88.00],
                ['benar' => 4, 'salah' => 1, 'nilai' => 85.00],
                ['benar' => 5, 'salah' => 0, 'nilai' => 92.00],
                ['benar' => 4, 'salah' => 1, 'nilai' => 80.00],
                ['benar' => 5, 'salah' => 0, 'nilai' => 96.00],
                ['benar' => 4, 'salah' => 1, 'nilai' => 84.00],
                ['benar' => 5, 'salah' => 0, 'nilai' => 90.00],
                ['benar' => 4, 'salah' => 1, 'nilai' => 88.00],
            ];

            $sIdx = 0;
            foreach ($siswasXRPL as $sw) {
                if ($hafiz && $sw->id === $hafiz->id) continue;
                $score = $sampleScores[$sIdx % count($sampleScores)];
                NilaiUjian::updateOrCreate([
                    'ujian_id' => $ujian1->id,
                    'siswa_id' => $sw->id,
                ], [
                    'total_benar' => $score['benar'],
                    'total_salah' => $score['salah'],
                    'nilai'       => $score['nilai'],
                    'created_at'  => Carbon::now()->subDay()->setTime(9, 30 + $sIdx, 0),
                ]);
                $sIdx++;
            }
            echo "✓ Seluruh siswa X RPL telah memiliki nilai selesai pada Ujian 1." . PHP_EOL;
        }

        // =========================================================================
        // 3. BUAT UJIAN 2 (TERSEDIA / AKTIF) AGAR ADA KOMBINASI SELESAI & TERSEDIA
        // =========================================================================
        $guruSiti = Guru::find(4) ?? Guru::where('nama_lengkap', 'like', '%SITI AMINAH%')->first();
        $mapelPBO = MataPelajaran::where('nama_mapel', 'like', '%Berorientasi Objek%')->first() 
            ?? MataPelajaran::first();

        if ($guruSiti && $mapelPBO) {
            $ujian2 = Ujian::updateOrCreate([
                'judul'    => 'Penilaian Sumatif: Pemrograman Berorientasi Objek',
                'kelas_id' => $kelasXRPL->id,
            ], [
                'guru_id'     => $guruSiti->id,
                'mapel_id'    => $mapelPBO->id,
                'semester'    => 'Ganjil',
                'waktu_mulai' => Carbon::now()->subHours(1),
                'durasi'      => 45, // 45 menit
                'status'      => 'Aktif',
            ]);

            // Soal untuk Ujian 2
            $soalUjian2 = [
                [
                    'pertanyaan'    => 'Dalam pemrograman berorientasi objek, entitas yang memiliki status (atribut) dan perilaku (method) dinamakan...',
                    'opsi_a'        => 'Objek (Object)',
                    'opsi_b'        => 'Variabel Global',
                    'opsi_c'        => 'Fungsi Void',
                    'opsi_d'        => 'Tipe Data Primitif',
                    'opsi_e'        => 'Konstanta',
                    'jawaban_benar' => 'a',
                ],
                [
                    'pertanyaan'    => 'Konsep pembungkusan variabel dan method ke dalam satu class untuk melindungi data dari manipulasi langsung dari luar class adalah...',
                    'opsi_a'        => 'Polimorfisme',
                    'opsi_b'        => 'Enkapsulasi (Encapsulation)',
                    'opsi_c'        => 'Inheritance',
                    'opsi_d'        => 'Abstraksi',
                    'opsi_e'        => 'Overriding',
                    'jawaban_benar' => 'b',
                ],
                [
                    'pertanyaan'    => 'Access modifier yang paling ketat dan hanya mengizinkan pengaksesan atribut dari dalam class itu sendiri adalah...',
                    'opsi_a'        => 'public',
                    'opsi_b'        => 'protected',
                    'opsi_c'        => 'private',
                    'opsi_d'        => 'default',
                    'opsi_e'        => 'static',
                    'jawaban_benar' => 'c',
                ],
            ];

            foreach ($soalUjian2 as $su2) {
                Soal::firstOrCreate([
                    'ujian_id'   => $ujian2->id,
                    'pertanyaan' => $su2['pertanyaan'],
                ], array_merge($su2, ['ujian_id' => $ujian2->id]));
            }

            echo "✓ Ujian 2 (Aktif / Tersedia) berhasil dibuat untuk kelas X RPL." . PHP_EOL;
        }

        echo PHP_EOL . "=== SELESAI: DATA DUMMY NILAI UJIAN TELAH SIAP ===" . PHP_EOL;
    }
}

