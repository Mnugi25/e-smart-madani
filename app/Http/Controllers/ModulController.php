<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModulController extends Controller
{
    public function index(Request $request)
    {
        $guru_id = Auth::user()->guru_id;
        $query = Modul::with(['mataPelajaran', 'kelas'])
                       ->where('guru_id', $guru_id);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', $request->mapel_id);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where('judul', 'like', "%{$cari}%");
        }

        $moduls = $query->latest()->get();

        // Ambil daftar kelas yang diajar oleh guru ini melalui jadwal
        $kelas_list = Kelas::whereHas('jadwal', function($q) use ($guru_id) {
            $q->where('guru_id', $guru_id);
        })->orderBy('nama_kelas')->get();

        if ($kelas_list->isEmpty()) {
            $kelas_list = Kelas::orderBy('nama_kelas')->get();
        }

        // Ambil daftar mata pelajaran dari jadwal guru
        $mapel_list = MataPelajaran::whereHas('jadwal', function($q) use ($guru_id) {
            $q->where('guru_id', $guru_id);
        })->orderBy('nama_mapel')->get();

        if ($mapel_list->isEmpty()) {
            $mapel_list = MataPelajaran::orderBy('nama_mapel')->get();
        }

        return view('guru.modul.index', compact('moduls', 'kelas_list', 'mapel_list'));
    }

    public function create()
    {
        $guru_id = Auth::user()->guru_id;
        
        // Ambil jadwal guru yang sedang login
        $jadwals = \App\Models\Jadwal::where('guru_id', $guru_id)->with(['kelas', 'mataPelajaran'])->get();
        
        // Ambil daftar mata pelajaran yang unik dari jadwal
        $mataPelajarans = $jadwals->pluck('mataPelajaran')->unique('id')->filter()->values();
        
        // Ambil daftar kelas yang unik dari jadwal
        $kelases = $jadwals->pluck('kelas')->unique('id')->filter()->values();

        return view('guru.modul.create', compact('mataPelajarans', 'kelases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_modul' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:10240', // Max 10MB
        ]);

        $guru_id = Auth::user()->guru_id;
        $file_path = null;

        if ($request->hasFile('file_modul')) {
            // Store file in public disk with randomized hashName
            $file_path = $request->file('file_modul')->store('e-modul', 'public');
        }

        Modul::create([
            'guru_id' => $guru_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'kelas_id' => $request->kelas_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_modul' => $file_path,
        ]);

        return redirect()->route('guru.modul.index')->with('success', 'E-Modul berhasil diunggah!');
    }

    public function edit(Modul $modul)
    {
        if ($modul->guru_id !== Auth::user()->guru_id) {
            abort(403, 'Unauthorized action.');
        }

        $guru_id = Auth::user()->guru_id;
        
        // Ambil jadwal guru yang sedang login
        $jadwals = \App\Models\Jadwal::where('guru_id', $guru_id)->with(['kelas', 'mataPelajaran'])->get();
        
        // Ambil daftar mata pelajaran yang unik dari jadwal
        $mataPelajarans = $jadwals->pluck('mataPelajaran')->unique('id')->filter()->values();
        
        // Ambil daftar kelas yang unik dari jadwal
        $kelases = $jadwals->pluck('kelas')->unique('id')->filter()->values();

        return view('guru.modul.edit', compact('modul', 'mataPelajarans', 'kelases'));
    }

    public function update(Request $request, Modul $modul)
    {
        if ($modul->guru_id !== Auth::user()->guru_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_modul' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:10240', // Max 10MB
        ]);

        $file_path = $modul->file_modul;

        if ($request->hasFile('file_modul')) {
            // Delete old file
            if ($modul->file_modul && Storage::disk('public')->exists($modul->file_modul)) {
                Storage::disk('public')->delete($modul->file_modul);
            }

            // Store new file with randomized hashName
            $file_path = $request->file('file_modul')->store('e-modul', 'public');
        }

        $modul->update([
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'kelas_id' => $request->kelas_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_modul' => $file_path,
        ]);

        return redirect()->route('guru.modul.index')->with('success', 'E-Modul berhasil diperbarui!');
    }

    public function destroy(Modul $modul)
    {
        if ($modul->guru_id !== Auth::user()->guru_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete physical file
        if ($modul->file_modul && Storage::disk('public')->exists($modul->file_modul)) {
            Storage::disk('public')->delete($modul->file_modul);
        }

        $modul->delete();

        return redirect()->route('guru.modul.index')->with('success', 'E-Modul berhasil dihapus!');
    }
}
