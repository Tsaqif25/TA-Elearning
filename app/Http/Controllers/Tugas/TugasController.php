<?php

namespace App\Http\Controllers\Tugas;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PengajarKelasMapel;
use App\Http\Controllers\Controller;
use App\Models\{Tugas, PengumpulanTugas, KelasMapel};

class TugasController extends Controller
{
    /**
     *  Menampilkan detail tugas dan status pengerjaan siswa
     */
public function viewTugas(Tugas $tugas)
{
    $kelasMapel = $tugas->kelasMapel ?? abort(404, 'Kelas Mapel tidak ditemukan.');
    $mapel = $kelasMapel->mapel;
    $kelas = $kelasMapel->kelas()->with('dataSiswa')->first(); // ✅ Perbaikan disini

    $pengajar = PengajarKelasMapel::where('kelas_mapel_id', $kelasMapel->id)
        ->with('guru')
        ->first();

    $tugasAll = Tugas::where('kelas_mapel_id', $kelasMapel->id)->get();

    $pengumpulan = PengumpulanTugas::where('tugas_id', $tugas->id)
        ->where('siswa_id', auth()->user()->dataSiswa->id ?? null)
        ->first();

    return view('menu.pengajar.tugas.view', [
        'title'        => $tugas->name,
        'tugas'        => $tugas,
        'kelas'        => $kelas,
        'mapel'        => $mapel,
        'kelasMapel'   => $kelasMapel,
        'pengajar'     => $pengajar,
        'tugasAll'     => $tugasAll,
        'pengumpulan'  => $pengumpulan,
    ]);
}


    /**
     *  Update nilai tugas siswa oleh guru
     */
public function siswaUpdateNilai(Request $request, Tugas $tugas)
{
    $validated = $request->validate([
        'siswaId' => 'required|array',
        'nilai'   => 'required|array',
    ]);

    foreach ($validated['siswaId'] as $i => $userId) {
        $nilaiInput = $validated['nilai'][$i] ?? null;
        if ($nilaiInput === null || $nilaiInput === '') continue;

        $nilai = max(0, min(100, (int) $nilaiInput));

        PengumpulanTugas::updateOrCreate(
            ['tugas_id' => $tugas->id, 'siswa_id' => $userId],
            ['nilai' => $nilai]
        );
    }

    return back()->with('success', 'Nilai berhasil diperbarui.');
}


    /**
     *  Tampilkan form tambah tugas baru
     */
    public function viewCreateTugas(KelasMapel $kelasMapel)
    {
        return view('menu.pengajar.tugas.add', [
            'title'       => 'Tambah Tugas',
            'kelasMapel'  => $kelasMapel,
            'kelas'       => $kelasMapel->kelas,
            'mapel'       => $kelasMapel->mapel,
            'tab'         => 'tugas',
        ]);
    }

    /**
     *  Tampilkan form edit tugas
     */
    public function viewUpdateTugas(Tugas $tugas)
    {
        $kelasMapel = $tugas->kelasMapel;

        return view('menu.pengajar.tugas.edit', [
            'title'       => 'Edit Tugas',
            'tugas'       => $tugas,
            'kelasMapel'  => $kelasMapel,
            'kelas'       => $kelasMapel->kelas,
            'mapel'       => $kelasMapel->mapel,
            'tab'         => 'tugas',
        ]);
    }

    /**
     *  Simpan tugas baru
     */
    public function createTugas(Request $request, KelasMapel $kelasMapel)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'due'     => 'required|date_format:Y-m-d\TH:i',
        ]);

        $tugas = Tugas::create([
            'kelas_mapel_id' => $kelasMapel->id,
            'name'           => $validated['name'],
            'deskripsi'        => $validated['deskripsi'],
            'due'            => Carbon::createFromFormat('Y-m-d\TH:i', $validated['due']),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'tugas_id'  => $tugas->id,
                'message'   => 'Tugas berhasil ditambahkan!',
            ]);
        }

        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id,
            'kelas' => $kelasMapel->kelas_id,
            'tab'   => 'tugas',
        ])->with('success', 'Tugas berhasil ditambahkan!');
    }

    /**
     *  Update data tugas yang sudah ada
     */
    public function updateTugas(Request $request, Tugas $tugas)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'due'     => 'required|date_format:Y-m-d\TH:i',
        ]);

        $tugas->update([
            'name'    => $validated['name'],
            'deskripsi' => $validated['deskripsi'],
            'due'     => Carbon::createFromFormat('Y-m-d\TH:i', $validated['due']),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success'  => true,
                'tugas_id' => $tugas->id,
                'message'  => 'Tugas berhasil diperbarui!',
            ]);
        }

        return redirect()->route('viewKelasMapel', [
            'mapel' => $tugas->kelasMapel->mapel_id,
            'kelas' => $tugas->kelasMapel->kelas_id,
            'tab'   => 'tugas',
        ])->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     *  Hapus tugas beserta data relasinya
     */
    public function destroyTugas(Tugas $tugas)
    {
        $kelasMapel = $tugas->kelasMapel;
        $tugas->delete();

        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id,
            'kelas' => $kelasMapel->kelas_id,
            'tab'   => 'tugas',
        ])->with('success', 'Tugas berhasil dihapus!');
    }
}
