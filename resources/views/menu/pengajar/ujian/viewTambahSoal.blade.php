@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col px-6 lg:px-10 mt-6">

  <!-- 🔹 Tombol Back -->
  <div class="mb-6">
    <a href="{{ route('ujian.soal.manage', $ujian->id) }}"
       class="flex items-center gap-2 text-[#2B82FE] hover:text-[#1a5fd4] font-medium text-sm transition">
      <i class="fa-solid fa-arrow-left text-xs"></i>
      Kembali ke Daftar Soal
    </a>
  </div>

  <!-- Header Quiz Info -->
  <div class="bg-white border border-[#EEEEEE] rounded-2xl p-6 flex flex-col sm:flex-row justify-between items-center gap-5 shadow-sm">
    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B]">{{ $ujian->name }}</h1>
      <p class="text-sm text-[#7F8190]">Tambah pertanyaan baru untuk quiz ini</p>
    </div>

    <div class="flex items-center gap-4">
      <div class="flex flex-col text-right">
        <p class="text-sm font-medium text-[#7F8190]">Durasi: <span class="text-[#0A090B] font-semibold">{{ $ujian->time }} Menit</span></p>
        <p class="text-sm font-medium text-[#7F8190]">Deadline: <span class="text-[#0A090B] font-semibold">{{ \Carbon\Carbon::parse($ujian->due)->format('d M Y H:i') }}</span></p>
      </div>
      <div class="w-[80px] h-[80px] bg-gradient-to-r from-[#2B82FE] to-[#1E3A8A] rounded-2xl flex items-center justify-center shadow">
        <i class="fa-solid fa-clipboard-question text-white text-3xl"></i>
      </div>
    </div>
  </div>

  <!-- Form Section -->
  <div class="mt-6 bg-white border border-[#EEEEEE] rounded-2xl shadow-sm p-6 sm:p-10 flex flex-col gap-6">

    <form id="add-question" action="{{ route('ujian.soal.store', $ujian->id) }}" method="POST" class="flex flex-col gap-6">
      @csrf

      <h2 class="font-bold text-2xl text-[#0A090B]">Add New Question</h2>

      <!-- Question Input -->
      <div class="flex flex-col gap-[10px]">
        <p class="font-semibold">Question</p>
        <div class="flex items-center w-full sm:w-[550px] h-[52px] p-[14px_16px] rounded-full border border-[#EEEEEE] focus-within:border-2 focus-within:border-[#0A090B] transition">
          <div class="mr-[14px] w-6 h-6 flex items-center justify-center overflow-hidden">
            <img src="{{ asset('images/icons/note-text.svg') }}" class="h-full w-full object-contain" alt="icon">
          </div>
          <input type="text" name="question" required
                 class="font-semibold placeholder:text-[#7F8190] placeholder:font-normal w-full outline-none bg-transparent"
                 placeholder="Write the question">
        </div>
      </div>

      <!-- Answers Section -->
      <div class="flex flex-col gap-[10px]">
        <p class="font-semibold">Answers</p>

        @for ($i = 0; $i < 4; $i++)
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
          <div class="flex items-center w-full sm:w-[550px] h-[52px] p-[14px_16px] rounded-full border border-[#EEEEEE] focus-within:border-2 focus-within:border-[#0A090B] transition">
            <div class="mr-[14px] w-6 h-6 flex items-center justify-center overflow-hidden">
              <img src="{{ asset('images/icons/edit.svg') }}" class="h-full w-full object-contain" alt="icon">
            </div>
            <input type="text" name="answers[]" required
                   class="font-semibold placeholder:text-[#7F8190] placeholder:font-normal w-full outline-none bg-transparent"
                   placeholder="Write better answer option">
          </div>

          <label class="font-semibold flex items-center gap-[10px] text-sm text-[#0A090B]">
            <input type="radio" name="correct_answer" value="{{ $i }}" class="w-[22px] h-[22px] appearance-none rounded-full ring ring-[#EEEEEE] checked:bg-[#2B82FE] checked:border-[3px] checked:border-white cursor-pointer" {{ $i === 0 ? 'required' : '' }}/>
            Correct
          </label>
        </div>
        @endfor
      </div>

      <!-- Submit Button -->
      <div class="pt-3">
        <button type="submit"
                class="w-full sm:w-[550px] h-[52px] bg-gradient-to-r from-[#6436F1] to-[#4F3CF1] rounded-full font-semibold text-white transition-all duration-300 hover:shadow-[0_4px_15px_0_#6436F14D] hover:scale-[1.02]">
          <i class="fa-solid fa-paper-plane mr-2"></i> Save Question
        </button>
      </div>
    </form>
  </div>
</div>

@endsection