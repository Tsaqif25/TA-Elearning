<?php

namespace App\Http\Controllers;

use App\Models\{User, DataSiswa, Kelas, Mapel, Materi, Tugas, Ujian, KelasMapel, EditorAccess};
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Route utama dashboard berdasarkan role
     */
    public function viewDashboard(): View|RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return $this->redirectWithError('login', 'Anda harus login terlebih dahulu');
        }

        return match(true) {
            $user->hasRole('Admin') => $this->adminDashboard(),
            $user->hasRole('Pengajar') => $this->pengajarDashboard(),
            $user->hasRole('Siswa') => redirect()->route('home'),
            default => $this->redirectWithError('login', 'Role tidak ditemukan')
        };
    }

    /**
     * Dashboard Admin - menampilkan statistik global
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
            'materi' => Materi::all(),
            'title' => 'Dashboard Admin',
            'roles' => 'Admin',
            'data' => $stats
        ]);
    }

    /**
     * Dashboard Pengajar - menampilkan kelas & mapel yang diajar
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
            'assignedKelas' => self::getAssignedClass(),
            'kelasDanMapel' => $this->formatKelasMapelData($kelasMapel),
            'title' => 'Dashboard Pengajar',
        ]);
    }

    /**
     * Home untuk Siswa - menampilkan mapel di kelasnya
     */
    public function viewHome(): View|RedirectResponse
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('Siswa')) {
            return redirect()->route($user ? 'dashboard' : 'login');
        }

        if (!$user->kelas_id) {
            return $this->viewSiswaWithoutKelas($user);
        }

        $kelas = Kelas::find($user->kelas_id);
        $mapelKelas = $this->getMapelWithPengajar($kelas);

        return view('menu.siswa.home.home', [
            'assignedKelas' => self::getAssignedClass(),
            'title' => 'Home',
            'roles' => 'Siswa',
            'user' => $user,
            'kelas' => $kelas,
            'mapelKelas' => $mapelKelas
        ]);
    }

    // ========== HELPER METHODS ==========

    /**
     * Format data kelas-mapel untuk pengajar
     */
    private function formatKelasMapelData($kelasMapel): array
    {
        return $kelasMapel->map(fn($item) => [
            'kelas_id' => $item->kelasMapel->kelas?->id,
            'kelas_nama' => $item->kelasMapel->kelas?->name,
            'mapel_id' => $item->kelasMapel->mapel?->id,
            'mapel_nama' => $item->kelasMapel->mapel?->name,
        ])->toArray();
    }

    /**
     * Ambil mapel beserta pengajarnya untuk siswa
     */
    private function getMapelWithPengajar(Kelas $kelas): array
    {
        return KelasMapel::where('kelas_id', $kelas->id)
            ->with(['mapel', 'editorAccess.user'])
            ->get()
            ->map(function($km) {
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
            ->toArray();
    }

    /**
     * View untuk siswa yang belum punya kelas
     */
    private function viewSiswaWithoutKelas($user): View
    {
        return view('menu.siswa.home.home', [
            'title' => 'Home',
            'roles' => 'Siswa',
            'user' => $user,
            'kelas' => null,
            'mapelKelas' => [],
            'assignedKelas' => []
        ])->with('warning', 'Anda belum terdaftar di kelas manapun');
    }

    /**
     * Redirect dengan pesan error
     */
    private function redirectWithError(string $route, string $message): RedirectResponse
    {
        return redirect()->route($route)->with('error', $message);
    }

    // ========== STATIC UTILITIES ==========

    public static function getRolesName(): string
    {
        return Auth::user()?->roles->first()?->name ?? 'Guest';
    }

    public static function hasRole(string $roleName): bool
    {
        return Auth::user()?->hasRole($roleName) ?? false;
    }

    /**
     * Mendapatkan assigned class berdasarkan role user
     */
    public static function getAssignedClass(): ?array
    {
        $user = Auth::user();
        if (!$user) return [];

        return match(true) {
            $user->hasRole('Admin') => null,
            $user->hasRole('Pengajar') => self::getPengajarKelas($user),
            $user->hasRole('Siswa') => self::getSiswaKelas($user),
            default => []
        };
    }

    /**
     * Ambil kelas yang diajar oleh pengajar (dikelompokkan per mapel)
     */
    private static function getPengajarKelas(User $user): array
    {
        $akses = EditorAccess::with(['kelasMapel.kelas', 'kelasMapel.mapel'])
            ->where('user_id', $user->id)
            ->get();

        $grouped = [];

        foreach ($akses as $a) {
            if (!$a->kelasMapel?->mapel || !$a->kelasMapel?->kelas) continue;

            $mapelId = $a->kelasMapel->mapel->id;

            if (!isset($grouped[$mapelId])) {
                $grouped[$mapelId] = [
                    'mapel_id' => $mapelId,
                    'mapel' => $a->kelasMapel->mapel,
                    'kelas' => []
                ];
            }

            $grouped[$mapelId]['kelas'][] = $a->kelasMapel->kelas;
        }

        return array_values($grouped);
    }

    /**
     * Ambil kelas & mapel untuk siswa
     */
    private static function getSiswaKelas(User $user): array
    {
        if (!$user->kelas_id) return [];

        return KelasMapel::with(['mapel', 'kelas'])
            ->where('kelas_id', $user->kelas_id)
            ->get()
            ->map(fn($km) => [
                'mapel_id' => $km->mapel->id,
                'mapel' => $km->mapel,
                'kelas' => [$km->kelas],
            ])
            ->toArray();
    }
}