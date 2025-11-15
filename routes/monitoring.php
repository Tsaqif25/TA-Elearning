<?php

use App\Http\Controllers\MonitoringController;
use Illuminate\Support\Facades\Route;


Route::get('/monitoring-guru',[MonitoringController::class,'monitoringGuru'])->name('monitoring.guru');
Route::get('/monitoring-guru/{guru}',[MonitoringController::class,'detailGuru'])->name('monitoring.guru.detail');
