@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] min-h-screen font-poppins">
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

        <!-- BACK BUTTON -->
        <a href="{{ route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel->id,
            'kelas' => $kelasMapel->kelas->id,
            'tab' => 'quiz'
        ]) }}"
           class="flex items-center gap-2 text-[#2B82FE] hover:text-[#1a5fd4] font-medium text-sm mb-6">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Kembali ke Daftar Quiz
        </a>

        <!-- HEADER -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0A090B] leading-tight">
                Edit Ujian
            </h1>
            <p class="text-sm text-[#7F8190]">Perbarui detail ujian untuk kelas ini.</p>
        </div>

        <!-- FORM -->
        <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-6 sm:p-8">

            @if ($errors->any())
                <div class="mb-4 p-4 rounded-2xl border-2 border-red-200 bg-red-50">
                    <ul class="mb-0 text-sm text-red-700 list-disc pl-5">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('ujian.update', $ujian->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Kelas Mapel -->
        

                <!-- Judul -->
                <div class="mb-5">
                    <label class="font-semibold text-sm">Judul Quiz *</label>
                    <input type="text" name="judul" required
                           value="{{ $ujian->judul }}"
                           class="w-full p-3 rounded-xl border border-gray-200 bg-[#F9FAFB]">
                </div>

                <!-- Deskripsi -->
                <div class="mb-5">
                    <label class="font-semibold text-sm">Deskripsi *</label>
                    <textarea name="deskripsi" rows="3" required
                              class="w-full p-3 rounded-xl border border-gray-200 bg-[#F9FAFB]">{{ $ujian->deskripsi }}</textarea>
                </div>

                <!-- Durasi -->
                <div class="mb-8">
                    <label class="font-semibold text-sm">Durasi (menit) *</label>
                    <input type="number" name="durasi" required
                           value="{{ $ujian->durasi_menit }}"
                           class="w-full p-3 rounded-xl border border-gray-200 bg-[#F9FAFB]">
                </div>

                <!-- BUTTON -->
                <div class="flex justify-end gap-3">
                    <a href="{{ url()->previous() }}"
                       class="px-5 py-2.5 rounded-full border border-gray-300 text-gray-600 font-semibold">
                        Batal
                    </a>

                    <button type="submit"
                            class="px-6 py-2.5 rounded-full bg-gradient-to-r from-[#2B82FE] to-[#1a5fd4] text-white font-semibold shadow">
                        Update Ujian
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection
