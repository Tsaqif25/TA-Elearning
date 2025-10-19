@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col mb-8">
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
        {{ $kelasMapel->kelas->name }}
      </h1>
      <p class="text-sm text-[#7F8190] font-medium">
        {{ $kelasMapel->mapel->name }}
      </p>
    </div>
  </div>

  {{-- Judul Tambah Materi --}}
  <div class="mt-6">
    <h2 class="text-xl font-bold text-[#0A090B]">Tambah Materi</h2>
    <p class="text-sm text-[#7F8190]">Upload materi pembelajaran untuk siswa</p>
  </div>
</div>
    {{-- Form Container --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom kiri: Form --}}
        <div class="col-span-2 bg-white border-2 border-black  rounded-2xl shadow-sm p-6">
            <form id="formMateri" action="{{ route('materi.store', $kelasMapel->id) }}" method="POST"
                enctype="multipart/form-data" class="space-y-5">
                @csrf
                {{-- Judul Materi --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">
                        Judul Materi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" class="w-full px-5 py-3 rounded-2xl border-1 border-black bg-gray-50 
                       text-gray-800 placeholder-gray-400 
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                       focus:bg-white shadow-sm transition-all duration-200" placeholder="Masukkan judul materi..."
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi / Konten Materi --}}
                <div class="mt-5">
                    <label for="content" class="block text-sm font-semibold text-gray-800 mb-2">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" name="content" rows="6" class="w-full px-5 py-3 rounded-2xl border-1 border-black bg-gray-50 
                       text-gray-800 placeholder-gray-400 
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                       focus:bg-white shadow-sm transition-all duration-200 resize-none"
                        placeholder="Jelaskan tentang materi ini...">{{ old('content') }}</textarea>
                </div>

                
                <div class="mt-5">
                    <label for="youtube_link" class="block text-sm font-semibold text-gray-800 mb-2">
                        Link YouTube (bisa lebih dari satu, pisahkan dengan Enter)
                    </label>
                    <textarea id="youtube_link" name="youtube_link" rows="4"
                        class="w-full px-5 py-3 rounded-2xl border-1 border-black bg-gray-50 text-gray-800 placeholder-gray-400
    focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white shadow-sm transition-all duration-200 resize-none"
                        placeholder="Contoh: https://youtu.be/K7AIv3J-78g?si=CwIZwaMuWIIqB2iO">{{ old('youtube_link') }}</textarea>
                    @error('youtube_link')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload File (Dropzone) --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1">
                        Upload File <span class="text-red-500">*</span>
                    </label>

                    <div id="my-dropzone" class="dropzone rounded-2xl  border-1 border-black bg-gray-50 p-8 text-center">
                    </div>
                </div>

                {{-- Tombol Submit --}}
                <div class="flex justify-end gap-3 pt-4">

                    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'materi'
    ]) }}" class="px-6 py-3 rounded-xl border-1 border-black text-gray-700 font-medium hover:bg-gray-100 transition"">
                        Batal
                    </a>
                            <button type=" submit" id="btnSimpan"
                        class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition flex items-center gap-2">
                        <i class="fa-solid fa-upload"></i> Upload Materi
                        </button>
                </div>
            </form>
        </div>

        {{-- Kolom kanan: Preview + Catatan --}}
        <div class="space-y-5">

            {{-- Catatan --}}
            <div class="bg-white border-2 border-black rounded-2xl shadow-sm p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">CATATAN</h3>
                <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
                    <li>Pastikan file dapat diakses dengan baik</li>
                    <li>Gunakan judul yang jelas dan deskriptif</li>
                    <li>Periksa kualitas file sebelum upload</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- CDN: jQuery, Dropzone, Dropzone CSS, Toastify CSS & JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        Dropzone.autoDiscover = false;

        let savedMateriId = null;

        const myDropzone = new Dropzone("#my-dropzone", {
            url: "#", // akan diganti setelah form materi disimpan
            paramName: "file",
            maxFilesize: 10, // MB
            acceptedFiles: ".jpg,.jpeg,.png,.gif,.mp4,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.mp3,.avi,.mov",
            addRemoveLinks: true,
            timeout: 5000,
            dictDefaultMessage: "Seret file ke sini atau klik untuk mengunggah",
            autoProcessQueue: false,
            parallelUploads: 100,
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        });

        // ✅ Redirect hanya kalau file berhasil semua diupload (tampilkan toast dulu lalu redirect)
        myDropzone.on("queuecomplete", function () {
            Toastify({
                text: "Semua file berhasil diunggah — mengalihkan...",
                duration: 900,
                close: false,
                gravity: "top",
                position: "right",
                style: { background: "#16a34a" } // hijau
            }).showToast();

            setTimeout(function () {
                window.location.href = "{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'materi'
    ]) }}";
            }, 900);
        });

        // ✅ Proses submit form hanya jika ada file
        $(document).ready(function () {
            $('#formMateri').submit(function (e) {
                e.preventDefault();

                if (myDropzone.getQueuedFiles().length === 0) {
                    // **Ganti alert dengan toast (peringatan kecil)**
                    Toastify({
                        text: "Silakan unggah minimal satu file sebelum menyimpan materi.",
                        duration: 2500,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: { background: "#f59e0b" } // kuning/orange
                    }).showToast();
                    return; // hentikan proses
                }

                let formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response);
                        savedMateriId = response.materi_id;

                        // **Tampilkan toast sukses kecil saat form berhasil disimpan (sebelum upload file)**
                        Toastify({
                            text: "Data materi tersimpan. Mulai mengunggah file…",
                            duration: 2000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            style: { background: "#16a34a" } // hijau
                        }).showToast();

                        // Setelah form tersimpan → lanjut upload file
                        myDropzone.options.url = "/materi/" + savedMateriId + "/upload-file";
                        myDropzone.processQueue();
                    },
                    error: function (xhr, status, error) {
                        // **Ganti alert error dengan toast merah**
                        Toastify({
                            text: "Terjadi kesalahan saat menyimpan materi.",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            style: { background: "#dc2626" } // merah
                        }).showToast();
                    }
                });
            });
        });
    </script>
@endsection