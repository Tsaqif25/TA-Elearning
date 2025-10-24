<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengumumanController;

Route::middleware('auth')
    ->controller(PengumumanController::class)
    ->prefix('pengumuman')
    ->name('pengumuman.')
    ->group(function () {

        // 🔹 Semua user (Wakur, Pengajar, Siswa)
        Route::get('/', 'index')->name('index');

        // 🔹 Hanya WAKUR
        Route::middleware('role:Wakur')->group(function () {
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{pengumuman}/edit', 'edit')->name('edit');
            Route::put('/{pengumuman}', 'update')->name('update');
            Route::delete('/{pengumuman}', 'destroy')->name('destroy');
        });

        // 🔹 HARUS DITARUH PALING BAWAH
        Route::get('/{pengumuman}', 'show')->name('show');
    });
