@extends('layout.template.mainTemplate')

@section('container')
<section class="container py-5">

  {{-- ✅ Judul Soal --}}
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">{{ $soal->soal }}</h3>
  </div>

  {{-- ✅ Form Jawaban --}}
  <form action="{{ route('ujian.answer.store', ['ujian' => $ujian->id, 'soal' => $soal->id]) }}" method="POST" class="mx-auto" style="max-width: 700px;">
    @csrf

    @foreach ($soal->answer as $index => $ans)
      <div class="border rounded-3 p-3 mb-3 d-flex justify-content-between align-items-center">
        <div>
          <strong>{{ chr(65 + $index) }}.</strong> {{ $ans->jawaban }}
        </div>
        <input type="radio" name="answer_id" value="{{ $ans->id }}" required>
      </div>
    @endforeach

    <div class="text-center mt-4">
      <button type="submit" class="btn btn-primary px-4 py-2">Simpan & Lanjut</button>
    </div>
  </form>
</section>
@endsection