@extends('layout.template.mainTemplate')

@section('container')
    <div class="flex flex-col lg:flex-row gap-6">

        {{-- Kiri: Konten Utama --}}
        <div class="flex-1 space-y-6">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route('viewKelasMapel', [
        'mapel' => $materi->kelasMapel->mapel->id,
        'kelas' => $materi->kelasMapel->kelas->id
    ]) }}" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
                        <i class="fa-solid fa-arrow-left text-gray-700"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $materi->name }}</h1>
                        <p class="text-sm text-gray-500">Diunggah {{ $materi->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>
            {{-- Deskripsi Materi --}}
            <div class="bg-white border-2 border-black rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-semibold mb-4">Deskripsi</h2>
                <div class="whitespace-pre-line text-gray-700 leading-relaxed">
                    {{($materi->content)}}
                </div>
            </div>
            {{-- File Materi --}}
            <div class="bg-white border-2 border-black rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-semibold mb-4">File Materi</h2>

                @forelse ($materi->files as $file)
                    <div
                        class="flex items-center justify-between p-3 border-1 border-black rounded-xl mb-2 hover:bg-gray-50 transition">
                        <div class="flex items-center gap-3">
                            {{-- Icon --}}
                            <i class="fa-solid fa-file text-gray-500 text-lg"></i>

                            {{-- Nama File Asli --}}
                            <a href="{{ asset('storage/' . $file->file) }}" target="_blank"
                                class="text-sm text-gray-800 hover:underline break-all">
                                {{ basename($file->file) }}
                            </a>
                        </div>

                        {{-- Tombol Download --}}
                        <a href="{{ route('getFile', ['namaFile' => $file->file]) }}"
                            class="px-3 py-2 text-sm rounded-lg border-2 border-black text-gray-700 hover:bg-gray-100 font-medium transition flex items-center gap-2">
                            <i class="fa-solid fa-download"></i> Download
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Belum ada file materi diunggah.</p>
                @endforelse
            </div>


@if ($materi->youtube_link)
<div class="bg-white border border-black rounded-2xl shadow-sm p-6">
    <h2 class="text-lg font-semibold mb-4">Video Pembelajaran</h2>

    @php
        // Pisahkan setiap baris menjadi link terpisah
        $links = preg_split("/(\r\n|\r|\n)/", trim($materi->youtube_link));
        $links = array_filter($links);
    @endphp

    @foreach ($links as $link)
        @php
            $link = trim($link);

            // Bersihkan parameter tambahan seperti ?si=xxxxx atau &t=123s
            $cleanLink = preg_replace('/\?.*/', '', $link);

            // Konversi berbagai format link ke bentuk embed standar
            if (str_contains($cleanLink, 'youtu.be/')) {
                $embedLink = str_replace('youtu.be/', 'www.youtube.com/embed/', $cleanLink);
            } elseif (str_contains($cleanLink, 'watch?v=')) {
                $embedLink = str_replace('watch?v=', 'embed/', $cleanLink);
            } else {
                $embedLink = $cleanLink;
            }
        @endphp

        <div class="mb-5">
            <iframe width="100%" height="400" class="rounded-2xl"
                src="{{ $embedLink }}"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>
    @endforeach
</div>
@endif


            


        </div>
        {{-- Kanan: Informasi Materi --}}
        <div class="w-full lg:w-80 space-y-6">
            <div class="bg-white  border-2 border-black rounded-2xl shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase">Informasi Materi</h3>
                <ul class="text-sm text-gray-700 space-y-2">
                    <li><span class="font-medium">Total File:</span> {{ $materi->files->count() }} File</li>

                </ul>

                <div class="mt-4">
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Deskripsi Singkat</h4>
                    <p class="text-sm text-gray-600">{{ Str::limit($materi->content, 100) }}</p>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="bg-white  border-2 border-black rounded-2xl shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase">Aksi</h3>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('viewKelasMapel', [
        'mapel' => $materi->kelasMapel->mapel->id,
        'kelas' => $materi->kelasMapel->kelas->id
    ]) }}"
                        class="w-full text-center py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                        ← Kembali ke Kelas
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection