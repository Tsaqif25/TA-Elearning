<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tugas\FileController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Materi\MateriController;
use App\Http\Controllers\SurveyController;
// use App\Http\Controllers\Diskusi\DiskusiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\KelasMapelController;
use App\Http\Controllers\Materi\MateriFileController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\LoginRegistController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\StudentAnswerController;
use App\Http\Controllers\Tugas\TugasFileController;
use App\Http\Controllers\Tugas\TugasController;
use App\Http\Controllers\Tugas\TugasSubmitController;
use App\Http\Controllers\Ujian\UjianStudentController ;
use App\Http\Controllers\Ujian\SoalManagementController;
use App\Http\Controllers\Ujian\UjianEvaluationController;
use App\Http\Controllers\Ujian\UjianManagementController ;



Route::get('/', function () {
    return redirect('/dashboard');
});


Route::controller(LoginRegistController::class)->group(function () {
    // Get
    Route::get('/login', 'viewLogin')->middleware('guest')->name('login');
    Route::get('/register', 'viewRegister')->middleware('guest')->name('register');
    Route::get('/forgot-password', 'viewForgotPassword')->middleware('guest')->name('forgotPassword');
    Route::get('/authenticate', function() {
    return redirect()->route('login')->with('login-error', 'Sesi login telah berakhir, silakan login kembali');
})->name('authenticate.get');
    // Post
    Route::post('/vallidate-register', 'register')->middleware('guest')->name('validate');
  Route::post('/authenticate', [LoginRegistController::class, 'authenticate'])->middleware('guest')->name('authenticate');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

// Dashboard
Route::middleware('auth')->controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'viewDashboard')->name('dashboard');
    Route::get('/home', 'viewHome')->name('home');
});


// KelasMapel
Route::middleware('auth')->controller(KelasMapelController::class)->group(function () {
    // Umum (semua user login bisa akses)
    Route::get('/kelas-mapel/{mapel}/{kelas}', 'viewKelasMapel')->name('viewKelasMapel');
    Route::get('/save-image-temp', 'saveImageTemp')->name('saveImageTemp');

    // Khusus Admin
    Route::middleware('role:Admin')->group(function () {
        Route::get('/activity', 'viewAllActivities')->name('activity');
    });

    // Khusus Pengajar
    Route::middleware('role:Pengajar')->group(function () {
        Route::get('/export-nilai-tugas', 'exportNilaiTugas')->name('exportNilaiTugas');
        Route::get('/export-nilai-ujian', 'exportNilaiUjian')->name('exportNilaiUjian');
    });
});

    Route::middleware(['auth','role:Pengajar'])
    ->prefix('ujian')
    ->name('ujian.')
    ->group(function(){
    // CRUD Ujian
        Route::controller(UjianManagementController::class)->group(function(){

        //  Route::get('/kelas-mapel/{kelasMapel}/manage', 'index')->name('manage');
        Route::get('/kelas-mapel/{kelasMapel}/create', 'create')->name('create');
        Route::post('/kelas-mapel/{kelasMapel}', 'store')->name('store');
        Route::get('/{ujian}/edit', 'edit')->name('edit');
        Route::put('/{ujian}', 'update')->name('update');
        Route::delete('/{ujian}', 'destroy')->name('destroy');
        
        });
        Route::controller(SoalManagementController::class)
        ->prefix('{ujian}/soal')
        ->name('soal.')
        ->group(function(){
            Route::get('manage','show')->name('manage');
            Route::get('create','createSoal')->name('create');
            Route::post('store','storeSoal')->name('store');
        });
        Route::controller(UjianEvaluationController::class)->group(function(){
            Route::get('{ujian}/siswa','listStudent')->name('students');
        });
    });


Route::middleware(['auth','role:Siswa'])
    ->prefix('ujian')
    ->name('ujian.')
    ->controller(UjianStudentController::class)
    ->group(function(){
        Route::get('access/{id}{kelas}{mapel}','ujianAccess')->name('access');
        Route::get('start/{id}','startUjian')->name('start');
        Route::get('do/{ujian}','siswaUjian')->name('userUjian');
        Route::post('{ujian}/answer/{soal}','storeAnswer')->name('answer.store');
        Route::get('{ujian}/finished','learningFinished')->name('learning.finished');
        Route::get('{ujian}/raport','learningRapport')->name('learning.raport');

    });



Route::middleware('auth')->controller(MateriController::class)
    ->prefix('materi')
    ->name('materi.')
    ->group(function () {

        Route::middleware('role:Pengajar')->group(function () {
            Route::get('/kelas-mapel/{kelasMapel}/create', 'create')->name('create');
            Route::post('/kelas-mapel/{kelasMapel}', 'store')->name('store');
            Route::get('/{materi}/edit', 'edit')->name('edit');
            Route::put('/{materi}', 'update')->name('update');
            Route::delete('/{materi}', 'destroy')->name('destroy');
        });

        Route::get('/{materi}', 'show')->name('show');
    });




 Route::middleware(['auth', 'role:Pengajar'])
    ->prefix('materi')
    ->name('materi.')
    ->controller(MateriFileController::class)
    ->group(function () {
        Route::post('{materi}/upload-file', 'store')->name('uploadFile');
        Route::delete('{materi}/delete-destroy-file', 'destroy')->name('destroyFile');
    });



// Pengumuman
Route::middleware('auth')->controller(PengumumanController::class)->group(function () {
    // Umum (semua user login bisa akses)
    Route::get('/pengumuman', 'viewPengumuman')->name('viewPengumuman');

    // Khusus Pengajar
    Route::middleware('role:Pengajar')->group(function () {
        Route::get('/pengumuman/add/{kelas}', 'viewCreatePengumuman')->name('viewCreatePengumuman');
        Route::get('/pengumuman/update/{pengumuman}', 'viewUpdatePengumuman')->name('viewUpdatePengumuman');

        Route::post('/store-pengumuman', 'createPengumuman')->name('createPengumuman');
        Route::post('/update-pengumuman', 'updatePengumuman')->name('updatePengumuman');
        Route::post('/destroy-pengumuman', 'destroyPengumuman')->name('destroyPengumuman');
    });
});

// =========================
// 📌 TugasController (utama)
// =========================
 Route::middleware('auth')->controller(TugasController::class)->group(function () {
     // Semua user login
     Route::get('/tugas/{tugas}', 'viewTugas')->name('viewTugas');
   //   Khusus Pengajar
   Route::middleware('role:Pengajar')->group(function () {
    Route::get('/tugas/kelas-mapel/{kelasMapel}/create', 'viewCreateTugas')->name('viewCreateTugas');
    Route::post('/tugas/kelas-mapel/{kelasMapel}', 'createTugas')->name('createTugas');
    Route::get('/tugas/{tugas}/edit', 'viewUpdateTugas')->name('viewUpdateTugas');
    Route::put('/tugas/{tugas}', 'updateTugas')->name('updateTugas');
    Route::post('/tugas/update-nilai/{tugas}', 'siswaUpdateNilai')->name('siswaUpdateNilai');
    Route::delete('/tugas/{tugas}', 'destroyTugas')->name('tugas.destroy');
});

//    Khusus Admin
    Route::middleware('role:Admin')->group(function () {
        Route::get('/tugasAdmin', 'viewTugasAdmin')->name('viewTugasAdmin');
    });
});
// // ============================
// // 📌 TugasFileController (soal)
// // ============================
Route::middleware(['auth', 'role:Pengajar'])
    ->prefix('tugas/file')
    ->name('tugas.file.')
    ->controller(TugasFileController::class)
    ->group(function () {
        Route::post('upload', 'store')->name('upload');         
        Route::delete('delete', 'destroy')->name('delete');      
    });


// // ==================================
// // 📌 TugasSubmitFileController (jawaban siswa)
// // ==================================
 Route::middleware('auth')
     ->controller(TugasSubmitController::class)
     ->group(function () {
          Route::post('/submit-tugas/{tugas}', 'submitTugas')->name('submitTugas');
         Route::post('/submit-tugas-file', 'submitFileTugas')->name('submitFileTugas');
         Route::delete('/destroy-tugas-submit-file', 'destroyFileSubmit')->name('destroyFileSubmit');
     });


Route::controller(FileController::class)->group(function () {
    Route::get('/getFile/{namaFile}', 'getFile')->middleware('auth')->name('getFile');
    Route::get('/getFileTugas/{namaFile}', 'getFileTugas')->middleware('auth')->name('getFileTugas');
    Route::get('/getFileUser/{namaFile}', 'getFileUser')->middleware('auth')->name('getFileUser');
});


