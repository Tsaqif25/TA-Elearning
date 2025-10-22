@extends('layout.template.mainTemplate')

@section('container')

<div class="flex flex-col px-5 sm:px-6 lg:px-10 mt-6 mb-10 space-y-6">

  <!-- Header -->
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-extrabold">{{ $kelasMapel->kelas->name }} — {{ $kelasMapel->mapel->name }}</h1>
      <p class="text-sm text-[#7F8190]">Lihat dan nilai tugas siswa</p>
    </div>
    <a href="{{ route('viewKelasMapel', [ 'mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab' => 'tugas']) }}" class="flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-full font-semibold text-sm hover:bg-gray-200 transition">
      <i class="fa-solid fa-arrow-left text-sm"></i> Kembali
    </a>
  </div>

  <!-- 🧾 Detail Tugas -->
  <div class="bg-white border border-[#EEEEEE] rounded-2xl shadow-sm p-6 space-y-6">

    <div class="grid sm:grid-cols-3 gap-4">
      <div>
        <h4 class="text-sm text-[#7F8190] font-semibold">Nama Tugas</h4>
        <p class="text-lg font-bold text-[#0A090B]">{{ $tugas->name }}</p>
      </div>
      <div>
        <h4 class="text-sm text-[#7F8190] font-semibold">Deadline</h4>
        @php $localTime = \Carbon\Carbon::parse($tugas->due)->setTimeZone('Asia/Jakarta'); @endphp
        <p class="text-lg font-bold text-[#F59E0B]"><i class="fa-solid fa-clock mr-1"></i> {{ $localTime->translatedFormat('d F Y H:i') }}</p>
      </div>
      <div>
        <h4 class="text-sm text-[#7F8190] font-semibold">Status</h4>
        @if(now() < $localTime)
          <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full">
            <i class="fa-solid fa-unlock"></i> Dibuka
          </span>
        @else
          <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 text-sm font-semibold rounded-full">
            <i class="fa-solid fa-lock"></i> Ditutup
          </span>
        @endif
      </div>
    </div>

    <div>
      <h4 class="text-sm text-[#7F8190] font-semibold mb-1">Perintah</h4>
      <div class="text-sm text-[#0A090B] leading-relaxed">{!! $tugas->content !!}</div>
    </div>

    <div>
      <h4 class="text-sm text-[#7F8190] font-semibold mb-2">File Tugas</h4>
      @if (count($tugas->files) > 0)
        @foreach ($tugas->files as $key)
          <div class="border border-gray-100 rounded-xl p-3 bg-gray-50 flex justify-between items-center hover:bg-gray-100 transition mb-2">
            <div class="flex items-center gap-3">
              @if (Str::endsWith($key->file, ['.pdf']))
                <i class="fa-solid fa-file-pdf text-red-500 text-xl"></i>
              @elseif (Str::endsWith($key->file, ['.jpg', '.jpeg', '.png', '.gif']))
                <i class="fa-solid fa-image text-blue-500 text-xl"></i>
              @elseif (Str::endsWith($key->file, ['.mp4', '.avi', '.mov']))
                <i class="fa-solid fa-video text-purple-500 text-xl"></i>
              @elseif (Str::endsWith($key->file, ['.doc', '.docx']))
                <i class="fa-solid fa-file-word text-blue-700 text-xl"></i>
              @elseif (Str::endsWith($key->file, ['.ppt', '.pptx']))
                <i class="fa-solid fa-file-powerpoint text-orange-500 text-xl"></i>
              @elseif (Str::endsWith($key->file, ['.xls', '.xlsx']))
                <i class="fa-solid fa-file-excel text-green-600 text-xl"></i>
              @else
                <i class="fa-solid fa-file text-gray-500 text-xl"></i>
              @endif
              <span class="text-sm font-medium text-gray-700">{{ Str::substr($key->file, 5, 20) }}</span>
            </div>
            <a href="{{ route('getFileTugas', ['namaFile' => $key->file]) }}" class="text-[#2B82FE] text-sm font-semibold hover:underline">Lihat</a>
          </div>
        @endforeach
      @else
        <p class="text-sm text-gray-500 italic">(Tidak ada file untuk tugas ini)</p>
      @endif
    </div>
  </div>

  <!-- 🧮 Submission Siswa -->
  <form action="{{ route('siswaUpdateNilai', ['tugas' => $tugas->id]) }}" method="post" class="bg-white border border-[#EEEEEE] rounded-2xl shadow-sm p-6">
    @csrf
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-bold">Submission Siswa ({{ $kelas->users->count() }} siswa)</h3>
      <button type="submit" class="bg-[#2B82FE] text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-[#1a5fd4] transition">
        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Nilai
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
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse ($kelas->users as $siswa)
            @php
              $userTugas = $siswa->userTugas->where('tugas_id', $tugas->id)->first();
              $nilai = $userTugas && is_numeric($userTugas->nilai) ? intval($userTugas->nilai) : null;
            @endphp
            <tr class="hover:bg-gray-50 transition">
              <td class="py-3 px-4 font-medium">{{ $loop->iteration }}</td>
              <td class="py-3 px-4 font-semibold">{{ $siswa->name }}</td>
              <td class="py-3 px-4">
                @if ($userTugas && $userTugas->userTugasFile->count())
                  @foreach ($userTugas->userTugasFile as $file)
                    <a href="{{ route('getFileUser', ['namaFile' => $file->file]) }}" class="text-[#2B82FE] font-semibold hover:underline cursor-pointer block">Lihat File</a>
                  @endforeach
                @else
                  <span class="text-gray-500 italic">Belum upload</span>
                @endif
              </td>
              {{-- <td class="py-3 px-4">
                @if ($userTugas)
                  @if ($userTugas->status == 'Telah dinilai')
                    <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700 font-semibold">Sudah Upload</span>
                  @else
                    <span class="px-3 py-1 rounded-full text-xs bg-gray-200 text-gray-700 font-semibold">Belum Dinilai</span>
                  @endif
                @else
                  <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700 font-semibold">Belum Mengerjakan</span>
                @endif
              </td> --}}
              <td class="py-3 px-4 text-center text-gray-800 font-semibold">{{ $nilai ?? '-' }}</td>
              <td class="py-3 px-4 text-center">
                <input type="hidden" name="siswaId[]" value="{{ $siswa->id }}">
                <input type="number" name="nilai[]" value="{{ $nilai ?? 0 }}" min="0" max="100"
                  class="w-16 border border-gray-200 rounded-xl p-1 text-center text-sm focus:ring-[#2B82FE] focus:border-[#2B82FE] transition">
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-red-500 py-4 font-semibold">❌ Tidak ada siswa di kelas ini</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </form>
</div>

<script>
  document.querySelectorAll('img').forEach(function(el) {
    el.classList.add('img-fluid');
  });
</script>

@endsection