<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginRegistController;

// ==========================
// LOGIN,REGISTER,LOGOUT
// ==========================

Route::get('/', [LandingController::class, 'index'])->name('landing');

// ==========================
// LOGIN, REGISTER, LOGOUT
// ==========================

//  ROUTE UNTUK PENGGUNA YANG BELUM LOGIN (GUEST)
Route::middleware('guest')
    ->controller(LoginRegistController::class)
    ->group(function () {
        Route::get('/login', 'viewLogin')->name('login');
        Route::get('/register', 'viewRegister')->name('register');

        // Saat sesi login berakhir
        Route::get('/authenticate', fn() =>
            redirect()->route('login')->with('login-error', 'Sesi login telah berakhir, silakan login kembali')
        )->name('authenticate.get');

        Route::post('/register', 'register')->name('register.store');
        Route::post('/authenticate', 'authenticate')->name('authenticate');
    });

//  ROUTE UNTUK PENGGUNA YANG SUDAH LOGIN (AUTH)
Route::middleware('auth')
    ->controller(LoginRegistController::class)
    ->group(function () {
        Route::post('/logout', 'logout')->name('logout');
    });

