@extends('layout.template.mainTemplate')

@section('container')
    {{-- Navigasi Breadcrumb --}}
    <div class="col-12 ps-4 pe-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('viewKelasMapel', ['mapel' => $mapel['id'], 'kelas' => $kelas['id']]) }}">
                        {{ $mapel['name'] }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"> Ujian</li>
            </ol>
        </nav>
    </div>

    {{-- Judul Halaman --}}
    <div class="ps-4 pe-4 mt-4 pt-4">
        <h2 class="display-6 fw-bold">
            <a href="{{ route('viewKelasMapel', ['mapel' => $mapel['id'], 'kelas' => $kelas['id']]) }}">
                {{ $mapel['name'] }}
            </a>
            Ujian
        </h2>
    </div>

    {{-- Informasi Ujian --}}
    <div class="mb-4 p-4 bg-white rounded-4">
        <div class="p-4">
            <h4 class="fw-bold mb-2">Informasi</h4>
            <hr>
            <h3 class="fw-bold text-primary">
                {{ $ujian->name }}
            </h3>

            @php
                $dueDateTime = \Carbon\Carbon::parse($ujian->due);
                $now = \Carbon\Carbon::now();
            @endphp

            <div class="row">
                @if ($dueDateTime < $now)
                    <div class="border p-3 fw-bold col-lg-3 col-12">
                        Status : <span class="badge badge-danger p-2">Ditutup</span>
                    </div>
                @else
                    <div class="border p-3 fw-bold col-lg-3 col-12">
                        Status : <span class="badge badge-primary p-2">Dibuka</span>
                    </div>
                @endif

                <div class="col-12 border p-3 col-lg-3">
                    <span class="fw-bold">Durasi : </span>{{ $ujian->time }} Menit
                </div>
                <div class="col-12 border p-3 col-lg-3">
                    <span class="fw-bold">Deadline :</span>
                    {{ $dueDateTime->translatedFormat('d F Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    <hr>

    {{-- Kondisi pengerjaan ujian --}}
    @php
        // cek apakah user sudah menjawab minimal 1 soal
        $sudahMenjawab = \App\Models\UserJawaban::where('user_id', auth()->id())
            ->whereIn('multiple_id', $ujian->soalUjianMultiple->pluck('id'))
            ->exists();
    @endphp

    @if ($sudahMenjawab)
        {{-- Jika sudah ada jawaban → tampilkan hasil --}}
        <div class="mb-4 p-4 bg-white rounded-4 text-center">
            <h6 class="fw-bold display-6 text-primary">Hasil Ujian</h6>
            <div class="accordion-body table-responsive p-4">
                <table id="table" class="table table-striped table-hover table-lg">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Soal</th>
                            <th>Jawaban Anda</th>
                            <th>Kunci Jawaban</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ujian->soalUjianMultiple as $key)
                            @php
                                $jawaban = \App\Models\UserJawaban::where('user_id', auth()->id())
                                    ->where('multiple_id', $key->id)
                                    ->first();
                                $correct = $key->answers->firstWhere('is_correct', 1);
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $key->soal }}</td>
                                <td>{{ $jawaban ? $jawaban->jawaban : '-' }}</td>
                                <td>{{ $correct ? $correct->jawaban : '-' }}</td>
                                <td>
                                    @if ($jawaban && $correct && $jawaban->jawaban == $correct->jawaban)
                                        ✅ Benar
                                    @else
                                        ❌ Salah
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        {{-- Jika belum ada jawaban → tombol mulai ujian --}}
    <div class="text-center">
    <a href="{{ route('ujian.start', $ujian->id) }}" class="btn btn-lg btn-primary">
        Mulai Ujian
    </a>
</div>


    @endif
@endsection
