@extends('layout.template.mainTemplate')

@section('container')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 font-poppins">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-3">
    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B]">Pengumuman</h1>
      <p class="text-sm text-[#7F8190] leading-snug">
        Informasi terbaru untuk seluruh warga sekolah.
      </p>
    </div>

    @if (Auth::user()->hasRole('Wakur'))
      <a href="{{ route('pengumuman.create') }}"
         class="flex items-center justify-center gap-2 bg-[#2B82FE] text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow hover:bg-[#1E68D9] transition">
        <i class="fa-solid fa-plus"></i> Buat Pengumuman
      </a>
    @endif
  </div>

  <!-- Daftar Pengumuman -->
  @forelse ($pengumuman as $item)
    <div class="relative w-full bg-white rounded-2xl p-6 border border-blue-200 shadow-sm mb-6 overflow-hidden">

      <!-- DEKORASI -->
      <div class="absolute top-0 right-0 w-44 h-44 bg-blue-50 opacity-40 rounded-full translate-x-12 -translate-y-12"></div>

      <!-- AVATAR + JUDUL -->
      <div class="flex items-start gap-4">

        <!-- Avatar -->
        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center shadow-sm">
          <span class="text-lg font-bold text-gray-700">
            {{ strtoupper(substr($item->user->name ?? 'A', 0, 1)) }}
          </span>
        </div>

        <div class="flex-1">

          <!-- Judul -->
          <h2 class="text-lg sm:text-xl font-semibold text-[#0A0A0A] leading-tight">
            {{ $item->judul }}
          </h2>

          <!-- Info pengirim + tanggal -->
          <p class="text-xs text-[#7F8190] mt-1 mb-3 flex items-center gap-2">
            <i class="fa-regular fa-user text-gray-400"></i>
           Oleh {{ $item->user->name ?? 'Admin' }}


            <i class="fa-regular fa-calendar text-gray-400 ml-4"></i>
            {{ \Carbon\Carbon::parse($item->published_at)->translatedFormat('d/m/Y') }}
          </p>

        </div>
      </div>

      <!-- Isi -->
      <div class="text-sm text-[#4B5563] leading-relaxed mb-4 mt-2 prose max-w-none">
        {!! $item->isi !!}
      </div>

      <!-- Lampiran -->
      @if ($item->lampiran)
        <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank"
           class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-xl font-medium text-sm hover:bg-blue-100 transition">
          <i class="fa-solid fa-paperclip"></i> {{ basename($item->lampiran) }}
        </a>
      @endif

      <!-- Tombol Edit & Delete -->
      @if (Auth::user()->hasRole('Wakur'))
        <div class="absolute top-3 right-3 flex gap-2">
          <a href="{{ route('pengumuman.edit', $item->id) }}" 
             class="p-2 rounded-full hover:bg-gray-100 transition" title="Edit">
            <i class="fa-solid fa-pen text-gray-500 text-sm"></i>
          </a>
          <form action="{{ route('pengumuman.destroy', $item->id) }}" 
                method="POST" 
                onsubmit="return confirm('Hapus pengumuman ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 rounded-full hover:bg-gray-100 transition" title="Hapus">
              <i class="fa-solid fa-trash text-gray-500 text-sm"></i>
            </button>
          </form>
        </div>
      @endif

    </div>

  @empty
    <div class="text-center text-[#7F8190] italic mt-12">
      Belum ada pengumuman yang dipublikasikan.
    </div>
  @endforelse

</div>

<style>
  .prose ul {
    list-style-type: disc;
    margin-left: 1.5rem;
  }
  .prose ol {
    list-style-type: decimal;
    margin-left: 1.5rem;
  }
  .prose li {
    margin-bottom: 4px;
  }
</style>
@endsection
