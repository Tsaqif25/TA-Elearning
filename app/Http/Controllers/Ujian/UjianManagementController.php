<?php

namespace App\Http\Controllers\Ujian;

use App\Models\Ujian;
use App\Models\KelasMapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UjianManagementController extends Controller
{


    // FORM TAMBAH UJIAN
    // public function create()
    // {
    //     $kelasMapel = KelasMapel::with('kelas', 'mapel')
    //         ->whereHas('pengajarKelasMapels', fn($q) => $q->where('guru_id', auth()->user()->guru->id))
    //         ->get();

    //     return view('menu.pengajar.ujian.viewTambahUjian', compact('kelasMapel'));
    // }
    public function create(KelasMapel $kelasMapel)
{
    return view('menu.pengajar.ujian.viewTambahUjian', compact('kelasMapel'));
}


    // SIMPAN UJIAN
public function store(Request $request, KelasMapel $kelasMapel)
{
    $request->validate([
        'judul' => 'required',
        'deskripsi' => 'required',
       
    ]);

    $ujian = Ujian::create([
       'kelas_mapel_id' => $kelasMapel->id,
        'guru_id'        => auth()->user()->guru->id, // WAJIB
        'judul'          => $request->judul,
        'deskripsi'      => $request->deskripsi,
    
        'random_question' => false,
        'random_answer'   => false,
        'show_answer'     => false,
    ]);

    return redirect()->route('ujian.soal.manage', $ujian->id)
        ->with('success', 'Ujian berhasil dibuat! Silakan tambahkan soal.');
}


    // DETAIL UJIAN
    public function show(Ujian $ujian)
    {
        $ujian->load('soal');

        return view('guru.ujian.show', compact('ujian'));
    }


public function edit(Ujian $ujian)
{
    // Data kelas-mapel dari ujian yang sedang diedit
    $kelasMapel = $ujian->kelasMapel;

    // Untuk dropdown (jika ingin pindahkan ujian ke kelasMapel lain)
    // $listKelasMapel = KelasMapel::with('kelas', 'mapel')->get();

    return view('menu.pengajar.ujian.viewUpdateUjian', [
        'ujian' => $ujian,
        'kelasMapel' => $kelasMapel,
        // 'listKelasMapel' => $listKelasMapel
    ]);
}

    // EDIT
    // public function edit(Ujian $ujian)
    // {
    //     $kelasMapel = KelasMapel::with('kelas', 'mapel')->get();
    //     return view('menu.pengajar.ujian.viewUpdateUjian', compact('ujian', 'kelasMapel'));
    // }

    // UPDATE
    public function update(Request $request, Ujian $ujian)
    {
     

$ujian->update([
    'judul' => $request->judul,
    'deskripsi' => $request->deskripsi,
 
]);


        //  Redirect ke halaman manage soal
        return redirect()->route('ujian.soal.manage', $ujian->id)
            ->with('success', 'Ujian berhasil diperbarui!');
    }

    // HAPUS
    public function destroy(Ujian $ujian)
    {
        $kelasMapel = $ujian->kelasMapel;

        $ujian->delete();

        // 👉 Balik ke halaman tab Quiz
        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id,
            'kelas' => $kelasMapel->kelas_id,
            'tab'   => 'quiz'
        ])->with('success', 'Ujian berhasil dihapus');
    }
}
