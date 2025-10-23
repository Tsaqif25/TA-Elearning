<?php

use App\Http\Controllers\KelasMapelController;
use Illuminate\Support\Facades\Route;

// ==========================
//  MODUL KELAS & MAPEL
// ==========================

Route::middleware('auth')->controller(KelasMapelController::class)->group(function () {
    // Semua user login
    Route::get('/kelas-mapel/{mapel}/{kelas}', 'viewKelasMapel')->name('viewKelasMapel');
    Route::get('/save-image-temp', 'saveImageTemp')->name('saveImageTemp');

    // Khusus Admin
    Route::middleware('role:Admin')->group(function () {
        Route::get('/activity', 'viewAllActivities')->name('activity');
    });
});
