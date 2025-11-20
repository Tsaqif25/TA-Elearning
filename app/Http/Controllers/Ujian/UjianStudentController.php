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
    // ambil siswa_id dari tabel data_siswas
    $siswa = Auth::user()->dataSiswa;

    if (!$siswa) {
        abort(403, 'Akun ini tidak memiliki data siswa.');
    }

    $siswaId = $siswa->id;

    // Cek kalau sudah pernah attempt
    $existing = UjianAttempt::where('ujian_id', $ujian->id)
        ->where('siswa_id', $siswaId)
        ->first();

    if ($existing) {
        return redirect()->route('ujian.show', [
            'attempt' => $existing->id,
            'nomor' => 1
        ]);
    }

    // Buat attempt baru
    $attempt = UjianAttempt::create([
        'ujian_id' => $ujian->id,
        'siswa_id' => $siswaId,
        'mulai' => now(),
    ]);

    // Buat jawaban kosong utk semua soal
    foreach ($ujian->soal as $soal) {
        UjianAttemptAnswer::create([
            'ujian_attempt_id' => $attempt->id,
            'soal_ujian_id' => $soal->id,
            'answer' => null,
            'is_corret' => false,
        ]);
    }

    return redirect()->route('ujian.show', [
        'attempt' => $attempt->id,
        'nomor' => 1
    ]);
}

public function siswaUjian(UjianAttempt $attempt, $nomor)

{
    $ujian = $attempt->ujian;

    $soal = $ujian->soal()->orderBy('id')->skip($nomor - 1)->first();

    if (!$soal) abort(404);

    $jawaban = $attempt->answers()
        ->where('soal_ujian_id', $soal->id)
        ->first();

    $totalSoal = $ujian->soal->count();

    return view('menu.siswa.ujian.cbt-show', compact(
        'attempt', 'ujian', 'soal', 'jawaban', 'nomor', 'totalSoal'
    ));
}
public function submit(Request $request, UjianAttempt $attempt, $soalId)
{
    $request->validate([
        'answer' => 'required'
    ]);

    $soal = \App\Models\SoalUjian::findOrFail($soalId);

    $correct = ($request->answer == $soal->kunci);

    $attempt->answers()->where('soal_ujian_id', $soalId)->update([
        'answer' => $request->answer,
        'is_corret' => $correct,
    ]);

    return back();
}
public function finish(UjianAttempt $attempt)
{
    $correct = $attempt->answers()->where('is_corret', true)->count();
    $total = $attempt->answers()->count();

    $nilai = round(($correct / $total) * 100);

    $attempt->update([
        'selesai' => now(),
        'nilai' => $nilai,
    ]);

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
