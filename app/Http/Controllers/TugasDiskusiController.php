<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use App\Models\TugasKomentar;
use App\Models\PengumpulanTugas;
use App\Http\Controllers\Controller;

class TugasDiskusiController extends Controller
{
    public function index(Tugas $tugas,DataSiswa $siswa)
    {
        $pengumpulan = PengumpulanTugas::where('tugas_id',$tugas->id)->where('siswa_id',$siswa->id)->first();
        $komentar = TugasKomentar::where('tugas_id',$tugas->id)->where('siswa_id',$siswa->id)->orderBy('created_at','asc')->get();
        
        return view('menu.pengajar.tugas.diskusi',compact('tugas','siswa','pengumpulan','komentar'));
    }

    public function store (Request $request, Tugas $tugas, DataSiswa $siswa)
{
    $request->validate([
        'pesan' => 'required'
    ]);

    TugasKomentar::create([
        'tugas_id' => $tugas->id,
        'siswa_id' => $siswa->id,
        'user_id' => auth()->id(),
        'pesan' => $request->pesan,
    ]);
    return back();
}

public function indexSiswa(Tugas $tugas)
{
   // Ambil otomatis siswa yang login
    $siswa = DataSiswa::where('user_id', auth()->id())->firstOrFail();

    $pengumpulan = PengumpulanTugas::where('tugas_id', $tugas->id)
                    ->where('siswa_id', $siswa->id)
                    ->first();

    $komentar = TugasKomentar::where('tugas_id', $tugas->id)
                    ->where('siswa_id', $siswa->id)
                    ->orderBy('created_at')
                    ->get();

    return view('menu.siswa.tugas.diskusi', compact('tugas','siswa','pengumpulan','komentar'));
}

public function storeSiswa(Request $request, Tugas $tugas)
{
   // Ambil otomatis siswa yang login
    $siswa = DataSiswa::where('user_id', auth()->id())->firstOrFail();

    $request->validate(['pesan' => 'required']);

    TugasKomentar::create([
        'tugas_id' => $tugas->id,
        'siswa_id' => $siswa->id,
        'user_id'  => auth()->id(), // siswa
        'pesan'    => $request->pesan
    ]);

    return back();
}


}
