@extends('layout.template.mainTemplate')

@section('container')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 fade-in bg-[#F9FAFB] font-poppins ">

    <!-- HEADER KELAS + MAPEL -->
    <h1 class="text-2xl font-extrabold text-gray-800 mb-1">
        {{ $kelasMapel->kelas->name }}-{{ $kelasMapel->mapel->name }}
    </h1>

    <p class="text-gray-500 text-sm mb-4">Daftar Siswa</p>

    <div class="flex items-center gap-2 mb-4">
        <span class="text-xl">👥</span>
        <span class="text-gray-700 font-semibold">{{ $siswa->count() }} Siswa</span>
    </div>

    <!-- Tombol Kembali (opsional) -->
    <a href="{{ route('dashboard') }}"
       class="inline-flex items-center mb-4 px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium bg-gradient-to-tr from-blue-500 to-green-500 text-white">
        <i class="fa-solid fa-arrow-left mr-2 text-xs"></i>
        Kembali ke Dashboard
    </a>

    <!-- TABLE -->
    <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-gray-200">

        <table class="w-full text-left min-w-max">
            <thead class="bg-blue-50 text-gray-700 text-sm">
                <tr>
                    <th class="py-3 px-4 font-semibold">No</th>
                    <th class="py-3 px-4 font-semibold">NIS</th>
                    <th class="py-3 px-4 font-semibold">Nama Siswa</th>
                    <th class="py-3 px-4 font-semibold">Email</th>
                    <th class="py-3 px-4 font-semibold">No Telepon</th>
                </tr>
            </thead>

            <tbody class="text-gray-700 text-sm">
                @foreach ($siswa as $index => $item)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3 px-4">{{ $index + 1 }}</td>
                    <td class="py-3 px-4 font-medium">{{ $item->nis }}</td>
                    <td class="py-3 px-4 font-semibold">{{ $item->name }}</td>
                    <td class="py-3 px-4">{{ $item->user->email }}</td>
                    <td class="py-3 px-4">{{ $item->no_telp ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div class="mt-4">
    {{ $siswa->links() }}
</div>

</div>

@endsection
