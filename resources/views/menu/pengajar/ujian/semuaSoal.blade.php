@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
    <div class="max-w-[1200px] mx-auto w-full px-5 sm:px-6 lg:px-10 mt-8 mb-16">

        <!-- Back -->
        <a href="{{ route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel->id,
            'kelas' => $kelasMapel->kelas->id,
            'tab' => 'quiz'
        ]) }}"
           class="flex items-center gap-2 text-blue-600 hover:text-blue-800 text-sm font-medium mb-6">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
        </a>


        <!-- ============================ -->
        <!-- DETAIL UJIAN (TIDAK DIHAPUS) -->
        <!-- ============================ -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 mb-10">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-pen"></i> Detail Ujian
            </h2>

            <table class="w-full text-sm">
                <tr>
                    <td class="py-2 font-semibold w-1/4">Nama Ujian</td>
                    <td class="py-2">{{ $ujian->judul }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Mata Pelajaran</td>
                    <td class="py-2">{{ $mapel->name }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Kelas</td>
                    <td class="py-2">{{ $kelas->name }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Jumlah Soal</td>
                    <td class="py-2">{{ $soal->count() }}</td>
                </tr>
            </table>
        </div>


        <!-- HEADER LIST SOAL -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-question"></i> Soal Ujian
            </h2>

            <a href="{{ route('ujian.soal.create', $ujian->id) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full shadow text-sm font-semibold flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Soal
            </a>
        </div>


        <!-- ============================ -->
        <!-- LIST SOAL CBT PREMIUM STYLE -->
        <!-- ============================ -->
        <div class="space-y-6">
            @foreach ($soal as $item)
       <div class="border border-gray-200 bg-white rounded-xl shadow-sm flex relative">

    <!-- Kolom Nomor -->
    <div class="w-20 border-r border-gray-200 flex items-start justify-center pt-6 shrink-0">
        <span class="text-lg font-bold text-gray-700">{{ $loop->iteration }}</span>
    </div>

    <!-- Konten Soal -->
    <div class="flex-1 p-6 relative">

        <!-- Tombol Edit/Hapus (FLOAT) -->
        <div class="absolute top-4 right-4 flex gap-2">
            <a href="{{ route('ujian.soal.edit', [$ujian->id, $item->id]) }}"
               class="px-3 py-1.5 bg-blue-600 text-white text-xs rounded-full flex items-center gap-1 hover:bg-blue-700 shadow">
                <i class="fa-solid fa-pen"></i> Edit
            </a>

            <form action="{{ route('ujian.soal.destroy', [$ujian->id, $item->id]) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                @csrf
                @method('DELETE')
                <button class="px-3 py-1.5 bg-red-600 text-white text-xs rounded-full flex items-center gap-1 hover:bg-red-700 shadow">
                    <i class="fa-solid fa-trash"></i> Hapus
                </button>
            </form>
        </div>

        <!-- SOAL -->
        <h3 class="font-semibold text-gray-900 mb-4 pr-32">
            {!! $item->pertanyaan !!}
            <hr>
        </h3>

        <!-- PILIHAN -->
        <ul class="text-sm text-gray-700 space-y-1 mb-4">
            <li>A. {!! $item->option_1 !!}</li>
            <li>B. {!! $item->option_2 !!}</li>
            <li>C. {!! $item->option_3 !!}</li>
            <li>D. {!! $item->option_4 !!}</li>
            @if($item->option_5)
                <li>E. {!! $item->option_5 !!}</li>
            @endif
        </ul>

        <!-- Kunci -->
        <p class="text-green-600 font-semibold text-sm">
            Kunci Jawaban: {{ chr(64 + $item->answer) }}
        </p>

    </div>

</div>

            @endforeach
        </div>

    </div>
</div>
@endsection
