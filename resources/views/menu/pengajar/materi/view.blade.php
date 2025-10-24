@extends('layout.template.mainTemplate')

@section('title', 'Detail Materi')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins">

  
  <div class="max-w-[1200px] w-full mx-auto px-4 sm:px-6 lg:px-10 mt-6 mb-10">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-5 gap-3">
      <div>
        <h1 class="text-xl sm:text-2xl font-extrabold text-[#0A090B]">{{ $materi->name }}</h1>
        <p class="text-sm text-[#7F8190] mt-1">
          Diunggah {{ $materi->created_at->translatedFormat('d F Y') }}
          @if($materi->pengajar)
          oleh <span class="font-semibold text-[#2B82FE]">{{ $materi->pengajar->name ?? '' }}</span>
          @endif
        </p>
      </div>

      <div class="flex flex-wrap gap-2 sm:gap-3">
        <a href="{{ route('viewKelasMapel', [
            'mapel' => $materi->kelasMapel->mapel->id,
            'kelas' => $materi->kelasMapel->kelas->id
        ]) }}"
           class="flex items-center gap-1 bg-gray-100 text-gray-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-gray-200 transition">
          <i class="fa-solid fa-arrow-left text-[11px]"></i> Kembali
        </a>
      </div>
    </div>

    <!-- Deskripsi -->
    <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-5 sm:p-6 mb-6">
      <h2 class="text-base sm:text-lg font-semibold mb-2">Deskripsi Materi</h2>
      <p class="text-sm text-[#7F8190] leading-relaxed whitespace-pre-line">
        {{ $materi->content }}
      </p>
    </div>

    <!-- File Materi -->
 <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-5 sm:p-6 mb-6">
  <h2 class="text-base sm:text-lg font-semibold mb-3">File Materi</h2>

  @if ($materi->files->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      @foreach ($materi->files as $file)
        @php
          $ext = pathinfo($file->file, PATHINFO_EXTENSION);
          $iconClass = match($ext) {
            'pdf' => 'fa-file-pdf text-red-500',
            'ppt', 'pptx' => 'fa-file-powerpoint text-orange-500',
            'doc', 'docx' => 'fa-file-word text-blue-500',
            'xls', 'xlsx' => 'fa-file-excel text-green-500',
            default => 'fa-file text-gray-500'
          };
        @endphp

        {{-- Card File --}}
        <div class="flex items-center justify-between border border-gray-100 rounded-2xl px-4 py-3 hover:bg-gray-50 transition">
          <div class="flex items-center gap-3 overflow-hidden">
            <i class="fa-solid {{ $iconClass }} text-2xl flex-shrink-0"></i>
            <a href="{{ asset('storage/' . $file->file) }}" target="_blank"
               class="font-medium text-sm text-gray-700 hover:underline truncate">
              {{ basename($file->file) }}
            </a>
          </div>

          <a href="{{ route('getFile', ['namaFile' => $file->file]) }}"
             class="text-[#2B82FE] text-xs sm:text-sm font-semibold hover:underline whitespace-nowrap">
            Lihat
          </a>
        </div>
      @endforeach
    </div>
  @else
    <p class="text-gray-500 text-sm">Belum ada file materi diunggah.</p>
  @endif
</div>


    <!-- Video -->
@if ($materi->youtube_link)
  <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-5 sm:p-6">
    <h2 class="text-base sm:text-lg font-semibold mb-3">Video Pembelajaran</h2>

    @php
      //  Pisahkan per baris
      $links = preg_split("/(\r\n|\r|\n)/", trim($materi->youtube_link));
      $links = array_filter($links);

      //  Fungsi helper untuk ubah ke embed
      function toEmbed($url) {
          $url = trim($url);
          $url = preg_replace('/\?.*/', '', $url); // hapus query (?si= dsb)

          // Normalisasi (hapus spasi dan trailing slash)
          $url = rtrim($url, '/');

          //  youtu.be/xxxxxx
          if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $match)) {
              return 'https://www.youtube.com/embed/' . $match[1];
          }

          //  youtube.com/watch?v=xxxxxx
          if (preg_match('/v=([a-zA-Z0-9_-]+)/', $url, $match)) {
              return 'https://www.youtube.com/embed/' . $match[1];
          }

          //  youtube.com/shorts/xxxxxx
          if (preg_match('/shorts\/([a-zA-Z0-9_-]+)/', $url, $match)) {
              return 'https://www.youtube.com/embed/' . $match[1];
          }

          //  Sudah embed? biarkan
          if (str_contains($url, 'embed/')) {
              return $url;
          }

          //  Format tidak dikenali → kembalikan aslinya
          return $url;
      }
    @endphp

    {{--  Tampilkan semua video --}}
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
</div>
@endsection
