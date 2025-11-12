<div id="content-tugas" class="tab-content block p-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-8 gap-3">
    <h2 class="text-2xl font-extrabold text-[#0A090B] tracking-tight">📋 Daftar Tugas</h2>

    @if (Auth::user()->hasRole('Pengajar'))
      <a href="{{ route('viewCreateTugas', $kelasMapel->id) }}" 
         class="flex items-center gap-2 bg-gradient-to-tr from-blue-500 to-green-500 text-white px-5 py-2.5 rounded-full font-semibold text-sm shadow-md hover:scale-[1.03] hover:shadow-lg transition duration-300 ease-in-out">
        <i class="fa-solid fa-plus"></i> Tambah Tugas
      </a>
    @endif
  </div>

  <!-- Jika belum ada tugas -->
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

        <!-- Isi Tugas -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

          <!-- Kiri -->
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-tr from-indigo-500 to-blue-500 text-white rounded-xl shadow-sm flex-shrink-0 group-hover:scale-110 transition">
              <i class="fa-solid fa-clipboard-list text-lg"></i>
            </div>

            <div>
              <h3 class="font-semibold text-[#0A090B] text-[15px] mb-1 leading-snug group-hover:text-[#2B82FE] transition">
                {{ $tugass->name }}
              </h3>
              <p class="text-sm text-[#555] leading-relaxed mb-2">
                {{ Str::words(strip_tags($tugass->deskripsi ?? 'Belum ada deskripsi untuk tugas ini.'), 7, '...') }}
              </p>
              <p class="text-xs text-[#7F8190]">
                <span class="inline-flex items-center gap-1">
                  <i class="fa-solid fa-calendar-days text-[10px]"></i>
                  Deadline: {{ \Carbon\Carbon::parse($tugass->due ?? '2025-10-20')->format('d/m/Y') }}
                </span>
                <span class="mx-2 text-gray-300">•</span>
                <span class="inline-flex items-center gap-1">
                  <i class="fa-solid fa-book text-[10px]"></i> Tugas
                </span>
              </p>
            </div>
          </div>

          <!-- Kanan -->
          <div class="flex flex-wrap gap-2">
            @if (Auth::user()->hasRole('Siswa'))
              <a href="{{ route('lihatTugas', $tugass->id) }}"
                 class="flex items-center gap-1 bg-[#F8FAFC] text-[#0A090B] text-xs px-3 py-1.5 rounded-full font-medium border border-gray-200 hover:bg-[#EEF4FF] hover:text-[#2B82FE] transition duration-200">
                <i class="fa-solid fa-eye text-[12px]"></i> Lihat
              </a>
            @endif

            @if (Auth::user()->hasRole('Pengajar'))
              <a href="{{ route('viewTugas', $tugass->id) }}"
                 class="flex items-center gap-1 bg-[#F8FAFC] text-[#0A090B] text-xs px-3 py-1.5 rounded-full font-medium border border-gray-200 hover:bg-[#EEF4FF] hover:text-[#2B82FE] transition duration-200">
                <i class="fa-solid fa-eye text-[12px]"></i> Lihat
              </a>

              <a href="{{ route('viewUpdateTugas', $tugass->id) }}"
                 class="flex items-center gap-1 bg-amber-50 text-amber-700 text-xs px-3 py-1.5 rounded-full font-medium border border-amber-200 hover:bg-amber-100 transition duration-200">
                <i class="fa-solid fa-pen text-[12px]"></i> Edit
              </a>

              <a href="#"
                 onclick="event.preventDefault(); handleDeleteTugas('{{ route('tugas.destroy', $tugass->id) }}');"
                 class="flex items-center gap-1 bg-rose-50 text-rose-700 text-xs px-3 py-1.5 rounded-full font-medium border border-rose-200 hover:bg-rose-100 transition duration-200">
                <i class="fa-solid fa-trash text-[12px]"></i> Hapus
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
