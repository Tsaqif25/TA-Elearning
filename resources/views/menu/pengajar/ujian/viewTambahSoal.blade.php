@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
    <div class="max-w-[1200px] mx-auto w-full px-5 lg:px-10 mt-8 mb-16">

        <!-- Back -->
        <a href="{{ route('ujian.soal.manage', $ujian->id) }}"
           class="flex items-center gap-2 text-[#2B82FE] hover:text-[#1a5fd4] mb-6 text-sm font-medium">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Soal
        </a>

        <!-- Header -->
        <div class="bg-white border rounded-2xl shadow-sm p-6 mb-8">
            <h1 class="text-2xl font-extrabold text-[#0A090B] mb-1">Tambah Soal</h1>
            <p class="text-sm text-gray-500">{{ $kelas->name }} — {{ $mapel->name }}</p>
        </div>

        <div class="bg-white border rounded-2xl shadow-sm p-8">

            <form action="{{ route('ujian.soal.store', $ujian->id) }}" method="POST">
                @csrf

                <!-- Pertanyaan -->
                <div class="mb-5">
                    <label class="font-semibold text-sm">Pertanyaan</label>
                    <textarea name="pertanyaan" required
                        class="w-full mt-2 p-3 border rounded-xl bg-[#F9FAFB] focus:ring-2 focus:ring-blue-300"></textarea>
                </div>

                <!-- Options -->
                @for ($i = 1; $i <= 5; $i++)
                    <div class="mb-4">
                        <label class="text-sm font-semibold">Pilihan {{ chr(64 + $i) }}</label>
                        <input type="text" name="option_{{ $i }}" 
                               class="w-full mt-2 p-3 border rounded-xl bg-[#F9FAFB]">
                    </div>
                @endfor

                <!-- Kunci Jawaban -->
                <div class="mb-6">
                    <label class="text-sm font-semibold">Kunci Jawaban</label>
                    <select name="answer" required
                        class="w-full mt-2 p-3 border rounded-xl bg-[#F9FAFB]">
                        <option value="">-- Pilih --</option>
                        <option value="1">A</option>
                        <option value="2">B</option>
                        <option value="3">C</option>
                        <option value="4">D</option>
                        <option value="5">E</option>
                    </select>
                </div>

                <button class="bg-[#2B82FE] text-white px-6 py-2.5 rounded-full shadow hover:bg-blue-600">
                    Simpan Soal
                </button>
            </form>

        </div>

    </div>
</div>
@endsection
