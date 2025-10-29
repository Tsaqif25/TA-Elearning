<?php

namespace App\Http\Controllers\Ujian;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Ujian;
use App\Models\KelasMapel;
use App\Models\UserCommit;
use App\Models\UserJawaban;
use Illuminate\Http\Request;
use App\Models\SoalUjianAnswer;
use App\Imports\SoalUjianImport;
use App\Models\SoalUjianMultiple;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use Illuminate\Validation\ValidationException;



class UjianManagementController extends Controller
{



    // FORM TAMBAH UJIAN
    public function create(KelasMapel $kelasMapel, Request $request)
    {
        $kelasMapel->load(['kelas', 'mapel']);
        return view('menu.pengajar.ujian.viewTambahUjian', [
            'kelasMapel' => $kelasMapel,
            'title' => 'Tambah Ujian',
            'tipe' => $request->type,
        ]);
    }

    // SIMPAN UJIAN BARU
    public function store(Request $request, KelasMapel $kelasMapel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
           
            'due' => 'required|date',
        ]);

        $ujian = Ujian::create([
            'kelas_mapel_id' => $kelasMapel->id,
            'name' => $validated['name'],
          
            'due' => $validated['due'],
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Ujian berhasil dibuat!', 'ujian_id' => $ujian->id]);
        }



        return redirect()->route('ujian.soal.manage', $ujian->id)
            ->with('success', 'Ujian berhasil dibuat! Silakan tambahkan soal ujian.');
    }



    public function edit(Ujian $ujian)
    {
        $kelasMapel = $ujian->kelasMapel; // relasi belongsTo

        return view('menu.pengajar.ujian.viewUpdateUjian', [
            'ujian' => $ujian,
            'kelasMapel' => $kelasMapel,
        ]);
    }


    public function update(Request $request, Ujian $ujian)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
       
            'due' => 'required|date',
        ]);

        $ujian->update([
            'name' => $validated['name'],
         
            'due' => $validated['due'],
        ]);



        return redirect()->route('ujian.soal.manage', $ujian->id)
            ->with('success', 'Ujian berhasil dibuat! Silakan tambahkan soal ujian.');


    }



    public function destroy(Ujian $ujian)
    {

        // Ambil relasi kelasMapel
        $kelasMapel = $ujian->kelasMapel;

        // $kelasMapelId = $ujian->kelas_mapel_id;
        $ujian->delete();

        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id,
            'kelas' => $kelasMapel->kelas_id,
            'tab' => 'quiz'
        ])->with('success', 'Materi berhasil ditambahkan!');
    }






}



?>