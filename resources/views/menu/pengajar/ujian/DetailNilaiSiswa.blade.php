@extends('layout.template.mainTemplate')

@section('container')

<div class="flex flex-col w-full bg-[#FAFAFA] min-h-screen font-poppins">
  <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

    <!-- HEADER GRADIENT + BACK -->
    <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl p-6 sm:p-8 shadow-lg mb-8">

        <!-- Tombol Back -->
        <a href="{{ url()->previous() }}"
        class="flex items-center gap-2 text-white/90 hover:text-white font-medium text-sm mb-4 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Kembali ke Halaman Sebelumnya
        </a>

        <!-- Judul -->
        <h2 class="text-2xl sm:text-3xl font-extrabold leading-tight">
            Detail Jawaban: {{ $attempt->siswa->name }}
        </h2>

        <!-- Nilai -->
        <p class="text-sm opacity-90 mt-1">
            Nilai: <span class="font-bold">{{ $attempt->nilai }}</span>
        </p>

    </div>

    <!-- BODY DETAIL -->
    <div class="space-y-4">

        @foreach ($answers as $i => $ans)

        <div x-data="{ open: false }" class="border rounded-xl bg-white shadow">

            <!-- HEADER -->
            <button @click="open = !open"
                class="w-full flex justify-between items-center px-4 py-3">

                <div class="flex items-center gap-3">
                    <span class="w-7 h-7 flex items-center justify-center bg-gray-200 rounded-full">
                        {{ $i + 1 }}
                    </span>

                    <p class="font-semibold text-gray-900">{!! $ans->soal->pertanyaan !!}</p>
                </div>

                <div>
                    @if ($ans->is_corret)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">✔ Benar</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">✘ Salah</span>
                    @endif
                </div>
            </button>

            <!-- BODY -->
            <div x-show="open" x-collapse class="px-4 pb-4 space-y-3">

                <div>
                    <p class="text-sm text-gray-500">Jawaban Siswa:</p>
                    <div class="p-3 bg-gray-50 border rounded-lg">
                        {!! $ans->soal->{'option_'.$ans->answer} ?? 'Tidak dijawab' !!}
                    </div>
                </div>

                @if (!$ans->is_corret)
                <div>
                    <p class="text-sm text-gray-500">Jawaban Benar:</p>
                    <div class="p-3 bg-green-50 border border-green-300 rounded-lg text-green-700">
                        {!! $ans->soal->{'option_'.$ans->soal->answer} !!}
                    </div>
                </div>
                @endif

            </div>

        </div>

        @endforeach

    </div>

  </div>
</div>

<!-- Alpine -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

@endsection
