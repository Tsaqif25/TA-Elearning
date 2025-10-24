@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full p-8 bg-[#F9FAFB] min-h-screen font-poppins">

  <!-- Header -->
  <div class="flex items-center gap-4 mb-8">
    <a href="{{ route('pengumuman.index') }}" 
       class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 hover:bg-gray-100 transition">
      <i class="fa-solid fa-arrow-left text-gray-700"></i>
    </a>
    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B]">Buat Pengumuman Baru</h1>
      <p class="text-sm text-[#7F8190]">Buat pengumuman untuk semua pengguna sistem</p>
    </div>
  </div>

  <!-- Card Form -->
  <div class="bg-white border border-[#E5E7EB] rounded-2xl shadow-sm p-8 max-w-4xl mx-auto">
    <h2 class="font-bold text-lg mb-5 text-[#0A090B]">Detail Pengumuman</h2>

    <form action="{{ route('pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <!-- Judul -->
      <div>
        <label class="block text-sm font-semibold mb-2">Judul Pengumuman <span class="text-red-500">*</span></label>
        <input type="text" name="judul" placeholder="Masukkan judul pengumuman..."
               required
               class="w-full border border-gray-200 rounded-full p-3 focus:ring-[#6C63FF] focus:border-[#6C63FF] outline-none transition">
      </div>

      <!-- Isi -->
      <div>
        <label class="block text-sm font-semibold mb-2">Isi Pengumuman <span class="text-red-500">*</span></label>
        <textarea name="isi" rows="6" placeholder="Tulis isi pengumuman di sini..."
                  required
                  class="w-full border border-gray-200 rounded-xl p-3 focus:ring-[#6C63FF] focus:border-[#6C63FF] outline-none transition resize-none"></textarea>
      </div>

      <!-- Lampiran -->
      <div>
        <label class="block text-sm font-semibold mb-2">Lampiran File (Opsional)</label>
        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center text-[#7F8190] hover:bg-gray-50 transition">
          <input type="file" name="lampiran" id="fileUpload" class="hidden">
          <label for="fileUpload" class="cursor-pointer flex flex-col items-center gap-2">
            <i class="fa-solid fa-upload text-3xl text-[#6C63FF]"></i>
            <span class="text-sm font-medium">Klik untuk upload file</span>
            <span class="text-xs text-gray-400">PDF, DOC, XLS, JPG, PNG (Max 10MB)</span>
          </label>
        </div>
      </div>

      <!-- Tombol -->
      <div class="flex justify-end gap-3">
        <a href="{{ route('pengumuman.index') }}"
           class="px-5 py-2.5 rounded-full border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">Batal</a>
        <button type="submit"
          class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#6C63FF] text-white font-semibold shadow hover:bg-[#574FFB] transition">
          <i class="fa-solid fa-paper-plane"></i> Buat Pengumuman
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
