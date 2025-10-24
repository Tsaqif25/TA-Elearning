@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full p-8 bg-[#F9FAFB] min-h-screen font-poppins">

  <!-- Header -->
  <div class="flex justify-between items-center mb-8">
    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B]">Daftar Pengumuman</h1>
      <p class="text-sm text-[#7F8190]">Semua pengumuman resmi dari Wakil Kurikulum</p>
    </div>

    @if (Auth::user()->hasRole('Wakur'))
      <a href="{{ route('pengumuman.create') }}"
         class="flex items-center gap-2 bg-[#6C63FF] text-white px-6 py-2 rounded-full font-semibold shadow hover:bg-[#574FFB] transition">
        <i class="fa-solid fa-plus"></i> Tambah Pengumuman
      </a>
    @endif
  </div>

  <!-- Daftar Pengumuman -->
  @if ($pengumuman->isEmpty())
    <div class="text-center text-[#7F8190] italic mt-10">
      Belum ada pengumuman yang dipublikasikan.
    </div>
  @else
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($pengumuman as $item)
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between">
          <div>
            <h2 class="font-bold text-lg text-[#0A090B] mb-2">{{ $item->judul }}</h2>
            <p class="text-sm text-[#7F8190] mb-4 line-clamp-3">{!! Str::limit(strip_tags($item->isi), 100) !!}</p>
          </div>
          <div class="flex justify-between items-center text-xs text-[#7F8190] mt-3">
            <p><i class="fa-solid fa-calendar-days text-[#6C63FF] mr-1"></i> 
              {{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->translatedFormat('d F Y') : '-' }}
            </p>
            <a href="{{ route('pengumuman.show', $item->id) }}" 
               class="text-[#6C63FF] font-semibold hover:underline">Lihat</a>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
