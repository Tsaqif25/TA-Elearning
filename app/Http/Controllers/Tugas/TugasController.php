<?php

namespace App\Http\Controllers\Tugas;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\DashboardController;
use Exception; // Menggunakan kelas Exception
use App\Models\User; // Menggunakan model User
use App\Models\Kelas; // Menggunakan model Kelas
use App\Models\Mapel; // Menggunakan model Mapel
use App\Models\Tugas; // Menggunakan model Tugas
use App\Models\TugasFile; // Menggunakan model TugasFile
use App\Models\UserTugas; // Menggunakan model UserTugas
use App\Models\KelasMapel; // Menggunakan model KelasMapel
use App\Models\EditorAccess; // Menggunakan model EditorAccess
use App\Models\UserTugasFile; // Menggunakan model UserTugasFile
use Illuminate\Http\Request; // Menggunakan kelas Request dari Illuminate
use Illuminate\Support\Facades\DB; // Menggunakan DB dari Illuminate\Support\Facades

class TugasController extends Controller
{

   public function viewTugas(Tugas $tugas)
{
$kelasMapel = $tugas->kelasMapel;

if (!$kelasMapel) {
    abort(404, 'Kelas Mapel tidak ditemukan untuk tugas ini');
}

$mapel        = $kelasMapel->mapel;
$kelas        = $kelasMapel->kelas;

$editorAccess = $kelasMapel->editorAccess()->first();
$tugasAll     = Tugas::where('kelas_mapel_id', $kelasMapel->id)->get();
$userTugas    = UserTugas::where('tugas_id', $tugas->id)
                            ->where('user_id', auth()->id())
                            ->first();

$title        = $tugas->name;

return view('menu.pengajar.tugas.view', compact(
    'userTugas',
 
    'tugas',
    'kelas',
    'title',
  
    'tugasAll',
    'mapel',
    'kelasMapel',
    'editorAccess'
));
}





    public function siswaUpdateNilai(Request $request, Tugas $tugas)
    {
        foreach ($request->nilai as $i => $nilaiInput) {
            if ($nilaiInput !== null && $nilaiInput !== '') {
                $nilai = max(0, min(100, (int) $nilaiInput)); // clamp nilai 0–100

                $userId = $request->siswaId[$i];
                $exist = UserTugas::where('tugas_id', $tugas->id)
                    ->where('user_id', $userId)
                    ->first();

                if ($exist) {
                    $exist->update([
                        'status' => 'Telah dinilai',
                        'nilai' => $nilai,
                    ]);
                } else {
                    UserTugas::create([
                        'tugas_id' => $tugas->id,
                        'user_id' => $userId,
                        'status' => 'Telah dinilai',
                        'nilai' => $nilai,
                    ]);
                }
            }
        }

        return back()->with('success', 'Nilai berhasil diperbarui');
    }

    public function viewCreateTugas(KelasMapel $kelasMapel)
    {
        // Cari kelasMapel
        $kelasMapel->load(['kelas', 'mapel']);


        $title = 'Tambah Tugas';

        return view('menu.pengajar.tugas.add', [
            'title' => $title,
            'kelasMapel' => $kelasMapel,
            'tab' => 'tugas',
        ]);

    }


    public function viewUpdateTugas(Tugas $tugas)
    {
        $kelasMapel = $tugas->kelasMapel;
        $title = 'Update Tugas';
        $kelasId = $kelasMapel->kelas_id;
        $mapel = $kelasMapel->mapel;

        return view('menu.pengajar.tugas.edit', [
            'title' => $title,
            'tugas' => $tugas,
            'kelasId' => $kelasId,
            'mapel' => $mapel,
            'kelasMapel' => $kelasMapel,
            'tab' => 'tugas',
        ]);
    }

    public function createTugas(Request $request, KelasMapel $kelasMapel)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'content' => 'required|string',
                'due' => 'required|date_format:Y-m-d\TH:i',
            ]);

            $due = Carbon::createFromFormat('Y-m-d\TH:i', $request->due);

            // Simpan data tugas ke database
            $tugas = Tugas::create([
                'kelas_mapel_id' => $kelasMapel->id,
                'name' => $request->name,
                'content' => $request->input('content'),
                'due' => $due,
            ]);

            //  Jika request dari AJAX (Dropzone)
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'tugas_id' => $tugas->id,
                ]);
            }

            return redirect()->route('viewKelasMapel', [
                'mapel' => $kelasMapel->mapel_id,
                'kelas' => $kelasMapel->kelas_id,
                'tab' => 'tugas'
            ])->with('success', 'Tugas berhasil ditambahkan!');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function updateTugas(Request $request, Tugas $tugas)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required',
            'due' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $tugas->update([
            'name' => $request->name,
            'content' => $request->input('content'),
            'due' => Carbon::createFromFormat('Y-m-d\TH:i', $request->due),

        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'tugas_id' => $tugas->id,
                'message' => 'Tugas berhasil diperbarui!',
            ]);
        }

        return redirect()->route('viewKelasMapel', [
            'mapel' => $tugas->kelasMapel->mapel_id,
            'kelas' => $tugas->kelasMapel->kelas_id,
            'tab' => 'tugas'
        ])->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroyTugas(Tugas $tugas)
    {
        $kelasMapel = $tugas->kelasMapel;
        $tugas->delete();

        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id,
            'kelas' => $kelasMapel->kelas_id,
            'tab' => 'tugas'
        ])->with('success', 'Tugas berhasil dihapus!');
    }
}
