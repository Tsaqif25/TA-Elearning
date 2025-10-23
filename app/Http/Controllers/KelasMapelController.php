<?php

namespace App\Http\Controllers; // Mendeklarasikan namespace untuk controller



use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\Mapel; 
use App\Models\Materi; 


use App\Models\Tugas;
use App\Models\Ujian; 
use App\Models\User; 
use Illuminate\Http\Request; 
use Maatwebsite\Excel\Facades\Excel; // Mengimpor facade Excel

class KelasMapelController extends Controller // Mendeklarasikan kelas controller KelasMapel
{
  
//  public function viewKelasMapel(Mapel $mapel,Kelas $kelas)
 
// {
    
//  $kelasMapel = KelasMapel::where('mapel_id', $mapel->id)
//         ->where('kelas_id', $kelas->id)
//         ->firstOrFail();

//     // Load resources terkait
//     $materi      = Materi::where('kelas_mapel_id', $kelasMapel->id)->get();
//     $tugas       = Tugas::where('kelas_mapel_id', $kelasMapel->id)->get();
//     $ujian       = Ujian::where('kelas_mapel_id', $kelasMapel->id)->get();


//     $assignedKelas = DashboardController::getAssignedClass();

//     // Editor (aman untuk berbagai nama relasi)
//     $editor = null;
//     $ea = method_exists($kelasMapel, 'editorAccess')
//         ? $kelasMapel->editorAccess()->first()
//         : (method_exists($kelasMapel, 'EditorAccess') ? $kelasMapel->EditorAccess()->first() : null);

//     if ($ea) {
//         $u = User::find($ea->user_id);
//         if ($u) {
//             $editor = ['name' => $u->name, 'id' => $u->id];
//         }
//     }

//     return view('menu.kelasMapel.viewKelasMapel', [
//         'editor'        => $editor,
//         'assignedKelas' => $assignedKelas,
       
//         'title'         => 'Dashboard',
//         'kelasMapel'    => $kelasMapel,
//         'ujian'         => $ujian,
//         'materi'        => $materi,
//         'mapel'         => $mapel,
//         'kelas'         => $kelas,
//         'tugas'         => $tugas,
//         'kelasId'       => $kelas->id,
//     ]);
// }


public function viewKelasMapel(Mapel $mapel, Kelas $kelas)
{
    $kelasMapel = KelasMapel::firstWhere([
        'kelas_id' => $kelas->id,
        'mapel_id' => $mapel->id
    ]);

  

 return view('menu.kelasMapel.viewKelasMapel', [
    'kelasMapel'    => $kelasMapel->load(['materi', 'tugas', 'ujian']),
    'materi'        => $kelasMapel->materi, 
    'tugas'         => $kelasMapel->tugas,  
    'ujian'         => $kelasMapel->ujian,  
    // 'assignedKelas' => DashboardController::getAssignedClass(),
    'editor'        => optional($kelasMapel->editorAccess?->user)->only('id', 'name'),
    'title'         => "{$kelas->name} — {$mapel->name}",
    'kelas'         => $kelas,
    'mapel'         => $mapel,
]);

}


  
    

}
