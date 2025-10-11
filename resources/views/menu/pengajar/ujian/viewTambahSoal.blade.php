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

        <form action="{{ route('ujian.soal.store', $ujian->id) }}" method="POST">
            @csrf

            <h4 class="fw-bold text-primary mb-3"><i class="fa-solid fa-question"></i> Tambah Soal</h4>
            <div class="p-4 bg-white rounded-2 shadow-sm">
                {{-- Pertanyaan --}}
                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <input type="text" class="form-control" name="question" placeholder="Tuliskan pertanyaan" required>
                </div>

                {{-- Jawaban --}}
                <div class="mb-3">
                    <label class="form-label">Jawaban</label>
                    @for ($i = 0; $i < 4; $i++)
                        <div class="d-flex align-items-center mb-2">
                            <input type="text" class="form-control me-2" name="answers[]" placeholder="Pilihan jawaban" required>
                            <label class="ms-2">
                                <input type="radio" name="correct_answer" value="{{ $i }}" required> Benar
                            </label>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-lg btn-success mt-3">Simpan Soal</button>
        </form>
    </div>
</div>
@endsection
