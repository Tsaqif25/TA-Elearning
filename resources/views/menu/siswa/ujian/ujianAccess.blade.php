@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col px-6 lg:px-10 mt-6">

  <!-- 📋 INFO KUIS -->
  <div class="bg-white border border-[#EEEEEE] rounded-2xl p-6 flex flex-col sm:flex-row justify-between items-center gap-5 shadow-sm">
    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B]">{{ $ujian->name }} — Ujian</h1>
      <p class="text-sm text-[#7F8190] mt-1">Pastikan kamu sudah siap sebelum memulai ujian</p>
    </div>

    <div class="w-[80px] h-[80px] bg-gradient-to-r from-[#2B82FE] to-[#1E3A8A] rounded-2xl flex items-center justify-center shadow">
      <i class="fa-solid fa-clipboard-question text-white text-3xl"></i>
    </div>
  </div>

  <!-- 🔙 Tombol Kembali -->
  <div class="mt-6">
    <a href="{{ route('viewKelasMapel', ['mapel' => $mapel['id'], 'kelas' => $kelas['id']]) }}"
       class="inline-flex items-center gap-2 text-[#7F8190] hover:text-[#0A090B] font-semibold transition">
      <div class="w-9 h-9 flex items-center justify-center rounded-full border border-[#E5E7EB] hover:bg-[#F3F4F6]">
        <i class="fa-solid fa-arrow-left text-sm"></i>
      </div>
      Kembali ke Daftar Ujian
    </a>
  </div>

  @php
      $dueDateTime = \Carbon\Carbon::parse($ujian->due);
      $now = \Carbon\Carbon::now();
      $siswaJawaban = \App\Models\UserJawaban::where('user_id', auth()->id())
          ->whereIn('multiple_id', $ujian->soalUjianMultiple->pluck('id'))
          ->get()
          ->keyBy('multiple_id');
      $sudahMenjawab = $siswaJawaban->isNotEmpty();
  @endphp

  <!-- 📘 DETAIL INFORMASI UJIAN -->
  <div class="mt-6 bg-white border border-[#EEEEEE] rounded-2xl p-6 shadow-sm space-y-4 max-w-3xl">
    <h3 class="font-bold text-lg text-[#0A090B] flex items-center gap-2">
      <i class="fa-solid fa-circle-info text-[#2B82FE]"></i> Informasi Ujian
    </h3>

    <div class="border-t border-[#E5E7EB] pt-4 space-y-3">
      <div class="flex justify-between">
        <p class="text-[#7F8190] font-medium">Judul</p>
        <p class="font-semibold text-[#0A090B]">{{ $ujian->name }}</p>
      </div>

      <div class="flex justify-between items-center">
        <p class="text-[#7F8190] font-medium">Status</p>
        @if ($dueDateTime < $now)
          <span class="font-semibold px-3 py-1 bg-[#FEE2E2] text-[#B91C1C] rounded-full text-sm">Ditutup</span>
        @else
          <span class="font-semibold px-3 py-1 bg-[#DCFCE7] text-[#065F46] rounded-full text-sm">Dibuka</span>
        @endif
      </div>

    

      <div class="flex justify-between">
        <p class="text-[#7F8190] font-medium">Deadline</p>
        <p class="font-semibold text-[#0A090B]">{{ $dueDateTime->translatedFormat('d F Y H:i') }}</p>
      </div>
    </div>
  </div>

  <!-- 🚀 TAMPILAN HASIL ATAU MULAI UJIAN -->
  @if ($sudahMenjawab)
  <div class="mt-10 bg-white border border-[#EEEEEE] rounded-2xl shadow-sm p-6 overflow-x-auto">
    <h3 class="font-bold text-lg text-[#0A090B] mb-4">Hasil Ujian</h3>
    <table class="min-w-full border-collapse text-sm">
      <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
        <tr>
          <th class="py-3 px-4 text-left">#</th>
          <th class="py-3 px-4 text-left">Soal</th>
          <th class="py-3 px-4 text-left">Jawaban Anda</th>
          <th class="py-3 px-4 text-left">Kunci Jawaban</th>
          <th class="py-3 px-4 text-center">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($ujian->soalUjianMultiple as $key)
          @php
              $jawaban = $siswaJawaban[$key->id] ?? null;
              $correct = $key->answer ? $key->answer->firstWhere('is_correct', 1) : null;
              $isCorrect = $jawaban && $correct && $jawaban->user_jawaban == $correct->jawaban;
          @endphp
          <tr class="border-b hover:bg-gray-50">
            <td class="py-3 px-4">{{ $loop->iteration }}</td>
            <td class="py-3 px-4 font-medium">{{ $key->soal }}</td>
            <td class="py-3 px-4">{{ $jawaban ? $jawaban->user_jawaban : '-' }}</td>
            <td class="py-3 px-4">{{ $correct ? $correct->jawaban : '-' }}</td>
            <td class="py-3 px-4 text-center">
              @if ($isCorrect)
                <span class="px-3 py-1 rounded-full bg-[#DCFCE7] text-[#065F46] font-semibold text-xs">✅ Benar</span>
              @else
                <span class="px-3 py-1 rounded-full bg-[#FEE2E2] text-[#B91C1C] font-semibold text-xs">❌ Salah</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @else
  <div class="mt-10 text-center">
    <a href="{{ route('ujian.start', $ujian->id) }}"
       class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-[#2B82FE] to-[#4F46E5] text-white font-semibold rounded-full text-lg hover:shadow-[0_4px_15px_0_#2B82FE4D] hover:scale-[1.02] transition">
      <i class="fa-solid fa-play"></i> Mulai Ujian
    </a>
    <p class="text-sm text-[#7F8190] mt-2">Pastikan koneksi internet stabil sebelum memulai</p>
  </div>
  @endif
</div>
@endsection