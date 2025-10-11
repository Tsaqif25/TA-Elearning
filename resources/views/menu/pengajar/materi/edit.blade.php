@extends('layout.template.mainTemplate')

@section('container')
    {{-- Cek peran pengguna --}}

    <div class="col-12 ps-4 pe-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a
                        href="{{ route('viewKelasMapel', [
                            'mapel' => $kelasMapel->mapel->id,
                            'kelas' => $kelasMapel->kelas->id,
                        ]) }}">
                        {{ $kelasMapel->mapel->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Update Materi</li>
            </ol>
        </nav>
    </div>

    {{-- Judul Halaman --}}
    <div class="ps-4 pe-4 mt-4 pt-4">
        <h2 class="display-6 fw-bold">
            <a
                href="{{ route('viewKelasMapel', [
                    'mapel' => $kelasMapel->mapel->id,
                    'kelas' => $kelasMapel->kelas->id,
                ]) }}">
                <button type="button" class="btn btn-outline-secondary rounded-circle">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </a> Update Materi
        </h2>
    </div>

    {{-- Formulir Update Materi --}}
    <div class="row p-4">
        <h4 class="fw-bold text-primary"><i class="fa-solid fa-pen"></i> Data Materi</h4>
        <div class="col-12 bg-white rounded-2">
            <div class="mt-4 p-4">
                <form id="formMateri" action="{{ route('materi.update', $materi->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    {{-- Status Open / Close --}}
                   

                    {{-- Nama Materi --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Judul Materi</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Inputkan judul materi..." value="{{ old('name', $materi->name) }}" required>
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konten Materi --}}
                    <div class="mb-3">
                        <label for="content" class="form-label">
                            Konten <span class="small text-info">(Opsional)</span>
                        </label>
                        <textarea id="tinymce" name="content">{{ old('content', $materi->content) }}</textarea>
                    </div>

                    {{-- Dropzone --}}
                    <div class="mb-3">
                        <label for="uploadFile" class="form-label">Upload <span
                                class="small text-info">(Opsional)</span></label>
                        <div id="my-dropzone" class="dropzone"></div>
                    </div>

                    {{-- Tombol Submit --}}
                    <button type="submit" id="btnSimpan" class="btn-lg btn btn-primary w-100">
                        Simpan dan Lanjutkan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Files --}}
    <div class="row p-4">
        <div class="col-12 bg-white rounded-2">
            <div class="mt-4 p-4">
                <h4 class="fw-bold mb-2">Files</h4>
                <hr>
                <div class="row">
                    @foreach ($materi->files as $file)
                        <div class="col-lg-4 col-sm-6 col-12 mb-2">
                            <div class="list-group-item">
                                {{-- Icon file --}}
                                @if (Str::endsWith($file->file, ['.jpg', '.jpeg', '.png', '.gif']))
                                    <i class="fa-solid fa-image"></i>
                                @elseif (Str::endsWith($file->file, ['.mp4', '.avi', '.mov']))
                                    <i class="fa-solid fa-video"></i>
                                @elseif (Str::endsWith($file->file, ['.pdf']))
                                    <i class="fa-solid fa-file-pdf"></i>
                                @elseif (Str::endsWith($file->file, ['.doc', '.docx']))
                                    <i class="fa-solid fa-file-word"></i>
                                @elseif (Str::endsWith($file->file, ['.ppt', '.pptx']))
                                    <i class="fa-solid fa-file-powerpoint"></i>
                                @elseif (Str::endsWith($file->file, ['.xls', '.xlsx']))
                                    <i class="fa-solid fa-file-excel"></i>
                                @elseif (Str::endsWith($file->file, ['.txt']))
                                    <i class="fa-solid fa-file-alt"></i>
                                @elseif (Str::endsWith($file->file, ['.mp3']))
                                    <i class="fa-solid fa-music"></i>
                                @else
                                    <i class="fa-solid fa-file"></i>
                                @endif

                                {{-- Link file --}}
                                <a href="{{ route('getFile', $file->file) }}" class="text-decoration-none">
                                    {{ Str::limit($file->file, 20) }}
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('materi.destroyFile', $materi->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus file ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="file_id" value="{{ $file->id }}">

                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.tiny.cloud/1/1dcn6y89gj7jtaawstjd7qt5nddl47py62pg67ihnxq6vyoa/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
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

const myDropzone = new Dropzone("#my-dropzone", {
    url: "/materi/{{ $materi->id }}/upload-file", // langsung pakai ID materi yg sudah ada
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

// 🔹 Kalau semua file selesai diupload → redirect
myDropzone.on("queuecomplete", function () {
    window.location.href = "{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id
    ]) }}";
});

// 🔹 Handle form update materi
$(document).ready(function () {
    $('#formMateri').submit(function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            type: 'POST', // meski ada @method('PUT'), Ajax tetap pakai POST
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (response) {
                console.log(response);

                if (myDropzone.getQueuedFiles().length === 0) {
                    // Tidak ada file → langsung redirect
                    window.location.href = "{{ route('viewKelasMapel', [
                        'mapel' => $kelasMapel->mapel->id,
                        'kelas' => $kelasMapel->kelas->id
                    ]) }}";
                } else {
                    // Ada file → proses upload
                    myDropzone.processQueue();
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert("Terjadi kesalahan saat menyimpan materi.");
            }
        });
    });
});
</script>

@endsection
