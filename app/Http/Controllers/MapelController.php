<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Mapel;
use App\Models\KelasMapel;
use App\Exports\MapelExport;
use App\Imports\MapelImport;
use App\Models\EditorAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class MapelController extends Controller
{
   public function viewMapel()
    {
        $mapel = Mapel::paginate(10);
        
        return view('menu.admin.controlMapel.index', compact( 'mapel'))
               ->with('title', 'Data Mapel');
    }


    public function viewTambahMapel()
    {
        
        return view('menu.admin.controlMapel.create', )
               ->with('title', 'Tambah Mapel');
    }

        public function validateNamaMapel(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:mapels|max:255',
            'deskripsi' => 'nullable|string|max:500'
        ], [
            'name.required' => 'Nama mapel wajib diisi',
            'name.unique' => 'Nama mapel sudah ada, gunakan nama lain',
            'name.max' => 'Nama mapel maksimal 255 karakter'
        ]);

        try {
            // Simpan mapel
            $mapel = Mapel::create([
                'name' => $request->name,
                'deskripsi' => $request->deskripsi ?? '-',
            ]);

           
            return redirect()->route('viewMapel')
                   ->with('success', 'Mapel "' . $request->name . '" berhasil ditambahkan!');
                   
        } catch (Exception $e) {
            return redirect()->back()
                   ->with('error', 'Gagal menambahkan mapel: ' . $e->getMessage())
                   ->withInput();
        }
    }

  

 public function viewUpdateMapel(Mapel $mapel)
{
    return view('menu.admin.controlMapel.edit', compact('mapel'))
           ->with('title', 'Update Mapel');
}


public function updateMapel(Request $request)
{
    $request->validate([
        'id' => 'required|exists:mapels,id',
        'name' => 'required|max:255|unique:mapels,name,' . $request->id,
        'deskripsi' => 'nullable|string|max:500',
    ], [
        'name.required' => 'Nama mapel wajib diisi',
        'name.unique'   => 'Nama mapel sudah digunakan',
        'name.max'      => 'Nama mapel maksimal 255 karakter',
    ]);

    try {
        $mapel = Mapel::findOrFail($request->id);
        $mapel->update($request->only(['name', 'deskripsi']));

        return redirect()->route('viewMapel')
               ->with('success', "Mapel \"{$request->name}\" berhasil diperbarui!");
    } catch (Exception $e) {
        Log::error($e);

        return back()
               ->with('error', 'Terjadi kesalahan saat memperbarui mapel. Silakan coba lagi.')
               ->withInput();
    }
}



  
 public function destroyMapel(Request $request)
{
    try {
        $mapel = Mapel::findOrFail($request->idHapus);
        $namaMapel = $mapel->name;

       
        $mapel->delete();

        return redirect()->back()
               ->with('delete-success', "Mapel \"$namaMapel\" berhasil dihapus!");
    } catch (Exception $e) {
        return redirect()->back()
               ->with('error', 'Gagal menghapus mapel: ' . $e->getMessage());
    }
}

 public function searchMapel(Request $request)
    {
        // Validasi input keyword
       $request->validate([
            'keyword' => ['required', 'string', 'max:255'],
        ]);

        $keyword = $request->keyword;

        // Query pencarian mapel berdasarkan nama & deskripsi
        $mapels = Mapel::with('kelasMapel')
            ->where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('deskripsi', 'LIKE', "%{$keyword}%")
            ->paginate(6);

        // Kirim ke view
     return view('menu.admin.controlMapel.search', [
    'mapels' => $mapels,
    'keyword' => $keyword,
    'title' => 'Hasil Pencarian Mapel',
     ]);
    }


    public function cekKelasMapel(Request $request)
    {
        $response = KelasMapel::where('kelas_id', $request->kelasId)->where('mapel_id', $request->mapelId)->first(); // Mencari data kelas-mapel berdasarkan kelas_id dan mapel_id

        if (count($response->EditorAccess) > 0) {
            return response()->json(['response' => '1']); // Pesan jika memiliki akses Editor
        } else {
            return response()->json(['response' => '0']); // Pesan jika tidak memiliki akses Editor
        }
    }

        public function searchKelasMapel(Request $request) // Fungsi untuk mencari kelas-mapel yang terkait dengan kelas tertentu
    {

        $kelasMapel = KelasMapel::where('kelas_id', $request->kelasId)->get();
        $enrolledMapel = []; // Inisialisasi array untuk menyimpan data mapel yang diambil

        foreach ($kelasMapel as $key) {
            $mapel = Mapel::where('id', $key->mapel_id)->first();
            $pengajarExist = count($key->EditorAccess);
            $mapel['exist'] = $pengajarExist;

            if ($mapel) {
                $enrolledMapel[] = $mapel; // Tambahkan data mapel ke dalam array
            }
        }
        // dd($enrolledMapel);

        return response()->json($enrolledMapel);
    }

    public function tambahEditorAccess(Request $request)
    {
        $kelasMapel = KelasMapel::where('kelas_id', $request->kelasId)
                                ->where('mapel_id', $request->mapelId)
                                ->first();

        EditorAccess::create([
            'user_id' => $request->userId,
            'kelas_mapel_id' => $kelasMapel->id,
        ]);

        return response()->json(['response' => 'Added']);
    }

    public function deleteEditorAccess(Request $request)
    {
        $kelasMapel = KelasMapel::where('kelas_id', $request->kelasId)
                                ->where('mapel_id', $request->mapelId)
                                ->first();

        if (!$kelasMapel) {
            return response()->json(['response' => 'Data tidak ditemukan'], 404);
        }

        EditorAccess::where('kelas_mapel_id', $kelasMapel->id)->delete();
        return response()->json(['response' => 'Deleted']);
    }

    public function addChangeEditorAccess(Request $request)
    {
        try {
            $kelasMapel = KelasMapel::where('kelas_id', $request->kelasId)
                                   ->where('mapel_id', $request->mapelId)
                                   ->first();
            
            $editorAccess = EditorAccess::where('kelas_mapel_id', $kelasMapel->id)->get();

            if ($request->pengajarId == 'delete') {
                EditorAccess::where('kelas_mapel_id', $kelasMapel->id)->delete();
                return response()->json(['success' => 'deleted']);
            }

            if (count($editorAccess) > 0) {
                EditorAccess::where('kelas_mapel_id', $kelasMapel->id)
                           ->update(['user_id' => $request->pengajarId]);
                return response()->json(['success' => 1]);
            } else {
                EditorAccess::create([
                    'user_id' => $request->pengajarId,
                    'kelas_mapel_id' => $kelasMapel->id
                ]);
                return response()->json(['success' => 0]);
            }
        } catch (Exception $e) {
            return response()->json(['success' => $e->getMessage()]);
        }
    }

    public function contohMapel()
    {
        $file = public_path('examples/contoh-data-mapel.xls');
        return response()->download($file, 'contoh-mapel.xls');
    }

    public function export()
    {
        return Excel::download(new MapelExport, 'export-mapel-' . date('Y-m-d') . '.xls');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,pdf|max:2048',
        ]);

        session()->forget('imported_ids', []);

        try {
            Excel::import(new MapelImport, $request->file('file'));
            $ids = session()->get('imported_ids', []);
            
            Mapel::whereNotIn('id', $ids)->delete();
            $editorId = KelasMapel::whereNotIn('mapel_id', $ids)->get('id');
            KelasMapel::whereNotIn('mapel_id', $ids)->delete();
            
            $editor = EditorAccess::whereIn('kelas_mapel_id', $editorId)->get();
            if (count($editor) > 0) {
                EditorAccess::whereIn('kelas_mapel_id', $editorId)->delete();
            }

            return redirect()->route('viewMapel')
                   ->with('import-success', 'Data Mapel berhasil diimpor (' . count($ids) . ' data).');
                   
        } catch (Exception $e) {
            return redirect()->route('viewMapel')
                   ->with('import-error', 'Gagal import: ' . $e->getMessage());
        }
    }
}