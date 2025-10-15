<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Ujian;

class DashboardController extends Controller
{
    public function index()
    {
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
    }
}
