@extends('layout.template.mainTemplate')

@section('container')
<div class="w-full bg-gray-100 min-h-screen font-poppins py-10">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-8">

        <h2 class="text-2xl font-bold text-center mb-6">
            Hasil Ujian: {{ $ujian->judul }}
        </h2>

        <div class="space-y-3 text-gray-700 mb-6">
            <p><strong>Mulai:</strong> {{ $attempt->mulai }}</p>
            <p><strong>Selesai:</strong> {{ $attempt->selesai }}</p>
            <p><strong>Nilai:</strong> 
                <span class="text-blue-600 font-bold text-xl">
                    {{ $attempt->nilai }}
                </span>
            </p>
        </div>

        <hr class="my-6">

        <h3 class="text-xl font-semibold mb-3">Detail Jawaban</h3>

        <div class="space-y-4">
            @foreach ($answers as $index => $ans)
                <div class="p-4 border rounded-lg">
                    <p class="font-semibold">Soal {{ $index + 1 }}:</p>
                    <p class="mb-2">{!! $ans->soal->pertanyaan !!}</p>

                    <p>
                        Jawaban Kamu: 
                        <strong>{{ $ans->answer ?: 'Tidak dijawab' }}</strong>
                    </p>
                    <p>
                        Status: 
                        @if ($ans->is_corret)
                            <span class="text-green-600 font-bold">Benar</span>
                        @else
                            <span class="text-red-600 font-bold">Salah</span>
                        @endif
                    </p>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            <a href="{{ route('dashboard') }}"
               class="block text-center bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700">
                Kembali ke Dashboard
            </a>
        </div>

    </div>
</div>
@endsection
