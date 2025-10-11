@extends('layout.template.mainTemplate')

@section('container')
<div class="row p-4">
    <div class="col-12 col-lg-12">
        <h2 class="fw-bold mb-3">{{ $ujian->name }}</h2>
        <p><i class="fa-solid fa-clock"></i> Durasi: {{ $ujian->time }} menit</p>
        <p><i class="fa-solid fa-calendar"></i> Deadline: {{ $ujian->due }}</p>

        <div class="add-question-box mb-4">
            <a href="{{ route('ujian.soal.create', $ujian->id) }}" class="btn btn-primary">
                ➕ New Question
            </a>
        </div>

        @forelse ($ujian->soalUjianMultiple as $soal)
            <div class="question-card d-flex justify-content-between align-items-center p-3 mb-2 border rounded">
                <div>
                    <div class="label fw-bold">Question</div>
                    <p class="question-text mb-1">{{ $soal->soal }}</p>
                    <ul>
                        @foreach ($soal->answer as $ans)
                            <li>
                                {{ $ans->jawaban }}
                                @if ($ans->is_correct)
                                    <span class="badge bg-success">Benar</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-sm btn-warning">📝 Edit</a>
                    <form action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">🗑️ Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada soal tersedia</p>
        @endforelse
    </div>
</div>
@endsection
