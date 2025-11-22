@extends('layout.template.mainTemplate')

@section('container')
<div class="bg-gray-100 min-h-screen py-10 font-poppins">

    <div class="max-w-4xl mx-auto">

        <!-- CARD UTAMA -->
        <div class="bg-white p-8 rounded-2xl shadow">

            <!-- Judul -->
            <h2 class="text-2xl font-bold mb-6">
                Hasil Ujian: {{ $ujian->judul }}
            </h2>

            <!-- STATISTIK -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

                <!-- Nilai -->
                <div class="bg-blue-100 rounded-xl p-4 border border-blue-200">
                    <p class="text-sm font-semibold text-blue-700">Skor</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $attempt->nilai }}</p>
                </div>

                <!-- Benar -->
                <div class="bg-green-100 rounded-xl p-4 border border-green-200">
                    <p class="text-sm font-semibold text-green-700">Benar</p>
                    <p class="text-2xl font-bold text-green-700">
                        {{ $benar }} dari {{ count($answers) }}
                    </p>
                </div>

                <!-- Salah -->
                <div class="bg-red-100 rounded-xl p-4 border border-red-200">
                    <p class="text-sm font-semibold text-red-700">Salah</p>
                    <p class="text-2xl font-bold text-red-700">
                        {{ $salah }}
                    </p>
                </div>

                <!-- Akurasi -->
                <div class="bg-yellow-100 rounded-xl p-4 border border-yellow-200">
                    <p class="text-sm font-semibold text-yellow-700">Akurasi</p>
                    <p class="text-2xl font-bold text-yellow-700">
                        {{ round(($benar / count($answers)) * 100) }}%
                    </p>
                </div>
            </div>

            <!-- PROGRESS BAR -->
            <div class="mb-8">
                <p class="text-sm font-semibold mb-1">Progress Jawaban</p>
                <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
                    <div class="h-full bg-green-500"
                         style="width: {{ ($benar / count($answers)) * 100 }}%">
                    </div>
                </div>
            </div>

            <hr class="my-8">

            <!-- DETAIL JAWABAN -->
            <h3 class="text-xl font-bold mb-4">Detail Jawaban</h3>

            <div class="space-y-4">

                @foreach ($answers as $index => $ans)
                <div x-data="{ open: false }" class="border rounded-xl bg-white shadow-sm">

                    <!-- HEADER ACCORDION -->
                    <button
                        @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-4">

                        <!-- KIRI: Nomor + Pertanyaan -->
                        <div class="flex items-center gap-3 flex-1 text-left">
                            <span class="w-7 h-7 flex items-center justify-center
                                bg-gray-200 text-gray-700 rounded-full text-sm font-semibold">
                                {{ $index + 1 }}
                            </span>

                            <p class="font-semibold text-gray-900 leading-snug">
                                {!! $ans->soal->pertanyaan !!}
                            </p>
                        </div>

                        <!-- KANAN: Badge + Arrow -->
                        <div class="flex items-center gap-3 min-w-[120px] justify-end">

                            <!-- Badge Benar / Salah -->
                            @if ($ans->is_corret)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    ✔ Benar
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    ✘ Salah
                                </span>
                            @endif

                            <!-- Icon Arrow -->
                            <svg
                                :class="open ? 'rotate-180' : ''"
                                class="w-5 h-5 text-gray-500 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>

                        </div>

                    </button>

                    <!-- ISI COLLAPSE -->
                    <div x-show="open" x-collapse class="px-4 pb-4 mt-2 space-y-3">

                        <!-- Jawaban Anda -->
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Jawaban Anda:</p>
                            <div class="p-3 bg-gray-50 border rounded-lg">
                                {!! $ans->answer ? $ans->soal->{'option_'.$ans->answer} : 'Tidak dijawab' !!}
                            </div>
                        </div>

                        <!-- Kunci jika salah -->
                        @if (!$ans->is_corret)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Jawaban Benar:</p>
                            <div class="p-3 bg-green-50 border border-green-300 rounded-lg text-green-700">
                             {!! $ans->soal->{'option_'.$ans->soal->answer} !!}
                            </div>
                        </div>
                        @endif

                    </div>

                </div>
                @endforeach

            </div>

            <!-- BUTTON -->
            <a href="{{ route('dashboard') }}"
               class="mt-8 block bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-xl font-semibold">
                Kembali ke Dashboard
            </a>

        </div>
    </div>

</div>

<!-- Alpine -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Collapse Plugin -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

@endsection
