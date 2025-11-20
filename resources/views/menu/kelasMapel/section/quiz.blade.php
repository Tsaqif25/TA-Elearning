<div id="content-quiz" class="tab-content block p-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-3">
    <h2 class="text-xl font-bold text-[#0A090B]">Daftar Ujian</h2>

    {{-- Tombol Buat Ujian hanya untuk Pengajar --}}
    @if (Auth::user()->hasRole('Pengajar'))
      <a href="{{ route('ujian.create', ['kelasMapel' => $kelasMapel->id]) }}"
         class="flex items-center gap-2 bg-[#2B82FE] text-white px-5 py-2 rounded-full font-semibold text-sm shadow hover:bg-[#1a6ae0] transition">
        <i class="fa-solid fa-plus"></i> Tambah Ujian
      </a>
    @endif
  </div>

  {{-- Jika Belum Ada Ujian --}}
  @if ($ujian->isEmpty())
    <p class="text-center text-[#7F8190] py-6">Belum ada ujian yang ditambahkan.</p>
  @else
    <div class="flex flex-col gap-3">

      @foreach ($ujian as $item)

        @php
            // CEK apakah siswa sudah attempt
            $sudahAttempt = \App\Models\UjianAttempt::where('ujian_id', $item->id)
                ->where('siswa_id', Auth::id())
                ->exists();
        @endphp

        <div class="bg-white border border-gray-100 rounded-xl p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center shadow-sm hover:shadow-md transition">

          <!-- KIRI -->
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-[#2B82FE] rounded-lg">
              <i class="fa-solid fa-circle-question text-lg"></i>
            </div>

            <div>
              <h3 class="font-semibold text-[#0A090B] text-[15px] mb-1">
                {{ $item->judul }}
              </h3>

              <p class="text-sm text-[#7F8190]">
                <span class="inline-flex items-center gap-1">
                  <i class="fa-solid fa-list-check text-xs"></i>
                  {{ $item->soal->count() }} Soal
                </span>
              </p>
            </div>
          </div>

          <!-- KANAN -->
          <div class="flex gap-2 mt-4 sm:mt-0">

            {{-- PENGAJAR --}}
            @if (Auth::user()->hasRole('Pengajar'))

              <a href="{{ route('ujian.soal.manage', ['ujian' => $item->id]) }}"
                class="px-3 py-1.5 text-xs bg-gray-100 rounded-full font-semibold hover:bg-gray-200">
                Detail
              </a>

              <a href="{{ route('ujian.edit', ['ujian' => $item->id]) }}"
                class="px-3 py-1.5 text-xs bg-amber-100 text-amber-700 rounded-full">
                Edit
              </a>

              <form action="{{ route('ujian.destroy', $item->id) }}" method="POST"
                    onsubmit="event.preventDefault(); handleDeleteUjian(this);">
                @csrf @method('DELETE')
                <button class="px-3 py-1.5 text-xs bg-rose-100 text-rose-700 rounded-full">
                  Hapus
                </button>
              </form>

            @else
            {{-- SISWA --}}

              @if ($sudahAttempt)
                <a href="{{ route('ujian.learning.rapport', $item->id) }}"
                  class="px-3 py-1.5 text-xs bg-green-100 text-green-700 rounded-full">
                  Lihat Hasil
                </a>
              @else
                <a href="{{ route('ujian.access', [
                      'ujian' => $item->id,
                      'kelas' => $kelas->id,
                      'mapel' => $mapel->id,
                    ]) }}"
                  class="px-3 py-1.5 text-xs bg-[#2B82FE] text-white rounded-full">
                  Kerjakan
                </a>
              @endif

            @endif

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