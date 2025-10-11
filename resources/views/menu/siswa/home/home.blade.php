@extends('layout.template.mainTemplate')

@section('container')
    <link rel="stylesheet" href="{{ url('/asset/css/card-img-full.css') }}">

    <div class="row">
        @if (session()->has('success'))
            <div class="alert alert-lg alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="col-12 ps-4 pe-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>

        <div class="bg-body-secondary rounded-4 mb-4">
            <div class="container col-xxl-8 px-4 py-5">
                <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                    <div class="col-10 col-sm-8 col-lg-6">
                        <img src="{{ url('/asset/img/work.png') }}" class="d-block mx-lg-auto img-fluid h-50 w-50" alt="Ilustrasi" loading="lazy">
                    </div>
                    <div class="col-lg-6">
                        <h1 class="fw-bold text-body-emphasis lh-1 mb-3">{{ $kelas['name'] }}</h1>
                        <p class="lead">Selamat datang!, Selamat belajar!</p>
                        <button class="btn btn-outline-primary" onclick="getData('{{ $kelas['name'] }}')" data-bs-toggle="modal" data-bs-target="#modal-view">
                            <i class="fa-solid fa-users"></i> View Siswa
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-5 col-md-5 col-lg-3 p-4">
            <div class="bg-white rounded-2 p-4">
                <div id="profile">
                    <div class="mx-auto w-75">
                        <div class="text-center">
                            @if (empty($user->gambar))
                                <img src="/asset/icons/profile-women.svg" class="image-previewer image-class rounded-circle" width="150" alt="Avatar default">
                            @else
                                <img src="{{ asset('storage/file/img-upload/' . $user->gambar) }}" alt="Foto profil" class="image-previewer image-class rounded-circle" width="150">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-7 col-md-7 col-lg col-12 p-4">
            <div class="border border-light-subtle p-4 rounded-2">
                <div class="row d-sm-none d-block">
                    @foreach ($mapelKelas as $mapelKelasItem)
                        <div class="card w-100 my-4">
                            <img src="{{ !empty($mapelKelasItem['gambar']) ? asset('storage/file/img-upload/' . $mapelKelasItem['gambar']) : url('/asset/img/placeholder-3.jpg') }}" class="card-img-top" height="150" alt="Gambar mapel">
                            <div class="card-body">
                                <a href="{{ route('viewKelasMapel', ['mapel' => $mapelKelasItem['mapel_id'], 'kelas' => $kelas['id']]) }}" class="text-dark" style="text-decoration: none;">
                                    <h5 class="card-title">{{ $mapelKelasItem['mapel_name'] }}</h5>
                                </a>
                                <h6 class="small">Pengajar : {{ $mapelKelasItem['pengajar_name'] === '-' ? '-' : $mapelKelasItem['pengajar_name'] }}</h6>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($mapelKelasItem['deskripsi'], 150) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row d-none d-sm-block">
                    @foreach ($mapelKelas as $mapelKelasItem)
                        <div class="card mb-3 col-12 mx-2 bg-white shadow-sm">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <a href="{{ route('viewKelasMapel', ['mapel' => $mapelKelasItem['mapel_id'], 'kelas' => $kelas['id']]) }}" class="text-dark" style="text-decoration:none;">
                                        <div class="card-img-full" style="background-image: url('{{ !empty($mapelKelasItem['gambar']) ? asset('storage/file/img-upload/' . $mapelKelasItem['gambar']) : url('/asset/img/placeholder-3.jpg') }}')">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <a href="{{ route('viewKelasMapel', ['mapel' => $mapelKelasItem['mapel_id'], 'kelas' => $kelas['id']]) }}" class="text-dark" style="text-decoration:none;">
                                            <h5 class="card-title text-black fw-bold">{{ $mapelKelasItem['mapel_name'] }}</h5>
                                        </a>
                                        <h6 class="small">Pengajar : {{ $mapelKelasItem['pengajar_name'] === '-' ? '-' : $mapelKelasItem['pengajar_name'] }}</h6>
                                        <p class="card-text">{{ \Illuminate\Support\Str::limit($mapelKelasItem['deskripsi'], 150) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-view" tabindex="-1" aria-labelledby="modal-view-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-view-title"><i class="fa-solid fa-book"></i> Siswa di {{ $kelas['name'] }}</h5>
                    <button type="button" class="btn-close animate-btn-small" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-1 ps-4 pe-4">
                        <img src="{{ url('/asset/img/panorama.png') }}" class="w-100 rounded-2 img-fluid" alt="Panorama">
                    </div>
                    <div id="modalContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary animate-btn-small" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const loading = `<div id="loadingIndicator2">
                      <div class="spinner-border text-info" role="status">
                          <span class="visually-hidden">Loading...</span>
                      </div>
                    </div>`;

        function getData(itemId) {
            console.log(itemId);
            let kelasName = "{{ $kelas['name'] }}";
            $('#modalContent').html(loading);
            $.ajax({
                url: "{{ route('viewSiswaKelas') }}",
                type: "GET",
                data: { kelasName: kelasName },
                success: function(data) {
                    $('#modalContent').html(data);
                    $("#loadingIndicator2").addClass("d-none");
                },
                error: function() {
                    console.error('Gagal mengambil data siswa.');
                    $("#loadingIndicator2").addClass("d-none");
                }
            });
        }

        const url = "{{ route('searchKelas') }}";
    </script>
@endsection
