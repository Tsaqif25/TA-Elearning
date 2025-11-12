<div id="content-materi" class="tab-content block p-6">

  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-8 gap-3">
    <h2 class="text-2xl font-extrabold text-[#0A090B] tracking-tight">📘 Daftar Materi</h2>

    @if (Auth::user()->hasRole('Pengajar'))
      <a href="{{ route('materi.create', ['kelasMapel' => $kelasMapel->id]) }}"
         class="flex items-center gap-2 bg-gradient-to-tr from-blue-500 to-green-500 text-white px-5 py-2.5 rounded-full font-semibold text-sm shadow-md hover:scale-[1.03] hover:shadow-lg transition duration-300 ease-in-out">
        <i class="fa-solid fa-plus"></i> Tambah Materi
      </a>
    @endif
  </div>

  <!-- Jika kosong -->
  @if ($materi->isEmpty())
    <div class="flex flex-col items-center justify-center py-10 text-center">
      <div class="w-14 h-14 flex items-center justify-center bg-[#EEF4FF] rounded-2xl text-[#2B82FE] mb-4 shadow-sm">
        <i class="fa-solid fa-folder-open text-xl"></i>
      </div>
      <p class="text-[#7F8190] text-sm">Belum ada materi yang ditambahkan.</p>
    </div>
  @else

  <!-- Daftar Materi -->
  <div class="flex flex-col gap-4">
    @foreach ($materi as $materis)
      <div class="group bg-white border border-gray-100 p-5 rounded-2xl shadow-sm hover:shadow-lg hover:border-[#2B82FE]/40 transition-all duration-300 ease-in-out">

        <!-- Baris utama -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

          <!-- Kiri -->
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-xl shadow-sm flex-shrink-0 group-hover:scale-110 transition">
              <i class="fa-solid fa-file-lines text-lg"></i>
            </div>

            <div>
              <h3 class="font-semibold text-[#0A090B] text-[15px] mb-1 leading-snug group-hover:text-[#2B82FE] transition">
                {{ $materis->name }}
              </h3>
              <p class="text-sm text-[#555] leading-relaxed mb-2">
                {{ Str::words(strip_tags($materis->content), 7, '...') ?? 'Belum ada deskripsi untuk materi ini.' }}
              </p>
              <p class="text-xs text-[#7F8190]">
                <span class="inline-flex items-center gap-1">
                  <i class="fa-solid fa-calendar-days text-[10px]"></i> {{ $materis->created_at->format('d/m/Y') }}
                </span>
                <span class="mx-2 text-gray-300">•</span>
                <span class="inline-flex items-center gap-1">
                  <i class="fa-solid fa-book text-[10px]"></i> Materi
                </span>
              </p>
            </div>
          </div>

          <!-- Kanan -->
          <div class="flex flex-wrap gap-2">
            <a href="{{ route('materi.show', $materis->id) }}"
               class="flex items-center gap-1 bg-[#F8FAFC] text-[#0A090B] text-xs px-3 py-1.5 rounded-full font-medium border border-gray-200 hover:bg-[#EEF4FF] hover:text-[#2B82FE] transition duration-200">
              <i class="fa-solid fa-eye text-[12px]"></i>
            </a>

            @if (Auth::user()->hasRole('Pengajar'))
              <a href="{{ route('materi.edit', $materis->id) }}"
                 class="flex items-center gap-1 bg-amber-50 text-amber-700 text-xs px-3 py-1.5 rounded-full font-medium border border-amber-200 hover:bg-amber-100 transition duration-200">
                <i class="fa-solid fa-pen text-[12px]"></i>
              </a>

              <a href="#"
                 onclick="event.preventDefault(); handleDeleteMateri('{{ route('materi.destroy', $materis->id) }}');"
                 class="flex items-center gap-1 bg-rose-50 text-rose-700 text-xs px-3 py-1.5 rounded-full font-medium border border-rose-200 hover:bg-rose-100 transition duration-200">
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


{{-- SweetAlert Delete Confirmation --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function handleDeleteMateri(url) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: 'Data materi ini akan dihapus secara permanen!',
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
          text: 'Materi berhasil dihapus.',
          icon: 'success',
          width: '300px',
          timer: 1500,
          showConfirmButton: false,
          background: '#ffffff',
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Dibatalkan',
          text: 'Materi tidak jadi dihapus.',
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
