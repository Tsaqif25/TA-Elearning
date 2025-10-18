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

        <form action="{{ route('updateUjian') }}" method="POST">
            @csrf
            <input type="hidden" name="ujian_id" value="{{ $ujian->id }}">

            <h4 class="fw-bold text-primary mb-3"><i class="fa-solid fa-pen"></i> Update Ujian</h4>
            <div class="p-4 bg-white rounded-2 shadow-sm">
                {{-- Judul Ujian --}}
                <div class="mb-3">
                    <label class="form-label">Judul Ujian</label>
                    <input type="text" class="form-control" name="name"
                        value="{{ old('name', $ujian->name) }}" required>
                </div>

                {{-- Durasi --}}
                <div class="mb-3">
                    <label class="form-label">Durasi (menit)</label>
                    <input type="number" class="form-control" name="time"
                        value="{{ old('time', $ujian->time) }}" required>
                </div>

                {{-- Due Date --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Jatuh Tempo</label>
                    <input type="datetime-local" class="form-control" name="due"
                        value="{{ old('due', \Carbon\Carbon::parse($ujian->due)->format('Y-m-d\TH:i')) }}"
                        required>
                </div>
            </div>

            {{-- Soal --}}
            <div class="mt-4">
                <h4 class="fw-bold text-primary mb-3"><i class="fa-solid fa-question"></i> Soal</h4>

                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <input type="text" class="form-control" name="question"
                        value="{{ old('question', optional($ujian->soalUjianMultiple->first())->soal) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jawaban</label>
                    @php
                        $answers = optional($ujian->soalUjianMultiple->first())->answers ?? collect();
                    @endphp
                    @for ($i = 0; $i < 4; $i++)
                        @php $ans = $answers[$i] ?? null; @endphp
                        <div class="d-flex align-items-center mb-2">
                            <input type="text" class="form-control me-2" name="answers[]"
                                   value="{{ old('answers.' . $i, $ans->jawaban ?? '') }}" placeholder="Pilihan jawaban" required>
                            <label class="ms-2">
                                <input type="radio" name="correct_answer" value="{{ $i }}"
                                    @if(old('correct_answer', $ans && $ans->is_correct ? $i : -1) == $i) checked @endif> Benar
                            </label>
                        </div>
                    @endfor
                </div>
            </div>

            <button type="submit" class="btn btn-lg btn-primary mt-3">Update Ujian</button>
        </form>
    </div>
</div>
@endsection
