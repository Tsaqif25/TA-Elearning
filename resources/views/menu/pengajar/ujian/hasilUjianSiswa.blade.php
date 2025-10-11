@extends('layout.template.mainTemplate')

@section('container')
<div class="container py-5">

  <div class="mb-4 text-center">
    <h2 class="fw-bold">{{ $ujian->name }}</h2>
    <p class="text-muted">{{ $ujian->kelasMapel->mapel->name }} - {{ $ujian->kelasMapel->kelas->name }}</p>
    <p>Total Questions: <strong>{{ $ujian->soalUjianMultiple->count() }}</strong></p>
  </div>

  <h3 class="fw-bold mb-3">Students</h3>

  @forelse ($students as $student)
    <div class="student-card w-100 d-flex justify-content-between align-items-center p-3 border rounded-4 mb-3">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle overflow-hidden" style="width: 50px; height: 50px;">
          <img src="{{ asset($student->gambar ?? 'assets/images/photos/default-photo.svg') }}" 
               class="w-100 h-100 object-cover" alt="photo">
        </div>
        <div>
          <p class="fw-bold mb-0">{{ $student->dataSiswa->name ?? $student->name }}</p>
          <p class="text-muted mb-0">{{ $student->email }}</p>
        </div>
      </div>

      @if ($student->status === 'Passed')
        <p class="p-2 px-3 rounded-3 text-white fw-bold" style="background-color:#06BC65;">Passed</p>
      @elseif ($student->status === 'Not Passed')
        <p class="p-2 px-3 rounded-3 text-white fw-bold" style="background-color:#F04438;">Not Passed</p>
      @else
        <p class="p-2 px-3 rounded-3 text-white fw-bold" style="background-color:#7F8190;">Not Started</p>
      @endif
    </div>
  @empty
    <p class="text-center text-muted">Belum ada siswa yang terdaftar untuk ujian ini.</p>
  @endforelse

</div>
@endsection
