<?php

namespace App\Http\Controllers\Materi;

use App\Models\Materi;
use App\Models\DataSiswa;
use App\Models\KelasMapel;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class MateriController extends Controller
{
    public function create(KelasMapel $kelasMapel)
    {
     
        $kelas = $kelasMapel->kelas;  
        $mapel = $kelasMapel->mapel;   

      
        return view('menu.pengajar.materi.add', [
            'kelasMapel' => $kelasMapel, 
            'kelas' => $kelas,          
            'mapel' => $mapel,           
            'title' => 'Tambah Materi'  
        ]);
    }

 public function store(Request $request, KelasMapel $kelasMapel)
{
    $validated = $request->validate([
        'name' => 'required|string',   
        'konten' => 'required|string',
        'youtube_link' => 'nullable',  
    ]);

    // Simpan materi baru
    $materi = Materi::create([
        'kelas_mapel_id' => $kelasMapel->id,         
        'name' => $validated['name'],                  
        'konten' => $validated['konten'],           
        'youtube_link' => $validated['youtube_link'] ?? null ,
        'user_id' => Auth::id() 
    ]);

    // 🔔 Tambahkan Notifikasi ke Semua Siswa di Kelas Ini
    $kelasId = $kelasMapel->kelas_id; // ambil ID kelas dari KelasMapel
    $siswaList = DataSiswa::where('kelas_id', $kelasId)->get();

    foreach ($siswaList as $siswa) {
        Notification::create([
            'user_id' => $siswa->user_id,
            'title' => 'Materi Baru: ' . $materi->name,
            'message' => 'Guru menambahkan materi baru di mapel ' . $kelasMapel->mapel->name,
            'type' => 'materi',
        ]);
    }

    // Jika request berasal dari AJAX (Dropzone / CKEditor)
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil disimpan!',
            'materi_id' => $materi->id 
        ]);
    }

    // Redirect biasa jika bukan AJAX
    return redirect()->route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel_id, 
        'kelas' => $kelasMapel->kelas_id, 
        'tab'   => 'materi'            
    ])->with('success', 'Materi berhasil ditambahkan & notifikasi dikirim.');
}


    public function edit(Materi $materi)
    {

        $kelasMapel = $materi->kelasMapel;  
        $kelas = $kelasMapel->kelas;        
        $mapel = $kelasMapel->mapel;       

   
        return view('menu.pengajar.materi.edit', [
            'materi' => $materi,     
            'kelasMapel' => $kelasMapel, 
            'kelas' => $kelas,         
            'mapel' => $mapel,          
            'title' => 'Update Materi'  
        ]);
    }

    public function update(Request $request, Materi $materi)
    {
     
        $validated = $request->validate([
            'name' => 'required|string|max:255', 
            'konten' => 'required|string',      
            'youtube_link' => 'nullable|string',
        ]);

        
        $materi->update($validated);

        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil diperbarui!',
                'materi_id' => $materi->id 
            ]);
        }

        
        $kelasMapel = $materi->kelasMapel;

       
        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id, 
            'kelas' => $kelasMapel->kelas_id, 
            'tab'   => 'materi'             
        ])->with('success', 'Materi berhasil diperbarui!');
    }

    public function show(Materi $materi)
    {
        $kelasMapel = $materi->kelasMapel;
        $kelas = $kelasMapel->kelas;
        $mapel = $kelasMapel->mapel;
        $materiAll = Materi::where('kelas_mapel_id', $kelasMapel->id)
            ->orderBy('created_at', 'asc')
            ->get();

        //  Kirim data ke view detail materi
        return view('menu.pengajar.materi.view', [
            'title' => $materi->name,    
            'materi' => $materi,         
            'materiAll' => $materiAll,    
            'kelasMapel' => $kelasMapel,  
            'kelas' => $kelas,           
            'mapel' => $mapel,            
           
        ]);
    }

    public function destroy(Materi $materi)
    {
    
        $kelasMapel = $materi->kelasMapel;

   
        $materi->delete();

       
        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id, 
            'kelas' => $kelasMapel->kelas_id,
            'tab'   => 'materi'              
        ])->with('success', 'Materi berhasil dihapus!');
    }
}
