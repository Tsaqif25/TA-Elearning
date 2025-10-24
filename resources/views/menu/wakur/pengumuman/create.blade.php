@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full px-8 pt-8 pb-12 bg-[#F9FAFB] min-h-screen font-poppins">

  <!-- Header Title -->
  <div class="flex items-center gap-3 mb-8">
    <a href="{{ route('pengumuman.index') }}"
       class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-gray-200 hover:bg-gray-100 transition">
      <i class="fa-solid fa-arrow-left text-gray-700"></i>
    </a>
    <div>
      <h1 class="text-xl font-extrabold text-[#0A090B]">Buat Pengumuman Baru</h1>
      <p class="text-sm text-[#7F8190]">Isi form di bawah untuk membuat pengumuman</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 max-w-3xl">
    <form action="{{ route('pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-7">
      @csrf

      <!-- Judul -->
      <div>
        <label class="block text-sm font-semibold mb-2 text-[#0A090B]">
          Judul Pengumuman <span class="text-red-500">*</span>
        </label>
        <input type="text" name="judul" value="{{ old('judul') }}" required
               class="w-full border border-gray-200 rounded-full px-4 py-3 text-sm focus:ring-2 focus:ring-[#6C63FF] focus:border-[#6C63FF] outline-none transition"
               placeholder="Masukkan judul pengumuman...">
      </div>

      <!-- Isi -->
      <div>
        <label class="block text-sm font-semibold mb-2 text-[#0A090B]">
          Isi Pengumuman <span class="text-red-500">*</span>
        </label>
        <textarea name="isi" id="editor" rows="6" required
          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#6C63FF] focus:border-[#6C63FF] outline-none transition resize-none"
          placeholder="Tulis isi pengumuman di sini...">{{ old('isi') }}</textarea>
      </div>

      <!-- Lampiran -->
      <div>
        <label class="block text-sm font-semibold mb-2 text-[#0A090B]">
          Lampiran File (Opsional)
        </label>
        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center text-[#7F8190] hover:bg-gray-50 hover:border-[#6C63FF] transition cursor-pointer">
          <input type="file" name="lampiran" id="fileUpload" class="hidden">
          <label for="fileUpload" class="cursor-pointer flex flex-col items-center gap-2">
            <i class="fa-solid fa-upload text-3xl text-[#6C63FF]"></i>
            <span class="text-sm font-medium text-[#0A090B]">Klik untuk upload file</span>
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
          <i class="fa-solid fa-paper-plane"></i> Simpan Pengumuman
        </button>
      </div>
    </form>
  </div>
</div>

<!-- JS kecil untuk ubah nama file setelah upload -->
<script>
  const fileUpload = document.getElementById('fileUpload');
  fileUpload.addEventListener('change', function() {
    if (this.files.length > 0) {
      const label = this.nextElementSibling;
      label.querySelector('span.text-sm.font-medium').textContent = this.files[0].name;
    }
  });
</script>
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>



@endsection
