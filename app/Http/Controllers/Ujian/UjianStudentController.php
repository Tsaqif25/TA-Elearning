<?php

namespace App\Http\Controllers\Ujian;

use App\Http\Controllers\Controller;
use App\Models\Ujian ;
 use App\Models\SoalUjianMultiple ; 
use App\Models\SoalUjianAnswer ;
use App\Models\UserJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UjianStudentController extends Controller
{
    public function ujianAccess($id, $kelasId, $mapelId)
{
    $ujian = Ujian::with('soalUjianMultiple')->findOrFail($id);
    $kelas = \App\Models\Kelas::findOrFail($kelasId);
    $mapel = \App\Models\Mapel::findOrFail($mapelId);

    $roles = \App\Http\Controllers\DashboardController::getRolesName();
    $assignedKelas = \App\Http\Controllers\DashboardController::getAssignedClass();

    $sudahMenjawab = UserJawaban::where('user_id', Auth::id())
        ->whereIn('multiple_id', $ujian->soalUjianMultiple->pluck('id'))
        ->exists();

    return view('menu.siswa.ujian.ujianAccess', compact('ujian', 'kelas', 'mapel', 'roles', 'assignedKelas', 'sudahMenjawab'));
}


public function startUjian($id)
{
    $ujian = Ujian::with('soalUjianMultiple')->findOrFail($id);
    $firstSoal = $ujian->soalUjianMultiple->first();

    if (!$firstSoal) {
        return back()->with('error', 'Belum ada soal pada ujian ini.');
    }

    return redirect()->route('ujian.userUjian', [
        'ujian' => $ujian->id,
        'soal' => $firstSoal->id,
    ]);
}


public function siswaUjian(Request $request, Ujian $ujian)
{
    $soalId = $request->get('soal');
    $soal = $soalId ? SoalUjianMultiple::with('answer')->findOrFail($soalId)
                    : $ujian->soalUjianMultiple()->with('answer')->first();

    return view('menu.siswa.ujian.learning', compact('ujian', 'soal'));
}


public function storeAnswer(Request $request, Ujian $ujian, SoalUjianMultiple $soal)
{
    $validated = $request->validate([
        'answer_id' => 'required|exists:soal_ujian_answers,id',
    ]);

    DB::beginTransaction();
    try {
        $selectedAnswer = SoalUjianAnswer::findOrFail($validated['answer_id']);
        $existing = UserJawaban::where('user_id', Auth::id())
            ->where('multiple_id', $soal->id)
            ->first();

        if ($existing) {
            throw \Illuminate\Validation\ValidationException::withMessages(['system_error' => 'Kamu sudah menjawab pertanyaan ini!']);
        }

        UserJawaban::create([
            'user_id' => Auth::id(),
            'multiple_id' => $soal->id,
            'soal_ujian_answer_id' => $selectedAnswer->id,
            'user_jawaban' => $selectedAnswer->jawaban,
        ]);

        DB::commit();

        $nextSoal = SoalUjianMultiple::where('ujian_id', $ujian->id)
            ->where('id', '>', $soal->id)
            ->orderBy('id', 'asc')
            ->first();

        if ($nextSoal) {
            return redirect()->route('userUjian', [
                'ujian' => $ujian->id,
                'soal' => $nextSoal->id,
            ]);
        }

        return redirect()->route('ujian.learning.finished', $ujian->id);

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['system_error' => $e->getMessage()]);
    }
}


public function learningFinished(Ujian $ujian)
{
    return view('menu.siswa.ujian.learning-finished', compact('ujian'));
}


public function learningRapport(Ujian $ujian)
{
    $studentAnswers = UserJawaban::with('soalUjianMultiple.answer')
        ->where('user_id', Auth::id())
        ->whereIn('multiple_id', $ujian->soalUjianMultiple->pluck('id'))
        ->get();

    $totalQuestions = $ujian->soalUjianMultiple->count();
    $correctAnswers = $studentAnswers->filter(function ($ans) {
        $correct = $ans->soalUjianMultiple->answer->firstWhere('is_correct', 1);
        return $correct && $ans->user_jawaban == $correct->jawaban;
    })->count();

    return view('menu.siswa.ujian.learning-raport', compact('ujian', 'studentAnswers', 'totalQuestions', 'correctAnswers'));
}
}
