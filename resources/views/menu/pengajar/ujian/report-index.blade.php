@extends('layout.template.mainTemplate')

@section('container')
<div class="p-6">

    <h2 class="text-2xl font-bold mb-4">Rekap Nilai Ujian Anda</h2>

    @if ($ujians->isEmpty())
        <p class="text-gray-500">Belum ada ujian.</p>
    @endif

    <div class="space-y-4">
        @foreach($ujians as $ujian)
            <div class="p-4 bg-white rounded-xl shadow">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $ujian->judul }}</h3>
                        {{-- <p class="text-sm text-gray-500">
                            Kelas: {{ $ujian->kelas->name }} — Mapel: {{ $ujian->mapel->name }}
                        </p> --}}
                    </div>

                    <a href="{{ route('guru.ujian.report.show', $ujian->id) }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Lihat Rekap
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
