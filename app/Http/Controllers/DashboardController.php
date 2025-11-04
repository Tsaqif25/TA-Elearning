<?php

namespace App\Http\Controllers;

use App\Models\{User, DataSiswa, Kelas, Mapel, Materi, Tugas, Ujian, KelasMapel, EditorAccess};
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function viewDashboard(): View|RedirectResponse
    {
        $user = Auth::user();

        // Jika belum login, arahkan ke login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
        }
        // Arahkan ke dashboard sesuai role

        if ($user->hasRole('Admin')) {
            return $this->adminDashboard();
                } elseif ($user->hasRole('Wakur')) {
            return $this->pengajarDashboard(); 
        } elseif ($user->hasRole('Pengajar')) {
            return $this->pengajarDashboard();
        } elseif ($user->hasRole('Siswa')) {
            return redirect()->route('home');
        } else {
            return $this->redirectWithError('login', 'Role tidak ditemukan');
        }

    }

 
    // private function adminDashboard(): View
    // {
    //     $stats = [
    //         'totalSiswa' => DataSiswa::count(),
    //         'totalUserSiswa' => User::role('Siswa')->count(),
    //         'totalPengajar' => User::role('Pengajar')->count(),
    //         'totalKelas' => Kelas::count(),
    //         'totalMapel' => Mapel::count(),
    //         'totalMateri' => Materi::count(),
    //         'totalTugas' => Tugas::count(),
    //         'totalUjian' => Ujian::count(),
    //     ];

    //     return view('menu.admin.dashboard.dashboard', [
    //         'materi' => Materi::latest()->take(5)->get(),
    //         'title' => 'Dashboard Admin',
    //         'roles' => 'Admin',
    //         'data' => $stats,
    //     ]);
    // }

   
private function pengajarDashboard(): View
{
    // Ambil data user yang login
    $user = Auth::user();

    // Ambil semua data kelas-mapel yang diajar guru ini
    $dataAkses = EditorAccess::where('user_id', $user->id)
        ->with(['kelasMapel.kelas', 'kelasMapel.mapel'])
        ->get();

    // Siapkan data awal
    $totalKelas = 0;
    $totalMapel = 0;
    $totalSiswa = 0;
    $kelasDanMapel = [];

    // Jika ada data akses, hitung semuanya
    if ($dataAkses->isNotEmpty()) {
        $kelasIds = [];
        $mapelIds = [];

        foreach ($dataAkses as $akses) {
            $kelas = $akses->kelasMapel->kelas ?? null;
            $mapel = $akses->kelasMapel->mapel ?? null;

            // Hanya proses kalau dua-duanya ada
            if ($kelas && $mapel) {
                $kelasIds[] = $kelas->id;
                $mapelIds[] = $mapel->id;

                $kelasDanMapel[] = [
                    'kelas_id' => $kelas->id,
                    'kelas_nama' => $kelas->name,
                    'mapel_id' => $mapel->id,
                    'mapel_nama' => $mapel->name,
                ];
            }
        }

        // Hilangkan duplikat dan hitung jumlahnya
        $totalKelas = count(array_unique($kelasIds));
        $totalMapel = count(array_unique($mapelIds));
        $totalSiswa = DataSiswa::whereIn('kelas_id', $kelasIds)->count();
    }

    // Kirim semua data ke tampilan
    return view('menu.pengajar.dashboard.dashboard', [
        'title' => 'Dashboard Pengajar',
        'user' => $user,
        'kelasDanMapel' => $kelasDanMapel,
        'totalKelas' => $totalKelas,
        'totalMapel' => $totalMapel,
        'totalSiswa' => $totalSiswa,
    ]);
}


private function getMapelWithPengajar(Kelas $kelas)
{
    // Ambil semua data mapel untuk kelas ini, beserta guru pengajarnya
    $data = KelasMapel::where('kelas_id', $kelas->id)
        ->with(['mapel', 'editorAccess.user'])
        ->get();

    $hasil = [];

    foreach ($data as $item) {
        $mapel = $item->mapel;
        $pengajar = $item->editorAccess ? $item->editorAccess->user : null;

        $hasil[] = [
            'mapel_id' => $mapel ? $mapel->id : '',
            'mapel_name' => $mapel ? $mapel->name : '',
            'deskripsi' => $mapel ? $mapel->deskripsi : '',
            'pengajar_name' => $pengajar ? $pengajar->name : '',
        ];
    }

    return $hasil;
}

 


// public function viewHome(): View|RedirectResponse
// {
//     $user = Auth::user();

//     // Cek login dan role
//     if (!$user) return redirect()->route('login');
//     if (!$user->hasRole('Siswa')) return redirect()->route('dashboard');

//     // Cek apakah siswa sudah punya kelas
//     if (!$user->kelas_id) {
//         return view('menu.siswa.home.home', [
//             'title' => 'Home',
//             'roles' => 'Siswa',
//             'user' => $user,
//             'kelas' => null,
//             'mapelKelas' => [],
//         ])->with('warning', 'Anda belum terdaftar di kelas manapun');
//     }

//     // Jika sudah ada kelas
//     $kelas = Kelas::find($user->kelas_id);
//     $mapelKelas = $this->getMapelWithPengajar($kelas);

//     return view('menu.siswa.home.home', compact('user', 'kelas', 'mapelKelas') + [
//         'title' => 'Home',
//         'roles' => 'Siswa',
//     ]);
// } 


public function viewHome(): View|RedirectResponse
{
    $user = Auth::user();

    if (!$user) return redirect()->route('login');
    if (!$user->hasRole('Siswa')) return redirect()->route('dashboard');

    // 🔹 Ambil kelas langsung dari relasi user
    $kelas = $user->kelas;

    // 🔹 Jika belum ada kelas, tampilkan peringatan
    if (!$kelas) {
        return view('menu.siswa.home.home', [
            'title' => 'Home',
            'roles' => 'Siswa',
            'user' => $user,
            'kelas' => null,
            'mapelKelas' => [],
        ])->with('warning', 'Anda belum terdaftar di kelas manapun');
    }

    // 🔹 Ambil mapel & pengajar untuk kelas ini
    $mapelKelas = $this->getMapelWithPengajar($kelas);

    return view('menu.siswa.home.home', compact('user', 'kelas', 'mapelKelas') + [
        'title' => 'Home',
        'roles' => 'Siswa',
    ]);
}



  

 

}
