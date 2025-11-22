@extends('layout.template.mainTemplate')

@section('container')

<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-10 mb-16">

        {{-- 🔙 KEMBALI --}}
        <a href="{{ route('viewKelasMapel', [
            'mapel' => $tugas->kelasMapel->mapel->id,
            'kelas' => $tugas->kelasMapel->kelas->id,
            'tab'   => 'tugas'
        ]) }}"
            class="flex items-center gap-2 text-sm text-[#2B82FE] hover:text-[#1A5FD4] font-medium mb-6 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Daftar Tugas
        </a>

        {{-- 🟦 HEADER GRADIENT KONSISTEN --}}
        <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl shadow-lg p-6 sm:p-8 mb-8 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-tr from-blue-600/80 to-green-500/80 rounded-2xl"></div>

            <div class="relative z-10">

                <p class="text-xs uppercase opacity-90 font-semibold tracking-wide mb-1">DISKUSI & KOMENTAR</p>

                <h1 class="text-2xl sm:text-3xl font-extrabold">
                    Submission - {{ $siswa->name }}
                </h1>

                @if($pengumpulan)
                    <p class="text-sm mt-2 opacity-90">
                        Diupload pada:
                        {{ \Carbon\Carbon::parse($pengumpulan->submitted_at)->translatedFormat('d F Y, H:i') }}
                    </p>
                @endif

            </div>
        </div>

        {{-- 📎 FILE YANG DIUPLOAD --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-lg font-bold text-[#0A090B] mb-4">File yang Diupload</h2>

            @if ($pengumpulan && $pengumpulan->files->count())
                @foreach ($pengumpulan->files as $file)
                    <a href="{{ asset('storage/' . $file->file) }}" target="_blank"
                        class="flex items-center justify-between bg-[#F9FAFB] hover:bg-gray-50 transition
                               border border-gray-200 p-3 rounded-xl mb-2">

                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file text-blue-600 text-xl"></i>

                            <span class="text-sm font-medium text-[#0A090B] truncate">
                                {{ basename($file->file) }}
                            </span>
                        </div>

                        <span class="text-xs text-gray-500">
                            {{ number_format(Storage::size('public/'.$file->file) / 1024, 1) }} KB
                        </span>

                    </a>
                @endforeach
            @else
                <p class="text-gray-500 text-sm italic">Belum upload file.</p>
            @endif
        </div>

        {{-- 💬 DISKUSI & KOMENTAR --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">

            <h2 class="text-lg font-bold text-[#0A090B] mb-4">Diskusi & Komentar</h2>

            {{-- LIST KOMENTAR --}}
            <div class="space-y-4 max-h-[450px] overflow-y-auto pr-2 mb-6">

                @foreach ($komentar as $k)

                    @php
                        $isSiswa = $k->user_id == auth()->id();
                    @endphp

                    <div class="p-4 rounded-xl border shadow-sm
                        {{ $isSiswa ? 'bg-green-50 border-green-200' : 'bg-blue-50 border-blue-200' }}">

                        <div class="flex justify-between items-center mb-2">

                            <div class="flex items-center gap-2">
                                <p class="font-semibold text-sm">
                                    {{ $k->user->name }}
                                </p>

                                <span class="text-[10px] px-2 py-1 rounded-full font-semibold
                                    {{ $isSiswa ? 'bg-green-200 text-green-700' : 'bg-blue-200 text-blue-700' }}">
                                    {{ $isSiswa ? 'Siswa' : 'Guru' }}
                                </span>
                            </div>

                            <span class="text-xs text-gray-500">
                                {{ $k->created_at->translatedFormat('d/m/Y, H:i') }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-700 leading-relaxed">
                            {{ $k->pesan }}
                        </p>

                    </div>

                @endforeach
            </div>

            {{-- FORM INPUT --}}
            <form action="{{ route('siswa.tugas.diskusi.store', $tugas->id) }}" method="POST">
                @csrf

                <textarea name="pesan" rows="3"
                    class="w-full border border-gray-300 rounded-xl p-3 
                           text-sm focus:ring-[#2B82FE] focus:border-[#2B82FE]"
                    placeholder="Tulis komentar atau pertanyaan..."
                    required></textarea>

                <button type="submit"
                    class="mt-3 bg-gradient-to-tr from-blue-500 to-green-500 hover:opacity-90 
                           text-white px-5 py-2 rounded-full text-sm font-semibold shadow flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    Kirim
                </button>

                <p class="text-[10px] text-gray-400 mt-2">
                    Tips: Tekan <b>Ctrl + Enter</b> untuk mengirim cepat
                </p>
            </form>

        </div>

    </div>
</div>

@endsection
