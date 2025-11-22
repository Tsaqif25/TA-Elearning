@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
    <div class="max-w-[1200px] mx-auto w-full px-5 sm:px-6 lg:px-10 mt-8 mb-16">

        <!--  HEADER GRADIENT -->
        <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl p-6 sm:p-8 shadow-lg mb-10">

            <!-- Tombol Back -->
            <a href="{{ route('viewKelasMapel', [
                'mapel' => $kelasMapel->mapel->id,
                'kelas' => $kelasMapel->kelas->id,
                'tab' => 'quiz'
            ]) }}"
               class="flex items-center gap-2 text-white/90 hover:text-white font-medium text-sm mb-4 transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali ke Daftar Quiz
            </a>

            <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                Soal Ujian
            </h1>

            <p class="text-sm opacity-90 mt-1">
                {{ $ujian->judul }} — {{ $kelas->name }} / {{ $mapel->name }}
            </p>
        </div>

        <!-- ============================ -->
        <!-- DETAIL UJIAN -->
        <!-- ============================ -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 mb-10">
            <h2 class="text-lg font-bold text-[#0A090B] flex items-center gap-2 mb-4">
                <i class="fa-solid fa-pen-to-square"></i> Detail Ujian
            </h2>

            <table class="w-full text-sm">
                <tr class="border-b">
                    <td class="py-2 font-semibold w-1/4">Nama Ujian</td>
                    <td class="py-2">{{ $ujian->judul }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 font-semibold">Mata Pelajaran</td>
                    <td class="py-2">{{ $mapel->name }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 font-semibold">Kelas</td>
                    <td class="py-2">{{ $kelas->name }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Jumlah Soal</td>
                    <td class="py-2">{{ $soal->count() }}</td>
                </tr>
            </table>
        </div>

        <!-- ============================ -->
        <!-- HEADER LIST SOAL -->
        <!-- ============================ -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold flex items-center gap-2 text-[#0A090B]">
                <i class="fa-solid fa-circle-question"></i> Daftar Soal
            </h2>

            <a href="{{ route('ujian.soal.create', $ujian->id) }}"
               class="flex items-center gap-2 bg-gradient-to-tr from-blue-500 to-green-500 text-white px-5 py-2.5 rounded-full font-semibold text-sm shadow hover:scale-[1.03] hover:shadow-lg transition">
                <i class="fa-solid fa-plus"></i> Tambah Soal
            </a>
        </div>

        <!-- ============================ -->
        <!-- LIST SOAL STYLE PREMIUM CBT -->
        <!-- ============================ -->
        <div class="space-y-6">
            @foreach ($soal as $item)
                <div class="border border-gray-200 bg-white rounded-2xl shadow-sm flex relative overflow-hidden">

                    <!-- Nomor Soal -->
                    <div class="w-20 bg-[#F9FAFB] border-r border-gray-200 flex items-start justify-center pt-6 shrink-0">
                        <span class="text-xl font-bold text-gray-700">{{ $loop->iteration }}</span>
                    </div>

                    <!-- Konten Soal -->
                    <div class="flex-1 p-6 relative">

                        <!-- ACTION BUTTON FLOAT -->
                        <div class="absolute top-4 right-4 flex gap-2">

                            <!-- Edit -->
                            <a href="{{ route('ujian.soal.edit', [$ujian->id, $item->id]) }}"
                               class="px-4 py-1.5 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full hover:bg-amber-200 flex items-center gap-1 transition border border-amber-200">
                                <i class="fa-solid fa-pen"></i> Edit
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('ujian.soal.destroy', [$ujian->id, $item->id]) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="px-4 py-1.5 bg-rose-100 text-rose-700 text-xs font-semibold rounded-full hover:bg-rose-200 flex items-center gap-1 transition border border-rose-200">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>

                        </div>

                        <!-- Pertanyaan -->
                        <h3 class="font-semibold text-gray-900 mb-4 pr-32 leading-relaxed">
                            {!! $item->pertanyaan !!}
                            <hr class="mt-3">
                        </h3>

                        <!-- Pilihan -->
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
