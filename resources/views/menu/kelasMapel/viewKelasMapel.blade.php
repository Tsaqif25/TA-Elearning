@extends('layout.template.mainTemplate')

@section('container')

    {{-- Navigasi Breadcrumb --}}
    <div class="col-12 ps-4 pe-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $mapel['name'] }}</li>
            </ol>
        </nav>
    </div>

    {{-- Judul Halaman --}}
    <div class="ps-4 pe-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="display-6 fw-bold ">
                <a href="{{ route('dashboard') }}">
                    <button type="button" class="btn btn-outline-dark rounded-circle">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </a> {{ $mapel['name'] }}
                <span class="badge badge-secondary">{{ $kelas['name'] }}</span>
            </h1>
        </div>
    </div>

    {{-- Pesan Sukses --}}
    @if (session()->has('success'))
        <div class="alert alert-lg alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Informasi Mata Pelajaran --}}
    <div class="bg-body-secondary rounded-4 mb-4">
        <div class="container col-xxl-8 px-4 py-5 ">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                <div class="col-10 col-sm-8 col-lg-6">
                    @if ($mapel['gambar'] != null)
                        <img src="{{ asset('storage/file/img-upload/' . $mapel['gambar']) }}"
                            class="d-block mx-lg-auto img-fluid w-100 rounded-3" alt="Bootstrap Themes" loading="lazy">
                    @else
                        <img src="{{ url('/asset/img/work.png') }}" class="d-block mx-lg-auto img-fluid h-50 w-50 "
                            alt="" loading="lazy">
                    @endif
                </div>
                <div class="col-lg-6">
                    <h1 class=" fw-bold text-body-emphasis lh-1 mb-3">{{ $mapel['name'] }}</h1>
                    <span class="small">
                        @if ($editor)
                            with
                            {{-- <a href="{{ route('viewProfilePengajar', ['pengajar' => $editor->id]) }}">
                            {{ $editor->name }}
                        </a> --}}
                        @else
                            (belum ada pengajar)
                        @endif
                    </span>
                    <p class="lead">{{ $mapel['deskripsi'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Tugas, Materi --}}
    <div class="row ps-4 pe-4 mb-4" id="materi">
        <div class=" col-lg-12 col-md-12">
            <h3 class=" fw-bold text-primary"><i class="fa-solid fa-bullhorn"></i> Pengumuman
                @if (Auth::user()->hasRole('Pengajar'))
                    <a href="{{ route('viewCreatePengumuman', $kelas['id']) }}?mapel={{ $mapel['id'] }}">
                        Tambah Pengumuman
                    </a>
                @endif
            </h3>
            <div class="p-4 bg-white rounded-3">
                {{-- Tabel Pengumuman --}}
                <div class="table-responsive col-12">
                    @if (count($pengumuman) > 0)
                        <table id="table" class="table table-striped table-hover table-lg p-3">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Pengumuman</th>
                                    @if (Auth::user()->hasRole('Pengajar'))
                                        <th scope="col">Tanggal</th>
                                    @endif
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($pengumuman as $key)
                                    @if ($key->isHidden != 1 || Auth::user()->hasRole('Pengajar'))
                                        <tr class=" @if ($key->isHidden == 1) opacity-50 @endif">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $key->name }}
                                                @if ($key->isHidden == 1)
                                                    <i class="fa-solid fa-eye-slash fa-bounce text-danger"></i>
                                                @endif
                                            </td>
                                            @if (Auth::user()->hasRole('Pengajar'))
                                                <td>
                                                    {{ $key->created_at->format('d F Y H:i') }}
                                                </td>
                                            @endif
                                            @if (Auth::user()->hasRole('Pengajar'))
                                                <td>
                                                    <a href="{{ route('viewPengumuman', ['pengumuman' => $key->id, 'mapel' => $mapel['id']]) }}"
                                                        class="badge bg-info p-2 mb-1 animate-btn-small">
                                                        <i class="fa-regular fa-eye fa-xl"></i>
                                                    </a>
                                                    <a href="{{ route('viewUpdatePengumuman', ['pengumuman' => $key->id, 'mapel' => $mapel['id']]) }}"
                                                        class="badge bg-secondary p-2 mb-1 animate-btn-small">
                                                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                                                    </a>
                                                    <a href="#table" class="badge bg-secondary p-2 animate-btn-small">
                                                        <i class="fa-solid fa-xl fa-trash" data-bs-toggle="modal"
                                                            data-bs-target="#modalHapusPengumuman"
                                                            onclick="changeValuePengumuman({{ $key->id }})"></i>
                                                    </a>
                                                </td>
                                            @else
                                                <td>
                                                    <a
                                                        href="{{ route('viewPengumuman', ['pengumuman' => $key->id, 'mapel' => $mapel['id']]) }}">
                                                        <button type="button" class="btn btn-primary"><i
                                                                class="fa-regular fa-eye fa-xl"></i>
                                                            View</button>
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <img src="{{ url('/asset/img/not-found.png') }}" alt="" class="img-fluid w-50"
                                style="filter: saturate(0);" srcset="">
                            <br>
                            <Strong>Belum ada Pengumuman</Strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 mt-4">
            <h3 class="fw-bold text-primary">
                <i class="fa-solid fa-book"></i> Materi
                @if (Auth::user()->hasRole('Pengajar'))
                    <a href="{{ route('materi.create', $kelasMapel->id) }}" class="btn btn-outline-primary">
                        + Tambah
                    </a>
                @endif
            </h3>

            <div class="p-4 bg-white rounded-3">
                <div class="row">
                    <div class="table-responsive col-lg-6 col-12 p-3" style="max-height: 300px; overflow-y:auto;">
                        @if ($materi->count() > 0)
                            <table class="table table-striped table-hover table-lg p-3">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Materi</th>
                                        @if (Auth::user()->hasRole('Pengajar'))
                                            <th>Tanggal</th>
                                        @endif
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($materi as $key)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $key->name }}</td>

                                            @if (Auth::user()->hasRole('Pengajar'))
                                                <td>{{ $key->created_at->format('d F Y H:i') }}</td>
                                                <td>
                                                    {{-- View --}}
                                                    <a href="{{ route('materi.show', $key->id) }}"
                                                        class="badge bg-info p-2 mb-1">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    {{-- Edit --}}
                                                    <a href="{{ route('materi.edit', $key->id) }}"
                                                        class="badge bg-secondary p-2 mb-1">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    {{-- Delete --}}
                                                    <form action="{{ route('materi.destroy', $key->id) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="badge bg-danger p-2 border-0">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            @else
                                                <td>
                                                    <a href="{{ route('materi.show', $key->id) }}" class="btn btn-primary">
                                                        <i class="fa-regular fa-eye"></i> View
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center">
                                <img src="{{ url('/asset/img/not-found.png') }}" alt="" class="img-fluid w-50"
                                    style="filter: saturate(0);">
                                <br>
                                <strong>Belum ada Materi</strong>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-6 col-12 p-4">
                        <div class="border border-primary rounded-2 h-100 p-3">
                            <h6 class="text-primary fw-bold text-center">Materi</h6>
                            <p>
                                Materi berfungsi sebagai akses materi pembelajaran, referensi untuk belajar mandiri,
                                pemantauan kemajuan, dan sumber referensi bagi pengguna dalam memahami materi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- <div class="col-lg-12 col-md-12 mt-4">
        <h3 class="fw-bold text-primary"><i class="fa-solid fa-comments"></i> Diskusi
            @if (Auth::user()->hasRole('Pengajar'))
                <a href="{{ route('viewCreateDiskusi', $kelasMapel->id) }}">
                    <button type="button" class="btn btn-outline-primary">+ Tambah Diskusi</button>
                </a>
            @endif
        </h3> --}}
        {{-- <div class="p-4 bg-white rounded-3">
            <div class="row">
                {{-- Tabel Diskusi --}}
                {{-- <div class="table-responsive col-lg-6 col-12 p-3" style="max-height: 300px; overflow-y:auto;">
                    @if ($diskusi->count() > 0)
                        <table id="table" class="table table-striped table-hover table-lg p-3">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Diskusi</th>
                                    @if (Auth::user()->hasRole('Pengajar'))
                                        <th>Tanggal</th>
                                    @endif
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($diskusi as $key)
                                    @if ($key->isHidden != 1 || Auth::user()->hasRole('Pengajar'))
                                        <tr class="@if ($key->isHidden == 1) opacity-50 @endif">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $key->name }}
                                                @if ($key->isHidden == 1)
                                                    <i class="fa-solid fa-eye-slash fa-bounce text-danger"></i>
                                                @endif
                                            </td>
                                            @if (Auth::user()->hasRole('Pengajar'))
                                                <td>{{ $key->created_at->format('d F Y H:i') }}</td>
                                            @endif

                                            <td>
                                                @if (Auth::user()->hasRole('Pengajar'))
                                                    {{-- viewDiskusi hanya butuh diskusi --}}
                                                    {{-- <a href="{{ route('viewDiskusi', $key->id) }}"
                                                        class="badge bg-info p-2 mb-1 animate-btn-small">
                                                        <i class="fa-regular fa-eye fa-xl"></i>
                                                    </a> --}} 

                                                    {{-- viewUpdateDiskusi hanya butuh diskusi --}}
                                                    {{-- <a href="{{ route('viewUpdateDiskusi', $key->id) }}"
                                                        class="badge bg-secondary p-2 mb-1 animate-btn-small">
                                                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                                                    </a> --}}

                                                    {{-- Hapus pakai modal --}}
                                                    {{-- <form action="{{ route('destroyDiskusi', $key->id) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus diskusi ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="badge bg-danger p-2 border-0">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form> --}}
                                                {{-- @else
                                                    <a href="{{ route('viewDiskusi', $key->id) }}">
                                                        <button type="button" class="btn btn-primary">
                                                            <i class="fa-regular fa-eye fa-xl"></i> View
                                                        </button>
                                                    </a>
                                                @endif --}}
                                            {{-- </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <img src="{{ url('/asset/img/not-found.png') }}" alt="" class="img-fluid w-50"
                                style="filter: saturate(0);">
                            <br>
                            <strong>Belum ada Diskusi</strong>
                        </div>
                    @endif
                </div> --}}

                {{-- Tabel Kanan --}}
                {{-- <div class="p-4 col-lg-6 col-12">
                    <div class="border border-primary rounded-2 h-100 p-3">
                        <h6 class="text-primary fw-bold text-center">Diskusi</h6>
                        <p>
                            Diskusi berfungsi sebagai platform interaksi antara pengguna untuk berbagi pengetahuan,
                            pengalaman, dan pandangan. Melalui diskusi, peserta dapat saling bertukar ide, memecahkan
                            masalah bersama, dan memperdalam pemahaman tentang materi. Diskusi juga membantu dalam
                            mengembangkan kemampuan berpikir kritis dan komunikasi, serta membangun komunitas
                            pembelajaran yang saling mendukung.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}} 


    {{-- Section  tUGAS --}}
    <div class="col-lg-12 col-md-12 mt-4">
        <h3 class="fw-bold text-primary">
            <i class="fa-solid fa-pen"></i> Tugas
            @if (Auth::user()->hasRole('Pengajar'))
                <a href="{{ route('viewCreateTugas', ['kelas' => $kelas->id, 'mapel' => $mapel->id]) }}">
                    <button type="button" class="btn btn-outline-primary">+ Tambah</button>
                </a>
            @endif
        </h3>
        <div class="p-4 bg-white rounded-3">
            <div class="row">
                {{-- Kolom kiri: tabel tugas --}}
                <div class="table-responsive col-lg-6 col-12 p-3">
                    @if ($tugas->count() > 0)
                        <table class="table table-striped table-hover table-lg">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Tugas</th>
                                    <th>Deadline</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tugas as $key)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $key->name }}
                                            @if ($key->isHidden == 1)
                                                <i class="fa-solid fa-lock text-danger"></i>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($key->due)->format('d M Y H:i') }}</td>
                                        <td>
                                            {{-- View --}}
                                            <a href="{{ route('viewTugas', [
                                                'tugas' => $key->id,
                                                'kelasMapelId' => $kelasMapel->id,
                                                'mapelId' => $mapel->id,
                                            ]) }}"
                                                class="badge bg-info p-2 mb-1 animate-btn-small">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>

                                            @if (Auth::user()->hasRole('Pengajar'))
                                                {{-- Edit --}}
                                                <a href="{{ route('viewUpdateTugas', $key->id) }}"
                                                    class="badge bg-secondary p-2 mb-1 animate-btn-small">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                {{-- Hapus (onclick confirm) --}}
                                                <form action="{{ route('tugas.destroy', $key->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin mau hapus tugas ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="badge bg-danger border-0 p-2 mb-1 animate-btn-small">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <img src="{{ url('/asset/img/not-found.png') }}" alt="not found" class="img-fluid w-50"
                                style="filter: saturate(0);">
                            <br>
                            <strong>Belum ada Tugas</strong>
                        </div>
                    @endif
                </div>

                {{-- Kolom kanan: penjelasan --}}
                <div class="p-4 col-lg-6 col-12">
                    <div class="border border-primary rounded-2 h-100 p-3">
                        <h6 class="text-primary fw-bold text-center">Tugas</h6>
                        <p>
                            Tugas digunakan untuk menguji pemahaman siswa, memberi latihan,
                            serta menilai hasil belajar. Fitur ini memudahkan guru memberi
                            instruksi dan siswa mengunggah hasil kerja dengan rapi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Section Ujian --}}
    <div class="mb-4 ps-4 pe-4">
        <h3 class="text-primary fw-bold">
            <i class="fa-solid fa-newspaper"></i> Ujian
            @if (Auth::user()->hasRole('Pengajar'))
                <a href="{{ route('ujian.add', ['kelas' => $kelasId, 'mapel' => $mapel->id]) }}">
                    <button type="button" class="btn btn-outline-primary">+ Tambah</button>
                </a>
            @endif
        </h3>

        <div class="p-4 bg-white rounded-3">
            <div class="table-responsive col-12">
                @if ($ujian->count() > 0)
                    <table id="table" class="table table-hover table-striped table-lg">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Ujian</th>
                                <th>Time</th>
                                <th>Tipe Soal</th>
                                <th>Jumlah Soal</th>
                                <th>Due Date</th>
                                @if (Auth::user()->hasRole('Pengajar'))
                                    <th>Tanggal</th>
                                @endif
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ujian as $key)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $key->name }}</td>
                                    <td>{{ $key->time }} Menit</td>
                                    <td><span class="badge p-2 bg-dark">Pilihan Ganda</span></td>
                                    <td>{{ $key->soalUjianMultiple->count() }}</td>
                                    <td>
                                        @php
                                            $dueDate = \Carbon\Carbon::parse($key->due);
                                            $now = \Carbon\Carbon::now();
                                            $daysUntilDue = $dueDate->diffInDays($now);
                                        @endphp
                                        @if ($dueDate->isPast())
                                            <span class="badge bg-secondary">Selesai</span>
                                        @else
                                            @if ($daysUntilDue == 0)
                                                <span class="badge bg-warning">Hari ini deadline</span>
                                            @else
                                                <span class="badge bg-primary">{{ $daysUntilDue }} hari lagi</span>
                                            @endif
                                        @endif
                                    </td>

                                    @if (Auth::user()->hasRole('Pengajar'))
                                        <td>{{ $key->created_at->format('d F Y H:i') }}</td>
                                        <td>
                                            {{-- Kelola soal --}}
                                            <a href="{{ route('ujian.soal.manage', $key->id) }}"
                                                class="badge bg-info p-2 mb-1 animate-btn-small">
                                                <i class="fa-regular fa-eye fa-xl"></i> Soal
                                            </a>

                                            {{-- Edit ujian --}}
                                            {{-- <a href="{{ route('viewUpdateUjian', $key->id) }}"
                                           class="badge bg-secondary p-2 mb-1 animate-btn-small">
                                            <i class="fa-solid fa-pen-to-square fa-xl"></i>
                                        </a> --}}

                                            {{-- Hapus ujian --}}
                                            <a href="#table" class="badge bg-danger p-2 animate-btn-small"
                                                data-bs-toggle="modal" data-bs-target="#modalHapusUjian"
                                                onclick="changeValueUjian({{ $key->id }}, '{{ $key->tipe }}')">
                                                <i class="fa-solid fa-xl fa-trash"></i>
                                            </a>

                                            {{-- Export nilai --}}
                                            <a
                                                href="{{ route('exportNilaiUjian', ['ujian' => $key->id, 'kelasMapel' => $kelasMapel->id]) }}">
                                                <button type="button" class="btn btn-outline-success">
                                                    <i class="fa-solid fa-file-export"></i> Export
                                                </button>
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            @php
                                                // Cek apakah user sudah ada jawaban di salah satu soal ujian
                                                $sudahJawab = false;
                                                foreach ($key->soalUjianMultiple as $soal) {
                                                    if ($soal->userJawaban->count() > 0) {
                                                        $sudahJawab = true;
                                                        break;
                                                    }
                                                }
                                            @endphp

                                            @if ($sudahJawab)
                                                <a href="{{ route('ujian.learning.rapport', $key->id) }}">
                                                    <button type="button" class="btn btn-success">
                                                        Lihat Hasil
                                                    </button>
                                                </a>
                                          
                                        @else
                                            {{-- Belum pernah jawab → tampilkan tombol Kerjakan --}}
                                            <a
                                                href="{{ route('ujian.access', [
                                                    'id' => $key->id,
                                                    'kelasId' => $kelas->id,
                                                    'mapelId' => $mapel->id,
                                                ]) }}">
                                                <button type="button" class="btn btn-primary">
                                                    <i class="fa-regular fa-eye fa-xl"></i> Kerjakan
                                                </button>
                                            </a>
                                    @endif
                                    </td>
                            @endif
                            </tr>
                @endforeach
                </tbody>
                </table>
            @else
                <div class="text-center">
                    <img src="{{ url('/asset/img/not-found.png') }}" alt="" class="img-fluid w-25"
                        style="filter: saturate(0);">
                    <br>
                    <strong>Belum ada Ujian</strong>
                </div>
                @endif
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalHapusMateri" tabindex="-1" aria-labelledby="modalHapusMateriLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusMateriLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Materi ini?
                </div>
                <div class="modal-footer">
                    <form id="formDeleteMateri" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="modal fade" id="modalHapusDiskusi" tabindex="-1" aria-labelledby="modalHapusDiskusiLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusDiskusiLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus diskusi ini?
                </div> --}}
                {{-- <div class="modal-footer">
                      <form action="{{ route('destroyDiskusi') }}" method="POST">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <input type="hidden" name="hapusId" id="diskusiId" value="">
                        <input type="hidden" name="kelasMapelId" id="kelasMapelDiskusi" value="">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div> --}}
            {{-- </div>
        </div>
    </div> --}}
    <div class="modal fade" id="modalHapusPengumuman" tabindex="-1" aria-labelledby="modalHapusPengumumanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusPengumumanLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Pengumuman ini?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('destroyPengumuman') }}" method="post">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <input type="hidden" name="hapusId" id="pengumumanId" value="">
                        <input type="hidden" name="kelasMapelId" id="kelasMapelPengumuman" value="">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus Ujian --}}
    <div class="modal fade" id="modalHapusUjian" tabindex="-1" aria-labelledby="modalHapusUjianLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusUjianLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Ujian ini?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('ujian.destroy') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <input type="hidden" name="hapusId" id="ujianId" value="">
                        <input type="hidden" name="tipe" id="tipe" value="">
                        <input type="hidden" name="kelasMapelId" id="kelasMapelUjian" value="">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Hapus --}}



    <script>
        function changeValueTugas(id) {
            document.getElementById('idTugas').value = id;
        }

        function changeValueMateri(itemId) {
            console.log(itemId);
            const materiId = document.getElementById('materiId');
            const kelasMapelMateri = document.getElementById('kelasMapelMateri');
            materiId.setAttribute('value', itemId);
            kelasMapelMateri.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        }

        // function changeValueDiskusi(itemId) {
        //     console.log(itemId);
        //     const diskusiId = document.getElementById('diskusiId');
        //     const kelasMapelDiskusi = document.getElementById('kelasMapelDiskusi');
        //     diskusiId.setAttribute('value', itemId);
        //     kelasMapelDiskusi.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        // }

        function changeValuePengumuman(itemId) {
            console.log(itemId);
            const pengumumanId = document.getElementById('pengumumanId');
            const kelasMapelPengumuman = document.getElementById('kelasMapelPengumuman');
            pengumumanId.setAttribute('value', itemId);
            kelasMapelPengumuman.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        }

        function changeValueTugas(itemId) {
            console.log(itemId);
            const tugasId = document.getElementById('tugasId');
            const kelasMapelTugas = document.getElementById('kelasMapelTugas');
            tugasId.setAttribute('value', itemId);
            kelasMapelTugas.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        }

        function changeValueUjian(itemId, tipe) {
            console.log(itemId);
            console.log(tipe);
            const ujianId = document.getElementById('ujianId');
            const tipeId = document.getElementById('tipe');
            const kelasMapelUjian = document.getElementById('kelasMapelUjian');
            ujianId.setAttribute('value', itemId);
            tipeId.setAttribute('value', tipe);
            kelasMapelUjian.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        }
    </script>
@endsection

{{-- Script JavaScript --}}
