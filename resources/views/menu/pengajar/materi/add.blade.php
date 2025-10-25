@extends('layout.template.mainTemplate')

@section('container')


<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
  <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

    <!-- 🔹 Tombol Back -->
    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'materi'
    ]) }}"
       class="flex items-center gap-2 text-[#2B82FE] hover:text-[#1a5fd4] font-medium text-sm mb-6 transition">
      <i class="fa-solid fa-arrow-left text-xs"></i>
      Kembali ke Daftar Materi
    </a>

    <!-- 🔸 Header Informasi -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-8 flex items-start sm:items-center justify-between flex-wrap gap-4">
      <div class="flex items-start sm:items-center gap-3">
        <div class="w-1.5 h-8 rounded-full bg-[#2B82FE]"></div>
        <div>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0A090B] leading-tight">
            {{ $kelasMapel->kelas->name }} — {{ $kelasMapel->mapel->name }}
          </h1>
          <p class="text-sm text-[#7F8190]">Upload materi pembelajaran untuk siswa</p>
        </div>
      </div>

      <!-- Optional Badge -->
      <div class="flex items-center gap-2 bg-[#E8F0FF] text-[#2B82FE] px-3 py-1 rounded-full text-xs font-semibold">
        <i class="fa-solid fa-circle-plus text-[10px]"></i> Tambah Materi
      </div>
    </div>

    <!-- 🔷 Card Form Utama -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8 flex flex-col lg:flex-row gap-6">

      <!-- Kiri: Form -->
      <div class="flex-1">
        <form id="formMateri" action="{{ route('materi.store', $kelasMapel->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
          @csrf

          <!-- Judul -->
          <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">
              Judul Materi <span class="text-red-500">*</span>
            </label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
              placeholder="Masukkan judul materi..." required
              class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition placeholder:text-gray-400">
            @error('name')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Deskripsi -->
          <div>
            <label for="content" class="block text-sm font-semibold text-gray-800 mb-2">
              Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea id="content" name="content" rows="5"
              placeholder="Jelaskan tentang materi ini..."
              class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition resize-none placeholder:text-gray-400">{{ old('content') }}</textarea>
          </div>

          <!-- Link YouTube -->
          <div>
            <label for="youtube_link" class="block text-sm font-semibold text-gray-800 mb-2">
              Link YouTube (bisa lebih dari satu, pisahkan dengan Enter)
            </label>
            <textarea id="youtube_link" name="youtube_link" rows="3"
              placeholder="Contoh: https://youtu.be/abcd1234"
              class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition resize-none placeholder:text-gray-400">{{ old('youtube_link') }}</textarea>
            @error('youtube_link')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Dropzone -->
          <div>
            <label class="block text-sm font-semibold text-gray-800 mb-2">
              Upload File <span class="text-red-500">*</span>
            </label>
            <div id="my-dropzone"
              class="dropzone border-2 border-dashed border-gray-300 bg-[#F9FAFB] hover:bg-[#F3F6FF] rounded-xl p-10 text-center cursor-pointer transition">
              <i class="fa-solid fa-cloud-arrow-up text-4xl text-[#2B82FE] mb-3"></i>
              <p class="text-sm text-[#7F8190] font-medium">
                Seret file ke sini atau klik untuk mengunggah
              </p>
              <p class="text-xs text-gray-400 mt-1">
                (PDF, DOCX, PPTX, ZIP, MP4, dsb. — maks 10 MB)
              </p>
            </div>
          </div>

          <!-- Tombol -->
          <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('viewKelasMapel', [
                'mapel' => $kelasMapel->mapel->id,
                'kelas' => $kelasMapel->kelas->id,
                'tab' => 'materi'
            ]) }}"
              class="px-5 py-2.5 rounded-full border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">
              Batal
            </a>
            <button type="submit" id="btnSimpan"
              class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-gradient-to-r from-[#2B82FE] to-[#1a5fd4] text-white font-semibold shadow hover:opacity-90 transition">
              <i class="fa-solid fa-upload"></i> Upload Materi
            </button>
          </div>
        </form>
      </div>

      <!-- Kanan: Catatan -->
      <div class="lg:w-[30%] bg-[#F9FAFB] border border-gray-200 rounded-2xl p-6 h-fit">
        <h3 class="font-bold text-[#0A090B] mb-3 text-sm uppercase tracking-wide">Catatan</h3>
        <ul class="list-disc list-inside text-sm text-[#7F8190] space-y-2">
          <li>Pastikan file dapat diakses dengan baik.</li>
          <li>Gunakan judul yang jelas dan deskriptif.</li>
          <li>Periksa kualitas file sebelum upload.</li>
          <li>Gunakan format standar (PDF, DOCX, ZIP, MP4, dsb).</li>
        </ul>
      </div>
    </div>
  </div>
</div>


{{-- ========================== --}}
{{--  SCRIPT DROPZONE & TOASTIFY --}}
{{-- ========================== --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
Dropzone.autoDiscover = false;

let savedMateriId = null;

const myDropzone = new Dropzone("#my-dropzone", {
  url: "#", // akan diubah setelah materi tersimpan
  paramName: "file",
  maxFilesize: 10,
  acceptedFiles: ".jpg,.jpeg,.png,.gif,.mp4,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.mp3,.avi,.mov",
  addRemoveLinks: true,
  timeout: 5000,
  dictDefaultMessage: "Seret file ke sini atau klik untuk mengunggah",
  autoProcessQueue: false,
  parallelUploads: 100,
  headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
});

myDropzone.on("queuecomplete", function () {
  Toastify({
    text: "Semua file berhasil diunggah — mengalihkan...",
    duration: 900,
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
  }, 900);
});

$(document).ready(function () {
  $('#formMateri').submit(function (e) {
    e.preventDefault();

    if (myDropzone.getQueuedFiles().length === 0) {
      Toastify({
        text: "Silakan unggah minimal satu file sebelum menyimpan materi.",
        duration: 2500,
        gravity: "top",
        position: "right",
        style: { background: "#f59e0b" }
      }).showToast();
      return;
    }

    let formData = new FormData(this);

    $.ajax({
      type: 'POST',
      url: $(this).attr('action'),
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        savedMateriId = response.materi_id;

        Toastify({
          text: "Data materi tersimpan. Mulai mengunggah file…",
          duration: 2000,
          gravity: "top",
          position: "right",
          style: { background: "#16a34a" }
        }).showToast();

        myDropzone.options.url = "/materi/" + savedMateriId + "/upload-file";
        myDropzone.processQueue();
      },
      error: function () {
        Toastify({
          text: "Terjadi kesalahan saat menyimpan materi.",
          duration: 3000,
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
