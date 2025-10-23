<?php

namespace App\Http\Controllers;

use App\Models\{User, DataSiswa, Kelas, Mapel, Materi, Tugas, Ujian, KelasMapel, EditorAccess};
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * ==========================================================
     *  DASHBOARD CONTROLLER (VERSI RINGKAS & AMAN)
     *  ----------------------------------------------------------
     *  Menentukan tampilan dashboard berdasarkan role pengguna.
     * ==========================================================
     */

    /**
     * Menampilkan dashboard sesuai role pengguna.
     */
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
        } elseif ($user->hasRole('Pengajar')) {
            return $this->pengajarDashboard();
        } elseif ($user->hasRole('Siswa')) {
            return redirect()->route('home');
        } else {
            return $this->redirectWithError('login', 'Role tidak ditemukan');
        }

    }

    /**
     * ==========================================================
     *  DASHBOARD ADMIN
     *  ----------------------------------------------------------
     *  Menampilkan data statistik global sistem.
     * ==========================================================
     */
    private function adminDashboard(): View
    {
        $stats = [
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
            'materi' => Materi::latest()->take(5)->get(),
            'title' => 'Dashboard Admin',
            'roles' => 'Admin',
            'data' => $stats,
        ]);
    }

    /**
     * ==========================================================
     *  DASHBOARD PENGAJAR
     *  ----------------------------------------------------------
     *  Menampilkan daftar kelas dan mapel yang diajar oleh guru.
     * ==========================================================
     */
    private function pengajarDashboard(): View
    {
        $user = Auth::user();

        $kelasMapel = EditorAccess::where('user_id', $user->id)
            ->with(['kelasMapel.kelas', 'kelasMapel.mapel'])
            ->get();

        $kelasIds = $kelasMapel->pluck('kelasMapel.kelas.id')->filter()->unique();
        $mapelIds = $kelasMapel->pluck('kelasMapel.mapel.id')->filter()->unique();

        return view('menu.pengajar.dashboard.dashboard', [
            'user' => $user,
            'jumlahKelas' => $kelasIds->count(),
            'jumlahMapel' => $mapelIds->count(),
            'jumlahSiswa' => DataSiswa::whereIn('kelas_id', $kelasIds)->count(),
            'assignedKelas' => self::getAssignedClass(), // masih aman
            'kelasDanMapel' => $kelasMapel->map(fn($item) => [
                'kelas_id' => $item->kelasMapel->kelas?->id,
                'kelas_nama' => $item->kelasMapel->kelas?->name,
                'mapel_id' => $item->kelasMapel->mapel?->id,
                'mapel_nama' => $item->kelasMapel->mapel?->name,
            ]),
            'title' => 'Dashboard Pengajar',
        ]);
    }

 
    public function viewHome(): View|RedirectResponse
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('Siswa')) {
            return redirect()->route($user ? 'dashboard' : 'login');
        }

        if (!$user->kelas_id) {
            return view('menu.siswa.home.home', [
                'title' => 'Home',
                'roles' => 'Siswa',
                'user' => $user,
                'kelas' => null,
                'mapelKelas' => [],
                'assignedKelas' => [],
            ])->with('warning', 'Anda belum terdaftar di kelas manapun');
        }

        $kelas = Kelas::find($user->kelas_id);
        $mapelKelas = $this->getMapelWithPengajar($kelas);

        return view('menu.siswa.home.home', [
            'assignedKelas' => self::getAssignedClass(),
            'title' => 'Home',
            'roles' => 'Siswa',
            'user' => $user,
            'kelas' => $kelas,
            'mapelKelas' => $mapelKelas,
        ]);
    }

    /**
     * ==========================================================
     *  FUNGSI PEMBANTU
     * ==========================================================
     */

    /**
     * Mengambil data mapel dan pengajar untuk kelas tertentu.
     */
 private function getMapelWithPengajar(Kelas $kelas): array
{
    return KelasMapel::where('kelas_id', $kelas->id)
        ->with(['mapel', 'editorAccess.user'])
        ->get()
        ->sortBy(fn($item) => $item->mapel->name) // pengganti orderBy
        ->map(function ($km) {
            $pengajar = $km->editorAccess?->user;
            return [
                'mapel_id' => $km->mapel->id,
                'mapel_name' => $km->mapel->name,
                'deskripsi' => $km->mapel->deskripsi ?? '',
                'gambar' => $km->mapel->gambar ?? '',
                'pengajar_id' => $pengajar?->id,
                'pengajar_name' => $pengajar?->name ?? '-',
            ];
        })
        ->values() // reset index agar rapi
        ->toArray();
}




    /**
     * Mendapatkan daftar kelas yang dimiliki pengguna berdasarkan role.
     * (versi aman tanpa getPengajarKelas dan getSiswaKelas)
     */
   public static function getAssignedClass(): ?array
    {
        $user = Auth::user();
        if (!$user) return [];

        if ($user->hasRole('Admin')) {
            return null;
        } elseif ($user->hasRole('Pengajar')) {
            return [];
        } elseif ($user->hasRole('Siswa')) {
            return [];
        } else {
            return [];
        }
    }
}
