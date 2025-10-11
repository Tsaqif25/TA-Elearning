@extends('layout.template.mainTemplate')

@section('container')
 
    {{-- Navigasi Breadcrumb --}}
    <div class="col-12 ps-4 pe-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('viewKelasMapel', [
                            'mapel' => $kelasMapel->mapel->id,
                            'kelas' => $kelasMapel->kelas->id,
                        ]) }}">
                        {{ $kelasMapel->mapel->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Update Tugas</li>
            </ol>
        </nav>
    </div>

    {{-- Judul Halaman --}}
    <div class="ps-4 pe-4 mt-4  pt-4">
        <h2 class="display-6 fw-bold">
            <a href="{{ route('viewKelasMapel', [
                    'mapel' => $kelasMapel->mapel->id,
                    'kelas' => $kelasMapel->kelas->id,
                ]) }}">
                {{ $kelasMapel->mapel->name }}
                <button type="button" class="btn btn-outline-secondary rounded-circle">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                Update Tugas
            </a>
        </h2>
    </div>

    {{-- Formulir Update Tugas --}}
    <div class="">
        <div class="row p-4">
            <h4 class="fw-bold text-primary"><i class="fa-solid fa-pen"></i> Data Tugas</h4>
            <div class="col-12 col-lg-12 bg-white rounded-2">
                <div class="mt-4">
                    <div class="p-4">
                        <form id="formTugasUpdate" action="{{ route('updateTugas', $tugas->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            {{-- Status Open / Close --}}
                            <div class="mb-3 row">
                                <div class="col-8 col-lg-4">
                                    <label for="opened" class="form-label d-block">Aktif<span class="small">(apakah sudah bisa diakses?)</span></label>
                                </div>
                                <div class="col-4 col-lg form-check form-switch">
                                    <input class="form-check-input" name="opened" type="checkbox" role="switch" id="opened" @if ($tugas->isHidden == 0) checked @endif>
                                </div>
                            </div>
                            
                            {{-- Nama Tugas --}}
                            <div class="mb-3">
                                <label for="nama" class="form-label">Judul Tugas</label>
                                <input type="hidden" name="kelasId" value="{{ encrypt($kelasId) }}" readonly>
                                <input type="hidden" name="tugasId" value="{{ encrypt($tugas['id']) }}" readonly>
                                <input type="hidden" name="mapelId" value="{{ $mapel['id'] }}" readonly>
                                <input type="text" class="form-control" id="nama" name="name" placeholder="Inputkan judul tugas..." value="{{ old('name', $tugas['name']) }}" required>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Due Date Picker --}}
                            <div class="mb-3">
                                <label for="due" class="form-label">Due Date</label>
                                <input class="form-control" id="due" name="due" placeholder="Pilih tanggal jatuh tempo..." required value="{{ old('due', \Carbon\Carbon::parse($tugas['due'])->format('Y-m-d H:i')) }}">
                                @error('due')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Konten tugas --}}
                            <div class="mb-3">
                                <label for="nama" class="form-label">Konten <span class="small text-info">(Opsional)</span></label>
                                <textarea id="tinymce" name="content">{{ $tugas['content'] }}</textarea>
                                @error('content')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Dropzone --}}
                            <div class="mb-3">
                                <label for="uploadFile" class="form-label">Upload <span class="small text-info">(Opsional)</span></label>
                                <div id="my-dropzone" class="dropzone"></div>
                            </div>
                            
                            {{-- Tombol Submit --}}
                            <div class="">
                                <button type="submit" id="btnSimpan" class="btn-lg btn btn-primary w-100">Simpan dan Lanjutkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Files --}}
    <div class="row p-4">
        <div class="col-12 col-lg-12 bg-white rounded-2">
            <div class="mt-4">
                <div class="p-4">
                    <h4 class="fw-bold mb-2">Files</h4>
                    <hr>
                    <div class="row">
                        @foreach ($tugas->TugasFile as $key)
                            <div class="col-lg-4 col-sm-6 col-12 mb-2">
                                <div class="list-group-item">
                                    @if (Str::endsWith($key->file, ['.jpg', '.jpeg', '.png', '.gif']))
                                        <i class="fa-solid fa-image"></i>
                                    @elseif (Str::endsWith($key->file, ['.mp4', '.avi', '.mov']))
                                        <i class="fa-solid fa-video"></i>
                                    @elseif (Str::endsWith($key->file, ['.pdf']))
                                        <i class="fa-solid fa-file-pdf"></i>
                                    @elseif (Str::endsWith($key->file, ['.doc', '.docx']))
                                        <i class="fa-solid fa-file-word"></i>
                                    @elseif (Str::endsWith($key->file, ['.ppt', '.pptx']))
                                        <i class="fa-solid fa-file-powerpoint"></i>
                                    @elseif (Str::endsWith($key->file, ['.xls', '.xlsx']))
                                        <i class="fa-solid fa-file-excel"></i>
                                    @elseif (Str::endsWith($key->file, ['.txt']))
                                        <i class="fa-solid fa-file-alt"></i>
                                    @elseif (Str::endsWith($key->file, ['.mp3']))
                                        <i class="fa-solid fa-music"></i>
                                    @else
                                        <i class="fa-solid fa-file"></i>
                                    @endif
                                    <a href="{{ route('getFileTugas', ['namaFile' => $key->file]) }}" class="text-decoration-none">
                                        {{ Str::substr($key->file, 5, 10) }}
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm float-end" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalDelete" 
                                            data-filename="{{ $key->file }}">
                                        X
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDelete" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus file ini?
      </div>
   <div class="modal-footer">
<form id="formDeleteFile" action="{{ route('tugas.file.delete') }}" method="POST">
@csrf
@method('DELETE')
<input type="hidden" name="idTugas" value="{{ $tugas->id }}">
<input type="hidden" name="fileName" id="fileNameInput">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
<button type="submit" class="btn btn-danger">Hapus</button>
</form>
</div>
    </div>
  </div>
</div>





    {{-- Script yang dibutuhkan --}}
    <script src="https://cdn.tiny.cloud/1/1dcn6y89gj7jtaawstjd7qt5nddl47py62pg67ihnxq6vyoa/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ url('/asset/js/rich-text-editor.js') }}"></script>
    
    {{-- Tambahkan CSS datetimepicker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" />
    
    {{-- Tambahkan JS datetimepicker SETELAH jQuery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;

        // 🔹 Inisialisasi Dropzone (sama seperti pola materi)
        const myDropzone = new Dropzone("#my-dropzone", {
            url: "{{ route('tugas.file.upload') }}?action=edit&idTugas={{ $tugas->id }}", // langsung pakai ID tugas yang sudah ada
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

        // 🔹 Handle form update tugas
        $(document).ready(function () {
            // Handle modal delete button click
           $('#modalDelete').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    const filename = button.data('filename');
    const modal = $(this);
    modal.find('input[name="fileName"]').val(filename);
});

            // Initialize datetimepicker
            $('#due').datetimepicker({
                format: 'Y-m-d H:i',
                locale: 'id',
            });

            // Handle form submit
            $('#formTugasUpdate').submit(function (e) {
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
                        alert("Terjadi kesalahan saat menyimpan tugas.");
                    }
                });
            });
        });
    </script>
@endsection