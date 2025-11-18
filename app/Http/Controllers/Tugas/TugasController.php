<?php

namespace App\Http\Controllers\Tugas;

use Illuminate\Http\Request;
use App\Models\TugasKomentar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\{Tugas, KelasMapel, DataSiswa, PengumpulanTugas, NilaiTugas, Notification};

class TugasController extends Controller
{
    public function viewTugas(Tugas $tugas)
    {
        return view('menu.pengajar.tugas.view', [
            'tugas'      => $tugas,
    'kelas'      => $tugas->kelasMapel->kelas,
    'mapel'      => $tugas->kelasMapel->mapel,
    'kelasMapel' => $tugas->kelasMapel,
    'tugasAll'   => Tugas::where("kelas_mapel_id", $tugas->kelas_mapel_id)->get(),
   
        ]);
    }

    public function viewCreateTugas(KelasMapel $kelasMapel)
    {
        return view('menu.pengajar.tugas.add', compact("kelasMapel"));
    }

    public function createTugas(Request $request, KelasMapel $kelasMapel)
    {
        $request->validate([
            "name"      => "required",
            "deskripsi" => "required",
            "due"       => "required|date"
        ]);

        $tugas = Tugas::create([
            "kelas_mapel_id" => $kelasMapel->id,
            "judul"           => $request->name,
            "deskripsi"      => $request->deskripsi,
            "due"            => $request->due,
            "user_id"        => Auth::id()
        ]);

        foreach (DataSiswa::where("kelas_id", $kelasMapel->kelas_id)->get() as $siswa) {
            Notification::create([
                "user_id" => $siswa->user_id,
                "title"   => "Tugas Baru 🚀",
                "message" => "Guru menambahkan tugas: " . $request->name,
                "type"    => "tugas",
            ]);
        }

        if ($request->ajax()) {
            return response()->json(["success" => true, "tugas_id" => $tugas->id]);
        }

        return back()->with("success", "Tugas berhasil ditambahkan!");
    }

    public function viewUpdateTugas(Tugas $tugas)

    {
        $kelasMapel = $tugas->kelasMapel ;
        return view('menu.pengajar.tugas.edit', compact("tugas","kelasMapel"));
    }

    public function updateTugas(Request $request, Tugas $tugas)
    {
        $request->validate([
            "judul"      => "required",
            "deskripsi" => "required",
            "due"       => "required|date"
        ]);

        $tugas->update([
            "judul"      => $request->judul,
            "deskripsi" => $request->deskripsi,
            "due"       => $request->due,
        ]);

        return back()->with("success", "Tugas berhasil diperbarui!");
    }

public function siswaUpdateNilai(Request $request, Tugas $tugas)
{
    $siswaIds      = $request->input('siswaId', []);
    $nilaiList     = $request->input('nilai', []);
    $komentarList  = $request->input('komentar', []);

    foreach ($siswaIds as $index => $siswaId) {

        $nilai    = $nilaiList[$index] ?? null;
        $komentar = $komentarList[$index] ?? null;

        // SIMPAN / UPDATE NILAI
        if ($nilai !== null && $nilai !== '') {
            NilaiTugas::updateOrCreate(
                ['tugas_id' => $tugas->id, 'siswa_id' => $siswaId],
                ['nilai' => $nilai]
            );
        }

        // SIMPAN / UPDATE KOMENTAR
        if ($komentar !== null) {
            $pengumpulan = PengumpulanTugas::firstOrCreate(
                ['tugas_id' => $tugas->id, 'siswa_id' => $siswaId],
                ['submitted_at' => now(), 'is_late' => false]
            );

            $pengumpulan->komentar = $komentar;
            $pengumpulan->save();
        }
    }

    return back()->with("success", "Nilai & komentar berhasil disimpan!");
}

public function rekapNilaiTugas(KelasMapel $kelasMapel)
{
    // Ambil semua tugas dalam kelas-mapel ini
    $tugasList = Tugas::where("kelas_mapel_id", $kelasMapel->id)->get();

    // Ambil semua siswa dalam kelas ini
    $siswaList = DataSiswa::where("kelas_id", $kelasMapel->kelas_id)->get();

    // Ambil semua nilai siswa untuk tugas-tugas tersebut
    $nilaiList = \App\Models\NilaiTugas::whereIn("tugas_id", $tugasList->pluck('id'))->get();

    return view("menu.pengajar.tugas.rekap", compact(
        "kelasMapel",
        "tugasList",
        "siswaList",
        "nilaiList"
    ));
}

    public function destroyTugas(Tugas $tugas)
    {
        $tugas->delete();
        return back()->with("success", "Tugas berhasil dihapus!");
    }
}
