@extends('layout.template.publicTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins">
  <div class="max-w-[1200px] w-full mx-auto px-4 sm:px-6 lg:px-10 mt-8 mb-16">

    {{--  Tombol Kembali --}}
@auth
  @if (Auth::user()->hasRole('Wakur|Pengajar'))
    <div class="mb-5">
      <a href="{{ route('repository.index') }}"
         class="flex items-center gap-2 text-sm text-[#2B82FE] hover:underline font-medium">
        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Daftar Repository
      </a>
    </div>
  @endif
@endauth

@guest
  <div class="mb-5">
    <a href="{{ route('repository.public') }}"
       class="flex items-center gap-2 text-sm text-[#2B82FE] hover:underline font-medium">
      <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Daftar Repository
    </a>
  </div>
@endguest




    {{--  Header Biru --}}
    <div class="bg-[#2B82FE] text-white rounded-2xl p-6 sm:p-8 mb-8 shadow-sm">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <div class="flex items-center gap-2 mb-3">
            <span class="text-xs font-semibold bg-white/20 text-white px-3 py-1 rounded-full uppercase tracking-wide">
              Repository Publik
            </span>
            <span class="text-xs opacity-90">
              Diunggah {{ $repository->created_at->translatedFormat('d F Y') }}
            </span>
          </div>

          <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">{{ $repository->judul }}</h1>
          <p class="text-sm opacity-90 mt-1">{{ $repository->deskripsi ?? 'Belum ada deskripsi untuk repository ini.' }}</p>

          @if($repository->pengajar)
            <p class="text-sm mt-3">Oleh <span class="font-semibold">{{ $repository->pengajar->name ?? '' }}</span></p>
          @endif
        </div>
      </div>
    </div>

    {{-- 🔹 Statistik Info --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8">
      <div class="bg-white border border-gray-100 rounded-xl p-4 text-center shadow-sm">
        <p class="text-[#7F8190] text-xs font-medium mb-1">Total File</p>
        <p class="text-lg font-bold text-[#0A090B]">{{ $repository->files->count() }}</p>
      </div>
      <div class="bg-white border border-gray-100 rounded-xl p-4 text-center shadow-sm">
        <p class="text-[#7F8190] text-xs font-medium mb-1">Kelas</p>
        <p class="text-lg font-bold text-[#0A090B]">{{ $repository->kelas ?? '-' }}</p>
      </div>
      <div class="bg-white border border-gray-100 rounded-xl p-4 text-center shadow-sm">
        <p class="text-[#7F8190] text-xs font-medium mb-1">Jurusan</p>
        <p class="text-lg font-bold text-[#0A090B]">{{ $repository->jurusan ?? '-' }}</p>
      </div>
      <div class="bg-white border border-gray-100 rounded-xl p-4 text-center shadow-sm">
        <p class="text-[#7F8190] text-xs font-medium mb-1">Tanggal Upload</p>
        <p class="text-lg font-bold text-[#0A090B]">{{ $repository->created_at->format('d/m/Y') }}</p>
      </div>
    </div>

    {{-- Konten & Sidebar --}}
    <div class="grid lg:grid-cols-3 gap-8">

      {{-- Kolom Kiri --}}
      <div class="lg:col-span-2 flex flex-col gap-6">

        {{-- Deskripsi Repository --}}
        <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-6">
          <h2 class="text-lg font-semibold mb-3 text-[#0A090B]">Deskripsi Repository</h2>
          <p class="text-sm text-[#7F8190] leading-relaxed whitespace-pre-line">
            {{ $repository->deskripsi ?? 'Belum ada deskripsi yang ditulis untuk repository ini.' }}
          </p>
        </div>

        {{-- File Repository --}}
        <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-6">
          <h2 class="text-lg font-semibold mb-4 text-[#0A090B]">File Repository</h2>

          @if ($repository->files->count())
            <div class="flex flex-col gap-3">
              @foreach ($repository->files as $file)
                @php
                  $ext = pathinfo($file->file, PATHINFO_EXTENSION);
                  $iconClass = match($ext) {
                    'pdf' => 'fa-file-pdf text-red-500',
                    'ppt', 'pptx' => 'fa-file-powerpoint text-orange-500',
                    'doc', 'docx' => 'fa-file-word text-blue-500',
                    'xls', 'xlsx' => 'fa-file-excel text-green-500',
                    'zip', 'rar' => 'fa-file-zipper text-yellow-500',
                    'mp4' => 'fa-file-video text-purple-500',
                    default => 'fa-file text-gray-500'
                  };
                @endphp

                <div class="flex items-center justify-between bg-[#F9FAFB] border border-gray-100 rounded-xl px-5 py-3 hover:bg-gray-50 transition">
                  <div class="flex items-center gap-3 overflow-hidden">
                    <i class="fa-solid {{ $iconClass }} text-xl flex-shrink-0"></i>
                    <a href="{{ asset('storage/' . $file->file) }}" target="_blank"
                       class="font-medium text-sm text-[#0A090B] hover:text-[#2B82FE] truncate">
                      {{ basename($file->file) }}
                    </a>
                  </div>
                  <a href="{{ asset('storage/' . $file->file) }}" download
                     class="text-[#7F8190] hover:text-[#2B82FE]">
                    <i class="fa-solid fa-download"></i>
                  </a>
                </div>
              @endforeach
            </div>
          @else
            <p class="text-gray-500 text-sm">Belum ada file repository diunggah.</p>
          @endif
        </div>

        {{-- Video Pembelajaran --}}
        @if ($repository->youtube_link)
          <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-4 text-[#0A090B]">Video Pembelajaran</h2>
            @php
              $links = preg_split("/(\r\n|\r|\n)/", trim($repository->youtube_link));
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
          <h3 class="font-semibold mb-3 text-[#0A090B]">Informasi Repository</h3>
          <div class="text-sm text-[#7F8190] space-y-2">
            <p><span class="font-medium text-[#0A090B]">Uploader:</span> {{ $repository->pengajar->name ?? 'Tidak diketahui' }}</p>
            <p><span class="font-medium text-[#0A090B]">Kelas:</span> {{ $repository->kelas ?? '-' }}</p>
            <p><span class="font-medium text-[#0A090B]">Jurusan:</span> {{ $repository->jurusan ?? '-' }}</p>
            <p><span class="font-medium text-[#0A090B]">Tanggal Upload:</span> {{ $repository->created_at->format('d/m/Y') }}</p>
            <p><span class="font-medium text-[#0A090B]">Total File:</span> {{ $repository->files->count() }}</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
