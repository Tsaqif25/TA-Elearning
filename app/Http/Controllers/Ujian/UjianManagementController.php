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

   public function index($kelasId, $mapelId)
    {
        $mapel = Mapel::findOrFail($mapelId);
        $kelas = Kelas::findOrFail($kelasId);

        $roles = DashboardController::getRolesName();
        $assignedKelas = DashboardController::getAssignedClass();

        $kelasMapel = KelasMapel::where('mapel_id', $mapelId)
            ->where('kelas_id', $kelasId)
            ->firstOrFail();

        $ujians = Ujian::where('kelas_mapel_id', $kelasMapel->id)
            ->with('soalUjianMultiple')
            ->get();
            

        return view('menu.pengajar.ujian.manageUjian', [
            'assignedKelas' => $assignedKelas,
            'roles' => $roles,
            'mapel' => $mapel,
            'kelas' => $kelas,
            'kelasMapel'=> $kelasMapel,
            'kelasId' => $kelasId,
            'mapelId' => $mapelId,
            'ujians' => $ujians,
            'title' => 'Manage Ujian'
        ]);
    }

    // FORM TAMBAH UJIAN
    public function create(Request $request, $kelasId, $mapelId)
    {
        $roles = DashboardController::getRolesName();
        $mapel = Mapel::findOrFail($mapelId);
        $assignedKelas = DashboardController::getAssignedClass();

        return view('menu.pengajar.ujian.viewTambahUjian', [
            'assignedKelas' => $assignedKelas,
            'tipe'          => $request->type,
            'title'         => 'Tambah Ujian',
            'roles'         => $roles,
            'kelasId'       => $kelasId,
            'mapel'         => $mapel,
        ]);
    }

    // SIMPAN UJIAN BARU
 public function store(Request $request)
{
    $validated = $request->validate([
        'kelas_id' => 'required|exists:kelas,id',
        'mapel_id' => 'required|exists:mapels,id',
        'name'     => 'required|string|max:255',
        'time'     => 'required|integer',
        'due'      => 'required|date',
    ]);

    DB::beginTransaction();
    try {
        $kelasMapel = KelasMapel::where('kelas_id', $validated['kelas_id'])
            ->where('mapel_id', $validated['mapel_id'])
            ->firstOrFail();

        $ujian = Ujian::create([
            'kelas_mapel_id' => $kelasMapel->id,
            'name'           => $validated['name'],
            'time'           => $validated['time'],
            'due'            => $validated['due'],
        ]);

        DB::commit();

        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Ujian berhasil dibuat!',
                'ujian_id' => $ujian->id
            ]);
        }

        // ✅ Kalau normal, redirect ke halaman kelas-mapel
        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id,
            'kelas' => $kelasMapel->kelas_id
        ])->with('success', 'Ujian berhasil dibuat! Silakan tambahkan soal.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}


public function viewUpdateUjian($id)
{
    $ujian = Ujian::with(['soalUjianMultiple.answers'])->findOrFail($id);

    $kelasMapel = $ujian->kelasMapel;
    $mapel = $kelasMapel->mapel;
    $kelas = $kelasMapel->kelas;

    $roles = DashboardController::getRolesName();
    $assignedKelas = DashboardController::getAssignedClass();

    return view('menu.pengajar.ujian.viewUpdateUjian', [
        'assignedKelas' => $assignedKelas,
        'title' => 'Update Ujian',
        'ujian' => $ujian,
        'roles' => $roles,
        'kelasId' => $kelas->id,
        'mapel' => $mapel,
    ]);
}

public function updateUjian(Request $request)
{
    $validated = $request->validate([
        'ujian_id'       => 'required|exists:ujians,id',
        'name'           => 'required|string|max:255',
        'time'           => 'required|integer',
        'due'            => 'required|date',
        'question'       => 'required|string',
        'answers'        => 'required|array|min:2',
        'answers.*'      => 'required|string',
        'correct_answer' => 'required|integer'
    ]);

    DB::beginTransaction();
    try {
        $ujian = Ujian::with('kelasMapel')->findOrFail($validated['ujian_id']);

        // Update ujian
        $ujian->update([
            'name' => $validated['name'],
            'time' => $validated['time'],
            'due'  => $validated['due'],
        ]);

        // Update soal
        $soal = $ujian->soalUjianMultiple()->first();
        if (!$soal) {
            $soal = SoalUjianMultiple::create([
                'ujian_id' => $ujian->id,
                'soal'     => $validated['question'],
            ]);
        } else {
            $soal->update(['soal' => $validated['question']]);
            $soal->answers()->delete();
        }

        // Simpan jawaban baru
        foreach ($validated['answers'] as $index => $answerText) {
            SoalUjianAnswer::create([
                'soal_ujian_id' => $soal->id,
                'jawaban'       => $answerText,
                'is_correct'    => ($validated['correct_answer'] == $index) ? 1 : 0,
            ]);
        }

        DB::commit();
        return redirect()->route('manageUjian', [
            'kelasId' => $ujian->kelasMapel->kelas_id,
            'mapelId' => $ujian->kelasMapel->mapel_id
        ])->with('success', 'Ujian berhasil diperbarui!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }

}

public function destroy(Request $request)
{
    $ujianId = $request->hapusId;

    foreach (auth()->user()->EditorAccess as $key) {
        if ($key->kelas_mapel_id == $request->kelasMapelId) {

            // Hapus ujian
            Ujian::where('id', $ujianId)->delete();

            // Hapus soal & jawaban
            $soalIds = SoalUjianMultiple::where('ujian_id', $ujianId)->pluck('id');
            SoalUjianMultiple::where('ujian_id', $ujianId)->delete();
            UserJawaban::whereIn('multiple_id', $soalIds)->delete();

            return redirect()->back()->with('success', 'Ujian Berhasil dihapus');
        }
    }
}
}



?>