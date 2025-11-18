@extends('layout.template.mainTemplate')

@section('container')

<div class="p-8 bg-gray-50 min-h-screen">

    <h1 class="text-3xl font-bold mb-6">
        📊 Rekap Nilai — {{ $kelasMapel->kelas->name }} / {{ $kelasMapel->mapel->name }}
    </h1>

    <table class="w-full border text-sm bg-white shadow rounded-xl overflow-hidden">

        <thead class="bg-gray-100 text-gray-700 font-semibold">
            <tr>
                <th class="p-3 border">Nama Siswa</th>

                @foreach($tugasList as $tugas)
                    <th class="p-3 border">{{ $tugas->judul }}</th>
                @endforeach

                <th class="p-3 border bg-blue-50">Rata-rata</th>
            </tr>
        </thead>

        <tbody>
            @foreach($siswaList as $siswa)

                @php $total = 0; $count = 0; @endphp

                <tr class="hover:bg-gray-50">

                    <td class="border p-3 font-semibold bg-gray-100">
                        {{ $siswa->name }}
                    </td>

                    @foreach($tugasList as $tugas)

                        @php
                            $nilai = $nilaiList
                                ->where("tugas_id", $tugas->id)
                                ->where("siswa_id", $siswa->id)
                                ->first();
                        @endphp

                        <td class="border p-2 text-center">
                            {{ $nilai->nilai ?? '-' }}

                            @if($nilai)
                                @php $total += $nilai->nilai; $count++; @endphp
                            @endif
                        </td>

                    @endforeach

                    <td class="border p-2 text-center font-bold bg-blue-50">
                        {{ $count > 0 ? round($total/$count,2) : '-' }}
                    </td>

                </tr>

            @endforeach
        </tbody>
    </table>

</div>

@endsection
