@extends('layout.template.mainTemplate')

@section('container')

   <div class="header flex justify-between items-center bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
  
  {{-- KIRI: Kelas dan Mapel --}}
  <div class="flex items-center gap-5">
  
    <a href="{{ route('ujian.soal.manage', ['ujian' => $ujian->id]) }}" 
   class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 border hover:bg-gray-100 hover:shadow transition">
  <i class="fa-solid fa-arrow-left text-gray-700 text-lg"></i>
</a>

    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B] leading-tight">
       {{ $kelasMapel->kelas->name }} 
      </h1>
      <p class="text-sm text-[#7F8190] font-medium mt-1">
     {{ $kelasMapel->mapel->name }} 
      </p>
    </div>
  </div>

  {{-- KANAN: Thumbnail dan Info Ujian --}}
  <div class="flex items-center gap-6">
    <div class="relative w-[120px] h-[120px]">
      <img src="{{ asset('images/thumbnail/Web-Development.png') }}" 
           class="w-full h-full object-contain" 
           alt="icon">
      <span class="absolute bottom-2 left-1/2 transform -translate-x-1/2 bg-[#FFF2E6] text-[#F6770B] text-xs font-bold px-3 py-1 rounded-full shadow-sm">
        Product Design
      </span>
    </div>

    <div class="flex flex-col justify-center">
      <h2 class="text-2xl font-extrabold text-[#0A090B]">{{ $ujian->name }}</h2>
      <div class="flex flex-wrap gap-4 mt-2 text-sm text-[#333]">
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-clock text-indigo-600"></i>
          <span>Durasi: <b>{{ $ujian->time }} Menit</b></span>
        </div>
        <div class="flex items-center gap-2">
          <i class="fa-regular fa-calendar-days text-pink-600"></i>
          <span>Deadline: <b>{{ \Carbon\Carbon::parse($ujian->due)->format('d M Y H:i') }}</b></span>
        </div>
      </div>
    </div>
  </div>

</div>
<div class="row p-4">
    <div class="col-12 col-lg-12">
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

   <form id="add-question" action="{{ route('ujian.soal.store', $ujian->id) }}" method="POST" class="flex flex-col gap-5">
    @csrf

    <h2 class="font-bold text-2xl">Add New Question</h2>

    {{-- Question --}}
    <div class="flex flex-col gap-[10px]">
      <p class="font-semibold">Question</p>
      <div
        class="flex items-center w-[500px] h-[52px] p-[14px_16px] rounded-full border border-[#EEEEEE] focus-within:border-2 focus-within:border-[#0A090B]">
        <div class="mr-[14px] w-6 h-6 flex items-center justify-center overflow-hidden">
          <img src="{{asset ('images/icons/note-text.svg')}}" class="h-full w-full object-contain" alt="icon">
            {{-- {{ asset('images/thumbnail/Web-Development.png') }} --}}
        </div>
        <input type="text" name="question"
               class="font-semibold placeholder:text-[#7F8190] placeholder:font-normal w-full outline-none bg-transparent"
               placeholder="Write the question" required>
      </div>
    </div>

    {{-- Answers --}}
    <div class="flex flex-col gap-[10px]">
      <p class="font-semibold">Answers</p>

      @for ($i = 0; $i < 4; $i++)
      <div class="flex items-center gap-4">
        <div
          class="flex items-center w-[500px] h-[52px] p-[14px_16px] rounded-full border border-[#EEEEEE] focus-within:border-2 focus-within:border-[#0A090B]">
          <div class="mr-[14px] w-6 h-6 flex items-center justify-center overflow-hidden">
            <img src="{{asset ('images/icons/edit.svg')}}" class="h-full w-full object-contain" alt="icon">
            
          </div>
          <input type="text" name="answers[]" required
                 class="font-semibold placeholder:text-[#7F8190] placeholder:font-normal w-full outline-none bg-transparent"
                 placeholder="Write better answer option">
        </div>

        <label class="font-semibold flex items-center gap-[10px]">
          <input
            type="radio"
            name="correct_answer"
            value="{{ $i }}"
            class="w-[24px] h-[24px] appearance-none rounded-full ring ring-[#EEEEEE] checked:bg-[#2B82FE] checked:border-[3px] checked:border-white"
            {{ $i === 0 ? 'required' : '' }} />
          Correct
        </label>
      </div>
      @endfor

    </div>

    {{-- Submit (jangan ubah route, hanya styling tombol) --}}
    <div>
      <button type="submit"
              class="w-[500px] h-[52px] p-[14px_20px] bg-[#6436F1] rounded-full font-bold text-white transition-all duration-300 hover:shadow-[0_4px_15px_0_#6436F14D]">
        Save Question
      </button>
    </div>
  </form>
    </div>
</div>
@endsection
