@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full p-8 bg-[#F9FAFB] min-h-screen font-poppins">

  <!-- Header -->
  <div class="flex justify-between items-center mb-8">
    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B]">Pengumuman</h1>
      <p class="text-sm text-[#7F8190]">Kelola dan lihat semua pengumuman</p>
    </div>

    @if (Auth::user()->hasRole('Wakur'))
      <a href="{{ route('pengumuman.create') }}"
         class="flex items-center gap-2 bg-[#2B82FE] text-white px-5 py-2.5 rounded-full font-semibold shadow hover:bg-[#1E68D9] transition">
        <i class="fa-solid fa-plus"></i> Buat Pengumuman
      </a>
    @endif
  </div>

  <!-- Daftar Pengumuman -->
  @forelse ($pengumuman as $item)
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm mb-6 relative">
      <!-- Judul -->
      <h2 class="text-lg font-bold text-[#0A090B] mb-1">{{ $item->judul }}</h2>

      <!-- Isi singkat -->
      <p class="text-sm text-[#555C68] mb-4 leading-relaxed">
        {{ $item->isi }}
      </p>

      <!-- Lampiran -->
      @if ($item->lampiran)
        <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank"
           class="inline-flex items-center gap-2 bg-[#EEF4FF] text-[#2B82FE] px-3 py-1.5 rounded-md text-sm font-medium mb-3 hover:bg-[#E3ECFF] transition">
          <i class="fa-solid fa-file"></i> {{ basename($item->lampiran) }}
        </a>
      @endif

      <!-- Footer: info user dan tanggal -->
      <div class="flex items-center gap-3 text-xs text-[#7F8190] mt-2">
        <i class="fa-solid fa-user"></i>
        <span>{{ $item->user->name ?? 'Admin Sekolah' }}</span>
        <i class="fa-solid fa-calendar-days ml-3"></i>
        <span>
          {{ \Carbon\Carbon::parse($item->published_at)->translatedFormat('d F Y \p\u\u\k\u\l H:i') }}
        </span>
      </div>

      <!-- Tombol edit & hapus -->
      @if (Auth::user()->hasRole('Wakur'))
        <div class="absolute top-6 right-6 flex gap-2">
          <a href="{{ route('pengumuman.edit', $item->id) }}" 
             class="p-2 rounded-full hover:bg-gray-100 transition" title="Edit">
            <i class="fa-solid fa-pen text-gray-500"></i>
          </a>
          <form action="{{ route('pengumuman.destroy', $item->id) }}" 
                method="POST" 
                onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 rounded-full hover:bg-gray-100 transition" title="Hapus">
              <i class="fa-solid fa-trash text-gray-500"></i>
            </button>
          </form>
        </div>
      @endif
    </div>
  @empty
    <div class="text-center text-[#7F8190] italic mt-10">
      Belum ada pengumuman yang dipublikasikan.
    </div>
  @endforelse
</div>
@endsection
