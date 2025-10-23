<?php

use App\Http\Controllers\PengumumanController;
use Illuminate\Support\Facades\Route;

// ==========================
//  MODUL PENGUMUMAN
// ==========================

Route::middleware('auth')->controller(PengumumanController::class)->group(function () {
    Route::get('/pengumuman', 'viewPengumuman')->name('viewPengumuman');

    Route::middleware('role:Pengajar')->group(function () {
        Route::get('/pengumuman/add/{kelas}', 'viewCreatePengumuman')->name('viewCreatePengumuman');
        Route::get('/pengumuman/update/{pengumuman}', 'viewUpdatePengumuman')->name('viewUpdatePengumuman');
        Route::post('/store-pengumuman', 'createPengumuman')->name('createPengumuman');
        Route::post('/update-pengumuman', 'updatePengumuman')->name('updatePengumuman');
        Route::post('/destroy-pengumuman', 'destroyPengumuman')->name('destroyPengumuman');
    });
});
