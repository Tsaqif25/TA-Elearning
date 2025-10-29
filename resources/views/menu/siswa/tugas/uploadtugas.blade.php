@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins">
  <div class="max-w-[1200px] w-full mx-auto px-4 sm:px-6 lg:px-10 mt-8 mb-16">

  
    <div class="mb-5">
      <a href="{{ route('viewKelasMapel', [
          'mapel' => $kelasMapel->mapel->id,
          'kelas' => $kelasMapel->kelas->id,
          'tab' => 'tugas'
      ]) }}"
         class="flex items-center gap-2 text-sm text-[#2B82FE] hover:underline font-medium">
        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Daftar Tugas
      </a>
    </div>

  
    <div class="bg-[#2B82FE] text-white rounded-2xl p-6 sm:p-8 mb-8 shadow-sm">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <div class="flex items-center gap-2 mb-3">
            <span class="text-xs font-semibold bg-white/20 text-white px-3 py-1 rounded-full uppercase tracking-wide">TUGAS</span>
            <span class="text-xs opacity-90">Deadline: {{ \Carbon\Carbon::parse($tugas->due)->translatedFormat('d F Y H:i') }}</span>
          </div>

          <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">{{ $tugas->name }}</h1>
          <p class="text-sm opacity-90 mt-1">Halaman tugas siswa</p>
        </div>
      </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
      <div class="bg-white border border-[#EEEEEE] rounded-xl p-5 text-center shadow-sm hover:shadow-md transition">
        <p class="text-[#7F8190] text-xs font-medium mb-1">Nama Tugas</p>
        <p class="text-lg font-bold text-[#0A090B]">{{ $tugas->name }}</p>
      </div>
      <div class="bg-white border border-[#EEEEEE] rounded-xl p-5 text-center shadow-sm hover:shadow-md transition">
        <p class="text-[#7F8190] text-xs font-medium mb-1">Deadline</p>
        @php $localTime = \Carbon\Carbon::parse($tugas->due)->setTimeZone('Asia/Jakarta'); @endphp
        <p class="text-lg font-bold text-[#0A090B]">{{ $localTime->translatedFormat('d F Y H:i') }}</p>
      </div>
      <div class="bg-white border border-[#EEEEEE] rounded-xl p-5 text-center shadow-sm hover:shadow-md transition">
        <p class="text-[#7F8190] text-xs font-medium mb-1">Status</p>
        @if(now() < $localTime)
          <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
            <i class="fa-solid fa-unlock"></i> Dibuka
          </span>
        @else
          <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
            <i class="fa-solid fa-lock"></i> Ditutup
          </span>
        @endif
      </div>
    </div>

  
    <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm hover:shadow-md transition p-6 mb-8">
      <h2 class="text-lg font-semibold mb-3 text-[#0A090B]">Perintah</h2>
      <div class="prose text-gray-700 leading-relaxed">{!! $tugas->content !!}</div>
    </div>

    <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm hover:shadow-md transition p-6 mb-8">
      <h2 class="text-lg font-semibold mb-4 text-[#0A090B]">File Pendukung</h2>
      @if ($tugas->files->count())
        <div class="flex flex-col gap-3">
          @foreach ($tugas->files as $file)
              <a href="{{ asset('storage/' . $file->file) }}"   target="_blank"
               class="flex items-center justify-between bg-[#F9FAFB] border border-[#EEEEEE] rounded-xl px-5 py-3 hover:bg-gray-50 shadow-sm transition">
              <div class="flex items-center gap-3 overflow-hidden">
                <i class="fa-solid fa-file text-[#6C63FF] text-xl"></i>
                <span class="font-medium text-sm text-[#0A090B] truncate">{{ basename($file->file) }}</span>
              </div>
              <i class="fa-solid fa-ellipsis-vertical text-[#7F8190] hover:text-[#2B82FE]"></i>
            </a>
          @endforeach
        </div>
      @else
        <p class="text-gray-500 text-sm">Tidak ada file tambahan untuk tugas ini.</p>
      @endif
    </div>

   
    <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm hover:shadow-md transition p-6 mb-8">
      <h2 class="text-lg font-semibold mb-3 text-[#0A090B]">Status:
        @if ($userTugas)
          <span class="ml-2 px-3 py-1 rounded-full text-xs font-semibold {{ $userTugas->status == 'Telah dinilai' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
            {{ $userTugas->status }}
          </span>
        @else
          <span class="ml-2 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
            Belum Mengerjakan
          </span>
        @endif
      </h2>

      {{-- File Upload Siswa --}}
      @if ($userTugas && $userTugas->UserTugasFile->count())
        <div class="mt-4">
          <h6 class="text-md font-semibold mb-2">File Anda:</h6>
          @foreach ($userTugas->UserTugasFile as $f)
            <div class="flex justify-between items-center border border-[#EEEEEE] rounded-xl p-3 mb-2 shadow-sm hover:shadow-md transition">
           <a href="{{ route('getFileUser', ['namaFile' => $f->file]) }}" 
   target="_blank"
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

    
    @if (!($userTugas && $userTugas->status == 'Telah dinilai'))
    <div class="bg-white rounded-2xl border border-[#EEEEEE] shadow-sm hover:shadow-md transition p-6 mb-8">
      <form action="{{ route('submitTugas', $tugas->id) }}" method="POST" enctype="multipart/form-data" id="submitTugas">
        @csrf
        <h4 class="text-lg font-bold mb-4 text-[#0A090B]">Upload Jawaban</h4>
        <div id="my-dropzone" class="dropzone border-2 border-dashed border-[#6C63FF] rounded-2xl bg-gray-50 p-10 text-center text-gray-600 font-medium">
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
