@extends('layout.template.mainTemplate')

@section('container')
<div class="w-full bg-gray-100 py-8 font-poppins">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- ====================== -->
        <!--  BAGIAN SOAL (KIRI)    -->
        <!-- ====================== -->
        <div class="md:col-span-2">
            <div class="bg-white shadow rounded-xl p-6">

                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">
                        Soal No. {{ $nomor }}
                    </h2>
                </div>

                <!-- Soal -->
                <div class="text-gray-800 mb-6">
                    {!! $soal->pertanyaan !!}
                </div>

                <!-- Pilihan Jawaban -->
                <form action="{{ route('ujian.answer.store', [$attempt->id, $soal->id]) }}" method="POST">
                    @csrf

                    @php
                        $labels = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E'];
                    @endphp

                    @foreach ([1,2,3,4,5] as $num)
                        @php
                            $field = 'option_' . $num;
                            if (!$soal->$field) continue;
                            $selected = $jawaban?->answer == $num;
                            $label = $labels[$num];
                        @endphp

                        <label class="flex items-start gap-3 mb-3 cursor-pointer">
                            <div class="w-8 h-8 flex items-center justify-center border rounded-full font-semibold
                                {{ $selected ? 'bg-blue-500 text-white border-blue-500' : 'border-gray-400 text-gray-700' }}">
                                {{ $label }}
                            </div>

                            <input 
                                type="radio"
                                name="answer"
                                value="{{ $num }}"
                                class="hidden"
                                onchange="this.form.submit()"
                                {{ $selected ? 'checked' : '' }}
                            >

                            <div class="mt-1 text-gray-800">
                                {!! $soal->$field !!}
                            </div>
                        </label>
                    @endforeach
                </form>

                <!-- Navigasi Soal -->
                <div class="flex justify-between mt-8">
                    @if ($nomor > 1)
                        <a href="{{ route('ujian.show', [$attempt->id, $nomor - 1]) }}"
                           class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300">
                            Sebelumnya
                        </a>
                    @else
                        <button class="px-4 py-2 bg-gray-200 rounded-lg text-gray-400" disabled>Sebelumnya</button>
                    @endif

                    @if ($nomor < $totalSoal)
                        <a href="{{ route('ujian.show', [$attempt->id, $nomor + 1]) }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Selanjutnya
                        </a>
                    @endif
                </div>

            </div>
        </div>

        <!-- ====================== -->
        <!--  NAVIGASI (KANAN)      -->
        <!-- ====================== -->
        <div>
            <div class="bg-white shadow rounded-xl p-6">

                <div class="text-center mb-4">
                    <span class="px-3 py-1.5 text-sm bg-green-100 text-green-700 rounded-full">
                        {{ $attempt->answers()->whereNotNull('answer')->count() }} dikerjakan
                    </span>
                </div>

                <div class="grid grid-cols-5 gap-3 max-h-64 overflow-y-auto">
                    @for ($i = 1; $i <= $totalSoal; $i++)
                        @php
                            $ans = $attempt->answers()->skip($i-1)->first();
                            $answered = $ans?->answer != null;
                        @endphp

                        <a href="{{ route('ujian.show', [$attempt->id, $i]) }}"
                           class="text-center py-2 rounded-lg border
                           @if ($i == $nomor)
                                bg-gray-400 text-white border-gray-500
                           @elseif ($answered)
                                bg-blue-500 text-white border-blue-500
                           @else
                                border-blue-400 text-blue-500
                           @endif
                           ">
                            {{ $i }}
                        </a>
                    @endfor
                </div>

                <div class="mt-6">
                    <a href="{{ route('ujian.finish', ['attempt' => $attempt->id]) }}"
                       class="block w-full text-center bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700">
                        Akhiri Ujian
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
