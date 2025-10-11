<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','SMK 2 Padang — E-Learning')</title>

      
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">



{{-- Bootstrap JS Bundle --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- jQuery (wajib sebelum script custom yang pakai $) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}

 <style>
    :root {
  --brand-1:#5CD1B2; 
  --brand-2:#60A5FA; 
  --text-1:#0A090B; 
}
body { font-family: 'Poppins', sans-serif; background-color: #f7f9fc; }
.sidebar { width: 250px; min-height: 100vh; background: #fff; border-right: 1px solid #e5e7eb; }
.sidebar .nav-link { color: var(--text-1); font-weight: 500; padding: 10px 15px; border-radius: .5rem; margin: 2px 0; }
.sidebar .nav-link.active, .sidebar .nav-link:hover { background: linear-gradient(90deg, var(--brand-2), var(--brand-1)); color: #fff; }
.content { flex: 1; padding: 20px; }
.btn-grad { background-image: linear-gradient(90deg, var(--brand-2), var(--brand-1)); color:#fff; border:0; }
.btn-grad:hover { filter: brightness(0.95); color:#fff; }
.topbar { background: #fff; border-bottom: 1px solid #e5e7eb; padding: 10px 20px; }

</style> 
 
  {{-- HEAD berisi CDN + CSS --}}
  @include('partials.head')
</head>
<body>
  <div class="d-flex">
    {{-- SIDEBAR (versi baru) --}}
    @include('layout.navbar.sidebar')

    <div class="content w-100">
      {{-- TOPBAR --}}
      @include('layout.navbar.topbar')

      {{-- AREA KONTEN HALAMAN --}}
      <main class="p-3">
        @yield('container')
      </main>
    </div>
  </div>

  {{-- Bootstrap JS Bundle --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
