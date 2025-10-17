<?php

namespace App\Http\Controllers; // Mendeklarasikan namespace untuk controller

use App\Exports\NilaiTugasExport; // Mengimpor kelas NilaiTugasExport
use App\Exports\NilaiUjianExport; // Mengimpor kelas NilaiUjianExport
use App\Models\Kelas; // Mengimpor model Kelas
use App\Models\KelasMapel; // Mengimpor model KelasMapel
use App\Models\Mapel; // Mengimpor model Mapel
use App\Models\Materi; // Mengimpor model Materi
use App\Models\Rekomendasi; // Mengimpor model Rekomendasi
use App\Models\Pengumuman; // Mengimpor model Pengumuman
use App\Models\Tugas; // Mengimpor model Tugas
use App\Models\Ujian; // Mengimpor model Ujian
use App\Models\User; // Mengimpor model User
use Illuminate\Http\Request; // Mengimpor kelas Request
use Maatwebsite\Excel\Facades\Excel; // Mengimpor facade Excel

class KelasMapelController extends Controller // Mendeklarasikan kelas controller KelasMapel
{
    /**
     * Menampilkan halaman kelas dan mata pelajaran tertentu.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
 public function viewKelasMapel(Mapel $mapel,Kelas $kelas)
 
{
    
 $kelasMapel = KelasMapel::where('mapel_id', $mapel->id)
        ->where('kelas_id', $kelas->id)
        ->firstOrFail();

    // Load resources terkait
    $materi      = Materi::where('kelas_mapel_id', $kelasMapel->id)->get();
    $tugas       = Tugas::where('kelas_mapel_id', $kelasMapel->id)->get();
    $ujian       = Ujian::where('kelas_mapel_id', $kelasMapel->id)->get();

    $roles         = DashboardController::getRolesName();
    $assignedKelas = DashboardController::getAssignedClass();

    // Editor (aman untuk berbagai nama relasi)
    $editor = null;
    $ea = method_exists($kelasMapel, 'editorAccess')
        ? $kelasMapel->editorAccess()->first()
        : (method_exists($kelasMapel, 'EditorAccess') ? $kelasMapel->EditorAccess()->first() : null);

    if ($ea) {
        $u = User::find($ea->user_id);
        if ($u) {
            $editor = ['name' => $u->name, 'id' => $u->id];
        }
    }

    return view('menu.kelasMapel.viewKelasMapel', [
        'editor'        => $editor,
        'assignedKelas' => $assignedKelas,
        'roles'         => $roles,
        'title'         => 'Dashboard',
        'kelasMapel'    => $kelasMapel,
        'ujian'         => $ujian,
        'materi'        => $materi,
        'mapel'         => $mapel,
        'kelas'         => $kelas,
        'tugas'         => $tugas,
        'kelasId'       => $kelas->id,
    ]);
}

    public function viewAllActivities()
    {
        // Ambil semua materi dan pengumuman
        $materi = Materi::all(); // Mengambil semua data materi
        $pengumuman = Pengumuman::all(); // Mengambil semua data pengumuman
        $tugas = Tugas::all(); // Mengambil semua data tugas
        $ujian = Ujian::all(); // Mengambil semua data ujian
        $roles = DashboardController::getRolesName(); // Mendapatkan peran pengguna
        
        // Ambil semua kelasMapel
        $kelasMapel = KelasMapel::all(); // Mengambil semua data kelasMapel
        
        // Array untuk menyimpan data editor
        $editors = []; // Inisialisasi array editor
    
        foreach ($kelasMapel as $km) { // Loop melalui setiap kelasMapel
            if (count($km->EditorAccess) > 0) { // Memeriksa apakah ada EditorAccess untuk kelasMapel
                $editor = User::where('id', $km->EditorAccess[0]->user_id)->first(); // Mengambil data pengguna yang menjadi editor
                $editors[$km->id] = [
                    'name' => $editor->name, // Menyimpan nama editor
                    'id' => $editor->id, // Menyimpan ID editor
                ];
            } else {
                $editors[$km->id] = null; // Menyimpan null jika tidak ada editor
            }
        }
    
        // Mengembalikan tampilan activity dengan data yang diperlukan
        return view('menu.admin.activity', [
            'materi' => $materi,
            'pengumuman' => $pengumuman,
            // 'diskusi' => $diskusi,
            'tugas' => $tugas,
            'ujian' => $ujian,
            'title' => 'Activity',
            'roles' => $roles,
            'editors' => $editors
        ]);
    }
    

    /**
     * Metode untuk menyimpan gambar sementara.
     *
     * @return \Illuminate\View\View
     */
    public function saveImageTemp(Request $request)
    {
        $roles = DashboardController::getRolesName(); // Mendapatkan peran pengguna
        $assignedKelas = DashboardController::getAssignedClass(); // Mendapatkan kelas yang ditugaskan kepada pengguna

        // Mengembalikan tampilan viewKelasMapel dengan data yang diperlukan
        return view('menu.mapelKelas.viewKelasMapel', ['assignedKelas' => $assignedKelas, 'roles' => $roles, 'title' => 'Dashboard']);
    }

}
