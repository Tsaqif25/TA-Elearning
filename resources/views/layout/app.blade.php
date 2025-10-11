<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'SMK 2 Padang')</title>
  @include('partials.head')
</head>
<body>
  <div class="d-flex">
    {{-- Sidebar --}}
    @include('layout.navbar.sidebar')
    
    {{-- Content --}}
    <div class="content w-100">
      {{-- Topbar --}}
      @include('layout.navbar.topbar')
      
      {{-- Main Content --}}
      <main class="p-3">
        @yield('content')
      </main>
    </div>
  </div> <!-- PERBAIKI: Tutup div dengan benar -->
  
  {{-- Bootstrap JS Bundle --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>