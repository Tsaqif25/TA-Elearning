@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full p-6 lg:px-10 mt-6 bg-[#FAFAFA] min-h-screen font-poppins">
  <!--  Header Kelas -->
  <div class="mb-6">
    <div class="flex items-center gap-4">
      <a href="{{ route('viewKelasMapel', [
          'mapel' => $kelasMapel->mapel->id,
          'kelas' => $kelasMapel->kelas->id,
          'tab' => 'materi',
      ]) }}" 
         class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-transparent hover:border-gray-200 shadow-sm hover:shadow-md transition">
        <i class="fa-solid fa-arrow-left text-gray-700"></i>
      </a>

      <div>
        <h1 class="text-2xl font-extrabold text-[#0A090B] leading-tight">
          {{ $kelasMapel->kelas->name }} — {{ $kelasMapel->mapel->name }}
        </h1>
        <p class="text-sm text-[#7F8190]">Perbarui materi pembelajaran untuk siswa</p>
      </div>
    </div>
  </div>

  <!--  Card Form -->
  <div class="bg-white rounded-2xl border border-[#E5E7EB] shadow-sm p-8 flex flex-col lg:flex-row gap-6">
    <!--  Kolom Kiri (Form) -->
    <div class="flex-1">
      <form id="formMateri" action="{{ route('materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <!-- Judul Materi -->
        <div>
          <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">Judul Materi <span class="text-red-500">*</span></label>
          <input type="text" id="name" name="name" value="{{ old('name', $materi->name) }}" 
            placeholder="Masukkan judul materi..." required
            class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition">
          @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Deskripsi -->
        <div>
          <label for="content" class="block text-sm font-semibold text-gray-800 mb-2">Deskripsi</label>
          <textarea id="content" name="content" rows="5" placeholder="Jelaskan tentang materi ini..."
            class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition resize-none">{{ old('content', $materi->content) }}</textarea>
        </div>

        <!-- Link YouTube -->
        <div>
          <label for="youtube_link" class="block text-sm font-semibold text-gray-800 mb-2">Link YouTube (bisa lebih dari satu, pisahkan dengan Enter)</label>
          <textarea id="youtube_link" name="youtube_link" rows="4"
            class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition resize-none"
            placeholder="Contoh: https://youtu.be/K7AIv3J-78g?si=CwIZwaMuWIIqB2iO">{{ $materi->youtube_link }}</textarea>
          @error('youtube_link')<p class="text-red-500 text-sm mt-1">{{ $materi->youtube_link }}</p>@enderror
        </div>

        <!-- Dropzone -->
        <div>
          <label class="block text-sm font-semibold text-gray-800 mb-2">Upload File Baru</label>
          <div id="my-dropzone" class="dropzone border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-xl p-10 text-center cursor-pointer transition">
            <i class="fa-solid fa-cloud-arrow-up text-4xl text-[#2B82FE] mb-3"></i>
            <p class="text-sm text-gray-600 font-medium">Seret file ke sini atau klik untuk mengunggah</p>
            <p class="text-xs text-gray-400 mt-1">Format: PDF, DOCX, PPTX, ZIP</p>
          </div>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end gap-3 mt-6">
          <a href="{{ route('viewKelasMapel', [ 'mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab' => 'materi' ]) }}"
             class="px-5 py-2.5 rounded-full border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">Batal</a>
          <button type="submit" id="btnSimpan"
            class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-gradient-to-r from-[#2B82FE] to-[#1a5fd4] text-white font-semibold shadow hover:opacity-90 transition">
            <i class="fa-solid fa-save"></i> Simpan Perubahan
          </button>
        </div>
      </form>
    </div>

    <!--  Kolom Kanan (File Lama) -->
    <div class="lg:w-[30%] bg-gray-50 border border-gray-200 rounded-2xl p-5 h-fit">
      <h3 class="font-bold text-[#0A090B] mb-3 text-sm flex items-center gap-2"><i class="fa-solid fa-folder-open text-[#2B82FE]"></i> File Lama</h3>
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
            <i class="fa-solid {{ $icon }} text-[#2B82FE] text-lg flex-shrink-0"></i>
            <a href="{{ route('getFile', $file->file) }}" target="_blank" class="text-sm text-gray-700 truncate hover:underline min-w-0">
              {{ Str::limit($file->file, 60) }}
            </a>
          </div>
          <form action="{{ route('materi.destroyFile', $materi->id) }}" method="POST" onsubmit="event.preventDefault(); handleDeleteMateri(this);" class="ml-4 flex-shrink-0">
            @csrf
            @method('DELETE')
            <input type="hidden" name="file_id" value="{{ $file->id }}">
            <button type="submit" class="inline-flex items-center gap-2 text-red-500 hover:text-red-700 text-xs font-medium">
              <i class="fa-solid fa-trash"></i><span>Hapus</span>
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
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
    customClass: {
      popup: 'rounded-2xl shadow-lg',
      confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg mx-1 text-sm',
      cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded-lg mx-1 text-sm',
    },
    buttonsStyling: false
  }).then((result) => {
    if (result.isConfirmed) {
      form.submit();
      Swal.fire({ title: 'Terhapus!', text: 'Materi berhasil dihapus.', icon: 'success', timer: 1500, showConfirmButton: false });
    }
  });
}

Dropzone.autoDiscover = false;
const myDropzone = new Dropzone("#my-dropzone", {
  url: "/materi/{{ $materi->id }}/upload-file",
  paramName: "file",
  maxFilesize: 10,
  acceptedFiles: ".jpg,.jpeg,.png,.gif,.mp4,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.mp3,.avi,.mov",
  addRemoveLinks: true,
  timeout: 60000,
  dictDefaultMessage: "Seret file ke sini atau klik untuk mengunggah",
  autoProcessQueue: false,
  parallelUploads: 100,
  headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
});

myDropzone.on("queuecomplete", function () {
  Toastify({ text: "Semua file berhasil diunggah — mengalihkan...", duration: 1000, gravity: "top", position: "right", style: { background: "#16a34a" } }).showToast();
  setTimeout(() => window.location.href = "{{ route('viewKelasMapel', ['mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab' => 'materi']) }}", 1000);
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
        if (myDropzone.getQueuedFiles().length === 0) {
          Toastify({ text: "Perubahan berhasil disimpan!", duration: 1500, gravity: "top", position: "right", style: { background: "#16a34a" } }).showToast();
          setTimeout(() => window.location.href = "{{ route('viewKelasMapel', ['mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab' => 'materi']) }}", 1500);
        } else {
          myDropzone.processQueue();
        }
      },
      error: function () {
        Toastify({ text: "Terjadi kesalahan saat menyimpan materi.", duration: 3000, gravity: "top", position: "right", style: { background: "#dc2626" } }).showToast();
      }
    });
  });
});
</script>
@endsection