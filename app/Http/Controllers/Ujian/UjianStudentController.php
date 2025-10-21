<?php

namespace App\Http\Controllers\Ujian;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Ujian;
use App\Models\UserJawaban;
use Illuminate\Http\Request;
use App\Models\SoalUjianAnswer;
use App\Models\SoalUjianMultiple;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

class UjianStudentController extends Controller
{
public function ujianAccess(Ujian $ujian, Kelas $kelas, Mapel $mapel)
{
    // 🔹 Muat semua soal + jawabannya sekaligus agar tidak query berulang di Blade
    $ujian->load('soalUjianMultiple.answer');

    $roles = DashboardController::getRolesName();
    $assignedKelas = DashboardController::getAssignedClass();

    // 🔹 Ambil SEMUA jawaban siswa dalam 1 query saja
    $siswaJawaban = UserJawaban::where('user_id', Auth::id())
        ->whereIn('multiple_id', $ujian->soalUjianMultiple->pluck('id'))
        ->get()
        ->keyBy('multiple_id'); // -> agar bisa dipanggil langsung di Blade seperti array: $siswaJawaban[$id]

    // 🔹 Cek apakah siswa sudah menjawab minimal 1 soal
    $sudahMenjawab = $siswaJawaban->isNotEmpty();

    // 🔹 Kirim ke view
    return view('menu.siswa.ujian.ujianAccess', compact(
        'ujian',
        'kelas',
        'mapel',
        'roles',
        'assignedKelas',
        'sudahMenjawab',
        'siswaJawaban'
    ));
}


    public function startUjian(Ujian $ujian)
    {
        $firstSoal = $ujian->soalUjianMultiple()->first();

        if (!$firstSoal) {
            return back()->with('error', 'Belum ada soal pada ujian ini.');
        }

        return redirect()->route('ujian.userUjian', [
            'ujian' => $ujian->id,
            'soal' => $firstSoal->id,
        ]);
    }

    public function siswaUjian(Ujian $ujian, SoalUjianMultiple $soal)
    {
        if ($soal->ujian_id !== $ujian->id) {
            abort(404, 'Soal tidak ditemukan pada ujian ini.');
        }

        $soal->load('answer');

        return view('menu.siswa.ujian.learning', compact('ujian', 'soal'));
    }

// Mari kita tambahkan debug logging agar tahu di mana prosesnya gagal

public function storeAnswer(Request $request, Ujian $ujian, SoalUjianMultiple $soal)
{
    $validated = $request->validate([
        'answer_id' => 'required|exists:soal_ujian_answers,id',
    ]);

    DB::beginTransaction();
    try {
        $selectedAnswer = SoalUjianAnswer::findOrFail($validated['answer_id']);

        // ✅ Log debug agar tahu ID yang diterima
        Log::info('Jawaban yang dipilih:', [
            'user_id' => Auth::id(),
            'ujian_id' => $ujian->id,
            'soal_id' => $soal->id,
            'answer_id' => $selectedAnswer->id,
            'jawaban' => $selectedAnswer->jawaban,
        ]);

        // ✅ Cek apakah sudah menjawab sebelumnya
        $existing = UserJawaban::where('user_id', Auth::id())
            ->where('multiple_id', $soal->id)
            ->first();

        if (!$existing) {
            $jawaban = UserJawaban::create([
                'user_id' => Auth::id(),
                'multiple_id' => $soal->id,
                'soal_ujian_answer_id' => $selectedAnswer->id,
                'user_jawaban' => $selectedAnswer->jawaban,
            ]);

            
        } else {
            Log::warning('User sudah menjawab soal ini sebelumnya', [
                'user_id' => Auth::id(), 'soal_id' => $soal->id,
            ]);
        }

        DB::commit();

        // ✅ Redirect ke soal berikutnya
        $nextSoal = SoalUjianMultiple::where('ujian_id', $ujian->id)
            ->where('id', '>', $soal->id)
            ->orderBy('id', 'asc')
            ->first();

        if ($nextSoal) {
            return redirect()->route('ujian.userUjian', [
                'ujian' => $ujian->id,
                'soal' => $nextSoal->id,
            ]);
        }

       return redirect()->route('ujian.learning.finished', ['ujian' => $ujian->id]) ;


    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal menyimpan jawaban:', ['error' => $e->getMessage()]);
        return back()->withErrors(['system_error' => $e->getMessage()]);
    }
}


    public function learningFinished(Ujian $ujian)
    {
        return view('menu.siswa.ujian.learning-finished', compact('ujian'));
    }

    public function learningRapport(Ujian $ujian)
    {
        $studentAnswers = UserJawaban::with(['soalUjianMultiple.answer'])
            ->where('user_id', Auth::id())
            ->whereIn('multiple_id', $ujian->soalUjianMultiple->pluck('id'))
            ->get();

        $totalQuestions = $ujian->soalUjianMultiple->count();

        $correctAnswers = $studentAnswers->filter(function ($ans) {
            $correct = $ans->soalUjianMultiple?->answer->firstWhere('is_correct', 1);
            return $correct && $ans->user_jawaban === $correct->jawaban;
        })->count();

        return view('menu.siswa.ujian.learning-raport', compact('ujian', 'studentAnswers', 'totalQuestions', 'correctAnswers'));
    }
}
