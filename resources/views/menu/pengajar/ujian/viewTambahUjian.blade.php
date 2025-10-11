@extends('layout.template.mainTemplate')

@section('container')
<div class="row p-4">
    <div class="col-12 col-lg-12">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ujian.store') }}" method="POST">
            @csrf
            {{-- Hidden Kelas & Mapel --}}
            <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
            <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">

            <h4 class="fw-bold text-primary mb-3"><i class="fa-solid fa-pen"></i> Data Ujian</h4>
            <div class="p-4 bg-white rounded-2 shadow-sm">
                {{-- Judul Ujian --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Judul Ujian</label>
                    <input type="text" class="form-control" name="name" placeholder="Inputkan judul ujian..." required>
                </div>

                {{-- Durasi --}}
                <div class="mb-3">
                    <label for="time" class="form-label">Durasi (menit)</label>
                    <input type="number" class="form-control" name="time" placeholder="Masukkan durasi ujian" required>
                </div>

                {{-- Due Date --}}
                <div class="mb-3">
                    <label for="due" class="form-label">Tanggal Jatuh Tempo</label>
                    <input type="datetime-local" class="form-control" name="due" required>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-lg btn-primary mt-3">Simpan Ujian</button>
        </form>
    </div>
</div>
@endsection
