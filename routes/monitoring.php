<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\Materi\MateriFileController;


Route::get('/monitoring-guru',[MonitoringController::class,'monitoringGuru'])->name('monitoring.guru');
Route::get('/monitoring-guru/{guru}',[MonitoringController::class,'detailGuru'])->name('monitoring.guru.detail');


Route::get('/materi/{materi}/file/{filename}', 
    [MateriFileController::class, 'downloadFile'])
    ->name('materi.file.download');

