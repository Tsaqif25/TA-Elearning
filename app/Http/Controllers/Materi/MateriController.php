<?php

namespace App\Http\Controllers\Materi;

use App\Models\Materi;
use App\Models\KelasMapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class MateriController extends Controller
{
 public function create(KelasMapel $kelasMapel)
    {
        // Ambil data kelas dan mapel langsung
        $kelas = $kelasMapel->kelas;
        $mapel = $kelasMapel->mapel;

        return view('menu.pengajar.materi.add', [
            'kelasMapel' => $kelasMapel,
            'kelas' => $kelas,
            'mapel' => $mapel,
            'title' => 'Tambah Materi'
        ]);
    }

    public function store(Request $request, KelasMapel $kelasMapel)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'content' => 'required|string',
            'youtube_link' => 'nullable',
        ]);

        $materi = Materi::create([
            'kelas_mapel_id' => $kelasMapel->id,
            'name' => $validated['name'],
            'content' => $validated['content'],
            'youtube_link' => $validated['youtube_link'] ?? null,
        ]);

        // Jika via AJAX (Dropzone)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil disimpan!',
                'materi_id' => $materi->id
            ]);
        }

        // Redirect biasa
        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id,
            'kelas' => $kelasMapel->kelas_id,
            'tab'   => 'materi'
        ])->with('success', 'Materi berhasil ditambahkan!');
    }

    public function edit(Materi $materi)
    {
        $kelasMapel = $materi->kelasMapel;
        $kelas = $kelasMapel->kelas;
        $mapel = $kelasMapel->mapel;

        return view('menu.pengajar.materi.edit', [
            'materi' => $materi,
            'kelasMapel' => $kelasMapel,
            'kelas' => $kelas,
            'mapel' => $mapel,
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

        $materi->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil diperbarui!',
                'materi_id' => $materi->id
            ]);
        }

        $kelasMapel = $materi->kelasMapel;

        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id,
            'kelas' => $kelasMapel->kelas_id,
            'tab'   => 'materi'
        ])->with('success', 'Materi berhasil diperbarui!');
    }

    public function show(Materi $materi)
    {
        $kelasMapel = $materi->kelasMapel;
        $kelas = $kelasMapel->kelas;
        $mapel = $kelasMapel->mapel;
        $editor = optional($kelasMapel->editorAccess->first())->user;

        $materiAll = Materi::where('kelas_mapel_id', $kelasMapel->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('menu.pengajar.materi.view', [
            'title' => $materi->name,
            'materi' => $materi,
            'materiAll' => $materiAll,
            'kelasMapel' => $kelasMapel,
            'kelas' => $kelas,
            'mapel' => $mapel,
            'editor' => $editor,
        ]);
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