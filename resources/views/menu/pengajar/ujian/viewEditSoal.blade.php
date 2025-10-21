@extends('layout.template.mainTemplate')

@section('container')

<div class="header flex justify-between items-center bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
    <div class="flex items-center gap-5">
        <a href="{{ route('ujian.soal.manage', $ujian->id) }}"
           class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 border hover:bg-gray-100 hover:shadow transition">
            <i class="fa-solid fa-arrow-left text-gray-700 text-lg"></i>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-[#0A090B]">{{ $kelasMapel->kelas->name }}</h1>
            <p class="text-sm text-[#7F8190] font-medium mt-1">{{ $kelasMapel->mapel->name }}</p>
        </div>
    </div>
</div>

<div class="p-6">
    <form action="{{ route('ujian.soal.update', [$ujian->id, $soal->id]) }}" method="POST" class="flex flex-col gap-5">
        @csrf
        @method('PUT')

        <h2 class="font-bold text-2xl">Edit Question</h2>

        {{-- Pertanyaan --}}
        <div class="flex flex-col gap-[10px]">
            <p class="font-semibold">Question</p>
            <input type="text" name="question"
                value="{{ old('question', $soal->soal) }}"
                class="w-[500px] border p-3 rounded-full"
                required>
        </div>

        {{-- Jawaban --}}
        <div class="flex flex-col gap-[10px]">
            <p class="font-semibold">Answers</p>
            @foreach ($soal->answer as $i => $ans)
                <div class="flex items-center gap-4">
                    <input type="text" name="answers[]" value="{{ $ans->jawaban }}"
                           class="w-[500px] border p-3 rounded-full" required>

                    <label class="font-semibold flex items-center gap-[10px]">
                        <input type="radio" name="correct_answer" value="{{ $i }}"
                               {{ $ans->is_correct ? 'checked' : '' }}
                               class="w-[24px] h-[24px] appearance-none rounded-full ring ring-[#EEEEEE] checked:bg-[#2B82FE]" />
                        Correct
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit"
                class="w-[500px] h-[52px] bg-[#6436F1] rounded-full text-white font-bold">
            Update Question
        </button>
    </form>
</div>

@endsection
