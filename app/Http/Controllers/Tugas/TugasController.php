<?php

namespace App\Http\Controllers\Tugas;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\DashboardController;
use Exception; // Menggunakan kelas Exception
use App\Models\User; // Menggunakan model User
use App\Models\Kelas; // Menggunakan model Kelas
use App\Models\Mapel; // Menggunakan model Mapel
use App\Models\Tugas; // Menggunakan model Tugas
use App\Models\TugasFile; // Menggunakan model TugasFile
use App\Models\UserTugas; // Menggunakan model UserTugas
use App\Models\KelasMapel; // Menggunakan model KelasMapel
use App\Models\EditorAccess; // Menggunakan model EditorAccess
use App\Models\UserTugasFile; // Menggunakan model UserTugasFile
use Illuminate\Http\Request; // Menggunakan kelas Request dari Illuminate
use Illuminate\Support\Facades\DB; // Menggunakan DB dari Illuminate\Support\Facades

class TugasController extends Controller
{

public function viewTugas(Tugas $tugas)
{
$kelasMapel = $tugas->kelasMapel;

if (!$kelasMapel) {
    abort(404, 'Kelas Mapel tidak ditemukan untuk tugas ini');
}

$mapel        = $kelasMapel->mapel;
$kelas        = $kelasMapel->kelas;
$roles        = DashboardController::getRolesName();
$editorAccess = $kelasMapel->editorAccess()->first();
$tugasAll     = Tugas::where('kelas_mapel_id', $kelasMapel->id)->get();
$userTugas    = UserTugas::where('tugas_id', $tugas->id)
                            ->where('user_id', auth()->id())
                            ->first();
$assignedKelas = DashboardController::getAssignedClass();
$title        = $tugas->name;

return view('menu.pengajar.tugas.view', compact(
    'userTugas',
    'assignedKelas',
    'tugas',
    'kelas',
    'title',
    'roles',
    'tugasAll',
    'mapel',
    'kelasMapel',
    'editorAccess'
));
}



    public function viewTugasAdmin(Tugas $tugas)
{
    $kelasMapel = $tugas->kelasMapel;
    $mapel      = $kelasMapel->mapel;
    $kelas      = $kelasMapel->kelas;

    $roles          = DashboardController::getRolesName();
    $editorAccess   = $kelasMapel->editorAccess()->first();
    $editorData     = $editorAccess ? $editorAccess->user()->where('roles_id', 2)->first() : null;
    $tugasAll       = Tugas::where('kelas_mapel_id', $kelasMapel->id)->get();
    $userTugas      = UserTugas::where('tugas_id', $tugas->id)
                        ->where('user_id', auth()->id())
                        ->first();
    $assignedKelas  = DashboardController::getAssignedClass();

    return view('menu.pengajar.tugas.viewAdmin', [
        'userTugas'     => $userTugas,
        'assignedKelas' => $assignedKelas,
        'editor'        => $editorData,
        'tugas'         => $tugas,
        'kelas'         => $kelas,
        'title'         => $tugas->name,
        'roles'         => $roles,
        'tugasAll'      => $tugasAll,
        'mapel'         => $mapel,
        'kelasMapel'    => $kelasMapel,
    ]);
}


public function siswaUpdateNilai(Request $request, Tugas $tugas)
{
    foreach ($request->nilai as $i => $nilaiInput) {
        if ($nilaiInput !== null && $nilaiInput !== '') {
            $nilai = max(0, min(100, (int) $nilaiInput)); // clamp nilai 0–100

            $userId = $request->siswaId[$i];
            $exist  = UserTugas::where('tugas_id', $tugas->id)
                                ->where('user_id', $userId)
                                ->first();

            if ($exist) {
                $exist->update([
                    'status' => 'Telah dinilai',
                    'nilai'  => $nilai,
                ]);
            } else {
                UserTugas::create([
                    'tugas_id' => $tugas->id,
                    'user_id'  => $userId,
                    'status'   => 'Telah dinilai',
                    'nilai'    => $nilai,
                ]);
            }
        }
    }

    return back()->with('success', 'Nilai berhasil diperbarui');
}

public function viewCreateTugas(KelasMapel $kelasMapel )
{
// Cari kelasMapel
 $kelasMapel->load(['kelas', 'mapel']);



// Siapkan variabel dulu
$assignedKelas = DashboardController::getAssignedClass();
// $roles         = DashboardController::getRolesName();
$title         = 'Tambah Tugas';
// $kelasId       = $kelas->id;

return view('menu.pengajar.tugas.add', compact(
    'assignedKelas',
    'title',
    'kelasMapel'
));
}


public function viewUpdateTugas(Tugas $tugas)
{
$kelasMapel = $tugas->kelasMapel;

// Siapkan variabel yang akan dikirim ke view
$assignedKelas = DashboardController::getAssignedClass();
$title         = 'Update Tugas';
// $roles         = DashboardController::getRolesName();
$kelasId       = $kelasMapel->kelas_id;
$mapel         = $kelasMapel->mapel;

return view('menu.pengajar.tugas.edit', compact(
    'assignedKelas',
    'title',
    // 'roles',
    'tugas',
    'kelasId',
    'mapel',
    'kelasMapel'
));
}


/**
 * Simpan tugas baru
 */
public function createTugas(Request $request, KelasMapel $kelasMapel)
{
   
    $request->validate([
        'name'    => 'required|string|max:255',
        'content' => 'required|string',
        'due'     => 'required|date_format:Y-m-d\TH:i',
    ]);

 
    $due = Carbon::createFromFormat('Y-m-d\TH:i', $request->due);

    //  Simpan data tugas
    Tugas::create([
        'kelas_mapel_id' => $kelasMapel->id,
        'name'           => $request->name,
        'content'        => $request->input('content'),
        // 'due'            => $due,
        'isHidden'       => $request->has('opened') ? 0 : 1,
    ]);
    

    // Redirect kembali ke halaman kelas-mapel
    return redirect()->route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel_id,
        'kelas' => $kelasMapel->kelas_id,
    ])->with('success', 'Tugas berhasil ditambahkan!');
}


public function updateTugas(Request $request, Tugas $tugas)
{
$request->validate([
    'name'    => 'required|string|max:255',
    'content' => 'required',
    'due'     => 'required|date_format:Y-m-d H:i',
]);

$tugas->update([
    'name'     => $request->name,
    'content'        => $request->input('content'),
    'due'      => Carbon::createFromFormat('Y-m-d H:i', $request->due),
    'isHidden' => $request->has('opened') ? 0 : 1,
]);

if ($request->ajax()) {
    return response()->json([
        'success'   => true,
        'tugas_id'  => $tugas->id,
        'message'   => 'Tugas berhasil diperbarui!',
    ]);
}

return redirect()->route('viewKelasMapel', [
    'mapel' => $tugas->kelasMapel->mapel_id,
    'kelas' => $tugas->kelasMapel->kelas_id,
])->with('success', 'Tugas berhasil diperbarui!');
}

public function destroyTugas(Tugas $tugas)
{
$kelasMapel = $tugas->kelasMapel;
$tugas->delete();

return redirect()->route('viewKelasMapel', [
    'mapel' => $kelasMapel->mapel_id,
    'kelas' => $kelasMapel->kelas_id
])->with('success', 'Tugas berhasil dihapus!');
}
}
