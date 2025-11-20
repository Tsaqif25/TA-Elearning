<div id="content-tugas" class="tab-content block p-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-8 gap-3">
      <h2 class="text-2xl font-extrabold text-[#0A090B] tracking-tight">
          📋 Daftar Tugas
      </h2>

      @if (Auth::user()->hasRole('Pengajar'))
      <div class="flex flex-col sm:flex-row sm:items-center gap-3">

          <a href="{{ route('guru.tugas.rekap', $kelasMapel->id) }}"
             class="flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-sm
                    bg-gradient-to-tr from-purple-500 to-pink-500 text-white shadow-md 
                    hover:shadow-lg transition duration-300 ease-in-out w-full sm:w-auto text-center">
              📊 Rekap Nilai Tugas
          </a>

          <a href="{{ route('guru.tugas.createView', $kelasMapel->id) }}"
             class="flex items-center gap-2 bg-gradient-to-tr from-blue-500 to-green-500 
                    text-white px-5 py-2.5 rounded-full font-semibold text-sm shadow-md 
                    hover:shadow-lg transition duration-300 ease-in-out w-full sm:w-auto text-center">
              <i class="fa-solid fa-plus"></i> Tambah Tugas
          </a>

      </div>
      @endif
  </div>



  <!-- Jika belum ada -->
  @if ($tugas->isEmpty())
    <div class="flex flex-col items-center justify-center py-10 text-center">
      <div class="w-14 h-14 flex items-center justify-center bg-[#EEF4FF] rounded-2xl text-[#2B82FE] mb-4 shadow-sm">
        <i class="fa-solid fa-clipboard-list text-xl"></i>
      </div>
      <p class="text-[#7F8190] text-sm">Belum ada tugas yang ditambahkan.</p>
    </div>

  @else

  <!-- Daftar Tugas -->
  <div class="flex flex-col gap-4">
    @foreach ($tugas as $tugass)
      <div class="group bg-white border border-gray-100 p-5 rounded-2xl shadow-sm hover:shadow-lg hover:border-[#2B82FE]/40 transition-all duration-300 ease-in-out">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

          <!-- KIRI -->
          <div class="flex items-start gap-4 w-full sm:w-auto">
            <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-tr from-indigo-500 to-blue-500 text-white rounded-xl shadow-sm flex-shrink-0 group-hover:scale-110 transition">
              <i class="fa-solid fa-clipboard-list text-lg"></i>
            </div>

            <div class="flex-1">
              <h3 class="font-semibold text-[#0A090B] text-[15px] mb-1 leading-snug group-hover:text-[#2B82FE] transition">
                {{ $tugass->judul }}
              </h3>

              <p class="text-sm text-[#555] leading-relaxed mb-2">
                {{ Str::words(strip_tags($tugass->deskripsi ?? 'Belum ada deskripsi'), 7, '...') }}
              </p>

              <p class="text-xs text-[#7F8190]">
                <i class="fa-solid fa-calendar-days text-[10px]"></i>
                Deadline: {{ \Carbon\Carbon::parse($tugass->due)->format('d/m/Y') }}
              </p>
            </div>
          </div>

          <!-- KANAN -->
          <div class="flex flex-wrap sm:flex-nowrap gap-2 w-full sm:w-auto sm:justify-end">

              @if (Auth::user()->hasRole('Siswa'))
              <a href="{{ route('siswa.tugas.view', $tugass->id) }}"
                 class="flex items-center gap-1 bg-gray-100 text-gray-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-gray-200 transition">
                <i class="fa-solid fa-eye text-[12px]"></i> Lihat
              </a>
              @endif

              @if (Auth::user()->hasRole('Pengajar'))
              <a href="{{ route('guru.tugas.view', $tugass->id) }}"
                 class="flex items-center gap-1 bg-[#F8FAFC] text-[#0A090B] text-xs px-3 py-1.5 rounded-full border hover:bg-[#EEF4FF] hover:text-[#2B82FE] transition">
                <i class="fa-solid fa-eye text-[12px]"></i>
              </a>

              <a href="{{ route('guru.tugas.edit', $tugass->id) }}"
                 class="flex items-center gap-1 bg-amber-50 text-amber-700 text-xs px-3 py-1.5 rounded-full border border-amber-200 hover:bg-amber-100 transition">
                <i class="fa-solid fa-pen text-[12px]"></i> 
              </a>

              <a href="#"
                 onclick="event.preventDefault(); handleDeleteTugas('{{ route('guru.tugas.destroy', $tugass->id) }}');"
                 class="flex items-center gap-1 bg-rose-50 text-rose-700 text-xs px-3 py-1.5 rounded-full border border-rose-200 hover:bg-rose-100 transition">
                <i class="fa-solid fa-trash text-[12px]"></i>
              </a>
              @endif

          </div>

        </div>
      </div>
    @endforeach
  </div>

  @endif
</div>




{{-- script lama tetap --}}

{{-- SweetAlert Delete Confirmation --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function handleDeleteTugas(url) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: 'Data tugas ini akan dihapus secara permanen!',
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
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);

        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);

        document.body.appendChild(form);
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
