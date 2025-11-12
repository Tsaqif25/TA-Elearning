<?php

namespace App\Http\Controllers\Materi;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriFileController extends Controller
{
    /**
     * Upload file materi (via Dropzone / AJAX)
     */
    public function store(Request $request, Materi $materi)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // max 10 MB
        ]);

        try {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();

            // 🔹 Pastikan folder materi/{id} selalu dibuat
            Storage::disk('public')->makeDirectory("materi/{$materi->id}");

            // 🔹 Simpan file di storage/app/public/materi/{id}/
            $path = $file->storeAs("materi/{$materi->id}", $originalName, 'public');

            // 🔹 Simpan ke database
            $materi->files()->create([
                'file' => $originalName
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File berhasil diunggah!',
                'path' => $path
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload file: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download file materi (langsung download)
     */
    public function downloadFile($materiId, $filename)
    {
        $materi = \App\Models\Materi::findOrFail($materiId);

        // 🔒 Validasi role user
        if (!auth()->user()->hasAnyRole(['Admin', 'Pengajar', 'Siswa', 'Wakur'])) {
            abort(403, 'Akses ditolak.');
        }

        $filePath = "materi/{$materiId}/{$filename}";

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        // 🔹 Download file
        return Storage::disk('public')->download($filePath);
    }

    /**
     * Preview file materi (tampil di browser, bukan download)
     */
    public function showFile(Materi $materi, $filename)
    {
        $path = storage_path("app/public/materi/{$materi->id}/{$filename}");

        // 🔹 Jika file tidak ditemukan di lokasi utama
        if (!file_exists($path)) {
            // Coba di alternatif
            $altPath = storage_path("app/public/file/materi/{$filename}");
            if (file_exists($altPath)) {
                $path = $altPath;
            } else {
                abort(404, 'File tidak ditemukan.');
            }
        }

        return response()->file($path);
    }

    /**
     * Hapus file materi
     */
    public function destroy(Request $request, Materi $materi)
    {
        $request->validate([
            'file_id' => 'required|integer|exists:materi_files,id',
        ]);

        $file = $materi->files()->find($request->file_id);

        if (!$file) {
            return $this->responseError('File tidak ditemukan.');
        }

        $filePath = "materi/{$materi->id}/{$file->file}";

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $file->delete();

        return $request->ajax()
            ? response()->json(['success' => true, 'message' => 'File berhasil dihapus.'])
            : back()->with('success', 'File berhasil dihapus.');
    }

    /**
     * Helper respon error
     */
    private function responseError(string $message)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], 404);
    }
}
