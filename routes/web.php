<?php

use Illuminate\Support\Facades\Route;

// ==========================
//  ROUTE UTAMA APLIKASI
// ==========================

Route::get('/', function () {
    return redirect('/dashboard');
});
require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
require __DIR__.'/kelasMapel.php';
require __DIR__.'/materi.php';
require __DIR__.'/tugas.php';
require __DIR__.'/ujian.php';
require __DIR__.'/pengumuman.php';
require __DIR__.'/file.php';
