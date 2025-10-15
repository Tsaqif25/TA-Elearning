<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\{Kelas, Mapel, KelasMapel, EditorAccess, User};
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->kelas_id) {
            return view('menu.siswa.home.home', [
                'title' => 'Home',
                'roles' => 'Siswa',
                'user' => $user,
                'kelas' => null,
                'mapelKelas' => [],
            ])->with('warning', 'Anda belum terdaftar di kelas manapun');
        }

        $kelas = Kelas::find($user->kelas_id);
        $kelasMapel = KelasMapel::where('kelas_id', $kelas->id)->get();

        $mapelKelas = $kelasMapel->map(function ($km) {
            $mapel = Mapel::find($km->mapel_id);
            if (! $mapel) return null;

            $editorAccess = EditorAccess::where('kelas_mapel_id', $km->id)->first();
            $pengajar = $editorAccess ? User::find($editorAccess->user_id) : null;

            return [
                'mapel_name' => $mapel->name,
                'mapel_id' => $mapel->id,
                'deskripsi' => $mapel->deskripsi ?? '',
                'gambar' => $mapel->gambar ?? '',
                'pengajar_id' => $pengajar?->id,
                'pengajar_name' => $pengajar?->name ?? '-',
            ];
        })->filter()->values();

        return view('menu.siswa.home.home', [
            'title' => 'Home',
            'roles' => 'Siswa',
            'user' => $user,
            'kelas' => $kelas,
            'mapelKelas' => $mapelKelas,
        ]);
    }
}
