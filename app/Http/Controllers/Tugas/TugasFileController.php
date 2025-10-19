<?php
namespace App\Http\Controllers\Tugas;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\TugasFile;
use Illuminate\Http\Request;

class TugasFileController extends Controller
{
public function store(Request $request, Tugas $tugas)
{
    $request->validate([
        'file' => 'required|file|max:10240',
    ]);

    try {
        $path = $request->file('file')->store("file/tugas/{$tugas->id}", 'public');

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
            'message' => $e->getMessage(),
        ], 500);
    }
}




public function destroy(Request $request, Tugas $tugas)
{
    $validated = $request->validate([
        'fileName' => ['required', 'string'],
    ]);

    // Cari record file di database
    $file = $tugas->files()->where('file', $validated['fileName'])->first();

    if (!$file) {
        return response()->json([
            'success' => false,
            'message' => 'File tidak ditemukan di database.'
        ], 404);
    }

    // Hapus file fisik dari storage (aman di semua OS)
    $path = 'file/tugas/' . $file->file;
    if (Storage::disk('public')->exists($path)) {
        Storage::disk('public')->delete($path);
    }

    // Hapus record database
    $file->delete();

      // 🔹 Jika request dari AJAX → kirim JSON
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'File berhasil dihapus.',
        ]);
    }

    // 🔹 Jika dari form biasa → redirect balik dengan flash message
    return back()->with('success', 'File berhasil dihapus.');
}
}
