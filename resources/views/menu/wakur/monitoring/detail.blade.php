@extends('layout.template.mainTemplate')

@section('title', 'Detail Guru')

@section('container')

{{-- Header Guru --}}
<div class="mb-6">
  <a href="{{ route('monitoring.guru') }}"
     class="text-sm text-blue-600 hover:underline mb-3 inline-flex items-center gap-1">
    ‹ Kembali ke Monitoring Guru
  </a>

  <h1 class="text-2xl font-extrabold text-[#0A090B] mb-1">{{ $guru->name }}</h1>
  <p class="text-sm text-gray-500">
    User: {{ $guru->user->email ?? '-' }} · NIP: {{ $guru->nip ?? '-' }}
  </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

  {{--  MATERI --}}
  <div class="bg-white rounded-2xl shadow-sm border border-gray-100 lg:col-span-1">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
      <h2 class="text-base font-semibold">Materi</h2>
      <span class="text-xs text-gray-500">{{ $materi->count() }} item</span>
    </div>

    <div class="max-h-[380px] overflow-y-auto">
      @forelse ($materi as $m)
        <div class="px-6 py-3 border-b last:border-b-0 text-sm">
          <p class="font-semibold text-[#0A090B]">{{ $m->name }}</p>

          <p class="text-xs text-gray-500">
            Kelas {{ $m->kelasMapel->kelas->name ?? '-' }} ·
            {{ $m->kelasMapel->mapel->name ?? '-' }}
          </p>

          <p class="text-[11px] text-gray-400 mt-1">
            {{ $m->created_at->diffForHumans() }}
          </p>

          {{-- 🔽 Tambahan tombol download file --}}
          @foreach ($m->files as $f)
            <a href="{{ route('materi.file.download', [$m->id, $f->file]) }}"
               class="text-blue-600 text-xs mt-1 hover:underline block">
               📄 {{ $f->file }}
            </a>
          @endforeach

        </div>
      @empty
        <p class="px-6 py-4 text-sm text-gray-500 italic">Belum ada materi.</p>
      @endforelse
    </div>
  </div>





</div>
@endsection
