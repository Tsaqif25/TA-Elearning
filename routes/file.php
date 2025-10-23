<?php

use App\Http\Controllers\Tugas\FileController;
use Illuminate\Support\Facades\Route;

// ==========================
//  FILE HANDLER (AKSES FILE)
// ==========================

Route::controller(FileController::class)->group(function () {
    Route::get('/getFile/{namaFile}', 'getFile')->middleware('auth')->name('getFile');
    Route::get('/getFileTugas/{namaFile}', 'getFileTugas')->middleware('auth')->name('getFileTugas');
    Route::get('/getFileUser/{namaFile}', 'getFileUser')->middleware('auth')->name('getFileUser');
});
