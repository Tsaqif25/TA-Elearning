@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
  <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

    {{-- HEADER GRADIENT KONSISTEN --}}
    <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl shadow-lg p-6 sm:p-8 mb-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-tr from-blue-600/90 to-green-500/90 rounded-2xl"></div>

        <div class="relative z-10">

            {{-- Tombol Kembali --}}
            <a href="{{ url()->previous() }}"
               class="flex items-center gap-2 text-white/90 hover:text-white font-medium text-sm mb-4 transition">
              <i class="fa-solid fa-arrow-left text-xs"></i>
              Kembali
            </a>

            <p class="text-xs font-semibold opacity-90 mb-1">DISKUSI & KOMENTAR</p>

            <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                Submission - {{ $siswa->name }}
            </h1>

            <p class="text-sm opacity-90 mt-1">
                Diupload pada:
                {{ optional($pengumpulan?->submitted_at)->translatedFormat('d F Y, H:i') ?? '-' }}
            </p>

            {{-- Nilai --}}
            <div class="absolute right-8 top-8 text-right">
                <p class="text-white text-lg font-semibold">
                    Nilai:
                    <span class="font-bold">{{ $nilai ?? '-' }}</span>
                </p>
            </div>

        </div>
    </div>

    {{-- FILE UPLOAD --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm mb-8">
        <h3 class="text-sm font-bold text-gray-700 mb-3">File yang Diupload</h3>

        @if ($pengumpulan && $pengumpulan->files->count())
            @foreach ($pengumpulan->files as $file)
                <a href="{{ asset('storage/' . $file->file) }}"
                   target="_blank"
                   class="flex items-center justify-between bg-[#F9FAFB] hover:bg-gray-50 transition 
                          rounded-xl px-4 py-3 mb-2 border">

                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-file text-blue-600 text-xl"></i>
                        <span class="text-sm text-gray-700">{{ basename($file->file) }}</span>
                    </div>

                    <span class="text-gray-500 text-xs">
                        {{ number_format(Storage::size('public/'.$file->file) / 1024, 1) }} KB
                    </span>
                </a>
            @endforeach
        @else
            <p class="text-gray-500 italic text-sm">Belum upload file.</p>
        @endif
    </div>

    {{-- KOMENTAR --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm mb-8">
        <h3 class="text-sm font-bold text-gray-700 mb-4">Diskusi & Komentar</h3>

        <div class="space-y-4 max-h-[450px] overflow-y-auto pr-2">

            @foreach ($komentar as $k)

                {{-- Pesan Guru --}}
                @if($k->user->hasRole('Pengajar'))
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <p class="font-semibold text-blue-800 text-sm mb-1">
                            {{ $k->user->name }}
                            <span class="text-xs bg-blue-200 text-blue-800 px-2 py-0.5 rounded-full ml-1">
                                Guru
                            </span>
                        </p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $k->pesan }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ $k->created_at->translatedFormat('d/m/Y, H:i') }}
                        </p>
                    </div>

                {{-- Pesan Siswa --}}
                @else
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                        <p class="font-semibold text-green-800 text-sm mb-1">
                            {{ $k->user->name }}
                            <span class="text-xs bg-green-200 text-green-800 px-2 py-0.5 rounded-full ml-1">
                                Siswa
                            </span>
                        </p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $k->pesan }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ $k->created_at->translatedFormat('d/m/Y, H:i') }}
                        </p>
                    </div>
                @endif

            @endforeach

        </div>

        {{-- FORM KIRIM PESAN --}}
        <form action="{{ route('guru.tugas.diskusi.store', [$tugas->id, $siswa->id]) }}"
              method="POST"
              class="mt-4 flex items-center gap-3">
            @csrf

            <input type="text"
                   name="pesan"
                   placeholder="Tulis komentar atau feedback..."
                   class="flex-1 border border-gray-300 rounded-xl px-4 py-2 text-sm
                          focus:ring-blue-400 focus:border-blue-400">

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold">
                <i class="fa-solid fa-paper-plane mr-1"></i> Kirim
            </button>
        </form>
    </div>

  </div>
</div>
@endsection
