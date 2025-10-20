@extends('layout.template.mainTemplate')

@section('container')
<link rel="stylesheet" href="{{ url('/asset/css/card-img-full.css') }}">

<div class="px-6 py-8 space-y-8">

    {{-- ✅ Alert Success --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    {{-- ✅ Breadcrumb --}}
    <nav class="text-sm text-gray-500">
        <ol class="flex items-center space-x-2">
            <li class="text-gray-700 font-medium">Profile</li>
        </ol>
    </nav>

    {{-- ✅ Hero Section --}}
    <div class="bg-gray-50 rounded-2xl p-8 flex flex-col lg:flex-row-reverse items-center justify-between gap-10 border-2 border-black shadow-sm">
        <div class="flex justify-center">
            <img src="{{ url('/asset/img/work.png') }}" alt="Ilustrasi" class="w-52 h-52 object-contain">
        </div>
        <div class="text-center lg:text-left space-y-4">
            <h1 class="text-3xl font-bold text-gray-900">{{ $kelas['name'] }}</h1>
            <p class="text-gray-600">Selamat datang! Selamat belajar 🎓</p>
<!-- Pastikan ini di layout utama kamu (jika belum) -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="{ open: false }" class="space-y-4">
  <!-- Tombol Toggle -->
  <button 
      @click="open = !open"
      class="bg-white border-2 border-black text-[#0A090B] hover:bg-[#0A090B] hover:text-white px-6 py-2.5 rounded-full font-semibold flex items-center gap-2 justify-center transition duration-200">
      <i class="fa-solid fa-users"></i>
      <span x-text="open ? 'Tutup Daftar Siswa' : 'View Siswa'"></span>
  </button>

  <!-- ✅ Dropdown daftar siswa -->
  <div 
      x-show="open" 
      x-transition 
      class="bg-white border-2 border-black rounded-xl p-6 shadow-sm mt-2"
  >
    <h2 class="text-lg font-bold text-[#0A090B] mb-4">
      Daftar Siswa di {{ $kelas->name }}
    </h2>

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



            
        </div>
    </div>

    {{-- ✅ Layout 2 Kolom --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- Kolom Profil --}}
        <div class="bg-white border-2 border-black p-6 rounded-xl flex flex-col items-center shadow-sm">
            <div class="w-40 h-40 rounded-full overflow-hidden mb-3 border-2 border-black">
                <img src="{{ url('/asset/img/teacher.png') }}" alt="Ilustrasi" class="w-full h-full object-covern">
          
            </div>
            <h3 class="font-semibold text-gray-800">{{ $user->name ?? 'Pengguna' }}</h3>
        </div>

        {{-- Kolom Mapel --}}
        <div class="md:col-span-3 bg-white border-2 border-black rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold mb-6">Kelas & Mata Pelajaran</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($mapelKelas as $mapelKelasItem)
                    <a href="{{ route('viewKelasMapel', [
                        'mapel' => $mapelKelasItem['mapel_id'],
                        'kelas' => $kelas['id']
                    ]) }}"
                        class="block p-6 border-2 border-black rounded-xl hover:shadow-md hover:scale-[1.02] transition transform">

                        <!-- Ikon di atas -->
                        <div class="bg-[#2B82FE] w-12 h-12 rounded-xl flex items-center justify-center mb-4">
                            <img src="{{ asset('images/icons/book-open.svg') }}" alt="kelas" class="w-6 h-6">
                        </div>

                        <!-- Nama Mapel -->
                        <h3 class="font-semibold text-[#0A090B] text-lg mb-1">
                            {{ $mapelKelasItem['mapel_name'] }}
                        </h3>

                        <!-- Nama Pengajar -->
                        <p class="text-sm text-[#7F8190] mb-2">
                            Pengajar: {{ $mapelKelasItem['pengajar_name'] ?? '-' }}
                        </p>

                        <!-- Deskripsi Singkat -->
                        <p class="text-sm text-[#7F8190] leading-relaxed">
                            {{ \Illuminate\Support\Str::limit($mapelKelasItem['deskripsi'], 120) }}
                        </p>
                    </a>
                @endforeach

                @if (count($mapelKelas) === 0)
                    <div class="col-span-3 text-center text-gray-500 p-6">
                        Belum ada mata pelajaran untuk kelas ini.
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>




<script>
    const loading = `
        <div class="flex justify-center py-8">
            <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8v4l3.5-3.5L12 0v4a8 8 0 010 16v4l-3.5-3.5L12 20v-4a8 8 0 01-8-8z">
                </path>
            </svg>
        </div>`;

    function getData(itemId) {
        document.getElementById('modal-view').classList.remove('hidden');
        $('#modalContent').html(loading);
        $.ajax({
            type: "GET",
            data: { kelasName: itemId },
            success: function(data) {
                $('#modalContent').html(data);
            },
            error: function() {
                $('#modalContent').html('<p class="text-red-500">Gagal mengambil data siswa.</p>');
            }
        });
    }

    function closeModal() {
        document.getElementById('modal-view').classList.add('hidden');
    }
</script>
@endsection
