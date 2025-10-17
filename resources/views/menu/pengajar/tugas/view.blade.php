@extends('layout.template.mainTemplate')

@section('container')

    {{-- Navigasi Breadcrumb --}}
    <div class="col-12 ps-4 pe-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @if (Auth()->user()->roles_id == 1)
                @else
                    <li class="breadcrumb-item">
                        <a
                            href="{{ route('viewKelasMapel', [
                                'mapel' => $kelasMapel->mapel->id,
                                'kelas' => $kelasMapel->kelas->id,
                            ]) }}">
                            {{ $kelasMapel->mapel->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page"> Tugas</li>
            </ol>
        </nav>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Judul Halaman --}}
    <div class="ps-4 pe-4 mt-4  pt-4">
        <h2 class="display-6 fw-bold">
            @if (Auth()->user()->roles_id == 1)
                <a href="{{ route('activity') }}">
                    <button type="button" class="btn btn-outline-secondary rounded-circle">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </a> Tugas
            @else
                <a
                    href="{{ route('viewKelasMapel', [
                        'mapel' => $kelasMapel->mapel->id,
                        'kelas' => $kelasMapel->kelas->id,
                    ]) }}">
                    {{ $kelasMapel->mapel->name }}
                </a>
            @endif
        </h2>
    </div>



    {{-- Baris utama --}}
    <div class="col-12 ps-4 pe-4 mb-4">
        <div class="row">
            {{-- Bagian Kiri --}}
            <div class="col-xl-9 col-lg-12 col-md-12">
                <div class="row">

                    {{-- Informasi Tugas --}}
                    <div class="mb-4 p-4 bg-white rounded-4">
                        <div class=" p-4">
                            <h4 class="fw-bold mb-2">Informasi
                            </h4>
                            <hr>

                            <div class="row">
                                <h3 class="fw-bold text-primary">{{ $tugas->name }}@if ($tugas->isHidden == 1)
                                        <i class="fa-solid fa-lock fa-bounce text-danger"></i>
                                    @endif
                                </h3>
                                <hr>
                                @php
                                    $dueDateTime = \Carbon\Carbon::parse($tugas->due); // Mengatur timezone ke Indonesia (ID)
                                    $localTime = \Carbon\Carbon::parse($tugas->due)->setTimeZone('asia/jakarta'); // Mengatur timezone ke Indonesia (ID)
                                    $now = \Carbon\Carbon::now(); // Mengatur timezone ke Indonesia (ID)
                                    $timeUntilDue = $dueDateTime->diff($now); // Perbedaan waktu antara sekarang dan waktu jatuh tempo
                                    // dd($dueDateTime, $now, $timeUntilDue);
                                    $daysUntilDue = $timeUntilDue->days; // Jumlah hari hingga jatuh tempo
                                    $hoursUntilDue = $timeUntilDue->h; // Jumlah jam hingga jatuh tempo
                                    $minutesUntilDue = $timeUntilDue->i; // Jumlah menit hingga jatuh tempo
                                @endphp
                                @if ($dueDateTime < $now)
                                    <div class="border p-3 fw-bold col-lg-4 col-12">
                                        Status : <span class="badge badge-danger p-2">Ditutup</span>
                                    </div>
                                    <div class="border p-3 fw-bold col-lg-4 col-12">
                                        Waktu : <span class="badge badge-danger p-2">
                                            -
                                        </span>
                                    </div>
                                @else
                                    @if ($daysUntilDue >= 0 || ($daysUntilDue == 0 && $hoursUntilDue >= 0 && $minutesUntilDue >= 0))
                                        <div class="border p-3 fw-bold col-lg-4 col-12">
                                            Status : <span class="badge badge-primary p-2">Dibuka</span>
                                        </div>
                                        <div class="border p-3 fw-bold col-lg-4 col-12">
                                            Waktu : <span class="badge badge-primary p-2">
                                                {{ $daysUntilDue }} hari, {{ $hoursUntilDue }} jam, {{ $minutesUntilDue }}
                                                menit lagi
                                            </span>
                                        </div>
                                    @endif
                                @endif
                                <div class="col-12 border p-3 col-lg-4">
                                    <span class="fw-bold">Deadline :</span>
                                    {{ $localTime->translatedFormat('d F Y H:i') }}

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tampilan Tugas --}}
                    <div class="col-12 mb-4">
                        <div class="p-4 bg-white rounded-4">
                            <div class="h-100 p-4 border border-primary">
                                <h5 class="fw-bold">Perintah :</h5>
                                <p>
                                    {!! $tugas->content !!}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Tampilan File --}}
                    <div class="col-12 mb-4">
                        <div class="p-4 bg-white rounded-4">
                            <div class="h-100 p-4">
                                <h4 class="fw-bold mb-2">Files</h4>
                                <hr>
                                @if (count($tugas->TugasFile) > 0)
                                    <ul class="list-group">
                                        <div class="row">
                                            @foreach ($tugas->TugasFile as $key)
                                                <div class="col-lg-4 col-sm-6 col-12 mb-2">

                                                    <a href="{{ route('getFileTugas', ['namaFile' => $key->file]) }}">
                                                        <li class="list-group-item">
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
                                                            {{ Str::substr($key->file, 5, 20) }}
                                                        </li>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="small">(Tidak ada file untuk Tugas ini)</span>
                                @endif

                                </ul>
                            </div>
                        </div>
                    </div>

                    @if (Auth::user()->hasRole('Pengajar'))
                        <form action="{{ route('siswaUpdateNilai', ['tugas' => $tugas['id']]) }}" method="post">
                            @csrf
                            {{-- Siswa dan Assignment --}}
                            <div class="accordion mb-4" id="sdsd">
                                <div class="accordion-item ">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button bg-outline-primary  fw-bold" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#sdsd-collapseOne"
                                            aria-controls="sdsd-collapseOne">
                                            Submittion Siswa
                                        </button>
                                    </h2>
                                    <div id="sdsd-collapseOne" class="accordion-collapse collapse show">
                                        <div class="accordion-body table-responsive">
                                            <table id="table" class="table table-striped table-hover table-lg ">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Nama</th>
                                                        <th scope="col">Submittion</th>
                                                        <th scope="col">Nilai</th>
                                                        <th scope="col">Input Nilai</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($kelas->users as $key)
                                                        @php
                                                            // Mencari UserTugas sesuai dengan ID tugas yang Anda inginkan
                                                            $userTugas = $key->UserTugas
                                                                ->where('tugas_id', $tugas['id'])
                                                                ->first();
                                                            $nilai =
                                                                $userTugas && is_numeric($userTugas->nilai)
                                                                    ? intval($userTugas->nilai)
                                                                    : null;
                                                        @endphp

                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $key->name }}</td>
                                                            <td>
                                                                @if ($userTugas)
                                                                    @if ($userTugas->UserTugasFile)
                                                                        @foreach ($userTugas->UserTugasFile as $file)
                                                                            <a class="d-block"
                                                                                href="{{ route('getFileUser', ['namaFile' => $file->file]) }}">{{ $file->file }}</a>
                                                                        @endforeach
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($userTugas)
                                                                    @if ($nilai !== null && $nilai >= 0)
                                                                        {{ $nilai }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <input type="hidden" name="siswaId[]"
                                                                value="{{ $key->id }}">
                                                            <td class="w-25">
                                                                <input type="number" class="form-control w-100"
                                                                    placeholder="-" aria-label="nilai" name="nilai[]"
                                                                    value="{{ $nilai !== null ? $nilai : '' }}">
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary w-100" type="submit">submit</button>
                        </form>
                    @elseif (Auth::user()->hasRole('Siswa'))
                        <h3 class="fw-bold text-primary">Submit Tugas
                            @if ($userTugas)
                                @if ($userTugas->status == 'Belum Mengerjakan')
                                    <span class="badge badge-danger p-2">{{ $userTugas->status }}</span>
                                @elseif($userTugas->status == 'Telah dinilai')
                                    <span class="badge badge-primary p-2">{{ $userTugas->status }}</span>
                                    <span class="badge badge-success p-2">{{ $userTugas->nilai }}</span>
                                @else
                                    <span class="badge badge-primary p-2">{{ $userTugas->status }}</span>
                                @endif
                            @else
                                <span class="badge badge-danger p-2">Belum Mengerjakan</span>
                            @endif
                        </h3>
                        @if ($userTugas)
                            {{-- Tampilan File --}}
                            <div class="col-12 mb-4">
                                <div class="p-4 bg-white rounded-4">
                                    <div class="h-100 p-4">
                                        <h4 class="fw-bold mb-2">Pekerjaan anda</h4>
                                        <hr>
                                        @if (count($userTugas->UserTugasFile) > 0)
                                            <ul class="list-group">
                                                <div class="row">
                                                    @foreach ($userTugas->UserTugasFile as $key)
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
                                                                <a href="{{ route('getFileUser', ['namaFile' => $key->file]) }}"
                                                                    class="text-decoration-none">
                                                                    {{ Str::substr($key->file, 5, 10) }}
                                                                </a>
                                                              @if ($dueDateTime > $now)
    @if ($userTugas)
        @if ($userTugas->status != 'Telah dinilai')
            <button type="button"
                class="btn btn-danger btn-sm float-end"
                data-bs-toggle="modal"
                data-bs-target="#modalDelete"
                onclick="changeValue('{{ addslashes($key->file) }}')">
                X
            </button>
        @endif
    @else
        <button type="button"
            class="btn btn-danger btn-sm float-end"
            data-bs-toggle="modal"
            data-bs-target="#modalDelete"
            onclick="changeValue('{{ addslashes($key->file) }}')">
            X
        </button>
    @endif
@endif

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="small">(anda belum mengupload file)</span>
                                        @endif

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($dueDateTime > $now)
                            @if ($userTugas)
                                @if ($userTugas->status != 'Telah dinilai')
                                    <form action="{{ route('submitTugas', $tugas->id) }}" method="post"
                                        enctype="multipart/form-data" id="submitTugas">
                                        @csrf
                                        {{-- Dropzone area --}}
                                        <div class="mb-3">
                                            <label for="uploadFile" class="form-label">Upload Jawaban</label>
                                            <div id="my-dropzone" class="dropzone"></div>
                                        </div>


                                        {{-- Hidden input tambahan --}}
                                        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                        <input type="hidden" name="tugasId" value="{{ $tugas->id }}">


                                        {{-- Tombol Submit --}}
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary w-100" id="btnSimpan">
                                                Simpan dan Lanjutkan
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    {{-- Telah dinilai --}}
                                    <div class="mb-3 text-center bg-white p-4">
                                        <div class="border border-primary p-4">
                                            <span class="fw-bold text-danger">Upload ditutup</span>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <form action="{{ route('submitTugas', $tugas->id) }}" method="post"
                                    enctype="multipart/form-data" id="submitTugas">
                                    @csrf


                                    {{-- Dropzone area --}}
                                    <div class="mb-3">
                                        <label for="uploadFile" class="form-label">Upload Jawaban</label>
                                        <div id="my-dropzone" class="dropzone"></div>
                                    </div>


                                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <input type="hidden" name="tugasId" value="{{ $tugas->id }}">


                                    <div>
                                        <button type="submit" class="btn-lg btn btn-primary w-100" id="btnSimpan">
                                            Simpan dan Lanjutkan
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @endif

                </div>
            </div>

            {{-- Bagian Kanan --}}
            <div class="col-xl-3 col-lg-12 col-md-12">
                {{-- Info Pengajar --}}
                <div class="mb-4 p-4 bg-white rounded-4">
                    <div class="h-100 p-4">
                        <h4 class="fw-bold mb-2">Pengajar</h4>
                        <hr>
                        <div class="row">

                        </div>
                    </div>
                </div>

                {{-- Daftar Tugas --}}
                <div class="mb-4 p-4 bg-white rounded-4">
                    <div class="h-100 p-4">
                        <h4 class="fw-bold mb-2">List Tugas</h4>
                        <hr>
                        <ul class="list-group">
                            @foreach ($tugasAll as $key)
                               @if (Auth::user()->hasRole('Pengajar'))
                                    @if ($tugas['id'] != $key->id)
                                        <a href="{{ route('viewTugas', [
                                            'tugas' => $key->id,
                                            'kelasMapelId' => $tugas['kelas_mapel_id'],
                                            'mapelId' => $mapel['id'],
                                        ]) }}"
                                            @endif
                                            <li class="list-group-item  @if ($tugas['id'] == $key->id) active @endif">
                                                {{ $key->name }}
                                            </li>
                                            @if ($tugas['id'] != $key->id)
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
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
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus File ini?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('destroyFileSubmit') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <input type="hidden" name="fileName" id="fileName" value="">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Load CSS dan JS Library --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.19/dist/css/tempus-dominus.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.19/dist/js/tempus-dominus.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.19/dist/locales/id.js" crossorigin="anonymous">
    </script>

    <script src="https://cdn.tiny.cloud/1/1dcn6y89gj7jtaawstjd7qt5nddl47py62pg67ihnxq6vyoa/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script src="{{ url('/asset/js/rich-text-editor.js') }}"></script>
    {{-- Script untuk mengatur gambar agar responsif --}}
    <script>
        var img = document.querySelectorAll('img');

        img.forEach(function(element) {
            element.classList.add('img-fluid');
        });

        function changeValue(itemId) {
            console.log(itemId);
            const fileName = document.getElementById('fileName');
            fileName.setAttribute('value', itemId);
        }
    </script>

    {{-- Script tambahan jika diperlukan --}}
    <script src="{{ url('/asset/js/lottie.js') }}"></script>
    <script src="{{ url('/asset/js/customJS/simpleAnim.js') }}"></script>
    @if (Auth::user()->hasRole('Siswa'))
        <script>
            $(document).ready(function() {


                // Menangkap submit form
                $('#submitTugas').submit(function(e) {
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
    @endif

   <script>
    Dropzone.autoDiscover = false;

    // 🔹 Inisialisasi Dropzone (pola sama dengan materi & edit tugas)
    const myDropzone = new Dropzone("#my-dropzone", {
        url: "{{ route('submitFileTugas') }}",
        paramName: "file",
        maxFilesize: 10, // MB
        acceptedFiles: ".jpg,.jpeg,.png,.gif,.mp4,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.mp3,.avi,.mov",
        addRemoveLinks: true,
        timeout: 60000,
        dictDefaultMessage: "Seret file ke sini atau klik untuk mengunggah",
        autoProcessQueue: false,
        parallelUploads: 100,
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        init: function() {
            // Tambahkan tugasId ke setiap request
            this.on("sending", function(file, xhr, formData) {
                formData.append("tugasId", "{{ $tugas->id }}");
            });
        }
    });

    // 🔹 Kalau semua file selesai diupload → redirect
    myDropzone.on("queuecomplete", function () {
        window.location.href = "{{ route('viewKelasMapel', ['mapel' => $mapel['id'], 'kelas' => $kelas->id]) }}";
    });

    // 🔹 Handle form submit
    $(document).ready(function() {
        $('#submitTugas').on('submit', function(e) {
            e.preventDefault();

            if (myDropzone.getQueuedFiles().length === 0) {
                // Tidak ada file → langsung redirect
                window.location.href = "{{ route('viewKelasMapel', ['mapel' => $mapel['id'], 'kelas' => $kelas->id]) }}";
            } else {
                // Ada file → proses upload
                myDropzone.processQueue();
            }
        });
    });
</script>
    @endif
@endsection
