@extends('layout.template.mainTemplate')

@section('title', 'Detail Guru')

@section('container')

{{-- BACK --}}
<a href="{{ route('monitoring.guru') }}"
   class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline mb-4">
   ‹ Kembali ke Monitoring Guru
</a>

{{-- 🔹 HEADER PROFILE --}}
<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 mb-6">

    <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-700
                flex items-center justify-center font-bold text-xl">
        {{ strtoupper(substr($guru->name, 0, 2)) }}
    </div>

    <div class="flex-1">
        <h1 class="text-2xl font-extrabold text-[#0A090B]">{{ $guru->name }}</h1>
        <p class="text-sm text-gray-500">
            {{ $guru->user->email }} · NIP: {{ $guru->nip ?? '-' }}
        </p>
    </div>

    <span class="px-4 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
        ✓ Aktif
    </span>

</div>

{{-- 🔹 STATISTIK --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">

    {{-- MATERI --}}
    <div class="bg-white p-6 rounded-2xl border shadow-sm flex items-center gap-5">
        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
            📘
        </div>
        <div>
            <p class="text-sm text-gray-500">Materi</p>
            <h2 class="text-3xl font-bold text-blue-600">{{ $materi->count() }}</h2>
            <p class="text-xs text-gray-400">Total materi diunggah</p>
        </div>
    </div>

    {{-- TUGAS --}}
    <div class="bg-white p-6 rounded-2xl border shadow-sm flex items-center gap-5">
        <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
            📝
        </div>
        <div>
            <p class="text-sm text-gray-500">Tugas</p>
            <h2 class="text-3xl font-bold text-green-600">{{ $tugas->count() }}</h2>
            <p class="text-xs text-gray-400">Tugas diberikan</p>
        </div>
    </div>

    {{-- FILE --}}
    <div class="bg-white p-6 rounded-2xl border shadow-sm flex items-center gap-5">
        <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center">
            📂
        </div>
        <div>
            <p class="text-sm text-gray-500">File</p>
            <h2 class="text-3xl font-bold text-orange-600">
                {{ $materi->flatMap->files->count() }}
            </h2>
            <p class="text-xs text-gray-400">Total file terlampir</p>
        </div>
    </div>

</div>



{{-- =============================
     🔹  MATERI BERDASARKAN KELAS
   ============================= --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

    <h2 class="text-lg font-bold mb-4">Materi Pembelajaran</h2>

    {{-- 🔹 FILTER KELAS --}}
    <div class="flex flex-wrap gap-2 mb-4">

        {{-- <button onclick="filterKelas('all')"
                class="kelas-btn px-3 py-1 rounded-full text-xs font-semibold bg-gray-200">
            Semua Kelas
        </button> --}}

        @foreach ($materi->groupBy('kelasMapel.kelas.name') as $kelas => $xxx)
            <button onclick="filterKelas('{{ $kelas }}')"
                class="kelas-btn px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                {{ $kelas }} ({{ $xxx->count() }})
            </button>
        @endforeach

    </div>

    {{-- 🔹 LIST MATERI --}}
    @foreach ($materi->groupBy('kelasMapel.kelas.name') as $kelas => $list)
        <div class="kelas-group mb-6" data-kelas="{{ $kelas }}">

            <h3 class="mb-3 text-sm font-bold text-gray-600">{{ $kelas }}</h3>

            @foreach ($list as $m)
            <div class="border rounded-xl bg-gray-50 p-4 mb-3">

                <p class="font-semibold text-gray-800">{{ $m->name }}</p>
                <p class="text-[11px] text-gray-500 mb-2">{{ $m->created_at->diffForHumans() }}</p>

                {{-- FILE TERLAMPIR --}}
                @foreach ($m->files as $f)
                <div class="flex justify-between bg-white px-4 py-2 rounded-xl border mb-2">

                    <span class="text-sm truncate w-60">
                        📄 {{ $f->file }}
                    </span>

                    <a href="{{ route('materi.file.download', [$m->id, $f->file]) }}"
                       class="text-blue-600 font-semibold hover:underline text-sm">
                       Lihat
                    </a>

                </div>
                @endforeach

            </div>
            @endforeach
        </div>
    @endforeach

</div>


{{-- JS FILTER --}}
<script>
function filterKelas(kelas){
    document.querySelectorAll('.kelas-group').forEach(e=>{
        if(kelas === 'all' || e.dataset.kelas === kelas){
            e.style.display = 'block'
        } else {
            e.style.display = 'none'
        }
    })
}
</script>

@endsection
