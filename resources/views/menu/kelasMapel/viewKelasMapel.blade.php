@extends('layout.template.mainTemplate')

@section('container')

    {{-- Navigasi Breadcrumb --}}
    <div class="col-12 ps-4 pe-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $mapel->name}}</li>
            </ol>
        </nav>
    </div>

   
<div class="flex flex-col w-full p-8 bg-[#F9FAFB] min-h-screen font-poppins border-2 border-black rounded-2xl">
  <!-- Header Kelas -->
  <div class="flex justify-between items-center mb-8">
    <div>
      <h1 class="text-3xl font-extrabold text-[#0A090B]">{{ $kelas->name }}</h1>
      <p class="text-[#7F8190] text-sm">👥 32 Siswa</p>
    </div>
    <a href="#" 
      class="flex items-center gap-2 px-5 py-2 border border-[#0A090B] rounded-full text-sm font-semibold text-[#0A090B] hover:bg-[#0A090B] hover:text-white transition">
      <i class="fa-regular fa-user"></i> Lihat Siswa
    </a>
  </div>

  <!-- Mini Navbar -->
  <div class="flex gap-3 bg-[#F1F1F1] p-2 rounded-full mb-8 w-fit">
    <button class="tab-link px-8 py-2 rounded-full border-1 border-[#7F8190] font-semibold bg-[#6C63FF] text-white transition shadow-sm" data-target="#materi">Materi</button>
    <button class="tab-link px-8 py-2 rounded-full border-1 border-[#7F8190] font-semibold text-[#7F8190] hover:bg-[#E9E9E9]" data-target="#tugas">Tugas</button>
    <button class="tab-link px-8 py-2 rounded-full border-1 border-[#7F8190] font-semibold text-[#7F8190] hover:bg-[#E9E9E9]" data-target="#quiz">Quiz</button>
  </div>

  <!-- Section Materi -->
  @include('menu.kelasMapel.materi-section')
@include('menu.kelasMapel.tugas-section')
@include('menu.kelasMapel.quiz-section')
</div>


<script>
  const tabs = document.querySelectorAll('.tab-link');
  const contents = document.querySelectorAll('.tab-content');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      // Reset semua tab
      tabs.forEach(btn => {
        btn.classList.remove('bg-[#6C63FF]', 'text-white', 'shadow-sm');
        btn.classList.add('text-[#7F8190]', 'hover:bg-[#E9E9E9]');
      });

      // Aktifkan tab yang diklik
      tab.classList.add('bg-[#6C63FF]', 'text-white', 'shadow-sm');
      tab.classList.remove('text-[#7F8190]', 'hover:bg-[#E9E9E9]');

      // Sembunyikan semua konten lalu tampilkan konten aktif
      contents.forEach(content => content.classList.add('hidden'));
      document.querySelector(tab.getAttribute('data-target')).classList.remove('hidden');
    });
  });
</script>



    <script>
        function changeValueTugas(id) {
            document.getElementById('idTugas').value = id;
        }

        function changeValueMateri(itemId) {
            console.log(itemId);
            const materiId = document.getElementById('materiId');
            const kelasMapelMateri = document.getElementById('kelasMapelMateri');
            materiId.setAttribute('value', itemId);
            kelasMapelMateri.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        }


        function changeValuePengumuman(itemId) {
            console.log(itemId);
            const pengumumanId = document.getElementById('pengumumanId');
            const kelasMapelPengumuman = document.getElementById('kelasMapelPengumuman');
            pengumumanId.setAttribute('value', itemId);
            kelasMapelPengumuman.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        }

        function changeValueTugas(itemId) {
            console.log(itemId);
            const tugasId = document.getElementById('tugasId');
            const kelasMapelTugas = document.getElementById('kelasMapelTugas');
            tugasId.setAttribute('value', itemId);
            kelasMapelTugas.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        }

        function changeValueUjian(itemId, tipe) {
            console.log(itemId);
            console.log(tipe);
            const ujianId = document.getElementById('ujianId');
            const tipeId = document.getElementById('tipe');
            const kelasMapelUjian = document.getElementById('kelasMapelUjian');
            ujianId.setAttribute('value', itemId);
            tipeId.setAttribute('value', tipe);
            kelasMapelUjian.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        }
    </script>
@endsection

{{-- Script JavaScript --}}
