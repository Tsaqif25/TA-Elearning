@extends('layout.template.mainTemplate')

@section('container')

<h1 class="text-2xl font-bold mb-2">{{ $guru->name }}</h1>
<p class="text-gray-600 mb-6">{{ $guru->user->email }}</p>

{{-- Materi --}}
<div class="bg-white p-6 rounded-xl shadow mb-6">
    <h2 class="text-lg font-bold mb-4">Materi yang Diunggah</h2>
    
    @forelse ($materi as $m)
        <p>- {{ $m->name }}</p>
    @empty
        <p class="text-gray-500 text-sm italic">Belum ada materi.</p>
    @endforelse
</div>

{{-- Tugas --}}
<div class="bg-white p-6 rounded-xl shadow mb-6">
    <h2 class="text-lg font-bold mb-4">Tugas yang Dibuat</h2>
    
    @forelse ($tugas as $t)
        <p>- {{ $t->name }}</p>
    @empty
        <p class="text-gray-500 text-sm italic">Belum ada tugas.</p>
    @endforelse
</div>

{{-- Ujian --}}
<div class="bg-white p-6 rounded-xl shadow">
    <h2 class="text-lg font-bold mb-4">Ujian yang Dibuat</h2>
    
    @forelse ($ujian as $u)
        <p>- {{ $u->name }}</p>
    @empty
        <p class="text-gray-500 text-sm italic">Belum ada ujian.</p>
    @endforelse
</div>

@endsection
