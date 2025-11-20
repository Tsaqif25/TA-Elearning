@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
    <div class="max-w-[1200px] mx-auto w-full px-5 lg:px-10 mt-8 mb-16">

        <!-- Back -->
        <a href="{{ route('ujian.soal.manage', $ujian->id) }}"
           class="flex items-center gap-2 text-[#2B82FE] hover:text-[#1a5fd4] mb-6 text-sm font-medium">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
        </a>

        <!-- Header -->
        <div class="bg-white border rounded-2xl shadow-sm p-6 mb-8">
            <h1 class="text-2xl font-extrabold">Edit Soal</h1>
            <p class="text-sm text-gray-500">{{ $kelasMapel->kelas->name }} — {{ $kelasMapel->mapel->name }}</p>
        </div>

        <div class="bg-white border rounded-2xl p-8 shadow-sm">

            <form action="{{ route('ujian.soal.update', [$ujian->id, $soal->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Pertanyaan -->
                <div class="mb-5">
                    <label class="text-sm font-semibold">Pertanyaan</label>
                    <textarea name="pertanyaan" required
                        class="w-full mt-2 p-3 border rounded-xl bg-[#F9FAFB]">{{ $soal->pertanyaan }}</textarea>
                </div>

                <!-- Options -->
                <div class="grid grid-cols-1 gap-4">
                    @foreach (['option_1','option_2','option_3','option_4','option_5'] as $index => $opt)
                        <div>
                            <label class="text-sm font-semibold">
                                Pilihan {{ chr(65 + $index) }}
                            </label>
                            <input type="text" name="{{ $opt }}" value="{{ $soal->$opt }}"
                                class="w-full mt-2 p-3 border rounded-xl bg-[#F9FAFB]">
                        </div>
                    @endforeach
                </div>

                <!-- Kunci Jawaban -->
                <div class="mt-5 mb-6">
                    <label class="text-sm font-semibold">Kunci Jawaban</label>
                    <select name="answer" required
                        class="w-full mt-2 p-3 border rounded-xl bg-[#F9FAFB]">
                        <option value="1" {{ $soal->answer == 1 ? 'selected' : '' }}>A</option>
                        <option value="2" {{ $soal->answer == 2 ? 'selected' : '' }}>B</option>
                        <option value="3" {{ $soal->answer == 3 ? 'selected' : '' }}>C</option>
                        <option value="4" {{ $soal->answer == 4 ? 'selected' : '' }}>D</option>
                        <option value="5" {{ $soal->answer == 5 ? 'selected' : '' }}>E</option>
                    </select>
                </div>

                <button class="bg-[#2B82FE] text-white px-6 py-2.5 rounded-full shadow hover:bg-blue-600">
                    Update Soal
                </button>
            </form>

        </div>

    </div>
</div>
@endsection
