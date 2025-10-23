<?php

use App\Http\Controllers\LoginRegistController;
use Illuminate\Support\Facades\Route;

// ==========================
// LOGIN,REGISTER,LOGOUT
// ==========================

Route::controller(LoginRegistController::class)->group(function () {
    // Halaman GET
    Route::get('/login', 'viewLogin')->middleware('guest')->name('login');
    Route::get('/register', 'viewRegister')->middleware('guest')->name('register');
    Route::get('/forgot-password', 'viewForgotPassword')->middleware('guest')->name('forgotPassword');
    Route::get('/authenticate', fn() =>
        redirect()->route('login')->with('login-error', 'Sesi login telah berakhir, silakan login kembali')
    )->name('authenticate.get');

    // Aksi POST
    Route::post('/vallidate-register', 'register')->middleware('guest')->name('validate');
    Route::post('/authenticate', [LoginRegistController::class, 'authenticate'])->middleware('guest')->name('authenticate');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});
