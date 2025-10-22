@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col px-6 lg:px-10 mt-6">

  <!-- 🧱 Header -->
  <div class="mb-6">
    <div class="flex items-center gap-4">
      <a href="{{ route('viewKelasMapel', [ 'mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab' => 'tugas' ]) }}" 
         class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-transparent hover:border-gray-200 shadow-sm hover:shadow-md transition">
        <i class="fa-solid fa-arrow-left text-gray-700"></i>
      </a>
      <div>
        <h1 class="text-2xl font-extrabold text-[#0A090B] leading-tight">
          {{ $kelasMapel->kelas->name }} — {{ $kelasMapel->mapel->name }}
        </h1>
        <p class="text-sm text-[#7F8190]">Buat dan unggah tugas untuk siswa</p>
      </div>
    </div>
  </div>

  <!-- 🧩 Card Form -->
  <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-6 sm:p-8 flex flex-col lg:flex-row gap-8">

    <!-- Kolom Kiri -->
    <div class="flex-1">
      <form id="formTugas" action="{{ route('createTugas', $kelasMapel->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Judul -->
        <div class="mb-5">
          <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Judul Tugas <span class="text-red-500">*</span></label>
          <input type="text" id="name" name="name" placeholder="Masukkan judul tugas..." value="{{ old('name') }}" required
            class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition">
          @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Deskripsi -->
        <div class="mb-5">
          <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi / Konten <span class="text-red-500">*</span></label>
          <textarea id="content" name="content" rows="5" placeholder="Tuliskan instruksi atau penjelasan tugas..."
            class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition resize-none">{{ old('content') }}</textarea>
          @error('content')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Deadline -->
        <div class="mb-5">
          <label for="due" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Jatuh Tempo <span class="text-red-500">*</span></label>
          <input type="datetime-local" id="due" name="due" value="{{ old('due') }}" required
            class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition">
          @error('due')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Dropzone -->
        <div class="mb-6">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Upload File <span class="text-red-500">*</span></label>
          <div id="my-dropzone" class="dropzone border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-xl p-10 text-center cursor-pointer transition">
            <i class="fa-solid fa-cloud-arrow-up text-4xl text-[#2B82FE] mb-3"></i>
            <p class="text-sm text-gray-600 font-medium">Seret file ke sini atau klik untuk mengunggah</p>
            <p class="text-xs text-gray-400 mt-1">Format: PDF, DOCX, ZIP</p>
          </div>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end gap-3 mt-6">
          <a href="{{ route('viewKelasMapel', [ 'mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab'=> 'tugas' ]) }}"
             class="px-5 py-2.5 rounded-full border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">Batal</a>
          <button type="submit" id="btnSimpan"
            class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-gradient-to-r from-[#2B82FE] to-[#1a5fd4] text-white font-semibold shadow hover:opacity-90 transition">
            <i class="fa-solid fa-paper-plane"></i> Simpan Tugas
          </button>
        </div>
      </form>
    </div>

    <!-- Kolom Kanan (Catatan) -->
    <div class="lg:w-[30%] bg-gray-50 border border-gray-200 rounded-2xl p-5 h-fit">
      <h3 class="font-bold text-[#0A090B] mb-3 text-sm">CATATAN</h3>
      <ul class="list-disc list-inside text-sm text-[#7F8190] space-y-2">
        <li>Pastikan file sudah siap sebelum diunggah.</li>
        <li>Gunakan judul dan deskripsi yang jelas.</li>
        <li>Tentukan tenggat waktu yang realistis.</li>
        <li>Format file harus sesuai (PDF/DOCX/ZIP).</li>
      </ul>
    </div>
  </div>
</div>

<!-- CDN: jQuery, Dropzone, Toastify -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
Dropzone.autoDiscover = false;
let savedTugasId = null;

const myDropzone = new Dropzone("#my-dropzone", {
  url: "#",
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
  window.location.href = "{{ route('viewKelasMapel', [ 'mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab' => 'tugas' ]) }}";
});

$(document).ready(function () {
  $('#formTugas').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
      type: 'POST',
      url: $(this).attr('action'),
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        savedTugasId = response.tugas_id;

        if (myDropzone.getQueuedFiles().length === 0) {
          window.location.href = "{{ route('viewKelasMapel', [ 'mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab' => 'tugas' ]) }}";
        } else {
          myDropzone.options.url = "/tugas/" + savedTugasId + "/upload-file";
          myDropzone.processQueue();
        }
      },
      error: function () {
        Toastify({ text: "Terjadi kesalahan saat menyimpan tugas.", duration: 3000, gravity: "top", position: "right", style: { background: "#dc2626" } }).showToast();
      }
    });
  });
});
</script>
@endsection