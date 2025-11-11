@extends('layout.template.mainTemplate')

@section('title', 'Dashboard')

@section('container')
@if (Auth::user()->hasRole('Pengajar'))

  {{--  HERO SECTION --}}
  <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 fade-in">
    <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl p-6 sm:p-8 shadow-md">
      <h1 class="text-2xl sm:text-4xl font-bold mb-3">
        Selamat Datang, <span class="underline decoration-white/40">{{ Auth::user()->name }}</span>! 👋
      </h1>
      <p class="text-white/90 max-w-2xl mb-6 text-sm sm:text-base">
        Kelola kelas dan materi ajar Anda di satu tempat. Pantau progres pembelajaran dan tingkatkan kualitas mengajar Anda.
      </p>
      <div class="flex flex-wrap gap-4">
        <a href="" 
           class="px-5 sm:px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition">
          Lanjutkan Mengajar
        </a>
        <a href="" 
           class="px-5 sm:px-6 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-600 transition">
          Lihat Semua Kelas
        </a>
      </div>
    </div>
  </header>

 
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- <h2 class="text-lg sm:text-xl font-semibold text-slate-800 mb-6">Statistik Pengajaran</h2> --}}

    {{-- <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
      {{-- Total Siswa --}}
      {{-- <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md border border-transparent hover:border-blue-200 transition">
        <div class="flex justify-between items-center">
          <div>
            <p class="text-sm text-gray-500">Total Siswa</p>
            <h3 class="text-3xl font-bold text-blue-600 mt-1">{{ $totalSiswa ?? 0 }}</h3>
          </div>
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 text-xl">👩‍🎓</div>
        </div>
      </div> --}}

      {{-- Total Mapel --}}
      {{-- <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md border border-transparent hover:border-green-200 transition">
        <div class="flex justify-between items-center">
          <div>
            <p class="text-sm text-gray-500">Total Mapel</p>
            <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $totalMapel ?? 0 }}</h3>
          </div>
          <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 text-xl">📘</div>
        </div>
      </div> --}}

      {{-- Total Kelas --}}
      {{-- <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md border border-transparent hover:border-orange-200 transition">
        <div class="flex justify-between items-center">
          <div>
            <p class="text-sm text-gray-500">Total Kelas</p>
            <h3 class="text-3xl font-bold text-orange-600 mt-1">{{ $totalKelas ?? 0 }}</h3>
          </div>
          <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600 text-xl">🏫</div>
        </div>
      </div> --}}
    {{-- </div> --}} 

    {{--  DAFTAR KELAS YANG DIAJAR --}}
    <h2 class="text-lg sm:text-xl font-semibold text-slate-800 mb-6">Kelas yang Anda Ajar</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @forelse ($kelasDanMapel as $index => $item)
        <a href="{{ route('viewKelasMapel', ['mapel' => $item['mapel_id'], 'kelas' => $item['kelas_id']]) }}"
           class="bg-white rounded-xl p-5 sm:p-6 shadow-sm hover:shadow-md transition border border-transparent hover:border-blue-200 cursor-pointer flex flex-col justify-between">
          
          <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white text-xl 
              {{ ['bg-blue-600','bg-green-600','bg-orange-600','bg-purple-600','bg-pink-600'][$index % 5] }}">
              {{ strtoupper(substr($item['mapel_nama'], 0, 2)) }}
            </div>
          </div>

          <h3 class="text-base sm:text-lg font-semibold mb-1">{{ $item['mapel_nama'] }}</h3>
          <p class="text-sm text-gray-500 mb-3">Kelas: {{ $item['kelas_nama'] }}</p>
          <div class="mt-1 flex justify-between items-center">
            <span class="text-sm text-gray-500">Jumlah Materi:</span>
            <span class="font-semibold text-blue-600">{{ $item['materi_count'] ?? 0 }} Materi</span>
          </div>
        </a>
      @empty
        <div class="col-span-4 text-center text-gray-500 py-10">
          Belum ada kelas yang Anda ampu.
        </div>
      @endforelse
    </div>
  </main>

@endif
@endsection
