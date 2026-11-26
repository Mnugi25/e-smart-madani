<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rpp;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class RppController extends Controller
{
    public function index(Request $request)
    {
        $guru_id = Auth::user()->guru_id;
        $query = Rpp::with(['mataPelajaran', 'kelas'])
                    ->where('guru_id', $guru_id);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $rpps = $query->latest()->get();

        // Ambil daftar kelas yang diajar oleh guru ini melalui jadwal
        $kelas_list = Kelas::whereHas('jadwal', function($q) use ($guru_id) {
            $q->where('guru_id', $guru_id);
        })->orderBy('nama_kelas')->get();

        if ($kelas_list->isEmpty()) {
            $kelas_list = Kelas::orderBy('nama_kelas')->get();
        }

        return view('guru.rpp.index', compact('rpps', 'kelas_list'));
    }

    public function create()
    {
        $guru_id = Auth::user()->guru_id;
        
        $jadwals = \App\Models\Jadwal::where('guru_id', $guru_id)->with(['kelas', 'mataPelajaran'])->get();
        $mataPelajarans = $jadwals->pluck('mataPelajaran')->unique('id')->filter()->values();
        $kelases = $jadwals->pluck('kelas')->unique('id')->filter()->values();

        if ($mataPelajarans->isEmpty()) {
            $mataPelajarans = MataPelajaran::orderBy('nama_mapel')->get();
        }
        if ($kelases->isEmpty()) {
            $kelases = Kelas::orderBy('nama_kelas')->get();
        }

        return view('guru.rpp.create', compact('mataPelajarans', 'kelases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'topik' => 'required|string|max:255',
            'fase' => 'nullable|string|max:255',
            'alokasi_waktu' => 'nullable|string|max:255',
            'model_pembelajaran' => 'nullable|string|max:255',
            'profil_pelajar_pancasila' => 'nullable|array',
            'konten' => 'required|string',
        ]);

        $guru_id = Auth::user()->guru_id;

        $rpp = Rpp::create([
            'guru_id' => $guru_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'kelas_id' => $request->kelas_id,
            'topik' => $request->topik,
            'fase' => $request->fase,
            'alokasi_waktu' => $request->alokasi_waktu,
            'model_pembelajaran' => $request->model_pembelajaran,
            'profil_pelajar_pancasila' => $request->profil_pelajar_pancasila,
            'konten' => $request->konten,
            'status' => 'draft',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'RPP berhasil disimpan.',
            'redirect_url' => route('guru.rpp.index')
        ]);
    }

    public function show(Rpp $rpp)
    {
        if ($rpp->guru_id !== Auth::user()->guru_id) {
            abort(403);
        }

        return view('guru.rpp.show', compact('rpp'));
    }

    public function edit(Rpp $rpp)
    {
        if ($rpp->guru_id !== Auth::user()->guru_id) {
            abort(403);
        }

        $guru_id = Auth::user()->guru_id;
        $jadwals = \App\Models\Jadwal::where('guru_id', $guru_id)->with(['kelas', 'mataPelajaran'])->get();
        $mataPelajarans = $jadwals->pluck('mataPelajaran')->unique('id')->filter()->values();
        $kelases = $jadwals->pluck('kelas')->unique('id')->filter()->values();

        if ($mataPelajarans->isEmpty()) {
            $mataPelajarans = MataPelajaran::orderBy('nama_mapel')->get();
        }
        if ($kelases->isEmpty()) {
            $kelases = Kelas::orderBy('nama_kelas')->get();
        }

        return view('guru.rpp.edit', compact('rpp', 'mataPelajarans', 'kelases'));
    }

    public function update(Request $request, Rpp $rpp)
    {
        if ($rpp->guru_id !== Auth::user()->guru_id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'topik' => 'required|string|max:255',
            'fase' => 'nullable|string|max:255',
            'alokasi_waktu' => 'nullable|string|max:255',
            'model_pembelajaran' => 'nullable|string|max:255',
            'profil_pelajar_pancasila' => 'nullable|array',
            'konten' => 'required|string',
        ]);

        $rpp->update($request->only([
            'mata_pelajaran_id',
            'kelas_id',
            'topik',
            'fase',
            'alokasi_waktu',
            'model_pembelajaran',
            'profil_pelajar_pancasila',
            'konten',
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'RPP berhasil diperbarui.',
            'redirect_url' => route('guru.rpp.index')
        ]);
    }

    public function destroy(Rpp $rpp)
    {
        if ($rpp->guru_id !== Auth::user()->guru_id) {
            return redirect()->route('guru.rpp.index')->with('error', 'Unauthorized');
        }

        $rpp->delete();

        return redirect()->route('guru.rpp.index')->with('success', 'RPP berhasil dihapus.');
    }

    public function generateAi(Request $request)
    {
        $request->validate([
            'mata_pelajaran' => 'required|string',
            'kelas_fase' => 'required|string',
            'topik' => 'required|string',
            'alokasi_waktu' => 'required|string',
            'model_pembelajaran' => 'nullable|string',
            'profil_pelajar_pancasila' => 'nullable|array',
        ]);

        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'API Key Gemini belum dikonfigurasi di file .env. Silakan tambahkan variabel GEMINI_API_KEY.'
            ], 400);
        }

        $user = Auth::user();
        $guru = $user ? $user->guru : null;
        $namaGuru = $guru ? $guru->nama_lengkap : 'Guru Mata Pelajaran';
        $alamatGuru = $guru ? $guru->alamat : '';
        $tahun = date('Y');

        $p3_string = '';
        if ($request->profil_pelajar_pancasila) {
            $p3_string = implode(', ', $request->profil_pelajar_pancasila);
        }

        $prompt = "Buatlah Rencana Pelaksanaan Pembelajaran (RPP) / Modul Ajar Kurikulum Merdeka yang lengkap, rapi, terstruktur, dan profesional dalam format HTML (tuliskan isi HTML-nya saja, mulai dari judul RPP sampai penutup, tanpa menyertakan tag html, head, body, atau markdown block ```html).
Gunakan parameter berikut:
- Mata Pelajaran: {$request->mata_pelajaran}
- Kelas: {$request->kelas_fase}
- Topik/Materi Pokok: {$request->topik}
- Alokasi Waktu: {$request->alokasi_waktu}
- Model Pembelajaran: {$request->model_pembelajaran}
- Profil Pelajar Pancasila (P3): {$p3_string}

Catatan penting untuk bagian penandatanganan/penutup RPP:
- Nama Guru: {$namaGuru}
- Tahun pembuatan RPP: {$tahun}
- Alamat/Lokasi Guru: {$alamatGuru} (Analisis alamat ini untuk mengambil nama kota/kabupaten secara cerdas sebagai kota penandatanganan RPP. Jika kosong atau tidak spesifik, gunakan 'Jakarta' sebagai default).
- Format penutup RPP: Tuliskan kota penandatanganan tersebut diikuti dengan tanggal kosong dan tahun {$tahun} (contoh: '[Nama Kota], ....................... {$tahun}') serta nama guru '{$namaGuru}' di bawahnya sebagai guru mata pelajaran yang menandatangani RPP.

Struktur dokumen RPP yang dihasilkan harus mencakup komponen Kurikulum Merdeka berikut secara lengkap:
1. IDENTITAS MODUL (Mata Pelajaran, Kelas, Alokasi Waktu, Topik)
2. KOMPETENSI AWAL
3. PROFIL PELAJAR PANCASILA (P3) (yang dipilih di atas beserta penjelasannya singkat)
4. SARANA DAN PRASARANA
5. TARGET PESERTA DIDIK
6. MODEL PEMBELAJARAN (yang dipilih di atas)
7. KOMPONEN INTI:
   - Tujuan Pembelajaran
   - Pemahaman Bermakna
   - Pertanyaan Pemantik
   - Kegiatan Pembelajaran (Pendahuluan, Inti [disesuaikan langkah-langkah model pembelajaran yang dipilih], Penutup)
8. ASESMEN / PENILAIAN (Sikap, Kognitif, Performa)
9. PENGAYAAN DAN REMEDIAL
10. REFLEKSI GURU DAN PESERTA DIDIK

Gunakan tag-tag HTML semantik seperti <h3>, <p>, <ul>, <ol>, <li>, <table>, <tr>, <td>, dan style CSS inline yang rapi (misal: text-align, border, padding, background-color yang soft) agar RPP terlihat sangat profesional dan langsung siap digunakan. Jangan memberikan teks pembuka seperti 'Tentu, ini adalah RPP...' atau penutup di luar HTML tersebut.";

        try {
            $model = 'gemini-3.5-flash';
            $response = Http::timeout(60)->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                ]
            ]);

            // Jika gagal karena limit/high demand, otomatis coba model fallback yang lebih ringan
            if ($response->failed() && ($response->status() === 429 || $response->status() === 503 || str_contains(strtolower($response->body()), 'demand'))) {
                $model = 'gemini-3.1-flash-lite';
                $response = Http::timeout(60)->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                    ]
                ]);
            }

            if ($response->failed()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal memanggil Gemini API: ' . ($response->json('error.message') ?? $response->body())
                ], 500);
            }

            $rppText = $response->json('candidates.0.content.parts.0.text');

            if (!$rppText) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Respon dari Gemini API kosong.'
                ], 500);
            }

            // Bersihkan tag markdown ```html dan ``` jika ada
            $rppText = trim($rppText);
            if (str_starts_with($rppText, '```html')) {
                $rppText = substr($rppText, 7);
            } elseif (str_starts_with($rppText, '```')) {
                $rppText = substr($rppText, 3);
            }
            if (str_ends_with($rppText, '```')) {
                $rppText = substr($rppText, 0, -3);
            }
            $rppText = trim($rppText);

            return response()->json([
                'status' => 'success',
                'konten' => $rppText
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}
