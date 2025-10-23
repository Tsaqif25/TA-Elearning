<?php

namespace App\Http\Controllers\Tugas;

use Carbon\Carbon;
use App\Models\Tugas;
use App\Models\UserTugas;
use Illuminate\Http\Request;
use App\Models\UserTugasFile;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;

class TugasSubmitController extends Controller
{


    public function viewTugasSiswa(Tugas $tugas)
    {
        $kelasMapel = $tugas->kelasMapel;
        if (!$kelasMapel) {
            abort(404, 'Kelas Mapel tidak ditemukan untuk tugas ini');
        }

        
        $mapel = $kelasMapel->mapel;
        $kelas = $kelasMapel->kelas;
        $tugasAll = Tugas::where('kelas_mapel_id', $kelasMapel->id)->get();
        $userTugas = UserTugas::where('tugas_id', $tugas->id)
            ->where('user_id', auth()->id())
            ->first();
        $title = $tugas->name;
        // $assignedKelas = DashboardController::getAssignedClass();

        return view('menu.siswa.tugas.uploadtugas', compact(
            'tugas',
            'kelas',
            'mapel',
            'tugasAll',
            'userTugas',
            'title' ,
            'kelasMapel',
            'assignedKelas'
        ));
    }
    public function submitTugas(Tugas $tugas)
    {
        $data = [
            'tugas_id' => $tugas->id,
            'user_id' => auth()->id(),
            'status' => 'Selesai',
        ];

        UserTugas::firstOrCreate(
            ['tugas_id' => $tugas->id, 'user_id' => auth()->id()],
            $data
        );

        return redirect()->route('viewKelasMapel', [
            'mapel' => $tugas->kelasMapel->mapel_id,
            'kelas' => $tugas->kelasMapel->kelas_id,
            'tab' => 'tugas'
        ])->with('success', 'Tugas berhasil disubmit!');
    }

    /**
     * Upload file jawaban siswa
     */
    public function submitFileTugas(Request $request)
    {
        $request->validate([
            'tugasId' => 'required|integer|exists:tugas,id',
            'file' => 'required|file|max:5120', // max 5 MB
        ]);

        $tugas = Tugas::findOrFail($request->tugasId);
        $userId = auth()->id();

        $now = Carbon::now('Asia/Jakarta');
        $dueDate = Carbon::parse($tugas->due, 'Asia/Jakarta');

        if ($dueDate < $now) {
            return response()->json(['message' => 'Tugas sudah ditutup'], 403);
        }

        $userTugas = UserTugas::firstOrCreate(
            ['tugas_id' => $tugas->id, 'user_id' => $userId],
            ['status' => 'Selesai']
        );

        // Upload file
        $file = $request->file('file');
        $fileName = 'F' . mt_rand(1, 999) . '_' . $file->getClientOriginalName();
        $file->move(storage_path('app/public/file/tugas/user'), $fileName);

        UserTugasFile::create([
            'user_tugas_id' => $userTugas->id,
            'file' => $fileName,
        ]);

        return response()->json(['message' => 'Upload sukses']);
    }

    /**
     * Hapus file jawaban siswa
     */

    public function destroyFileSubmit(Request $request)
    {
        $request->validate([
            'fileName' => 'required|string'
        ]);

        $fileName = $request->fileName;
        $fileData = UserTugasFile::where('file', $fileName)->firstOrFail();

        $dest = storage_path('app/public/file/tugas/user');
        $path = $dest . '/' . $fileName;

        if (file_exists($path)) {
            unlink($path);
        }

        // Simpan user_tugas_id sebelum record dihapus
        $userTugasId = $fileData->user_tugas_id;

        // Hapus file dari DB
        $fileData->delete();

        // Update status userTugas kalau tidak ada file tersisa
        $countFile = UserTugasFile::where('user_tugas_id', $userTugasId)->count();
        if ($countFile <= 0) {
            UserTugas::where('id', $userTugasId)->update([
                'status' => 'Belum Mengerjakan'
            ]);
        }

        return back()->with('success', 'File jawaban berhasil dihapus');
    }
}
