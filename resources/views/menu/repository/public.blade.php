


<div class="flex flex-col w-full px-6 lg:px-12 py-10 bg-[#FAFAFA] min-h-screen font-poppins">

  <!-- Header -->
  <div class="mb-8 text-center">
    <h1 class="text-3xl font-extrabold text-[#0A090B]">Repository Materi SMK</h1>
    <p class="text-sm text-[#7F8190] mt-2">
      Kumpulan materi pembelajaran dari kelas 10 hingga 12, tersedia untuk semua jurusan
    </p>
  </div>

  <!-- Filter -->
  <div class="flex flex-col sm:flex-row justify-center sm:justify-between items-center mb-8 gap-4">
    <div class="flex gap-3">
      <select id="filterKelas" class="border border-gray-300 bg-white rounded-full px-4 py-2 text-sm text-gray-700 focus:ring-[#2B82FE]/30 focus:border-[#2B82FE]">
        <option value="">Semua Kelas</option>
        <option value="10">Kelas 10</option>
        <option value="11">Kelas 11</option>
        <option value="12">Kelas 12</option>
      </select>

      <select id="filterJurusan" class="border border-gray-300 bg-white rounded-full px-4 py-2 text-sm text-gray-700 focus:ring-[#2B82FE]/30 focus:border-[#2B82FE]">
        <option value="">Semua Jurusan</option>
        <option value="RPL">RPL</option>
        <option value="TKJ">TKJ</option>
        <option value="Multimedia">Multimedia</option>
        <option value="Akuntansi">Akuntansi</option>
      </select>
    </div>

    <p class="text-sm text-[#7F8190] mt-2 sm:mt-0">Menampilkan {{ $repositories->count() }} materi</p>
  </div>

  <!-- Card Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="repositoryGrid">
    @forelse ($repositories as $repo)
      <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-all p-6 flex flex-col justify-between">

        <div>
          <div class="flex items-center justify-between mb-2">
            <span class="text-xs px-3 py-1 bg-[#EEF2FF] text-[#4F46E5] rounded-full font-semibold">
              Kelas {{ $repo->kelas ?? '-' }}
            </span>
            @if ($repo->jurusan)
              <span class="text-xs px-3 py-1 bg-[#ECFEFF] text-[#0891B2] rounded-full font-semibold">
                {{ $repo->jurusan }}
              </span>
            @endif
          </div>

          <h2 class="font-extrabold text-lg text-[#0A090B] leading-snug mb-1">{{ $repo->judul }}</h2>
          <p class="text-sm text-[#7F8190] mb-4 line-clamp-2">
            {{ $repo->deskripsi ?? 'Tidak ada deskripsi.' }}
          </p>
        </div>

        <div class="flex justify-between items-center mt-3">
          <div class="text-xs text-[#7F8190] flex items-center gap-2">
            <i class="fa-regular fa-calendar"></i>
            {{ $repo->created_at->translatedFormat('d/m/Y') }}
          </div>

          <a href="{{ route('repository.show', $repo->id) }}"
             class="text-sm px-4 py-2 rounded-full bg-[#6D28D9] hover:bg-[#5B21B6] text-white font-semibold transition flex items-center gap-2">
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

<script>
document.addEventListener('DOMContentLoaded', function () {
  const kelasFilter = document.getElementById('filterKelas');
  const jurusanFilter = document.getElementById('filterJurusan');
  const repositoryGrid = document.getElementById('repositoryGrid');

  function filterRepository() {
    const kelas = kelasFilter.value.toLowerCase();
    const jurusan = jurusanFilter.value.toLowerCase();

    document.querySelectorAll('#repositoryGrid > div').forEach(card => {
      const kelasText = card.innerText.toLowerCase().includes(kelas);
      const jurusanText = card.innerText.toLowerCase().includes(jurusan);
      card.style.display = (kelasText && jurusanText) || (!kelas && !jurusan) ? 'flex' : 'none';
    });
  }

  kelasFilter.addEventListener('change', filterRepository);
  jurusanFilter.addEventListener('change', filterRepository);
});
</script>

