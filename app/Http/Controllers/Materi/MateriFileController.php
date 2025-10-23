<?php

namespace App\Http\Controllers\Materi;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\MateriFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriFileController extends Controller
{
    /**
     * Upload file untuk materi.
     */
    public function store(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'max:10240'], // 10MB
        ]);

        try {
            //  Simpan file langsung ke folder public/materi/{id}
            $path = $validated['file']->store("materi/{$materi->id}", 'public');

            //  Simpan ke database via relasi
            $materi->files()->create(['file' => basename($path)]);
            return response()->json([
                'success' => true,
                'message' => 'File berhasil diunggah!',
                'path' => $path,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload file: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Hapus file dari materi.
     */
 public function destroy(Request $request, Materi $materi)
{
    $validated = $request->validate([
        'file_id' => ['required', 'integer', 'exists:materi_files,id'],
    ]);

    $file = $materi->files()->find($validated['file_id']);

    if (!$file) {
        return back()->with('error', 'File tidak ditemukan.');
    }

    if (Storage::disk('public')->exists($file->file)) {
        Storage::disk('public')->delete($file->file);
    }

    $file->delete();

    //  Kalau request dari AJAX, kirim JSON
    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'File berhasil dihapus.']);
    }

    //  Kalau request dari form biasa, redirect balik
    return redirect()->back()->with('success', 'File berhasil dihapus.');
}

}
