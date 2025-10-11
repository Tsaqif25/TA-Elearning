<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\EditorAccess;
use App\Models\KelasMapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
   
public function viewDashboard(): View|RedirectResponse
{
$user = Auth::user();


if (! $user) {
return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
}

if ($user->hasRole('Admin')) {
return $this->adminDashboard();
} elseif ($user->hasRole('Pengajar')) {
return $this->pengajarDashboard();
} elseif ($user->hasRole('Siswa')) {
return redirect()->route('home');
}
// Jika tidak ada role, redirect ke login
return redirect()->route('login')->with('error', 'Role tidak ditemukan');
}


/**
* Dashboard untuk Admin
*
* @return View
*/
private function adminDashboard(): View
{
try {
$data = [
'totalSiswa' => DataSiswa::count(),
'totalUserSiswa' => User::role('Siswa')->count(),
'totalPengajar' => User::role('Pengajar')->count(),
'totalKelas' => Kelas::count(),
'totalMapel' => Mapel::count(),
'totalMateri' => Materi::count(),
'totalTugas' => Tugas::count(),
'totalUjian' => Ujian::count(),
];


return view('menu.admin.dashboard.dashboard', [
'materi' => Materi::all(),
'title' => 'Dashboard Admin',
'roles' => 'Admin',
'data' => $data
]);
} catch (\Exception $e) {
return back()->with('error', 'Terjadi kesalahan dalam memuat dashboard admin: ' . $e->getMessage());
}
}

    /**
     * Dashboard untuk Pengajar
     */
    private function pengajarDashboard()
    {
        try {
            $user = Auth::user();
            $editorAccess = EditorAccess::where('user_id', $user->id)->get();

            // Inisialisasi variabel
            $mapelKelas = [];
            $totalSiswa = 0;
            $totalSiswaUnique = [];
            $kelasMapelId = [];

            // Membangun data yang berkaitan dengan pengajar
            foreach ($editorAccess as $access) {
                $kelasMapel = KelasMapel::find($access->kelas_mapel_id);

                if (!$kelasMapel) continue;

                $mapelID = $kelasMapel->mapel_id;
                $kelasID = $kelasMapel->kelas_id;

                // Cari apakah mapel sudah ada dalam array
                $mapelKey = $this->findMapelKey($mapelKelas, $mapelID);

                $kelas = Kelas::find($kelasID);
                if (!$kelas) continue;

                if ($mapelKey !== false) {
                    // Tambahkan kelas ke mapel yang sudah ada
                    $mapelKelas[$mapelKey]['kelas'][] = $kelas;
                } else {
                    // Buat entry baru untuk mapel
                    $mapel = Mapel::find($mapelID);
                    if ($mapel) {
                        $mapelKelas[] = [
                            'mapel_id' => $mapelID,
                            'mapel' => $mapel,
                            'kelas' => [$kelas],
                        ];
                        $kelasMapelId[] = $kelasMapel->id;
                    }
                }

                // Hitung siswa
                $siswa = DataSiswa::where('kelas_id', $kelasID)->get();
                $totalSiswa += $siswa->count();
                $totalSiswaUnique = array_merge($totalSiswaUnique, $siswa->pluck('id')->toArray());
            }

            $totalSiswaUnique = count(array_unique($totalSiswaUnique));
            $assignedKelas = $this->getAssignedClass();

            return view('menu.pengajar.dashboard.dashboard', [
                'kelasMapelId' => $kelasMapelId,
                'totalSiswaUnique' => $totalSiswaUnique,
                'totalSiswa' => $totalSiswa,
                'assignedKelas' => $assignedKelas,
                'user' => $user,
                'countKelas' => $editorAccess->count(),
                'mapelKelas' => $mapelKelas,
                'roles' => 'Pengajar',
                'title' => 'Dashboard Pengajar'
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan dalam memuat dashboard pengajar: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman home untuk siswa
     */
    public function viewHome()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->hasRole('Siswa')) {
            return redirect()->route('dashboard');
        }

        try {
            $kelas = null;
            if ($user->kelas_id) {
                $kelas = Kelas::find($user->kelas_id);
            }

            if (!$kelas) {
                return view('menu.siswa.home.home', [
                    'title' => 'Home',
                    'roles' => 'Siswa',
                    'user' => $user,
                    'kelas' => null,
                    'mapelKelas' => [],
                    'assignedKelas' => []
                ])->with('warning', 'Anda belum terdaftar di kelas manapun');
            }

            $kelasMapel = KelasMapel::where('kelas_id', $kelas->id)->get();
            $mapelCollection = [];

            foreach ($kelasMapel as $km) {
                $mapel = Mapel::find($km->mapel_id);
                if (!$mapel) continue;

                $editorAccess = EditorAccess::where('kelas_mapel_id', $km->id)->first();
                
                $pengajarNama = '-';
                $pengajarId = null;

                if ($editorAccess) {
                    $pengajar = User::find($editorAccess->user_id);
                    if ($pengajar) {
                        $pengajarNama = $pengajar->name;
                        $pengajarId = $pengajar->id;
                    }
                }

                $mapelCollection[] = [
                    'mapel_name' => $mapel->name,
                    'mapel_id' => $mapel->id,
                    'deskripsi' => $mapel->deskripsi ?? '',
                    'gambar' => $mapel->gambar ?? '',
                    'pengajar_id' => $pengajarId,
                    'pengajar_name' => $pengajarNama,
                ];
            }

            $assignedKelas = $this->getAssignedClass();

            return view('menu.siswa.home.home', [
                'assignedKelas' => $assignedKelas,
                'title' => 'Home',
                'roles' => 'Siswa',
                'user' => $user,
                'kelas' => $kelas,
                'mapelKelas' => $mapelCollection
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan dalam memuat halaman home: ' . $e->getMessage());
        }
    }

    /**
     * Helper method untuk mencari key mapel dalam array
     */
    private function findMapelKey($mapelKelas, $mapelID)
    {
        foreach ($mapelKelas as $key => $item) {
            if (isset($item['mapel_id']) && $item['mapel_id'] == $mapelID) {
                return $key;
            }
        }
        return false;
    }

    /**
     * Mendapatkan nama role pengguna menggunakan Spatie
     */
    public static function getRolesName()
    {
        $user = Auth::user();
        if (!$user) {
            return 'Guest';
        }

        $role = $user->roles->first();
        return $role ? $role->name : 'No Role';
    }

    /**
     * Cek apakah user memiliki role tertentu
     */
    public static function hasRole($roleName)
    {
        $user = Auth::user();
        return $user ? $user->hasRole($roleName) : false;
    }

    /**
     * Mendapatkan kelas yang ditugaskan berdasarkan role
     */
    public static function getAssignedClass()
    {
        $user = Auth::user();
        if (!$user) {
            return [];
        }
        try {
            if ($user->hasRole('Admin')) {
                return null;
            } elseif ($user->hasRole('Pengajar')) {
                return self::getPengajarAssignedClass($user);
            } elseif ($user->hasRole('Siswa')) {
                return self::getSiswaAssignedClass($user);
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Error in getAssignedClass: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Mendapatkan kelas untuk pengajar
     */
    private static function getPengajarAssignedClass($user)
    {
        $editorAccess = EditorAccess::where('user_id', $user->id)->get();
        $mapelKelas = [];

        foreach ($editorAccess as $access) {
            $kelasMapel = KelasMapel::find($access->kelas_mapel_id);
            if (!$kelasMapel) continue;

            $mapelID = $kelasMapel->mapel_id;
            $kelasID = $kelasMapel->kelas_id;

            $mapel = Mapel::find($mapelID);
            $kelas = Kelas::find($kelasID);

            if (!$mapel || !$kelas) continue;

            // Cari apakah mapel sudah ada
            $found = false;
            foreach ($mapelKelas as $key => $item) {
                if (isset($item['mapel_id']) && $item['mapel_id'] == $mapelID) {
                    $mapelKelas[$key]['kelas'][] = $kelas;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $mapelKelas[] = [
                    'mapel_id' => $mapelID,
                    'mapel' => $mapel,
                    'kelas' => [$kelas],
                ];
            }
        }

        return $mapelKelas;
    }

    /**
     * Mendapatkan kelas untuk siswa
     */
    private static function getSiswaAssignedClass($user)
    {
        if (!$user->kelas_id) {
            return [];
        }

        $kelasMapelList = KelasMapel::where('kelas_id', $user->kelas_id)->get();
        $mapelKelas = [];

        foreach ($kelasMapelList as $km) {
            $mapel = Mapel::find($km->mapel_id);
            $kelas = Kelas::find($km->kelas_id);

            if ($mapel && $kelas) {
                $mapelKelas[] = [
                    'mapel_id' => $km->mapel_id,
                    'mapel' => $mapel,
                    'kelas' => [$kelas],
                ];
            }
        }

        return $mapelKelas;
    }

    /**
     * Mendapatkan kelas yang ditugaskan khusus untuk siswa (method terpisah)
     */
    public static function getAssignedClassSiswa()
    {
        $user = Auth::user();
        if (!$user) {
            return [];
        }

        if ($user->hasRole('Admin')) {
            return null;
        } elseif ($user->hasRole('Pengajar')) {
            return self::getPengajarAssignedClass($user);
        } elseif ($user->hasRole('Siswa')) {
            return null; // Siswa tidak perlu assigned class di context ini
        }

        return [];
    }
}