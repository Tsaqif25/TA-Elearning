<?php

namespace App\Http\Controllers\Materi;

use App\Models\Materi;
use App\Models\MateriFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MateriFileController extends Controller
{
    public function store(Request $request, Materi $materi)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
        ]);
        try {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan file ke storage/app/public/materi/{id}
            $path = $file->storeAs('materi/' . $materi->id, $filename, 'public');

            // Simpan ke database
            MateriFile::create([
                'materi_id' => $materi->id,
                'file' => $path,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'File berhasil diupload!',
                'filename' => $filename
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload file: ' . $e->getMessage()
            ], 500);
        }
    }
    public function destroy(Request $request, Materi $materi)
    {
        $fileId = $request->file_id;

        $file = MateriFile::where('id', $fileId)
            ->where('materi_id', $materi->id)
            ->first();

        if (!$file) {
            return back()->with('error', 'File tidak ditemukan');
        }

        // Hapus dari storage
        if (Storage::disk('public')->exists($file->file)) {
            Storage::disk('public')->delete($file->file);
        }

        // Hapus record DB
        $file->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'File berhasil dihapus']);
        }

        return back()->with('success', 'File berhasil dihapus');
    }
}
