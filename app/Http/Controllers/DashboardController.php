<?php

namespace App\Http\Controllers;

use App\Models\{
    User,
    DataSiswa,
    Kelas,
    Mapel,
    Materi,
    Tugas,
    Ujian,
    EditorAccess,
    KelasMapel
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * 🔹 Menentukan tampilan dashboard berdasarkan role pengguna.
     */
    public function viewDashboard(): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
        }

        return match (true) {
            $user->hasRole('Admin') => $this->adminDashboard(),
            $user->hasRole('Pengajar') => $this->pengajarDashboard(),
            $user->hasRole('Siswa') => redirect()->route('home'),
            default => redirect()->route('login')->with('error', 'Role tidak ditemukan'),
        };
    }

    // ======================================================================
    //  ADMIN DASHBOARD
    // ======================================================================
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
                'title' => 'Dashboard Admin',
                'roles' => 'Admin',
                'materi' => Materi::all(),
                'data' => $data,
            ]);
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal memuat dashboard admin: ' . $e->getMessage());
        }
    }

    // ======================================================================
    //  PENGAJAR DASHBOARD
    // ======================================================================
    private function pengajarDashboard(): RedirectResponse|View
    {
        try {
            $user = Auth::user();

            // Ambil semua kelas-mapel yang diajar guru
            $akses = EditorAccess::where('user_id', $user->id)
                ->with(['kelasMapel.kelas', 'kelasMapel.mapel'])
                ->get();

            $kelasIds = $akses->pluck('kelasMapel.kelas.id')->filter()->unique();
            $mapelIds = $akses->pluck('kelasMapel.mapel.id')->filter()->unique();

            $statistik = [
                'jumlahKelas' => $kelasIds->count(),
                'jumlahMapel' => $mapelIds->count(),
                'jumlahSiswa' => DataSiswa::whereIn('kelas_id', $kelasIds)->count(),
            ];

            // Bentuk pasangan kelas-mapel
            $kelasDanMapel = $akses->map(fn($item) => [
                'kelas_id'   => optional($item->kelasMapel->kelas)->id,
                'kelas_nama' => optional($item->kelasMapel->kelas)->name,
                'mapel_id'   => optional($item->kelasMapel->mapel)->id,
                'mapel_nama' => optional($item->kelasMapel->mapel)->name,
            ]);

            return view('menu.pengajar.dashboard.dashboard', [
                'title' => 'Dashboard Pengajar',
                'user' => $user,
                'assignedKelas' => $this->getAssignedClass(),
                'kelasDanMapel' => $kelasDanMapel,
                ...$statistik
            ]);
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ======================================================================
    //  SISWA HOME
    // ======================================================================
    public function viewHome(): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user) return redirect()->route('login');
        if (! $user->hasRole('Siswa')) return redirect()->route('dashboard');

        try {
            $kelas = Kelas::find($user->kelas_id);

            if (! $kelas) {
                return view('menu.siswa.home.home', [
                    'title' => 'Home',
                    'roles' => 'Siswa',
                    'user' => $user,
                    'kelas' => null,
                    'mapelKelas' => [],
                    'assignedKelas' => [],
                ])->with('warning', 'Anda belum terdaftar di kelas manapun');
            }

            // Ambil daftar mapel + pengajar untuk kelas siswa
            $mapelKelas = KelasMapel::where('kelas_id', $kelas->id)
                ->get()
                ->map(function ($km) {
                    $mapel = Mapel::find($km->mapel_id);
                    if (! $mapel) return null;

                    $editor = EditorAccess::where('kelas_mapel_id', $km->id)->first();
                    $pengajar = $editor ? User::find($editor->user_id) : null;

                    return [
                        'mapel_name' => $mapel->name,
                        'mapel_id' => $mapel->id,
                        'deskripsi' => $mapel->deskripsi ?? '',
                        'gambar' => $mapel->gambar ?? '',
                        'pengajar_id' => $pengajar?->id,
                        'pengajar_name' => $pengajar?->name ?? '-',
                    ];
                })
                ->filter()
                ->values();

            return view('menu.siswa.home.home', [
                'title' => 'Home',
                'roles' => 'Siswa',
                'user' => $user,
                'kelas' => $kelas,
                'mapelKelas' => $mapelKelas,
                'assignedKelas' => $this->getAssignedClass(),
            ]);
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal memuat halaman home: ' . $e->getMessage());
        }
    }

    // ======================================================================
    //  HELPER ROLE & ASSIGNMENT
    // ======================================================================

    public static function getRolesName(): string
    {
        $role = Auth::user()?->roles->first();
        return $role?->name ?? 'Guest';
    }

    public static function hasRole(string $roleName): bool
    {
        return Auth::user()?->hasRole($roleName) ?? false;
    }

    public static function getAssignedClass(): array|null
    {
        $user = Auth::user();
        if (! $user) return [];

        try {
            return match (true) {
                $user->hasRole('Admin') => null,
                $user->hasRole('Pengajar') => self::getPengajarAssignedClass($user),
                $user->hasRole('Siswa') => self::getSiswaAssignedClass($user),
                default => [],
            };
        } catch (\Throwable $e) {
            Log::error('Error in getAssignedClass: ' . $e->getMessage());
            return [];
        }
    }

    private static function getPengajarAssignedClass(User $user): array
    {
        return EditorAccess::where('user_id', $user->id)
            ->get()
            ->reduce(function ($result, $access) {
                $kelasMapel = KelasMapel::find($access->kelas_mapel_id);
                if (! $kelasMapel) return $result;

                $mapel = Mapel::find($kelasMapel->mapel_id);
                $kelas = Kelas::find($kelasMapel->kelas_id);
                if (! $mapel || ! $kelas) return $result;

                $key = collect($result)->search(fn($i) => $i['mapel_id'] == $mapel->id);
                if ($key !== false) {
                    $result[$key]['kelas'][] = $kelas;
                } else {
                    $result[] = [
                        'mapel_id' => $mapel->id,
                        'mapel' => $mapel,
                        'kelas' => [$kelas],
                    ];
                }
                return $result;
            }, []);
    }

    private static function getSiswaAssignedClass(User $user): array
    {
        if (! $user->kelas_id) return [];

        return KelasMapel::where('kelas_id', $user->kelas_id)
            ->get()
            ->map(function ($km) {
                $mapel = Mapel::find($km->mapel_id);
                $kelas = Kelas::find($km->kelas_id);
                if (! $mapel || ! $kelas) return null;

                return [
                    'mapel_id' => $mapel->id,
                    'mapel' => $mapel,
                    'kelas' => [$kelas],
                ];
            })
            ->filter()
            ->values()
            ->toArray();
    }
}
