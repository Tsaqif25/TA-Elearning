@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
  <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

  
    <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl p-6 shadow-lg w-full mb-6 relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-tr from-blue-600/90 to-green-500/90 rounded-2xl"></div>

      <div class="relative z-10">

       
        <a href="{{ route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel->id,
            'kelas' => $kelasMapel->kelas->id,
            'tab'   => 'tugas'
        ]) }}"
           class="flex items-center gap-2 text-white/90 hover:text-white mb-4 font-medium text-sm transition">
          <i class="fa-solid fa-arrow-left text-xs"></i>
          Kembali ke Daftar Tugas
        </a>

      
        <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
          {{ $kelasMapel->kelas->name }} — {{ $kelasMapel->mapel->name }}
        </h1>

        <p class="text-sm opacity-90">Buat dan unggah tugas untuk siswa</p>

      </div>
    </div>

    
    <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-6 sm:p-8 flex flex-col lg:flex-row gap-8">

      <!-- Kolom Kiri: Form -->
      <div class="flex-1">
        <form id="formTugas"
              action="{{ route('guru.tugas.create', $kelasMapel->id) }}"
              method="POST"
              enctype="multipart/form-data">
          @csrf

       
          <div class="mb-5">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
              Judul Tugas <span class="text-red-500">*</span>
            </label>
            <input
              type="text"
              id="name"
              name="name"
              placeholder="Masukkan judul tugas..."
              value="{{ old('name') }}"
              required
              class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition">
            @error('name')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

        
          <div class="mb-5">
            <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
              Deskripsi / Konten <span class="text-red-500">*</span>
            </label>
            <textarea
              id="deskripsi"
              name="deskripsi"
              rows="5"
              placeholder="Tuliskan instruksi atau penjelasan tugas..."
              class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition resize-none"
              required>{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

        
          <div class="mb-5">
            <label for="due" class="block text-sm font-semibold text-gray-700 mb-2">
              Tanggal Jatuh Tempo <span class="text-red-500">*</span>
            </label>
            <input
              type="datetime-local"
              id="due"
              name="due"
              value="{{ old('due') }}"
              required
              class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition">
            @error('due')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

         
          <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Upload File (opsional)
            </label>
            <div id="my-dropzone"
                 class="dropzone border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-xl p-10 text-center cursor-pointer transition">
              <i class="fa-solid fa-cloud-arrow-up text-4xl text-[#2B82FE] mb-3"></i>
              <p class="text-sm text-gray-600 font-medium">Seret file ke sini atau klik untuk mengunggah</p>
              <p class="text-xs text-gray-400 mt-1">
                Format: PDF, DOCX, PPTX, ZIP, dll (maks 10MB)
              </p>
            </div>
          </div>

      
          <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('viewKelasMapel', [
                  'mapel' => $kelasMapel->mapel->id,
                  'kelas' => $kelasMapel->kelas->id,
                  'tab'   => 'tugas'
                ]) }}"
               class="px-5 py-2.5 rounded-full border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">
              Batal
            </a>
            <button type="submit" id="btnSimpan"
              class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-gradient-to-r from-[#2B82FE] to-[#1a5fd4] text-white font-semibold shadow hover:opacity-90 transition">
              <i class="fa-solid fa-paper-plane"></i> Simpan Tugas
            </button>
          </div>
        </form>
      </div>

      <!-- Kolom Kanan: Catatan -->
      <div class="lg:w-[30%] bg-gray-50 border border-gray-200 rounded-2xl p-5 h-fit">
        <h3 class="font-bold text-[#0A090B] mb-3 text-sm">CATATAN</h3>
        <ul class="list-disc list-inside text-sm text-[#7F8190] space-y-2">
          <li>Pastikan judul tugas jelas dan singkat.</li>
          <li>Deskripsi berisi instruksi yang mudah dipahami siswa.</li>
          <li>Tentukan tenggat waktu yang realistis.</li>
          <li>Upload file materi pendukung (jika ada).</li>
        </ul>
      </div>

    </div>

  </div>
</div>


{{-- CDN: jQuery, Dropzone, Toastify --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
  Dropzone.autoDiscover = false;
  let savedTugasId = null;

  const myDropzone = new Dropzone("#my-dropzone", {
    url: "#", // akan di-set ulang setelah tugas berhasil dibuat
    paramName: "file",
    maxFilesize: 10, // MB
    acceptedFiles: ".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar,.jpg,.jpeg,.png",
    addRemoveLinks: true,
    timeout: 60000,
    dictDefaultMessage: "Seret file ke sini atau klik untuk mengunggah",
    autoProcessQueue: false,
    parallelUploads: 20,
    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
  });

  // Setelah semua file selesai diupload → balik ke halaman kelas/mapel tab tugas
  myDropzone.on("queuecomplete", function () {
    window.location.href = "{{ route('viewKelasMapel', [
      'mapel' => $kelasMapel->mapel->id,
      'kelas' => $kelasMapel->kelas->id,
      'tab'   => 'tugas'
    ]) }}";
  });

  $(document).ready(function () {
    $('#formTugas').submit(function (e) {
      e.preventDefault();

      let formData = new FormData(this);

      $.ajax({
        type: 'POST',
        url: $(this).attr('action'), // route('guru.tugas.create', $kelasMapel->id)
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // response dari controller: ["success" => true, "tugas_id" => $tugas->id]
          savedTugasId = response.tugas_id;

          // Kalau tidak ada file di-dropzone → langsung redirect
          if (myDropzone.getQueuedFiles().length === 0) {
            window.location.href = "{{ route('viewKelasMapel', [
              'mapel' => $kelasMapel->mapel->id,
              'kelas' => $kelasMapel->kelas->id,
              'tab'   => 'tugas'
            ]) }}";
          } else {
            // Set URL upload file sesuai route:
            // Route::post('{tugas}/upload-file', 'store')->name('guru.tugas.file.upload');
           myDropzone.options.url = "/guru/tugas/" + savedTugasId + "/upload-file";

            myDropzone.processQueue();
          }
        },
        error: function (xhr) {
          let msg = "Terjadi kesalahan saat menyimpan tugas.";

          if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
            // Ambil error pertama dari validasi
            const firstKey = Object.keys(xhr.responseJSON.errors)[0];
            msg = xhr.responseJSON.errors[firstKey][0];
          }

          Toastify({
            text: msg,
            duration: 4000,
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
