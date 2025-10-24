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
     * Upload file materi (via Dropzone / AJAX)
     */
    public function store(Request $request, Materi $materi)
    {
        //  Validasi input
        $request->validate([
            'file' => 'required|file|max:10240', // max 10 MB
        ]);

        try {
            // Simpan file ke storage/public/materi/{id_materi}
            $file = $request->file('file');
            $path = $file->store("materi/{$materi->id}", 'public');

            //  Simpan nama file ke tabel materi_files via relasi
            $materi->files()->create([
                'file' => basename($path)
            ]);

            //  Response untuk Dropzone
            return response()->json([
                'success' => true,
                'message' => 'File berhasil diunggah!',
                'path' => $path
            ], 200);

        } catch (\Throwable $e) {
            //  Tangani error upload
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload file: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Hapus file materi
     */
    public function destroy(Request $request, Materi $materi)
    {
        // Validasi ID file
        $request->validate([
            'file_id' => 'required|integer|exists:materi_files,id',
        ]);

        //   Cari file yang terhubung dengan materi ini
        $file = $materi->files()->find($request->file_id);

        //  Pastikan file benar-benar milik materi tersebut
        if (!$file) {
            return $this->responseError('File tidak ditemukan.');
        }

        //  Hapus dari storage jika file ada
        $filePath = "materi/{$materi->id}/{$file->file}";
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        //  Hapus dari database
        $file->delete();

        //  Kembalikan respon sesuai jenis request
        return $request->ajax()
            ? response()->json(['success' => true, 'message' => 'File berhasil dihapus.'])
            : back()->with('success', 'File berhasil dihapus.');
    }

    /**
     * Helper untuk respon error
     */
    private function responseError(string $message)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], 404);
    }
}
