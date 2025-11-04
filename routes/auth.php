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

        Route::get('/authenticate', 'expiredSession')->name('authenticate.get');

        Route::post('/authenticate', 'authenticate')->name('authenticate');
    });

Route::middleware('auth')
    ->controller(LoginRegistController::class)
    ->group(function () {
        Route::post('/logout', 'logout')->name('logout');
    });