@extends('layout.template.mainTemplate')

@section('container')

{{-- Navigasi Breadcrumb --}}
<div class="col-12 ps-4 pe-4 mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('viewKelasMapel', ['mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id]) }}">
                    {{ $kelasMapel->mapel->name }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Materi</li>
        </ol>
    </nav>
</div>

{{-- Judul Halaman --}}
<div class="ps-4 pe-4 mt-4 pt-4">
    <h2 class="display-6 fw-bold">
        <a href="{{ route('viewKelasMapel', ['mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id]) }}">
            <button type="button" class="btn btn-outline-secondary rounded-circle">
                <i class="fa-solid fa-arrow-left"></i>
            </button> Tambah
        </a>
    </h2>
</div>

{{-- Formulir Tambah Materi --}}
<div class="">
    <div class="row p-4">
        <h4 class="fw-bold text-primary"><i class="fa-solid fa-pen"></i> Data Materi</h4>
        <div class="col-12 col-lg-12 bg-white rounded-2">
            <div class="mt-4">
                <div class="p-4">
                    <form id="formMateri" action="{{ route('materi.store', $kelasMapel->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Judul Materi</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Inputkan judul materi..." value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Konten Materi --}}
                        <div class="mb-3">
                            <label for="content" class="form-label">
                                Konten <span class="small text-info">(Opsional)</span>
                            </label>
                            <textarea id="tinymce" name="content">{{ old('content') }}</textarea>
                        </div>
                        
                        {{-- Upload File --}}
                        <div class="mb-3">
                            <label for="uploadFile" class="form-label">
                                Upload <span class="small text-info">(Opsional)</span>
                            </label>
                            <div id="my-dropzone" class="dropzone"></div>
                        </div>
                        
                        {{-- Tombol Submit --}}
                        <div class="">
                            <button type="submit" class="btn-lg btn btn-primary w-100" id="btnSimpan">
                                Simpan dan Lanjutkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.tiny.cloud/1/1dcn6y89gj7jtaawstjd7qt5nddl47py62pg67ihnxq6vyoa/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

{{-- Inisialisasi TinyMCE --}}
<script>
tinymce.init({
    selector: '#tinymce',
    height: 400,
    menubar: false,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link image | removeformat',
    content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
});
</script>

{{-- Inisialisasi Dropzone --}}
<script>
Dropzone.autoDiscover = false;

let savedMateriId = null;

const myDropzone = new Dropzone("#my-dropzone", {
    url: "#", // akan diubah setelah materi tersimpan
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

// 🔹 Redirect otomatis setelah semua file selesai diupload
myDropzone.on("queuecomplete", function () {
    window.location.href = "{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id
    ]) }}";
});

// 🔹 Ajax submit form materi
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
                savedMateriId = response.materi_id;

                if (myDropzone.getQueuedFiles().length === 0) {
                    // Tidak ada file → langsung redirect
                    window.location.href = "{{ route('viewKelasMapel', [
                        'mapel' => $kelasMapel->mapel->id,
                        'kelas' => $kelasMapel->kelas->id
                    ]) }}";
                } else {
                    // Ada file → ganti URL ke MateriFileController
                    myDropzone.options.url = "/materi/" + savedMateriId + "/upload-file";
                    myDropzone.processQueue();
                }
            },
            error: function () {
                alert("Terjadi kesalahan saat menyimpan materi.");
            }
        });
    });
});
</script>
@endsection