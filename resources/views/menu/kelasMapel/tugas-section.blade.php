<div id="tugas" class="tab-content hidden">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-[#0A090B]">Tugas</h2>

    {{-- ✅ Tombol "Buat Tugas" hanya untuk Pengajar --}}
    @if (Auth::user()->hasRole('Pengajar'))
      <a href="{{ route('viewCreateTugas', $kelasMapel->id) }}" 
         class="bg-[#6C63FF] text-white px-6 py-2 rounded-full font-semibold shadow hover:bg-[#574FFB] transition">
        + Buat Tugas
      </a>
    @endif
  </div>

  <div class="space-y-4">
    @forelse($tugas as $tugass)
      <div class="bg-white border-2 border-black rounded-xl p-4 flex items-center justify-between hover:shadow-sm transition">
        
        {{-- Kiri: Judul & Deadline --}}
        <div class="pr-4 min-w-0">
          <h3 class="font-semibold text-base truncate flex items-center gap-2">
            {{ $tugass->name }}
            <span class="text-[11px] bg-[#6C63FF] text-white px-2 py-[2px] rounded-md font-medium">Tugas</span>
          </h3>
          <p class="text-sm text-[#7F8190] mt-1 truncate">
            <i class="fa-solid fa-calendar-days text-[#6C63FF] mr-1 text-xs"></i>
            Deadline: {{ \Carbon\Carbon::parse($tugass->due ?? '2025-10-20')->format('d/m/Y') }}
          </p>
        </div>

        {{-- Kanan: Tombol aksi --}}
        <div class="flex items-center gap-2 flex-shrink-0">
          {{-- ✅ CRUD hanya untuk Pengajar --}}
          @if (Auth::user()->hasRole('Pengajar'))
            <form action="{{ route('tugas.destroy', $tugass->id) }}"  method="POST" 
                  onsubmit="event.preventDefault(); handleDeleteTugas(this);" 
                  class="inline">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="flex items-center gap-1 px-3 py-1.5 rounded-full bg-red-600 text-white text-xs font-semibold hover:bg-red-700 transition">
                <i class="fa-solid fa-trash text-xs"></i> Hapus
              </button>
            </form>
            
            <a href="{{ route('viewUpdateTugas', $tugass->id) }}"
               class="flex items-center gap-1 px-3 py-1.5 rounded-full border border-gray-700 text-xs font-semibold hover:bg-gray-100 transition">
              <i class="fa-solid fa-pen text-xs"></i> Edit
            </a>
          @endif
               @if (Auth::user()->hasRole('Pengajar'))
          <a href="{{ route('viewTugas', $tugass->id) }}"
             class="flex items-center gap-1 px-3 py-1.5 rounded-full bg-[#6C63FF] text-white text-xs font-semibold hover:bg-[#574FFB] transition">
            <i class="fa-solid fa-eye text-xs"></i> Lihat
          </a>
             @endif
          {{-- Semua user bisa Lihat --}}
           @if (Auth::user()->hasRole('Siswa'))
          <a href="{{ route('lihatTugas', $tugass->id) }}"
             class="flex items-center gap-1 px-3 py-1.5 rounded-full bg-[#6C63FF] text-white text-xs font-semibold hover:bg-[#574FFB] transition">
            <i class="fa-solid fa-eye text-xs"></i> Lihat
          </a>
             @endif
        </div>
      </div>
    @empty
      <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl py-8 text-center text-gray-500">
        Belum ada Tugas di kelas ini.
      </div>
    @endforelse
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function  handleDeleteTugas(form) {
  Swal.fire({
    title: 'Yakin ingin menghapus?',
    text: 'Data Tugas ini akan dihapus secara permanen!',
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
        text: 'Tugas berhasil dihapus.',
        icon: 'success',
        width: '300px',
        timer: 1500,
        showConfirmButton: false,
        background: '#ffffff',
      });
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire({
        title: 'Dibatalkan',
        text: 'Tugas tidak jadi dihapus.',
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