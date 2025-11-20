<?php

namespace App\Http\Controllers\Tugas;

use App\Models\NilaiTugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\{Tugas, PengumpulanTugas, PengumpulanTugasFile, TugasKomentar};

class TugasSubmitController extends Controller
{
   
public function viewTugasSiswa(Tugas $tugas)
{
    $siswaId = Auth::user()->dataSiswa->id;

    $pengumpulan = PengumpulanTugas::where([
        "tugas_id" => $tugas->id,
        "siswa_id" => $siswaId
    ])->first();

    $nilai = NilaiTugas::where([
        "tugas_id" => $tugas->id,
        "siswa_id" => $siswaId
    ])->value('nilai');
        $kelasMapel = $tugas->kelasMapel ;
    return view("menu.siswa.tugas.uploadtugas", compact("tugas", "pengumpulan", "nilai","kelasMapel"));
}

public function submitTugas(Request $request, Tugas $tugas)
{
    $siswaId = Auth::user()->dataSiswa->id;

    $isLate = now()->greaterThan($tugas->due) ? 1 : 0;

    PengumpulanTugas::updateOrCreate(
        [
            "tugas_id" => $tugas->id,
            "siswa_id" => $siswaId
        ],
        [
            "submitted_at" => now(),
            "is_late"      => $isLate
        ]
    );

    return response()->json([
        "success" => true,
        "late"    => $isLate,
        "message" => $isLate
            ? "Tugas berhasil dikirim, tetapi TERLAMBAT"
            : "Tugas berhasil dikirim!"
    ]);
}

    
    public function submitFileTugas(Request $request)
    {
        $request->validate([
            "tugas_id" => "required",
            "file"     => "required|file|max:10240" // 10MB
        ]);

        $tugas      = Tugas::findOrFail($request->tugas_id);
        $siswa_id = Auth::user()->dataSiswa->id;
        $isLate = now()->greaterThan($tugas->due) ? 1 : 0;
        $submit = PengumpulanTugas::firstOrCreate([
            "tugas_id" => $tugas->id,
            "siswa_id" => $siswa_id,
        ], [
            "submitted_at" => now() ,
             "is_late"      => $isLate
        ]);

        //  Simpan file ke folder: storage/app/public/tugas/siswa/{id_pengumpulan}
        $path = $request->file("file")->store("tugas/siswa/{$submit->id}", "public");

        //  Simpan ke database
        PengumpulanTugasFile::create([
            "pengumpulan_tugas_id" => $submit->id,
            "file" => $path
        ]);

        return response()->json([
            "success" => true,
            "file"    => $path,
            "message" => "📁 Upload berhasil!"
        ]);
    }

    /**
     *  HAPUS FILE JAWABAN SISWA
     */
    public function deleteFile(Request $request)
    {
        $request->validate(["fileName" => "required"]);

        $file = PengumpulanTugasFile::where("file", $request->fileName)->firstOrFail();

        Storage::disk("public")->delete($file->file);
        $file->delete();

        return back()->with("success", "🗑 File berhasil dihapus!");
    }

   
}
