@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full p-8 bg-[#F9FAFB] min-h-screen font-poppins">

  <!-- 🔹 Tombol Back -->
  <div class="mb-6">
    <a href="{{ route('pengumuman.index') }}"
       class="flex items-center gap-2 text-[#2B82FE] hover:text-[#1a5fd4] font-medium text-sm transition">
      <i class="fa-solid fa-arrow-left text-xs"></i>
      Kembali ke Daftar Pengumuman
    </a>
  </div>
  <!-- Header -->
  <div class="flex items-center gap-4 mb-8">
    
    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B]">Edit Pengumuman</h1>
      <p class="text-sm text-[#7F8190]">Perbarui isi dan lampiran pengumuman ini</p>
    </div>
  </div>
  <!-- Form Container -->
  <div class="bg-white border border-[#E5E7EB] rounded-2xl shadow-sm p-8 max-w-3xl">
    <h2 class="font-bold text-lg mb-6 text-[#0A090B]">Detail Pengumuman</h2>

    <form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data" class="space-y-7">
      @csrf
      @method('PUT')

      <!-- Judul -->
      <div>
        <label class="block text-sm font-semibold mb-2 text-[#0A090B]">
          Judul Pengumuman <span class="text-red-500">*</span>
        </label>
        <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}" required
               class="w-full border border-gray-200 rounded-full px-4 py-3 text-sm focus:ring-2 focus:ring-[#6C63FF] focus:border-[#6C63FF] outline-none transition" 
               placeholder="Masukkan judul pengumuman...">
      </div>

      <!-- Isi -->
      <div>
        <label class="block text-sm font-semibold mb-2 text-[#0A090B]">
          Isi Pengumuman <span class="text-red-500">*</span>
        </label>
        <textarea name="isi" rows="6" required
                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#6C63FF] focus:border-[#6C63FF] outline-none transition resize-none"
                  placeholder="Tulis isi pengumuman di sini...">{{ old('isi', $pengumuman->isi) }}</textarea>
      </div>

      <!-- Lampiran -->
      <div>
        <label class="block text-sm font-semibold mb-2 text-[#0A090B]">
          Lampiran File (Opsional)
        </label>

        @if ($pengumuman->lampiran)
          <p class="text-sm text-[#7F8190] mb-3">
            File saat ini: 
            <a href="{{ asset('storage/' . $pengumuman->lampiran) }}" target="_blank" class="text-[#2B82FE] font-semibold hover:underline">
              {{ basename($pengumuman->lampiran) }}
            </a>
          </p>
        @endif

        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center text-[#7F8190] hover:bg-gray-50 hover:border-[#6C63FF] transition cursor-pointer">
          <input type="file" name="lampiran" id="fileUpload" class="hidden">
          <label for="fileUpload" class="cursor-pointer flex flex-col items-center gap-2">
            <i class="fa-solid fa-upload text-3xl text-[#6C63FF]"></i>
            <span class="text-sm font-medium text-[#0A090B]">Klik untuk upload file baru</span>
            <span class="text-xs text-gray-400">PDF, DOC, XLS, JPG, PNG (Max 10MB)</span>
          </label>
        </div>
      </div>

      <!-- Tombol -->
      <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('pengumuman.index') }}"
           class="px-6 py-2.5 rounded-full border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">
          Batal
        </a>
        <button type="submit"
          class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#2B82FE] text-white font-semibold shadow hover:bg-[#1E68D9] transition">
          <i class="fa-solid fa-save"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
