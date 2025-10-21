@extends('layout.template.mainTemplate')

@section('container')
<div class="container py-5">


     <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'quiz',
    ]) }}" 
       class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-transparent hover:border-gray-200 shadow-sm hover:shadow-md transition">
      <i class="fa-solid fa-arrow-left text-gray-700"></i>
    </a>
  {{-- ✅ Informasi Ujian --}}
  <div class="mb-4 text-center">
    <h2 class="fw-bold">{{ $ujian->name }}</h2>
    <p class="text-muted">
      {{ $ujian->kelasMapel->mapel->name }} - {{ $ujian->kelasMapel->kelas->name }}
    </p>
    <p>Total Questions: <strong>{{ $ujian->soalUjianMultiple->count() }}</strong></p>
  </div>

  {{-- ✅ Daftar Siswa --}}
  <h3 class="fw-bold mb-3">Students</h3>

  @forelse ($students as $student)
    <div class="student-card w-100 d-flex justify-content-between align-items-center p-3 border rounded-4 mb-3 shadow-sm">
      
      {{-- 🧍 Informasi Siswa --}}
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

      {{-- 🎯 Status dan Nilai --}}
      <div class="text-end">
        @if ($student->status === 'Passed')
          <span class="badge px-3 py-2 text-white fw-bold" style="background-color:#06BC65;">
            Passed
          </span>
        @elseif ($student->status === 'Not Passed')
          <span class="badge px-3 py-2 text-white fw-bold" style="background-color:#F04438;">
            Not Passed
          </span>
        @else
          <span class="badge px-3 py-2 text-white fw-bold" style="background-color:#7F8190;">
            Not Started
          </span>
        @endif

        <p class="text-muted small mt-1 mb-0">
          Correct: {{ $student->correct }} / {{ $student->total }}
        </p>
      </div>
    </div>
  @empty
    <p class="text-center text-muted">Belum ada siswa yang terdaftar untuk ujian ini.</p>
  @endforelse

</div>
@endsection
