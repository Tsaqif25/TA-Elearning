<div id="content-quiz" class="tab-content block p-8">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-8 gap-3">
    <h2 class="text-2xl font-extrabold text-[#0A090B] tracking-tight">
      📘 Daftar Ujian
    </h2>

    {{-- Tombol Buat Ujian hanya untuk Pengajar --}}
    @if (Auth::user()->hasRole('Pengajar'))
      <a href="{{ route('ujian.create', ['kelasMapel' => $kelasMapel->id]) }}"
         class="flex items-center gap-2 bg-gradient-to-tr from-blue-500 to-green-500 text-white px-5 py-2.5 rounded-full font-semibold text-sm shadow-md hover:scale-[1.03] hover:shadow-lg transition duration-300 ease-in-out">
        <i class="fa-solid fa-plus"></i> Tambah Ujian
      </a>
    @endif
  </div>

  {{-- Jika Belum Ada Ujian --}}
  @if ($ujian->isEmpty())
    <div class="flex flex-col items-center justify-center py-10 text-center">
      <div class="w-14 h-14 flex items-center justify-center bg-[#EEF4FF] rounded-2xl text-[#2B82FE] mb-4 shadow-sm">
        <i class="fa-solid fa-folder-open text-xl"></i>
      </div>
      <p class="text-[#7F8190] text-sm">Belum ada ujian yang ditambahkan.</p>
    </div>

  @else

  <!-- Daftar Ujian -->
  <div class="flex flex-col gap-4">

    @foreach ($ujian as $item)
    <div class="group bg-white border border-gray-100 p-5 rounded-2xl shadow-sm hover:shadow-lg hover:border-[#2B82FE]/40 transition-all duration-300 ease-in-out">

      <!-- BARIS UTAMA -->
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

        <!-- KIRI -->
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-xl shadow-sm flex-shrink-0 group-hover:scale-110 transition">
            <i class="fa-solid fa-circle-question text-lg"></i>
          </div>

          <div class="min-w-0">
            <h3 class="font-semibold text-[#0A090B] text-[15px] mb-1 leading-snug group-hover:text-[#2B82FE] transition">
              {{ $item->judul }}
            </h3>

            <p class="text-sm text-[#555] leading-relaxed mb-2">
              Terdapat <strong>{{ $item->soal->count() }}</strong> soal ujian.
            </p>

            <p class="text-xs text-[#7F8190]">
              <span class="inline-flex items-center gap-1">
                <i class="fa-solid fa-calendar-days text-[10px]"></i>
                {{ $item->created_at->format('d/m/Y') }}
              </span>

              <span class="mx-2 text-gray-300">•</span>

              <span class="inline-flex items-center gap-1">
                <i class="fa-solid fa-bolt text-[10px]"></i>
                Ujian
              </span>
            </p>
          </div>
        </div>

        <!-- KANAN -->
        <div class="flex flex-wrap gap-2">

          {{-- PENGAJAR --}}
          @if (Auth::user()->hasRole('Pengajar'))

            <!-- Lihat Nilai -->
            <a href="{{ route('guru.ujian.report.show', $item->id) }}"
              class="flex items-center gap-1 bg-green-50 text-green-700 text-xs px-3 py-1.5 rounded-full font-medium border border-green-200 hover:bg-green-100 transition duration-200">
              <i class="fa-solid fa-chart-line text-[12px]"></i>
              Nilai
            </a>

            <!-- Detail -->
            <a href="{{ route('ujian.soal.manage', ['ujian' => $item->id]) }}"
              class="flex items-center gap-1 bg-gray-50 text-gray-700 text-xs px-3 py-1.5 rounded-full font-medium border border-gray-200 hover:bg-gray-100 transition duration-200">
              <i class="fa-solid fa-list-check text-[12px]"></i>
              Detail
            </a>

            <!-- Edit -->
            <a href="{{ route('ujian.edit', ['ujian' => $item->id]) }}"
              class="flex items-center gap-1 bg-amber-50 text-amber-700 text-xs px-3 py-1.5 rounded-full font-medium border border-amber-200 hover:bg-amber-100 transition duration-200">
              <i class="fa-solid fa-pen text-[12px]"></i>
           
            </a>

            <!-- Hapus -->
            <form action="{{ route('ujian.destroy', $item->id) }}" method="POST"
                  onsubmit="event.preventDefault(); handleDeleteUjian(this);">
              @csrf @method('DELETE')
              <button class="flex items-center gap-1 bg-rose-50 text-rose-700 text-xs px-3 py-1.5 rounded-full font-medium border border-rose-200 hover:bg-rose-100 transition duration-200">
                <i class="fa-solid fa-trash text-[12px]"></i>
              
              </button>
            </form>

          @else
          {{-- SISWA --}}
            @php
                $sudahAttempt = \App\Models\UjianAttempt::where('ujian_id', $item->id)
                    ->where('siswa_id', Auth::id())
                    ->exists();
            @endphp

            @if ($sudahAttempt)
              <!-- Lihat Hasil -->
              <a href="{{ route('ujian.learning.rapport', $item->id) }}"
                class="flex items-center gap-1 bg-green-50 text-green-700 text-xs px-3 py-1.5 rounded-full font-medium border border-green-200 hover:bg-green-100 transition duration-200">
                <i class="fa-solid fa-check text-[12px]"></i> Hasil
              </a>
            @else
              <!-- Kerjakan -->
              <a href="{{ route('ujian.access', ['ujian' => $item->id]) }}"
                class="flex items-center gap-1 bg-gradient-to-tr from-blue-500 to-green-500 text-white text-xs px-3 py-1.5 rounded-full font-medium shadow hover:scale-[1.03] hover:shadow-lg transition duration-200">
                <i class="fa-solid fa-pen-nib text-[12px]"></i> Kerjakan
              </a>
            @endif

          @endif

        </div>
      </div>

    </div>
    @endforeach

  </div>
  @endif

</div>



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
