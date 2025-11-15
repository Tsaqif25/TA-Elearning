<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// ==========================
//  DASHBOARD DAN HOME
// ==========================

Route::middleware('auth')->controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'viewDashboard')->name('dashboard');
    Route::get('/home', 'viewHome')->name('home');
    Route::get('/daftarsiswa/{kelasId}', 'viewSiswa')->name('siswa');
});

// Route::middleware(['auth', 'role:Wakur'])->group(function () {
//     Route::get('/wakur/dashboard', [DashboardController::class, 'viewWakurDashboard'])
//         ->name('wakur.dashboard');
// });

Route::middleware(['auth','role:Wakur'])->controller(DashboardController::class)->group(function(){
    Route::get('/wakur/dashboard',' wakurDashboard')->name('wakur.dashboard');
});
