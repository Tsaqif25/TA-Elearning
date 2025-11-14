@extends('layout.template.mainTemplate')

@section('container')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 fade-in bg-[#F9FAFB] font-poppins ">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-3">
        <h1 class="text-2xl font-extrabold text-gray-800">Daftar Siswa</h1>

        
    </div>




    <!-- Table Wrapper -->
    <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-gray-200">

        <table class="w-full text-left min-w-max">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="py-3 px-4">NIS</th>
                    <th class="py-3 px-4">Nama Siswa</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">No Telephone</th>
                
                </tr>
            </thead>

            <tbody class="text-gray-600 text-sm">
                @foreach ($siswa as $item)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3 px-4 font-medium">{{ $item->nis }}</td>
                    <td class="py-3 px-4 font-semibold text-gray-800">{{ $item->name }}</td>
                    <td class="py-3 px-4">{{ $item->email }}</td>
                     <td class="py-3 px-4">{{ $item->no_telp}}</td>
                  
                </tr>
                @endforeach
            </tbody> 
        </table>

    </div>

</div>

@endsection
