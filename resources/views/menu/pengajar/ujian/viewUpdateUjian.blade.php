@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
  <div class="max-w-[1100px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

    <!-- 🔹 Tombol Back -->
    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'quiz'
    ]) }}" 
       class="flex items-center gap-2 text-[#2B82FE] hover:text-[#1a5fd4] font-medium text-sm mb-6 transition">
      <i class="fa-solid fa-arrow-left text-xs"></i>
      Kembali ke Daftar Quiz
    </a>

    <!-- 🔸 Header -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-8 flex items-start sm:items-center justify-between flex-wrap gap-4">
      <div class="flex items-start sm:items-center gap-3">
        <div class="w-1.5 h-8 rounded-full bg-[#2B82FE]"></div>
        <div>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0A090B] leading-tight">
            Update Quiz
          </h1>
          <p class="text-sm text-[#7F8190]">Edit quiz untuk siswa di kelas {{ $kelasMapel->kelas->name }} — {{ $kelasMapel->mapel->name }}</p>
        </div>
      </div>

      <div class="flex items-center gap-2 bg-[#E8F0FF] text-[#2B82FE] px-3 py-1 rounded-full text-xs font-semibold">
        <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit Quiz
      </div>
    </div>

    <!-- 🔷 Form Card -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8 flex flex-col lg:flex-row gap-6">

      <!-- 🧩 Kolom Kiri -->
      <div class="flex-1">
        @if ($errors->any())
          <div class="mb-5 p-4 rounded-2xl border-2 border-red-200 bg-red-50">
            <ul class="mb-0 text-sm text-red-700 list-disc pl-5">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('ujian.update', $ujian->id) }}" method="POST" class="space-y-5">
          @csrf
          @method('PUT')

          <!-- Judul Ujian -->
          <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">
              Judul Ujian <span class="text-red-500">*</span>
            </label>
            <input type="text" id="name" name="name" value="{{ old('name', $ujian->name) }}" required
              placeholder="Masukkan judul ujian..."
              class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition placeholder:text-gray-400">
          </div>

  

          <!-- Tanggal Jatuh Tempo -->
          <div>
            <label for="due" class="block text-sm font-semibold text-gray-800 mb-2">
              Tanggal Jatuh Tempo <span class="text-red-500">*</span>
            </label>
            <input type="datetime-local" id="due" name="due"
              value="{{ old('due', \Carbon\Carbon::parse($ujian->due)->format('Y-m-d\\TH:i')) }}" required
              class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition">
          </div>

          <!-- Tombol -->
          <div class="flex justify-end gap-3 mt-8">
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

      <!-- 📘 Kolom Kanan (Catatan) -->
      <div class="lg:w-[30%] bg-[#F9FAFB] border border-gray-200 rounded-2xl p-6 h-fit">
        <h3 class="font-bold text-[#0A090B] mb-3 text-sm uppercase tracking-wide">
          Catatan
        </h3>
        <ul class="list-disc list-inside text-sm text-[#7F8190] space-y-2">
          <li>Pastikan judul, durasi, dan waktu sudah benar.</li>
          <li>Quiz akan menyesuaikan perubahan ini secara otomatis.</li>
          <li>Periksa kembali sebelum menyimpan perubahan.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection