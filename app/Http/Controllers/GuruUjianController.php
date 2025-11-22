<?php

namespace App\Http\Controllers;

use App\Models\UjianAttempt;
use Illuminate\Http\Request;
use App\Models\UjianAttemptAnswer;
use App\Http\Controllers\Controller;

class GuruUjianController extends Controller
{
    public function viewAttemptDetail($attemptId)
{
    $attempt = UjianAttempt::with('siswa')->findOrFail($attemptId);

    $answers = UjianAttemptAnswer::with('soal')
        ->where('ujian_attempt_id', $attemptId)
        ->get();

    return view('menu.pengajar.ujian.DetailNilaiSiswa', compact('attempt', 'answers'));
}

}
