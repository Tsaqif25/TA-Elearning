@extends('layout.template.mainTemplate')

@section('container')

  <div class="flex items-center mb-6">


        <a href="{{ route('viewKelasMapel', [
        'mapel' => $kelasMapel->mapel->id,
        'kelas' => $kelasMapel->kelas->id,
        'tab' => 'quiz'
    ]) }}" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
            <i class="fa-solid fa-arrow-left text-gray-700"></i>
        </a>
        <div class="ml-3">
            <h1 class="text-2xl font-bold text-gray-900">Update Quiz </h1>
            <p class="text-sm text-gray-500">Isi Quiz untuk siswa</p>
        </div>
    </div>
<div class="p-4">
    <div class="w-full">
        {{-- Validasi Error --}}
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-2xl border-2 border-red-200 bg-red-50">
                <ul class="mb-0 text-sm text-red-700 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Edit --}}
        <form action="{{ route('ujian.update', $ujian->id) }}" method="POST">
            @csrf
            @method('PUT')

           

            <div class="p-4 bg-white rounded-2xl border-2 border-black shadow-sm space-y-4">
                {{-- Judul Ujian --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-800 mb-2">Judul Ujian</label>
                    <input type="text" id="name" name="name"
                        value="{{ old('name', $ujian->name) }}"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-300 bg-gray-50 text-gray-800 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        placeholder="Inputkan judul ujian..." required>
                </div>

                {{-- Durasi --}}
                <div>
                    <label for="time" class="block text-sm font-medium text-gray-800 mb-2">Durasi (menit)</label>
                    <input type="number" id="time" name="time"
                        value="{{ old('time', $ujian->time) }}"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-300 bg-gray-50 text-gray-800 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        placeholder="Masukkan durasi ujian" required>
                </div>

                {{-- Due Date --}}
                <div>
                    <label for="due" class="block text-sm font-medium text-gray-800 mb-2">Tanggal Jatuh Tempo</label>
                    <input type="datetime-local" id="due" name="due"
                        value="{{ old('due', \Carbon\Carbon::parse($ujian->due)->format('Y-m-d\TH:i')) }}"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-300 bg-gray-50 text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        required>
                </div>
            </div>

            {{-- Tombol Aksi --}}
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
                    Update Ujian
                </button>

              
            </div>
        </form>
    </div>
</div>
@endsection
