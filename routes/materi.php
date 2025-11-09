<?php

use App\Http\Controllers\Materi\MateriController;
use App\Http\Controllers\Materi\MateriFileController;
use Illuminate\Support\Facades\Route;

// ==========================
//  MODUL MATERI
// ==========================

Route::middleware('auth')->controller(MateriController::class)
    ->prefix('materi')->name('materi.')->group(function () {

    Route::middleware('role:Pengajar')->group(function () {
        Route::get('/kelas-mapel/{kelasMapel}/create', 'create')->name('create');
        Route::post('/kelas-mapel/{kelasMapel}', 'store')->name('store');
        Route::get('/{materi}/edit', 'edit')->name('edit');
        Route::put('/{materi}', 'update')->name('update');
        Route::delete('/{materi}', 'destroy')->name('destroy');
       
    });

    Route::get('/{materi}', 'show')->name('show');
});

// File Materi (upload / hapus)
Route::prefix('materi')->name('materi.')->controller(MateriFileController::class)->group(function () {

    //  Hanya Pengajar yang boleh upload dan hapus
    Route::middleware(['auth', 'role:Pengajar'])->group(function () {
        Route::post('{materi}/upload-file', 'store')->name('uploadFile');
        Route::delete('{materi}/delete-destroy-file', 'destroy')->name('destroyFile');
    });

    //  Semua user login (Siswa, Pengajar, Admin, Wakur) boleh preview file
    Route::middleware('auth')->group(function () {
        Route::get('{materi}/file/{filename}', 'showFile')
            ->where('filename', '.*')
            ->name('previewFile');
    });
});
