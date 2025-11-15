<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\Materi;
use Illuminate\Http\Request;
use App\Models\PengajarKelasMapel;
use App\Http\Controllers\Controller;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function monitoringGuru()
    {
        $gurus = Guru::with('user', 'pengajarKelasMapels.kelasMapel.kelas', 'pengajarKelasMapels.kelasMapel.mapel')
            ->get();

    return view('menu.wakur.monitoring.monitoring', compact('gurus'));
    }


    public function detailGuru(Guru $guru)
{
    // kelas yang dia ajar
    $kelasMapelIds = PengajarKelasMapel::where('guru_id', $guru->id)
                        ->pluck('kelas_mapel_id');

    // materi
    $materi = Materi::whereIn('kelas_mapel_id', $kelasMapelIds)
                    ->latest()
                    ->get();

    // tugas
    $tugas = Tugas::whereIn('kelas_mapel_id', $kelasMapelIds)
                  ->latest()
                  ->get();

    // ujian
    $ujian = Ujian::whereIn('kelas_mapel_id', $kelasMapelIds)
                  ->latest()
                  ->get();

    return view('menu.wakur.monitoring.detail', compact(
        'guru',
        'materi',
        'tugas',
        'ujian'
    ));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
