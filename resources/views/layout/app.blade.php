<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>

  {{-- Head Partial cdn tailwind,font,dll --}}
  @include('partials.head')

  {{-- Style Inline (CSS Global) --}}
  <style>
    body { font-family: 'Poppins', sans-serif; }
    .sidebar { transition: transform 0.3s ease-in-out; }

    /* Mobile */
    @media (max-width: 1024px) {
      #sidebar {
        position: fixed; left: 0; top: 0; height: 100vh; width: 270px;
        z-index: 50; transform: translateX(-100%);
      }
      #sidebar.active { transform: translateX(0); }
    }

    /* Desktop */
    @media (min-width: 1025px) {
      #sidebar { transform: translateX(0) !important; }
    }

    /* Tab Style */
    .tab-active {
      color: #2B82FE;
      border-bottom: 2px solid #2B82FE;
    }
    .tab-inactive {
      color: #7F8190;
    }
  </style>
</head>

<body class="text-[#0A090B] bg-[#FAFAFA]">
  <!-- Overlay for mobile sidebar -->
  <div id="overlay"
       class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"
       onclick="toggleSidebar()"></div>

  <!-- Layout utama -->
  <section class="flex">
    {{-- Sidebar --}}
    @include('layout.navbar.sidebar')

    <div class="flex flex-col w-full pb-[30px]">
      {{-- Topbar --}}
      @include('layout.navbar.topbar')

      {{-- Konten dinamis --}}
      <main class="p-6">
        @yield('container')
      </main>
    </div>
  </section>

  {{-- Script Global --}}
  @include('partials.scripts')
</body>
</html>
