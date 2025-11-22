<?php

use App\Http\Controllers\Tugas\TugasController;
use App\Http\Controllers\Tugas\TugasFileController;
use App\Http\Controllers\Tugas\TugasSubmitController;
use App\Http\Controllers\TugasDiskusiController;
use Illuminate\Support\Facades\Route;

// ==========================
//  MODUL TUGAS
// ==========================


Route::middleware(['auth','role:Pengajar'])
->prefix('guru/tugas')
->controller(TugasController::class)
->group(function(){


    Route::get('{kelasMapel}/create','viewCreateTugas')->name('guru.tugas.createView');
    Route::post('{kelasMapel}','createTugas')->name('guru.tugas.create');
    Route::get('{tugas}','viewTugas')->name('guru.tugas.view');
    Route::get('{tugas}/edit','viewUpdateTugas')->name('guru.tugas.edit');
    Route::put('{tugas}','updateTugas')->name('guru.tugas.update');
    Route::delete('{tugas}','destroyTugas')->name('guru.tugas.destroy');
    Route::post('{tugas}/nilai','siswaUpdateNilai')->name('guru.tugas.nilai.update');
    // Route::post('{tugas}/komentar-store','storeKomentar')->name('guru.tugas.komentar.store');
     Route::get('{kelasMapel}/rekap', 'rekapNilaiTugas')
        ->name('guru.tugas.rekap');
});
// File Tugas Dari Guru
Route::middleware(['auth' ,'role:Pengajar' ])
->prefix('guru/tugas')
->controller(TugasFileController::class)
->group(function(){
  Route::post('{tugas}/upload-file', 'store')->name('guru.tugas.file.upload');
        Route::delete('{tugas}/delete-file', 'destroy')->name('guru.tugas.file.delete');
});


Route::middleware(['auth','role:Siswa'])
->prefix('siswa/tugas')
->controller(TugasSubmitController::class)
->group(function(){
 Route::delete('delete-file','deleteFile')->name('siswa.tugas.file.delete');

    Route::post('upload-file','submitFileTugas')->name('siswa.tugas.file');

    Route::post('{tugas}/submit','submitTugas')->name('siswa.tugas.submit');

    // INI HARUS PALING BAWAH
    Route::get('{tugas}','viewTugasSiswa')->name('siswa.tugas.view');
    // Route::post('{tugas}/komentar-siswa','komentarSiswa')->name('siswa.tugas.komentar.store');
});

Route::middleware(['auth','role:Pengajar'])
->prefix('guru/tugas')->name('guru.tugas.')
->controller(TugasDiskusiController::class)
->group(function(){
      Route::get('{tugas}/diskusi/{siswa}','index')->name('diskusi');
      Route::post('{tugas}/diskusi/{siswa}','store')->name('diskusi.store');
});

Route::middleware(['auth','role:Siswa'])
    ->prefix('siswa/tugas')->name('siswa.tugas.')
    ->controller(TugasDiskusiController::class)
    ->group(function(){
        Route::get('{tugas}/diskusi', 'indexSiswa')->name('diskusi');
        Route::post('{tugas}/diskusi', 'storeSiswa')->name('diskusi.store');
    });





