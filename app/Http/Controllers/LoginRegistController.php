<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\DataSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginRegistController extends Controller
{
    /**
     * Menampilkan halaman login.
     *
     * @return \Illuminate\View\View
     */
    public function viewLogin()
    {
        // Periksa ketersediaan akun admin menggunakan Spatie
        $adminAvailability = User::role('Admin')->first();

        // Jika ada admin, set variabel $checker ke 1, jika tidak, ke 0
        $checker = $adminAvailability ? 1 : 0;

        // Tampilkan halaman login dengan variabel hasAdmin yang mengindikasikan ketersediaan admin
        return view('loginRegist/login/login', ['title' => 'Login', 'hasAdmin' => $checker]);
    }

    /**
     * Menampilkan halaman registrasi.
     *
     * @return \Illuminate\View\View
     */
    public function viewRegister()
    {
        return view('loginRegist/register/register', ['title' => 'Register']);
    }

    /**
     * Menangani proses registrasi pengguna baru.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi data yang dikirimkan oleh form registrasi
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirm-password' => 'required|min:8|same:password',
            'nis' => 'required',
        ]);

        try {
            // Ambil data siswa berdasarkan NIS
            $dataSiswa = DataSiswa::where('nis', $request->nis)->first();

            if (!$dataSiswa) {
                return back()->with('nis-error', 'NIS (Nomor Induk Siswa) Tidak ditemukan');
            }

            // Jika siswa sudah memiliki akun
            if ($dataSiswa->punya_akun == 1) {
                return back()->with('nis-error', 'NIS (Nomor Induk Siswa) Sudah digunakan.');
            }

            // Buat user baru
            $user = User::create([
                'name' => $dataSiswa->name,
                'kelas_id' => $dataSiswa->kelas_id,
                'gambar' => null,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign role Siswa menggunakan Spatie
            $user->assignRole('Siswa');

            // Update status punya akun siswa
            $dataSiswa->update([
                'user_id' => $user->id,
                'punya_akun' => 1,
            ]);

            // Buat data kontak untuk user (jika ada no telp)
            if ($request->noTelp) {
                Contact::create([
                    'user_id' => $user->id, 
                    'no_telp' => $request->noTelp
                ]);
            }

            // Redirect ke halaman login dengan pesan sukses
            return redirect('/login')->with('register-success', 'Registrasi Berhasil');

        } catch (\Exception $e) {
            return back()->with('nis-error', 'Terjadi kesalahan dalam proses registrasi: ' . $e->getMessage());
        }
    }

    /**
     * Menangani proses otentikasi pengguna.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        // Validasi email dan password yang dikirimkan oleh form login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba untuk melakukan otentikasi dengan email dan password
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Redirect berdasarkan role menggunakan Spatie
            if ($user->hasRole('Admin')) {
                return redirect()->intended('/dashboard');
            } elseif ($user->hasRole('Pengajar')) {
                return redirect()->intended('/dashboard');
            } elseif ($user->hasRole('Siswa')) {
                return redirect()->intended('/home');
            }

            // Default fallback
            return redirect()->intended('/dashboard');
        } else {
            // Jika otentikasi gagal, kirim pesan error
            return back()->with('login-error', 'Email atau Kata Sandi salah!');
        }
    }

    /**
     * Menangani proses keluar (logout) pengguna.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        if (auth()->check()) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect ke halaman login dengan pesan logout sukses
            return redirect(route('login'))->with('logout-success', 'Berhasil keluar!');
        } else {
            // Jika tidak ada pengguna yang terautentikasi, redirect ke halaman login
            return redirect(route('login'));
        }
    }

    /**
     * Menampilkan halaman lupa kata sandi.
     *
     * @return \Illuminate\View\View
     */
    public function viewForgotPassword()
    {
        return view('loginRegist/forgot-password/forgotPassword', ['title' => 'Forgot Password']);
    }
}