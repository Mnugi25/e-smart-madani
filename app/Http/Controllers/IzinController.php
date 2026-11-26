<?php

namespace App\Http\Controllers;

use App\Models\PengajuanIzin;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    // Mengambil ID kelas yang diajar oleh guru tersebut melalui jadwal
    private function getKelasGuru()
    {
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            return \App\Models\Kelas::pluck('id')->toArray();
        }

        $guru = $user ? $user->guru : null;
        if (!$guru) return [];

        // Ambil kelas yang diajar oleh guru melalui jadwal mengajar
        $kelasIds = Jadwal::where('guru_id', $guru->id)->pluck('kelas_id')->toArray();

        // Sertakan juga kelas yang dibina sebagai wali kelas jika ada
        $waliKelasIds = \App\Models\Kelas::where('wali_kelas_id', $guru->id)->pluck('id')->toArray();

        $allKelasIds = array_values(array_unique(array_merge($kelasIds, $waliKelasIds)));

        return $allKelasIds;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Ambil ID kelas mengajar jika guru
        $kelasIds = $this->getKelasGuru();

        if (empty($kelasIds)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke kelas mana pun.');
        }

        $selectedKelas = $request->input('kelas_id');

        // Query dasar izin pending
        $izinQuery = PengajuanIzin::with('siswa.kelas')
            ->whereHas('siswa', function ($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })
            ->where('status', 'pending');

        // Query dasar riwayat izin
        $riwayatQuery = PengajuanIzin::with('siswa.kelas')
            ->whereHas('siswa', function ($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })
            ->whereIn('status', ['disetujui', 'ditolak']);

        // Filter berdasarkan kelas jika dipilih
        if ($selectedKelas) {
            $izinQuery->whereHas('siswa', function ($query) use ($selectedKelas) {
                $query->where('kelas_id', $selectedKelas);
            });
            $riwayatQuery->whereHas('siswa', function ($query) use ($selectedKelas) {
                $query->where('kelas_id', $selectedKelas);
            });
        }

        $izinMasuk = $izinQuery->latest()->get();
        $riwayatIzin = $riwayatQuery->latest('updated_at')->get();

        // Ambil daftar kelas untuk dropdown filter
        $daftarKelas = \App\Models\Kelas::whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        return view('guru.persetujuan_izin.index', compact('izinMasuk', 'riwayatIzin', 'daftarKelas', 'selectedKelas'));
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:setuju,tidak']);

        $izin = PengajuanIzin::with('siswa')->findOrFail($id);
        $kelasIds = $this->getKelasGuru();
        if (!$izin->siswa || !in_array($izin->siswa->kelas_id, $kelasIds)) {
            abort(403, 'Anda tidak memiliki akses untuk memverifikasi izin kelas ini.');
        }

        $statusBaru = ($request->status == 'setuju') ? 'disetujui' : 'ditolak';
        $izin->status = $statusBaru;
        $izin->save();

        return redirect()->route('guru.izin.index')->with('success', 'Status berhasil diperbarui!');
    }

    public function riwayat()
    {
        $kelasIds = $this->getKelasGuru();

        if (empty($kelasIds)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki jadwal mengajar.');
        }

        $riwayatIzin = PengajuanIzin::with('siswa.kelas')
            ->whereHas('siswa', function ($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->latest('updated_at')
            ->get();

        return view('guru.persetujuan_izin.riwayat', compact('riwayatIzin'));
    }
}
