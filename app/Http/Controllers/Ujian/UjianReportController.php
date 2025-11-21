<?php
namespace App\Http\Controllers\Ujian;


use App\Models\Ujian;
use App\Models\UjianAttempt;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UjianReportController extends Controller
{
 public function index()
    {
        // Guru login
        $guruId = Auth::user()->guru->id;

        // Ambil semua ujian milik guru ini
        $ujians = Ujian::where('guru_id', $guruId)
            ->with('kelasMapel.kelas', 'kelasMapel.mapel')
            ->get();

        // Ambil nilai siswa untuk ujian-ujian guru ini
        $nilai = UjianAttempt::whereHas('ujian', function($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            })
            ->with(['siswa', 'ujian'])
            ->orderBy('id', 'DESC')
            ->get();

        return view('menu.pengajar.ujian.report-index', [
            'ujians' => $ujians,
            'nilai'  => $nilai,
        ]);
    }


public function show(Ujian $ujian)
{

     $kelasMapel = $ujian->kelasMapel;
    // validasi ujian benar punya guru ini
    if ($ujian->guru_id != Auth::user()->guru->id) {
        abort(403);
    }

    $attempts = UjianAttempt::with('siswa.user')
        ->where('ujian_id', $ujian->id)
        ->orderBy('nilai','DESC')
        ->get();

    return view('menu.pengajar.ujian.report-show', compact('ujian','attempts','kelasMapel'));
}

}
