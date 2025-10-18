@extends('layout.template.mainTemplate')

@section('container')
 
    {{-- Navigasi Breadcrumb --}}
<div class="flex flex-col mb-8">
  <div class="flex items-center gap-4">
    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'tugas'
    ]) }}" 
       class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-transparent hover:border-gray-200 shadow-sm hover:shadow-md transition">
      <i class="fa-solid fa-arrow-left text-gray-700"></i>
    </a>

    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B] leading-tight">
        {{ $kelasMapel->kelas->name }}
      </h1>
      <p class="text-sm text-[#7F8190] font-medium">
        {{ $kelasMapel->mapel->name }}
      </p>
    </div>
  </div>

  {{-- Judul Tambah Tugas --}}
  <div class="mt-6">
    <h2 class="text-xl font-bold text-[#0A090B]">Update Tugas</h2>
    <p class="text-sm text-[#7F8190]">Edit detail tugas dan file pendukung siswa</p>
  </div>
</div>



{{-- 🔹 Form Container --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Kolom kiri: Form --}}
    <div class="col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
        <form id="formTugasUpdate" action="{{ route('updateTugas', $tugas->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            {{-- Judul Tugas --}}
            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-800 mb-2">
                    Judul Tugas <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama" name="name"
                    class="w-full px-5 py-3 rounded-2xl border border-gray-300 bg-gray-50 
                           text-gray-800 placeholder-gray-400 
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                           focus:bg-white shadow-sm transition-all duration-200"
                    placeholder="Masukkan judul tugas..." value="{{ old('name', $tugas->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deadline --}}
            <div>
                <label for="due" class="block text-sm font-semibold text-gray-800 mb-2">
                    Deadline <span class="text-red-500">*</span>
                </label>
                <input type="datetime-local" id="due" name="due"
                    value="{{ old('due', \Carbon\Carbon::parse($tugas->due)->format('Y-m-d\TH:i')) }}"
                    class="w-full px-5 py-3 rounded-2xl border border-gray-300 bg-gray-50 
                           text-gray-800 placeholder-gray-400 
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                           focus:bg-white shadow-sm transition-all duration-200" required>
            </div>

            {{-- Konten --}}
            <div>
                <label for="content" class="block text-sm font-semibold text-gray-800 mb-2">
                    Deskripsi <span class="text-gray-400 text-xs">(opsional)</span>
                </label>
                <textarea id="content" name="content" rows="6"
                    class="w-full px-5 py-3 rounded-2xl border border-gray-300 bg-gray-50 
                           text-gray-800 placeholder-gray-400 
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                           focus:bg-white shadow-sm transition-all duration-200 resize-none"
                    placeholder="Tambahkan deskripsi atau petunjuk tugas...">{{ old('content', $tugas->content) }}</textarea>
            </div>

            {{-- Upload File --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">
                    Upload File Pendukung <span class="text-gray-400 text-xs">(opsional)</span>
                </label>
                <div id="my-dropzone" class="dropzone rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 p-8 text-center">
                    <p class="text-gray-500 text-sm">Tarik atau klik untuk unggah file</p>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('viewKelasMapel', [
                    'mapel' => $kelasMapel->mapel->id,
                    'kelas' => $kelasMapel->kelas->id,
                    'tab' => 'tugas'
                ]) }}" 
                class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-100 transition">
                    Batal
                </a>

                <button type="submit" id="btnSimpan"
                    class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- Kolom kanan: File & Catatan --}}
    <div class="space-y-5">
        {{-- File yang sudah ada --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">File Tugas Saat Ini</h3>
            @if ($tugas->TugasFile->count())
                <ul class="divide-y divide-gray-100">
                    @foreach ($tugas->TugasFile as $key)
                        <li class="flex items-center justify-between py-2">
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                @if (Str::endsWith($key->file, ['.jpg', '.jpeg', '.png', '.gif']))
                                    <i class="fa-solid fa-image text-indigo-500"></i>
                                @elseif (Str::endsWith($key->file, ['.pdf']))
                                    <i class="fa-solid fa-file-pdf text-red-500"></i>
                                @elseif (Str::endsWith($key->file, ['.doc', '.docx']))
                                    <i class="fa-solid fa-file-word text-blue-500"></i>
                                @else
                                    <i class="fa-solid fa-file text-gray-400"></i>
                                @endif
                                <a href="{{ route('getFileTugas', ['namaFile' => $key->file]) }}" class="hover:underline">
                                    {{ Str::limit($key->file, 20) }}
                                </a>
                            </div>
                            <form id="formDeleteFile" action="{{ route('tugas.file.delete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus file ini?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="idTugas" value="{{ $tugas->id }}">
                                <input type="hidden" name="fileName" value="{{ $key->file }}">
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                                    Hapus
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 text-sm">Belum ada file yang diunggah.</p>
            @endif
        </div>

        {{-- Catatan --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-2">CATATAN</h3>
            <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
                <li>Pastikan data tugas diperbarui dengan benar.</li>
                <li>File lama bisa dihapus jika tidak relevan.</li>
                <li>Perubahan akan langsung diterapkan setelah disimpan.</li>
            </ul>
        </div>
    </div>
</div>






    {{-- Script yang dibutuhkan --}}
    <script src="https://cdn.tiny.cloud/1/1dcn6y89gj7jtaawstjd7qt5nddl47py62pg67ihnxq6vyoa/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ url('/asset/js/rich-text-editor.js') }}"></script>
    
    {{-- Tambahkan CSS datetimepicker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" />
    
    {{-- Tambahkan JS datetimepicker SETELAH jQuery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;

        // 🔹 Inisialisasi Dropzone (sama seperti pola materi)
        const myDropzone = new Dropzone("#my-dropzone", {
            url: "{{ route('tugas.file.upload') }}?action=edit&idTugas={{ $tugas->id }}", // langsung pakai ID tugas yang sudah ada
            paramName: "file",
            maxFilesize: 10, // MB
            acceptedFiles: ".jpg,.jpeg,.png,.gif,.mp4,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.mp3,.avi,.mov",
            addRemoveLinks: true,
            timeout: 60000,
            dictDefaultMessage: "Seret file ke sini atau klik untuk mengunggah",
            autoProcessQueue: false,
            parallelUploads: 100,
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        });

        // 🔹 Kalau semua file selesai diupload → redirect
        myDropzone.on("queuecomplete", function () {
            window.location.href = "{{ route('viewKelasMapel', [
                'mapel' => $kelasMapel->mapel->id,
                'kelas' => $kelasMapel->kelas->id
            ]) }}";
        });

        // 🔹 Handle form update tugas
        $(document).ready(function () {
            // Handle modal delete button click
           $('#modalDelete').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    const filename = button.data('filename');
    const modal = $(this);
    modal.find('input[name="fileName"]').val(filename);
});

            // Initialize datetimepicker
            $('#due').datetimepicker({
                format: 'Y-m-d H:i',
                locale: 'id',
            });

            // Handle form submit
            $('#formTugasUpdate').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    type: 'POST', // meski ada @method('PUT'), Ajax tetap pakai POST
                    url: $(this).attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function (response) {
                        console.log(response);

                        if (myDropzone.getQueuedFiles().length === 0) {
                            // Tidak ada file → langsung redirect
                            window.location.href = "{{ route('viewKelasMapel', [
                                'mapel' => $kelasMapel->mapel->id,
                                'kelas' => $kelasMapel->kelas->id
                            ]) }}";
                        } else {
                            // Ada file → proses upload
                            myDropzone.processQueue();
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        alert("Terjadi kesalahan saat menyimpan tugas.");
                    }
                });
            });
        });
    </script>
@endsection