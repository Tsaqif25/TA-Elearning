@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col gap-6">

  {{-- Header --}}
  <div class="flex items-center gap-4">
    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'tugas',
    ]) }}" 
       class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-transparent hover:border-gray-200 shadow-sm hover:shadow-md transition">
      <i class="fa-solid fa-arrow-left text-gray-700"></i>
    </a>
    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B] leading-tight">{{ $tugas->name }}</h1>
      <p class="text-sm text-[#7F8190] font-medium">Halaman tugas siswa</p>
    </div>
  </div>

  {{-- Detail Tugas --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white border-2 border-black p-5 rounded-xl">
      <h4 class="text-xs text-gray-500 font-semibold mb-1">Nama Tugas</h4>
      <p class="text-lg font-bold text-[#0A090B]">{{ $tugas->name }}</p>
    </div>
    <div class="bg-white border-2 border-black p-5 rounded-xl">
      <h4 class="text-xs text-gray-500 font-semibold mb-1">Deadline</h4>
      @php $localTime = \Carbon\Carbon::parse($tugas->due)->setTimeZone('Asia/Jakarta'); @endphp
      <p class="text-lg font-bold text-[#0A090B]">{{ $localTime->translatedFormat('d F Y H:i') }}</p>
    </div>
    <div class="bg-white border-2 border-black p-5 rounded-xl">
      <h4 class="text-xs text-gray-500 font-semibold mb-1">Status</h4>
      <p class="text-lg font-bold text-[#0A090B]">
        @if(now() < $localTime)
          Dibuka
        @else
          Ditutup
        @endif
      </p>
    </div>
  </div>

  {{-- Deskripsi / Perintah --}}
  <div class="bg-white border-2 border-black p-6 rounded-xl">
    <h5 class="text-lg font-bold mb-3 text-[#0A090B]">Perintah:</h5>
    <div class="prose text-gray-700">{!! $tugas->content !!}</div>
  </div>

  {{-- File Pendukung --}}
  <div class="bg-white border-2 border-black p-6 rounded-xl">
    <h4 class="text-lg font-bold mb-3 text-[#0A090B]">File Pendukung:</h4>
    @if ($tugas->files->count())
      <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach ($tugas->files as $file)
        <li>
          <a href="{{ route('getFileTugas', ['namaFile' => $file->file]) }}" 
             class="flex items-center gap-2 border-2 border-black rounded-lg p-3 hover:bg-gray-50 transition">
            <i class="fa-solid fa-file text-[#6C63FF]"></i>
            <span class="truncate">{{ $file->file }}</span>
          </a>
        </li>
        @endforeach
      </ul>
    @else
      <p class="text-sm text-gray-500 italic">(Tidak ada file tambahan)</p>
    @endif
  </div>

  {{-- Status & File Siswa --}}
  <div class="bg-white border-2 border-black p-6 rounded-xl">
    <h4 class="text-lg font-bold text-[#0A090B] mb-3">Status:
      @if ($userTugas)
        <span class="ml-2 px-3 py-1 rounded-full text-xs font-semibold {{ $userTugas->status == 'Telah dinilai' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
          {{ $userTugas->status }}
        </span>
      @else
        <span class="ml-2 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
          Belum Mengerjakan
        </span>
      @endif
    </h4>

    {{-- File yang sudah diupload --}}
    @if ($userTugas && $userTugas->UserTugasFile->count())
      <div class="mt-4">
        <h6 class="text-md font-semibold mb-2">File Anda:</h6>
        @foreach ($userTugas->UserTugasFile as $f)
          <div class="flex justify-between items-center border-2 border-black rounded-lg p-3 mb-2">
            <a href="{{ route('getFileUser', ['namaFile' => $f->file]) }}" 
               class="flex items-center gap-2 text-[#0A090B] hover:text-[#6C63FF] transition">
              <i class="fa-solid fa-file"></i>
              <span>{{ $f->file }}</span>
            </a>
            <form action="{{ route('destroyFileSubmit') }}" method="POST" onsubmit="return confirm('Yakin hapus file ini?')">
              @csrf
              @method('DELETE')
              <input type="hidden" name="fileName" value="{{ $f->file }}">
              <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                Hapus
              </button>
            </form>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  {{-- Upload File Dropzone --}}
  @if (!($userTugas && $userTugas->status == 'Telah dinilai'))
  <div class="bg-white border-2 border-black p-6 rounded-xl">
    <form action="{{ route('submitTugas', $tugas->id) }}" method="POST" enctype="multipart/form-data" id="submitTugas">
      @csrf
      <h4 class="text-lg font-bold mb-4 text-[#0A090B]">Upload Jawaban</h4>
      <div id="my-dropzone" class="dropzone border-2 border-dashed border-[#6C63FF] rounded-xl bg-gray-50 p-10 text-center text-gray-600 font-medium">
     
      </div>
      <input type="hidden" name="tugasId" value="{{ $tugas->id }}">
      <button type="submit" 
              class="mt-6 w-full py-3 bg-[#6C63FF] text-white font-semibold rounded-lg shadow hover:bg-[#574FFB] transition flex items-center justify-center gap-2">
        <i class="fa-solid fa-paper-plane"></i>
        Kirim Jawaban
      </button>
    </form>
  </div>
  @else
    <div class="alert alert-info mt-3 text-blue-700 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
      Upload ditutup. Tugas Anda sudah dinilai.
    </div>
  @endif

</div>

{{-- Script Dropzone ONLY --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />

<script>
  Dropzone.autoDiscover = false;

  const myDropzone = new Dropzone("#my-dropzone", {
      url: "{{ route('submitFileTugas') }}",
      paramName: "file",
      maxFilesize: 10,
      acceptedFiles: ".jpg,.jpeg,.png,.gif,.mp4,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.mp3,.avi,.mov",
      addRemoveLinks: true,
      timeout: 60000,
      dictDefaultMessage: "Seret file ke sini atau klik untuk mengunggah",
      autoProcessQueue: false,
      parallelUploads: 100,
      headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
      init: function() {
          this.on("sending", function(file, xhr, formData) {
              formData.append("tugasId", "{{ $tugas->id }}");
          });
      }
  });

  let uploadedCount = 0;
  myDropzone.on("complete", function(file) {
      uploadedCount++;
      if (uploadedCount === myDropzone.getAcceptedFiles().length) {
        window.location.href = "{{ route('viewKelasMapel', [
'mapel' => $mapel['id'],
    'kelas' => $kelas->id,
    'tab'   => 'tugas'
]) }}";

      }
  });

  $(document).ready(function() {
      $('#submitTugas').on('submit', function(e) {
          e.preventDefault();
          const formData = new FormData(this);

          $.ajax({
              type: 'POST',
              url: $(this).attr('action'),
              data: formData,
              processData: false,
              contentType: false,
              success: function(response) {
                  console.log('Data tersimpan:', response);
                  uploadFiles();
              },
              error: function(error) {
                  console.error(error);
                  alert('Terjadi kesalahan saat menyimpan tugas.');
              }
          });
      });
  });

  function uploadFiles() {
      if (myDropzone.getQueuedFiles().length === 0) {
         window.location.href = "{{ route('viewKelasMapel', [
    'mapel' => $mapel['id'],
    'kelas' => $kelas->id,
    'tab'   => 'tugas'
]) }}";

      } else {
          myDropzone.processQueue();
      }
  }
</script>
@endsection
