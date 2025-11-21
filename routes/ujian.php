<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ujian\UjianReportController;


use App\Http\Controllers\Ujian\UjianStudentController;
use App\Http\Controllers\Ujian\SoalManagementController;
use App\Http\Controllers\Ujian\UjianEvaluationController;
use App\Http\Controllers\Ujian\UjianManagementController;

// ==========================
//MODUL UJIAN / QUIZ
// ==========================

// Pengajar
Route::middleware(['auth','role:Pengajar'])
    ->prefix('ujian')->name('ujian.')
    ->group(function(){
        Route::controller(UjianManagementController::class)->group(function(){
            Route::get('/kelas-mapel/{kelasMapel}/create', 'create')->name('create');
            Route::post('/kelas-mapel/{kelasMapel}', 'store')->name('store');
            Route::get('/{ujian}/edit', 'edit')->name('edit');
            Route::put('/{ujian}', 'update')->name('update');
            Route::delete('/{ujian}', 'destroy')->name('destroy');
        });

        Route::controller(SoalManagementController::class)
            ->prefix('{ujian}/soal')->name('soal.')
            ->group(function(){
                Route::get('manage','show')->name('manage');
                  Route::get('preview','previewAll')->name('preview');
                Route::get('create','createSoal')->name('create');
                Route::post('store','storeSoal')->name('store');
                Route::get('edit/{soal}', 'editSoal')->name('edit');
                Route::put('update/{soal}', 'updateSoal')->name('update');
                Route::delete('delete/{soal}', 'destroySoal')->name('destroy');
                  Route::get('import', 'importView')->name('importView');
        Route::post('import', 'import')->name('import');
                
            });




        Route::controller(UjianEvaluationController::class)->group(function(){
            Route::get('{ujian}/siswa','listStudent')->name('students');
        });
    });

// Siswa
// Route::middleware(['auth','role:Siswa'])
//     ->prefix('ujian')->name('ujian.')
//     ->controller(UjianStudentController::class)
//     ->group(function(){
//         Route::get('access/{ujian}/{kelas}/{mapel}', 'ujianAccess')->name('access');
//         Route::get('{ujian}/start', 'startUjian')->name('start');
//         Route::get('{ujian}/finished', 'learningFinished')->name('learning.finished');
//         Route::get('{ujian}/raport', 'learningRapport')->name('learning.raport');
//         Route::get('{ujian}/{soal}', 'siswaUjian')->name('userUjian');
//         Route::post('{ujian}/{soal}/submit', 'storeAnswer')->name('answer.store');
//     });


Route::middleware(['auth','role:Siswa'])
    ->prefix('ujian')->name('ujian.')
    ->controller(UjianStudentController::class)
    ->group(function() {

        // halaman sebelum mulai, info ujian
        Route::get('{ujian}/access', 'ujianAccess')->name('access');

        // buat attempt
        Route::get('{ujian}/start', 'start')->name('start');

        Route::get('attempt/{attempt}/finished', 'finish')->name('finish');
        Route::get('attempt/{attempt}/raport',  'result')->name('hasil');

        // baru route yang pakai {nomor}
        Route::get('attempt/{attempt}/{nomor}', 'siswaUjian')->name('show');

        // simpan jawaban
        Route::post('attempt/{attempt}/{soal}/submit', 'submit')->name('answer.store');

        Route::post('update-timer/{attempt}', 'updateTimer')->name('update_timer');
    });


    Route::middleware(['auth','role:Pengajar'])
    ->prefix('guru/ujian')->name('guru.ujian.')
    ->controller(UjianReportController::class)
    ->group(function(){

        Route::get('/report', 'index')->name('report.index');

        Route::get('/report/{ujian}', 'show')->name('report.show');
});



