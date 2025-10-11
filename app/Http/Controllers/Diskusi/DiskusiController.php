<?php

namespace App\Http\Controllers\Diskusi;

use App\Http\Controllers\Controller;
use Exception; // Mengimpor kelas Exception
use App\Models\User; // Mengimpor model User
use Livewire\Livewire; // Mengimpor Livewire
use App\Http\Controllers\DashboardController;
use App\Models\Kelas; // Mengimpor model Kelas
use App\Models\Mapel; // Mengimpor model Mapel
use App\Models\Diskusi; // Mengimpor model Diskusi
use App\Models\KelasMapel; // Mengimpor model KelasMapel
use App\Models\EditorAccess; // Mengimpor model EditorAccess
use Illuminate\Http\Request; // Mengimpor Request dari Laravel
use Illuminate\Support\Facades\DB; // Mengimpor DB dari Laravel

/**
 * Class : DiskusiController
 *
 * Class ini berisi berbagai fungsi yang berkaitan dengan manipulasi data-data diskusi, terutama terkait dengan model.
 */
class DiskusiController extends Controller
{
    // Tambah Diskusi
public function viewCreateDiskusi($kelasMapelId)
{
    $kelasMapel = KelasMapel::findOrFail($kelasMapelId);
    $assignedKelas = DashboardController::getAssignedClass();

    return view('menu.pengajar.diskusi.add', compact('kelasMapel', 'assignedKelas'))
        ->with('title', 'Tambah Diskusi');
}

        

        

    // Update Diskusi
  public function viewUpdateDiskusi($diskusiId)
{
    $diskusi    = Diskusi::findOrFail($diskusiId);
    $kelasMapel = KelasMapel::findOrFail($diskusi->kelas_mapel_id);
    $mapel      = Mapel::findOrFail($kelasMapel->mapel_id);
    $kelas      = Kelas::findOrFail($kelasMapel->kelas_id);
    $assignedKelas = DashboardController::getAssignedClass();

    return view('menu.pengajar.diskusi.edit', compact(
        'diskusi', 'kelasMapel', 'mapel', 'kelas', 'assignedKelas'
    ))->with('title', 'Update Diskusi');
}

    // Lihat Diskusi
public function viewDiskusi($diskusiId)
{
    $diskusi    = Diskusi::findOrFail($diskusiId);
    $kelasMapel = KelasMapel::findOrFail($diskusi->kelas_mapel_id);

   
    // Data editor (pengajar) → opsional, hanya untuk ditampilkan di view
    $editor = $kelasMapel->editorAccess()->first()?->user;

    // Ambil resource terkait
    $mapel        = $kelasMapel->mapel;
    $kelas        = $kelasMapel->kelas;
    $diskusiAll   = $kelasMapel->diskusi()->get(); // langsung via relasi
    $assignedKelas = DashboardController::getAssignedClass();

    return view('menu.pengajar.diskusi.view', compact(
        'assignedKelas',
        'diskusi',
        'kelas',
        'mapel',
        'editor',
        'kelasMapel',
        'diskusiAll'
    ))->with('title', $diskusi->name);
}


    // Create Diskusi
public function createDiskusi(Request $request) 
{
    $request->validate([
        'name'    => 'required',
        'content' => 'nullable',  // Tetap required
    ]);

    try {
        $kelasMapel = KelasMapel::findOrFail($request->kelasMapelId);
        $isHidden = $request->opened ? 0 : 1;

        Diskusi::create([
            'kelas_mapel_id' => $kelasMapel->id,
            'name'           => $request->input('name'),
            'content'        => $request->input('content'),
            'isHidden'       => $isHidden,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Diskusi berhasil dibuat'
            ]);
        }

        return back()->with('success', 'Diskusi berhasil dibuat');
        
    } catch (\Exception $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 422);
        }
        
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}

public function updateDiskusi(Request $request)
{
    $request->validate([
        // 'diskusiId' => 'required|exists:diskusi,id',
        
        'name'      => 'required|string',
        'content'   => 'nullable|string',
    ]);

    try {
        $isHidden = $request->opened ? 0 : 1;

        Diskusi::where('id', $request->diskusiId)->update([
            'name'    => $request->input('name'),
            'content' => $request->input('content'),
            'isHidden'=> $isHidden,
        ]);

        return back()->with('success', 'Diskusi berhasil diperbarui');
    } catch (\Exception $e) {
        return back()->with('error', 'Error: '.$e->getMessage());
    }
}

    // Hapus Diskusi
public function destroyDiskusi(Diskusi $diskusi)
{
  $kelasMapel = $diskusi->kelasMapel;

    $diskusi->delete();

    return back()->with('success', 'Diskusi berhasil dihapus');
}

}

