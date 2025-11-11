@extends('layout.template.mainTemplate')

@section('container')
<div class="min-h-screen bg-slate-50 text-slate-800 font-sans fade-in">

  {{-- 🎓 Hero Section --}}
  <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
    <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl p-6 sm:p-8 shadow-md">
      <h1 class="text-2xl sm:text-4xl font-bold mb-3">
        Selamat Datang, <span class="underline decoration-white/40">{{ Auth::user()->name }}</span>! 👋
      </h1>
      <p class="text-white/90 max-w-2xl mb-6 text-sm sm:text-base">
        Akses semua mata pelajaran, tugas, dan materi pembelajaran dalam satu platform.
      </p>
      <div class="flex flex-wrap gap-4">
        <a href="{{ route('dashboard') }}"
           class="px-5 sm:px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition">
          Lanjutkan Belajar
        </a>
        <a href="#jadwal"
           class="px-5 sm:px-6 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-600 transition">
          Lihat Jadwal
        </a>
      </div>
    </div>
  </header>

  {{-- 📚 Mata Pelajaran Section --}}
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h2 class="text-lg sm:text-xl font-semibold text-slate-800 mb-6">Mata Pelajaran Saya</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @if ($kelas && count($mapelKelas))
        @foreach ($mapelKelas as $mapel)
          <a href="{{ route('viewKelasMapel', ['mapel' => $mapel['mapel_id'], 'kelas' => $kelas->id]) }}"
             class="bg-white rounded-xl p-5 sm:p-6 shadow-sm hover:shadow-md cursor-pointer transition border border-transparent hover:border-blue-200 flex flex-col justify-between">

            {{-- Icon + Nama --}}
            <div class="flex items-start justify-between mb-4">
              <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white text-xl
                          {{ $loop->index % 2 == 0 ? 'bg-green-600' : 'bg-blue-600' }}">
                {{ strtoupper(substr($mapel['mapel_name'], 0, 2)) }}
              </div>
            </div>

            {{-- Detail Mapel --}}
            <div>
              <h3 class="text-base sm:text-lg font-semibold mb-1">{{ $mapel['mapel_name'] }}</h3>
              <p class="text-sm text-gray-500 mb-4">Pengajar: {{ $mapel['pengajar_name'] ?? '-' }}</p>
              <div class="mt-3 flex items-center justify-between">
                <span class="text-sm text-gray-500">Jumlah Materi:</span>
                <span class="font-semibold text-green-600">{{ $mapel['materi_count'] ?? 0 }} Materi</span>
              </div>
            </div>
          </a>
        @endforeach
      @else
        <div class="col-span-4 text-center text-gray-500 py-10">
          Belum ada mata pelajaran untuk kelas ini.
        </div>
      @endif
    </div>
    
  </main>
</div>
@endsection
