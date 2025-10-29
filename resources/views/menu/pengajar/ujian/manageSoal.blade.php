@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col px-4 sm:px-6 lg:px-10 mt-6">

  <!-- 🔹 Tombol Back -->
  <div class="mb-6">
    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'quiz'
    ]) }}"
       class="flex items-center gap-2 text-[#2B82FE] hover:text-[#1a5fd4] font-medium text-sm transition">
      <i class="fa-solid fa-arrow-left text-xs"></i>
      Kembali ke Daftar Quiz
    </a>
  </div>

  <!-- Header Quiz Info -->
  <div class="bg-white border border-[#EEEEEE] rounded-2xl p-6 flex flex-col sm:flex-row justify-between items-center gap-5 shadow-sm">
    <div class="text-center sm:text-left">
      <h1 class="text-2xl font-extrabold text-[#0A090B]">{{ $kelasMapel->kelas->name }} — {{ $kelasMapel->mapel->name }}</h1>
      <p class="text-sm text-[#7F8190]">Kelola pertanyaan untuk quiz ini</p>
    </div>

    <div class="flex items-center gap-4 sm:flex-row flex-col sm:text-right text-center">
      <div class="flex flex-col">
        <p class="text-sm font-medium text-[#7F8190]">Deadline: <span class="text-[#0A090B] font-semibold">{{ \Carbon\Carbon::parse($ujian->due)->format('d M Y') }}</span></p>
      </div>
      <div class="w-[70px] h-[70px] bg-gradient-to-r from-[#2B82FE] to-[#1E3A8A] rounded-2xl flex items-center justify-center shadow">
        <i class="fa-solid fa-clipboard-question text-white text-2xl"></i>
      </div>
    </div>
  </div>

  <!-- Add Question Button -->
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mt-8 mb-4 gap-4">
    <h2 class="text-xl font-bold text-[#0A090B] text-center sm:text-left">Daftar Pertanyaan</h2>
    <a href="{{ route('ujian.soal.create', $ujian->id) }}"
       class="flex items-center justify-center gap-2 bg-gradient-to-r from-[#6436F1] to-[#4F3CF1] text-white px-5 py-2.5 rounded-full font-semibold text-sm shadow hover:opacity-90 transition w-full sm:w-auto">
      <i class="fa-solid fa-plus"></i> Tambah Pertanyaan
    </a>
  </div>

  <!-- Question List -->
  <div class="space-y-5">
    @forelse ($ujian->soalUjianMultiple as $index => $soal)
      <div class="bg-white border border-[#EEEEEE] rounded-2xl p-5 sm:p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-3 gap-3">
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 flex items-center justify-center bg-[#2B82FE]/10 text-[#2B82FE] font-bold rounded-full flex-shrink-0">{{ $index + 1 }}</div>
            <div>
              <p class="text-sm font-medium text-[#7F8190]">Pertanyaan</p>
              <h3 class="font-semibold text-lg text-[#0A090B] leading-snug break-words">{{ $soal->soal }}</h3>
            </div>
          </div>

          <div class="flex gap-2 justify-end sm:flex-nowrap flex-wrap">
            <a href="{{ route('ujian.soal.edit', [$ujian->id, $soal->id]) }}"
               class="flex items-center gap-1 bg-[#E0E7FF] text-[#4338CA] px-3 py-1.5 rounded-full font-semibold text-xs hover:bg-[#C7D2FE] transition w-full sm:w-auto justify-center">
              <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
            <form action="{{ route('ujian.soal.destroy', [$ujian->id, $soal->id]) }}" method="POST" class="w-full sm:w-auto" onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="flex items-center justify-center gap-1 bg-[#FEE2E2] text-[#B91C1C] px-3 py-1.5 rounded-full font-semibold text-xs hover:bg-[#FECACA] transition w-full sm:w-auto">
                <i class="fa-solid fa-trash"></i> Hapus
              </button>
            </form>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
          @php $labels = ['A','B','C','D']; @endphp
          @foreach ($soal->answer as $i => $ans)
            <div class="flex items-center justify-between border border-[#EEEEEE] rounded-xl px-4 py-2.5">
              <p class="text-sm text-[#0A090B] font-medium break-words">{{ $ans->jawaban }}</p>
              @if ($ans->is_correct)
                <span class="bg-[#D1FAE5] text-[#065F46] text-xs font-semibold px-3 py-1 rounded-full whitespace-nowrap">Benar</span>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    @empty
      <div class="text-center py-10 border border-dashed border-gray-300 rounded-2xl bg-gray-50 text-gray-500">
        Belum ada pertanyaan tersedia.
      </div>
    @endforelse
  </div>
</div>

@endsection