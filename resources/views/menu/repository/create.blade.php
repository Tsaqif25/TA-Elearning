@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full p-6 lg:px-10 mt-6 bg-[#FAFAFA] min-h-screen font-poppins">

  <!-- 🔹 Tombol Back -->
  <div class="mb-6">
    <a href="{{ route('repository.index') }}"
       class="flex items-center gap-2 text-[#2B82FE] hover:text-[#1a5fd4] font-medium text-sm transition">
      <i class="fa-solid fa-arrow-left text-xs"></i>
      Kembali ke Repository
    </a>
  </div>

  <!-- Header -->
  <div class="mb-6">
    <div class="flex items-center gap-4">
  

      <div>
        <h1 class="text-2xl font-extrabold text-[#0A090B] leading-tight">
          Upload Materi ke Repository
        </h1>
        <p class="text-sm text-[#7F8190]">Unggah materi pembelajaran untuk repository publik</p>
      </div>
    </div>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-[#E5E7EB] shadow-sm p-8 flex flex-col lg:flex-row gap-6">
    <!-- Kolom Kiri (Form) -->
    <div class="flex-1">
      <form id="formRepository" action="{{ route('repository.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- Judul -->
        <div>
          <label for="judul" class="block text-sm font-semibold text-gray-800 mb-2">Judul Materi <span class="text-red-500">*</span></label>
          <input type="text" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul materi..."
                 required class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition">
        </div>

        <!-- Kelas dan Jurusan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold text-gray-800 mb-2">Kelas</label>
            <select name="kelas" class="w-full border border-gray-200 rounded-xl p-3 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20">
              <option value="">Pilih Kelas</option>
              <option value="10">Kelas 10</option>
              <option value="11">Kelas 11</option>
              <option value="12">Kelas 12</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-800 mb-2">Jurusan</label>
            <select name="jurusan" class="w-full border border-gray-200 rounded-xl p-3 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20">
           <option value="">Pilih Jurusan</option>
        <option value="PPLG">Pengembangan Perangkat luank dan Gim</option>
        <option value="TKJ">Teknik Jaringan Komputer dan Telekomunikasi</option>
        <option value="ULW"> Usaha Layanan Wisata</option>
        <option value="MPLB">Manajemen Perkantoran dan Layanan Bisnis</option>
        <option value="AKL">Akuntansi dan Keuangan Lembaga</option>
         <option value="BDR">Bisnis Digital dan Retail</option>
           <option value="Umum">Umum</option>
            </select>
          </div>
        </div>

        <!-- Deskripsi -->
        <div>
          <label for="deskripsi" class="block text-sm font-semibold text-gray-800 mb-2">Deskripsi Materi</label>
          <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan isi materi..."
                    class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition resize-none">{{ old('deskripsi') }}</textarea>
        </div>

        <!-- Link YouTube -->
        <div>
          <label for="youtube_link" class="block text-sm font-semibold text-gray-800 mb-2">Link YouTube (Opsional)</label>
          <textarea id="youtube_link" name="youtube_link" rows="3" placeholder="https://youtu.be/abcd1234"
                    class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition resize-none">{{ old('youtube_link') }}</textarea>
        </div>

        <!-- Dropzone -->
        <div>
          <label class="block text-sm font-semibold text-gray-800 mb-2">Upload File</label>
          <div id="my-dropzone" class="dropzone border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-xl p-10 text-center cursor-pointer transition">
            <i class="fa-solid fa-cloud-arrow-up text-4xl text-[#2B82FE] mb-3"></i>
            <p class="text-sm text-gray-500">Seret file ke sini atau klik untuk mengunggah</p>
          </div>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end gap-3 mt-6">
          <a href="{{ route('repository.index') }}" class="px-5 py-2.5 rounded-full border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">Batal</a>
          <button type="submit" id="btnSimpan" class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-gradient-to-r from-[#2B82FE] to-[#1a5fd4] text-white font-semibold shadow hover:opacity-90 transition">
            <i class="fa-solid fa-upload"></i> Upload Repository
          </button>
        </div>
      </form>
    </div>

    <!-- Kolom Kanan -->
    <div class="lg:w-[30%] bg-gray-50 border border-gray-200 rounded-2xl p-5 h-fit">
      <h3 class="font-bold text-[#0A090B] mb-3 text-sm">CATATAN</h3>
      <ul class="list-disc list-inside text-sm text-[#7F8190] space-y-2">
        <li>Gunakan nama file dan judul yang jelas.</li>
        <li>Format file yang diizinkan: PDF, DOCX, PPTX, ZIP, MP4, dsb.</li>
        <li>File akan masuk ke repository publik setelah disetujui.</li>
      </ul>
    </div>
  </div>
</div>


<!-- ========================== -->
<!-- SCRIPT DROPZONE & TOASTIFY -->
<!-- ========================== -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
Dropzone.autoDiscover = false;
let savedRepoId = null;

const myDropzone = new Dropzone("#my-dropzone", {
  url: "#", // akan diubah setelah repository tersimpan
  paramName: "file",
  maxFilesize: 10,
  acceptedFiles: ".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.mp4,.jpg,.png",
  addRemoveLinks: true,
  timeout: 5000,
  autoProcessQueue: false,
  parallelUploads: 50,
  headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
});

myDropzone.on("queuecomplete", function () {
  Toastify({
    text: "Semua file berhasil diunggah!",
    duration: 900,
    gravity: "top",
    position: "right",
    style: { background: "#16a34a" }
  }).showToast();

  setTimeout(() => window.location.href = "{{ route('repository.index') }}", 900);
});

$('#formRepository').submit(function (e) {
  e.preventDefault();
  if (myDropzone.getQueuedFiles().length === 0) {
    Toastify({ text: "Silakan unggah minimal 1 file.", duration: 2500, gravity: "top", position: "right", style: { background: "#f59e0b" } }).showToast();
    return;
  }

  const formData = new FormData(this);
  $.ajax({
    type: 'POST',
    url: $(this).attr('action'),
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      savedRepoId = response.repository_id;
      Toastify({ text: "Data repository tersimpan, mulai upload file…", duration: 2000, gravity: "top", position: "right", style: { background: "#16a34a" } }).showToast();
      myDropzone.options.url = "/repository/" + savedRepoId + "/upload-file";
      myDropzone.processQueue();
    },
    error: function () {
      Toastify({ text: "Gagal menyimpan repository.", duration: 3000, gravity: "top", position: "right", style: { background: "#dc2626" } }).showToast();
    }
  });
});
</script>
@endsection
