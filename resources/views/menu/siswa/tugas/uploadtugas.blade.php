
@extends('layout.template.mainTemplate')

@section('container')
<div class="col-12 ps-4 pe-4 mb-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-white">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Tugas</li>
    </ol>
  </nav>
</div>

<div class="p-4 bg-white rounded-4">
  <h2 class="fw-bold text-primary">{{ $tugas->name }}</h2>
  <hr>
  <p>{!! $tugas->content !!}</p>

  <h5 class="mt-4">File Pendukung:</h5>
  @if ($tugas->files->count())
    <ul class="list-group">
      @foreach ($tugas->files as $file)
        <li class="list-group-item">
          <a href="{{ route('getFileTugas', ['namaFile' => $file->file]) }}">
            <i class="fa-solid fa-file"></i> {{ $file->file }}
          </a>
        </li>
      @endforeach
    </ul>
  @else
    <p class="text-muted">Tidak ada file tambahan.</p>
  @endif
</div>

{{-- Status dan upload area siswa --}}
<div class="p-4 bg-white rounded-4 mt-4">
  <h4 class="fw-bold">Status:
    @if ($userTugas)
      <span class="badge {{ $userTugas->status == 'Telah dinilai' ? 'bg-success' : 'bg-primary' }}">{{ $userTugas->status }}</span>
    @else
      <span class="badge bg-danger">Belum Mengerjakan</span>
    @endif
  </h4>

  @if ($userTugas && $userTugas->UserTugasFile->count())
    <div class="mt-3">
      <h6 class="fw-bold">File Anda:</h6>
      @foreach ($userTugas->UserTugasFile as $f)
        <div class="d-flex justify-content-between align-items-center border p-2 rounded mb-2">
          <a href="{{ route('getFileUser', ['namaFile' => $f->file]) }}" class="text-decoration-none">
            <i class="fa-solid fa-file"></i> {{ $f->file }}
          </a>
          <form action="{{ route('destroyFileSubmit') }}" method="POST" onsubmit="return confirm('Yakin hapus file ini?')">
            @csrf
            @method('DELETE')
            <input type="hidden" name="fileName" value="{{ $f->file }}">
            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
          </form>
        </div>
      @endforeach
    </div>
  @endif

  {{-- Form upload baru --}}
  @if (!($userTugas && $userTugas->status == 'Telah dinilai'))
    <form action="{{ route('submitTugas', $tugas->id) }}" method="POST" enctype="multipart/form-data" id="submitTugas">
      @csrf
      <div class="mb-3">
        <label class="form-label fw-bold">Upload Jawaban</label>
        <div id="my-dropzone" class="dropzone"></div>
      </div>
      <input type="hidden" name="tugasId" value="{{ $tugas->id }}">
      <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Kirim Jawaban</button>
    </form>
  @else
    <div class="alert alert-info mt-3">Upload ditutup. Anda sudah dinilai.</div>
  @endif
</div>

{{-- Dropzone script --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.19/dist/css/tempus-dominus.min.css"
        crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />


    <!-- ========== SCRIPT ORDER ========== -->
    <!-- 1️⃣ jQuery wajib paling atas -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- 2️⃣ Popper.js & TempusDominus -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.19/dist/js/tempus-dominus.min.js"
        crossorigin="anonymous"></script>

    <script>
        // Inisialisasi TempusDominus secara manual tanpa locales/id.js
        document.addEventListener('DOMContentLoaded', function() {
            const el = document.getElementById('due');
            if (el) {
                new tempusDominus.TempusDominus(el, {
                    localization: {
                        locale: 'id',
                        startOfTheWeek: 1,
                    },
                    display: {
                        components: {
                            decades: true,
                            year: true,
                            month: true,
                            date: true,
                            hours: true,
                            minutes: true,
                            seconds: false
                        },
                    },
                });
            }
        });
    </script>

    <!-- 3️⃣ TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/1dcn6y89gj7jtaawstjd7qt5nddl47py62pg67ihnxq6vyoa/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ url('/asset/js/rich-text-editor.js') }}"></script>

    <!-- 4️⃣ Dropzone -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <!-- 5️⃣ Custom scripts -->
    <script src="{{ url('/asset/js/lottie.js') }}"></script>

    <script>
        // Tambahkan class responsive ke semua gambar di halaman
        document.querySelectorAll('img').forEach(function(el) {
            el.classList.add('img-fluid');
        });

        // Untuk modal hapus file
        function changeValue(itemId) {
            document.getElementById('fileName').value = itemId;
        }
    </script>

    <!-- ====================================================== -->
    <!-- 🧩 LOGIKA DROPZONE BERDASARKAN ROLE -->
    <!-- ====================================================== -->

    @if (Auth::user()->hasRole('Siswa'))
        <script>
            Dropzone.autoDiscover = false;

            const myDropzone = new Dropzone("#my-dropzone", {
                url: "{{ route('submitFileTugas') }}", // route khusus siswa
                paramName: "file",
                maxFilesize: 10, // MB
                acceptedFiles: ".jpg,.jpeg,.png,.gif,.mp4,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.mp3,.avi,.mov",
                addRemoveLinks: true,
                timeout: 60000,
                dictDefaultMessage: "Seret file ke sini atau klik untuk mengunggah",
                autoProcessQueue: false,
                parallelUploads: 100,
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                init: function() {
                    this.on("sending", function(file, xhr, formData) {
                        formData.append("tugasId", "{{ $tugas->id }}");
                    });
                }
            });

            let uploadedCount = 0;
            myDropzone.on("complete", function(file) {
                uploadedCount++;
                if (uploadedCount === myDropzone.getAcceptedFiles().length) {
                    window.location.href =
                        "{{ route('viewKelasMapel', [
                            'mapel' => $mapel['id'],
                            'kelas' => $kelas->id,
                        ]) }}";
                }
            });

            // Handle submit form siswa
            $(document).ready(function() {
                $('#submitTugas').on('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log('Data tersimpan:', response);
                            uploadFiles();
                        },
                        error: function(error) {
                            console.error(error);
                            alert('Terjadi kesalahan saat menyimpan tugas.');
                        }
                    });
                });
            });

            function uploadFiles() {
                if (myDropzone.getQueuedFiles().length === 0) {
                    window.location.href =
                        "{{ route('viewKelasMapel', [
                            'mapel' => $mapel['id'],
                            'kelas' => $kelas->id,
                        ]) }}";
                } else {
                    myDropzone.processQueue();
                }
            }
        </script>
    @endif
@endsection
