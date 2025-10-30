<div class="flex justify-between items-center p-5 border-b border-[#EEEEEE] bg-white ">
  <!-- kalau mau fixed pada topbar tambahkan kode : sticky top-0 z-30 -->
  <div class="flex items-center gap-4">
    <!-- Tombol Hamburger (Mobile) -->
    <button class="lg:hidden text-[#2B82FE]" onclick="toggleSidebar()">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
      </svg>
    </button>

    <!-- Kolom Pencarian -->
    {{-- <form class="hidden md:flex items-center w-[300px] h-[45px] p-[10px_16px] rounded-full border border-[#EEEEEE] bg-white">
      <input type="text"
        class="font-semibold placeholder:text-[#7F8190] placeholder:font-normal w-full outline-none bg-transparent"
        placeholder="Cari materi, quiz, tugas...">
      <button type="submit" class="ml-[10px] w-8 h-8 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </button>
    </form> --}}
  </div>

  <!-- Bagian Kanan -->
  <div class="flex items-center gap-[20px]">
    <!-- Notifikasi -->
    <a href="#"
      class="hidden md:flex w-[46px] h-[46px] items-center justify-center rounded-full border border-[#EEEEEE] hover:bg-gray-50 transition relative">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
      <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
    </a>

    <!-- Profil & Logout -->
    <div class="flex gap-3 items-center">
      <div class="hidden sm:block text-right">

        <p class="font-semibold">{{ Auth::user()->name }}</p>
      </div>

      <!-- Avatar -->
      <div class="relative group">
        <div
          class="w-[46px] h-[46px] rounded-full bg-gradient-to-br from-[#2B82FE] to-[#1a5fd4] flex items-center justify-center text-white font-bold uppercase cursor-pointer select-none">
          {{ substr(Auth::user()->name, 0, 2) }}
        </div>

        <!-- Dropdown -->
        <div
          class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-all duration-200 z-50">
          <form action="{{ route('logout') }}" method="POST" class="block w-full">
            @csrf
            <button type="submit"
              class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-[#F9FAFB] transition">
              Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
