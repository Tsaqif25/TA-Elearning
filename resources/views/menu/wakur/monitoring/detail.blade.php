@extends('layout.template.mainTemplate')

@section('title', 'Detail Guru')

@section('container')

{{-- 🔹 Back Button --}}
<a href="{{ route('monitoring.guru') }}"
   class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline mb-4">
   ‹ Kembali ke Monitoring Guru
</a>

{{-- 🔹 Header Guru --}}
<div class="mb-6">
  <h1 class="text-2xl font-extrabold text-[#0A090B]">{{ $guru->name }}</h1>
  <p class="text-sm text-gray-500">
    {{ $guru->user->email }} · NIP: {{ $guru->nip ?? '-' }}
  </p>
</div>

{{-- 📦 WRAPPER --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 max-w-4xl">

  {{-- HEADER --}}
  <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
    <h2 class="text-lg font-bold">Materi Berdasarkan Kelas</h2>
    <span class="text-xs text-gray-500">{{ $materi->count() }} total materi</span>
  </div>

  {{-- CONTENT --}}
  <div class="p-2 max-h-[530px] overflow-y-auto">

    @php
      $grouped = $materi->groupBy(function($m){
          return $m->kelasMapel->kelas->name . ' - ' . $m->kelasMapel->mapel->name;
      });
    @endphp

    @forelse ($grouped as $kelasNama => $listMateri)

      {{-- 🔹 TITLE PER KELAS --}}
      <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
        <p class="font-semibold text-[#0A090B]">{{ $kelasNama }}</p>
      </div>

      {{-- 🔸 LIST MATERI --}}
      @foreach ($listMateri as $m)
      <div class="px-6 py-3 border-b last:border-none">

        <p class="font-semibold text-sm">{{ $m->name }}</p>

        <p class="text-[11px] text-gray-500 mb-1">
          {{ $m->created_at->diffForHumans() }}
        </p>

        {{-- 🔗 FILE DOWNLOAD --}}
        @foreach ($m->files as $f)
          <a href="{{ route('materi.file.download', [$m->id, $f->file]) }}"
             class="block text-blue-600 text-xs hover:underline mb-1">
             📄 {{ Str::limit($f->file, 40) }}
          </a>
        @endforeach

      </div>
      @endforeach

    @empty
      <p class="text-center py-6 text-gray-500 italic">
        Belum ada materi yang diunggah guru ini.
      </p>
    @endforelse

  </div>
</div>

@endsection
