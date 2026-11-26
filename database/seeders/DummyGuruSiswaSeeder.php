<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Jadwal;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use App\Models\Absensi;
use App\Models\PengajuanIzin;
use App\Models\Modul;
use App\Models\Rpp;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\NilaiUjian;
use Carbon\Carbon;

class DummyGuruSiswaSeeder extends Seeder
{
    public function run()
    {
        $today = Carbon::today();
        $hariIndo = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'][$today->format('l')] ?? 'Rabu';

        echo "Generating dummy data for day: {$hariIndo}, Date: " . $today->toDateString() . PHP_EOL;

        // Ambil data referensi
        $kelasXRPL = Kelas::where('nama_kelas', 'like', '%X%RPL%')->first() ?? Kelas::first();
        $kelasXIRPL = Kelas::where('nama_kelas', 'like', '%XI%RPL%')->first() ?? Kelas::skip(1)->first() ?? Kelas::first();
        $kelasXTKJ = Kelas::where('nama_kelas', 'like', '%X%TKJ%')->first() ?? Kelas::first();
        $kelasXITKJ = Kelas::where('nama_kelas', 'like', '%XI%TKJ%')->first() ?? Kelas::first();

        $mapelPBO = MataPelajaran::where('nama_mapel', 'like', '%Berorientasi Objek%')->first() 
            ?? MataPelajaran::where('nama_mapel', 'like', '%Pemrograman%')->first() 
            ?? MataPelajaran::first();

        $mapelWeb = MataPelajaran::where('nama_mapel', 'like', '%Web%')->first() 
            ?? MataPelajaran::skip(1)->first() 
            ?? MataPelajaran::first();

        $mapelIndo = MataPelajaran::where('nama_mapel', 'like', '%Indonesia%')->first() 
            ?? MataPelajaran::skip(2)->first() 
            ?? MataPelajaran::first();

        $mapelJaringan = MataPelajaran::where('nama_mapel', 'like', '%Jaringan%')->first() 
            ?? MataPelajaran::skip(3)->first() 
            ?? MataPelajaran::first();

        // 1. GURU TARGET: SITI AMINAH (ID 4) & BUDI SETIAWAN (ID 1 & 3)
        $guruSiti = Guru::find(4) ?? Guru::where('nama_lengkap', 'like', '%SITI AMINAH%')->first();
        $guruBudi1 = Guru::find(1) ?? Guru::where('nama_lengkap', 'like', '%BUDI%')->first();
        $guruBudi3 = Guru::find(3) ?? Guru::where('nama_lengkap', 'like', '%BUDI%')->skip(1)->first();

        if (!$guruSiti) {
            echo "Guru Siti Aminah tidak ditemukan, silakan pastikan data guru ada." . PHP_EOL;
            return;
        }

        echo "Target Guru: {$guruSiti->nama_lengkap} (ID: {$guruSiti->id})" . PHP_EOL;

        // =========================================================================
        // A. JADWAL MENGAJAR HARI INI (Rabu) & HARI LAINNYA UNTUK GURU
        // =========================================================================
        // Pastikan Siti Aminah memiliki jadwal mengajar di hari ini (Rabu)
        $jadwalSitiRabu1 = Jadwal::updateOrCreate([
            'guru_id'  => $guruSiti->id,
            'kelas_id' => $kelasXRPL->id,
            'hari'     => $hariIndo,
            'jam_mulai'=> '07:30:00',
        ], [
            'mapel_id'   => $mapelPBO->id,
            'jam_selesai'=> '09:45:00',
        ]);

        $jadwalSitiRabu2 = Jadwal::updateOrCreate([
            'guru_id'  => $guruSiti->id,
            'kelas_id' => $kelasXIRPL->id,
            'hari'     => $hariIndo,
            'jam_mulai'=> '10:15:00',
        ], [
            'mapel_id'   => $mapelPBO->id,
            'jam_selesai'=> '12:30:00',
        ]);

        // Jadwal hari Kamis & Jumat untuk Siti
        Jadwal::updateOrCreate([
            'guru_id'  => $guruSiti->id,
            'kelas_id' => $kelasXTKJ->id,
            'hari'     => 'Kamis',
            'jam_mulai'=> '08:00:00',
        ], [
            'mapel_id'   => $mapelPBO->id,
            'jam_selesai'=> '10:15:00',
        ]);

        // Jadwal Budi Setiawan hari ini (Rabu)
        if ($guruBudi1) {
            Jadwal::updateOrCreate([
                'guru_id'  => $guruBudi1->id,
                'kelas_id' => $kelasXIRPL->id,
                'hari'     => $hariIndo,
                'jam_mulai'=> '13:00:00',
            ], [
                'mapel_id'   => $mapelIndo->id,
                'jam_selesai'=> '15:15:00',
            ]);
        }

        echo "✓ Jadwal mengajar berhasil diperbarui/ditambahkan." . PHP_EOL;

        // =========================================================================
        // B. MATERI PEMBELAJARAN (Untuk Jadwal Siti Aminah & Budi Setiawan)
        // =========================================================================
        $materiList = [
            [
                'jadwal_id' => $jadwalSitiRabu1->id,
                'judul'     => 'Bab 1: Konsep Dasar Pemrograman Berorientasi Objek',
                'deskripsi' => 'Pengenalan paradigma OOP, perbandingan prosedural vs objek, dan instalasi IDE pengembangan.',
                'video_url' => 'https://www.youtube.com/watch?v=k5E2PUPi6b4',
                'file_name' => 'Modul_1_Pengenalan_OOP.pdf',
                'file_path' => 'materi/contoh_materi_1.pdf',
            ],
            [
                'jadwal_id' => $jadwalSitiRabu1->id,
                'judul'     => 'Bab 2: Pembuatan Class, Atribut, dan Method',
                'deskripsi' => 'Mempelajari cara mendefinisikan class, mendeklarasikan atribut, membuat constructor, serta method fungsi dan prosedur.',
                'video_url' => 'https://www.youtube.com/watch?v=5VbAwhBBHsg',
                'file_name' => 'Modul_2_Class_Method.pdf',
                'file_path' => 'materi/contoh_materi_2.pdf',
            ],
            [
                'jadwal_id' => $jadwalSitiRabu2->id,
                'judul'     => 'Bab 3: Prinsip Enkapsulasi, Getter dan Setter',
                'deskripsi' => 'Pembahasan hak akses modifier (private, protected, public) dan pembuatan setter-getter method untuk integritas data objek.',
                'video_url' => 'https://www.youtube.com/watch?v=3u_rW6Fz2X4',
                'file_name' => 'Modul_3_Enkapsulasi.pdf',
                'file_path' => 'materi/contoh_materi_3.pdf',
            ],
            [
                'jadwal_id' => $jadwalSitiRabu2->id,
                'judul'     => 'Bab 4: Penerapan Pewarisan (Inheritance) & Polimorfisme',
                'deskripsi' => 'Studi kasus hierarki inheritance, keyword extends, super, override method, serta implementasi interface.',
                'video_url' => 'https://www.youtube.com/watch?v=9g2QpL2zK_E',
                'file_name' => 'Modul_4_Inheritance.pdf',
                'file_path' => 'materi/contoh_materi_4.pdf',
            ]
        ];

        foreach ($materiList as $mData) {
            Materi::updateOrCreate([
                'jadwal_id' => $mData['jadwal_id'],
                'judul'     => $mData['judul'],
            ], $mData);
        }
        echo "✓ Materi pembelajaran berhasil ditambahkan." . PHP_EOL;

        // =========================================================================
        // C. TUGAS PEMBELAJARAN (Tugas Aktif & Deadline)
        // =========================================================================
        $tugas1 = Tugas::updateOrCreate([
            'jadwal_id' => $jadwalSitiRabu1->id,
            'judul'     => 'Praktikum 1: Perancangan Class Diagram & Objek Nyata',
        ], [
            'deskripsi'  => 'Buatlah perancangan minimal 3 entitas class dunia nyata (misal: Kendaraan, Akun Bank, atau Siswa) lengkap dengan atribut dan method-nya dalam bentuk kode program dan diagram UML ringkas.',
            'waktu_mulai'=> Carbon::now()->subDays(2),
            'deadline'   => Carbon::now()->addDays(3)->setTime(23, 59, 0),
            'file_name'  => 'Petunjuk_Praktikum_1.pdf',
            'file_path'  => 'tugas/petunjuk_praktikum_1.pdf',
        ]);

        $tugas2 = Tugas::updateOrCreate([
            'jadwal_id' => $jadwalSitiRabu2->id,
            'judul'     => 'Praktikum 2: Implementasi Enkapsulasi & Validasi Nilai',
        ], [
            'deskripsi'  => 'Implementasikan prinsip enkapsulasi pada class AkunNasabah dengan atribut saldo privat dan validasi saldo saat penarikan maupun setor tunai.',
            'waktu_mulai'=> Carbon::now()->subDay(),
            'deadline'   => Carbon::now()->addDays(5)->setTime(23, 59, 0),
            'file_name'  => 'Studi_Kasus_Enkapsulasi.pdf',
            'file_path'  => 'tugas/studi_kasus_enkapsulasi.pdf',
        ]);

        echo "✓ Tugas pembelajaran berhasil dibuat." . PHP_EOL;

        // =========================================================================
        // D. SISWA & PENGUMPULAN TUGAS (Sebagian dinilai, sebagian belum dinilai)
        // =========================================================================
        $siswaXRPL = Siswa::where('kelas_id', $kelasXRPL->id)->get();
        $siswaXIRPL = Siswa::where('kelas_id', $kelasXIRPL->id)->get();

        // Tugas 1: Kumpulkan tugas oleh siswa X RPL
        if ($siswaXRPL->count() > 0) {
            $sampleSiswaTugas1 = $siswaXRPL->take(6);
            $idx = 0;
            foreach ($sampleSiswaTugas1 as $s) {
                $idx++;
                // Siswa 1-3 sudah dinilai
                if ($idx <= 3) {
                    $nilai = [95, 88, 92][$idx - 1];
                    $catatan = [
                        'Pengerjaan sangat rapi, class diagram dan implementasi method lengkap!',
                        'Struktur kode sudah bagus, perhatikan indentasi dan komentar kode.',
                        'Sangat baik, logic method dan enkapsulasi berjalan dengan mulus.'
                    ][$idx - 1];
                    PengumpulanTugas::updateOrCreate([
                        'tugas_id' => $tugas1->id,
                        'siswa_id' => $s->id,
                    ], [
                        'link_tugas' => 'https://github.com/siswa-contoh/praktikum-oop-' . $idx,
                        'catatan'    => 'Tugas selesai dikerjakan sesuai petunjuk modul.',
                        'nilai'      => $nilai,
                        'created_at' => Carbon::now()->subDay(),
                    ]);
                } else {
                    // Siswa 4-6 BELUM dinilai (nilai null) -> muncul di counter Tugas Belum Dinilai!
                    PengumpulanTugas::updateOrCreate([
                        'tugas_id' => $tugas1->id,
                        'siswa_id' => $s->id,
                    ], [
                        'link_tugas' => 'https://github.com/siswa-contoh/tugas-rpl-' . $idx,
                        'catatan'    => 'Mohon review-nya Bu Guru, jika ada revisi siap diperbaiki.',
                        'nilai'      => null, // Menunggu penilaian
                        'created_at' => Carbon::now()->subHours(5),
                    ]);
                }
            }
        }

        // Tugas 2: Siswa XI RPL
        if ($siswaXIRPL->count() > 0) {
            $sampleSiswaTugas2 = $siswaXIRPL->take(5);
            $idx2 = 0;
            foreach ($sampleSiswaTugas2 as $s) {
                $idx2++;
                if ($idx2 <= 2) {
                    PengumpulanTugas::updateOrCreate([
                        'tugas_id' => $tugas2->id,
                        'siswa_id' => $s->id,
                    ], [
                        'link_tugas' => 'https://drive.google.com/file/d/sample-enkapsulasi-' . $idx2,
                        'catatan'    => 'File source code dan screenshot running program sudah diupload.',
                        'nilai'      => 90,
                        'created_at' => Carbon::now()->subHours(10),
                    ]);
                } else {
                    // Belum dinilai
                    PengumpulanTugas::updateOrCreate([
                        'tugas_id' => $tugas2->id,
                        'siswa_id' => $s->id,
                    ], [
                        'link_tugas' => 'https://drive.google.com/file/d/tugas-oop-xi-' . $idx2,
                        'catatan'    => 'Tugas enkapsulasi sudah selesai dibuat.',
                        'nilai'      => null, // Menunggu penilaian
                        'created_at' => Carbon::now()->subHours(2),
                    ]);
                }
            }
        }

        echo "✓ Data pengumpulan tugas siswa berhasil diisi (ada yang sudah dinilai & belum dinilai)." . PHP_EOL;

        // =========================================================================
        // E. ABSENSI / PRESENSI SISWA HARI INI & SEBELUMNYA
        // =========================================================================
        // Presensi untuk kelas X RPL di jadwal 1 (Hari ini)
        if ($siswaXRPL->count() > 0) {
            foreach ($siswaXRPL as $k => $s) {
                $status = 'hadir';
                $ket = 'Hadir tepat waktu';
                if ($k === 1) {
                    $status = 'terlambat';
                    $ket = 'Terlambat 10 menit karena ban bocor';
                } elseif ($k === 2) {
                    $status = 'sakit';
                    $ket = 'Sakit flu dan batuk';
                } elseif ($k === 3) {
                    $status = 'izin';
                    $ket = 'Izin mengikuti lomba futsal antar sekolah';
                }

                Absensi::updateOrCreate([
                    'siswa_id'  => $s->id,
                    'jadwal_id' => $jadwalSitiRabu1->id,
                    'tanggal'   => $today->toDateString(),
                ], [
                    'status'     => $status,
                    'keterangan' => $ket,
                ]);

                // Presensi 1 minggu lalu
                Absensi::updateOrCreate([
                    'siswa_id'  => $s->id,
                    'jadwal_id' => $jadwalSitiRabu1->id,
                    'tanggal'   => $today->copy()->subDays(7)->toDateString(),
                ], [
                    'status'     => 'hadir',
                    'keterangan' => 'Hadir tatap muka',
                ]);
            }
        }

        // Presensi kelas XI RPL di jadwal 2 (Hari ini)
        if ($siswaXIRPL->count() > 0) {
            foreach ($siswaXIRPL as $k => $s) {
                $status = ($k === 1) ? 'izin' : 'hadir';
                $ket = ($k === 1) ? 'Izin keperluan keluarga' : 'Hadir tepat waktu';

                Absensi::updateOrCreate([
                    'siswa_id'  => $s->id,
                    'jadwal_id' => $jadwalSitiRabu2->id,
                    'tanggal'   => $today->toDateString(),
                ], [
                    'status'     => $status,
                    'keterangan' => $ket,
                ]);
            }
        }

        echo "✓ Data presensi absensi siswa berhasil dibuat." . PHP_EOL;

        // =========================================================================
        // F. PENGAJUAN IZIN SISWA
        // =========================================================================
        $siswaIzin1 = $siswaXRPL->first();
        $siswaIzin2 = $siswaXIRPL->first() ?? $siswaXRPL->skip(1)->first();

        if ($siswaIzin1) {
            PengajuanIzin::updateOrCreate([
                'siswa_id'       => $siswaIzin1->id,
                'tanggal_mulai'  => $today->toDateString(),
            ], [
                'tanggal_selesai'=> $today->copy()->addDay()->toDateString(),
                'jenis'          => 'sakit',
                'alasan'         => 'Demam tinggi dan istirahat dokter selama 2 hari.',
                'status'         => 'pending', // Pending agar guru melihat notifikasi pengajuan
                'mapel_id'       => $mapelPBO->id,
            ]);
        }

        if ($siswaIzin2) {
            PengajuanIzin::updateOrCreate([
                'siswa_id'       => $siswaIzin2->id,
                'tanggal_mulai'  => $today->toDateString(),
            ], [
                'tanggal_selesai'=> $today->toDateString(),
                'jenis'          => 'izin',
                'alasan'         => 'Mengikuti seleksi olimpiade sains tingkat kota.',
                'status'         => 'disetujui',
                'mapel_id'       => $mapelPBO->id,
            ]);
        }

        echo "✓ Data pengajuan izin siswa berhasil dibuat." . PHP_EOL;

        // =========================================================================
        // G. MODUL & RPP UNTUK GURU SITI AMINAH & BUDI SETIAWAN
        // =========================================================================
        Modul::updateOrCreate([
            'guru_id'           => $guruSiti->id,
            'mata_pelajaran_id' => $mapelPBO->id,
            'kelas_id'          => $kelasXRPL->id,
            'judul'             => 'E-Modul Kurikulum Merdeka: Dasar OOP Berbasis Proyek',
        ], [
            'deskripsi'         => 'Panduan terstruktur belajar Pemrograman Berorientasi Objek mulai dari paradigma, class & object, modular programming, hingga studi kasus aplikasi kasir sederhana.',
            'file_modul'        => 'modul/e_modul_oop_dasar.pdf',
        ]);

        Modul::updateOrCreate([
            'guru_id'           => $guruSiti->id,
            'mata_pelajaran_id' => $mapelPBO->id,
            'kelas_id'          => $kelasXIRPL->id,
            'judul'             => 'E-Modul Lanjutan: Polimorfisme & Design Pattern MVC',
        ], [
            'deskripsi'         => 'Modul praktikum mandiri mengenai penerapan abstraksi, interface, dan arsitektur Model View Controller untuk rekayasa perangkat lunak.',
            'file_modul'        => 'modul/e_modul_mvc_lanjutan.pdf',
        ]);

        Rpp::updateOrCreate([
            'guru_id'           => $guruSiti->id,
            'mata_pelajaran_id' => $mapelPBO->id,
            'kelas_id'          => $kelasXRPL->id,
            'topik'             => 'Konsep Enkapsulasi dan Keamanan Akses Atribut Objek',
        ], [
            'fase'                     => 'Fase E (Kelas X SMK)',
            'alokasi_waktu'            => '2 x 45 Menit',
            'model_pembelajaran'       => 'Problem Based Learning (PBL)',
            'profil_pelajar_pancasila' => json_encode(['Bernalar Kritis', 'Mandiri', 'Gotong Royong']),
            'status'                   => 'Disetujui',
            'konten'                   => '<h2>MODUL AJAR KURIKULUM MERDEKA</h2><p><strong>Mata Pelajaran:</strong> Pemrograman Berorientasi Objek</p><p><strong>Topik:</strong> Enkapsulasi dan Keamanan Akses Objek</p><hr><h3>A. Capaian Pembelajaran</h3><p>Peserta didik mampu memahami dan mengimplementasikan konsep hak akses (private, protected, public) pada class serta membuat method getter dan setter untuk menjaga konsistensi nilai data.</p><h3>B. Langkah Kegiatan Pembelajaran</h3><ol><li><strong>Pendahuluan (15 Menit):</strong> Guru membuka kelas dengan salam, memeriksa presensi, dan memberikan apersepsi pentingnya keamanan data pada sistem perbankan.</li><li><strong>Kegiatan Inti (60 Menit):</strong> Siswa menganalisis studi kasus kebocoran data objek tanpa enkapsulasi, lalu mempraktikkan perbaikan kode menggunakan private access modifier.</li><li><strong>Penutup (15 Menit):</strong> Refleksi hasil praktikum, kesimpulan bersama, dan penugasan mandiri.</li></ol>',
        ]);

        echo "✓ Modul dan RPP Kurikulum Merdeka berhasil dibuat." . PHP_EOL;

        // =========================================================================
        // H. UJIAN ONLINE CBT, SOAL-SOAL, & HASIL PENGERJAAN SISWA
        // =========================================================================
        $ujian = Ujian::updateOrCreate([
            'guru_id'  => $guruSiti->id,
            'mapel_id' => $mapelPBO->id,
            'kelas_id' => $kelasXIRPL->id,
            'judul'    => 'Penilaian Harian 1: Konsep Dasar & Paradigma OOP',
        ], [
            'semester'   => 'Ganjil',
            'waktu_mulai'=> Carbon::now()->subHours(2),
            'durasi'     => 60, // 60 menit
            'status'     => 'Aktif',
        ]);

        // Buat butir soal untuk ujian
        $soalList = [
            [
                'ujian_id'      => $ujian->id,
                'pertanyaan'    => 'Paradigma pemrograman yang berbasis pada konsep "objek" yang dapat berisi data dalam bentuk field/atribut dan kode dalam bentuk prosedur/method disebut...',
                'opsi_a'        => 'Pemrograman Prosedural',
                'opsi_b'        => 'Pemrograman Berorientasi Objek (OOP)',
                'opsi_c'        => 'Pemrograman Fungsional',
                'opsi_d'        => 'Pemrograman Terstruktur',
                'opsi_e'        => 'Pemrograman Assembly',
                'jawaban_benar' => 'b',
            ],
            [
                'ujian_id'      => $ujian->id,
                'pertanyaan'    => 'Prinsip OOP yang membungkus data dan method yang memanipulasi data tersebut ke dalam satu unit class serta menyembunyikan detail implementasi internal adalah...',
                'opsi_a'        => 'Inheritance',
                'opsi_b'        => 'Polimorfisme',
                'opsi_c'        => 'Enkapsulasi',
                'opsi_d'        => 'Abstraksi',
                'opsi_e'        => 'Modularisasi',
                'jawaban_benar' => 'c',
            ],
            [
                'ujian_id'      => $ujian->id,
                'pertanyaan'    => 'Keyword yang digunakan pada bahasa pemrograman berorientasi objek untuk mewariskan sifat class induk ke class anak adalah...',
                'opsi_a'        => 'implements',
                'opsi_b'        => 'inherit',
                'opsi_c'        => 'extends',
                'opsi_d'        => 'super',
                'opsi_e'        => 'include',
                'jawaban_benar' => 'c',
            ],
            [
                'ujian_id'      => $ujian->id,
                'pertanyaan'    => 'Access modifier yang membuat suatu variabel atau method HANYA dapat diakses oleh class itu sendiri adalah...',
                'opsi_a'        => 'public',
                'opsi_b'        => 'protected',
                'opsi_c'        => 'private',
                'opsi_d'        => 'default',
                'opsi_e'        => 'static',
                'jawaban_benar' => 'c',
            ],
            [
                'ujian_id'      => $ujian->id,
                'pertanyaan'    => 'Method khusus yang dieksekusi secara otomatis saat sebuah objek instansiasi pertama kali dibuat dinamakan...',
                'opsi_a'        => 'Destructor',
                'opsi_b'        => 'Constructor',
                'opsi_c'        => 'Getter',
                'opsi_d'        => 'Setter',
                'opsi_e'        => 'Static Method',
                'jawaban_benar' => 'b',
            ],
        ];

        foreach ($soalList as $sData) {
            Soal::updateOrCreate([
                'ujian_id'   => $sData['ujian_id'],
                'pertanyaan' => $sData['pertanyaan'],
            ], $sData);
        }

        // Buat data pengerjaan ujian oleh beberapa siswa (Nilai Ujian)
        if ($siswaXIRPL->count() > 0) {
            $samplePeserta = $siswaXIRPL->take(4);
            $nilaiSamples = [
                ['benar' => 5, 'salah' => 0, 'skor' => 100.0],
                ['benar' => 4, 'salah' => 1, 'skor' => 80.0],
                ['benar' => 5, 'salah' => 0, 'skor' => 100.0],
                ['benar' => 4, 'salah' => 1, 'skor' => 80.0],
            ];
            foreach ($samplePeserta as $i => $peserta) {
                $nData = $nilaiSamples[$i] ?? ['benar' => 4, 'salah' => 1, 'skor' => 80.0];
                NilaiUjian::updateOrCreate([
                    'ujian_id' => $ujian->id,
                    'siswa_id' => $peserta->id,
                ], [
                    'total_benar' => $nData['benar'],
                    'total_salah' => $nData['salah'],
                    'nilai'       => $nData['skor'],
                ]);
            }
        }

        echo "✓ Ujian Online, butir soal CBT, dan nilai peserta berhasil dibuat." . PHP_EOL;

        echo PHP_EOL . "=== SELESAI: SELURUH DATA DUMMY GURU & SISWA BERHASIL DISIAPKAN ===" . PHP_EOL;
    }
}

