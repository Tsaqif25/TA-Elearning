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
Route::middleware(['auth', 'role:Pengajar'])
    ->prefix('materi')->name('materi.')
    ->controller(MateriFileController::class)
    ->group(function () {
        Route::post('{materi}/upload-file', 'store')->name('uploadFile');
        Route::delete('{materi}/delete-destroy-file', 'destroy')->name('destroyFile');
    });
