<div id="content-materi" class="tab-content block p-6">
  <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-3">
    <h2 class="text-xl font-bold text-[#0A090B]">Daftar Materi</h2>

    @if (Auth::user()->hasRole('Pengajar'))
      <a href="{{ route('materi.create', ['kelasMapel' => $kelasMapel->id]) }}"
         class="flex items-center gap-2 bg-gradient-to-tr from-blue-500 to-green-500 text-white px-5 py-2 rounded-full font-semibold text-sm shadow hover:opacity-90 transition">
        <i class="fa-solid fa-plus"></i> Tambah Materi
      </a>
    @endif
  </div>

  @if ($materi->isEmpty())
    <p class="text-center text-[#7F8190] py-6">Belum ada materi yang ditambahkan.</p>
  @else
    <div class="flex flex-col gap-3">
      @foreach ($materi as $materis)
        <div class="bg-white border border-gray-100 p-4 rounded-xl flex flex-col sm:flex-row justify-between items-start sm:items-center shadow-sm hover:shadow-md hover:border-blue-200 transition">
          <!-- kiri -->
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg flex-shrink-0">
              <i class="fa-solid fa-file-lines text-lg"></i>
            </div>

            <div>
              <h3 class="font-semibold text-[#0A090B] text-[15px] mb-1 leading-snug">{{ $materis->name }}</h3>
              <p class="text-sm text-[#7F8190] leading-relaxed mb-2">
                {{ Str::words(strip_tags($materis->content), 7, '...') ?? 'Belum ada deskripsi untuk materi ini.' }}
              </p>
              <p class="text-sm text-[#7F8190]">
                <span class="inline-flex items-center gap-1">
                  <i class="fa-solid fa-calendar-days text-xs"></i> {{ $materis->created_at->format('d/m/Y') }}
                </span>
                <span class="mx-2 text-gray-300">•</span>
                <span class="inline-flex items-center gap-1">
                  <i class="fa-solid fa-book text-xs"></i> Materi
                </span>
              </p>
            </div>
          </div>

          <!-- kanan -->
          <div class="flex flex-wrap gap-2 mt-4 sm:mt-0">
            <a href="{{ route('materi.show', $materis->id) }}"
               class="flex items-center gap-1 bg-gray-100 text-gray-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-gray-200 transition">
              <i class="fa-solid fa-eye text-[12px]"></i> Lihat
            </a>

            @if (Auth::user()->hasRole('Pengajar'))
              <a href="{{ route('materi.edit', $materis->id) }}"
                 class="flex items-center gap-1 bg-amber-100 text-amber-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-amber-200 transition">
                <i class="fa-solid fa-pen text-[12px]"></i> Edit
              </a>

              <a href="#"
                 onclick="event.preventDefault(); handleDeleteMateri('{{ route('materi.destroy', $materis->id) }}');"
                 class="flex items-center gap-1 bg-rose-100 text-rose-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-rose-200 transition">
                <i class="fa-solid fa-trash text-[12px]"></i> Hapus
              </a>
            @endif
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
