@extends('layout.template.mainTemplate')

@section('container')


<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
  <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

    <!-- HEADER GRADIENT KONSISTEN -->
    <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl shadow-lg p-6 sm:p-8 mb-6 relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-tr from-blue-600/90 to-green-500/90 rounded-2xl"></div>

      <div class="relative z-10">

        <!-- Tombol Kembali -->
        <a href="{{ route('viewKelasMapel', [
            'mapel' => $kelasMapel->mapel->id,
            'kelas' => $kelasMapel->kelas->id,
            'tab'   => 'tugas'
        ]) }}"
           class="flex items-center gap-2 text-white/90 hover:text-white font-medium text-sm mb-4 transition">
          <i class="fa-solid fa-arrow-left text-xs"></i>
          Kembali ke Daftar Tugas
        </a>

        <!-- Header Title Section -->
        <div>
          <div class="flex items-center gap-2 mb-3">
            <span class="text-xs font-semibold bg-white/20 text-white px-3 py-1 rounded-full uppercase tracking-wide">Tugas</span>
            <span class="text-xs opacity-90">Deadline:
              {{ \Carbon\Carbon::parse($tugas->due)->translatedFormat('d F Y H:i') }}
            </span>
          </div>

          <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
            {{ $tugas->name }}
          </h1>

          <p class="text-sm opacity-90 mt-1">Lihat dan nilai hasil tugas siswa dari kelas ini</p>
        </div>

      </div>
    </div>

    <!-- STATISTIK -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8">

      <div class="bg-white border border-gray-100 rounded-xl p-4 text-center shadow-sm">
        <p class="text-[#7F8190] text-xs font-medium mb-1">Total Siswa</p>
        <p class="text-lg font-bold text-[#0A090B]">{{ $kelas->dataSiswa->count() }}</p>
      </div>

      <div class="bg-white border border-gray-100 rounded-xl p-4 text-center shadow-sm">
        <p class="text-[#7F8190] text-xs font-medium mb-1">Sudah Upload</p>
        <p class="text-lg font-bold text-[#0A090B]">
          {{ \App\Models\PengumpulanTugas::where('tugas_id', $tugas->id)->count() }}
        </p>
      </div>

      <div class="bg-white border border-gray-100 rounded-xl p-4 text-center shadow-sm">
        <p class="text-[#7F8190] text-xs font-medium mb-1">Status</p>

        @php $localTime = \Carbon\Carbon::parse($tugas->due)->setTimeZone('Asia/Jakarta'); @endphp

        @if(now() < $localTime)
          <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
            <i class="fa-solid fa-unlock"></i> Dibuka
          </span>
        @else
          <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
            <i class="fa-solid fa-lock"></i> Ditutup
          </span>
        @endif
      </div>

    </div>

    <!-- GRID KIRI - KANAN -->
    <div class="grid lg:grid-cols-3 gap-8">

      <!-- BAGIAN KIRI -->
      <div class="lg:col-span-2 flex flex-col gap-6" id="submission-container">

        <!-- DETAIL TUGAS -->
        <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-6 space-y-6">

          <div>
            <h4 class="text-sm text-[#7F8190] font-semibold mb-1">Perintah Tugas</h4>
            <div class="text-sm text-[#0A090B] leading-relaxed">
              {!! $tugas->deskripsi !!}
            </div>
          </div>

          <div>
            <h4 class="text-sm text-[#7F8190] font-semibold mb-2">File Tugas</h4>

            @if ($tugas->files->isNotEmpty())
              @foreach ($tugas->files as $key)
                <a href="{{ asset('storage/' . $key->file) }}"
                   class="flex items-center justify-between bg-[#F9FAFB] border border-gray-100 rounded-xl px-5 py-3 hover:bg-gray-50 transition mb-2"
                   target="_blank">

                  <div class="flex items-center gap-3 overflow-hidden">
                    @if (Str::endsWith($key->file, ['.pdf']))
                      <i class="fa-solid fa-file-pdf text-red-500 text-xl"></i>
                    @elseif (Str::endsWith($key->file, ['.jpg','.jpeg','.png','.gif']))
                      <i class="fa-solid fa-image text-blue-500 text-xl"></i>
                    @elseif (Str::endsWith($key->file, ['.doc','.docx']))
                      <i class="fa-solid fa-file-word text-blue-700 text-xl"></i>
                    @elseif (Str::endsWith($key->file, ['.ppt','.pptx']))
                      <i class="fa-solid fa-file-powerpoint text-orange-500 text-xl"></i>
                    @elseif (Str::endsWith($key->file, ['.xls','.xlsx']))
                      <i class="fa-solid fa-file-excel text-green-600 text-xl"></i>
                    @else
                      <i class="fa-solid fa-file text-gray-500 text-xl"></i>
                    @endif

                    <span class="text-sm font-medium text-gray-700 truncate">
                      {{ Str::substr($key->file, 5, 30) }}
                    </span>
                  </div>

                  <i class="fa-solid fa-ellipsis-vertical text-[#7F8190] hover:text-[#2B82FE]"></i>
                </a>
              @endforeach
            @else
              <p class="text-sm text-gray-500 italic">(Tidak ada file untuk tugas ini)</p>
            @endif
          </div>

        </div>

        <!-- TABLE PENILAIAN -->
        <form id="submission"
              action="{{ route('guru.tugas.nilai.update', ['tugas' => $tugas->id]) }}"
              method="POST"
              class="bg-white border border-[#EEEEEE] rounded-2xl shadow-sm p-6 space-y-4">
          @csrf

          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Submission Siswa ({{ $kelas->dataSiswa->count() }} siswa)</h3>

            <button type="submit"
              class="bg-gradient-to-tr from-blue-500 to-green-500 text-white px-5 py-2 rounded-full text-sm font-semibold">
              <i class="fa-solid fa-floppy-disk mr-1"></i>
              Simpan Nilai 
            </button>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full text-sm border-t border-gray-100">

              <thead class="bg-gray-50 text-[#7F8190] font-semibold uppercase text-xs">
                <tr>
                  <th class="py-3 px-4 text-left">#</th>
                  <th class="py-3 px-4 text-left">Nama</th>
                  <th class="py-3 px-4 text-left">File</th>
                  <th class="py-3 px-4 text-center">Nilai</th>
                  <th class="py-3 px-4 text-center">Input Nilai</th>
              
                  <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th> 
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-100">

                @foreach ($kelas->dataSiswa as $siswa)
                  @php
                    $pengumpulan = \App\Models\PengumpulanTugas::where('tugas_id',$tugas->id)
                        ->where('siswa_id',$siswa->id)
                        ->with('files')
                        ->first();

                    $nilai = \App\Models\NilaiTugas::where('tugas_id',$tugas->id)
                                ->where('siswa_id',$siswa->id)
                                ->value('nilai');

                    $komentarGuru = $pengumpulan->komentar ?? null;
                  @endphp

                  <tr class="hover:bg-gray-50">

                    <td class="py-3 px-4">{{ $loop->iteration }}</td>

                    <td class="py-3 px-4 font-semibold">{{ $siswa->name }}</td>

                    <td class="py-3 px-4">
                      @if ($pengumpulan && $pengumpulan->files->count())
                        @foreach ($pengumpulan->files as $file)
                          <a href="{{ asset('storage/' . $file->file) }}"
                             target="_blank"
                             class="text-[#2B82FE] hover:underline block">
                            Lihat File
                          </a>
                        @endforeach
                      @else
                        <span class="text-gray-500 italic">Belum upload</span>
                      @endif
                    </td>

                    <td class="py-3 px-4 text-center font-semibold">{{ $nilai ?? '-' }}</td>

                    <td class="py-3 px-4 text-center">
                      <input type="hidden" name="siswaId[]" value="{{ $siswa->id }}">
                      <input type="number" name="nilai[]" min="0" max="100"
                             value="{{ $nilai ?? '' }}"
                             class="w-16 border border-gray-200 rounded-xl p-1 text-center focus:ring-[#2B82FE] focus:border-[#2B82FE]">
                    </td>

                  

                    <td class="py-3 px-4 text-center">
                      @if ($pengumpulan)
                        @if ($pengumpulan->is_late)
                          <span class="px-3 py-1 text-[10px] bg-red-100 text-red-700 rounded-full font-semibold">Terlambat</span>
                        @else
                          <span class="px-3 py-1 text-[10px] bg-green-100 text-green-700 rounded-full font-semibold">Tepat Waktu</span>
                        @endif
                      @else
                        <span class="text-gray-400 text-xs italic">Belum upload</span>
                      @endif
                    </td>
                    <td class="py-3 px-4 text-center">
          <a href="{{ route('guru.tugas.diskusi', [
    'tugas' => $tugas->id,
    'siswa' => $siswa->id
]) }}"
   class="inline-flex items-center gap-1 text-blue-600 text-xs font-semibold hover:underline">
    <i class="fa-regular fa-comments"></i> Buka Diskusi
</a>

        </td>
                  </tr>
                @endforeach

              </tbody>

            </table>
          </div>

        </form>

      </div>

    </div>

  </div>
</div>



{{-- CSS UNTUK MEMPERPANJANG CARD SUBMISSION --}}
<style>
#submission-container {
    grid-column: 1 / -1 !important; /* MEMBUAT SUBMISSION FULL LEBAR */
}

#submission {
    width: 100% !important;
}

#submission table {
    width: 100% !important;
}

#submission textarea {
    min-width: 300px !important;
}
</style>

@endsection
