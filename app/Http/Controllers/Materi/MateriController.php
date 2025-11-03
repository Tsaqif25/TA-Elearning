<?php

namespace App\Http\Controllers\Materi;

use App\Models\Materi;
use App\Models\KelasMapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class MateriController extends Controller
{
    public function create(KelasMapel $kelasMapel)
    {
        // 🔹 Ambil data kelas dan mapel dari relasi belongsTo di model KelasMapel
        $kelas = $kelasMapel->kelas;   // data kelas (misalnya: XI TKJ 1)
        $mapel = $kelasMapel->mapel;   // data mapel (misalnya: Administrasi Sistem Jaringan)

        // 🔹 Kirim semua data ke view "tambah materi"
        return view('menu.pengajar.materi.add', [
            'kelasMapel' => $kelasMapel, // objek relasi antara kelas dan mapel
            'kelas' => $kelas,           // objek kelas yang diampu
            'mapel' => $mapel,           // objek mapel yang diampu
            'title' => 'Tambah Materi'   // judul halaman
        ]);
    }

    public function store(Request $request, KelasMapel $kelasMapel)
    {
        // 🔹 Validasi input dari form tambah materi
        $validated = $request->validate(rules: [
            'name' => 'required|string',   
            'content' => 'required|string',
            'youtube_link' => 'nullable',  
        ]);

        // 🔹 Simpan data materi baru ke tabel "materi"
        $materi = Materi::create([
            'kelas_mapel_id' => $kelasMapel->id,           // foreign key → dari parameter route {kelasMapel}
            'name' => $validated['name'],                  // judul materi → dari input form
            'content' => $validated['content'],            // isi materi → dari input form
            'youtube_link' => $validated['youtube_link'] ?? null, // link video (opsional)
        ]);

        // 🔹 Jika request berasal dari AJAX (misalnya Dropzone JS atau autosave)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil disimpan!',
                'materi_id' => $materi->id  // ID materi yang baru dibuat (dipakai Dropzone untuk upload file)
            ]);
        }

        // 🔹 Jika bukan AJAX → redirect ke halaman daftar materi di kelas-mapel terkait
        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id, // ID mapel dari relasi KelasMapel → menentukan mata pelajaran
            'kelas' => $kelasMapel->kelas_id, // ID kelas dari relasi KelasMapel → menentukan kelas
            'tab'   => 'materi'               // tab aktif di halaman kelas-mapel adalah "materi"
        ])->with('success', 'Materi berhasil ditambahkan!');
    }

    public function edit(Materi $materi)
    {
        // 🔹 Ambil relasi antar tabel: Materi → KelasMapel → Kelas & Mapel
        $kelasMapel = $materi->kelasMapel;  // ambil data relasi kelas-mapel dari materi ini
        $kelas = $kelasMapel->kelas;        // ambil data kelas dari relasi KelasMapel
        $mapel = $kelasMapel->mapel;        // ambil data mapel dari relasi KelasMapel

        // 🔹 Kirim semua data ke halaman edit materi
        return view('menu.pengajar.materi.edit', [
            'materi' => $materi,         // objek materi yang sedang diedit
            'kelasMapel' => $kelasMapel, // relasi kelas-mapel dari materi
            'kelas' => $kelas,           // data kelas
            'mapel' => $mapel,           // data mapel
            'title' => 'Update Materi'   // judul halaman
        ]);
    }

    public function update(Request $request, Materi $materi)
    {
        // 🔹 Validasi ulang input dari form edit materi
        $validated = $request->validate([
            'name' => 'required|string|max:255', // judul materi wajib diisi
            'content' => 'required|string',      // isi materi wajib diisi
            'youtube_link' => 'nullable|string', // link video opsional
        ]);

        // 🔹 Perbarui data materi yang ada di database
        $materi->update($validated);

        // 🔹 Jika update dikirim lewat AJAX (tanpa reload halaman)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil diperbarui!',
                'materi_id' => $materi->id // kirim ID materi yang diperbarui
            ]);
        }

        // 🔹 Ambil data kelas-mapel yang terkait agar bisa redirect ke halaman semula
        $kelasMapel = $materi->kelasMapel;

        // 🔹 Redirect kembali ke halaman kelas-mapel → tab "materi" tetap aktif
        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id, // ID mapel → agar URL menuju halaman mapel yang benar
            'kelas' => $kelasMapel->kelas_id, // ID kelas → agar URL menuju kelas yang benar
            'tab'   => 'materi'               // tab aktif di halaman tersebut adalah tab "materi"
        ])->with('success', 'Materi berhasil diperbarui!');
    }

    public function show(Materi $materi)
    {
        // 🔹 Ambil relasi antara Materi → KelasMapel → Kelas & Mapel
        $kelasMapel = $materi->kelasMapel;
        $kelas = $kelasMapel->kelas;
        $mapel = $kelasMapel->mapel;
        // $editor = optional($kelasMapel->editorAccess->first())->user; // (fitur editorAccess, sementara dikomentari)

        // 🔹 Ambil semua materi dalam kelas-mapel yang sama (untuk daftar di sidebar)
        $materiAll = Materi::where('kelas_mapel_id', $kelasMapel->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // 🔹 Kirim data ke view detail materi
        return view('menu.pengajar.materi.view', [
            'title' => $materi->name,     // judul halaman = nama materi
            'materi' => $materi,          // data materi yang sedang ditampilkan
            'materiAll' => $materiAll,    // daftar semua materi dalam kelas-mapel ini
            'kelasMapel' => $kelasMapel,  // data relasi kelas-mapel
            'kelas' => $kelas,            // data kelas terkait
            'mapel' => $mapel,            // data mapel terkait
            // 'editor' => $editor,        // (fitur opsional)
        ]);
    }

    public function destroy(Materi $materi)
    {
        // 🔹 Ambil relasi kelas-mapel dari materi sebelum dihapus
        $kelasMapel = $materi->kelasMapel;

        // 🔹 Hapus record materi dari database
        $materi->delete();

        // 🔹 Redirect kembali ke halaman kelas-mapel dengan tab "materi"
        return redirect()->route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel_id, // ID mapel → agar kembali ke mapel yang sama
            'kelas' => $kelasMapel->kelas_id, // ID kelas → agar kembali ke kelas yang sama
            'tab'   => 'materi'               // tab aktif tetap "materi"
        ])->with('success', 'Materi berhasil dihapus!');
    }
}
