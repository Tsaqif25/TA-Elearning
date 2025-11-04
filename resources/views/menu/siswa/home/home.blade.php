@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full bg-[#FAFAFA] min-h-screen">
  <div class="flex flex-col px-6 lg:px-10 mt-6 pb-12">

    {{-- ALERT SUCCESS --}}
    @if (session()->has('success'))
      <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg flex justify-between items-center mb-6">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
    @endif

    {{-- HERO PROFIL --}}
    <div class="bg-white border border-[#EEEEEE] rounded-2xl shadow-sm p-6 flex flex-col sm:flex-row justify-between items-center mb-8">
      <div>
        <h1 class="text-2xl font-extrabold text-[#0A090B]">
          {{ $kelas?->name ?? 'Belum ada kelas terdaftar' }}
        </h1>
        <p class="text-sm text-[#7F8190]">
          @if ($kelas)
            Selamat datang di kelasmu! Semangat belajar 🎓
          @else
            Silakan hubungi admin untuk didaftarkan ke kelas.
          @endif
        </p>

        <!-- Toggle View Siswa -->
        @if ($kelas)
          <div x-data="{ open: false }" class="mt-4">
            <button 
              @click="open = !open"
              class="bg-[#F4F4F4] hover:bg-[#E5E7EB] text-[#0A090B] font-medium px-4 py-2 rounded-full transition flex items-center gap-2">
              <i class="fa-solid fa-users"></i>
              <span x-text="open ? 'Tutup Daftar Siswa' : 'View Siswa'"></span>
            </button>

            <div x-show="open" x-transition class="bg-white border border-[#EEEEEE] rounded-xl p-6 shadow-sm mt-3">
              <h2 class="text-lg font-bold text-[#0A090B] mb-3">Daftar Siswa di {{ $kelas->name }}</h2>
              @forelse ($kelas->users as $index => $siswa)
                <div class="flex justify-between items-center border-b border-gray-200 py-2">
                  <div class="flex items-center gap-3">
                    <span class="font-semibold text-gray-700">{{ $index + 1 }}.</span>
                    <span class="font-medium text-[#0A090B]">{{ $siswa->name }}</span>
                  </div>
                  <span class="text-sm text-gray-500">{{ $siswa->email }}</span>
                </div>
              @empty
                <p class="text-gray-500 italic text-center py-4">Belum ada siswa di kelas ini.</p>
              @endforelse
            </div>
          </div>
        @endif
      </div>
      <img src="https://cdn-icons-png.flaticon.com/512/4931/4931645.png" class="w-[140px]" alt="Student Illustration">
    </div>

    {{-- 📚 KELAS & MAPEL --}}
    <div class="bg-white border border-[#EEEEEE] rounded-2xl shadow-sm p-6">
      <h2 class="text-lg font-bold text-[#0A090B] mb-5">Kelas & Mata Pelajaran</h2>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @if ($kelas && count($mapelKelas))
          @foreach ($mapelKelas as $mapelKelasItem)
            <a href="{{ route('viewKelasMapel', ['mapel' => $mapelKelasItem['mapel_id'], 'kelas' => $kelas->id]) }}"
              class="p-5 border border-[#E0E7FF] rounded-2xl hover:-translate-y-1 transition bg-[#EEF2FF] shadow-sm">
              <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-[#4338CA] text-white flex items-center justify-center rounded-xl font-bold">
                  {{ strtoupper(substr($mapelKelasItem['mapel_name'], 0, 2)) }}
                </div>
                <div>
                  <h3 class="font-semibold text-[#0A090B]">{{ $mapelKelasItem['mapel_name'] }}</h3>
                  <p class="text-sm text-[#7F8190]">Pengajar: {{ $mapelKelasItem['pengajar_name'] ?? '-' }}</p>
                </div>
              </div>
              <button class="mt-3 w-full bg-[#2B82FE] text-white py-2 rounded-full font-semibold text-sm hover:bg-[#1E68CC] transition">
                Lihat Detail
              </button>
            </a>
          @endforeach
        @else
          <div class="col-span-3 text-center text-gray-500 p-6">
            Belum ada mata pelajaran untuk kelas ini.
          </div>
        @endif
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
