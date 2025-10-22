@extends('layout.template.mainTemplate')

@section('container')


   
<div class="flex flex-col w-full p-8 bg-[#F9FAFB] min-h-screen font-poppins ">

  @include('menu.kelasMapel.section.header')
   

  <!-- Mini Navbar -->
<div class="flex gap-6 px-6 border-b border-gray-200 overflow-x-auto">
  <button type="button" onclick="showTab('materi')" id="tab-materi" class="tab-active py-4 font-semibold whitespace-nowrap">Materi</button>
  <button type="button" onclick="showTab('tugas')" id="tab-tugas" class="tab-inactive py-4 font-semibold whitespace-nowrap hover:text-[#2B82FE] transition">Tugas</button>
  <button type="button" onclick="showTab('quiz')" id="tab-quiz" class="tab-inactive py-4 font-semibold whitespace-nowrap hover:text-[#2B82FE] transition">Quiz</button>
</div>


<!-- Materi -->
<div id="content-materi" class="tab-content block">
  @include('menu.kelasMapel.section.materi')
</div>

<!-- Tugas -->
<div id="content-tugas" class="tab-content hidden">
  @include('menu.kelasMapel.section.tugas')
</div>

<!-- Quiz -->
<div id="content-quiz" class="tab-content hidden">
  @include('menu.kelasMapel.section.quiz')
</div>

</div>





    
@endsection



{{-- Script JavaScript --}}
