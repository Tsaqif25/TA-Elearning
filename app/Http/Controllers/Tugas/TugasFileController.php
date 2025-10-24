<?php

namespace App\Http\Controllers\Tugas;

use App\Http\Controllers\Controller;
use App\Models\{Tugas, TugasFile};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasFileController extends Controller
{
    /**
     *  Upload file materi tugas oleh guru
     */
    public function store(Request $request, Tugas $tugas)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:10240', // Maksimal 10 MB
        ]);

        try {
            // Simpan file ke folder publik: storage/app/public/file/tugas/{id_tugas}
            $path = $validated['file']->store("file/tugas/{$tugas->id}", 'public');

            // Simpan path file ke database
            $tugas->files()->create([
                'file' => $path,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File tugas berhasil diunggah.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah file: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     *  Hapus file materi tugas
     */
    public function destroy(Request $request, Tugas $tugas)
    {
        $validated = $request->validate([
            'fileName' => 'required|string',
        ]);

        // Cari record file di database
        $file = $tugas->files()
                      ->where('file', $validated['fileName'])
                      ->first();

        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan di database.',
            ], 404);
        }

        // Tentukan path file di storage publik
        $path = $file->file;

        // Hapus file fisik jika masih ada
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // Hapus record database
        $file->delete();

        // Respon berdasarkan jenis request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'File berhasil dihapus.',
            ]);
        }

        return back()->with('success', 'File berhasil dihapus.');
    }
}
