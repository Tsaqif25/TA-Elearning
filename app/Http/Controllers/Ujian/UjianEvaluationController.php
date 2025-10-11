<?php

namespace App\Http\Controllers\Ujian;

use App\Http\Controllers\Controller;
use App\Models\Ujian ; 
use App\Models\User ;
 use App\Models\UserJawaban;
use App\Http\Controllers\DashboardController;

class UjianEvaluationController extends Controller
{
    public function listStudent(Ujian $ujian)
{
      $assignedKelas = DashboardController::getAssignedClass();
    // Ambil siswa dari user yang punya role siswa (role 4, atau sesuaikan)
    $students = User::whereHas('dataSiswa')
        ->orderBy('id', 'DESC')
        ->get();

    $totalQuestions = $ujian->soalUjianMultiple()->count();

    foreach ($students as $student) {
        // Hitung total jawaban siswa di ujian ini
        $answersCount = UserJawaban::whereHas('soalUjianMultiple', function ($query) use ($ujian) {
                $query->where('ujian_id', $ujian->id);
            })
            ->where('user_id', $student->id)
            ->count();

        // Hitung jawaban benar (langsung via relasi ke SoalUjianAnswer)
        $correctAnswersCount = UserJawaban::whereHas('soalUjianMultiple', function ($query) use ($ujian) {
                $query->where('ujian_id', $ujian->id);
            })
            ->where('user_id', $student->id)
            ->whereHas('answer', function ($query) {
                $query->where('is_correct', 1);
            })
            ->count();

        // Tentukan status siswa
        if ($answersCount === 0) {
            $student->status = 'Not Started';
        } elseif ($correctAnswersCount < $totalQuestions * 0.6) {
            $student->status = 'Not Passed';
        } else {
            $student->status = 'Passed';
        }

        // Tambahan untuk view
        $student->correct = $correctAnswersCount;
        $student->total = $totalQuestions;
    }

    return view('menu.pengajar.ujian.hasilUjianSiswa', [
        'ujian' => $ujian,
        'students' => $students,
        'assignedKelas' => $assignedKelas
    ]);
}
}
