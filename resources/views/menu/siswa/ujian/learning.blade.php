@extends('layout.template.mainTemplate')

@section('container')
<section class="container py-5">


  {{--  Form Jawaban --}}
<form action="{{ route('ujian.answer.store', ['ujian' => $ujian->id, 'soal' => $soal->id]) }}" method="POST" class="learning flex flex-col gap-[50px] items-center mt-[50px] w-full pb-[30px]">
  @csrf
  <h1 class="max-w-[800px] font-extrabold text-[40px] sm:text-[46px] leading-[60px] sm:leading-[69px] text-center text-[#0A090B]">
    {{ $soal->soal }}
  </h1>

  <div class="flex flex-col gap-[30px] max-w-[750px] w-full">
    @foreach ($soal->answer as $index => $ans)
      <label for="answer{{ $index }}" class="group flex items-center justify-between rounded-full w-full border border-[#EEEEEE] p-[18px_20px] gap-[14px] transition-all duration-300 has-[:checked]:border-2 has-[:checked]:border-[#0A090B] cursor-pointer">
        <div class="flex items-center gap-[14px]">
          <img src="{{ asset('images/icons/arrow-circle-right.svg') }}" alt="icon">
          <span class="font-semibold text-lg sm:text-xl leading-[30px] text-[#0A090B]">
            <strong>{{ chr(65 + $index) }}.</strong> {{ $ans->jawaban }}
          </span>
        </div>
        <div class="hidden group-has-[:checked]:block">
          <img src="{{ asset('images/icons/tick-circle.svg') }}" alt="icon">
        </div>
        <input type="radio" name="answer_id" value="{{ $ans->id }}" id="answer{{ $index }}" class="hidden" required>
      </label>
    @endforeach
  </div>

  <button type="submit" class="w-fit p-[14px_40px] bg-[#6436F1] rounded-full font-bold text-sm sm:text-base text-white transition-all duration-300 hover:shadow-[0_4px_15px_0_#6436F14D] text-center align-middle">
    Save & Next Question
  </button>
</form>
</section>
@endsection