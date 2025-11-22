@extends('layout.template.mainTemplate')

@section('container')

<div class="flex flex-col w-full bg-[#FAFAFA] min-h-screen font-poppins">
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

        <!--  HEADER GRADIENT + BACK -->
        <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl p-6 sm:p-8 shadow-lg mb-8">

            <!--  Tombol Back DI DALAM HEADER -->
            <a href="{{ route('viewKelasMapel', [
                'mapel' => $kelasMapel->mapel->id,
                'kelas'  => $kelasMapel->kelas->id,
                'tab'    => 'quiz'
            ]) }}"
               class="flex items-center gap-2 text-white/90 hover:text-white font-medium text-sm mb-4 transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali ke Daftar Quiz
            </a>

            <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                Edit Quiz
            </h1>
            <p class="text-sm opacity-90 mt-1">
                Perbarui detail quiz untuk kelas ini.
            </p>
        </div>

        <!--  CARD FORM -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">

            @if ($errors->any())
                <div class="mb-5 p-4 rounded-2xl border-2 border-red-200 bg-red-50">
                    <ul class="pl-5 list-disc text-sm text-red-700">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('ujian.update', $ujian->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Judul -->
                <div class="mb-5">
                    <label class="font-semibold text-sm text-gray-800 mb-1 block">Judul Quiz *</label>
                    <input type="text" name="judul" required
                        value="{{ $ujian->judul }}"
                        class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] p-3
                               focus:ring-2 focus:ring-[#2B82FE]/20 focus:border-[#2B82FE]
                               outline-none transition">
                </div>

                <!-- Deskripsi -->
                <div class="mb-5">
                    <label class="font-semibold text-sm text-gray-800 mb-1 block">Deskripsi *</label>
                    <textarea name="deskripsi" rows="3" required
                        class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] p-3
                               focus:ring-2 focus:ring-[#2B82FE]/20 focus:border-[#2B82FE]
                               outline-none transition resize-none">{{ $ujian->deskripsi }}</textarea>
                </div>

               

                <!-- Tombol -->
                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ url()->previous() }}"
                        class="px-5 py-2.5 rounded-full border border-gray-300 text-gray-700 font-semibold
                               hover:bg-gray-100 transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="px-6 py-2.5 rounded-full bg-gradient-to-r from-[#2B82FE] to-[#1a5fd4]
                               text-white font-semibold shadow hover:opacity-90 transition flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Update Quiz
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection
