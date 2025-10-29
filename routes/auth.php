<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginRegistController;

// ==========================
// LOGIN,REGISTER,LOGOUT
// ==========================






Route::get('/', [LandingController::class, 'index'])->name('landing');


Route::controller(LoginRegistController::class)->group(function () {
    // Halaman GET
    Route::get('/login', 'viewLogin')->middleware('guest')->name('login');
    Route::get('/register', 'viewRegister')->middleware('guest')->name('register');
    Route::get('/forgot-password', 'viewForgotPassword')->middleware('guest')->name('forgotPassword');
    Route::get('/authenticate', fn() =>
        redirect()->route('login')->with('login-error', 'Sesi login telah berakhir, silakan login kembali')
    )->name('authenticate.get');

    // Aksi POST
    // Route::post('/vallidate-register', 'register')->middleware('guest')->name('validate');
    // Route::post('/authenticate', [LoginRegistController::class, 'authenticate'])->middleware('guest')->name('authenticate');
    // Route::post('/logout', 'logout')->middleware('auth')->name('logout');

    // Aksi POST
Route::post('/register', 'register')->middleware('guest')->name('register.store');
Route::post('/authenticate', 'authenticate')->middleware('guest')->name('authenticate');
Route::post('/logout', 'logout')->middleware('auth')->name('logout');

});
