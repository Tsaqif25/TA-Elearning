@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col px-6 lg:px-10 mt-6">

  <!-- 🧾 Header Quiz Info -->
  <div class="bg-white border border-[#EEEEEE] rounded-2xl p-6 flex flex-col sm:flex-row justify-between items-center gap-5 shadow-sm">
    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B]">
        {{ $ujian->kelasMapel->kelas->name }} — {{ $ujian->kelasMapel->mapel->name }}
      </h1>
      <p class="text-sm text-[#7F8190]">Hasil pengerjaan quiz oleh siswa</p>
    </div>

    <div class="flex items-center gap-4">
      <div class="flex flex-col text-right">
        <p class="text-sm font-medium text-[#7F8190]">
          Judul Quiz: <span class="text-[#0A090B] font-semibold">{{ $ujian->name }}</span>
        </p>
        <p class="text-sm font-medium text-[#7F8190]">
          Total Soal: <span class="text-[#0A090B] font-semibold">{{ $ujian->soalUjianMultiple->count() }}</span>
        </p>
      </div>
      <div class="w-[80px] h-[80px] bg-gradient-to-r from-[#2B82FE] to-[#1E3A8A] rounded-2xl flex items-center justify-center shadow">
        <i class="fa-solid fa-chart-line text-white text-3xl"></i>
      </div>
    </div>
  </div>

  <!-- 🔙 Tombol Kembali -->
  <div class="mt-6">
    <a href="{{ route('viewKelasMapel', [ 'mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab' => 'quiz' ]) }}"
       class="inline-flex items-center gap-2 text-[#7F8190] hover:text-[#0A090B] font-semibold transition">
      <div class="w-9 h-9 flex items-center justify-center rounded-full border border-[#E5E7EB] hover:bg-[#F3F4F6]">
        <i class="fa-solid fa-arrow-left text-sm"></i>
      </div>
      Kembali ke Daftar Quiz
    </a>
  </div>

  <!-- 🧑‍🎓 DAFTAR SISWA -->
  <div class="mt-6 space-y-5">

    @forelse ($students as $student)
      <div class="bg-white border border-[#EEEEEE] rounded-2xl p-6 flex flex-col sm:flex-row justify-between items-center shadow-sm hover:shadow-md transition">
        <!-- Kiri: Foto & Info Siswa -->
        <div class="flex items-center gap-4">
          <img src="{{ $student->profile_photo_url ?? 'https://i.pravatar.cc/80?u=' . urlencode($student->email) }}"
               alt="Foto Siswa"
               class="w-14 h-14 rounded-full border border-gray-200 object-cover">
          <div>
            <h3 class="font-semibold text-lg text-[#0A090B]">
              {{ $student->dataSiswa->name ?? $student->name }}
            </h3>
            <p class="text-sm text-[#7F8190]">{{ $student->email }}</p>
          </div>
        </div>

        <!-- Kanan: Status & Nilai -->
        <div class="text-right mt-4 sm:mt-0">
          @if ($student->status === 'Passed')
            <span class="text-xs font-semibold bg-[#D1FAE5] text-[#065F46] px-3 py-1 rounded-full">Selesai</span>
          @elseif ($student->status === 'Not Passed')
            <span class="text-xs font-semibold bg-[#FEE2E2] text-[#991B1B] px-3 py-1 rounded-full">Tidak Lulus</span>
          @else
            <span class="text-xs font-semibold bg-[#F3F4F6] text-[#4B5563] px-3 py-1 rounded-full">Belum Mulai</span>
          @endif

          <p class="text-sm text-[#7F8190] mt-1">
            Nilai: <span class="text-[#0A090B] font-semibold">{{ $student->correct ?? 0 }} / {{ $student->total ?? $ujian->soalUjianMultiple->count() }}</span>
          </p>
        </div>
      </div>
    @empty
      <div class="text-center text-[#7F8190] py-10">
        <i class="fa-regular fa-face-frown text-3xl mb-3"></i>
        <p>Tidak ada siswa yang terdaftar untuk quiz ini.</p>
      </div>
    @endforelse

  </div> <!-- END DAFTAR SISWA -->
</div>
@endsection
