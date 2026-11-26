<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaModulController extends Controller
{
    public function index(Request $request)
    {
        $siswa = Auth::user()->siswa;
        
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $kelas_id = $siswa->kelas_id;

        // Query Modul untuk kelas siswa atau umum
        $query = Modul::with(['guru', 'mataPelajaran'])
                      ->where(function($q) use ($kelas_id) {
                          $q->where('kelas_id', $kelas_id)
                            ->orWhereNull('kelas_id');
                      });

        // Filter Mata Pelajaran
        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', $request->mapel_id);
        }

        // Fitur Pencarian Kata Kunci
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhereHas('mataPelajaran', function($qMapel) use ($cari) {
                      $qMapel->where('nama_mapel', 'like', "%{$cari}%");
                  })
                  ->orWhereHas('guru', function($qGuru) use ($cari) {
                      $qGuru->where('nama_lengkap', 'like', "%{$cari}%")
                            ->orWhere('nama_guru', 'like', "%{$cari}%");
                  });
            });
        }

        $moduls = $query->latest()->get();

        // Ambil daftar mata pelajaran dari modul yang tersedia untuk kelas ini
        $mapel_ids = Modul::where(function($q) use ($kelas_id) {
            $q->where('kelas_id', $kelas_id)->orWhereNull('kelas_id');
        })->pluck('mata_pelajaran_id')->unique()->filter();

        $mapel_list = MataPelajaran::whereIn('id', $mapel_ids)->orderBy('nama_mapel')->get();

        return view('siswa.modul.index', compact('moduls', 'mapel_list'));
    }
}
