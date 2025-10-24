<?php

namespace App\Http\Controllers\Tugas;

use App\Http\Controllers\Controller;
use App\Models\{Tugas, UserTugas, UserTugasFile};
use Illuminate\Http\Request;
use Carbon\Carbon;

class TugasSubmitController extends Controller
{
    /**
     *  Menampilkan halaman pengumpulan tugas untuk siswa
     */
    public function viewTugasSiswa(Tugas $tugas)
    {
        $kelasMapel = $tugas->kelasMapel ?? abort(404, 'Kelas Mapel tidak ditemukan.');

        return view('menu.siswa.tugas.uploadtugas', [
            'title'      => $tugas->name,
            'tugas'      => $tugas,
            'kelas'      => $kelasMapel->kelas,
            'mapel'      => $kelasMapel->mapel,
            'kelasMapel' => $kelasMapel,
            'tugasAll'   => Tugas::where('kelas_mapel_id', $kelasMapel->id)->get(),
            'userTugas'  => UserTugas::where('tugas_id', $tugas->id)
                                     ->where('user_id', auth()->id())
                                     ->first(),
        ]);
    }

    /**
     *  Simpan status pengumpulan tugas (tanpa file)
     */
    public function submitTugas(Tugas $tugas)
    {
        UserTugas::firstOrCreate(
            ['tugas_id' => $tugas->id, 'user_id' => auth()->id()],
            ['status'   => 'Selesai']
        );

        return redirect()->route('viewKelasMapel', [
            'mapel' => $tugas->kelasMapel->mapel_id,
            'kelas' => $tugas->kelasMapel->kelas_id,
            'tab'   => 'tugas',
        ])->with('success', 'Tugas berhasil disubmit!');
    }

    /**
     *  Upload file jawaban siswa
     */
    public function submitFileTugas(Request $request)
    {
        $validated = $request->validate([
            'tugasId' => 'required|integer|exists:tugas,id',
            'file'    => 'required|file|max:5120', // max 5 MB
        ]);

        $tugas   = Tugas::findOrFail($validated['tugasId']);
        $userId  = auth()->id();
        $now     = Carbon::now('Asia/Jakarta');
        $dueDate = Carbon::parse($tugas->due, 'Asia/Jakarta');

        if ($now->greaterThan($dueDate)) {
            return response()->json(['message' => 'Tugas sudah ditutup.'], 403);
        }

        $userTugas = UserTugas::firstOrCreate(
            ['tugas_id' => $tugas->id, 'user_id' => $userId],
            ['status'   => 'Selesai']
        );

        // Simpan file fisik
        $file = $validated['file'];
        $fileName = 'F' . mt_rand(1, 999) . '_' . $file->getClientOriginalName();
        $file->storeAs('file/tugas/user', $fileName, 'public');

        // Simpan ke database
        UserTugasFile::create([
            'user_tugas_id' => $userTugas->id,
            'file'          => $fileName,
        ]);

        return response()->json(['message' => 'Upload sukses.']);
    }

    /**
     * Hapus file jawaban siswa
     */
    public function destroyFileSubmit(Request $request)
    {
        $validated = $request->validate([
            'fileName' => 'required|string',
        ]);

        $fileData = UserTugasFile::where('file', $validated['fileName'])->firstOrFail();
        $filePath = storage_path("app/public/file/tugas/user/{$validated['fileName']}");

        // Hapus file fisik
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $userTugasId = $fileData->user_tugas_id;
        $fileData->delete();

        // Jika siswa tidak punya file lagi → status dikembalikan ke “Belum Mengerjakan”
        if (!UserTugasFile::where('user_tugas_id', $userTugasId)->exists()) {
            UserTugas::where('id', $userTugasId)->update(['status' => 'Belum Mengerjakan']);
        }

        return back()->with('success', 'File jawaban berhasil dihapus.');
    }
}
