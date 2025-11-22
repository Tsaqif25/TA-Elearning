@extends('layout.template.mainTemplate')

@section('container')

<div class="flex flex-col w-full bg-[#FAFAFA] min-h-screen font-poppins">
    <div class="max-w-[1200px] mx-auto w-full px-5 sm:px-6 lg:px-10 mt-8 mb-16">

        <!--  HEADER GRADIENT + BACK -->
        <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl p-6 sm:p-8 shadow-lg mb-8">

            <!-- Tombol Back -->
            <a href="{{ route('viewKelasMapel', [
                'mapel' => $kelasMapel->mapel->id,
                'kelas' => $kelasMapel->kelas->id,
                'tab'   => 'tugas'
            ]) }}"
            class="flex items-center gap-2 text-white/90 hover:text-white font-medium text-sm mb-4 transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali ke Daftar Tugas
            </a>

            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                Rekap Nilai Tugas
            </h1>

            <p class="text-sm opacity-90 mt-1">
                {{ $kelasMapel->kelas->name }} — {{ $kelasMapel->mapel->name }}
            </p>
        </div>

        <!-- 🔸 TABEL NILAI -->
        <div class="bg-white rounded-2xl shadow border border-gray-200 overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <!-- HEADER -->
                    <thead class="bg-gray-50 border-b sticky top-0 z-10">
                        <tr class="text-gray-700 font-semibold">

                            <th class="p-4 border text-left bg-gray-100">Nama Siswa</th>

                            @foreach($tugasList as $tugas)
                                <th class="p-4 border text-center">
                                    {{ $tugas->judul }}
                                </th>
                            @endforeach

                            <th class="p-4 border bg-blue-50 text-center">Rata-rata</th>
                        </tr>
                    </thead>

                    <!-- BODY -->
                    <tbody>
                        @foreach($siswaList as $siswa)
                            @php $total = 0; $count = 0; @endphp

                            <tr class="hover:bg-gray-50 transition">

                                <!-- NAMA SISWA -->
                                <td class="border p-4 font-semibold bg-gray-100">
                                    {{ $siswa->name }}
                                </td>

                                <!-- NILAI PER TUGAS -->
                                @foreach($tugasList as $tugas)

                                    @php
                                        $nilai = $nilaiList
                                                ->where("tugas_id", $tugas->id)
                                                ->where("siswa_id", $siswa->id)
                                                ->first();
                                    @endphp

                                    <td class="border p-3 text-center">
                                        {{ $nilai->nilai ?? '-' }}

                                        @if($nilai)
                                            @php
                                                $total += $nilai->nilai;
                                                $count++;
                                            @endphp
                                        @endif
                                    </td>
                                @endforeach

                                <!-- RATA-RATA -->
                                <td class="border p-3 text-center font-bold bg-blue-50">
                                    {{ $count > 0 ? round($total/$count, 2) : '-' }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>

    </div>
</div>

@endsection
