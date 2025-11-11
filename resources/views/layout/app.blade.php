<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>
<style>
  /* Tab aktif dengan garis bawah gradient */
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

  {{-- ✅ Partial untuk head --}}
  @include('partials.head')

  {{-- ✅ CSS Global --}}

</head>

<body class="text-[#0A090B] bg-[#FAFAFA] min-h-screen flex flex-col">

  {{-- Overlay untuk sidebar mobile (kalau nanti dipakai) --}}
  <div id="overlay"
       class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"
       onclick="toggleSidebar()"></div>

  {{-- 🌐 Layout Utama --}}
  <section class="flex flex-col flex-grow">

    {{-- ✅ TOPBAR --}}
    @include('layout.navbar.topbar')

    {{-- ✅ KONTEN --}}
    <main class="flex-grow p-6">
      @yield('container')
    </main>

  </section>
 @include('layout.navbar.footer')
  {{-- ✅ FOOTER (Letakkan di bawah konten, sebelum </body>) --}}


  {{-- ✅ SCRIPT --}}
  @include('partials.scripts')

  

</body>
</html>
