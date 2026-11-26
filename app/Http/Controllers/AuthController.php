<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Sesuaikan dengan kolom username yang Anda gunakan di tabel users
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // ================= ⚙️ PROFIL USER =================

    public function profil()
    {
        // Ambil model User dengan relasi yang dibutuhkan agar method load tidak dipanggil langsung pada object yang belum didefinisikan dengan jelas.
        $user = User::with(['guru', 'siswa.kelas'])->findOrFail(Auth::id());
        return view('admin.profil.index', compact('user'));
    }

    public function editProfil()
    {
        $user = User::with(['guru', 'siswa.kelas'])->findOrFail(Auth::id());
        return view('admin.profil.edit', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'nama'     => 'required|string|max:255',
            'password' => 'nullable|min:6',
            'no_hp'    => 'nullable|string|max:20',
            'alamat'   => 'nullable|string|max:500',
        ]);

        // 1. Update data User
        $userData = ['nama' => $request->nama];
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $user->update($userData);

        // 2. Update data profil (Guru atau Siswa)
        if ($user->guru) {
            $guruData = [
                'nama_lengkap' => $request->nama,
                'no_hp' => $request->no_hp,
            ];
            if ($request->has('alamat')) {
                $guruData['alamat'] = $request->alamat;
            }
            $user->guru->update($guruData);
        } elseif ($user->siswa) {
            $siswaData = [
                'no_hp' => $request->no_hp,
            ];
            if ($request->has('alamat')) {
                $siswaData['alamat'] = $request->alamat;
            }
            $user->siswa->update($siswaData);
        }

        return redirect('/admin/profil')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
