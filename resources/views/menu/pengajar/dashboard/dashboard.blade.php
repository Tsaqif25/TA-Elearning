@extends('layout.template.mainTemplate')

@section('title', 'Dashboard ')

@section('container')
<div class="flex flex-col px-5 mt-5 gap-6">
  <!-- Header -->
  <div>
    <p class="font-extrabold text-[30px] leading-[45px]">Dashboard Saya</p>
    <p class="text-[#7F8190]">Selesaikan semua pembelajaran untuk berkembang</p>
  </div>

  <!-- 🔹 Stats Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Total Siswa -->
    <div class="bg-white p-5 rounded-2xl border border-[#EEEEEE] hover:shadow-md transition-all duration-300">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-[#7F8190] text-sm">Total Siswa</p>
          <p class="text-3xl font-bold mt-1">{{ $jumlahSiswa ?? 0 }}</p>
        </div>
        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Total Mapel -->
    <div class="bg-white p-5 rounded-2xl border border-[#EEEEEE] hover:shadow-md transition-all duration-300">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-[#7F8190] text-sm">Total Mapel</p>
          <p class="text-3xl font-bold mt-1">{{ $jumlahMapel ?? 0 }}</p>
        </div>
        <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Total Kelas -->
    <div class="bg-white p-5 rounded-2xl border border-[#EEEEEE] hover:shadow-md transition-all duration-300">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-[#7F8190] text-sm">Total Kelas</p>
          <p class="text-3xl font-bold mt-1">{{ $jumlahKelas ?? 0 }}</p>
        </div>
        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
        </div>
      </div>
    </div>
  </div>

  <!-- 🧩 Kelas yang Diajar -->
<!-- 🧩 Kelas yang Diajar -->
  <div class="bg-white rounded-2xl border border-[#EEEEEE] p-4 sm:p-6">
    <h2 class="font-bold text-lg sm:text-xl mb-4">Kelas yang Diajar</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4">
      @php
        $colors = [
          ['bg' => 'bg-blue-50', 'hover' => 'hover:bg-blue-100', 'badge' => 'bg-blue-500', 'border' => 'hover:border-blue-200'],
          ['bg' => 'bg-green-50', 'hover' => 'hover:bg-green-100', 'badge' => 'bg-green-500', 'border' => 'hover:border-green-200'],
          ['bg' => 'bg-orange-50', 'hover' => 'hover:bg-orange-100', 'badge' => 'bg-orange-500', 'border' => 'hover:border-orange-200'],
          ['bg' => 'bg-purple-50', 'hover' => 'hover:bg-purple-100', 'badge' => 'bg-purple-500', 'border' => 'hover:border-purple-200'],
          ['bg' => 'bg-pink-50', 'hover' => 'hover:bg-pink-100', 'badge' => 'bg-pink-500', 'border' => 'hover:border-pink-200'],
        ];
      @endphp

      @forelse ($kelasDanMapel as $index => $item)
        @php
          $color = $colors[$index % count($colors)];
        @endphp
        <a href="{{ route('viewKelasMapel', ['mapel' => $item['mapel_id'], 'kelas' => $item['kelas_id']]) }}"
           class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 rounded-xl border border-transparent transition-all duration-200 
                  {{ $color['bg'] }} {{ $color['hover'] }} {{ $color['border'] }}">
          <div class="w-10 h-10 sm:w-12 sm:h-12 {{ $color['badge'] }} rounded-xl flex items-center justify-center text-white font-bold text-base sm:text-lg shadow-sm">
            {{ strtoupper(Str::substr($item['kelas_nama'], 0, 3)) }}
          </div>
          <div>
            <p class="font-semibold text-gray-900 text-sm sm:text-base">{{ $item['kelas_nama'] ?? '-' }}</p>
            <p class="text-xs sm:text-sm text-[#7F8190]">Mapel: {{ $item['mapel_nama'] ?? '-' }}</p>
          </div>
        </a>
      @empty
        <div class="p-4 bg-gray-50 rounded-xl text-center text-[#7F8190] font-medium">
          Belum ada kelas yang Anda ampu.
        </div>
      @endforelse
    </div>
  </div>

</div>
@endsection
