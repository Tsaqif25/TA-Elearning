<?php

namespace App\Http\Controllers\Ujian;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Ujian;
use App\Models\KelasMapel;
use App\Models\UserCommit;
use App\Models\UserJawaban;
use Illuminate\Http\Request;
use App\Models\SoalUjianAnswer;
use App\Imports\SoalUjianImport;
use App\Models\SoalUjianMultiple;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use Illuminate\Validation\ValidationException;



class UjianManagementController extends Controller
{



    // FORM TAMBAH UJIAN
  public function create(KelasMapel $kelasMapel, Request $request)
{
    $kelasMapel->load(['kelas', 'mapel']);
    return view('menu.pengajar.ujian.viewTambahUjian', [
        'assignedKelas' => DashboardController::getAssignedClass(),
        // 'roles' => DashboardController::getRolesName(),
        'kelasMapel' => $kelasMapel,
        'title' => 'Tambah Ujian',
        'tipe' => $request->type,
    ]);
}

    // SIMPAN UJIAN BARU
public function store(Request $request, KelasMapel $kelasMapel)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'time' => 'required|integer',
        'due'  => 'required|date',
    ]);

    $ujian = Ujian::create([
        'kelas_mapel_id' => $kelasMapel->id,
        'name' => $validated['name'],
        'time' => $validated['time'],
        'due'  => $validated['due'],
    ]);

    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Ujian berhasil dibuat!', 'ujian_id' => $ujian->id]);
    }



     return redirect()->route('ujian.soal.manage', $ujian->id)
    ->with('success', 'Ujian berhasil dibuat! Silakan tambahkan soal ujian.');
}



public function edit(Ujian $ujian)
{
    $kelasMapel = $ujian->kelasMapel; // relasi belongsTo
    
    return view('menu.pengajar.ujian.viewUpdateUjian', [
        'ujian' => $ujian,
        'assignedKelas' => DashboardController::getAssignedClass(),
        'kelasMapel' => $kelasMapel,
    ]);
}


public function update(Request $request, Ujian $ujian)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'time' => 'required|integer',
        'due'  => 'required|date',
    ]);

    $ujian->update([
        'name' => $validated['name'],
        'time' => $validated['time'],
        'due'  => $validated['due'],
    ]);



 return redirect()->route('ujian.soal.manage', $ujian->id)
    ->with('success', 'Ujian berhasil dibuat! Silakan tambahkan soal ujian.');


}



public function destroy(Ujian $ujian)
{

     // Ambil relasi kelasMapel
    $kelasMapel = $ujian->kelasMapel;

    // $kelasMapelId = $ujian->kelas_mapel_id;
    $ujian->delete();

    return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id,
            'kelas' => $kelasMapel->kelas_id,
            'tab'   => 'quiz'
        ])->with('success', 'Materi berhasil ditambahkan!');
}



//Batas Suci
///////////////////////////////////////////////////////////////////////////////////
// public function viewUpdateUjian($id)
// {
//     $ujian = Ujian::with(['soalUjianMultiple.answers'])->findOrFail($id);

//     $kelasMapel = $ujian->kelasMapel;
//     $mapel = $kelasMapel->mapel;
//     $kelas = $kelasMapel->kelas;

//     $roles = DashboardController::getRolesName();
//     $assignedKelas = DashboardController::getAssignedClass();

//     return view('menu.pengajar.ujian.viewUpdateUjian', [
//         'assignedKelas' => $assignedKelas,
//         'title' => 'Update Ujian',
//         'ujian' => $ujian,
//         'roles' => $roles,
//         'kelasId' => $kelas->id,
//         'mapel' => $mapel,
//     ]);
// }

// public function updateUjian(Request $request)
// {
//     $validated = $request->validate([
//         'ujian_id'       => 'required|exists:ujians,id',
//         'name'           => 'required|string|max:255',
//         'time'           => 'required|integer',
//         'due'            => 'required|date',
//         'question'       => 'required|string',
//         'answers'        => 'required|array|min:2',
//         'answers.*'      => 'required|string',
//         'correct_answer' => 'required|integer'
//     ]);

//     DB::beginTransaction();
//     try {
//         $ujian = Ujian::with('kelasMapel')->findOrFail($validated['ujian_id']);

//         // Update ujian
//         $ujian->update([
//             'name' => $validated['name'],
//             'time' => $validated['time'],
//             'due'  => $validated['due'],
//         ]);

//         // Update soal
//         $soal = $ujian->soalUjianMultiple()->first();
//         if (!$soal) {
//             $soal = SoalUjianMultiple::create([
//                 'ujian_id' => $ujian->id,
//                 'soal'     => $validated['question'],
//             ]);
//         } else {
//             $soal->update(['soal' => $validated['question']]);
//             $soal->answers()->delete();
//         }

//         // Simpan jawaban baru
//         foreach ($validated['answers'] as $index => $answerText) {
//             SoalUjianAnswer::create([
//                 'soal_ujian_id' => $soal->id,
//                 'jawaban'       => $answerText,
//                 'is_correct'    => ($validated['correct_answer'] == $index) ? 1 : 0,
//             ]);
//         }

//         DB::commit();
//         return redirect()->route('manageUjian', [
//             'kelasId' => $ujian->kelasMapel->kelas_id,
//             'mapelId' => $ujian->kelasMapel->mapel_id
//         ])->with('success', 'Ujian berhasil diperbarui!');
//     } catch (\Exception $e) {
//         DB::rollBack();
//         return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
//     }

// }


}



?>