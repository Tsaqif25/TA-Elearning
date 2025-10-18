@extends('layout.template.mainTemplate')

@section('container')

    <section id="content" class="flex">

        <div id="menu-content" class="flex flex-col w-full pb-[30px]">
            <div class="header flex justify-between items-center bg-white p-8 rounded-2xl shadow-sm border border-gray-200">

                {{-- KIRI: Kelas dan Mapel --}}
                <div class="flex items-center gap-5">
                    <a href="{{ route('viewKelasMapel', [
                        'mapel' => $kelasMapel->mapel->id,
                        'kelas' => $kelasMapel->kelas->id,
                        'tab' => 'quiz',
                    ]) }}"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 border hover:bg-gray-100 hover:shadow transition">
                        <i class="fa-solid fa-arrow-left text-gray-700 text-lg"></i>
                    </a>

                    <div>
                        <h1 class="text-2xl font-extrabold text-[#0A090B] leading-tight">
                            {{ $kelasMapel->kelas->name }}
                        </h1>
                        <p class="text-sm text-[#7F8190] font-medium mt-1">
                            {{ $kelasMapel->mapel->name }}
                        </p>
                    </div>
                </div>

                {{-- KANAN: Thumbnail dan Info Ujian --}}
                <div class="flex items-center gap-6">
                    <div class="relative w-[120px] h-[120px]">
                        <img src="{{ asset('images/thumbnail/Web-Development.png') }}" class="w-full h-full object-contain"
                            alt="icon">
                        <span
                            class="absolute bottom-2 left-1/2 transform -translate-x-1/2 bg-[#FFF2E6] text-[#F6770B] text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                            Product Design
                        </span>
                    </div>

                    <div class="flex flex-col justify-center">
                        <h2 class="text-2xl font-extrabold text-[#0A090B]">{{ $ujian->name }}</h2>
                        <div class="flex flex-wrap gap-4 mt-2 text-sm text-[#333]">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-clock text-indigo-600"></i>
                                <span>Durasi: <b>{{ $ujian->time }} Menit</b></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-calendar-days text-pink-600"></i>
                                <span>Deadline: <b>{{ \Carbon\Carbon::parse($ujian->due)->format('d M Y H:i') }}</b></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div id="course-test" class="mx-[70px] w-[870px] mt-[30px]">
                <h2 class="font-bold text-2xl">Course Tests</h2>
                <div class="flex flex-col gap-[30px] mt-2">
                    <a href="{{ route('ujian.soal.create', $ujian->id) }}"
                        class="w-full h-[92px] flex items-center justify-center p-4 border-dashed border-2 border-[#0A090B] rounded-[20px]">
                        <div class="flex items-center gap-5">
                            <div>
                                <img src="  {{ asset('images/icons/note-add.svg') }}" alt="icon">


                            </div>

                            <p class="font-bold text-xl">New Question</p>
                        </div>
                    </a>


                    <div class="space-y-6 mt-6">
                        @forelse ($ujian->soalUjianMultiple as $index => $soal)
                            <div
                                class="relative group transition hover:shadow-xl hover:-translate-y-[2px] rounded-2xl border border-gray-200 bg-gradient-to-br from-white via-[#FBFBFB] to-[#F5F7FA] p-6 duration-300">

                                {{-- Nomor Soal --}}
                                <div
                                    class="absolute -top-4 -left-4 bg-[#2B82FE] text-white w-10 h-10 flex items-center justify-center font-bold rounded-full shadow-md">
                                    {{ $index + 1 }}
                                </div>

                                {{-- Header Soal --}}
                                <div class="flex justify-between items-start">
                                    <div class="flex flex-col gap-[6px] max-w-[70%]">
                                        <p class="text-[#7F8190] text-sm font-medium uppercase tracking-wide">Pertanyaan</p>
                                        <p class="font-bold text-lg text-gray-900 leading-relaxed">
                                            {{ $soal->soal }}
                                        </p>
                                    </div>

                                    {{-- Tombol Aksi --}}
                                    <div class="flex items-center gap-2 opacity-90 group-hover:opacity-100 transition">
                                        <a href=""
                                            class="px-4 py-2 rounded-full bg-[#2B82FE] text-white font-semibold text-sm shadow hover:bg-[#1E6EEB] transition">
                                            <i class="fa-solid fa-pen me-1"></i>Edit
                                        </a>

                                        <form action="" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-10 h-10 flex items-center justify-center rounded-full bg-[#FD445E] hover:bg-[#E03E55] transition">
                                                <i class="fa-solid fa-trash text-white"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                {{-- Jawaban ABCD --}}
                                <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @php
                                        $labels = ['A', 'B', 'C', 'D'];
                                    @endphp

                                    @foreach ($soal->answer as $i => $ans)
                                        <div
                                            class="flex items-center justify-between p-4 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 transition relative">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 flex items-center justify-center font-bold text-sm rounded-full border border-gray-300 bg-gray-100 text-gray-700">
                                                    {{ $labels[$i] ?? '?' }}
                                                </div>
                                                <p class="text-gray-800 font-medium">{{ $ans->jawaban }}</p>
                                            </div>

                                            @if ($ans->is_correct)
                                                <span
                                                    class="absolute -top-3 -right-3 bg-green-500 text-white text-xs font-semibold px-3 py-[3px] rounded-full shadow">
                                                    ✅ Benar
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div
                                class="text-center py-10 border border-dashed border-gray-300 rounded-2xl bg-gray-50 text-gray-500">
                                Belum ada soal tersedia.
                            </div>
                        @endforelse
                    </div>




                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('more-button');
            const dropdownMenu = document.querySelector('.dropdown-menu');

            menuButton.addEventListener('click', function() {
                dropdownMenu.classList.toggle('hidden');
            });


            document.addEventListener('click', function(event) {
                const isClickInside = menuButton.contains(event.target) || dropdownMenu.contains(event
                    .target);
                if (!isClickInside) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        });
    </script>



@endsection
