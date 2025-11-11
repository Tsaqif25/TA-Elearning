<nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50 backdrop-blur">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">

      <!-- Logo -->
      <div class="flex items-center space-x-3">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
          <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-tr from-blue-500 to-blue-400 rounded-lg text-white">
            📘
          </div>
          <div>
            <h1 class="text-lg font-bold">E-Learning</h1>
            <p class="text-xs text-gray-500">SMK 2 Padang</p>
          </div>
        </a>
      </div>

      <!-- Menu Desktop -->
      <div class="hidden md:flex items-center space-x-2">
        {{-- BERANDA --}}
        <a href="{{ route('dashboard') }}"
          class="px-4 py-2 text-sm font-medium rounded-lg transition
          {{ request()->routeIs('dashboard') 
              ? 'bg-gradient-to-tr from-blue-500 to-blue-400 text-white shadow-md' 
              : 'text-gray-600 hover:text-blue-600 hover:bg-slate-100' }}">
          Beranda
        </a>

        {{-- PENGUMUMAN --}}
        <a href="{{ route('pengumuman.index') }}"
          class="px-4 py-2 text-sm font-medium rounded-lg transition
          {{ request()->routeIs('pengumuman.*') 
              ? 'bg-gradient-to-tr from-blue-500 to-blue-400 text-white shadow-md' 
              : 'text-gray-600 hover:text-blue-600 hover:bg-slate-100' }}">
          Pengumuman
        </a>

        {{-- REPOSITORY (hanya pengajar) --}}
        @if (Auth::user()->hasRole('Pengajar'))
          <a href="{{ route('repository.index') }}"
            class="px-4 py-2 text-sm font-medium rounded-lg transition
            {{ request()->routeIs('repository.*') 
                ? 'bg-gradient-to-tr from-blue-500 to-blue-400 text-white shadow-md' 
                : 'text-gray-600 hover:text-blue-600 hover:bg-slate-100' }}">
            Repository
          </a>
        @endif

        {{-- ANALYTIC (hanya wakur) --}}
        @if (Auth::user()->hasRole('Wakur'))
          <a href="{{ route('wakur.analytics') }}"
            class="px-4 py-2 text-sm font-medium rounded-lg transition
            {{ request()->routeIs('wakur.analytics') 
                ? 'bg-gradient-to-tr from-blue-500 to-blue-400 text-white shadow-md' 
                : 'text-gray-600 hover:text-blue-600 hover:bg-slate-100' }}">
            Analytic
          </a>
        @endif
      </div>

      <!-- Right Section -->
      <div class="flex items-center space-x-3">

        <!-- Notifikasi -->
        <div class="relative cursor-pointer">
          <div class="w-9 h-9 rounded-full flex items-center justify-center bg-slate-100 hover:bg-slate-200 transition">
            🔔
          </div>
          <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full"></span>
        </div>

        <!-- Profil & Dropdown -->
        <div class="relative group">
          <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-green-600 to-green-400 flex items-center justify-center text-white font-bold uppercase cursor-pointer">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
          </div>
          <div
            class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-all duration-200 z-50">
            <div class="px-4 py-2 border-b text-sm text-gray-700 font-medium">
              {{ Auth::user()->name }}
            </div>
            <form action="{{ route('logout') }}" method="POST" class="block w-full">
              @csrf
              <button type="submit"
                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-[#F9FAFB] transition">
                Logout
              </button>
            </form>
          </div>
        </div>

        <!-- Hamburger Menu -->
        <button id="menuBtn" class="md:hidden p-2 rounded-lg hover:bg-slate-100 focus:outline-none">
          ☰
        </button>
      </div>
    </div>
  </div>

  <!-- Menu Mobile -->
  <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-200">
    <div class="flex flex-col p-3 space-y-2 text-sm">
      <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg text-left {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'hover:bg-slate-100' }}">Beranda</a>
      <a href="{{ route('pengumuman.index') }}" class="px-4 py-2 rounded-lg text-left {{ request()->routeIs('pengumuman.*') ? 'bg-blue-50 text-blue-600' : 'hover:bg-slate-100' }}">Pengumuman</a>
      @if (Auth::user()->hasRole('Pengajar'))
        <a href="{{ route('repository.index') }}" class="px-4 py-2 rounded-lg text-left {{ request()->routeIs('repository.*') ? 'bg-blue-50 text-blue-600' : 'hover:bg-slate-100' }}">Repository</a>
      @endif
      @if (Auth::user()->hasRole('Wakur'))
        <a href="{{ route('wakur.analytics') }}" class="px-4 py-2 rounded-lg text-left {{ request()->routeIs('wakur.analytics') ? 'bg-blue-50 text-blue-600' : 'hover:bg-slate-100' }}">Analytic</a>
      @endif
    </div>
  </div>
</nav>

<script>
  const btn = document.getElementById('menuBtn');
  const menu = document.getElementById('mobileMenu');
  btn.addEventListener('click', () => menu.classList.toggle('hidden'));
</script>
