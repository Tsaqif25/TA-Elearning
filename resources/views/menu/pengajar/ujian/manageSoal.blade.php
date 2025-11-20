@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

        <!-- Back -->
        <a href="{{ route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel->id,
            'kelas' => $kelasMapel->kelas->id,
            'tab' => 'quiz'
        ]) }}"
           class="flex items-center gap-2 text-[#2B82FE] hover:text-[#1a5fd4] font-medium text-sm mb-6">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
        </a>

        <!-- =============================== -->
        <!-- DETAIL UJIAN -->
        <!-- =============================== -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 mb-8">
            <h2 class="text-lg font-bold text-[#0A090B] flex items-center gap-2 mb-4">
                <i class="fa-solid fa-pen-to-square"></i> Detail Ujian
            </h2>

            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <tbody>
                        <tr class="border-b">
                            <td class="bg-gray-50 font-semibold p-3 w-1/3">Nama Ujian</td>
                            <td class="p-3">{{ $ujian->judul }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="bg-gray-50 font-semibold p-3">Mata Pelajaran</td>
                            <td class="p-3">{{ $mapel->name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="bg-gray-50 font-semibold p-3">Kelas</td>
                            <td class="p-3">{{ $kelas->name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="bg-gray-50 font-semibold p-3">Jumlah Soal</td>
                            <td class="p-3">{{ $soal->count() }}</td>
                        </tr>
                        <tr>
                            <td class="bg-gray-50 font-semibold p-3">Durasi (Menit)</td>
                            <td class="p-3">{{ $ujian->durasi }} menit</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- =============================== -->
        <!-- SOAL UJIAN -->
        <!-- =============================== -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">

            <h2 class="text-lg font-bold text-[#0A090B] flex items-center gap-2 mb-4">
                <i class="fa-solid fa-circle-question"></i> Soal Ujian
            </h2>

            <!-- Tombol Tambah dan Import -->
            <div class="flex gap-2 mb-5">
                <a href="{{ route('ujian.soal.create', $ujian->id) }}"
                   class="px-4 py-2 text-sm font-semibold bg-[#2B82FE] text-white rounded-lg shadow hover:bg-blue-600">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah
                </a>

                {{-- <a href="#"
                   class="px-4 py-2 text-sm font-semibold bg-green-500 text-white rounded-lg shadow hover:bg-green-600">
                    <i class="fa-solid fa-file-excel mr-1"></i> Import
                </a> --}}
<a href="{{ route('ujian.soal.importView', $ujian->id) }}"
   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow flex items-center gap-2 text-sm font-semibold">
    <i class="fa-solid fa-file-excel"></i>
    Import Soal
</a>


            </div>

            <!-- LIST SOAL -->
            @if ($soal->isEmpty())
                <p class="text-center text-gray-500 py-6">Belum ada soal ditambahkan.</p>
            @else
                <table class="w-full text-sm border border-gray-200 rounded-xl overflow-hidden">
                    <thead class="bg-[#111827] text-white">
                        <tr>
                            <th class="p-3 w-16 text-center">No.</th>
                            <th class="p-3">Soal</th>
                            <th class="p-3 w-32 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($soal as $item)
                            <tr class="border-b">
                                <td class="p-3 text-center">{{ $loop->iteration }}</td>
                                <td class="p-3">
                                    {{ $item->pertanyaan }}
                                </td>
                                <td class="p-3 text-center flex justify-center gap-2">

                                    <!-- Edit -->
                                    <a href="{{ route('ujian.soal.edit', [$ujian->id, $item->id]) }}"
                                       class="px-3 py-1.5 text-xs bg-amber-100 text-amber-700 rounded-full">
                                        Edit
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('ujian.soal.destroy', [$ujian->id, $item->id]) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1.5 text-xs bg-red-100 text-red-700 rounded-full">
                                            Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            @endif

        </div>

    </div>
</div>
@endsection
