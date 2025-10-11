@extends('layout.template.mainTemplate')

@section('container')
    {{-- Cek peran pengguna --}}
    

    {{-- Navigasi Breadcrumb --}}
 <div class="col-12 ps-4 pe-4 mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('viewKelasMapel', ['mapel' => $mapel->id, 'kelas' => $kelasId]) }}">
                    {{ $mapel->name }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Tugas</li>
        </ol>
    </nav>
</div>

{{-- Judul Halaman --}}
<div class="ps-4 pe-4 mt-4 pt-4">
    <h2 class="display-6 fw-bold">
        <a href="{{ route('viewKelasMapel', ['mapel' => $mapel->id, 'kelas' => $kelasId]) }}">
            <button type="button" class="btn btn-outline-secondary rounded-circle">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </a>
        Tambah Tugas
    </h2>
</div>

{{-- Formulir Tambah Tugas --}}
<div class="row p-4">
    <h4 class="fw-bold text-primary"><i class="fa-solid fa-pen"></i> Data Tugas</h4>
    <div class="col-12 bg-white rounded-2 mt-4">
        <div class="p-4">
            <form action="{{ route('createTugas') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Status Open / Close --}}
                <div class="mb-3 row">
                    <div class="col-8 col-lg-4">
                        <label for="opened" class="form-label d-block">Aktif 
                            <span class="small">(apakah sudah bisa diakses?)</span>
                        </label>
                    </div>
                    <div class="col-4 col-lg form-check form-switch">
                        <input class="form-check-input" name="opened" type="checkbox" role="switch" id="opened" checked>
                    </div>
                </div>

                {{-- Nama Tugas --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Judul Tugas</label>
                    <input type="hidden" name="kelasId" value="{{ $kelasId }}" readonly>
                    <input type="hidden" name="mapelId" value="{{ $mapel->id }}" readonly>
                    <input type="text" class="form-control" id="name" name="name"
                           placeholder="Inputkan judul Tugas..." value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Due Date Picker --}}
                <div class="mb-3">
                    <label for="due" class="form-label">Tanggal Jatuh Tempo</label>
                    <div class="input-group" id="dueWrapper" data-td-target-input="nearest" data-td-target-toggle="nearest">
                        <input id="due" name="due" type="text" class="form-control" data-td-target="#dueWrapper"
                               autocomplete="off" placeholder="Pilih tanggal jatuh tempo..." required value="{{ old('due') }}">
                        <span class="input-group-text" data-td-target="#dueWrapper" data-td-toggle="datetimepicker">
                            <i class="fa-solid fa-calendar"></i>
                        </span>
                    </div>
                </div>

                {{-- Konten Tugas --}}
                <div class="mb-3">
                    <label for="content" class="form-label">Konten 
                        <span class="small text-info">(Opsional)</span>
                    </label>
                    <textarea id="tinymce" name="content">{{ old('content') }}</textarea>
                </div>

                {{-- Upload File --}}
                <div class="mb-3">
                    <label for="uploadFile" class="form-label">Upload 
                        <span class="small text-info">(Opsional)</span>
                    </label>
                    <div id="my-dropzone" class="dropzone"></div>
                </div>

                {{-- Tombol Submit --}}
                <div>
                    <button type="submit" class="btn btn-primary w-100 btn-lg" id="btnSimpan">
                        Simpan dan Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Load CSS dan JS Library --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.19/dist/css/tempus-dominus.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.19/dist/js/tempus-dominus.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.19/dist/locales/id.js" crossorigin="anonymous"></script>

<script src="https://cdn.tiny.cloud/1/1dcn6y89gj7jtaawstjd7qt5nddl47py62pg67ihnxq6vyoa/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script src="{{ url('/asset/js/rich-text-editor.js') }}"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi TempusDominus DateTime Picker
        new tempusDominus.TempusDominus(document.getElementById('dueWrapper'), {
            localization: {
                locale: 'id',
                format: 'yyyy-MM-dd HH:mm'
            },
            display: {
                components: {
                    useTwentyfourHour: true
                }
            }
        });

        // Menangkap submit form
        $('form').submit(function(e) {
            e.preventDefault(); // Mencegah form melakukan submit default

            // Mengambil data form
            var formData = new FormData(this);

            // Menggunakan AJAX untuk mengirim data ke server
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Berhasil, lakukan sesuatu dengan respons dari server jika diperlukan
                    console.log(response);
                    uploadFiles();
                },
                error: function(error) {
                    // Terjadi kesalahan, tangani kesalahan jika diperlukan
                    console.log(error);
                    // Di sini Anda dapat menambahkan logika lain atau menampilkan pesan kesalahan kepada pengguna.
                }
            });
        });
    });
</script>

<script>
    Dropzone.autoDiscover = false;

    
    // 🔹 Validasi TinyMCE
    function validateTinyMCE() {
        var content = tinymce.get("tinymce").getContent();
        if (!content.trim()) {
            alert("Konten tidak boleh kosong.");
            return false;
        }
        return true;
    }

    // 🔹 Inisialisasi Dropzone (pola clean)
    const myDropzone = new Dropzone("#my-dropzone", {
        url: "{{ route('tugas.file.upload', ['action' => 'tambah']) }}",
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
        window.location.href = "{{ route('viewKelasMapel', ['mapel' => $mapel->id, 'kelas' => $kelasId]) }}";
    });

    // 🔹 Handle form submit
    $(document).ready(function() {
        $("form").on("submit", function(e) {
            e.preventDefault();

            // Validasi TinyMCE
            if (!validateTinyMCE()) {
                return false;
            }

            // Cek apakah ada file yang di-queue
            if (myDropzone.getQueuedFiles().length === 0) {
                // Tidak ada file → langsung redirect
                window.location.href = "{{ route('viewKelasMapel', ['mapel' => $mapel->id, 'kelas' => $kelasId]) }}";
            } else {
                // Ada file → proses upload
                myDropzone.processQueue();
            }
        });
    });
</script>
@endsection