@extends('layout.template.mainTemplate')

@section('title', 'Detail Materi')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
  <div class="max-w-[1200px] w-full mx-auto px-4 sm:px-6 lg:px-10 mt-10 mb-16">

    {{-- 🔙 Tombol Kembali --}}
    <a href="{{ route('viewKelasMapel', [
        'mapel' => $materi->kelasMapel->mapel->id,
        'kelas' => $materi->kelasMapel->kelas->id
    ]) }}"
       class="flex items-center gap-2 text-sm text-[#2B82FE] hover:underline font-medium mb-6">
      <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Daftar Materi
    </a>

    {{-- 🎨 Hero Section --}}
    <section class="relative bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-3xl p-8 shadow-lg overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-tr from-blue-600/90 to-green-500/90 rounded-3xl"></div>
      <div class="relative z-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold leading-snug break-words">
          {{ $materi->name }}
        </h1>

        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mt-4 text-sm text-white/90">
          <span class="flex items-center gap-2"><i class="fa-regular fa-calendar"></i> {{ $materi->created_at->translatedFormat('d F Y') }}</span>
          <span class="flex items-center gap-2"><i class="fa-solid fa-eye"></i> 189 ditonton</span>
          <span class="flex items-center gap-2"><i class="fa-solid fa-user-graduate"></i> 45 siswa</span>
        </div>
      </div>
    </section>

    {{-- 📄 Deskripsi Materi --}}
    @if ($materi->konten)
    <section class="bg-white border border-gray-100 rounded-2xl shadow-sm mt-8 p-6">
      <h2 class="text-lg font-semibold text-[#0A090B] mb-3 flex items-center gap-2">
        <i class="fa-regular fa-file-lines text-[#2B82FE]"></i> Deskripsi Materi
      </h2>
      <p class="text-gray-700 leading-relaxed text-sm sm:text-base">
        {{ $materi->konten }}
      </p>
    </section>
    @endif

    {{-- 📦 Konten Utama --}}
    <div class="grid lg:grid-cols-3 gap-10 mt-8">

      {{-- Kolom Kiri --}}
      <div class="lg:col-span-2 flex flex-col gap-8">

        {{-- 📁 File Materi --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
          <h2 class="text-lg font-semibold text-[#0A090B] mb-4 flex items-center gap-2">
            <i class="fa-solid fa-folder-open text-[#2B82FE]"></i> File Materi
          </h2>

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

                <div class="flex items-center justify-between bg-[#F9FAFB] hover:bg-[#EEF4FF] border border-gray-100 rounded-xl px-5 py-4 transition duration-300">
                  <div class="flex items-center gap-3 min-w-0">
                    <i class="fa-solid {{ $iconClass }} text-2xl"></i>
                    <a href="{{ asset('storage/materi/' . $materi->id . '/' . $file->file) }}"
                       target="_blank"
                       class="truncate font-medium text-[#0A090B] hover:text-[#2B82FE]">
                      {{ basename($file->file) }}
                    </a>
                  </div>

                  <a href="{{ asset('storage/materi/' . $materi->id . '/' . $file->file) }}" download
                     class="flex items-center justify-center w-9 h-9 border border-[#2B82FE]/30 rounded-full text-[#2B82FE] hover:bg-[#2B82FE] hover:text-white transition">
                    <i class="fa-solid fa-download text-sm"></i>
                  </a>
                </div>
              @endforeach
            </div>
          @else
            <p class="text-gray-500 text-sm">Belum ada file materi diunggah.</p>
          @endif
        </div>

        {{-- 🎥 Video Pembelajaran --}}
        @if ($materi->youtube_link)
        <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-6">
          <h2 class="text-lg font-semibold mb-4 text-[#0A090B] flex items-center gap-2">
            <i class="fa-brands fa-youtube text-red-500"></i> Video Pembelajaran
          </h2>

          @php
              $links = preg_split("/(\r\n|\r|\n)/", trim($materi->youtube_link));
              $links = array_filter($links);
              function toEmbed($url) {
                  $url = trim($url);
                  if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $m)) return "https://www.youtube.com/embed/{$m[1]}";
                  if (preg_match('/v=([a-zA-Z0-9_-]+)/', $url, $m)) return "https://www.youtube.com/embed/{$m[1]}";
                  if (preg_match('/shorts\/([a-zA-Z0-9_-]+)/', $url, $m)) return "https://www.youtube.com/embed/{$m[1]}";
                  return $url;
              }
          @endphp

          @foreach ($links as $link)
            <div class="aspect-video rounded-xl overflow-hidden mb-5">
              <iframe class="w-full h-full rounded-xl"
                      src="{{ toEmbed($link) }}"
                      title="YouTube video player"
                      frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowfullscreen></iframe>
            </div>
          @endforeach
        </div>
        @endif
      </div>

      {{-- 📊 Sidebar --}}
      <aside class="space-y-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
          <h3 class="text-sm font-bold text-[#0A090B] mb-3">📊 Statistik</h3>
          <div class="text-sm text-[#7F8190] space-y-2">
            <div class="flex justify-between">
              <span>Progress Pembelajaran</span>
              <span class="font-semibold text-[#0A090B]">100%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
              <div class="bg-[#16a34a] h-2 rounded-full w-full"></div>
            </div>
            <p>Ditonton <span class="font-semibold text-[#0A090B]">189x</span></p>
            <p>Siswa Aktif <span class="font-semibold text-[#0A090B]">45</span></p>
          </div>
        </div>

        <div class="bg-[#EEF4FF] rounded-2xl border border-gray-100 shadow-sm p-6">
          <h3 class="text-sm font-bold text-[#0A090B] mb-3">📘 Status Pembelajaran</h3>
          <div class="flex items-center gap-2">
            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
            <span class="font-semibold text-green-700">Selesai</span>
          </div>
          <p class="text-xs text-[#7F8190] mt-2">Diupload 2 hari yang lalu</p>
        </div>
      </aside>

    </div>
  </div>
</div>
@endsection
