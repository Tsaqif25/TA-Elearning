<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalyticsController;

Route::middleware(['auth', 'role:Wakur'])->prefix('wakur')->name('wakur.')->group(function () {
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
});
