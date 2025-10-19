@extends('layout.template.mainTemplate')

@section('container')
    <div class="flex flex-col mb-8">
  <div class="flex items-center gap-4">
    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'materi'
    ]) }}" 
       class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-transparent hover:border-gray-200 shadow-sm hover:shadow-md transition">
      <i class="fa-solid fa-arrow-left text-gray-700"></i>
    </a>

    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B] leading-tight">
        {{ $kelasMapel->kelas->name }}
      </h1>
      <p class="text-sm text-[#7F8190] font-medium">
        {{ $kelasMapel->mapel->name }}
      </p>
    </div>
  </div>

  {{-- Judul Tambah Materi --}}
  <div class="mt-6">
    <h2 class="text-xl font-bold text-[#0A090B]">Edit Materi</h2>
    <p class="text-sm text-[#7F8190]">Perbarui materi pembelajaran untuk siswa</p>
  </div>
</div>

    {{-- Form Container --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom kiri: Form --}}
        <div class="col-span-2 bg-white border-2 border-black rounded-2xl shadow-sm p-6">
            <form id="formMateri" action="{{ route('materi.update', $materi->id) }}" method="POST"
                enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')
                {{-- Judul Materi --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">
                        Judul Materi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" class="w-full px-5 py-3 rounded-2xl  border-1 border-black bg-gray-50 
                               text-gray-800 placeholder-gray-400 
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                               focus:bg-white shadow-sm transition-all duration-200" placeholder="Masukkan judul materi..."
                        value="{{ old('name', $materi->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mt-5">
                    <label for="content" class="block text-sm font-semibold text-gray-800 mb-2">
                        Deskripsi 
                    </label>
                    <textarea id="content" name="content" rows="6" class="w-full px-5 py-3 rounded-2xl  border-1 border-black bg-gray-50 
                               text-gray-800 placeholder-gray-400 
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                               focus:bg-white shadow-sm transition-all duration-200 resize-none"
                        placeholder="Jelaskan tentang materi ini...">{{ old('content', $materi->content) }}</textarea>
                </div>

                        <div class="mt-5">
                    <label for="youtube_link" class="block text-sm font-semibold text-gray-800 mb-2">
                        Link YouTube (bisa lebih dari satu, pisahkan dengan Enter)
                    </label>
                    <textarea id="youtube_link" name="youtube_link" rows="4"
                        class="w-full px-5 py-3 rounded-2xl border-1 border-black bg-gray-50 text-gray-800 placeholder-gray-400
    focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white shadow-sm transition-all duration-200 resize-none"
                        placeholder="Contoh: https://youtu.be/K7AIv3J-78g?si=CwIZwaMuWIIqB2iO">{{ $materi->youtube_link}}</textarea>
                    @error('youtube_link')
                        <p class="text-red-500 text-sm mt-1">{{ $materi->youtube_link}}</p>
                    @enderror
                </div>

                {{-- Upload File (Dropzone) --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1">
                        Upload File Baru 
                    </label>
                    <div id="my-dropzone"
                        class="dropzone rounded-2xl  border-1 border-black bg-gray-50 p-8 text-center">
                    </div>
                </div>

                {{-- Tombol Submit --}}
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'materi'
    ]) }}"
                        class="px-6 py-3 rounded-xl border-1 border-black  text-gray-700 font-medium hover:bg-gray-100 transition">
                        Batal
                    </a>
                    <button type="submit" id="btnSimpan"
                        class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition flex items-center gap-2">
                        <i class="fa-solid fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Kolom kanan: Catatan + File Lama --}}
        <div class="space-y-5">
            {{-- Catatan --}}
            <div class="bg-white border-2 border-black rounded-2xl shadow-sm p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">CATATAN</h3>
                <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
                    <li>Pastikan file dapat diakses dengan baik</li>
                    <li>Gunakan nama file yang jelas dan deskriptif</li>
                    <li>File lama dapat dihapus di bawah</li>
                </ul>
            </div>

            {{-- File Lama --}}
            <div class="bg-white border-2 border-black  rounded-2xl shadow-sm p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-folder-open text-indigo-600"></i> File Lama
                </h3>
              <div class="divide-y divide-gray-100">
  @forelse ($materi->files as $file)
    <div class="flex items-center justify-between py-3">
      <div class="flex items-center gap-3 min-w-0">
        @php
          $icon = 'fa-file';
          if (Str::endsWith($file->file, ['.jpg', '.jpeg', '.png', '.gif'])) $icon = 'fa-image';
          elseif (Str::endsWith($file->file, ['.mp4', '.avi', '.mov'])) $icon = 'fa-video';
          elseif (Str::endsWith($file->file, ['.pdf'])) $icon = 'fa-file-pdf';
          elseif (Str::endsWith($file->file, ['.doc', '.docx'])) $icon = 'fa-file-word';
          elseif (Str::endsWith($file->file, ['.ppt', '.pptx'])) $icon = 'fa-file-powerpoint';
          elseif (Str::endsWith($file->file, ['.xls', '.xlsx'])) $icon = 'fa-file-excel';
          elseif (Str::endsWith($file->file, ['.txt'])) $icon = 'fa-file-alt';
          elseif (Str::endsWith($file->file, ['.mp3'])) $icon = 'fa-music';
        @endphp

        <i class="fa-solid {{ $icon }} text-indigo-600 text-lg flex-shrink-0"></i>

        {{-- Link + nama file: take remaining space, truncate if long --}}
        <a href="{{ route('getFile', $file->file) }}"
           target="_blank"
           class="text-sm text-gray-700 truncate hover:underline min-w-0">
          {{ Str::limit($file->file, 60) }}
        </a>
      </div>

      {{-- Tombol Hapus: tetap di kanan, tidak mendorong keluar --}}
      <form action="{{ route('materi.destroyFile', $materi->id) }}" method="POST"
            onsubmit="event.preventDefault(); handleDeleteMateri(this);"
            class="ml-4 flex-shrink-0">
        @csrf
        @method('DELETE')
        <input type="hidden" name="file_id" value="{{ $file->id }}">
        <button type="submit"
                class="inline-flex items-center gap-2 text-red-500 hover:text-red-700 text-xs font-medium">
          <i class="fa-solid fa-trash"></i>
          <span>Hapus</span>
        </button>
      </form>
    </div>
  @empty
    <p class="text-gray-500 text-sm italic py-2">Belum ada file yang diunggah.</p>
  @endforelse
</div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
function handleDeleteMateri(form) {
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

    <script>


        Dropzone.autoDiscover = false;

        const myDropzone = new Dropzone("#my-dropzone", {
            url: "/materi/{{ $materi->id }}/upload-file",
            paramName: "file",
            maxFilesize: 10, // MB
            acceptedFiles: ".jpg,.jpeg,.png,.gif,.mp4,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.mp3,.avi,.mov",
            addRemoveLinks: true,
            timeout: 60000,
            dictDefaultMessage: "Seret file ke sini atau klik untuk mengunggah",
            autoProcessQueue: false,
            parallelUploads: 100,
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        });

        myDropzone.on("queuecomplete", function () {
            Toastify({
                text: "Semua file berhasil diunggah — mengalihkan...",
                duration: 1000,
                close: false,
                gravity: "top",
                position: "right",
                style: { background: "#16a34a" }
            }).showToast();

            setTimeout(function () {
                window.location.href = "{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'materi'
    ]) }}";
            }, 1000);
        });

        $(document).ready(function () {
            $('#formMateri').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response);

                        if (myDropzone.getQueuedFiles().length === 0) {
                            // ✅ Jika tidak ada file, tetap redirect dan tampilkan toast sukses hijau
                            Toastify({
                                text: "Perubahan berhasil disimpan!",
                                duration: 1500,
                                close: false,
                                gravity: "top",
                                position: "right",
                                style: { background: "#16a34a" }
                            }).showToast();

                            setTimeout(function () {
                                window.location.href = "{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'materi'
    ]) }}";
                            }, 1500);
                        } else {
                            myDropzone.processQueue();
                        }
                    },
                    error: function () {
                        Toastify({
                            text: "Terjadi kesalahan saat menyimpan materi.",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            style: { background: "#dc2626" }
                        }).showToast();
                    }
                });
            });
        });
    </script>

@endsection