<?php

namespace App\Http\Controllers;

use App\Models\{
    User, DataSiswa, Kelas, Mapel, Materi, Tugas, Ujian,
    KelasMapel, PengajarKelasMapel, Guru
};
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function viewDashboard(): View|RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Arahkan dashboard sesuai role
        if ($user->hasRole('Wakur')) {
            return $this->pengajarDashboard($user);
        } elseif ($user->hasRole('Pengajar')) {
            return $this->pengajarDashboard($user);
        } elseif ($user->hasRole('Siswa')) {
            return redirect()->route('home');
        }

        return redirect()->route('login')->with('error', 'Role tidak ditemukan.');
    }

    // 🟣 DASHBOARD WAKUR
    private function wakurDashboard(): View
    {
        return view('menu.wakur.dashboard.dashboard', [
            'title' => 'Dashboard Wakur',
            'roles' => 'Wakur',
        ]);
    }

    // 🟢 DASHBOARD PENGAJAR
    private function pengajarDashboard(User $user): View
    {
        // Ambil data guru yang terkait dengan user ini
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return view('menu.pengajar.dashboard.dashboard', [
                'title' => 'Dashboard Pengajar',
                'user' => $user,
                'kelasDanMapel' => [],
                // 'totalKelas' => 0,
                // 'totalMapel' => 0,
                // 'totalSiswa' => 0,
                'warning' => 'Data guru belum terhubung dengan user ini.',
            ]);
        }

        // Ambil semua kelas & mapel yang diampu guru ini
        $dataAkses = PengajarKelasMapel::where('guru_id', $guru->id)
            ->with(['kelasMapel.kelas', 'kelasMapel.mapel'])
            ->get();

        $kelasDanMapel = [];
        $kelasIds = [];
        $mapelIds = [];

        foreach ($dataAkses as $akses) {
            $kelas = $akses->kelasMapel->kelas ?? null;
            $mapel = $akses->kelasMapel->mapel ?? null;

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

        // $totalKelas = count(array_unique($kelasIds));
        // $totalMapel = count(array_unique($mapelIds));
        // $totalSiswa = DataSiswa::whereIn('kelas_id', $kelasIds)->count();

        return view('menu.pengajar.dashboard.dashboard', [
            'title' => 'Dashboard Pengajar',
            'user' => $user,
            'kelasDanMapel' => $kelasDanMapel,
            // 'totalKelas' => $totalKelas,
            // 'totalMapel' => $totalMapel,
            // 'totalSiswa' => $totalSiswa,
        ]);
    }

    // 🟡 FUNGSI UNTUK SISWA
    public function viewHome(): View|RedirectResponse
    {
        $user = Auth::user();

        if (!$user) return redirect()->route('login');
        if (!$user->hasRole('Siswa')) return redirect()->route('dashboard');

        // Ambil data siswa berdasarkan user_id
        $dataSiswa = DataSiswa::where('user_id', $user->id)->first();

        if (!$dataSiswa || !$dataSiswa->kelas) {
            return view('menu.siswa.home.home', [
                'title' => 'Home',
                'roles' => 'Siswa',
                'user' => $user,
                'kelas' => null,
                'mapelKelas' => [],
                'warning' => 'Anda belum terdaftar di kelas manapun.',
            ]);
        }

        $kelas = $dataSiswa->kelas;
        $mapelKelas = $this->getMapelWithPengajar($kelas);

        return view('menu.siswa.home.home', compact('user', 'kelas', 'mapelKelas') + [
            'title' => 'Home',
            'roles' => 'Siswa',
        ]);
    }

    // 🔹 Relasi mapel & pengajar untuk siswa
    private function getMapelWithPengajar(Kelas $kelas): array
    {
        $data = KelasMapel::where('kelas_id', $kelas->id)
            ->with(['mapel', 'pengajarKelasMapels.guru.user'])
            ->get();

        $hasil = [];

        foreach ($data as $item) {
            $mapel = $item->mapel;
            $pengajar = $item->pengajarKelasMapels->first()?->guru?->user;

            $hasil[] = [
                'mapel_id' => $mapel?->id,
                'mapel_name' => $mapel?->name,
                'deskripsi' => $mapel?->deskripsi,
                'pengajar_name' => $pengajar?->name ?? 'Belum Ditentukan',
            ];
        }

        return $hasil;
    }

public function viewSiswa($kelasId)
{
    $siswa = DataSiswa::where('kelas_id', $kelasId)->get();

    return view('menu.siswa.home.siswa', compact('siswa'));
}

}
