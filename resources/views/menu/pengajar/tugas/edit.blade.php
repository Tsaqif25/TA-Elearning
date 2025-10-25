@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
  <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

    <!-- 🔹 Tombol Back -->
    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'tugas',
    ]) }}"
       class="flex items-center gap-2 text-[#2B82FE] hover:text-[#1a5fd4] font-medium text-sm mb-6 transition">
      <i class="fa-solid fa-arrow-left text-xs"></i>
      Kembali ke Daftar Tugas
    </a>

    <!-- 🔸 Header -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-8 flex items-start sm:items-center justify-between flex-wrap gap-4">
      <div class="flex items-start sm:items-center gap-3">
        <div class="w-1.5 h-8 rounded-full bg-[#2B82FE]"></div>
        <div>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0A090B] leading-tight">
            {{ $kelasMapel->kelas->name }} — {{ $kelasMapel->mapel->name }}
          </h1>
          <p class="text-sm text-[#7F8190]">Edit detail tugas dan file pendukung siswa</p>
        </div>
      </div>

      <div class="flex items-center gap-2 bg-[#E8F0FF] text-[#2B82FE] px-3 py-1 rounded-full text-xs font-semibold">
        <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit Tugas
      </div>
    </div>

    <!-- 🔷 Card Form Utama -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8 flex flex-col lg:flex-row gap-6">

      <!-- 📝 Kolom Kiri -->
      <div class="flex-1">
        <form id="formTugasUpdate" action="{{ route('updateTugas', $tugas->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
          @csrf
          @method('PUT')

          <!-- Judul -->
          <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">
              Judul Tugas <span class="text-red-500">*</span>
            </label>
            <input type="text" id="name" name="name" placeholder="Masukkan judul tugas..." 
              value="{{ old('name', $tugas->name) }}" required
              class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition placeholder:text-gray-400">
            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
          </div>

          <!-- Deadline -->
          <div>
            <label for="due" class="block text-sm font-semibold text-gray-800 mb-2">
              Tanggal Jatuh Tempo <span class="text-red-500">*</span>
            </label>
            <input type="datetime-local" id="due" name="due"
              value="{{ old('due', \Carbon\Carbon::parse($tugas->due)->format('Y-m-d\\TH:i')) }}" required
              class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition">
            @error('due')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
          </div>

          <!-- Deskripsi -->
          <div>
            <label for="content" class="block text-sm font-semibold text-gray-800 mb-2">
              Deskripsi / Konten
            </label>
            <textarea id="content" name="content" rows="5" placeholder="Tuliskan instruksi atau penjelasan tugas..."
              class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition resize-none placeholder:text-gray-400">{{ old('content', $tugas->content) }}</textarea>
            @error('content')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
          </div>

          <!-- Dropzone -->
          <div>
            <label class="block text-sm font-semibold text-gray-800 mb-2">Upload File Pendukung</label>
            <div id="my-dropzone" class="dropzone border-2 border-dashed border-gray-300 bg-[#F9FAFB] hover:bg-[#F3F6FF] rounded-xl p-10 text-center cursor-pointer transition">
              <i class="fa-solid fa-cloud-arrow-up text-4xl text-[#2B82FE] mb-3"></i>
              <p class="text-sm text-[#7F8190] font-medium">Seret file ke sini atau klik untuk mengunggah</p>
              <p class="text-xs text-gray-400 mt-1">Format: PDF, DOCX, ZIP — maks 10 MB</p>
            </div>
          </div>

          <!-- Tombol -->
          <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('viewKelasMapel', [ 
                'mapel' => $kelasMapel->mapel->id, 
                'kelas' => $kelasMapel->kelas->id, 
                'tab'=> 'tugas' 
            ]) }}"
              class="px-5 py-2.5 rounded-full border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">
              Batal
            </a>
            <button type="submit" id="btnSimpan"
              class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-gradient-to-r from-[#2B82FE] to-[#1a5fd4] text-white font-semibold shadow hover:opacity-90 transition">
              <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
          </div>
        </form>
      </div>

      <!-- 📂 Kolom Kanan (File Lama) -->
      <div class="lg:w-[30%] bg-[#F9FAFB] border border-gray-200 rounded-2xl p-6 h-fit">
        <h3 class="font-bold text-[#0A090B] mb-3 text-sm flex items-center gap-2">
          <i class="fa-solid fa-folder-open text-[#2B82FE]"></i> File Tugas Saat Ini
        </h3>

        @if ($tugas->files->count())
          <ul class="divide-y divide-gray-100">
            @foreach ($tugas->files as $key)
              <li class="flex items-center justify-between py-3">
                <div class="flex items-center gap-3 min-w-0">
                  @if (Str::endsWith($key->file, ['.jpg', '.jpeg', '.png', '.gif']))
                    <i class="fa-solid fa-image text-indigo-500"></i>
                  @elseif (Str::endsWith($key->file, ['.pdf']))
                    <i class="fa-solid fa-file-pdf text-red-500"></i>
                  @elseif (Str::endsWith($key->file, ['.doc', '.docx']))
                    <i class="fa-solid fa-file-word text-blue-500"></i>
                  @elseif (Str::endsWith($key->file, ['.zip']))
                    <i class="fa-solid fa-file-archive text-amber-500"></i>
                  @else
                    <i class="fa-solid fa-file text-gray-400"></i>
                  @endif
                  <a href="{{ route('getFileTugas', ['namaFile' => $key->file]) }}" 
                     class="text-sm text-gray-700 truncate hover:text-[#2B82FE] hover:underline min-w-0">
                    {{ Str::limit($key->file, 40) }}
                  </a>
                </div>
                <form id="formDeleteFile" action="{{ route('tugas.deleteFile', $tugas->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus file ini?')">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="idTugas" value="{{ $tugas->id }}">
                  <input type="hidden" name="fileName" value="{{ $key->file }}">
                  <button type="submit"
                    class="inline-flex items-center gap-1 text-rose-500 hover:text-rose-700 text-xs font-medium transition">
                    <i class="fa-solid fa-trash"></i> Hapus
                  </button>
                </form>
              </li>
            @endforeach
          </ul>
        @else
          <p class="text-gray-500 text-sm italic py-2">Belum ada file yang diunggah.</p>
        @endif

        <div class="mt-5 border-t border-gray-200 pt-4">
          <h3 class="font-bold text-[#0A090B] mb-3 text-sm uppercase tracking-wide">Catatan</h3>
          <ul class="list-disc list-inside text-sm text-[#7F8190] space-y-2">
            <li>Pastikan data tugas diperbarui dengan benar.</li>
            <li>File lama dapat dihapus jika tidak relevan.</li>
            <li>Perubahan akan langsung diterapkan setelah disimpan.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
Dropzone.autoDiscover = false;
const myDropzone = new Dropzone("#my-dropzone", {
  url: "{{ route('tugas.uploadFile', $tugas->id) }}",
  paramName: "file",
  maxFilesize: 10,
  acceptedFiles: ".jpg,.jpeg,.png,.gif,.mp4,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.mp3,.avi,.mov",
  addRemoveLinks: true,
  timeout: 60000,
  dictDefaultMessage: "Seret file ke sini atau klik untuk mengunggah",
  autoProcessQueue: false,
  parallelUploads: 100,
  headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
});

myDropzone.on("queuecomplete", function () {
  window.location.href = "{{ route('viewKelasMapel', [ 'mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab' => 'tugas' ]) }}";
});

$(document).ready(function () {
  $('#formTugasUpdate').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
      type: 'POST',
      url: $(this).attr('action'),
      data: formData,
      processData: false,
      contentType: false,
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      success: function (response) {
        if (myDropzone.getQueuedFiles().length === 0) {
          Toastify({ text: 'Perubahan tugas berhasil disimpan!', duration: 2000, gravity: 'top', position: 'right', style: { background: '#16a34a' } }).showToast();
          setTimeout(() => window.location.href = "{{ route('viewKelasMapel', [ 'mapel' => $kelasMapel->mapel->id, 'kelas' => $kelasMapel->kelas->id, 'tab' => 'tugas' ]) }}", 1500);
        } else {
          myDropzone.processQueue();
        }
      },
      error: function () {
        Toastify({ text: 'Terjadi kesalahan saat menyimpan tugas.', duration: 3000, gravity: 'top', position: 'right', style: { background: '#dc2626' } }).showToast();
      }
    });
  });
});
</script>
@endsection
