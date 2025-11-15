@extends('layout.template.mainTemplate')

@section('title', 'Dashboard Wakur')

@section('container')

{{-- HEADER --}}
<h1 class="text-2xl font-extrabold text-[#0A090B] mb-1">Overview Dashboard</h1>
<p class="text-sm text-gray-500 mb-8">SMK 2 Padang – Monitoring & Management</p>

{{-- STATISTIK --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

    {{-- TOTAL MATERI --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5">
        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6l-8 4 8 4 8-4-8-4z M4 14l8 4 8-4 M4 10l8 4 8-4" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Materi</p>
            <h2 class="text-3xl font-bold">{{ $totalMateri }}</h2>
        </div>
    </div>

    {{-- TOTAL TUGAS --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5">
        <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6M9 16h6M9 8h6M4 6h16v12H4z" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Tugas</p>
            <h2 class="text-3xl font-bold">{{ $totalTugas }}</h2>
        </div>
    </div>

    {{-- TOTAL UJIAN --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5">
        <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.5l4 7h-8l4-7z M6 11.5h12M9 16.5h6" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Ujian</p>
            <h2 class="text-3xl font-bold">{{ $totalUjian }}</h2>
        </div>
    </div>

    {{-- GURU AKTIF --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5">
        <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.856M12 12a4 4 0 100-8 4 4 0 000 8zm6 8v-2a4 4 0 00-3-3.874M6 20v-2a4 4 0 013-3.874M6 12a4 4 0 110-8" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Guru Aktif Minggu Ini</p>
            <h2 class="text-3xl font-bold">{{ $guruAktif }}</h2>
        </div>
    </div>

</div>

{{-- BAGIAN BAWAH --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- KOLOM KIRI - AKTIVITAS --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2">
        <h2 class="text-lg font-bold mb-4">Aktivitas Terbaru</h2>

    @foreach ($aktivitas as $m)

<div class="flex items-center justify-between py-4 border-b last:border-none">

    <div class="flex items-center gap-4">
        
        <div class="w-11 h-11 rounded-full bg-blue-100 text-blue-600 
                    flex items-center justify-center font-bold text-lg shadow-sm">
            {{ strtoupper(substr($m->user->name ?? 'G', 0, 1)) }}
        </div>

        <div>
            <p class="font-semibold text-[#0A090B]">
                {{ $m->user->name ?? 'Guru Tidak Diketahui' }}
            </p>
         <p class="text-sm text-gray-500">
    Mengunggah 
    <span class="font-medium text-gray-700">
        {{ $m->tipe }}
    </span> 
    : {{ $m->name }}
</p>

        </div>
    </div>

    <p class="text-xs text-gray-400">
        {{ $m->created_at->diffForHumans() }}
    </p>

</div>

@endforeach

    </div>

   

</div>

@endsection
