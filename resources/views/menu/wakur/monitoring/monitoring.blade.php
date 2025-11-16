@extends('layout.template.mainTemplate')

@section('title', 'Monitoring Guru')

@section('container')

<h1 class="text-2xl font-extrabold mb-1">Monitoring Guru</h1>
<p class="text-sm text-gray-500 mb-6">Pantau aktivitas semua guru</p>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
  <table class="min-w-full text-sm">
    <thead class="bg-[#F9FAFB] text-gray-600">
      <tr>
        <th class="px-6 py-3 text-left">Guru</th>
        <th class="px-6 py-3 text-left">Mata Pelajaran</th>
        <th class="px-6 py-3 text-center">Materi</th>
        <th class="px-6 py-3 text-center">Tugas</th>
        <th class="px-6 py-3 text-center">Ujian</th>
        <th class="px-6 py-3 text-center">Aksi</th>
      </tr>
    </thead>

    <tbody class="divide-y divide-gray-100 text-gray-800">

      @foreach ($gurus as $guru)
      <tr class="hover:bg-gray-50">

        {{-- 🧑 Nama guru --}}
        <td class="px-6 py-4 flex items-center gap-3">
          <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
            {{ strtoupper(substr($guru->name,0,2)) }}
          </div>
          <div>
            <p class="font-semibold">{{ $guru->name }}</p>
            <p class="text-xs text-gray-500">{{ $guru->user->email ?? '-' }}</p>
          </div>
        </td>

        {{-- 📚 MAPEL --}}
        <td class="px-6 py-4">
          @forelse ($guru->mapel_list as $mapel)
            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-semibold mr-1">
              {{ $mapel }}
            </span>
          @empty
            <span class="text-xs text-gray-400">Tidak ada mapel</span>
          @endforelse
        </td>

        {{-- 📁 MATERI --}}
        <td class="px-6 py-4 text-center">
          <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-lg font-semibold">
            {{ $guru->total_materi }}
          </span>
        </td>

        {{-- 📝 TUGAS --}}
        <td class="px-6 py-4 text-center">
          <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg font-semibold">
            {{ $guru->total_tugas }}
          </span>
        </td>

        {{-- ❓ UJIAN --}}
        <td class="px-6 py-4 text-center">
          <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-lg font-semibold">
            {{ $guru->total_ujian }}
          </span>
        </td>

        {{-- 🔗 TOMBOL DETAIL --}}
        <td class="px-6 py-4 text-center">
          <a href="{{ route('monitoring.guru.detail', $guru->id) }}"
             class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center gap-1">
             Detail
             <span>›</span>
          </a>
        </td>

      </tr>
      @endforeach

    </tbody>
  </table>
</div>

@endsection
