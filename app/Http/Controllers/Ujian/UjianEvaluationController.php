<?php

namespace App\Http\Controllers\Ujian;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Models\Ujian;
use App\Models\UserJawaban;

class UjianEvaluationController extends Controller
{
    public function listStudent(Ujian $ujian)
    {
            $kelasMapel = $ujian->kelasMapel;
        // 🔹 Ambil hanya siswa dari kelas yang ikut ujian
        $students = $ujian->kelasMapel->kelas->users()
            ->orderBy('id', 'DESC')
            ->get();

        $totalQuestions = $ujian->soalUjianMultiple()->count();

        foreach ($students as $student) {
            $studentAnswers = UserJawaban::whereHas('soalUjianMultiple', function ($query) use ($ujian) {
                    $query->where('ujian_id', $ujian->id);
                })
                ->where('user_id', $student->id)
                ->get();

            $answersCount = $studentAnswers->count();

            $correctAnswers = 0;
            foreach ($studentAnswers as $answer) {
                if ($answer->answer && $answer->answer->is_correct == 1) {
                    $correctAnswers++;
                }
            }

            if ($answersCount == 0) {
                $student->status = 'Not Started';
            } elseif ($correctAnswers < $totalQuestions * 0.6) {
                $student->status = 'Not Passed';
            } else {
                $student->status = 'Passed';
            }

            $student->correct = $correctAnswers;
            $student->total   = $totalQuestions;
        }

        return view('menu.pengajar.ujian.hasilUjianSiswa', [
            'ujian' => $ujian,
            'students' => $students,
            'kelasMapel' => $kelasMapel
        ]);
    }
}
