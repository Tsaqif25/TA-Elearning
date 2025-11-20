@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">

    <div class="max-w-[900px] w-full mx-auto px-6 mt-12">

        <!-- CARD -->
        <div class="bg-white rounded-2xl shadow p-8 border border-gray-100">

            <!-- Judul -->
            <h2 class="text-2xl font-bold text-[#0A090B] mb-4">
                Informasi Ujian
            </h2>

            <!-- Info Ujian -->
            <div class="space-y-3 text-[#333] text-sm">
                <p><span class="font-semibold">Judul:</span> {{ $ujian->judul }}</p>
                <p><span class="font-semibold">Jumlah Soal:</span> {{ $ujian->soal->count() }} soal</p>
            </div>

            <hr class="my-6">

            <!-- Tombol Mulai -->
            <a href="{{ route('ujian.start', $ujian->id) }}"
                class="w-full text-center block bg-[#2B82FE] text-white py-3 rounded-xl font-semibold hover:bg-[#1a6ae0] transition">
                Mulai Ujian
            </a>

            <!-- Tombol Kembali -->
            <a href="javascript:history.back()"
                class="w-full text-center block mt-3 text-[#2B82FE] hover:underline text-sm font-medium">
                Kembali
            </a>

        </div>

    </div>

</div>
@endsection
