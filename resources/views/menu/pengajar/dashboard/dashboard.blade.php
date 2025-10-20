@extends('layout.template.mainTemplate')

@section('container')
    <section id="content" class="flex">
        <div id="menu-content" class="flex flex-col w-full pb-[30px]">
            <!-- 🔸 DASHBOARD SECTION -->
            <div class="p-8 space-y-8">
                <!-- Header -->
                <div>
                    <h1 class="text-2xl font-bold text-[#0A090B]">Dashboard</h1>
                    <p class="text-[#7F8190] mt-1">Selamat datang kembali! Berikut ringkasan aktivitas Anda.</p>
                </div>

                <!-- Statistik -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Kelas -->
                    <div class="flex items-center justify-between bg-white rounded-xl p-6 shadow-sm   border-2 border-black">
                        <div>
                            <p class="text-[#7F8190] text-sm font-medium">Total Siswa</p>
                            <h2 class="text-2xl font-bold mt-1">{{ $jumlahSiswa }}</h2>
                        </div>
                        <div class="bg-[#2B82FE] w-12 h-12 rounded-xl flex items-center justify-center">
                            <img src="{{ asset('images/icons/book-open.svg') }}" alt="kelas" class="w-6 h-6">
                        </div>
                    </div>

                    <!-- Materi -->
                    <div class="flex items-center justify-between  border-2 border-black rounded-xl p-6 shadow-sm">
                        <div>
                            <p class="text-[#7F8190] text-sm font-medium">Total Mapel</p>
                            <h2 class="text-2xl font-bold mt-1">{{ $jumlahMapel }}</h2>
                        </div>
                        <div class="bg-[#22C55E] w-12 h-12 rounded-xl flex items-center justify-center">
                            <img src="{{ asset('images/icons/document.svg') }}" alt="materi" class="w-6 h-6">
                        </div>
                    </div>

                    <!-- Tugas -->
                    <div class="flex items-center justify-between  border-2 border-black rounded-xl p-6 shadow-sm">
                        <div>
                            <p class="text-[#7F8190] text-sm font-medium">Total Kelas</p>
                            <h2 class="text-2xl font-bold mt-1">{{ $jumlahKelas }}</h2>
                        </div>
                        <div class="bg-[#F97316] w-12 h-12 rounded-xl flex items-center justify-center">
                            <img src=" {{ asset('images/icons/clipboard.svg') }}" alt="tugas" class="w-6 h-6">

                        </div>
                    </div>
                </div>

                <!-- Kelas yang Anda Ajar -->
                <div class="bg-white  border-2 border-black rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold mb-6">Kelas yang Anda Ajar</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                        @forelse ($kelasDanMapel as $item)
                            <a href="{{ route('viewKelasMapel', [
                                'mapel' => $item['mapel_id'],
                                'kelas' => $item['kelas_id'],
                            ]) }}"
                                class="block p-6  border-2 border-black rounded-xl hover:shadow-md hover:scale-[1.02] transition">

                                <div class="bg-[#2B82FE] w-12 h-12 rounded-xl flex items-center justify-center mb-4">
                                    <img src="{{ asset('images/icons/book-open.svg') }}" alt="kelas" class="w-6 h-6">
                                </div>

                                <h3 class="font-semibold text-[#0A090B] text-lg">
                                    {{ $item['kelas_nama'] ?? '-' }}
                                </h3>
                                <p class="text-[#7F8190]">
                                    {{ $item['mapel_nama'] ?? '-' }}
                                </p>
                                {{-- <p class="text-[#7F8190] text-sm mt-2">2024/2025</p> --}}
                            </a>

                        @empty
                            <div class="col-span-3 text-center text-gray-500 p-6">
                                Belum ada kelas yang Anda ampu.
                            </div>
                        @endforelse

                    </div>
                </div>



    </section>

    </body>

    </html>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
@endsection
