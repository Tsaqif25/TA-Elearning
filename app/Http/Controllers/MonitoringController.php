<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\PengajarKelasMapel;

class MonitoringController extends Controller
{
    
 public function monitoringGuru()
    {
        $gurus = Guru::with(['user', 'pengajarKelasMapels.kelasMapel.mapel'])
            ->get();

        foreach ($gurus as $guru) {

            // 🔹 Ambil semua kelas_mapel guru ini
            $kelasMapelIds = $guru->pengajarKelasMapels->pluck('kelas_mapel_id');

            // 🔹 Hitung materi, tugas, ujian
            $guru->total_materi = Materi::whereIn('kelas_mapel_id', $kelasMapelIds)->count();
            $guru->total_tugas  = Tugas::whereIn('kelas_mapel_id', $kelasMapelIds)->count();
            $guru->total_ujian  = Ujian::whereIn('kelas_mapel_id', $kelasMapelIds)->count();

            // 🔹 Ambil SEMUA mapel yang dia ajar
            $guru->mapel_list = $guru->pengajarKelasMapels
                ->map(fn($pkm) => $pkm->kelasMapel->mapel->name)
                ->unique()
                ->values()
                ->toArray();
        }

        return view('menu.wakur.monitoring.monitoring', compact('gurus'));
    }


    // 🟣 Halaman detail 1 guru
    public function detailGuru(Guru $guru)
    {
        // ambil semua kelas_mapel yang dia ajar
        $kelasMapelIds = PengajarKelasMapel::where('guru_id', $guru->id)
            ->pluck('kelas_mapel_id');

        // semua materi yang dia upload (di semua kelas & mapel)
        $materi = Materi::with('kelasMapel.kelas', 'kelasMapel.mapel')
            ->whereIn('kelas_mapel_id', $kelasMapelIds)
            ->latest()
            ->get();

        // semua tugas
        $tugas = Tugas::with('kelasMapel.kelas', 'kelasMapel.mapel')
            ->whereIn('kelas_mapel_id', $kelasMapelIds)
            ->latest()
            ->get();

        // semua ujian
        $ujian = Ujian::with('kelasMapel.kelas', 'kelasMapel.mapel')
            ->whereIn('kelas_mapel_id', $kelasMapelIds)
            ->latest()
            ->get();

        return view('menu.wakur.monitoring.detail', compact(
            'guru',
            'materi',
            'tugas',
            'ujian'
        ));
    }
}
