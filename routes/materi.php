<?php

use App\Http\Controllers\Materi\MateriController;
use App\Http\Controllers\Materi\MateriFileController;
use Illuminate\Support\Facades\Route;

// ==========================
//  MODUL MATERI
// ==========================


Route::middleware('auth')->group(function () {

    // ==========================
    // FILE MATERI (UPLOAD, DOWNLOAD, PREVIEW)
    // ==========================
    Route::prefix('materi')->name('materi.')->controller(MateriFileController::class)->group(function () {

        //  PREVIEW FILE
        Route::get('{materi}/file/{filename}', 'showFile')
            ->where('filename', '.*')
            ->name('previewFile');

        //  DOWNLOAD FILE
        Route::get('{materi}/download/{filename}', 'downloadFile')
            ->name('downloadFile');

        //  UPLOAD & HAPUS FILE (khusus pengajar)
        Route::middleware('role:Pengajar')->group(function () {
            Route::post('{materi}/upload-file', 'store')->name('uploadFile');
            Route::delete('{materi}/delete-file', 'destroy')->name('destroyFile');
        });
    });

    // ==========================
    // MATERI CRUD
    // ==========================
    Route::controller(MateriController::class)
        ->prefix('materi')
        ->name('materi.')
        ->group(function () {

        Route::middleware('role:Pengajar')->group(function () {
            Route::get('/kelas-mapel/{kelasMapel}/create', 'create')->name('create');
            Route::post('/kelas-mapel/{kelasMapel}', 'store')->name('store');
            Route::get('/{materi}/edit', 'edit')->name('edit');
            Route::put('/{materi}', 'update')->name('update');
            Route::delete('/{materi}', 'destroy')->name('destroy');
        });

        Route::get('/{materi}', 'show')->name('show');
    });
});

