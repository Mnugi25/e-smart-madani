<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UjianController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        $ujians = Ujian::where('guru_id', $guru->id)->with(['mataPelajaran', 'kelas'])->latest()->get();
        return view('guru.ujian.index', compact('ujians'));
    }

    public function create()
    {
        $guru = Auth::user()->guru;
        // Ambil mapel dan kelas yang diampu oleh guru dari jadwal
        $jadwal = Jadwal::where('guru_id', $guru->id)->with(['mataPelajaran', 'kelas'])->get();
        $mapels = $jadwal->pluck('mataPelajaran')->unique('id');
        $kelas = $jadwal->pluck('kelas')->unique('id');

        return view('guru.ujian.create', compact('mapels', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mapel_id' => 'required',
            'kelas_id' => 'required',
            'judul' => 'required|string|max:255',
            'semester' => 'required|in:Ganjil,Genap',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'durasi' => 'required|integer|min:1',
        ]);

        $guru = Auth::user()->guru;
        $waktu_mulai = $request->tanggal . ' ' . $request->jam;

        Ujian::create([
            'guru_id' => $guru->id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'judul' => $request->judul,
            'semester' => $request->semester,
            'waktu_mulai' => $waktu_mulai,
            'durasi' => $request->durasi,
            'status' => 'Draft',
        ]);

        return redirect()->route('guru.ujian.index')->with('success', 'Ujian berhasil dibuat sebagai Draft.');
    }

    public function edit($id)
    {
        $ujian = Ujian::findOrFail($id);
        $guru = Auth::user()->guru;

        if ($ujian->guru_id != $guru->id) {
            return abort(403);
        }

        $jadwal = Jadwal::where('guru_id', $guru->id)->with(['mataPelajaran', 'kelas'])->get();
        $mapels = $jadwal->pluck('mataPelajaran')->unique('id');
        $kelas = $jadwal->pluck('kelas')->unique('id');

        return view('guru.ujian.edit', compact('ujian', 'mapels', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $ujian = Ujian::findOrFail($id);
        if ($ujian->guru_id != Auth::user()->guru->id) {
            return abort(403);
        }

        $request->validate([
            'mapel_id' => 'required',
            'kelas_id' => 'required',
            'judul' => 'required|string|max:255',
            'semester' => 'required|in:Ganjil,Genap',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'durasi' => 'required|integer|min:1',
            'status' => 'required|in:Draft,Aktif,Selesai',
        ]);

        $waktu_mulai = $request->tanggal . ' ' . $request->jam;
        
        $data = $request->only([
            'mapel_id',
            'kelas_id',
            'judul',
            'semester',
            'durasi',
            'status',
        ]);
        $data['waktu_mulai'] = $waktu_mulai;

        $ujian->update($data);

        return redirect()->route('guru.ujian.index')->with('success', 'Ujian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ujian = Ujian::findOrFail($id);
        if ($ujian->guru_id != Auth::user()->guru->id) {
            return abort(403);
        }

        $ujian->delete();
        return back()->with('success', 'Ujian berhasil dihapus.');
    }

    public function soal($id)
    {
        $ujian = Ujian::with('soal')->findOrFail($id);
        if ($ujian->guru_id != Auth::user()->guru->id) {
            return abort(403);
        }

        return view('guru.ujian.soal', compact('ujian'));
    }

    public function storeSoal(Request $request, $id)
    {
        $ujian = Ujian::findOrFail($id);
        if ($ujian->guru_id != Auth::user()->guru->id) {
            return abort(403);
        }

        $request->validate([
            'pertanyaan' => 'required',
            'opsi_a' => 'required',
            'opsi_b' => 'required',
            'opsi_c' => 'required',
            'opsi_d' => 'required',
            'jawaban_benar' => 'required|in:a,b,c,d,e',
        ]);

        Soal::create([
            'ujian_id' => $id,
            'pertanyaan' => $request->pertanyaan,
            'opsi_a' => $request->opsi_a,
            'opsi_b' => $request->opsi_b,
            'opsi_c' => $request->opsi_c,
            'opsi_d' => $request->opsi_d,
            'opsi_e' => $request->opsi_e,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return back()->with('success', 'Soal berhasil ditambahkan.');
    }

    public function destroySoal($id)
    {
        $soal = Soal::with('ujian')->findOrFail($id);
        if (!$soal->ujian || $soal->ujian->guru_id != Auth::user()->guru->id) {
            return abort(403);
        }

        $soal->delete();
        return back()->with('success', 'Soal berhasil dihapus.');
    }

    public function rekap($id)
    {
        $ujian = Ujian::with(['nilaiUjian.siswa', 'kelas'])->findOrFail($id);
        if ($ujian->guru_id != Auth::user()->guru->id) {
            return abort(403);
        }

        return view('guru.ujian.rekap', compact('ujian'));
    }
}
