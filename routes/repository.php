<?php

use App\Http\Controllers\RepositoryController;
use App\Http\Controllers\RepositoryFileController;
use Illuminate\Support\Facades\Route;

// ==========================
//  MODUL REPOSITORY
// ==========================
Route::middleware('auth')
    ->controller(RepositoryController::class)
    ->prefix('repository')
    ->name('repository.')
    ->group(function () {

        Route::middleware('role:Pengajar|Admin|Wakur')->group(function () {
            Route::get('/', 'index')->name('index');               
            Route::get('/create', 'create')->name('create');       
            Route::post('/', 'store')->name('store');              // simpan data baru
            // tampil detail repository
            Route::get('/{repository}/edit', 'edit')->name('edit');// form edit
            Route::put('/{repository}', 'update')->name('update'); // simpan perubahan
            Route::delete('/{repository}', 'destroy')->name('destroy'); // hapus repository
        });
    });

// ==========================
//  MODUL FILE REPOSITORY (UPLOAD / HAPUS)
// ==========================
Route::middleware(['auth', 'role:Pengajar|Admin|Wakur'])
    ->prefix('repository')
    ->name('repository.')
    ->controller(RepositoryFileController::class)
    ->group(function () {
        Route::post('{repository}/upload-file', 'store')->name('uploadFile');         // Upload via Dropzone
        Route::delete('{repository}/delete-destroy-file', 'destroy')->name('destroyFile'); // Hapus file
    });



// ==========================
// HALAMAN PUBLIK (TANPA LOGIN)
// ==========================
Route::get('/repository-public', [RepositoryController::class, 'public'])
    ->name('repository.public');

Route::get('/repository-public/{repository}', [RepositoryController::class, 'show'])
    ->name('repository.showPublic');

