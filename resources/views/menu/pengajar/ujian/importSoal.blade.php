@extends('layout.template.mainTemplate')

@section('container')
<div class="max-w-[1200px] mx-auto px-5 mt-8">

    <!-- Back -->
    <a href="{{ route('ujian.soal.manage', $ujian->id) }}"
       class="text-blue-600 hover:text-blue-800 mb-6 inline-flex items-center gap-2">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>

    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4">Import Soal Ujian</h1>
        <p class="text-gray-500 mb-6">Upload file Excel (.xlsx) sesuai format.</p>

        <form action="{{ route('ujian.soal.import', $ujian->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="font-semibold">File Excel</label>
                <input type="file" name="file" class="w-full p-3 border rounded-xl" required>

                @error('file')
                <p class="text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full">
                Upload
            </button>

            <a href="{{ asset('format/soal_format.xlsx') }}"
               class="ml-3 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-full">
                Download Format
            </a>
        </form>
    </div>

</div>
@endsection
