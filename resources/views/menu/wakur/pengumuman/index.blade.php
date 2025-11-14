@extends('layout.template.mainTemplate')

@section('container')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 fade-in bg-[#F9FAFB]  font-poppins">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-3">
    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B]">Pengumuman</h1>
      <p class="text-sm text-[#7F8190] leading-snug">
        Berisi pengumuman penting dari Kepala Sekolah, Wakil Kepala Sekolah, dan Admin
      </p>
    </div>

    @if (Auth::user()->hasRole('Wakur'))
      <a href="{{ route('pengumuman.create') }}"
         class="flex items-center justify-center gap-2 bg-[#2B82FE] text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl font-semibold text-sm sm:text-base shadow hover:bg-[#1E68D9] transition">
        <i class="fa-solid fa-plus"></i> Buat Pengumuman
      </a>
    @endif
  </div>

  <!-- Daftar Pengumuman -->
  @forelse ($pengumuman as $item)
    <div class="relative w-full bg-white rounded-2xl shadow-sm mb-6 border-l-[6px]
                @if($item->kategori == 'Akademik') border-[#2B82FE]
                @elseif($item->kategori == 'Umum') border-[#10B981]
                @else border-[#6366F1] @endif
                hover:shadow-md transition-all duration-200">

      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 sm:p-6">

        <!-- Avatar -->
        <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-sm
          @if($item->kategori == 'Akademik') bg-[#2B82FE]
          @elseif($item->kategori == 'Umum') bg-[#10B981]
          @else bg-[#6366F1] @endif">
          {{ strtoupper(substr($item->pengirim ?? 'K', 0, 1)) }}
        </div>

        <!-- Konten -->
        <div class="flex-1 w-full">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h2 class="text-base sm:text-lg font-semibold text-[#0A0A0A]">
              {{ $item->judul }}
            </h2>

            @if($item->kategori)
              <span class="text-xs px-3 py-1 rounded-full font-semibold self-start sm:self-center
                @if($item->kategori == 'Akademik') bg-blue-50 text-blue-600
                @elseif($item->kategori == 'Umum') bg-green-50 text-green-600
                @else bg-indigo-50 text-indigo-600 @endif">
                {{ $item->kategori }}
              </span>
            @endif
          </div>

          <p class="text-xs text-[#7F8190] mt-1 mb-2">
            Oleh {{ $item->pengirim ?? 'Wakil Kurikulum' }} • {{ \Carbon\Carbon::parse($item->published_at)->translatedFormat('d/m/Y') }}
          </p>

          <p class="text-sm text-[#4B5563] leading-relaxed mb-3 break-words">
            {{ $item->isi }}
          </p>

          @if ($item->lampiran)
            <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank"
               class="inline-flex items-center gap-2 text-[#2B82FE] text-sm font-medium hover:underline break-all">
              <i class="fa-solid fa-paperclip"></i> {{ basename($item->lampiran) }}
            </a>
          @endif
        </div>
      </div>

      <!-- Tombol edit & hapus -->
      @if (Auth::user()->hasRole('Wakur'))
        <div class="absolute top-3 right-3 flex gap-2">
          <a href="{{ route('pengumuman.edit', $item->id) }}" 
             class="p-2 rounded-full hover:bg-gray-100 transition" title="Edit">
            <i class="fa-solid fa-pen text-gray-500 text-sm"></i>
          </a>
          <form action="{{ route('pengumuman.destroy', $item->id) }}" 
                method="POST" 
                onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
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
    <div class="text-center text-[#7F8190] italic mt-10">
      Belum ada pengumuman yang dipublikasikan.
    </div>
  @endforelse
</div>
@endsection
