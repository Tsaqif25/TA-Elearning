@extends('layout.template.mainTemplate')

@section('container')



    <div class="flex flex-col mb-8">
  <div class="flex items-center gap-4">
    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'quiz' 
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
    <h2 class="text-xl font-bold text-[#0A090B]">Tambah Quiz</h2>
    <p class="text-sm text-[#7F8190]">Isi Quiz untuk siswa</p>
  </div>
</div>
<div class="p-4">
    <div class="w-full">
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-2xl border-2 border-red-200 bg-red-50">
                <ul class="mb-0 text-sm text-red-700 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ujian.store', $kelasMapel->id) }}" method="POST">
            @csrf

            <div class="p-4 bg-white rounded-2xl border-2 border-black shadow-sm space-y-4">
                {{-- Judul Ujian --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-800 mb-2">Judul Ujian</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-300 bg-gray-50 text-gray-800 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        placeholder="Inputkan judul ujian..." required>
                </div>

                {{-- Durasi --}}
                <div>
                    <label for="time" class="block text-sm font-medium text-gray-800 mb-2">Durasi (menit)</label>
                    <input type="number" id="time" name="time"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-300 bg-gray-50 text-gray-800 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        placeholder="Masukkan durasi ujian" required>
                </div>

                {{-- Due Date --}}
                <div>
                    <label for="due" class="block text-sm font-medium text-gray-800 mb-2">Tanggal Jatuh Tempo</label>
                    <input type="datetime-local" id="due" name="due"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-300 bg-gray-50 text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                </div>
            </div>

            {{-- Submit --}}
             <div class="mt-4 flex gap-3">
                    <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'quiz'
    ]) }}" class="px-6 py-3 rounded-xl border-1 border-black text-gray-700 font-medium hover:bg-gray-100 transition"">
                        Batal
                    </a>
                <button type="submit"
                    class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Ujian
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
