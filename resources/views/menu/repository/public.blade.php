@extends('layout.template.publicTemplate')

@section('container')
<!-- =========================
     NAVBAR
========================= -->
<nav class="w-full bg-white border-b border-gray-100 shadow-sm fixed top-0 left-0 z-50">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 py-4 flex justify-between items-center">
    <div class="flex items-center gap-2">
      <i class="fa-solid fa-graduation-cap text-[#2B82FE] text-xl"></i>
      <h1 class="text-lg font-bold text-[#0A090B]">E-Learning SMK 2 Padang</h1>
    </div>

    <a href="{{ route('login') }}"
       class="bg-[#2B82FE] hover:bg-[#1D4ED8] text-white px-5 py-2 rounded-full font-semibold text-sm transition">
      Login
    </a>
  </div>
</nav>

<!-- =========================
     CONTENT
========================= -->
<div class="flex flex-col w-full px-6 lg:px-12 py-24 bg-[#FAFAFA] min-h-screen font-poppins">

  <!-- Header -->
  <div class="mb-8 text-center">
    <h1 class="text-3xl sm:text-4xl font-extrabold text-[#0A090B]">Repository Materi SMK</h1>
    <p class="text-sm text-[#7F8190] mt-2">
      Kumpulan lengkap materi pembelajaran dari kelas 10 hingga 12, tersedia untuk semua jurusan
    </p>
  </div>

  <!-- Filter -->
  <div class="bg-white shadow-sm border border-gray-100 rounded-2xl px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-10">
    <div class="flex w-full sm:w-auto flex-col sm:flex-row gap-3">
      <div class="relative flex-1">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-gray-400 text-sm"></i>
        <input type="text" id="searchInput" placeholder="Cari materi pembelajaran..."
               class="pl-9 pr-4 py-2 w-full border border-gray-300 rounded-full text-sm text-gray-700 focus:ring-[#2B82FE]/30 focus:border-[#2B82FE] transition" />
      </div>

      <select id="filterKelas" class="border border-gray-300 bg-white rounded-full px-4 py-2 text-sm text-gray-700 focus:ring-[#2B82FE]/30 focus:border-[#2B82FE]">
        <option value="">Semua Kelas</option>
        <option value="10">Kelas 10</option>
        <option value="11">Kelas 11</option>
        <option value="12">Kelas 12</option>
      </select>

      <select id="filterJurusan" class="border border-gray-300 bg-white rounded-full px-4 py-2 text-sm text-gray-700 focus:ring-[#2B82FE]/30 focus:border-[#2B82FE]">
        <option value="">Semua Jurusan</option>
        <option value="PPLG">Pengembangan Perangkat luank dan Gim</option>
        <option value="TKJ">Teknik Jaringan Komputer dan Telekomunikasi</option>
        <option value="ULW"> Usaha Layanan Wisata</option>
        <option value="MPLB">Manajemen Perkantoran dan Layanan Bisnis</option>
        <option value="AKL">Akuntansi dan Keuangan Lembaga</option>
         <option value="BDR">Bisnis Digital dan Retail</option>
      </select>
    </div>

    <p class="text-sm text-[#7F8190] sm:ml-4">Menampilkan {{ $repositories->count() }} materi</p>
  </div>

  <!-- Card Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="repositoryGrid">
    @forelse ($repositories as $repo)
      @php
        $color = match($repo->kelas) {
          '10' => 'bg-[#ECFEFF]',
          '11' => 'bg-[#F0FDF4]',
          '12' => 'bg-[#EEF2FF]',
          default => 'bg-white'
        };
      @endphp

      <div class="border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-all p-6 flex flex-col justify-between {{ $color }}">
        <div>
          <div class="flex items-center justify-between mb-3">
            <span class="text-xs px-3 py-1 bg-white/70 text-[#2563EB] rounded-full font-semibold">
              Kelas {{ $repo->kelas ?? '-' }}
            </span>
            @if ($repo->jurusan)
              <span class="text-xs px-3 py-1 bg-white/70 text-[#059669] rounded-full font-semibold">
                {{ $repo->jurusan }}
              </span>
            @endif
          </div>

          <h2 class="font-extrabold text-lg text-[#0A090B] leading-snug mb-2">{{ $repo->judul }}</h2>
          <p class="text-sm text-[#6B7280] mb-5 line-clamp-2">{{ $repo->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
        </div>

        <div class="flex justify-between items-center">
          <div class="text-xs text-[#7F8190] flex items-center gap-2">
            <i class="fa-regular fa-calendar"></i>
            {{ $repo->created_at->translatedFormat('d/m/Y') }}
          </div>
          <a href="{{ route('repository.showPublic', $repo->id) }}"
             class="text-sm px-4 py-2 rounded-full bg-[#2B82FE] hover:bg-[#1E66E1] text-white font-semibold transition flex items-center gap-2">
            <i class="fa-solid fa-book-open"></i> Lihat Materi
          </a>
        </div>
      </div>
    @empty
      <p class="text-center col-span-full text-[#7F8190]">Belum ada materi di repository publik.</p>
    @endforelse
  </div>

  <!-- Pagination -->
  <div class="mt-10">
    {{ $repositories->links() }}
  </div>
</div>

<!-- =========================
     FOOTER
========================= -->
<footer class="w-full bg-white border-t border-gray-200 mt-20">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 py-8 text-center text-sm text-[#7F8190]">
    <p class="font-medium">© 2025 <span class="font-semibold text-[#0A090B]">E-Learning SMK 2 Padang</span>. All rights reserved.</p>
  </div>
</footer>

<!-- =========================
     JS FILTER
========================= -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const kelasFilter = document.getElementById('filterKelas');
  const jurusanFilter = document.getElementById('filterJurusan');
  const searchInput = document.getElementById('searchInput');
  const cards = document.querySelectorAll('#repositoryGrid > div');

  function filterCards() {
    const kelas = kelasFilter.value.toLowerCase();
    const jurusan = jurusanFilter.value.toLowerCase();
    const search = searchInput.value.toLowerCase();

    cards.forEach(card => {
      const text = card.innerText.toLowerCase();
      const matchesKelas = !kelas || text.includes(kelas);
      const matchesJurusan = !jurusan || text.includes(jurusan);
      const matchesSearch = !search || text.includes(search);

      card.style.display = (matchesKelas && matchesJurusan && matchesSearch) ? 'flex' : 'none';
    });
  }

  [kelasFilter, jurusanFilter, searchInput].forEach(el => el.addEventListener('input', filterCards));
});
</script>

<style>
  /* Line clamp untuk deskripsi */
  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>
@endsection
