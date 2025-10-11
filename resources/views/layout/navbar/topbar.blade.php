<div class="d-flex justify-content-between align-items-center topbar bg-white border-bottom px-3 py-2 shadow-sm">
  <div class="fw-semibold">
    {{-- Teks dinamis sesuai role --}}
    @if(Auth::user()->hasRole('Admin'))
      Selamat datang, <span class="text-primary">Admin</span>
    @elseif(Auth::user()->hasRole('Pengajar'))
      Selamat datang, <span class="text-success">Pengajar</span>
    @elseif(Auth::user()->hasRole('Siswa'))
      Selamat datang, <span class="text-info">Siswa</span>
    @else
      Selamat datang di Sistem E-Learning SMK 2 Padang
    @endif
  </div>

  <div class="d-flex align-items-center gap-3">
    {{-- Profil User --}}
    <div class="d-flex align-items-center">
      {{-- <img src="{{ Auth::user()->gambar ? asset('storage/' . Auth::user()->gambar) : url('/asset/img/default-user.png') }}"  --}}
           {{-- alt="User" 
           class="rounded-circle me-2" 
           width="36" height="36"> --}}
      <span class="small fw-semibold">{{ Auth::user()->name }}</span>
    </div>

    {{-- Tombol Logout --}}
    <form action="{{ route('logout') }}" method="POST" class="m-0">
      @csrf
      <button type="submit" class="btn btn-sm btn-outline-danger">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </button>
    </form>
  </div>
</div>
