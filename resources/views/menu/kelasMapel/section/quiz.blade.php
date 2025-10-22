<div id="content-quiz" class="tab-content block p-6">
  <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-3">
    <h2 class="text-xl font-bold">Daftar Quiz</h2>

    {{-- ✅ Tombol Buat Quiz hanya untuk Pengajar --}}
    @if (Auth::user()->hasRole('Pengajar'))
      <a href="{{ route('ujian.create', ['kelasMapel' => $kelasMapel->id]) }}" 
         class="flex items-center gap-2 bg-[#2B82FE] text-white px-5 py-2 rounded-full font-semibold text-sm shadow hover:bg-[#1a6ae0] transition">
        <i class="fa-solid fa-plus"></i> Tambah Quiz
      </a>
    @endif
  </div>

  {{-- Jika Belum Ada Quiz --}}
  @if ($ujian->isEmpty())
    <p class="text-center text-[#7F8190] py-6">Belum ada quiz yang ditambahkan.</p>
  @else
    <!-- Daftar Card Quiz -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse($ujian as $ujians)
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
          <div>
            <div class="flex justify-between items-start mb-3">
              <h3 class="font-semibold text-gray-800 text-lg leading-snug truncate">
                {{ $ujians->name }}
              </h3>
              <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-semibold">Quiz</span>
            </div>

            <p class="text-sm text-[#7F8190] mb-1">
              📅 Tanggal: {{ \Carbon\Carbon::parse($ujians->due)->format('d/m/Y H:i') }}
            </p>
            <p class="text-sm text-[#7F8190] mb-1">⏱️ Durasi: {{ $ujians->time ?? '-' }} menit</p>
            <p class="text-sm text-[#7F8190] mb-4">📚 Jumlah Soal: {{ $ujians->soalUjianMultiple->count() ?? 0 }}</p>
          </div>

          {{-- Tombol Aksi --}}
          <div class="flex flex-wrap gap-2 mt-2">
            {{-- ✅ CRUD hanya untuk Pengajar --}}
            @if (Auth::user()->hasRole('Pengajar'))
              {{-- Hapus --}}
              <form action="{{ route('ujian.destroy', $ujians->id) }}" method="POST"
                    onsubmit="event.preventDefault(); handleDeleteUjian(this);" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="flex items-center gap-1 bg-rose-100 text-rose-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-rose-200 transition">
                  <i class="fa-solid fa-trash text-[12px]"></i> Hapus
                </button>
              </form>

              {{-- Edit --}}
              <a href="{{ route('ujian.edit', ['ujian' => $ujians->id]) }}"
                 class="flex items-center gap-1 bg-amber-100 text-amber-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-amber-200 transition">
                <i class="fa-solid fa-pen text-[12px]"></i> Edit
              </a>

              {{-- Detail / Kelola Soal --}}
              <a href="{{ route('ujian.soal.manage', ['ujian' => $ujians->id]) }}"
                 class="flex items-center gap-1 bg-gray-100 text-gray-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-gray-200 transition">
                <i class="fa-solid fa-eye text-[12px]"></i> Detail
              </a>

              {{-- Hasil Quiz --}}
              <a href="{{ route('ujian.students', ['ujian' => $ujians->id]) }}"
                 class="flex items-center gap-1 bg-blue-100 text-blue-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-blue-200 transition">
                <i class="fa-solid fa-chart-line text-[12px]"></i> Hasil
              </a>
            @else
              {{-- ✅ Untuk siswa, tampilkan tombol Kerjakan atau Hasil --}}
              @php
                  $sudahJawab = $ujians->soalUjianMultiple
                      ->flatMap(fn($soal) => $soal->userJawabans ?? [])
                      ->where('user_id', Auth::id())
                      ->count() > 0;
              @endphp

              @if ($sudahJawab)
                <a href="{{ route('ujian.learning.rapport', ['ujian' => $ujians->id]) }}"
                   class="flex items-center gap-1 bg-green-100 text-green-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-green-200 transition">
                  <i class="fa-solid fa-chart-line text-[12px]"></i> Lihat Hasil
                </a>
              @else
                <a href="{{ route('ujian.access', [
                    'ujian' => $ujians->id,
                    'kelas' => $kelas->id,
                    'mapel' => $mapel->id,
                ]) }}"
                   class="flex items-center gap-1 bg-[#2B82FE] text-white text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-[#1a6ae0] transition">
                  <i class="fa-solid fa-pencil text-[12px]"></i> Kerjakan
                </a>
              @endif
            @endif
          </div>
        </div>
      @empty
        <p class="text-center text-[#7F8190] py-6">Belum ada quiz di kelas ini.</p>
      @endforelse
    </div>
  @endif
</div>

{{-- SweetAlert Delete Confirmation --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function handleDeleteUjian(form) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: 'Data Quiz ini akan dihapus secara permanen!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal',
      reverseButtons: true,
      width: '320px',
      padding: '1rem',
      background: '#ffffff',
      color: '#333',
      customClass: {
        popup: 'rounded-2xl shadow-lg',
        confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg mx-1 text-sm',
        cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded-lg mx-1 text-sm',
        title: 'text-base font-semibold',
        htmlContainer: 'text-sm'
      },
      buttonsStyling: false
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
        Swal.fire({
          title: 'Terhapus!',
          text: 'Quiz berhasil dihapus.',
          icon: 'success',
          width: '300px',
          timer: 1500,
          showConfirmButton: false,
          background: '#ffffff',
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Dibatalkan',
          text: 'Quiz tidak jadi dihapus.',
          icon: 'error',
          width: '300px',
          timer: 1300,
          showConfirmButton: false,
          background: '#ffffff',
        });
      }
    });
  }
</script>
