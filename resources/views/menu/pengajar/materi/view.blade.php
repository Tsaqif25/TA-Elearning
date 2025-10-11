@extends('layout.template.mainTemplate')

@section('container')
    {{-- Navigasi Breadcrumb --}}
    <div class="col-12 ps-4 pe-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @if (!Auth::user()->hasRole('Admin'))
                    <li class="breadcrumb-item">
                        <a
                            href="{{ route('viewKelasMapel', [
                                'mapel' => $kelasMapel->mapel->id,
                                'kelas' => $kelasMapel->kelas->id,
                            ]) }}">
                            {{ $kelasMapel->mapel->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">Materi</li>
            </ol>

        </nav>
    </div>

    {{-- Judul Halaman --}}
    <div class="ps-4 pe-4 mt-4 pt-4">
        <h2 class="display-6 fw-bold">
            @if (Auth::user()->hasRole('Admin'))
                <a href="{{ route('activity') }}">
                    <button type="button" class="btn btn-outline-secondary rounded-circle">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </a> Materi
            @else
                <a
                    href="{{ route('viewKelasMapel', [
                        'mapel' => $kelasMapel->mapel->id,
                        'kelas' => $kelasMapel->kelas->id,
                    ]) }}">
                    <button type="button" class="btn btn-outline-secondary rounded-circle">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </a>
            @endif
        </h2>
    </div>

    {{-- Baris utama --}}
    <div class="col-12 ps-4 pe-4 mb-4">
        <div class="row">
            {{-- Bagian Kiri --}}
            <div class="col-xl-9 col-lg-12 col-md-12">
                <div class="row">
                    {{-- Tampilan Materi --}}
                    <div class="col-12 mb-4">
                        <div class="p-4 bg-white rounded-4">
                            <div class="h-100 p-4">
                                <h2 class="fw-bold text-primary">
                                    {{ $materi->name }}
                                    @if ($materi->isHidden == 1)
                                        <i class="fa-solid fa-lock fa-bounce text-danger"></i>
                                    @endif
                                </h2>
                                <hr>
                                <p>{!! $materi->content !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan --}}
            <div class="col-xl-3 col-lg-12 col-md-12">
                {{-- Info Pengajar --}}
                <div class="mb-4 p-4 bg-white rounded-4">
                    <div class="h-100 p-4">
                        <h4 class="fw-bold mb-2">Pengajar</h4>
                        <hr>
                        <div class="row">
                            <div class="col-lg-4 d-none d-lg-none d-xl-block">
                                @if ($editor && $editor->gambar == null)
                                    <img src="/asset/icons/profile-women.svg" class="rounded-circle img-fluid"
                                        alt="">
                                @elseif ($editor)
                                    <img src="{{ asset('storage/file/img-upload/' . $editor->gambar) }}" alt="placeholder"
                                        class="rounded-circle img-fluid">
                                @endif
                            </div>
                            <div class="col-lg-8">
                                @if ($editor)
                                    <a href="{{ route('viewProfilePengajar', ['pengajar' => $editor->id]) }}">
                                        {{ $editor->name }}
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada pengajar</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

          
                {{-- Daftar File --}}
                <div class="mb-4 p-4 bg-white rounded-4">
                    <div class="h-100 p-4">
                        <h4 class="fw-bold mb-2">Files</h4>
                        <hr>
                        @if ($materi->files->count() > 0)
                            <ul class="list-group">
                                @foreach ($materi->files as $key)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            @if (Str::endsWith($key->file, ['.jpg', '.jpeg', '.png', '.gif']))
                                                <i class="fa-solid fa-image"></i>
                                            @elseif (Str::endsWith($key->file, ['.mp4', '.avi', '.mov']))
                                                <i class="fa-solid fa-video"></i>
                                            @elseif (Str::endsWith($key->file, ['.pdf']))
                                                <i class="fa-solid fa-file-pdf"></i>
                                            @elseif (Str::endsWith($key->file, ['.doc', '.docx']))
                                                <i class="fa-solid fa-file-word"></i>
                                            @elseif (Str::endsWith($key->file, ['.ppt', '.pptx']))
                                                <i class="fa-solid fa-file-powerpoint"></i>
                                            @elseif (Str::endsWith($key->file, ['.xls', '.xlsx']))
                                                <i class="fa-solid fa-file-excel"></i>
                                            @elseif (Str::endsWith($key->file, ['.txt']))
                                                <i class="fa-solid fa-file-alt"></i>
                                            @elseif (Str::endsWith($key->file, ['.mp3']))
                                                <i class="fa-solid fa-music"></i>
                                            @else
                                                <i class="fa-solid fa-file"></i>
                                            @endif

                                            {{-- tampilkan nama file asli --}}
                                            <a href="{{ asset('storage/' . urlencode($key->file)) }}" target="_blank">
                                                {{ basename($key->file) }}
                                            </a>
                                          
                                            <a href="{{ route('getFile', ['namaFile' => $key->file]) }}">
                                                Download
                                            </a>

                                        </span>

                                        {{-- Tombol hapus opsional --}}
                                        {{-- <form action="{{ route('materi.destroy', $materi->id) }}" method="POST" --}}
                                        @if (Auth::user()->hasRole('Pengajar'))
                                        <form action="{{ route('materi.destroy', $materi->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus file ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="file_id" value="{{ $key->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm">X</button>
                                        </form>
                                        @endif


                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="small">(Tidak ada file untuk materi ini)</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Script untuk mengatur gambar agar responsif --}}
    <script>
        var img = document.querySelectorAll('img');
        img.forEach(function(element) {
            element.classList.add('img-fluid');
        });
    </script>

  
@endsection
