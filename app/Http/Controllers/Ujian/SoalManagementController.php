<?php

namespace App\Http\Controllers\Ujian;

use App\Http\Controllers\Controller;
use App\Models\Ujian;
use App\Models\SoalUjianMultiple;
use App\Models\SoalUjianAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DashboardController;

class SoalManagementController extends Controller
{

public function show(Ujian $ujian)
{
    // ambil kelas_mapel (otomatis bawa relasi kelas & mapel lewat accessor di model)
    $kelasMapel = $ujian->kelasMapel;

    // ambil kelas yang diajar guru (opsional, untuk sidebar/dashboard)
    // $assignedKelas = DashboardController::getAssignedClass();

    return view('menu.pengajar.ujian.manageSoal', [
        'ujian' => $ujian,
        'kelasMapel' => $kelasMapel,
        // 'assignedKelas' => $assignedKelas,
        'title' => 'Kelola Soal',
    ]);
}


public function createSoal(Ujian $ujian)
{
    // Ambil relasi kelas_mapel secara langsung
    $kelasMapel = $ujian->kelasMapel;

    // Ambil data kelas dan mapel secara manual dari relasi KelasMapel
    $kelas = $kelasMapel->kelas;
    $mapel = $kelasMapel->mapel;

    // Ambil kelas yang diampu guru (opsional, untuk sidebar/dashboard)
    // $assignedKelas = DashboardController::getAssignedClass();

    // Kirim semua data ke view
    return view('menu.pengajar.ujian.viewTambahSoal', [
        'ujian' => $ujian,
        'kelasMapel' => $kelasMapel,
        'kelas' => $kelas,
        'mapel' => $mapel,
        // 'assignedKelas' => $assignedKelas,
        'title' => 'Tambah Soal',
    ]);
}


public function editSoal(Ujian $ujian, SoalUjianMultiple $soal)
{
    $kelasMapel = $ujian->kelasMapel;
    // $assignedKelas = DashboardController::getAssignedClass();

    return view('menu.pengajar.ujian.viewEditSoal', [
        'ujian' => $ujian,
        'soal' => $soal,
        'kelasMapel' => $kelasMapel,
        'assignedKelas' => $assignedKelas,
        'title' => 'Edit Soal',
    ]);
}


public function updateSoal(Request $request, Ujian $ujian, SoalUjianMultiple $soal)
{
    $validated = $request->validate([
        'question'       => 'required|string',
        'answers'        => 'required|array|min:2',
        'answers.*'      => 'required|string',
        'correct_answer' => 'required|integer'
    ]);

    DB::beginTransaction();
    try {
        // update pertanyaan utama
        $soal->update([
            'soal' => $validated['question'],
        ]);

        // hapus semua jawaban lama
        $soal->answer()->delete();

        // simpan jawaban baru
        foreach ($validated['answers'] as $index => $answerText) {
            $soal->answer()->create([
                'jawaban'    => $answerText,
                'is_correct' => ($validated['correct_answer'] == $index),
            ]);
        }

        DB::commit();
        return redirect()->route('ujian.soal.manage', $ujian->id)
            ->with('success', 'Soal berhasil diperbarui!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal memperbarui soal: ' . $e->getMessage());
    }
}




public function destroySoal(Ujian $ujian, SoalUjianMultiple $soal)
{
    try {
        $soal->answer()->delete(); // hapus semua jawaban
        $soal->delete(); // hapus soal utama

        return redirect()->route('soal.manage', $ujian->id)
            ->with('success', 'Soal berhasil dihapus!');
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal menghapus soal: ' . $e->getMessage());
    }
}





    

    public function storeSoal(Request $request, Ujian $ujian)
{
    $validated = $request->validate([
        'question'       => 'required|string',
        'answers'        => 'required|array|min:2',
        'answers.*'      => 'required|string',
        'correct_answer' => 'required|integer'
    ]);

    DB::beginTransaction();
    try {
        $soal = $ujian->soalUjianMultiple()->create([
            'soal' => $validated['question'],
        ]);

        foreach ($validated['answers'] as $index => $answerText) {
            $soal->answer()->create([
                'jawaban'    => $answerText,
                'is_correct' => ($validated['correct_answer'] == $index),
            ]);
        }

        DB::commit();
        return redirect()->route('ujian.soal.manage', $ujian->id)
            ->with('success', 'Soal berhasil ditambahkan!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

}
