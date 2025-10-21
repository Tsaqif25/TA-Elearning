<div id="quiz" class="tab-content hidden">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-[#0A090B]">Quiz</h2>

    {{-- ✅ Tombol Buat Quiz hanya untuk Pengajar --}}
    @if (Auth::user()->hasRole('Pengajar'))
      <a href="{{ route('ujian.create', ['kelasMapel' => $kelasMapel->id]) }}" 
         class="bg-[#6C63FF] text-white px-6 py-2 rounded-full font-semibold shadow hover:bg-[#574FFB] transition">
        + Buat Quiz
      </a>
    @endif
  </div>

  <div class="space-y-5">
    @forelse($ujian as $ujians)
      <div class="bg-white border-2 border-black rounded-xl p-5 flex justify-between items-start">
        <div>
          <h3 class="font-semibold text-lg">
            {{ $ujians->name }}
            <span class="text-xs bg-[#6C63FF] text-white px-2 py-1 rounded-md font-medium">Quiz</span>
          </h3>

          <p class="text-sm text-[#7F8190] mt-1">
            📅 Tanggal: {{ \Carbon\Carbon::parse($ujians->due)->format('d/m/Y H:i') }}
          </p>
          <p class="text-sm text-[#7F8190]">⏱️ Durasi: {{ $ujians->time ?? '-' }} menit</p>
          <p class="text-sm text-[#7F8190]">📚 Jumlah Soal: {{ $ujians->soalUjianMultiple->count() ?? 0 }}</p>

          <div class="flex gap-2 mt-3">
            {{-- ✅ Tombol CRUD hanya untuk Pengajar --}}
            @if (Auth::user()->hasRole('Pengajar'))
              {{-- Hapus --}}
              <form action="{{ route('ujian.destroy', $ujians->id) }}" method="POST"
                    onsubmit="event.preventDefault(); handleDeleteUjian(this);" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 rounded-full bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition"
                        title="Hapus Ujian">
                  <i class="fa-solid fa-trash"></i> Hapus
                </button>
              </form>

              {{-- Edit --}}
              <a href="{{ route('ujian.edit', ['ujian' => $ujians->id]) }}"
                 class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-[#0A090B] text-sm font-semibold hover:bg-[#F3F3F3] transition">
                <i class="fa-solid fa-pen text-sm"></i> Edit
              </a>

              {{-- Detail / Kelola Soal --}}
              <a href="{{ route('ujian.soal.manage', ['ujian' => $ujians->id]) }}"
                 class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#6C63FF] text-white text-sm font-semibold hover:bg-[#574FFB] transition">
                <i class="fa-solid fa-eye text-sm"></i> Detail
              </a>

                  <a href="{{ route('ujian.students', ['ujian' => $ujians->id]) }}"
                 class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#6C63FF] text-white text-sm font-semibold hover:bg-[#574FFB] transition">
                <i class="fa-solid fa-eye text-sm"></i> Hasil Quiz
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
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-600 text-white text-sm font-semibold hover:bg-green-700 transition">
                  <i class="fa-solid fa-chart-line"></i> Lihat Hasil
                </a>
              @else
                <a href="{{ route('ujian.access', [
                    'ujian' => $ujians->id,
                    'kelas' => $kelas->id,
                    'mapel' => $mapel->id,
                ]) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#6C63FF] text-white text-sm font-semibold hover:bg-[#574FFB] transition">
                  <i class="fa-solid fa-pencil"></i> Kerjakan
                </a>
              @endif
            @endif
          </div>
        </div>

        <div class="text-right">
          <p class="text-lg font-semibold">{{ $ujians->participants_count ?? 0 }}/{{ $ujians->total_students ?? 0 }}</p>
          <p class="text-sm text-[#7F8190]">Sudah Mengerjakan</p>
        </div>
      </div>
    @empty
      <div class="bg-gray-50 border border-dashed border-gray-300 rounded-2xl py-10 text-center text-gray-500">
        Belum ada Quiz di kelas ini.
      </div>
    @endforelse
  </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function  handleDeleteUjian(form) {
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
    background: '#ffffff', // warna latar popup
    color: '#333', // warna teks
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