<div id="sidebar"
  class="sidebar w-[270px] flex flex-col shrink-0 min-h-screen justify-between p-[30px] border-r border-[#EEEEEE] bg-[#FBFBFB]">
  <div class="w-full flex flex-col gap-[30px]">
    <div class="flex items-center justify-between">
      <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
  <!--  Logo Buku -->
  <div class="w-9 h-9 bg-[#2B82FE] rounded-lg flex items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M12 6l-8 4 8 4 8-4-8-4zM4 14l8 4 8-4M4 10l8 4 8-4" />
    </svg>
  </div>

  <!--  Teks Sekolah -->
  <span class="text-[15px] font-extrabold text-[#0A090B]">SMK N 2 PADANG</span>
</a>

      <button class="lg:hidden text-gray-500 hover:text-gray-700" onclick="toggleSidebar()">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <ul class="flex flex-col gap-3">
      <li>
        <h3 class="font-bold text-xs text-[#A5ABB2] uppercase tracking-wide">Menu</h3>
      </li>

      {{-- OVERVIEW --}}
      <li>
        <a href="{{ route('dashboard') }}"
          class="p-[10px_16px] flex items-center gap-[14px] rounded-full h-11 transition-all duration-300
          {{ request()->routeIs('dashboard') ? 'bg-[#2B82FE] text-white' : 'hover:bg-[#2B82FE] group' }}">
          <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-[#7F8190] group-hover:text-white' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3" />
          </svg>
          <p
            class="font-semibold {{ request()->routeIs('dashboard') ? 'text-white' : 'text-[#0A090B] group-hover:text-white' }}">
            Overview</p>
        </a>
      </li>

      {{-- ANALYTIC (Wakur only) --}}
      @if (Auth::user()->hasRole('Wakur'))
        <li>
          <a href="{{ route('wakur.analytics') }}"
            class="p-[10px_16px] flex items-center gap-[14px] rounded-full h-11 transition-all duration-300
            {{ request()->routeIs('wakur.analytics') ? 'bg-[#2B82FE] text-white' : 'hover:bg-[#2B82FE] group' }}">
            <svg xmlns="http://www.w3.org/2000/svg"
              class="w-5 h-5 {{ request()->routeIs('wakur.analytics') ? 'text-white' : 'text-[#7F8190] group-hover:text-white' }}"
              fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14" />
            </svg>
            <p
              class="font-semibold {{ request()->routeIs('wakur.analytics') ? 'text-white' : 'text-[#0A090B] group-hover:text-white' }}">
              Analytic</p>
          </a>
        </li>
      @endif

      {{-- PENGUMUMAN --}}
      <li>
        <a href="{{ route('pengumuman.index') }}"
          class="p-[10px_16px] flex items-center gap-[14px] rounded-full h-11 transition-all duration-300
          {{ request()->routeIs('pengumuman.*') ? 'bg-[#2B82FE] text-white' : 'hover:bg-[#2B82FE] group' }}">
          <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 {{ request()->routeIs('pengumuman.*') ? 'text-white' : 'text-[#7F8190] group-hover:text-white' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14" />
          </svg>
          <p
            class="font-semibold {{ request()->routeIs('pengumuman.*') ? 'text-white' : 'text-[#0A090B] group-hover:text-white' }}">
            Pengumuman</p>
        </a>
      </li>

      {{-- REPOSITORY --}}
      @if (Auth::user()->hasRole('Wakur|Pengajar'))
        <li>
          <a href="{{ route('repository.index') }}"
            class="p-[10px_16px] flex items-center gap-[14px] rounded-full h-11 transition-all duration-300
            {{ request()->routeIs('repository.*') ? 'bg-[#2B82FE] text-white' : 'hover:bg-[#2B82FE] group' }}">
            <svg xmlns="http://www.w3.org/2000/svg"
              class="w-5 h-5 {{ request()->routeIs('repository.*') ? 'text-white' : 'text-[#7F8190] group-hover:text-white' }}"
              fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14" />
            </svg>
            <p
              class="font-semibold {{ request()->routeIs('repository.*') ? 'text-white' : 'text-[#0A090B] group-hover:text-white' }}">
              Repository</p>
          </a>
        </li>
      @endif
    </ul>
  </div>
</div>
