<?php
namespace App\Http\Controllers\Tugas;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\TugasFile;
use Illuminate\Http\Request;

class TugasFileController extends Controller
{
       public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
            'action' => 'required|in:tambah,edit',
        ]);

        $file     = $request->file('file');
        $fileName = 'F' . mt_rand(1, 999) . '_' . $file->getClientOriginalName();
        $file->move(storage_path('app/public/file/tugas'), $fileName);

        if ($request->action === 'tambah') {
            $tugas = Tugas::latest()->first();
        } else {
            $request->validate(['idTugas' => 'required|integer|exists:tugas,id']);
            $tugas = Tugas::findOrFail($request->idTugas);
        }

        TugasFile::create([
            'tugas_id' => $tugas->id,
            'file'     => $fileName,
        ]);

        return response()->json(['message' => 'File berhasil diunggah.'], 200);
    }

 
    //  * Delete file Tugas.
          public function destroy(Request $request)
    {
        $request->validate([
            'idTugas'  => 'required|integer|exists:tugas,id',
            'fileName' => 'required|string'
        ]);

        $dest = storage_path('app/public/file/tugas');
        $path = $dest . '/' . $request->fileName;

        if (file_exists($path)) {
            unlink($path);
        }

        TugasFile::where('tugas_id', $request->idTugas)
                 ->where('file', $request->fileName)
                 ->delete();

        return back()->with('success', 'File berhasil dihapus');
    }
}
