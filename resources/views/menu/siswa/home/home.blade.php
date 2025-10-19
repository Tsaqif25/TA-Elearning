@extends('layout.template.mainTemplate')

@section('container')
<link rel="stylesheet" href="{{ url('/asset/css/card-img-full.css') }}">

<div class="px-6 py-8 space-y-6">

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
    <div>
        <nav class="text-sm text-gray-500">
            <ol class="flex items-center space-x-2">
                <li class="text-gray-700 font-medium">Profile</li>
            </ol>
        </nav>
    </div>

    {{-- ✅ Hero Section --}}
    <div class="bg-gray-50 rounded-2xl p-8 flex flex-col lg:flex-row-reverse items-center justify-between gap-10 shadow-sm">
        <div class="flex justify-center">
            <img src="{{ url('/asset/img/work.png') }}" alt="Ilustrasi" class="w-52 h-52 object-contain">
        </div>
        <div class="text-center lg:text-left space-y-4">
            <h1 class="text-3xl font-bold text-gray-900">{{ $kelas['name'] }}</h1>
            <p class="text-gray-600">Selamat datang! Selamat belajar 🎓</p>
            <button onclick="getData('{{ $kelas['name'] }}')" data-modal-target="modal-view"
                class="bg-white border border-blue-500 text-blue-600 hover:bg-blue-500 hover:text-white px-5 py-2.5 rounded-full transition duration-200 font-semibold flex items-center gap-2 justify-center">
                <i class="fa-solid fa-users"></i> View Siswa
            </button>
        </div>
    </div>

    {{-- ✅ Layout 2 Kolom --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- Kolom Profil --}}
        <div class="bg-white p-6 rounded-xl shadow-sm flex flex-col items-center">
            <div class="w-40 h-40 rounded-full overflow-hidden mb-3">
                @if (empty($user->gambar))
                    <img src="/asset/icons/profile-women.svg" class="w-full h-full object-cover" alt="Avatar default">
                @else
                    <img src="{{ asset('storage/file/img-upload/' . $user->gambar) }}" class="w-full h-full object-cover" alt="Foto profil">
                @endif
            </div>
            <h3 class="font-semibold text-gray-800">{{ $user->name ?? 'Pengguna' }}</h3>
            {{-- <p class="text-gray-500 text-sm">Guru / Pengajar</p> --}}
        </div>

        {{-- Kolom Mapel --}}
        <div class="md:col-span-3 bg-white p-6 rounded-xl shadow-sm">
            <div class="grid sm:grid-cols-2 gap-6">
                @foreach ($mapelKelas as $mapelKelasItem)
                    <div class="bg-gray-50 border border-gray-100 rounded-xl overflow-hidden hover:shadow-md transition">
                        <a href="{{ route('viewKelasMapel', ['mapel' => $mapelKelasItem['mapel_id'], 'kelas' => $kelas['id']]) }}">
                            <div class="h-40 bg-cover bg-center"
                                style="background-image: url('{{ !empty($mapelKelasItem['gambar']) ? asset('storage/file/img-upload/' . $mapelKelasItem['gambar']) : url('/asset/img/placeholder-3.jpg') }}')">
                            </div>
                        </a>
                        <div class="p-4 space-y-2">
                            <a href="{{ route('viewKelasMapel', ['mapel' => $mapelKelasItem['mapel_id'], 'kelas' => $kelas['id']]) }}"
                                class="text-lg font-semibold text-gray-900 hover:text-blue-600">
                                {{ $mapelKelasItem['mapel_name'] }}
                            </a>
                            <p class="text-sm text-gray-600">Pengajar: {{ $mapelKelasItem['pengajar_name'] ?? '-' }}</p>
                            <p class="text-sm text-gray-500">
                                {{ \Illuminate\Support\Str::limit($mapelKelasItem['deskripsi'], 120) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

{{-- ✅ Modal Tailwind --}}
<div id="modal-view" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white w-full max-w-lg rounded-xl shadow-lg overflow-hidden">
        <div class="flex justify-between items-center border-b px-6 py-3">
            <h5 class="text-lg font-semibold text-gray-800"><i class="fa-solid fa-book text-blue-500 mr-2"></i> Siswa di {{ $kelas['name'] }}</h5>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
            <img src="{{ url('/asset/img/panorama.png') }}" class="w-full rounded-lg" alt="Panorama">
            <div id="modalContent" class="text-center text-gray-600"></div>
        </div>
        <div class="border-t px-6 py-3 text-right">
            <button onclick="closeModal()" class="px-4 py-2 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium">Tutup</button>
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
