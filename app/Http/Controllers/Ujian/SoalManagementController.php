<?php

namespace App\Http\Controllers\Ujian;

use App\Models\Ujian;
use App\Models\SoalUjian;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SoalUjianImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SoalManagementController extends Controller
{
    // ============================
    // 1. SHOW (MANAGE SOAL)
    // ============================
    public function show(Ujian $ujian)
    {
        $kelasMapel = $ujian->kelasMapel;

        return view('menu.pengajar.ujian.manageSoal', [
            'ujian'       => $ujian,
            'kelasMapel'  => $kelasMapel,
            'kelas'       => $kelasMapel->kelas,
            'mapel'       => $kelasMapel->mapel,
            'soal'        => $ujian->soal, // relasi
            'title'       => 'Kelola Soal',
        ]);
    }


    // ============================
    // 2. CREATE FORM
    // ============================
    public function createSoal(Ujian $ujian)
    {
        $kelasMapel = $ujian->kelasMapel;

        return view('menu.pengajar.ujian.viewTambahSoal', [
            'ujian'      => $ujian,
            'kelasMapel' => $kelasMapel,
            'kelas'      => $kelasMapel->kelas,
            'mapel'      => $kelasMapel->mapel,
            'title'      => 'Tambah Soal',
        ]);
    }


    // ============================
    // 3. STORE SOAL
    // ============================
    public function storeSoal(Request $request, Ujian $ujian)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'option_1'   => 'required|string',
            'option_2'   => 'required|string',
            'option_3'   => 'required|string',
            'option_4'   => 'required|string',
            'option_5'   => 'nullable|string',
            'answer'     => 'required|integer|min:1|max:5'
        ]);

        SoalUjian::create([
            'ujian_id'   => $ujian->id,
            'pertanyaan' => $validated['pertanyaan'],
            'option_1'   => $validated['option_1'],
            'option_2'   => $validated['option_2'],
            'option_3'   => $validated['option_3'],
            'option_4'   => $validated['option_4'],
            'option_5'   => $validated['option_5'],
            'answer'     => $validated['answer'],
        ]);

        return redirect()->route('ujian.soal.preview', $ujian->id)
            ->with('success', 'Soal berhasil ditambahkan!');
    }


    // ============================
    // 4. EDIT
    // ============================
    public function editSoal(Ujian $ujian, SoalUjian $soal)
    {
        $kelasMapel = $ujian->kelasMapel;

        return view('menu.pengajar.ujian.viewEditSoal', [
            'ujian'      => $ujian,
            'soal'       => $soal,
            'kelasMapel' => $kelasMapel,
            'kelas'      => $kelasMapel->kelas,
            'mapel'      => $kelasMapel->mapel,
            'title'      => 'Edit Soal',
        ]);
    }


    // ============================
    // 5. UPDATE
    // ============================
    public function updateSoal(Request $request, Ujian $ujian, SoalUjian $soal)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'option_1'   => 'required|string',
            'option_2'   => 'required|string',
            'option_3'   => 'required|string',
            'option_4'   => 'required|string',
            'option_5'   => 'nullable|string',
            'answer'     => 'required|integer|min:1|max:5'
        ]);

        $soal->update($validated);
   return redirect()->route('ujian.soal.preview', $ujian->id)
            ->with('success', 'Soal berhasil diperbarui!');
    }

public function previewAll(Ujian $ujian)
{
    $kelasMapel = $ujian->kelasMapel;

    return view('menu.pengajar.ujian.semuaSoal', [
        'ujian'      => $ujian,
        'kelasMapel' => $kelasMapel,
        'kelas'      => $kelasMapel->kelas,
        'mapel'      => $kelasMapel->mapel,
        'soal'       => $ujian->soal,
    ]);
}

public function importView(Ujian $ujian)
{
    return view('menu.pengajar.ujian.importSoal', compact('ujian'));
}

public function import(Request $request, Ujian $ujian)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    Excel::import(new SoalUjianImport($ujian->id), $request->file('file'));

    return redirect()
        ->route('ujian.soal.manage', $ujian->id)
        ->with('success', 'Import soal berhasil dilakukan!');
}




    // ============================
    // 6. DELETE
    // ============================
    public function destroySoal(Ujian $ujian, SoalUjian $soal)
    {
        $soal->delete();

        return redirect()->route('ujian.soal.manage', $ujian->id)
            ->with('success', 'Soal berhasil dihapus!');
    }
}
