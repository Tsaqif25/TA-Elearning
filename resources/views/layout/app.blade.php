<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>

  <style>
    .tab-active {
      color: #2B82FE;
      font-weight: 600;
      border-bottom-width: 3px;
      border-image: linear-gradient(to right, #3B82F6, #22C55E) 1;
      border-image-slice: 1;
    }

    .tab-inactive {
      color: #7F8190;
      border-bottom: 3px solid transparent;
    }

    .tab-inactive:hover {
      color: #2B82FE;
    }
  </style>

  @include('partials.head')

  {{-- Jika WAKUR, konten bergeser ke kanan --}}
  @if(Auth::check() && Auth::user()->hasRole('Wakur'))
  <style>
      body {
        margin-left: 270px; /* ruang untuk sidebar */
      }
  </style>
  @endif

</head>


{{-- ============================= --}}
{{--     BODY UTAMA APLIKASI       --}}
{{-- ============================= --}}
<body class="text-[#0A090B] bg-[#FAFAFA] min-h-screen flex">

  {{-- ================================= --}}
  {{-- 1️⃣ SIDEBAR KHUSUS WAKUR SAJA     --}}
  {{-- ================================= --}}
  @if(Auth::user()->hasRole('Wakur'))
      @include('layout.navbar.sidebar')
  @endif


  {{-- ================================= --}}
  {{-- 2️⃣ AREA KONTEN & TOPBAR           --}}
  {{-- ================================= --}}
  <section class="flex flex-col flex-grow w-full">

      {{-- TOPBAR — semua role tetap pakai --}}
      @if (Auth::user()->hasRole('Wakur'))
    @include('layout.navbar.topbar-wakur')
@else
    @include('layout.navbar.topbar')
@endif


      {{-- MAIN CONTENT --}}
      <main class="flex-grow p-6">
          @yield('container')
      </main>

      {{-- FOOTER --}}
           @if (Auth::user()->hasRole('Pengajar|Siswa'))
      @include('layout.navbar.footer')
@endif
  </section>


  {{-- SCRIPT --}}
  @include('partials.scripts')

</body>
</html>
