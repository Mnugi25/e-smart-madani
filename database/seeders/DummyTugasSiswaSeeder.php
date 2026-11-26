<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use App\Models\Siswa;
use App\Models\Kelas;
use Carbon\Carbon;

class DummyTugasSiswaSeeder extends Seeder
{
    public function run()
    {
        $kelasXRPL = Kelas::where('nama_kelas', 'like', '%X%RPL%')->first() ?? Kelas::first();
        $siswasXRPL = Siswa::where('kelas_id', $kelasXRPL->id)->get();
        $hafiz = Siswa::where('nama_lengkap', 'like', '%HAFIZ%')->first();

        echo "Target Kelas: {$kelasXRPL->nama_kelas} (Total Siswa: " . $siswasXRPL->count() . ")" . PHP_EOL;

        // =========================================================================
        // 1. TUGAS UNTUK JADWAL ID 26 (Kompetensi Keahlian Rekayasa Perangkat Lunak)
        // =========================================================================
        $jadwal26 = Jadwal::find(26);
        if ($jadwal26) {
            echo "Membuat Tugas untuk Jadwal ID 26 ({$jadwal26->mataPelajaran->nama_mapel})..." . PHP_EOL;

            // Tugas 1: Sudah Dikumpulkan & Sudah Dinilai
            $tugas1 = Tugas::updateOrCreate([
                'jadwal_id' => $jadwal26->id,
                'judul'     => 'Praktikum 1: Analisis Kebutuhan Sistem & Use Case Diagram',
            ], [
                'deskripsi'  => 'Susun dokumen analisis kebutuhan fungsional dan diagram use case lengkap dengan skenario interaksi aktor untuk sistem kasir minimarket.',
                'waktu_mulai'=> Carbon::now()->subDays(3)->setTime(8, 0, 0),
                'deadline'   => Carbon::now()->addDays(4)->setTime(23, 59, 0),
                'file_name'  => 'Modul_Praktikum_UseCase.pdf',
                'file_path'  => 'tugas/modul_praktikum_usecase.pdf',
            ]);

            // Tugas 2: Sudah Dikumpulkan & Belum Dinilai
            $tugas2 = Tugas::updateOrCreate([
                'jadwal_id' => $jadwal26->id,
                'judul'     => 'Praktikum 2: Perancangan Basis Data Relasional & Normalisasi 3NF',
            ], [
                'deskripsi'  => 'Rancang Entity Relationship Diagram (ERD) dan terapkan normalisasi dari 1NF, 2NF, hingga 3NF untuk modul data barang, transaksi, dan pelanggan.',
                'waktu_mulai'=> Carbon::now()->subDays(2)->setTime(8, 0, 0),
                'deadline'   => Carbon::now()->addDays(3)->setTime(23, 59, 0),
                'file_name'  => 'Panduan_ERD_Normalisasi.pdf',
                'file_path'  => 'tugas/panduan_erd_normalisasi.pdf',
            ]);

            // Tugas 3: Belum Dikumpulkan (Aktif)
            $tugas3 = Tugas::updateOrCreate([
                'jadwal_id' => $jadwal26->id,
                'judul'     => 'Tugas Mandiri: Pembuatan Wireframe & Prototipe Antarmuka Pengguna (UI/UX)',
            ], [
                'deskripsi'  => 'Buatlah prototipe antarmuka pengguna responsif minimal 5 halaman (Dashboard, Login, Produk, Kasir, Laporan) menggunakan Figma.',
                'waktu_mulai'=> Carbon::now()->subHours(3),
                'deadline'   => Carbon::now()->addDays(7)->setTime(23, 59, 0),
                'file_name'  => 'Petunjuk_Wireframe_Figma.pdf',
                'file_path'  => 'tugas/petunjuk_wireframe_figma.pdf',
            ]);

            // SUBMISI SISWA UNTUK TUGAS 1 (Sebagian dinilai, termasuk Hafiz nilai 95)
            if ($hafiz) {
                PengumpulanTugas::updateOrCreate([
                    'tugas_id' => $tugas1->id,
                    'siswa_id' => $hafiz->id,
                ], [
                    'link_tugas' => 'https://github.com/hafiz-alfathir/rpl-usecase-analysis',
                    'catatan'    => 'Tugas use case diagram dan skenario use case sudah selesai dikerjakan sesuai modul.',
                    'nilai'      => 95,
                    'created_at' => Carbon::now()->subDays(2)->setTime(14, 20, 0),
                ]);

                // Hafiz kumpul Tugas 2 (Belum dinilai)
                PengumpulanTugas::updateOrCreate([
                    'tugas_id' => $tugas2->id,
                    'siswa_id' => $hafiz->id,
                ], [
                    'link_tugas' => 'https://drive.google.com/file/d/erd-normalisasi-hafiz',
                    'catatan'    => 'Diagram ERD dan bukti normalisasi 3NF sudah terlampir. Mohon review-nya Bu Sri.',
                    'nilai'      => null, // Belum dinilai
                    'created_at' => Carbon::now()->subDay()->setTime(11, 45, 0),
                ]);
            }

            // Siswa lain di kelas X RPL
            $sampleNilai = [90, 88, 92, 85, 96, 84, 91, 89];
            $idx = 0;
            foreach ($siswasXRPL as $sw) {
                if ($hafiz && $sw->id === $hafiz->id) continue;

                // Tugas 1: Kumpul & dinilai
                PengumpulanTugas::updateOrCreate([
                    'tugas_id' => $tugas1->id,
                    'siswa_id' => $sw->id,
                ], [
                    'link_tugas' => 'https://github.com/' . strtolower(explode(' ', $sw->nama_lengkap)[0]) . '/usecase-kasir',
                    'catatan'    => 'Sudah selesai dikerjakan.',
                    'nilai'      => $sampleNilai[$idx % count($sampleNilai)],
                    'created_at' => Carbon::now()->subDays(2),
                ]);

                // Tugas 2: Setengah sudah dinilai, setengah belum dinilai
                $nilaiT2 = ($idx % 2 === 0) ? ($sampleNilai[$idx % count($sampleNilai)] - 2) : null;
                PengumpulanTugas::updateOrCreate([
                    'tugas_id' => $tugas2->id,
                    'siswa_id' => $sw->id,
                ], [
                    'link_tugas' => 'https://drive.google.com/file/d/erd-' . strtolower(explode(' ', $sw->nama_lengkap)[0]),
                    'catatan'    => 'Tugas ERD dan normalisasi.',
                    'nilai'      => $nilaiT2,
                    'created_at' => Carbon::now()->subDay(),
                ]);

                $idx++;
            }

            echo "✓ Tugas & Submisi untuk Jadwal 26 berhasil dibuat." . PHP_EOL;
        }

        // =========================================================================
        // 2. TUGAS UNTUK JADWAL LAIN DI KELAS X RPL
        // =========================================================================
        // Jadwal 4: Bahasa Indonesia (Budi Setiawan)
        $jadwal4 = Jadwal::find(4);
        if ($jadwal4) {
            $tugasIndo = Tugas::updateOrCreate([
                'jadwal_id' => $jadwal4->id,
                'judul'     => 'Tugas Analisis Struktur Teks Laporan Hasil Observasi',
            ], [
                'deskripsi'  => 'Bacalah teks observasi tentang lingkungan sekolah, lalu identifikasi bagian pernyataan umum, deskripsi bagian, dan deskripsi manfaat.',
                'waktu_mulai'=> Carbon::now()->subDays(4),
                'deadline'   => Carbon::now()->addDays(2)->setTime(23, 59, 0),
                'file_name'  => 'Teks_LHO_Sekolah.pdf',
                'file_path'  => 'tugas/teks_lho_sekolah.pdf',
            ]);

            if ($hafiz) {
                PengumpulanTugas::updateOrCreate([
                    'tugas_id' => $tugasIndo->id,
                    'siswa_id' => $hafiz->id,
                ], [
                    'link_tugas' => 'https://drive.google.com/file/d/analisis-teks-lho-hafiz',
                    'catatan'    => 'Analisis struktur sudah lengkap disertai bukti kalimat kutipan.',
                    'nilai'      => 92,
                    'created_at' => Carbon::now()->subDays(2),
                ]);
            }
        }

        // Jadwal 61: Pemrograman Berorientasi Objek (Siti Aminah)
        $jadwal61 = Jadwal::find(61);
        if ($jadwal61) {
            $tugasOOP = Tugas::updateOrCreate([
                'jadwal_id' => $jadwal61->id,
                'judul'     => 'Praktikum OOP: Enkapsulasi Class Akun Bank',
            ], [
                'deskripsi'  => 'Implementasikan class AkunBank dengan atribut nomor rekening, saldo, dan nama pemilik menggunakan akses private serta method deposit dan withdraw.',
                'waktu_mulai'=> Carbon::now()->subDays(2),
                'deadline'   => Carbon::now()->addDays(5)->setTime(23, 59, 0),
                'file_name'  => 'Petunjuk_Praktikum_OOP.pdf',
                'file_path'  => 'tugas/petunjuk_praktikum_oop.pdf',
            ]);

            if ($hafiz) {
                PengumpulanTugas::updateOrCreate([
                    'tugas_id' => $tugasOOP->id,
                    'siswa_id' => $hafiz->id,
                ], [
                    'link_tugas' => 'https://github.com/hafiz-alfathir/oop-bank-account',
                    'catatan'    => 'Source code Java/PHP class AkunBank sudah diupload ke repo.',
                    'nilai'      => null, // Belum dinilai
                    'created_at' => Carbon::now()->subDay(),
                ]);
            }
        }

        echo PHP_EOL . "=== SELESAI: DATA DUMMY TUGAS SISWA TELAH SIAP ===" . PHP_EOL;
    }
}

