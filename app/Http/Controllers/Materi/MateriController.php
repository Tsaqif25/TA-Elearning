<?php

namespace App\Http\Controllers\Materi;

use App\Models\Materi;
use App\Models\KelasMapel;
use App\Models\MateriFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\DashboardController;

class MateriController extends Controller
{
    public function create(KelasMapel $kelasMapel)
    {
    
        $kelasMapel->load(['kelas', 'mapel']);
        // Ambil assigned kelas 
        $assignedKelas = DashboardController::getAssignedClass();
       return view('menu.pengajar.materi.add', compact('kelasMapel', 'assignedKelas'))
       ->with('title', 'Tambah Materi');

    }
    public function store(Request $request, KelasMapel $kelasMapel)
    {
        $validated = $request->validate([
            'name' => 'required',
            'content' => 'required',
       'youtube_link' => 'nullable|string',
        ]);
        $materi = Materi::create([
            'kelas_mapel_id' => $kelasMapel->id,
            'name' => $validated['name'],
            'content' => $validated['content'] ?? null,
            'youtube_link' => $validated['youtube_link'] ?? null,
        ]);
        // Return JSON untuk AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil disimpan!',
                'materi_id' => $materi->id
            ]);
        }
        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id,
            'kelas' => $kelasMapel->kelas_id,
              'tab'   => 'materi'
        ])->with('success', 'Materi berhasil ditambahkan!');
    }
    public function edit(Materi $materi)
    {
        // Load relasi
        $materi->load(['kelasMapel.kelas', 'kelasMapel.mapel']);
        
        // Ambil assigned kelas untuk sidebar
        $assignedKelas = DashboardController::getAssignedClass();
        
        return view('menu.pengajar.materi.edit', [
            'materi' => $materi,
            'kelasMapel' => $materi->kelasMapel,
            'assignedKelas' => $assignedKelas,
            'title' => 'Update Materi'
        ]);
    }

    public function update(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
             'youtube_link' => 'nullable|string',
        ]);

        $materi->update([
            'kelas_mapel_id' => $materi->kelas_mapel_id, 
            'name' => $validated['name'],
            'content' => $validated['content'],
                 'youtube_link' => $validated['youtube_link'] ?? null,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil diperbarui!',
                'materi_id' => $materi->id
            ]);
        }

        return redirect()->route('viewKelasMapel', [
            'mapel' => $materi->kelasMapel->mapel_id,
            'kelas' => $materi->kelasMapel->kelas_id,
             'tab'   => 'materi'
        ])->with('success', 'Materi berhasil diperbarui!');
    }

public function show(Materi $materi)
{
    // Load relasi
    $materi->load([
        'kelasMapel.kelas',
        'kelasMapel.mapel',
        'kelasMapel.editorAccess.user',
    ]);
    // Ambil semua materi di kelas mapel yang sama
    $materiAll = Materi::where('kelas_mapel_id', $materi->kelas_mapel_id)
        ->orderBy('created_at', 'asc')
        ->get();

    // Ambil data pengajar
    $editor = $materi->kelasMapel->editorAccess->first()?->user;

    // Ambil assigned kelas untuk sidebar
    $assignedKelas = DashboardController::getAssignedClass();

    $kelasMapel = $materi->kelasMapel; 
    $title = $materi->name; 

    return view('menu.pengajar.materi.view', compact(
        'materi',
        'materiAll',
        'editor',
        'kelasMapel',
        'assignedKelas',
        'title'
    ));
}
  public function destroy(Materi $materi)
{
    $kelasMapel = $materi->kelasMapel;
    $materi->delete();

    return redirect()->route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel_id,
        'kelas' => $kelasMapel->kelas_id,
        'tab'   => 'materi'
    ])->with('success', 'Materi berhasil dihapus!');
}

}