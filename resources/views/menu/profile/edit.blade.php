@extends('layout.template.mainTemplate')

@section('container')

<div class="min-h-screen bg-gray-100 pb-20">

    {{-- WRAPPER LEBAR CARD --}}
    <div class="max-w-2xl mx-auto">

        {{-- 🔵 HEADER BIRU (MENYATU DENGAN CARD) --}}
        <div class="w-full h-40 bg-gradient-to-tr from-blue-500 to-green-500 rounded-t-3xl relative flex justify-center">
            
            {{-- AVATAR FLOATING --}}
            <div class="absolute -bottom-14">
                <div class="relative">

                    {{-- AVATAR CIRCLE --}}
                    <div class="w-28 h-28 bg-green-500 rounded-full flex items-center justify-center text-white text-5xl font-extrabold shadow-xl ring-4 ring-white">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    {{-- CAMERA ICON --}}
                    <div class="absolute bottom-2 right-2 bg-blue-600 text-white p-2 rounded-full shadow cursor-pointer">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- 🟦 CARD PUTIH (MENEMPEL LANGSUNG TANPA JARAK) --}}
        <div class="bg-white p-8 rounded-b-3xl shadow-md pt-20">

            {{-- TITLE --}}
            <h2 class="text-2xl font-bold text-center mb-1">Edit Profil</h2>
            <p class="text-center text-gray-500 mb-8">Perbarui informasi profil Anda</p>

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- FORM --}}
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf

                {{-- Nama --}}
                <label class="block mb-4">
                    <span class="font-medium text-gray-700">Nama Lengkap</span>
                    <div class="mt-2 flex items-center gap-3 bg-gray-50 border rounded-xl px-4 py-3">
                        <i class="fa-solid fa-user text-gray-400"></i>
                        <input type="text" name="name" value="{{ $user->name }}"
                            class="bg-transparent w-full focus:outline-none">
                    </div>
                </label>

                {{-- Email --}}
                <label class="block mb-4">
                    <span class="font-medium text-gray-700">Email</span>
                    <div class="mt-2 flex items-center gap-3 bg-gray-50 border rounded-xl px-4 py-3">
                        <i class="fa-solid fa-envelope text-gray-400"></i>
                        <input type="email" name="email" value="{{ $user->email }}"
                            class="bg-transparent w-full focus:outline-none">
                    </div>
                </label>

                {{-- Password --}}
                <label class="block mb-6">
                    <span class="font-medium text-gray-700">Password Baru <span class="text-gray-400">(opsional)</span></span>
                    <div class="mt-2 flex items-center gap-3 bg-gray-50 border rounded-xl px-4 py-3">
                        <i class="fa-solid fa-lock text-gray-400"></i>
                        <input type="password" name="password"
                            class="bg-transparent w-full focus:outline-none"
                            placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>
                </label>

                <button class="w-full bg-gradient-to-tr from-blue-500 to-green-500 text-white py-3 rounded-xl font-semibold flex items-center justify-center gap-2 shadow">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Perubahan
                </button>

            </form>
        </div>

    </div>

</div>

@endsection
