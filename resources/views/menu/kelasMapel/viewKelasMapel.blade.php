@extends('layout.template.mainTemplate')

@section('container')

<div class="font-poppins bg-slate-50 min-h-screen">

  <!-- 🔙 Tombol Kembali -->
  {{-- <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <a href="{{ route('kelasMapel.index') }}" 
       class="flex items-center gap-2 text-sm text-blue-600 hover:underline">
      ← Kembali ke Daftar Mata Pelajaran
    </a>
  </div> --}}

  <!-- 🌈 Header Mapel -->
  @include('menu.kelasMapel.section.header')

  <!-- 🧭 Tab Menu -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">

      <!-- Tab Header -->
      <div class="flex border-b text-sm font-medium text-gray-600">
        
        <!-- Materi -->
        <button type="button" onclick="showTab('materi')" id="tab-materi"
  class="tab-active w-1/3 py-3 flex items-center justify-center gap-2 font-semibold">
  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24"
    stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
  </svg>
  Materi
</button>


        <!-- Tugas -->
        <button type="button" onclick="showTab('tugas')" id="tab-tugas"
          class="tab-inactive w-1/3 py-3 flex items-center justify-center gap-2 text-gray-600 hover:text-blue-600 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 9h8m-8 4h6m2 5H8a2 2 0 01-2-2V7a2 2 0 012-2h7l5 5v9a2 2 0 01-2 2z" />
          </svg>
          Tugas
        </button>

        <!-- Ujian -->
        <button type="button" onclick="showTab('quiz')" id="tab-quiz"
          class="tab-inactive w-1/3 py-3 flex items-center justify-center gap-2 text-gray-600 hover:text-blue-600 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-3-3v6m9-9v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h12a2 2 0 012 2z" />
          </svg>
          Quiz
        </button>

      </div>

      <!-- 🧩 Konten Tiap Tab -->
      <div class="p-6">
        <div id="content-materi" class="tab-content block">
          @include('menu.kelasMapel.section.materi')
        </div>
        <div id="content-tugas" class="tab-content hidden">
          @include('menu.kelasMapel.section.tugas')
        </div>
        <div id="content-quiz" class="tab-content hidden">
          @include('menu.kelasMapel.section.quiz')
        </div>
      </div>
    </div>
  </section>

</div>

@endsection
