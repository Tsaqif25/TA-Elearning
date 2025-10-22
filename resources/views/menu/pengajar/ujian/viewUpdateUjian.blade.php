@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col px-6 lg:px-10 mt-6">

  <!-- Header -->
  <div class="mb-6 flex items-center gap-4">
    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'quiz'
    ]) }}" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
      <i class="fa-solid fa-arrow-left text-gray-700"></i>
    </a>
    <div>
      <h1 class="text-2xl font-extrabold">Update Quiz</h1>
      <p class="text-sm text-[#7F8190]">Edit Quiz untuk siswa di kelas ini</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm p-6 sm:p-8 flex flex-col lg:flex-row gap-8">

    <!-- Kolom Kiri -->
    <div class="flex-1">
      @if ($errors->any())
        <div class="mb-4 p-4 rounded-2xl border-2 border-red-200 bg-red-50">
          <ul class="mb-0 text-sm text-red-700 list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('ujian.update', $ujian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Judul Ujian -->
        <div class="mb-5">
          <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
            Judul Ujian <span class="text-red-500">*</span>
          </label>
          <input type="text" id="name" name="name" value="{{ old('name', $ujian->name) }}" required
            placeholder="Masukkan judul ujian..."
            class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition">
        </div>

        <!-- Durasi -->
        <div class="mb-5">
          <label for="time" class="block text-sm font-semibold text-gray-700 mb-2">
            Durasi (menit) <span class="text-red-500">*</span>
          </label>
          <input type="number" id="time" name="time" value="{{ old('time', $ujian->time) }}" required
            placeholder="Masukkan durasi ujian..."
            class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition">
        </div>

        <!-- Tanggal Jatuh Tempo -->
        <div class="mb-5">
          <label for="due" class="block text-sm font-semibold text-gray-700 mb-2">
            Tanggal Jatuh Tempo <span class="text-red-500">*</span>
          </label>
          <input type="datetime-local" id="due" name="due"
            value="{{ old('due', \Carbon\Carbon::parse($ujian->due)->format('Y-m-d\\TH:i')) }}" required
            class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 p-3 outline-none transition">
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end gap-3 mt-6">
          <a href="{{ route('viewKelasMapel', [
              'mapel' => $kelasMapel->mapel->id,
              'kelas' => $kelasMapel->kelas->id,
              'tab' => 'quiz'
          ]) }}"
             class="px-5 py-2.5 rounded-full border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">
            Batal
          </a>
          <button type="submit"
            class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-gradient-to-r from-[#2B82FE] to-[#1a5fd4] text-white font-semibold shadow hover:opacity-90 transition">
            <i class="fa-solid fa-floppy-disk"></i> Update Ujian
          </button>
        </div>
      </form>
    </div>

    <!-- Kolom Kanan (Catatan) -->
    <div class="lg:w-[30%] bg-gray-50 border border-gray-200 rounded-2xl p-5 h-fit">
      <h3 class="font-bold text-[#0A090B] mb-3 text-sm">CATATAN</h3>
      <ul class="list-disc list-inside text-sm text-[#7F8190] space-y-2">
        <li>Pastikan judul, durasi, dan waktu sudah benar.</li>
        <li>Quiz akan menyesuaikan perubahan ini secara otomatis.</li>
        <li>Periksa kembali sebelum menyimpan perubahan.</li>
      </ul>
    </div>
  </div>
</div>
@endsection