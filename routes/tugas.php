<?php

use App\Http\Controllers\Tugas\TugasController;
use App\Http\Controllers\Tugas\TugasFileController;
use App\Http\Controllers\Tugas\TugasSubmitController;
use Illuminate\Support\Facades\Route;

// ==========================
//  MODUL TUGAS
// ==========================

// TugasController
Route::middleware('auth')->controller(TugasController::class)->group(function () {
    Route::get('/tugas/{tugas}', 'viewTugas')->name('viewTugas');

    Route::middleware('role:Pengajar')->group(function () {
        Route::get('/tugas/kelas-mapel/{kelasMapel}/create', 'viewCreateTugas')->name('viewCreateTugas');
        Route::post('/tugas/kelas-mapel/{kelasMapel}', 'createTugas')->name('createTugas');
        Route::get('/tugas/{tugas}/edit', 'viewUpdateTugas')->name('viewUpdateTugas');
        Route::put('/tugas/{tugas}', 'updateTugas')->name('updateTugas');
        Route::post('/tugas/update-nilai/{tugas}', 'siswaUpdateNilai')->name('siswaUpdateNilai');
        Route::delete('/tugas/{tugas}', 'destroyTugas')->name('tugas.destroy');
    });

    Route::middleware('role:Admin')->group(function () {
        Route::get('/tugasAdmin', 'viewTugasAdmin')->name('viewTugasAdmin');
    });
});

// File Tugas
Route::middleware(['auth', 'role:Pengajar'])
    ->prefix('tugas')->name('tugas.')
    ->controller(TugasFileController::class)
    ->group(function () {
        Route::post('{tugas}/upload-file', 'store')->name('uploadFile');
        Route::delete('{tugas}/delete-file', 'destroy')->name('deleteFile');
    });

// Submit Tugas (Siswa)
Route::middleware('auth')->controller(TugasSubmitController::class)->group(function () {
    Route::get('/lihat-tugas/{tugas}', 'viewTugasSiswa')->name('lihatTugas');
    Route::post('/submit-tugas/{tugas}', 'submitTugas')->name('submitTugas');
    Route::post('/submit-tugas-file', 'submitFileTugas')->name('submitFileTugas');
    Route::delete('/destroy-tugas-submit-file', 'destroyFileSubmit')->name('destroyFileSubmit');
});


