<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RepositoryController extends Controller
{
    /**
     * 🔹 Menampilkan daftar repository milik guru login
     */
    public function index()
    {
        $repositories = Repository::where('user_id', auth()->id())->latest()->get();

        return view('menu.repository.index', compact('repositories'));
    }

    /**
     * 🔹 Menampilkan 1 repository (detail)
     */
    public function show(Repository $repository)
    {
        // Pastikan hanya pemilik atau admin bisa lihat detail
        if (auth()->id() !== $repository->user_id && !auth()->user()->hasRole('Pengajar')) {
            abort(403, 'Kamu tidak punya izin untuk melihat repository ini.');
        }

        return view('menu.repository.show', compact('repository'));
    }

    /**
     * 🔹 Menampilkan form tambah repository baru
     */
    public function create()
    {
        return view('menu.repository.create');
    }

    /**
     * 🔹 Simpan data repository baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kelas' => 'nullable|string',
            'jurusan' => 'nullable|string',
            'youtube_link' => 'nullable|string',
        ]);

        $repo = Repository::create([
            'user_id' => auth()->id(),
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'kelas' => $validated['kelas'] ?? null,
            'jurusan' => $validated['jurusan'] ?? null,
            'youtube_link' => $validated['youtube_link'] ?? null,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Repository berhasil dibuat!',
                'repository_id' => $repo->id,
            ]);
        }

        return redirect()->route('repository.index')->with('success', 'Repository berhasil dibuat!');
    }

    /**
     * 🔹 Menampilkan form edit repository
     */
    public function edit(Repository $repository)
    {
        if (auth()->id() !== $repository->user_id && !auth()->user()->hasRole('Admin')) {
            abort(403, 'Kamu tidak punya izin untuk mengedit repository ini.');
        }

        return view('menu.repository.edit', compact('repository'));
    }

    /**
     * 🔹 Update repository setelah diedit
     */
    public function update(Request $request, Repository $repository)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kelas' => 'nullable|string',
            'jurusan' => 'nullable|string',
            'youtube_link' => 'nullable|string',
        ]);

        $repository->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Repository berhasil diperbarui!',
                'repository_id' => $repository->id,
            ]);
        }

        return redirect()->route('repository.index')->with('success', 'Repository berhasil diperbarui!');
    }

    /**
     * 🔹 Hapus repository dan semua file di dalamnya
     */
    public function destroy(Repository $repository)
    {
        if (auth()->id() !== $repository->user_id && !auth()->user()->hasRole('Admin')) {
            abort(403, 'Kamu tidak punya izin untuk menghapus repository ini.');
        }

        foreach ($repository->files as $file) {
            $path = "repository/{$repository->id}/{$file->file}";
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        Storage::disk('public')->deleteDirectory("repository/{$repository->id}");
        $repository->delete();

        return back()->with('success', 'Repository berhasil dihapus!');
    }

    /**
     * 🔹 Halaman publik: menampilkan semua repository
     */
    public function public()
    {
        $repositories = Repository::latest()->paginate(12);
        return view('menu.repository.public', compact('repositories'));
    }
}
