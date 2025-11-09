<?php

use App\Http\Controllers\KelasMapelController;
use Illuminate\Support\Facades\Route;

// ==========================
//  MODUL KELAS & MAPEL
// ==========================

Route::middleware('auth')->controller(KelasMapelController::class)->group(function () {
    // Semua user login
    Route::get('/kelas-mapel/{mapel}/{kelas}', 'viewKelasMapel')->name('viewKelasMapel');
 
});
