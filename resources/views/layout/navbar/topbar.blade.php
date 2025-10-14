{{-- <div class="d-flex justify-content-between align-items-center topbar bg-white border-bottom px-3 py-2 shadow-sm">
  <div class="fw-semibold">
    {{-- Teks dinamis sesuai role --}}
    {{-- @if(Auth::user()->hasRole('Admin'))
      Selamat datang, <span class="text-primary">Admin</span>
    @elseif(Auth::user()->hasRole('Pengajar'))
      Selamat datang, <span class="text-success">Pengajar</span>
    @elseif(Auth::user()->hasRole('Siswa'))
      Selamat datang, <span class="text-info">Siswa</span>
    @else
      Selamat datang di Sistem E-Learning SMK 2 Padang
    @endif
  </div> --}}

  {{-- <div class="d-flex align-items-center gap-3"> --}}
    {{-- Profil User --}}
    {{-- <div class="d-flex align-items-center"> --}}
      {{-- <img src="{{ Auth::user()->gambar ? asset('storage/' . Auth::user()->gambar) : url('/asset/img/default-user.png') }}"  --}}
           {{-- alt="User" 
           class="rounded-circle me-2" 
           width="36" height="36"> --}}
      {{-- <span class="small fw-semibold">{{ Auth::user()->name }}</span>
    </div> --}}

    {{-- Tombol Logout --}}
    {{-- <form action="{{ route('logout') }}" method="POST" class="m-0">
      @csrf
      <button type="submit" class="btn btn-sm btn-outline-danger">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </button>
    </form>
  </div> --}}
{{-- </div> --}} 
{{-- layout/navbar/topbar.blade.php --}}
<div class="nav flex justify-between p-5 border-b border-[#EEEEEE]">
    <form class="search flex items-center w-[400px] h-[52px] p-[10px_16px] rounded-full border border-[#EEEEEE]">
        <input type="text" class="font-semibold placeholder:text-[#7F8190] placeholder:font-normal w-full outline-none" placeholder="Search by report, student, etc" name="search">
        <button type="submit" class="ml-[10px] w-8 h-8 flex items-center justify-center">
            <img src="{{ asset('asset/images/icons/search.svg') }}" alt="icon">
        </button>
    </form>
    <div class="flex items-center gap-[30px]">
        <div class="flex gap-[14px]">
            <a href="#" class="w-[46px] h-[46px] flex shrink-0 items-center justify-center rounded-full border border-[#EEEEEE]">
                <img src="{{ asset('asset/images/icons/receipt-text.svg') }}" alt="icon">
            </a>
            <a href="#" class="w-[46px] h-[46px] flex shrink-0 items-center justify-center rounded-full border border-[#EEEEEE]">
                <img src="{{ asset('asset/images/icons/notification.svg') }}" alt="icon">
            </a>
        </div>
        <div class="h-[46px] w-[1px] border border-[#EEEEEE]"></div>
        <div class="flex gap-3 items-center">
            <div class="flex flex-col text-right">
            
                <p class="text-sm">{{ Auth::user()->name }}</p>
            </div>
            {{-- <div class="w-[46px] h-[46px]">
                <img src="{{ asset('asset/images/photos/default-photo.svg') }}" alt="photo">
            </div> --}}
        </div>
         <form action="{{ route('logout') }}" method="POST" class="m-0">
      @csrf
      <button type="submit" class="btn btn-sm btn-outline-danger">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </button>
    </form>
    </div>
</div>
