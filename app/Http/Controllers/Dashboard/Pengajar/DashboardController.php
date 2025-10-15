<?php

namespace App\Http\Controllers\Dashboard\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\{EditorAccess, DataSiswa};
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua akses kelas-mapel milik guru
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

        $kelasDanMapel = $akses->map(fn($item) => [
            'kelas_id'   => optional($item->kelasMapel->kelas)->id,
            'kelas_nama' => optional($item->kelasMapel->kelas)->name,
            'mapel_id'   => optional($item->kelasMapel->mapel)->id,
            'mapel_nama' => optional($item->kelasMapel->mapel)->name,
        ]);

        return view('menu.pengajar.dashboard.dashboard', [
            'title' => 'Dashboard Pengajar',
            'user' => $user,
            'kelasDanMapel' => $kelasDanMapel,
            ...$statistik
        ]);
    }
}
