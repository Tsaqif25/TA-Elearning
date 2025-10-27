<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use App\Models\RepositoryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RepositoryFileController extends Controller
{
    /**
     * Upload file repository (via Dropzone / AJAX)
     */
    public function store(Request $request, Repository $repository)
    {
        // Validasi file (maks 10 MB)
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        try {
            // Simpan ke storage/public/repository/{id_repository}
            $file = $request->file('file');
            $path = $file->store("repository/{$repository->id}", 'public');

            // Simpan nama file di tabel repository_files
            $repository->files()->create([
              'file' => $path,
            ]);

            // Respon JSON untuk Dropzone
            return response()->json([
                'success' => true,
                'message' => 'File berhasil diunggah!',
                'path'    => $path,
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload file: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Hapus file repository (via AJAX atau form biasa)
     */
    public function destroy(Request $request, Repository $repository)
    {
        $request->validate([
            'file_id' => 'required|integer|exists:repository_files,id',
        ]);

        // Cari file berdasarkan relasi repository
        $file = $repository->files()->find($request->file_id);

        if (!$file) {
            return $this->responseError('File tidak ditemukan.');
        }

        // Hapus dari storage jika ada
        $filePath = "repository/{$repository->id}/{$file->file}";
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Hapus dari database
        $file->delete();

        // Balasan tergantung tipe request
        return $request->ajax()
            ? response()->json(['success' => true, 'message' => 'File berhasil dihapus.'])
            : back()->with('success', 'File berhasil dihapus.');
    }

    /**
     * Helper respon error JSON
     */
    private function responseError(string $message)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 404);
    }
}
