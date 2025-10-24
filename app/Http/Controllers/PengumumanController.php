<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest('published_at')->get();
        return view('menu.wakur.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('menu.wakur.pengumuman.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'lampiran' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('file/pengumuman', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['published_at'] = now();

        Pengumuman::create($validated);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dibuat dan langsung dipublikasikan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('menu.wakur.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'lampiran' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($pengumuman->lampiran && Storage::disk('public')->exists($pengumuman->lampiran)) {
                Storage::disk('public')->delete($pengumuman->lampiran);
            }
            $validated['lampiran'] = $request->file('lampiran')->store('file/pengumuman', 'public');
        }

        $pengumuman->update($validated);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }


    public function show (Pengumuman $pengumuman) {

         return view('menu.wakur.pengumuman.show', compact('pengumuman'));
    }
    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->lampiran && Storage::disk('public')->exists($pengumuman->lampiran)) {
            Storage::disk('public')->delete($pengumuman->lampiran);
        }

        $pengumuman->delete();

    
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
