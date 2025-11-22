@extends('layout.template.mainTemplate')

@section('container')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Informasi Tugas --}}
    <div class="mb-4 p-4 bg-white rounded-4">
        <div class=" p-4">
            <h2 class="fw-bold mb-2 text-primary">{{ $ujian->name }}</h2>
            <hr>
            <div class="row">
                @php
                    $end_time = Carbon\Carbon::parse($userCommit->end_time);
                    $now = Carbon\Carbon::now();
                    if ($now > $end_time) {
                        $diffInSeconds = 0;
                    } else {
                        $diffInSeconds = $end_time->diffInSeconds($now);
                    }
                @endphp

                <div class="border p-3 fw-bold col-lg-3 col-12">
                    Deadline :
                    <span class="badge badge-primary p-2">
                        {{ \Carbon\Carbon::parse($userCommit->end_time)->format('h:i A') }}
                    </span>
                </div>

              

                <div class="col-12 border p-3 col-lg-3">
                    <span class="fw-bold">Jumlah Soal :</span>
                    {{ count($ujian->SoalUjianEssay) }}
                </div>
            </div>
        </div>
    </div>
    <hr>

    {{-- Main Section --}}
    <div class="row">
        {{-- Question Section --}}
        <div class="col-lg-8 col-12">
            <div class="bg-white p-4 rounded-2 row">
                {{-- Soal --}}
                <div class="border border-primary rounded-2 p-4 mb-4 col-12" id="soal-container">
                    <h1 class="text-primary fw-bold" id="soal-title">Soal 1</h1>
                    <hr>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aliquid atque quos inventore nesciunt
                        voluptates ipsam molestias non quasi incidunt dolor!</p>
                </div>

                {{-- Jawaban --}}
                <div class="rounded-2 mb-4 col-12">
                    <h6 class="text-primary fw-bold">Jawaban</h6>
                    <textarea id="jawaban" cols="30" rows="10" class="form-control"></textarea>
                </div>

                {{-- Next and Prev --}}
                <div class="d-flex justify-content-between align-items-center col-12">
                    <button class="btn btn-primary" id="prevBtn" disabled>Previous</button>
                    <button class="btn btn-primary" id="nextBtn">Next</button>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <div class="col-lg-4 col-12">
            <div class="bg-white p-4 rounded-2">
                <div class="border border-primary rounded-2 p-4">
                    <h5 class="text-primary fw-bold">Nomor Soal</h5>
                    <div class="border border-secondary p-4 rounded-2" id="nomorSoalContainer">
                        @foreach ($ujian->SoalUjianEssay as $index => $soal)
                            <button class="btn btn-outline-primary nomor-soal-btn"
                                data-soal="{{ $soal->id }}">{{ $index + 1 }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#modalSelesai">Selesai
                    Mengerjakan</button>
            </div>
        </div>

    </div>

    {{-- Modal --}}
    <div class="modal fade" id="modalSelesai" tabindex="-1" aria-labelledby="modalSelesai" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Selesai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin mengakhiri ujian?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('selesaiUjian') }}" method="post">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <input type="hidden" name="userCommit" id="userCommit" value="{{ encrypt($userCommit['id']) }}">
                        {{-- <input type="hidden" name="idMateri" id="idMateri" value="{{ $materi['id'] }}"> --}}
                        <button type="submit" class="btn btn-danger">Selesai</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   
@endsection
