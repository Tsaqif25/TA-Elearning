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
use App\Http\Controllers\Diskusi\DiskusiController;
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



// Route::middleware(['auth', 'role:Pengajar'])
//     ->prefix('ujian')
//     ->name('ujian.')
//     ->controller(UjianController::class)
//     ->group(function () {

//         // 🟢 CRUD Ujian
//         Route::get('manage/{kelas}/{mapel}', 'index')->name('manage');
//         Route::get('add/{kelas}/{mapel}', 'create')->name('add');
//         Route::post('store', 'store')->name('store');
//         Route::post('update', 'updateUjian')->name('update');
//       Route::delete('destroy', 'destroy')->name('destroy');

//         // 🧩 Soal Ujian
//         Route::prefix('{ujian}/soal')->name('soal.')->group(function () {
//             Route::get('manage', 'show')->name('manage');
//             Route::get('create', 'createSoal')->name('create');
//             Route::post('store', 'storeSoal')->name('store');
//         });

//         // 👥 Daftar siswa yang ikut ujian
//         Route::get('{ujian}/students', 'listStudent')->name('students');
//     });


// // 🔹 Akses siswa (pisah karena role-nya berbeda)
// Route::middleware(['auth', 'role:Siswa'])
//     ->prefix('ujian')
//     ->name('ujian.')
//     ->controller(UjianController::class)
//     ->group(function () {
//         Route::get('access/{id}/{kelas}/{mapel}', 'ujianAccess')->name('access');
//         Route::get('start/{id}', 'startUjian')->name('start');
//         Route::get('do/{ujian}', 'userUjian')->name('userUjian');
//         Route::post('{ujian}/answer/{soal}', 'storeAnswer')->name('answer.store');
//         Route::get('{ujian}/finished', 'learningFinished')->name('learning.finished');
//         Route::get('{ujian}/rapport', 'learningRapport')->name('learning.rapport');
//     });



    Route::middleware(['auth','role:Pengajar'])
    ->prefix('ujian')
    ->name('ujian.')
    ->group(function(){
    // CRUD Ujian
        Route::controller(UjianManagementController::class)->group(function(){
            Route::get('manage/{kelas}/{mapel}','index')->name('manage');
            Route::get('add/{kelas}/{mapel}','create')->name('add');
            Route::post('store','store')->name('store');
            Route::post('update','updateUjian')->name('update');
            Route::delete('destroy','destroy')->name('destroy');
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

// Diskusi
Route::middleware('auth')->controller(DiskusiController::class)->group(function () {
// Umum (semua user login bisa akses)
Route::get('/diskusi/{diskusi}', 'viewDiskusi')
    ->name('viewDiskusi');

// Khusus Pengajar
Route::middleware('role:Pengajar')->group(function () {
    Route::get('/diskusi/add/{kelasMapel}', 'viewCreateDiskusi')
        ->name('viewCreateDiskusi');

    Route::get('/diskusi/update/{diskusi}', 'viewUpdateDiskusi')
        ->name('viewUpdateDiskusi');

    Route::post('/store-diskusi', 'createDiskusi')
        ->name('createDiskusi');

    Route::post('/update-diskusi', 'updateDiskusi')
        ->name('updateDiskusi');

  Route::delete('/diskusi/{diskusi}', 'destroyDiskusi')->name('destroyDiskusi');

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
         Route::get('/tugas/add/{kelas}/{mapel}', 'viewCreateTugas')->name('viewCreateTugas');
         Route::get('/tugas/{tugas}/edit', 'viewUpdateTugas')->name('viewUpdateTugas');
         Route::put('/tugas/{tugas}', 'updateTugas')->name('updateTugas');
         Route::post('/tugas/update-nilai/{tugas}', 'siswaUpdateNilai')->name('siswaUpdateNilai');
         Route::delete('/tugas/{tugas}', 'destroyTugas')->name('tugas.destroy');
         Route::post('/store-tugas', 'createTugas')->name('createTugas');
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





//Admin Only
Route::middleware(['auth', 'role:Admin'])->controller(PengajarController::class)->group(function () {
    // ==================== MAIN CRUD ROUTES ====================

    // View - Menampilkan daftar pengajar
    Route::get('/data-pengajar', 'viewPengajar')->name('viewPengajar');

    // Create - Form tambah pengajar
    Route::get('/data-pengajar/tambah', 'viewNewPengajar')->name('viewTambahPengajar');
    Route::post('/data-pengajar/store', 'storePengajar')->name('storePengajar');

    // Update
  Route::get('/data-pengajar/edit/{user}', [PengajarController::class, 'viewUpdatePengajar'])->name('viewUpdatePengajar');

    Route::post('/data-pengajar/update', 'updatePengajar')->name('updatePengajar');

    // Delete
    Route::post('/data-pengajar/destroy', 'destroyPengajar')->name('destroyPengajar');

    Route::get('/pengajar/search', 'searchPengajar')->name('searchPengajar');
    // Export pengajar ke Excel
    Route::get('/data-pengajar/export', 'export')->name('exportPengajar');

    // Download template Excel
    Route::get('/data-pengajar/template', 'downloadTemplate')->name('downloadTemplatePengajar');

    // Import pengajar dari Excel
    Route::post('/data-pengajar/import', 'import')->name('importPengajar');
});

// All Roles
Route::middleware('auth')->controller(ProfileController::class)->group(function () {
    // Khusus Admin
    Route::middleware('role:Admin')->group(function () {
        Route::get('/data-pengajar/profile/{pengajar}', 'viewProfilePengajar')
            ->name('viewProfileAdmin');
    });

    // Umum (semua user login bisa akses)
    Route::get('/profile-pengajar/{pengajar}', 'viewProfilePengajar')
        ->name('viewProfilePengajar');

    Route::get('/profile/{siswa}', 'viewProfileSiswa')
        ->name('viewProfileSiswa');

    Route::get('/user-setting/{user}', 'viewProfileSetting')
        ->name('viewProfileSetting');

    // Update / Action
    Route::post('/crop-photo-user', 'cropImageUser')
        ->name('cropImageUser');
});



Route::middleware(['auth', 'role:Admin'])->controller(MapelController::class)->group(function () {
    // ==================== MAIN CRUD ROUTES ====================
    Route::get('/data-mapel', 'viewMapel')->name('viewMapel');
    Route::get('/data-mapel/tambah-mapel', 'viewTambahMapel')->name('viewTambahMapel');
    Route::get('/data-mapel/update-mapel/{mapel}', 'viewUpdateMapel')->name('viewUpdateMapel');

    Route::post('/validate-mapel', 'validateNamaMapel')->name('validateNamaMapel');
    Route::post('/update-mapel', 'updateMapel')->name('updateMapel');
    Route::post('/destroy-mapel', 'destroyMapel')->name('destroyMapel');
    Route::get('/search-mapel', 'searchMapel')->name('searchMapel');

    // ==================== IMPORT / EXPORT ====================
    Route::get('/export-mapel', 'exportTT')->name('exportMapel');
    Route::get('/contoh-mapel', 'contohMapel')->name('contohMapel');
    Route::post('/import-mapel', 'import')->name('importMapel');
  Route::get('/search-mapel-from-kelas', 'searchKelasMapel')->name('searchKelasMapel');
    // ==================== EDITOR ACCESS ====================
    Route::get('/cek-kelas-mapel', 'cekKelasMapel')->name('cekKelasMapel');
    Route::post('/add-change-access', 'addChangeEditorAccess')->name('addChangeEditorAccess');
    Route::post('/add-editor-access', 'tambahEditorAccess')->name('tambahEditorAccess');
    Route::post('/delete-editor-access', 'deleteEditorAccess')->name('deleteEditorAccess');
});



// DataSiswa
Route::controller(DataSiswaController::class)->group(function () {
    // Hanya login (umum, tidak wajib Admin)
    Route::post('/update-user-siswa', 'updateUserSiswa')->middleware('auth')->name('updateUserSiswa');
    Route::get('/search-siswa-kelas', 'viewSiswaKelas')->middleware('auth')->name('viewSiswaKelas');
});

Route::middleware(['auth', 'role:Admin'])->controller(DataSiswaController::class)->group(function () {
    // ==================== MAIN CRUD ROUTES ====================
    Route::get('/data-siswa', 'viewSiswa')->name('viewSiswa');
    Route::get('/data-siswa/tambah-siswa', 'viewTambahSiswa')->name('viewTambahSiswa');
    Route::get('/data-siswa/update-siswa/{data_siswa:id}', 'viewUpdateDataSiswa')->name('viewUpdateDataSiswa');
    Route::get('/data-siswa/update/{token}', 'viewUpdateUserSiswa')->name('viewUpdateUserSiswa');
    

    Route::post('/validate-data-siswa', 'validateDataSiswa')->name('validateDataSiswa');
    Route::post('/destroy-siswa', 'destroyDataSiswa')->name('destroyDataSiswa');
    Route::post('/update-siswa', 'updateDataSiswa')->name('updateSiswa');

    // ==================== IMPORT / EXPORT ====================
    Route::get('/export-siswa', 'export')->name('exportSiswa');
    Route::get('/contoh-siswa', 'contohSiswa')->name('contohSiswa');
    Route::post('/import-siswa', 'import')->name('importSiswa');

    // ==================== API / SEARCH ====================
    Route::get('/search-siswa', 'searchSiswa')->name('searchSiswa');
});



Route::middleware(['auth', 'role:Admin'])->controller(KelasController::class)->group(function () {
    // ==================== MAIN CRUD ROUTES ====================
    Route::get('/data-kelas', 'viewKelas')->name('viewKelas');
    Route::get('/data-kelas/tambah-kelas', 'viewTambahKelas')->name('viewTambahKelas');
    Route::get('/data-kelas/update-kelas/{kelas}', 'viewUpdateKelas')->name('viewUpdateKelas');
    Route::get('/data-kelas/success', 'dataKelasSuccess')->name('dataKelasSuccess');

    // ==================== ACTION ROUTES ====================
    Route::post('/store-kelas', 'storeKelas')->name('storeKelas');
    Route::post('/update-kelas', 'updateKelas')->name('updateKelas');
    Route::post('/destroy-kelas', 'destroyKelas')->name('destroyKelas');
    Route::post('/validate-kelas', 'validateNamaKelas')->name('validateNamaKelas');

    // ==================== IMPORT / EXPORT ====================
    Route::get('/export-kelas', 'export')->name('exportKelas');
    Route::get('/contoh-kelas', 'contohKelas')->name('contohKelas');
    Route::post('/import-kelas', 'import')->name('importKelas');

    // ==================== API / SEARCH ====================
    Route::get('/search-kelas', 'searchKelas')->name('searchKelas');
});
// File
// File
Route::controller(FileController::class)->group(function () {
    Route::get('/getFile/{namaFile}', 'getFile')->middleware('auth')->name('getFile');
    Route::get('/getFileTugas/{namaFile}', 'getFileTugas')->middleware('auth')->name('getFileTugas');
    Route::get('/getFileUser/{namaFile}', 'getFileUser')->middleware('auth')->name('getFileUser');
});


