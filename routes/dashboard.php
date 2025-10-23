<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// ==========================
//  DASHBOARD DAN HOME
// ==========================

Route::middleware('auth')->controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'viewDashboard')->name('dashboard');
    Route::get('/home', 'viewHome')->name('home');
});
