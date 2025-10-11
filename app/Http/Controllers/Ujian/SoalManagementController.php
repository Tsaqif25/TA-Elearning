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
    public function show($ujianId)
    {
    $ujian = Ujian::with('soalUjianMultiple.answer')->findOrFail($ujianId);

        $roles = DashboardController::getRolesName();
        $assignedKelas = DashboardController::getAssignedClass();

        return view('menu.pengajar.ujian.manageSoal', [
            'ujian' => $ujian,
            'roles' => $roles,
            'assignedKelas' => $assignedKelas,
            'title' => 'Kelola Soal'
        ]);
    }

    public function createSoal($ujianId)
    {
        $ujian = Ujian::findOrFail($ujianId);

        $roles = DashboardController::getRolesName();
        $assignedKelas = DashboardController::getAssignedClass();

        return view('menu.pengajar.ujian.viewTambahSoal', [
            'ujian' => $ujian,
            'roles' => $roles,
            'assignedKelas' => $assignedKelas,
            'title' => 'Tambah Soal'
        ]);
    }

    public function storeSoal(Request $request, $ujianId)
    {
        $validated = $request->validate([
            'question'       => 'required|string',
            'answers'        => 'required|array|min:2',
            'answers.*'      => 'required|string',
            'correct_answer' => 'required|integer'
        ]);

        DB::beginTransaction();
        try {
            $soal = SoalUjianMultiple::create([
                'ujian_id' => $ujianId,
                'soal'     => $validated['question'],
            ]);

            foreach ($validated['answers'] as $index => $answerText) {
                SoalUjianAnswer::create([
                    'soal_ujian_id' => $soal->id,
                    'jawaban'       => $answerText,
                    'is_correct'    => ($validated['correct_answer'] == $index),
                ]);
            }

            DB::commit();
            return redirect()->route('ujian.soal.manage', $ujianId)
                ->with('success', 'Soal berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
