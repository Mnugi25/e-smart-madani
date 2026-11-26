<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\NilaiUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaUjianController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        // Ambil ujian yang statusnya 'Aktif' atau 'Selesai' untuk kelas siswa tersebut
        $ujians = Ujian::where('kelas_id', $siswa->kelas_id)
            ->whereIn('status', ['Aktif', 'Selesai'])
            ->with(['mataPelajaran', 'guru', 'soal', 'nilaiUjian' => function($q) use ($siswa) {
                $q->where('siswa_id', $siswa->id);
            }])
            ->latest()
            ->get();

        return view('siswa.ujian.index', compact('ujians', 'siswa'));
    }

    public function kerjakan(Request $request, $id)
    {
        $siswa = Auth::user()->siswa;
        $ujian = Ujian::with('soal')->findOrFail($id);

        if ($ujian->kelas_id != $siswa->kelas_id || $ujian->status !== 'Aktif') {
            return redirect()->route('siswa.ujian.index')->with('error', 'Ujian ini tidak tersedia atau belum aktif untuk kelas Anda.');
        }

        // Verifikasi Lokasi Geofencing (Sekolah)
        $schoolLat = \App\Models\Setting::get('school_latitude');
        $schoolLng = \App\Models\Setting::get('school_longitude');
        $schoolRadius = \App\Models\Setting::get('school_radius', 100);

        if ($schoolLat && $schoolLng) {
            $studentLat = $request->query('lat');
            $studentLng = $request->query('lng');

            if (!$studentLat || !$studentLng) {
                return redirect()->route('siswa.ujian.index')->with('error', 'Akses Ujian Ditolak! Koordinat lokasi GPS Anda tidak terdeteksi. Silakan klik tombol Mulai Mengerjakan lagi dan izinkan lokasi browser.');
            }

            // Hitung jarak menggunakan rumus Haversine
            $earthRadius = 6371; // Jari-jari bumi dalam km
            
            $dLat = deg2rad($studentLat - $schoolLat);
            $dLon = deg2rad($studentLng - $schoolLng);
            
            $a = sin($dLat/2) * sin($dLat/2) +
                 cos(deg2rad($schoolLat)) * cos(deg2rad($studentLat)) *
                 sin($dLon/2) * sin($dLon/2);
            $c = 2 * atan2(sqrt($a), sqrt(1-$a));
            $distanceInMeters = ($earthRadius * $c) * 1000;

            if ($distanceInMeters > $schoolRadius) {
                $formattedDistance = number_format($distanceInMeters, 1, ',', '.');
                return redirect()->route('siswa.ujian.index')->with('error', "Akses Ujian Ditolak! Anda terdeteksi berada di luar lingkungan sekolah. Jarak Anda: {$formattedDistance} meter, batas maksimum: {$schoolRadius} meter.");
            }
        }

        // Acak urutan soal untuk siswa
        $ujian->setRelation('soal', $ujian->soal->shuffle());

        // Cek apakah siswa sudah mengerjakan
        $sudahMengerjakan = NilaiUjian::where('ujian_id', $id)
            ->where('siswa_id', $siswa->id)
            ->exists();

        if ($sudahMengerjakan) {
            return redirect()->route('siswa.ujian.index')->with('error', 'Anda sudah mengerjakan ujian ini.');
        }

        // Cek waktu (optional, bisa diperketat di sini)
        $sekarang = now();
        if ($sekarang < $ujian->waktu_mulai) {
             return redirect()->route('siswa.ujian.index')->with('error', 'Ujian belum dimulai.');
        }

        return view('siswa.ujian.kerjakan', compact('ujian'));
    }

    public function submit(Request $request, $id)
    {
        $siswa = Auth::user()->siswa;
        $ujian = Ujian::with('soal')->findOrFail($id);

        if ($ujian->kelas_id != $siswa->kelas_id || $ujian->status !== 'Aktif') {
            return redirect()->route('siswa.ujian.index')->with('error', 'Ujian ini tidak tersedia atau sudah ditutup.');
        }

        // Cek lagi untuk keamanan
        if (NilaiUjian::where('ujian_id', $id)->where('siswa_id', $siswa->id)->exists()) {
            return redirect()->route('siswa.ujian.index')->with('error', 'Anda sudah mengerjakan ujian ini.');
        }

        $jawabanSiswa = $request->input('jawaban', []);
        $totalSoal = $ujian->soal->count();
        $totalBenar = 0;

        foreach ($ujian->soal as $soal) {
            if (isset($jawabanSiswa[$soal->id]) && $jawabanSiswa[$soal->id] == $soal->jawaban_benar) {
                $totalBenar++;
            }
        }

        $totalSalah = $totalSoal - $totalBenar;
        $nilai = ($totalSoal > 0) ? ($totalBenar / $totalSoal) * 100 : 0;

        NilaiUjian::create([
            'ujian_id' => $id,
            'siswa_id' => $siswa->id,
            'total_benar' => $totalBenar,
            'total_salah' => $totalSalah,
            'nilai' => $nilai,
        ]);

        return redirect()->route('siswa.ujian.index')->with('success', 'Ujian berhasil dikirim. Nilai Anda: ' . round($nilai, 2));
    }

    public function download($id)
    {
        $siswa = Auth::user()->siswa;
        $ujian = Ujian::with(['soal', 'mataPelajaran', 'guru'])->findOrFail($id);

        if ($ujian->kelas_id != $siswa->kelas_id) {
            abort(403, 'Anda tidak memiliki akses ke ujian ini.');
        }

        // Pastikan siswa sudah mengerjakan
        $nilaiUjian = NilaiUjian::where('ujian_id', $id)
            ->where('siswa_id', $siswa->id)
            ->first();

        if (!$nilaiUjian) {
            return redirect()->route('siswa.ujian.index')->with('error', 'Anda harus mengerjakan ujian terlebih dahulu untuk mengunduh soal.');
        }

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('siswa.ujian.pdf', compact('ujian', 'siswa', 'nilaiUjian'));
        
        $filename = 'Soal_Ujian_' . str_replace(' ', '_', $ujian->judul) . '.pdf';
        return $pdf->download($filename);
    }
}
