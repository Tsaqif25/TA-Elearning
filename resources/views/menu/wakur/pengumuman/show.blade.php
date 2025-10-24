@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full p-8 bg-[#F9FAFB] min-h-screen font-poppins">

  <!-- Header -->
  <div class="flex items-center gap-4 mb-8">
    <a href="{{ route('pengumuman.index') }}" 
       class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 hover:bg-gray-100 transition">
      <i class="fa-solid fa-arrow-left text-gray-700"></i>
    </a>
    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B]">{{ $pengumuman->judul }}</h1>
      <p class="text-sm text-[#7F8190]">
        Dipublikasikan pada 
        {{ $pengumuman->published_at ? \Carbon\Carbon::parse($pengumuman->published_at)->translatedFormat('d F Y, H:i') : '-' }}
      </p>
    </div>
  </div>

  <!-- Card -->
  <div class="bg-white border border-[#E5E7EB] rounded-2xl shadow-sm p-8 max-w-4xl mx-auto space-y-6">
    <!-- Isi -->
    <div class="prose max-w-none text-[#0A090B] leading-relaxed">
      {!! nl2br(e($pengumuman->isi)) !!}
    </div>

    <!-- Lampiran -->
    @if ($pengumuman->lampiran)
      <div class="border-t pt-5 mt-5">
        <h3 class="font-semibold text-[#0A090B] mb-2">Lampiran</h3>
        <a href="{{ asset('storage/' . $pengumuman->lampiran) }}" 
           target="_blank"
           class="inline-flex items-center gap-2 bg-[#F3F4F6] hover:bg-[#E5E7EB] text-[#0A090B] px-4 py-2 rounded-full font-medium transition">
          <i class="fa-solid fa-paperclip text-[#6C63FF]"></i> Lihat Lampiran
        </a>
      </div>
    @endif

    <!-- Tombol Edit/Hapus untuk Wakur -->
    @if (Auth::user()->hasRole('Wakur'))
      <div class="flex justify-end gap-3 pt-4 border-t">
        <a href="{{ route('pengumuman.edit', $pengumuman->id) }}"
           class="flex items-center gap-2 bg-amber-100 text-amber-700 px-4 py-2 rounded-full font-semibold hover:bg-amber-200 transition">
          <i class="fa-solid fa-pen"></i> Edit
        </a>

        <form action="{{ route('pengumuman.destroy', $pengumuman->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="flex items-center gap-2 bg-rose-100 text-rose-700 px-4 py-2 rounded-full font-semibold hover:bg-rose-200 transition">
            <i class="fa-solid fa-trash"></i> Hapus
          </button>
        </form>
      </div>
    @endif
  </div>
</div>
@endsection
