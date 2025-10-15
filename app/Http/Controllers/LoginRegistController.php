<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginRegistController extends Controller
{
    public function viewLogin()
    {
        $adminAvailability = User::role('Admin')->first();
        $checker = $adminAvailability ? 1 : 0;

        return view('loginRegist/login/login', [
            'title' => 'Login',
            'hasAdmin' => $checker,
        ]);
    }

    public function viewRegister()
    {
        return view('loginRegist/register/register', ['title' => 'Register']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirm-password' => 'required|min:8|same:password',
            'nis' => 'required',
        ]);

        try {
            $dataSiswa = DataSiswa::where('nis', $request->nis)->first();

            if (!$dataSiswa) {
                return back()->with('nis-error', 'NIS (Nomor Induk Siswa) Tidak ditemukan');
            }

            if ($dataSiswa->punya_akun == 1) {
                return back()->with('nis-error', 'NIS (Nomor Induk Siswa) Sudah digunakan.');
            }

            $user = User::create([
                'name' => $dataSiswa->name,
                'kelas_id' => $dataSiswa->kelas_id,
                'gambar' => null,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('Siswa');

            // Update DataSiswa: tandai sudah punya akun + isi no_telp jika ada
            $dataSiswa->update([
                'user_id' => $user->id,
                'punya_akun' => 1,
                'no_telp' => $request->noTelp ?? $dataSiswa->no_telp,
            ]);

            return redirect('/login')->with('register-success', 'Registrasi Berhasil');
        } catch (\Exception $e) {
            return back()->with('nis-error', 'Terjadi kesalahan dalam proses registrasi: ' . $e->getMessage());
        }
    }

   public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        // 🔹 Arahkan sesuai role baru
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('Pengajar')) {
            return redirect()->route('pengajar.dashboard');
        } elseif ($user->hasRole('Siswa')) {
            return redirect()->route('siswa.home');
        }

        // Kalau tidak punya role sama sekali
        Auth::logout();
        return redirect()->route('login')->with('login-error', 'Role pengguna tidak ditemukan.');
    }

    return back()->with('login-error', 'Email atau Kata Sandi salah!');
}


    public function logout(Request $request)
    {
        if (auth()->check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect(route('login'))->with('logout-success', 'Berhasil keluar!');
        }

        return redirect(route('login'));
    }

    public function viewForgotPassword()
    {
        return view('loginRegist/forgot-password/forgotPassword', ['title' => 'Forgot Password']);
    }
}
