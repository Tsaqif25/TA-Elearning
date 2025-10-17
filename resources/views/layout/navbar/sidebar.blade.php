<aside id="sidebar"
  class="fixed lg:static inset-y-0 left-0 w-[270px] bg-[#FBFBFB] border-r-2 border-black  flex flex-col pt-[15px] pb-[30px] px-[25px] transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50">
      
      <div class="w-full flex flex-col gap-[30px]">
    
        <a href="{{ route('dashboard') }}" class="flex items-center justify-center">
          <img src="{{ asset('images/logo/logo.svg') }}" alt="logo">
        </a>
       
        {{-- 🔹 Menu Section 1: DAILY USE --}}
        <ul class="flex flex-col gap-3">
          <li>
            <h3 class="font-bold text-xs text-[#A5ABB2]">DAILY USE</h3>
          </li>

          @if (Auth::user()->hasRole('Pengajar'))
          <li>
            <a href="{{ route('dashboard') }}"
               class="p-[10px_16px] flex items-center gap-[14px] rounded-full h-11 transition-all duration-300
                      {{ Request::is('dashboard') ? 'bg-[#2B82FE]' : 'hover:bg-[#2B82FE]' }}">
              <div>
                <img src="{{ asset('asset/images/icons/home-hashtag.svg') }}" 
                     alt="Dashboard Icon" 
                     class="w-5 h-5 transition-all duration-300
                            {{ Request::is('dashboard') ? 'brightness-0 invert' : '' }}">
              </div>
              <p class="font-semibold transition-all duration-300 {{ Request::is('dashboard') ? 'text-white' : 'hover:text-white' }}">
                Dashboard
              </p>
            </a>
          </li>
          @endif

          {{-- Pengumuman --}}
          <li>
            <a href="{{ route('dashboard') }}"
               class="p-[10px_16px] flex items-center gap-[14px] rounded-full h-11 transition-all duration-300
               {{ Request::is('') ? 'bg-[#2B82FE]' : 'hover:bg-[#2B82FE]' }}">
              <div>
                <img src="{{ asset('asset/images/icons/home-hashtag.svg') }}" alt="icon" class="w-5 h-5">
              </div>
              <p class="font-semibold transition-all duration-300 {{ Request::is('') ? 'text-white' : 'hover:text-white' }}">
                Pengumuman
              </p>
            </a>
          </li>
        </ul>
        
        {{-- 🔹 Submenu dinamis untuk Pengajar --}}
        @if (Auth::user()->hasRole('Pengajar'))
          @foreach ($assignedKelas as $assignedKelasItem)
          <ul class="flex flex-col gap-3">
            <li>
              <h3 class="font-bold text-xs text-[#A5ABB2]">{{ $assignedKelasItem['mapel']->name }}</h3>
            </li>

            @foreach ($assignedKelasItem['kelas'] as $kelas)
            <li>
              <a href="{{ route('viewKelasMapel', [
                  'mapel' => $assignedKelasItem['mapel']->id,
                  'kelas' => $kelas->id,
              ]) }}"
                class="p-[10px_16px] flex items-center gap-[14px] rounded-full h-11 transition-all duration-300
                {{ Request::is('kelas-mapel/' . $assignedKelasItem['mapel']->id . '/' . $kelas->id)
                    ? 'bg-[#2B82FE]'
                    : 'hover:bg-[#2B82FE]' }}">
                
                <div>
                  <img src="{{ asset('asset/images/icons/home-hashtag.svg') }}"
                    alt="icon"
                    class="w-5 h-5">
                </div>

                <p class="font-semibold transition-all duration-300 
                {{ Request::is('kelas-mapel/' . $assignedKelasItem['mapel']->id . '/' . $kelas->id)
                    ? 'text-white'
                    : 'hover:text-white' }}">
                  {{ $kelas->name }}
                </p>
              </a>
            </li>
            @endforeach
          </ul>
          @endforeach
        @endif

        {{-- 🔹 Section OTHERS --}}
        <ul class="flex flex-col gap-3">
          <li>
            <h3 class="font-bold text-xs text-[#A5ABB2]">OTHERS</h3>
          </li>
          <li>
            <a href="#" class="p-[10px_16px] flex items-center gap-[14px] rounded-full h-11 transition-all duration-300 hover:bg-[#2B82FE]">
              <div>
                <img src="{{ asset('asset/images/icons/box.svg') }}" alt="icon" class="w-5 h-5">
              </div>
              <p class="font-semibold transition-all duration-300 hover:text-white">Rewards</p>
            </a>
          </li>
          <li>
            <a href="#" class="p-[10px_16px] flex items-center gap-[14px] rounded-full h-11 transition-all duration-300 hover:bg-[#2B82FE]">
              <div>
                <img src="{{ asset('asset/images/icons/code.svg') }}" alt="icon" class="w-5 h-5">
              </div>
              <p class="font-semibold transition-all duration-300 hover:text-white">A.I Plugins</p>
            </a>
          </li>
        </ul>
      </div>
    </aside>
