@extends('layout.template.mainTemplate')

@section('container')

    {{-- Navigasi Breadcrumb --}}
   <div class="flex flex-col mb-8">
  <!-- Header -->
  <div class="flex items-center gap-4">
    <a href="{{ route('viewKelasMapel', [ 'mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab' => 'tugas', ]) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-transparent hover:border-black shadow-sm hover:shadow-md transition">
      <i class="fa-solid fa-arrow-left text-gray-700"></i>
    </a>
    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B] leading-tight">{{ $kelasMapel->kelas->name }}</h1>
      <p class="text-sm text-[#7F8190] font-medium">{{ $kelasMapel->mapel->name }}</p>
    </div>
  </div>

  <div class="mt-6">
    <h2 class="text-xl font-bold text-[#0A090B]">Lihat Tugas</h2>
    <p class="text-sm text-[#7F8190]">Nilai Tugas siswa</p>
  </div>
</div>

<!-- Informasi & Deadline -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
  <div class="bg-white p-5 rounded-xl border-2 border-black shadow-sm">
    <h4 class="text-sm text-gray-500 font-semibold mb-1">Nama Tugas</h4>
    <p class="text-lg font-bold text-[#0A090B]">{{ $tugas->name }}</p>
  </div>
  <div class="bg-white p-5 rounded-xl border-2 border-black shadow-sm">
    <h4 class="text-sm text-gray-500 font-semibold mb-1">Deadline</h4>
    @php $localTime = \Carbon\Carbon::parse($tugas->due)->setTimeZone('Asia/Jakarta'); @endphp
    <p class="text-lg font-bold text-[#0A090B]">{{ $localTime->translatedFormat('d F Y H:i') }}</p>
  </div>
  <div class="bg-white p-5 rounded-xl border-2 border-black shadow-sm">
    <h4 class="text-sm text-gray-500 font-semibold mb-1">Status</h4>
    <p class="text-lg font-bold text-[#0A090B]">@if(now() < $localTime) Dibuka @else Ditutup @endif</p>
  </div>
</div>

<!-- Perintah -->
<div class="bg-white p-6 rounded-xl border-2 border-black shadow-sm mb-6">
  <h5 class="text-lg font-bold mb-3 text-[#0A090B]">Perintah :</h5>
  <div class="prose text-gray-700">{!! $tugas->content !!}</div>
</div>

<!-- Files -->
<div class="bg-white p-6 rounded-xl border-2 border-black shadow-sm mb-6">
  <h4 class="text-lg font-bold mb-3 text-[#0A090B]">Files</h4>
  <hr class="mb-4">
  @if (count($tugas->files) > 0)
  <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
    @foreach ($tugas->files as $key)
    <li>
      <a href="{{ route('getFileTugas', ['namaFile' => $key->file]) }}" class="flex items-center gap-2 border-2 border-black rounded-lg p-3 hover:bg-gray-50 transition">
        @if (Str::endsWith($key->file, ['.jpg', '.jpeg', '.png', '.gif']))
        <i class="fa-solid fa-image text-blue-500"></i>
        @elseif (Str::endsWith($key->file, ['.mp4', '.avi', '.mov']))
        <i class="fa-solid fa-video text-purple-500"></i>
        @elseif (Str::endsWith($key->file, ['.pdf']))
        <i class="fa-solid fa-file-pdf text-red-500"></i>
        @elseif (Str::endsWith($key->file, ['.doc', '.docx']))
        <i class="fa-solid fa-file-word text-blue-700"></i>
        @elseif (Str::endsWith($key->file, ['.ppt', '.pptx']))
        <i class="fa-solid fa-file-powerpoint text-orange-500"></i>
        @elseif (Str::endsWith($key->file, ['.xls', '.xlsx']))
        <i class="fa-solid fa-file-excel text-green-600"></i>
        @elseif (Str::endsWith($key->file, ['.txt']))
        <i class="fa-solid fa-file-lines text-gray-600"></i>
        @elseif (Str::endsWith($key->file, ['.mp3']))
        <i class="fa-solid fa-music text-pink-600"></i>
        @else
        <i class="fa-solid fa-file text-gray-600"></i>
        @endif
        <span class="truncate">{{ Str::substr($key->file, 5, 20) }}</span>
      </a>
    </li>
    @endforeach
  </ul>
  @else
  <span class="text-sm text-gray-500 italic">(Tidak ada file untuk Tugas ini)</span>
  @endif
</div>

<!-- Tabel Penilaian -->
<form action="{{ route('siswaUpdateNilai', ['tugas' => $tugas->id]) }}" method="post" class="bg-white p-6 rounded-xl border border-black shadow-sm">
  @csrf
  <h3 class="text-lg font-bold text-[#0A090B] mb-4">Submission Siswa ({{ $kelas->users->count() }} siswa)</h3>
  <div class="overflow-x-auto">
    <table class="min-w-full border-collapse text-sm">
      <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
        <tr>
          <th class="py-3 px-4 text-left">#</th>
          <th class="py-3 px-4 text-left">Nama</th>
          <th class="py-3 px-4 text-left">File</th>
          <th class="py-3 px-4 text-left">Status</th>
          <th class="py-3 px-4 text-center">Nilai</th>
          <th class="py-3 px-4 text-center">Input Nilai</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($kelas->users as $siswa)
        @php
        $userTugas = $siswa->userTugas->where('tugas_id', $tugas->id)->first();
        $nilai = $userTugas && is_numeric($userTugas->nilai) ? intval($userTugas->nilai) : null;
        @endphp
        <tr class="border-b hover:bg-gray-50">
          <td class="py-3 px-4">{{ $loop->iteration }}</td>
          <td class="py-3 px-4 font-medium">{{ $siswa->name }}</td>
          <td class="py-3 px-4">
            @if ($userTugas && $userTugas->userTugasFile->count())
              @foreach ($userTugas->userTugasFile as $file)
              <a href="{{ route('getFileUser', ['namaFile' => $file->file]) }}" class="block text-blue-600 hover:underline">
                <i class="fa-solid fa-file me-1"></i>{{ Str::limit($file->file, 30) }}
              </a>
              @endforeach
            @else
              <span class="text-gray-400 italic">Belum upload</span>
            @endif
          </td>
          <td class="py-3 px-4">
            @if ($userTugas)
              <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $userTugas->status == 'Telah dinilai' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                {{ $userTugas->status ?? 'Belum Mengerjakan' }}
              </span>
            @else
              <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Belum Mengerjakan</span>
            @endif
          </td>
          <td class="py-3 px-4 text-center font-semibold">{{ $nilai ?? '-' }}</td>
          <td class="py-3 px-4 text-center">
            <input type="hidden" name="siswaId[]" value="{{ $siswa->id }}">
            <input type="number" name="nilai[]" value="{{ $nilai ?? '' }}" placeholder="0" min="0" max="100" class="w-20 border-2 border-gray-300 rounded-lg text-center py-1 font-bold focus:ring focus:ring-blue-300">
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
<button 
  class="mt-6 w-full py-3 bg-[#6C63FF] text-white font-semibold rounded-lg shadow hover:bg-[#574FFB] transition flex items-center justify-center gap-2"
  type="submit">
  <i class="fa-solid fa-floppy-disk text-lg"></i>
  Simpan Nilai
</button>

  {{-- <a href="{{ route('viewCreateTugas', $kelasMapel->id) }}" 
         class="bg-[#6C63FF] text-white px-6 py-2 rounded-full font-semibold shadow hover:bg-[#574FFB] transition">
        + Buat Tugas
      </a> --}}
</form>

<script>
  document.querySelectorAll('img').forEach(function(el) {
    el.classList.add('img-fluid');
  });
</script>

@endsection