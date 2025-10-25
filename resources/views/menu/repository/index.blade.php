@extends('layout.template.mainTemplate')

@section('container')
<div class="flex flex-col w-full p-6 lg:px-10 mt-6 bg-[#FAFAFA] min-h-screen font-poppins">

  <!-- Header -->
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-extrabold text-[#0A090B]">Kelola Repository</h1>
      <p class="text-sm text-[#7F8190]">Kelola materi pembelajaran untuk repository publik</p>
    </div>

    <a href="{{ route('repository.create') }}"
       class="flex items-center gap-2 bg-[#2B82FE] text-white px-5 py-2 rounded-full font-semibold text-sm shadow hover:bg-[#1a6ae0] transition">
      <i class="fa-solid fa-plus"></i> Upload Materi
    </a>
  </div>

  <!-- Daftar Repository -->
  <div class="flex flex-col gap-3">
    @forelse ($repositories as $repo)
      <div class="bg-white border border-gray-100 rounded-xl p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center shadow-sm hover:shadow-md transition hover:-translate-y-0.5 duration-200">

        <!-- Kiri -->
        <div class="flex items-start gap-4">
          <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-[#2B82FE] rounded-lg flex-shrink-0">
            <i class="fa-solid fa-folder-open text-lg"></i>
          </div>

          <div>
            <h3 class="font-semibold text-[#0A090B] text-[15px] mb-1 leading-snug">{{ $repo->judul }}</h3>
            <p class="text-sm text-[#7F8190] leading-relaxed mb-2">
              {{ Str::words(strip_tags($repo->deskripsi), 7, '...') ?? 'Belum ada deskripsi.' }}
            </p>
            <p class="text-sm text-[#7F8190]">
              <span class="inline-flex items-center gap-1">
                <i class="fa-solid fa-calendar-days text-xs"></i>
                {{ $repo->created_at->format('d/m/Y') }}
              </span>
              <span class="mx-2 text-gray-300">•</span>
              <span class="inline-flex items-center gap-1">
                <i class="fa-solid fa-book text-xs"></i>
                Kelas {{ $repo->kelas ?? '-' }} — {{ $repo->jurusan ?? '-' }}
              </span>
            </p>
          </div>
        </div>

        <!-- Kanan -->
        <div class="flex flex-wrap gap-2 mt-4 sm:mt-0">
          <a href="{{ route('repository.show', $repo->id) }}"
             class="flex items-center gap-1 bg-gray-100 text-gray-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-gray-200 transition">
            <i class="fa-solid fa-eye text-[12px]"></i> Lihat
          </a>

          <a href="{{ route('repository.edit', $repo->id) }}"
             class="flex items-center gap-1 bg-amber-100 text-amber-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-amber-200 transition">
            <i class="fa-solid fa-pen text-[12px]"></i> Edit
          </a>

          <form action="{{ route('repository.destroy', $repo->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus repository ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="flex items-center gap-1 bg-rose-100 text-rose-700 text-xs px-3 py-1.5 rounded-full font-semibold hover:bg-rose-200 transition">
              <i class="fa-solid fa-trash text-[12px]"></i> Hapus
            </button>
          </form>
        </div>
      </div>
    @empty
      <p class="text-center text-[#7F8190] py-10">Belum ada repository yang diupload.</p>
    @endforelse
  </div>
</div>
@endsection

