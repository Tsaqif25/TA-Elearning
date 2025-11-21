<?php

namespace App\Http\Controllers\Ujian;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Ujian;
use App\Models\UjianAttempt;
use Illuminate\Http\Request;
use App\Models\SoalUjianAnswer;
use App\Models\SoalUjianMultiple;
use App\Models\UjianAttemptAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

class UjianStudentController extends Controller
{

    public function ujianAccess(Ujian $ujian)
{
    return view('menu.siswa.ujian.cbt-access', compact('ujian'));
}

public function start(Ujian $ujian)
{
    $siswa = Auth::user()->dataSiswa;

    if (!$siswa) abort(403);

    $existing = UjianAttempt::where('ujian_id', $ujian->id)
        ->where('siswa_id', $siswa->id)
        ->first();

    if ($existing) {
        return redirect()->route('ujian.show', [$existing->id, 1]);
    }

    // PENTING!!!
    $durasiDetik = $ujian->durasi_menit * 60;

    $attempt = UjianAttempt::create([
        'ujian_id'  => $ujian->id,
        'siswa_id'  => $siswa->id,
        'mulai'     => now(),
        'sisa_waktu' => $durasiDetik,   // JANGAN LUPA INI
    ]);

    foreach ($ujian->soal as $soal) {
        UjianAttemptAnswer::create([
            'ujian_attempt_id' => $attempt->id,
            'soal_ujian_id'    => $soal->id,
            'answer'           => 0,
            'is_corret'        => false,
        ]);
    }

    return redirect()->route('ujian.show', [$attempt->id, 1]);
}



public function siswaUjian(UjianAttempt $attempt, $nomor)
{
    // CEK JIKA UJIAN SUDAH SELESAI
    if ($attempt->selesai !== null) {
        return redirect()->route('ujian.hasil', $attempt->id)
            ->with('error', 'Ujian ini sudah selesai.');
    }

    $ujian = $attempt->ujian;

    $soal = $ujian->soal()->orderBy('id')->skip($nomor - 1)->first();

    if (!$soal) abort(404);

    $jawaban = $attempt->answers()
        ->where('soal_ujian_id', $soal->id)
        ->first();

    $totalSoal = $ujian->soal->count();
    $sisaWaktu = $attempt->sisa_waktu;

    return view('menu.siswa.ujian.cbt-show', compact(
        'attempt', 'ujian', 'soal', 'jawaban', 'nomor', 'totalSoal', 'sisaWaktu'
    ));
}



 public function updateTimer(Request $request, UjianAttempt $attempt)
    {
        $validated = $request->validate([
            'sisa_waktu' => 'required|integer|min:0'
        ]);

        $attempt->update([
            'sisa_waktu' => $validated['sisa_waktu']
        ]);

        return response()->json([
            'success' => true,
            'sisa_waktu' => $attempt->sisa_waktu
        ]);
    }

public function submit(Request $request, UjianAttempt $attempt, $soalId)
{
    $request->validate([
        'answer' => 'required'
    ]);

    $soal = \App\Models\SoalUjian::findOrFail($soalId);

    // PENENTU BENAR ATAU SALAH
    $correct = ($request->answer == $soal->answer);

    $attempt->answers()->where('soal_ujian_id', $soalId)->update([
        'answer'    => $request->answer,
        'is_corret' => $correct,
    ]);

    return back();
}

public function finish(UjianAttempt $attempt)
{
    // hitung jawaban benar
    $correct = $attempt->answers()->where('is_corret', true)->count();

    // hitung total soal
    $total = $attempt->answers()->count();

    // hitung nilai
    $nilai = round(($correct / $total) * 100);

    // simpan
    $attempt->update([
        'selesai' => now(),
        'nilai'   => $nilai,
    ]);

    // redirect ke hasil
    return redirect()->route('ujian.hasil', $attempt->id);
}

public function result(UjianAttempt $attempt)
{
    $ujian = $attempt->ujian;
    $answers = $attempt->answers()->with('soal')->get();

    return view('menu.siswa.ujian.cbt-result', compact(
        'attempt', 'ujian', 'answers'
    ));
}

}
