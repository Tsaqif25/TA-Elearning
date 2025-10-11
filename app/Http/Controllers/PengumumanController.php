<?php

namespace App\Http\Controllers;

use App\Models\EditorAccess;
use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\Mapel;
use App\Models\Pengumuman;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class : PengumumanController
 *
 * Class ini berisi berbagai fungsi yang berkaitan dengan manipulasi data-data pengumuman, terutama terkait dengan model.

 */
class PengumumanController extends Controller
{
    /**
     * Menampilkan halaman Tambah Pengumuman.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
public function viewCreatePengumuman($kelasId, Request $request)
{
    $mapelId = $request->mapel; // dari query string ?mapel=1

    $kelasMapel = KelasMapel::where('mapel_id', $mapelId)
        ->where('kelas_id', $kelasId)
        ->firstOrFail();

    $preparedIdPengumuman = Pengumuman::count() + 1;

    foreach (auth()->user()->EditorAccess as $key) {
        if ($key->kelas_mapel_id == $kelasMapel->id) {
            $roles = DashboardController::getRolesName();
            $mapel = Mapel::findOrFail($mapelId);
            $assignedKelas = DashboardController::getAssignedClass();

            return view('menu.pengajar.pengumuman.viewTambahPengumuman', [
                'assignedKelas'        => $assignedKelas,
                'title'                => 'Tambah Pengumuman',
                'roles'                => $roles,
                'kelasId'              => $kelasId,
                'mapel'                => $mapel,
                'preparedIdPengumuman' => $preparedIdPengumuman
            ]);
        }
    }

    abort(404, 'Anda tidak punya akses ke kelas & mapel ini');
}




   
  public function viewUpdatePengumuman(Pengumuman $pengumuman, Request $request)
{
    $kelasMapel = KelasMapel::findOrFail($pengumuman->kelas_mapel_id);

    foreach (auth()->user()->EditorAccess as $key) {
        if ($key->kelas_mapel_id == $kelasMapel->id) {
            $roles = DashboardController::getRolesName();
            $mapel = Mapel::findOrFail($request->mapel);
            $kelas = Kelas::findOrFail($kelasMapel->kelas_id);
            $assignedKelas = DashboardController::getAssignedClass();

            return view('menu.pengajar.pengumuman.viewUpdatePengumuman', [
                'assignedKelas' => $assignedKelas,
                'title'         => 'Update Pengumuman',
                'pengumuman'    => $pengumuman,
                'roles'         => $roles,
                'kelasId'       => $kelas->id,
                'mapel'         => $mapel,
                'kelasMapel'    => $kelasMapel
            ]);
        }
    }

    abort(404);
}



 public function viewPengumuman()
{
    $roles = DashboardController::getRolesName();
    $assignedKelas = DashboardController::getAssignedClass();

    $pengumumanAll = Pengumuman::latest()->get();

    return view('menu.pengajar.pengumuman.viewPengumuman', [
        'assignedKelas' => $assignedKelas,
        'title'         => 'Daftar Pengumuman',
        'roles'         => $roles,
        'pengumumanAll' => $pengumumanAll,
    ]);
}



    public function createPengumuman(Request $request)
    {
        // Lakukan validasi untuk inputan form
        $request->validate([
            'name' => 'required',
            'content' => 'required',
        ]);

        try {
            // Dekripsi token dan dapatkan KelasMapel
            $token = decrypt($request->kelasId);
            $kelasMapel = KelasMapel::where('mapel_id', $request->mapelId)->where('kelas_id', $token)->first();

            $isHidden = 1;

            if ($request->opened) {
                $isHidden = 0;
            }
            $temp = [
                'kelas_mapel_id' => $kelasMapel['id'],
                'name' => $request->name,
                'content' => $request->content,
                'isHidden' => $isHidden,
            ];

            // Simpan data Pengumuman ke database
            Pengumuman::create($temp);

            // Commit transaksi database
            DB::commit();

            // Berikan respons sukses jika semuanya berjalan lancar
            return response()->json(['message' => 'Pengumuman berhasil dibuat'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error'], 200);
        }
    }


    public function updatePengumuman(Request $request)
    {
        // Lakukan validasi untuk inputan form
        $request->validate([
            'name' => 'required',
            'content' => 'required',
        ]);
        // return response()->json(['message' => $request->input()], 200);
        // Dekripsi token hasil dari hidden form lalu dapatkan data KelasMapel
        $pengumumanId = decrypt($request->pengumumanId);

        try {
            $isHidden = 1;

            if ($request->opened) {
                $isHidden = 0;
            }
            $data = [
                'name' => $request->name,
                'content' => $request->content,
                'isHidden' => $isHidden,
            ];
            // Simpan data Pengumuman ke database
            Pengumuman::where('id', $pengumumanId)->update($data);
            // Commit transaksi database
            DB::commit();

            // Berikan respons sukses jika semuanya berjalan lancar
            return response()->json(['message' => 'Pengumuman berhasil dibuat'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error'], 200);
        }
    }

    /**
     * Menghapus Pengumuman.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyPengumuman(Request $request)
    {

        // Dapatkan Id Pengumuman dari Inputan Form request
        $pengumumanId = $request->hapusId;

        // Logika untuk memeriksa apakah pengguna yang sudah login memiliki akses editor
        foreach (Auth()->User()->EditorAccess as $key) {
            if ($key->kelas_mapel_id == $request->kelasMapelId) {
                Pengumuman::where('id', $pengumumanId)->delete();

                return redirect()->back()->with('success', 'Pengumuman Berhasil dihapus');
            }
        }
        abort(404);
    }


   public function redirectBack(Request $request)
{
    $mapelId = $request->mapelId;
    $kelasId = $request->kelasId;
    $message = $request->message;

    return redirect()->route('viewKelasMapel', [
        'mapel' => $mapelId,
        'kelas' => $kelasId
    ])->with('success', 'Data Berhasil di ' . $message);
}

}
