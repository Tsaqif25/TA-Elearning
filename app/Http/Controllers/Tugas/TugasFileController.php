<?php

namespace App\Http\Controllers\Tugas;

use App\Http\Controllers\Controller;
use App\Models\{Tugas, TugasFile};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasFileController extends Controller
{
  
    public function store(Request $request, Tugas $tugas)
    {
        $request->validate([
            "file" => "required|file|max:20480", // MAX 20MB
        ]);

        //  Simpan file ke folder: storage/app/public/tugas/{id}
        $path = $request->file("file")->store("tugas/{$tugas->id}", "public");

        //  Simpan ke database
        $tugas->files()->create([
            "file" => $path
        ]);

        return response()->json([
            "success" => true,
            "file"    => $path,
            "message" => "📁 File berhasil diupload!"
        ]);
    }

    /**
     * HAPUS FILE TUGAS
     */
public function destroy(Request $request, Tugas $tugas)
{
    $request->validate([
        "fileName" => "required"
    ]);

    $file = $tugas->files()->where("file", $request->fileName)->first();

    if (!$file) {
        return back()->with("error", "⚠ File tidak ditemukan!");
    }

    Storage::disk("public")->delete($file->file);
    $file->delete();

    return back()->with("success", "🗑 File berhasil dihapus!");
}

}
