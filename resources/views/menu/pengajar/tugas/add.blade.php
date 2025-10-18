@extends('layout.template.mainTemplate')

@section('container')

{{-- Header --}}

<div class="flex flex-col mb-8">
  <div class="flex items-center gap-4">
    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'tugas' 
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

  {{-- Judul Tambah Tugas --}}
  <div class="mt-6">
    <h2 class="text-xl font-bold text-[#0A090B]">Tambah Tugas</h2>
    <p class="text-sm text-[#7F8190]">Buat dan unggah tugas untuk siswa</p>
  </div>
</div>

{{-- Form Container --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Kolom kiri: Form --}}
    <div class="col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
        <form id="formTugas" action="{{ route('createTugas', $kelasMapel->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Judul Tugas --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">
                    Judul Tugas <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name"
                    class="w-full px-5 py-3 rounded-2xl border border-gray-300 bg-gray-50 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white shadow-sm transition-all duration-200"
                    placeholder="Masukkan judul tugas..." value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi / Konten Tugas --}}
            <div>
                <label for="content" class="block text-sm font-semibold text-gray-800 mb-2">
                    Deskripsi / Konten <span class="text-red-500">*</span>
                </label>
                <textarea id="content" name="content" rows="6"
                    class="w-full px-5 py-3 rounded-2xl border border-gray-300 bg-gray-50 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white shadow-sm transition-all duration-200 resize-none"
                    placeholder="Tuliskan instruksi atau penjelasan tugas...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Jatuh Tempo --}}
            <div>
                <label for="due" class="block text-sm font-semibold text-gray-800 mb-2">
                    Tanggal Jatuh Tempo <span class="text-red-500">*</span>
                </label>
                <input type="datetime-local" id="due" name="due"
                    class="w-full px-5 py-3 rounded-2xl border border-gray-300 bg-gray-50 text-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white shadow-sm transition-all duration-200"
                    required value="{{ old('due') }}">
                @error('due')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Upload File (Dropzone) --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">
                    Upload File <span class="text-red-500">*</span>
                </label>
                <div id="my-dropzone" class="dropzone rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 p-8 text-center"></div>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('viewKelasMapel', [
                    'mapel' => $kelasMapel->mapel->id,
                    'kelas' => $kelasMapel->kelas->id,
                    'tab'=> 'tugas'
                ]) }}" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-100 transition">
                    Batal
                </a>
                <button type="submit" id="btnSimpan" class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Simpan Tugas
                </button>
            </div>
        </form>
    </div>

    {{-- Kolom kanan: Catatan --}}
    <div class="space-y-5">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-2">CATATAN</h3>
            <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
                <li>Pastikan file sudah siap sebelum diunggah</li>
                <li>Judul dan deskripsi tugas harus jelas dan relevan</li>
                <li>Tentukan tenggat waktu yang realistis</li>
            </ul>
        </div>
    </div>
</div>

{{-- Dropzone Scripts --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script>
Dropzone.autoDiscover = false;

let savedTugasId = null;

const myDropzone = new Dropzone("#my-dropzone", {
    url: "#", // akan diupdate setelah tugas tersimpan
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
    window.location.href = "{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'tugas'
    ]) }}";
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
                    window.location.href = "{{ route('viewKelasMapel', [
                        'mapel' => $kelasMapel->mapel->id,
                        'kelas' => $kelasMapel->kelas->id,
                        'tab' => 'tugas'
                    ]) }}";
                } else {
                    myDropzone.options.url = "/tugas/" + savedTugasId + "/upload-file";
                    myDropzone.processQueue();
                }
            },
            error: function () {
                alert("Terjadi kesalahan saat menyimpan tugas.");
            }
        });
    });
});
</script>
@endsection