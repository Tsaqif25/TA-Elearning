<div id="content-quiz" class="tab-content block p-6">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-3">
    <h2 class="text-xl font-bold text-[#0A090B]">Daftar Quiz</h2>

    {{-- Tombol Buat Quiz hanya untuk Pengajar --}}
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
    <div class="flex flex-col gap-3">
      @forelse($ujian as $ujians)
        <div class="bg-white border border-gray-100 rounded-xl p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center shadow-sm hover:shadow-md transition hover:-translate-y-0.5 duration-200">
          
          <!-- Kiri -->
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-[#2B82FE] rounded-lg flex-shrink-0">
              <i class="fa-solid fa-circle-question text-lg"></i>
            </div>

            <div>
              <h3 class="font-semibold text-[#0A090B] text-[15px] mb-1 leading-snug">
                {{ $ujians->name }}
              </h3>

             

              <p class="text-sm text-[#7F8190]">
                <span class="inline-flex items-center gap-1">
                  <i class="fa-solid fa-calendar-days text-xs"></i>
                  {{ \Carbon\Carbon::parse($ujians->due)->format('d/m/Y H:i') }}
                </span>
              
                <span class="mx-2 text-gray-300">•</span>
                <span class="inline-flex items-center gap-1">
                  <i class="fa-solid fa-list-check text-xs"></i>
                  {{ $ujians->soalUjianMultiple->count() ?? 0 }} Soal
                </span>
              </p>
            </div>
          </div>

          <!-- Kanan -->
          <div class="flex flex-wrap gap-2 mt-4 sm:mt-0">
            {{-- Untuk Pengajar --}}
            @if (Auth::user()->hasRole('Pengajar'))
              <a href="{{ route('ujian.soal.manage', ['ujian' => $ujians->id]) }}"
                 class="flex items-center gap-1 bg-gray-100 text-gray-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-gray-200 transition">
                <i class="fa-solid fa-eye text-[12px]"></i> Detail
              </a>

              <a href="{{ route('ujian.edit', ['ujian' => $ujians->id]) }}"
                 class="flex items-center gap-1 bg-amber-100 text-amber-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-amber-200 transition">
                <i class="fa-solid fa-pen text-[12px]"></i> Edit
              </a>

              <a href="{{ route('ujian.students', ['ujian' => $ujians->id]) }}"
                 class="flex items-center gap-1 bg-blue-100 text-blue-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-blue-200 transition">
                <i class="fa-solid fa-chart-line text-[12px]"></i> Hasil
              </a>

              <form action="{{ route('ujian.destroy', $ujians->id) }}" method="POST"
                    onsubmit="event.preventDefault(); handleDeleteUjian(this);" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="flex items-center gap-1 bg-rose-100 text-rose-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-rose-200 transition">
                  <i class="fa-solid fa-trash text-[12px]"></i> Hapus
                </button>
              </form>
            @else
              {{-- Untuk Siswa --}}
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
