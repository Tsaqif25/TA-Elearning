<?php

use App\Http\Controllers\Ujian\UjianStudentController;
use App\Http\Controllers\Ujian\UjianManagementController;
use App\Http\Controllers\Ujian\SoalManagementController;
use App\Http\Controllers\Ujian\UjianEvaluationController;
use Illuminate\Support\Facades\Route;

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
                Route::get('create','createSoal')->name('create');
                Route::post('store','storeSoal')->name('store');
                Route::get('edit/{soal}', 'editSoal')->name('edit');
                Route::put('update/{soal}', 'updateSoal')->name('update');
                Route::delete('delete/{soal}', 'destroySoal')->name('destroy');
            });

        Route::controller(UjianEvaluationController::class)->group(function(){
            Route::get('{ujian}/siswa','listStudent')->name('students');
        });
    });

// Siswa
Route::middleware(['auth','role:Siswa'])
    ->prefix('ujian')->name('ujian.')
    ->controller(UjianStudentController::class)
    ->group(function(){
        Route::get('access/{ujian}/{kelas}/{mapel}', 'ujianAccess')->name('access');
        Route::get('{ujian}/start', 'startUjian')->name('start');
        Route::get('{ujian}/finished', 'learningFinished')->name('learning.finished');
        Route::get('{ujian}/raport', 'learningRapport')->name('learning.raport');
        Route::get('{ujian}/{soal}', 'siswaUjian')->name('userUjian');
        Route::post('{ujian}/{soal}/submit', 'storeAnswer')->name('answer.store');
    });
