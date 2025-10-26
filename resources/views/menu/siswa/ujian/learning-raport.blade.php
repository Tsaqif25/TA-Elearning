@extends('layout.template.mainTemplate')

@section('container')
  <!-- Header -->

    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'quiz'
    ]) }}"
       class="flex items-center gap-2 text-[#2B82FE] hover:text-[#1a5fd4] font-medium text-sm transition">
      <i class="fa-solid fa-arrow-left text-xs"></i>
      Kembali ke Daftar Quiz
    </a>
  <div class="w-full max-w-5xl mb-8 text-center">
    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0A090B]">Hasil Ujian</h1>
    <p class="text-sm text-[#7F8190] mt-1">Ringkasan jawaban dan status pengerjaan</p>
  </div>

  <!-- Tabel Hasil -->
  <div class="bg-white border border-[#EEEEEE] rounded-2xl shadow-sm p-6 w-full max-w-5xl overflow-x-auto">
    <table class="min-w-full border-collapse text-sm">
      <thead class="bg-[#F3F4F6] text-[#7F8190] uppercase text-xs">
        <tr>
          <th class="py-3 px-4 text-left font-semibold">#</th>
          <th class="py-3 px-4 text-left font-semibold">Soal</th>
          <th class="py-3 px-4 text-left font-semibold">Jawaban Anda</th>
          <th class="py-3 px-4 text-left font-semibold">Kunci Jawaban</th>
          <th class="py-3 px-4 text-center font-semibold">Status</th>
        </tr>
      </thead>
      <tbody class="text-[#0A090B]">
        @foreach ($studentAnswers as $index => $answer)
          @php
              $correct = $answer->soalUjianMultiple->answer->firstWhere('is_correct', 1);
              $isCorrect = $correct && $answer->user_jawaban == $correct->jawaban;
          @endphp
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="py-3 px-4">{{ $loop->iteration }}</td>
            <td class="py-3 px-4 font-medium">{{ $answer->soalUjianMultiple->soal }}</td>
            <td class="py-3 px-4 text-[#1E3A8A] font-semibold">{{ $answer->user_jawaban }}</td>
            <td class="py-3 px-4 text-[#047857] font-semibold">{{ $correct ? $correct->jawaban : '-' }}</td>
            <td class="py-3 px-4 text-center">
              @if ($isCorrect)
                <span class="px-3 py-1 rounded-full bg-[#DCFCE7] text-[#065F46] font-semibold text-xs flex items-center justify-center gap-1 w-fit mx-auto">
                  <i class="fa-solid fa-check text-xs"></i> Benar
                </span>
              @else
                <span class="px-3 py-1 rounded-full bg-[#FEE2E2] text-[#B91C1C] font-semibold text-xs flex items-center justify-center gap-1 w-fit mx-auto">
                  <i class="fa-solid fa-xmark text-xs"></i> Salah
                </span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</body>
@endsection
