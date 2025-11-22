@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
    <div class="max-w-[1200px] mx-auto w-full px-5 sm:px-6 lg:px-10 mt-8 mb-16">

        <!-- 🔹 HEADER GRADIENT -->
        <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl p-6 sm:p-8 shadow-lg mb-8">

            <!-- Tombol Back -->
            <a href="{{ route('ujian.soal.manage', $ujian->id) }}"
               class="flex items-center gap-2 text-white/90 hover:text-white font-medium text-sm mb-4 transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali ke Soal
            </a>

            <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                Edit Soal
            </h1>

            <p class="text-sm opacity-90 mt-1">
                {{ $kelasMapel->kelas->name }} — {{ $kelasMapel->mapel->name }}
            </p>
        </div>

        <!-- 🔸 CARD FORM -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8">

            <form action="{{ route('ujian.soal.update', [$ujian->id, $soal->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Pertanyaan -->
                <div class="mb-6">
                    <label class="font-semibold text-sm text-gray-800 mb-1 block">Pertanyaan *</label>
                    <textarea name="pertanyaan" rows="3" required
                        class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:ring-2 focus:ring-blue-300/30 focus:border-blue-500 p-3 outline-none transition resize-none">{{ $soal->pertanyaan }}</textarea>
                </div>

                <!-- OPTIONS A–E -->
                @foreach (['option_1','option_2','option_3','option_4','option_5'] as $index => $opt)
                    <div class="mb-5">
                        <label class="font-semibold text-sm text-gray-800 mb-1 block">
                            Pilihan {{ chr(65 + $index) }}
                        </label>
                        <input type="text" 
                               name="{{ $opt }}" 
                               value="{{ $soal->$opt }}"
                               class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:ring-2 focus:ring-blue-300/30 focus:border-blue-500 p-3 outline-none transition">
                    </div>
                @endforeach

                <!-- Kunci Jawaban -->
                <div class="mb-8">
                    <label class="font-semibold text-sm text-gray-800 mb-1 block">Kunci Jawaban *</label>
                    <select name="answer" required
                        class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:ring-2 focus:ring-blue-300/30 focus:border-blue-500 p-3 outline-none transition">
                        <option value="1" {{ $soal->answer == 1 ? 'selected' : '' }}>A</option>
                        <option value="2" {{ $soal->answer == 2 ? 'selected' : '' }}>B</option>
                        <option value="3" {{ $soal->answer == 3 ? 'selected' : '' }}>C</option>
                        <option value="4" {{ $soal->answer == 4 ? 'selected' : '' }}>D</option>
                        <option value="5" {{ $soal->answer == 5 ? 'selected' : '' }}>E</option>
                    </select>
                </div>

                <!-- BUTTON -->
                <div class="flex justify-end">
                    <button
                        class="px-6 py-2.5 rounded-full bg-gradient-to-r from-[#2B82FE] to-[#1a5fd4] text-white font-semibold shadow hover:opacity-90 transition flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Update Soal
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>
@endsection
