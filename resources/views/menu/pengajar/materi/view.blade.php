@extends('layout.template.mainTemplate')

@section('title', 'Detail Materi')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins">
  <div class="max-w-[1200px] w-full mx-auto px-4 sm:px-6 lg:px-10 mt-8 mb-16">

    {{-- 🔙 Tombol Kembali --}}
    <div class="mb-5">
      <a href="{{ route('viewKelasMapel', [
          'mapel' => $materi->kelasMapel->mapel->id,
          'kelas' => $materi->kelasMapel->kelas->id
      ]) }}"
         class="flex items-center gap-2 text-sm text-[#2B82FE] hover:underline font-medium">
        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Daftar Materi
      </a>
    </div>

    {{--  Header Biru --}}
    <div class="bg-[#2B82FE] text-white rounded-2xl p-6 sm:p-8 mb-8 shadow-sm">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <div class="flex items-center gap-2 mb-3">
            <span class="text-xs font-semibold bg-white/20 text-white px-3 py-1 rounded-full uppercase tracking-wide">PDF</span>
            <span class="text-xs opacity-90">Diunggah {{ $materi->created_at->translatedFormat('d F Y') }}</span>
          </div>

          <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">{{ $materi->name }}</h1>
          <p class="text-sm opacity-90 mt-1">Dasar-dasar HTML, CSS, dan JavaScript untuk membangun website modern</p>
          @if($materi->pengajar)
            <p class="text-sm mt-3">Oleh <span class="font-semibold">{{ $materi->pengajar->name ?? '' }}</span></p>
          @endif
        </div>

      
      </div>
    </div>

    {{-- Statistik Dummy --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8">
      <div class="bg-white border border-gray-100 rounded-xl p-4 text-center shadow-sm">
        <p class="text-[#7F8190] text-xs font-medium mb-1">Total Views</p>
        <p class="text-lg font-bold text-[#0A090B]">124</p>
      </div>
      <div class="bg-white border border-gray-100 rounded-xl p-4 text-center shadow-sm">
        <p class="text-[#7F8190] text-xs font-medium mb-1">File Terunduh</p>
        <p class="text-lg font-bold text-[#0A090B]">3</p>
      </div>
      <div class="bg-white border border-gray-100 rounded-xl p-4 text-center shadow-sm">
        <p class="text-[#7F8190] text-xs font-medium mb-1">Total Size</p>
        <p class="text-lg font-bold text-[#0A090B]">2.4 MB</p>
      </div>
      <div class="bg-white border border-gray-100 rounded-xl p-4 text-center shadow-sm">
        <p class="text-[#7F8190] text-xs font-medium mb-1">Rata-rata Size</p>
        <p class="text-lg font-bold text-[#0A090B]">2.4 MB</p>
      </div>
    </div>

    {{--  Konten & Sidebar --}}
    <div class="grid lg:grid-cols-3 gap-8">
      {{-- Kolom Kiri --}}
      <div class="lg:col-span-2 flex flex-col gap-6">

        {{-- Deskripsi Materi --}}
        <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-6">
          <h2 class="text-lg font-semibold mb-3 text-[#0A090B]">Deskripsi Materi</h2>
          <p class="text-sm text-[#7F8190] leading-relaxed whitespace-pre-line">
            {{ $materi->content }}
          </p>
        </div>

        {{-- File Materi --}}
        <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-6">
          <h2 class="text-lg font-semibold mb-4 text-[#0A090B]">File Materi</h2>

          @if ($materi->files->count())
            <div class="flex flex-col gap-3">
              @foreach ($materi->files as $file)
                @php
                  $ext = pathinfo($file->file, PATHINFO_EXTENSION);
                  $iconClass = match($ext) {
                    'pdf' => 'fa-file-pdf text-red-500',
                    'ppt', 'pptx' => 'fa-file-powerpoint text-orange-500',
                    'doc', 'docx' => 'fa-file-word text-blue-500',
                    'xls', 'xlsx' => 'fa-file-excel text-green-500',
                    'zip', 'rar' => 'fa-file-zipper text-yellow-500',
                    default => 'fa-file text-gray-500'
                  };
                @endphp

                <div class="flex items-center justify-between bg-[#F9FAFB] border border-gray-100 rounded-xl px-5 py-3 hover:bg-gray-50 transition">
                  <div class="flex items-center gap-3 overflow-hidden">
                    <i class="fa-solid {{ $iconClass }} text-xl flex-shrink-0"></i>



  <a href="{{ asset('storage/materi/' . $materi->id . '/' . basename($file->file)) }}"
   target="_blank"
   class="font-medium text-sm text-[#0A090B] hover:text-[#2B82FE] truncate">
   {{ basename($file->file) }}
</a> 

{{-- <a href="{{ route('getFile', ['path' => 'materi/' . $materi->id . '/' . basename($file->file)]) }}"
   target="_blank"
   class="font-medium text-sm text-[#0A090B] hover:text-[#2B82FE] truncate">
   {{ basename($file->file) }}
</a> --}}



                  </div>
                  <button class="text-[#7F8190] hover:text-[#2B82FE]">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                  </button>
                </div>
              @endforeach
            </div>
          @else
            <p class="text-gray-500 text-sm">Belum ada file materi diunggah.</p>
          @endif
        </div>

        {{-- Video Pembelajaran --}}
        @if ($materi->youtube_link)
          <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-4 text-[#0A090B]">Video Pembelajaran</h2>
            @php
              $links = preg_split("/(\r\n|\r|\n)/", trim($materi->youtube_link));
              $links = array_filter($links);
              function toEmbed($url) {
                  $url = trim($url);
                  $url = preg_replace('/\?.*/', '', $url);
                  $url = rtrim($url, '/');
                  if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $m)) return 'https://www.youtube.com/embed/' . $m[1];
                  if (preg_match('/v=([a-zA-Z0-9_-]+)/', $url, $m)) return 'https://www.youtube.com/embed/' . $m[1];
                  if (preg_match('/shorts\/([a-zA-Z0-9_-]+)/', $url, $m)) return 'https://www.youtube.com/embed/' . $m[1];
                  if (str_contains($url, 'embed/')) return $url;
                  return $url;
              }
            @endphp
            @foreach ($links as $link)
              @php $embedLink = toEmbed($link); @endphp
              <div class="aspect-video rounded-xl overflow-hidden mb-5">
                <iframe class="w-full h-full rounded-xl"
                        src="{{ $embedLink }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
              </div>
            @endforeach
          </div>
        @endif

      </div>

      {{-- Sidebar Kanan --}}
      <div class="flex flex-col gap-6">
        <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-6">
          <h3 class="font-semibold mb-3 text-[#0A090B]">Informasi</h3>
          <div class="text-sm text-[#7F8190] space-y-2">
            <p><span class="font-medium text-[#0A090B]">Pengajar:</span> {{ $materi->pengajar->name ?? 'Dr. Budi Santoso' }}</p>
            <p><span class="font-medium text-[#0A090B]">Diunggah:</span> {{ $materi->created_at->format('d/m/Y') }}</p>
            <p><span class="font-medium text-[#0A090B]">Tipe:</span> PDF</p>
          </div>
        </div>

       
      </div>
    </div>
  </div>
</div>
@endsection
