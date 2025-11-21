@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
  <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

    <!-- HEADER GRADIENT EDIT (SAMA STRUCTURE DENGAN ADD) -->
    <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl p-6 shadow-lg w-full mb-6">

      <!-- Back Button -->
      <a href="{{ route('viewKelasMapel', [
          'mapel' => $kelasMapel->mapel->id,
          'kelas' => $kelasMapel->kelas->id,
          'tab' => 'materi'
      ]) }}"
        class="flex items-center gap-2 text-white/90 hover:text-white mb-4 font-medium text-sm transition">
        <i class="fa-solid fa-arrow-left text-xs"></i>
        Kembali ke Daftar Materi
      </a>

      <!-- Title -->
      <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
        {{ $kelasMapel->kelas->name }} — {{ $kelasMapel->mapel->name }}
      </h1>

      <p class="text-sm opacity-90">Perbarui materi pembelajaran untuk siswa</p>

    </div>

    <!-- Form Utama -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8 flex flex-col lg:flex-row gap-6">

      <!-- Kiri: Form -->
      <div class="flex-1">
        <form id="formMateri" action="{{ route('materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
          @csrf
          @method('PUT')

          <!-- Judul -->
          <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">
              Judul Materi <span class="text-red-500">*</span>
            </label>
            <input type="text" id="name" name="name" value="{{ old('name', $materi->name) }}"
              placeholder="Masukkan judul materi..." required
              class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition placeholder:text-gray-400">
          </div>

          <!-- Deskripsi -->
          <div>
            <label for="konten" class="block text-sm font-semibold text-gray-800 mb-2">Deskripsi</label>
            <textarea id="konten" name="konten" rows="5" placeholder="Jelaskan tentang materi ini..."
              class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition resize-none placeholder:text-gray-400">{{ old('konten', $materi->konten) }}</textarea>
          </div>

          <!-- Link YouTube -->
          <div>
            <label for="youtube_link" class="block text-sm font-semibold text-gray-800 mb-2">
              Link YouTube (pisahkan dengan Enter jika lebih dari satu)
            </label>
            <textarea id="youtube_link" name="youtube_link" rows="3"
              class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition resize-none placeholder:text-gray-400"
              placeholder="https://youtu.be/abcd1234">{{ old('youtube_link', $materi->youtube_link) }}</textarea>
          </div>

          <!-- Dropzone -->
          <div>
            <label class="block text-sm font-semibold text-gray-800 mb-2">Upload File Baru</label>
            <div id="my-dropzone" class="dropzone border-2 border-dashed border-gray-300 bg-[#F9FAFB] hover:bg-[#F3F6FF] rounded-xl p-10 text-center cursor-pointer transition">
              <i class="fa-solid fa-cloud-arrow-up text-4xl text-[#2B82FE] mb-3"></i>
              <p class="text-sm text-[#7F8190] font-medium">Seret file ke sini atau klik untuk mengunggah</p>
              <p class="text-xs text-gray-400 mt-1">(PDF, DOCX, PPTX, ZIP, MP4, dsb. — maks 10 MB)</p>
            </div>
          </div>

          <!-- Tombol -->
          <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('viewKelasMapel', ['mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab' => 'materi']) }}"
              class="px-5 py-2.5 rounded-full border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">
              Batal
            </a>
            <button type="submit" id="btnSimpan"
              class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-gradient-to-r from-[#2B82FE] to-[#1a5fd4] text-white font-semibold shadow hover:opacity-90 transition">
              <i class="fa-solid fa-save"></i> Simpan Perubahan
            </button>
          </div>
        </form>
      </div>

      <!-- File Lama -->
      <div class="lg:w-[30%] bg-[#F9FAFB] border border-gray-200 rounded-2xl p-6 h-fit">
        <h3 class="font-bold text-[#0A090B] mb-3 text-sm flex items-center gap-2">
          <i class="fa-solid fa-folder-open text-[#2B82FE]"></i> File Lama
        </h3>
        <div class="divide-y divide-gray-100">
          @forelse ($materi->files as $file)
            <div class="flex items-center justify-between py-3">
              <div class="flex items-center gap-3 min-w-0">
                <i class="fa-solid fa-file text-[#2B82FE] text-lg"></i>
                <a href="{{ asset('storage/materi/' . $materi->id . '/' . basename($file->file)) }}"
                  target="_blank"
                  class="font-medium text-sm text-[#0A090B] hover:text-[#2B82FE] truncate">
                  {{ basename($file->file) }}
                </a>
              </div>
              <form action="{{ route('materi.destroyFile', $materi->id) }}" method="POST" onsubmit="event.preventDefault(); handleDeleteMateri(this);" class="ml-4 flex-shrink-0">
                @csrf
                @method('DELETE')
                <input type="hidden" name="file_id" value="{{ $file->id }}">
                <button type="submit" class="inline-flex items-center gap-1 text-rose-500 hover:text-rose-700 text-xs font-medium transition">
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
</div>


{{-- ========================== --}}
{{-- SCRIPT DROPZONE & ALERT --}}
{{-- ========================== --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function handleDeleteMateri(form) {
  Swal.fire({
    title: 'Yakin ingin menghapus?',
    text: 'File ini akan dihapus permanen.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      form.submit();
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
  autoProcessQueue: false,
  headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
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
        Toastify({ text: "Terjadi kesalahan saat menyimpan.", duration: 3000, gravity: "top", position: "right", style: { background: "#dc2626" } }).showToast();
      }
    });
  });

  myDropzone.on("queuecomplete", function () {
    Toastify({ text: "Semua file berhasil diunggah!", duration: 1000, gravity: "top", position: "right", style: { background: "#16a34a" } }).showToast();
    setTimeout(() => window.location.href = "{{ route('viewKelasMapel', ['mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab' => 'materi']) }}", 1000);
  });
});
</script>
@endsection
