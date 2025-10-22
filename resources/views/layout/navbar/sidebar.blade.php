<div id="sidebar" class="sidebar w-[270px] flex flex-col shrink-0 min-h-screen justify-between p-[30px] border-r border-[#EEEEEE] bg-[#FBFBFB]">
  <div class="w-full flex flex-col gap-[30px]">
    <div class="flex items-center justify-between">
      <a href="{{ route('dashboard') }}" class="flex items-center justify-center">
        <img src="{{ asset('images/logo/logo.svg') }}" alt="logo" class="w-24"
          onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2296%22 height=%2240%22%3E%3Ctext x=%2210%22 y=%2225%22 font-size=%2216%22 fill=%22%232B82FE%22 font-weight=%22bold%22%3EAnggaCBT%3C/text%3E%3C/svg%3E'">
      </a>
      <button class="lg:hidden text-gray-500 hover:text-gray-700" onclick="toggleSidebar()">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <ul class="flex flex-col gap-3">
      <li><h3 class="font-bold text-xs text-[#A5ABB2] uppercase tracking-wide">Menu</h3></li>

      <li>
        <a href="{{ route('dashboard') }}" class="p-[10px_16px] flex items-center gap-[14px] rounded-full h-11 bg-[#2B82FE] transition-all duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/>
          </svg>
          <p class="font-semibold text-white">Overview</p>
        </a>
      </li>

      <li>
        <a href="#" class="p-[10px_16px] flex items-center gap-[14px] rounded-full h-11 hover:bg-[#2B82FE] group transition-all duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#7F8190] group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14"/>
          </svg>
          <p class="font-semibold text-[#0A090B] group-hover:text-white">Pengumuman</p>
        </a>
      </li>
    </ul>
  </div>

  <div class="border-t border-[#EEEEEE] pt-4">
    <a href="{{ route('logout') }}" class="flex items-center gap-2 text-[#F6770B] font-semibold hover:underline">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4"/>
      </svg>
      Logout
    </a>
  </div>
</div>
