<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Contact;
use Illuminate\View\View;
use App\Models\KelasMapel;
use App\Models\EditorAccess;
use Illuminate\Http\Request;
use App\Exports\PengajarExport;
use App\Imports\PengajarImport;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;

class PengajarController extends Controller
{
  
  public function viewPengajar()
{
    $pengajar = User::role('pengajar')->paginate(15);
    $title = 'Data Pengajar';

    return view('menu.admin.controlPengajar.viewPengajar', compact('title', 'pengajar'));
}


public function viewNewPengajar()
{
    $dataKelas = Kelas::all();

    return view('menu.admin.controlPengajar.tambahPengajar', compact('dataKelas'))
        ->with('title', 'Tambah Pengajar');
}


    public function storePengajar(Request $request)
{
    
    $validated = $request->validate([
        'nama'             => 'required|min:5|string|max:255',
        'email'            => 'required|email|unique:users,email',
        'password'         => 'required|min:8',
        'confirm-password' => 'required|min:8|same:password',
        'noTelp'           => 'nullable|string|max:20',
        'nuptk'            => 'nullable|string|max:20',
        'nik'              => 'nullable|string|max:20',
        'kelas_mapel'      => 'nullable|json'
    ]);

    DB::beginTransaction();

    try {
        // ✅ 2. Simpan User + Role
        $pengajar = User::create([
            'name'     => $validated['nama'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        $pengajar->assignRole('pengajar');

        // ✅ 3. Simpan Contact
        Contact::create([
            'user_id' => $pengajar->id,
            'no_telp' => $validated['noTelp'] ?? null,
            'nuptk'   => $validated['nuptk'] ?? null,
            'nik'     => $validated['nik'] ?? null,
        ]);

      // ✅ 4. Simpan akses kelas-mapel (jika ada)
if (!empty($validated['kelas_mapel'])) {
    foreach ($validated['kelas_mapel'] as $kelasMapelId) {
        // Cek apakah sudah ada akses
        if (!EditorAccess::where('kelas_mapel_id', $kelasMapelId)->exists()) {
            EditorAccess::create([
                'user_id'        => $pengajar->id,
                'kelas_mapel_id' => $kelasMapelId,
            ]);
        }
    }
}
        DB::commit();

        return redirect()
            ->route('viewPengajar')
            ->with('success', 'Data pengajar berhasil ditambahkan!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()
            ->withInput()
            ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
    }
}

  

public function searchPengajar(Request $request): View
{
    $keyword = $request->keyword;

    $pengajar = User::where('name', 'LIKE', "%{$keyword}%")
        ->paginate(6);

    return view('menu.admin.controlPengajar.search', [
        'pengajar' => $pengajar,
        'keyword'  => $keyword,
        'title'    => 'Hasil Pencarian Pengajar',
    ]);
}

  
public function viewUpdatePengajar(User $user)
{
    $contact = Contact::where('user_id', $user->id)->first();
    $roles = Role::all();
    $kelas = Kelas::all();
    $mapelEnrolled = EditorAccess::with(['kelasMapel.kelas', 'kelasMapel.mapel'])
        ->where('user_id', $user->id)
        ->get()
        ->pluck('kelasMapel');

    return view('menu.admin.controlPengajar.updatePengajar', compact(
        'user', 'contact', 'kelas', 'mapelEnrolled', 'roles'
    ))->with('title', 'Update Pengajar');
}

public function updatePengajar(Request $request)
{

  
    $user = User::findOrFail($request->id);
    
    $user->update([
        'name' => $request->nama,
        'email' => $request->email,
      ($request->filled('password') ? ['password' => bcrypt($request->password)] : [])
    ]);
    
    $user->contact()->update($request->only(['no_Telp', 'nuptk', 'nik']));
    
    return back()->with('success', 'Update berhasil!');
}
   public function destroyPengajar(Request $request)
    {
        // dd($request);
        User::where('id', $request->idHapus)->delete();
        EditorAccess::where('user_id', $request->idHapus)->delete();

        return redirect(route('viewPengajar'))->with('delete-success', 'Berhasil menghapus data!');
    }



    public function export()
    {
        return Excel::download(new PengajarExport, 'export-pengajar-' . date('Y-m-d') . '.xlsx');
    }


 public function import(Request $request)
{
  
    
    try {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        // Reset session imported_ids
        session()->forget('imported_ids');

        // Import file
        Excel::import(new PengajarImport, $request->file('file'));

        // Ambil IDs yang berhasil diimport
        $importedIds = session('imported_ids', []);
        $importedCount = count($importedIds);

        return redirect()->back()->with('success', "Berhasil import {$importedCount} data pengajar");

    } catch (\Exception $e) {
        Log::error('Import error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage());
    }
}


    public function downloadTemplate()
    {
        $file = public_path('examples/contoh-data-pengajar.xls');
     
        if (file_exists($file)) {
            return response()->download($file, 'contoh-data-pengajar.xls');
        }
        
        return redirect()->back()->withErrors(['error' => 'File template tidak ditemukan']);
    }



}