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
      <p class="text-[#7F8190] text-sm">{{ $mapel->name}}</p>
    </div>
    {{-- <a href="#" 
      class="flex items-center gap-2 px-5 py-2 border border-[#0A090B] rounded-full text-sm font-semibold text-[#0A090B] hover:bg-[#0A090B] hover:text-white transition">
      <i class="fa-regular fa-user"></i> Lihat Siswa
    </a> --}}
    <a href="{{ route('viewKelasMapel', [
    'mapel' => $mapel->id,
    'kelas' => $kelas->id,
    'tab'   => 'siswa'
]) }}" 
class="flex items-center gap-2 px-5 py-2 border border-[#0A090B] rounded-full text-sm font-semibold text-[#0A090B] hover:bg-[#0A090B] hover:text-white transition">
  <i class="fa-regular fa-user"></i> Lihat Siswa
</a>
{{-- TAB SISWA --}}
@if (request('tab') == 'siswa')
  <div id="siswa" class="tab-content">
    <h2 class="text-2xl font-bold text-[#0A090B] mb-6">Daftar Siswa</h2>

    <div class="bg-white border-2 border-black rounded-xl p-6 shadow-sm">
      <table class="min-w-full border-collapse text-sm">
        <thead class="bg-gray-100 border-b-2 border-black">
          <tr>
            <th class="py-3 px-4 text-left">#</th>
            <th class="py-3 px-4 text-left">Nama</th>
            <th class="py-3 px-4 text-left">Email</th>
            <th class="py-3 px-4 text-left">Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($kelas->users as $siswa)
            <tr class="border-b hover:bg-gray-50">
              <td class="py-3 px-4">{{ $loop->iteration }}</td>
              <td class="py-3 px-4 font-medium">{{ $siswa->name }}</td>
              <td class="py-3 px-4 text-gray-500">{{ $siswa->email }}</td>
              <td class="py-3 px-4">
                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Aktif</span>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center py-5 text-red-500 font-semibold">
                Tidak ada siswa di kelas ini
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endif

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
  (function() {
    // --- Tab handling (single source of truth) ---
    const tabs = document.querySelectorAll('.tab-link');
    const contents = document.querySelectorAll('.tab-content');

    function activateTab(targetId) {
      if (!targetId) return;
      // Reset semua tab (tampilan)
      tabs.forEach(btn => {
        const match = btn.getAttribute('data-target') === `#${targetId}`;
        if (match) {
          btn.classList.add('bg-[#6C63FF]', 'text-white', 'shadow-sm');
          btn.classList.remove('text-[#7F8190]');
        } else {
          btn.classList.remove('bg-[#6C63FF]', 'text-white', 'shadow-sm');
          btn.classList.add('text-[#7F8190]');
        }
      });

      // Sembunyikan semua konten lalu tampilkan konten aktif (jika ada)
      contents.forEach(content => content.classList.add('hidden'));
      const activeContent = document.querySelector(`#${targetId}`);
      if (activeContent) activeContent.classList.remove('hidden');
    }

    // Klik tab -> aktivasi + update URL tanpa reload
    tabs.forEach(tab => {
      tab.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = tab.getAttribute('data-target').substring(1);
        activateTab(targetId);

        // Update query param 'tab' di URL (tanpa reload)
        try {
          const url = new URL(window.location);
          url.searchParams.set('tab', targetId);
          window.history.replaceState({}, '', url);
        } catch (err) {
          // fallback jika environment tidak mendukung URL()
          console.warn('Unable to update URL:', err);
        }
      });
    });

    // Saat halaman dimuat: baca param ?tab=... atau default 'materi'
    window.addEventListener('DOMContentLoaded', () => {
      const urlParams = new URLSearchParams(window.location.search);
      const activeTab = urlParams.get('tab') || 'materi';
      activateTab(activeTab);
    });

    // --- Utility functions for modals/forms (single definitions) ---
    window.changeValueMateri = function(itemId) {
      console.log('changeValueMateri', itemId);
      const materiId = document.getElementById('materiId');
      const kelasMapelMateri = document.getElementById('kelasMapelMateri');
      if (materiId) materiId.value = itemId;
      if (kelasMapelMateri) kelasMapelMateri.value = "{{ $kelasMapel->id ?? '' }}";
    };

    window.changeValuePengumuman = function(itemId) {
      console.log('changeValuePengumuman', itemId);
      const pengumumanId = document.getElementById('pengumumanId');
      const kelasMapelPengumuman = document.getElementById('kelasMapelPengumuman');
      if (pengumumanId) pengumumanId.value = itemId;
      if (kelasMapelPengumuman) kelasMapelPengumuman.value = "{{ $kelasMapel->id ?? '' }}";
    };

    // single definition for changeValueTugas
    window.changeValueTugas = function(itemId) {
      console.log('changeValueTugas', itemId);
      const tugasId = document.getElementById('tugasId');
      const kelasMapelTugas = document.getElementById('kelasMapelTugas');
      if (tugasId) tugasId.value = itemId;
      if (kelasMapelTugas) kelasMapelTugas.value = "{{ $kelasMapel->id ?? '' }}";
    };

    window.changeValueUjian = function(itemId, tipe) {
      console.log('changeValueUjian', itemId, tipe);
      const ujianId = document.getElementById('ujianId');
      const tipeId = document.getElementById('tipe');
      const kelasMapelUjian = document.getElementById('kelasMapelUjian');
      if (ujianId) ujianId.value = itemId;
      if (tipeId) tipeId.value = tipe;
      if (kelasMapelUjian) kelasMapelUjian.value = "{{ $kelasMapel->id ?? '' }}";
    };
  })();
</script>


    
@endsection

{{-- Script JavaScript --}}
