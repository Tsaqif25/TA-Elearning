<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginRegistController extends Controller
{
    /**
     * 🔹 Tampilkan halaman login utama
     */
    public function viewLogin()
    {
        return view('loginRegist/login/login', [
            'title' => 'Login',
        ]);
    }

    /**
     * 🔹 Proses autentikasi login
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->with('login-error', 'Email atau Kata Sandi salah!');
        }

        $request->session()->regenerate();
        $user = Auth::user();

        // 🔸 Sinkron kelas otomatis untuk siswa (jika belum ada)
        if ($user->hasRole('Siswa') && !$user->kelas_id) {
            $dataSiswa = DataSiswa::where('user_id', $user->id)->first();
            if ($dataSiswa) {
                $user->update(['kelas_id' => $dataSiswa->kelas_id]);
            }
        }

        // 🔸 Redirect sesuai role
        if ($user->hasRole('Admin')) {
            return redirect()->intended('/dashboard');
        }

        if ($user->hasRole('Pengajar')) {
            return redirect()->intended('/dashboard');
        }

        if ($user->hasRole('Wakur')) {
            return redirect()->intended('/dashboard');
        }

        if ($user->hasRole('Siswa')) {
            return redirect()->intended('/home');
        }

        // Jika role tidak dikenali
        Auth::logout();
        return redirect()->route('login')->with('login-error', 'Role pengguna tidak dikenali.');
    }

    /**
     * 🔹 Logout user dari sistem
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')->with('logout-success', 'Berhasil keluar!');
    }

    /**
     * 🔹 Jika sesi login berakhir
     */
    public function expiredSession()
    {
        return redirect()->route('login')
            ->with('login-error', 'Sesi login telah berakhir, silakan login kembali.');
    }
}
