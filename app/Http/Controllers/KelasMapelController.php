<?php

namespace App\Http\Controllers; 
use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\Mapel; 
use App\Models\Materi; 
use App\Models\Tugas;
use App\Models\Ujian; 

class KelasMapelController extends Controller 
{
  
public function viewKelasMapel(Mapel $mapel, Kelas $kelas)
{
        $kelasMapel = KelasMapel::where('mapel_id', $mapel->id)
        ->where('kelas_id', $kelas->id)
        ->firstOrFail();
    $materi = Materi::where('kelas_mapel_id', $kelasMapel->id)->get();
    $tugas  = Tugas::where('kelas_mapel_id', $kelasMapel->id)->get();
    $ujian  = Ujian::where('kelas_mapel_id', $kelasMapel->id)->get();

    return view('menu.kelasMapel.viewKelasMapel', [
        'kelasMapel'    => $kelasMapel,
        'materi'        => $materi,
        'tugas'         => $tugas,
        'ujian'         => $ujian,
        'title'         => "{$kelas->name} — {$mapel->name}",
        'kelas'         => $kelas,
        'mapel'         => $mapel,
    ]);
}
}
