<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\DataSiswa;
use App\Models\KelasMapel;
use App\Exports\KelasExport;
use App\Imports\KelasImport;
use App\Models\EditorAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class KelasController extends Controller
{
    /**
     * Menampilkan halaman data kelas
     */
    public function viewKelas ()
    {
        $kelas = Kelas::paginate(15);
    
    
        return view('menu.admin.controlKelas.index', compact('kelas'))
            ->with('title', 'Data Kelas');
    }


public function searchKelas(Request $request)
{
    // Validasi input keyword
    $request->validate([
        'keyword' => ['required', 'string', 'max:255'],
    ]);

    $keyword = $request->keyword;

    // Query pencarian hanya berdasarkan nama kelas
    $kelas = Kelas::where('name', 'LIKE', "%{$keyword}%")
        ->paginate(6);

    // Kirim ke view
  return view('menu.admin.controlKelas.search', compact('kelas', 'keyword'))
       ->with('title', 'Hasil Pencarian Kelas');

}
    public function viewTambahKelas()
    {
        $dataMapel = Mapel::all();
       
        return view('menu.admin.controlKelas.create', compact('dataMapel'))
            ->with('title', 'Tambah Kelas');
    }


    public function validateNamaKelas(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:kelas|max:255',
            'mapels' => 'array'
        ]);

        // Create kelas
        $kelas = Kelas::create(['name' => $validated['name']]);

        // Attach mapels if provided
        if (isset($validated['mapels'])) {
            foreach ($validated['mapels'] as $mapelId) {
                KelasMapel::create([
                    'kelas_id' => $kelas->id,
                    'mapel_id' => $mapelId
                ]);
            }
        }

        return redirect()->route('viewKelas')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }


    public function viewUpdateKelas(Kelas $kelas)
    {
        $dataMapel = Mapel::all();
        $kelasMapel = $kelas->KelasMapel()->with('mapel')->get()->pluck('mapel');
     
        return view('menu.admin.controlKelas.edit', compact('kelas', 'dataMapel', 'kelasMapel'))
            ->with('title', 'Edit Kelas');
    }


public function updateKelas(Request $request)
{
    $validated = $request->validate([
        'id' => 'required|exists:kelas,id',
        'nama' => 'required|max:255',
        'mapels' => 'array'
    ]);

    $kelas = Kelas::findOrFail($validated['id']);

    // Update nama kelas
    $kelas->update(['name' => $validated['nama']]);

    // Update mapels
    if (isset($validated['mapels'])) {
        // Cari kelas_mapel yang dihapus
        $mapelsToRemove = KelasMapel::where('kelas_id', $kelas->id)
            ->whereNotIn('mapel_id', $validated['mapels'])
            ->pluck('id');

        if ($mapelsToRemove->isNotEmpty()) {
            EditorAccess::whereIn('kelas_mapel_id', $mapelsToRemove)->delete();
            KelasMapel::whereIn('id', $mapelsToRemove)->delete();
        }

        // Tambahkan mapel baru (hindari duplikat dengan firstOrCreate)
        foreach ($validated['mapels'] as $mapelId) {
            KelasMapel::firstOrCreate([
                'kelas_id' => $kelas->id,
                'mapel_id' => $mapelId
            ]);
        }
    }
    return redirect()->back()->with('success', 'Kelas berhasil diperbarui!');
}

public function destroyKelas(Request $request)
{
    $request->validate([
        'idHapus' => 'required|exists:kelas,id',
    ]);
    Kelas::destroy($request->idHapus);
     return redirect()->back()->with('delete-success', 'Berhasil menghapus Kelas!');
}


    public function export()
    {
        return Excel::download(new KelasExport, 'export-kelas.xls');
    }

    
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        session()->forget('imported_ids', []);

        try {
            Excel::import(new KelasImport, $request->file('file'));

            $ids = session()->get('imported_ids');
            Kelas::whereNotIn('id', $ids)->delete();
            DataSiswa::whereNotIn('kelas_id', $ids)->update(['kelas_id' => null]);

            $editorId = KelasMapel::whereNotIn('kelas_id', $ids)->get('id');
            KelasMapel::whereNotIn('kelas_id', $ids)->delete();

            $editor = EditorAccess::whereIn('kelas_mapel_id', $editorId)->get();
            if (count($editor) > 0) {
                EditorAccess::whereIn('kelas_mapel_id', $editorId)->delete();
            }

            return redirect()->route('viewKelas')->with('import-success', 'Data Kelas berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->route('viewKelas')->with('import-error', 'Error: ' . $e);
        }
    }

    /**
     * Mengunduh contoh data kelas dalam format Excel.
     */
    public function contohKelas()
    {
        $file = public_path('/examples/contoh-data-kelas.xls');
        return response()->download($file, 'contoh-kelas.xls');
    }
}