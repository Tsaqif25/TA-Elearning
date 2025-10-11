<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SMK 2 Padang — E‑Learning</title>
<!-- Font Awesome 6 (CDN) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
      :root{
        --brand-1:#5CD1B2; /* hijau */
        --brand-2:#60A5FA; /* biru */
        --text-1:#0A090B; /* hampir hitam */
      }
      body{ font-family: 'Poppins', sans-serif; color:var(--text-1); background-color:#f7f9fc; }
      .btn-grad{
        background-image: linear-gradient(90deg, var(--brand-2), var(--brand-1));
        color:#fff; border:0; transition: filter .2s ease;
      }
      .btn-grad:hover{ filter:brightness(0.95); color:#fff; }

      .hero-card{
        border:0; border-radius:1rem; box-shadow:0 10px 30px rgba(16,24,40,.08);
        min-height: 460px;
      }
      .hero-image{
        width:100%; height:auto; border-radius:18px; object-fit:cover; box-shadow:0 4px 20px rgba(0,0,0,.08);
      }

      .login-card{ border:0; border-radius:1rem; box-shadow:0 10px 30px rgba(16,24,40,.08); }
      .form-control:focus{ border-color:#86b7fe; box-shadow:0 0 0 .2rem rgba(13,110,253,.15); }
    </style>
  </head>
  <body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top py-2">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
          <img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f393.svg" alt="logo" width="28" height="28"/>
          <span class="fw-bold">SMK 2 Padang</span>
          <span class="text-muted ms-2 small">E‑Learning Platform</span>
        </a>
        <div class="ms-auto">
          <a class="btn btn-outline-primary" href="{{ route('register') }}">Daftar Sekarang</a>
        </div>
      </div>
    </nav>

    <!-- MAIN -->
    <main class="py-5">
      <div class="container">
        <div class="row g-4 align-items-stretch">
          <!-- LEFT: Hero -->
          <div class="col-12 col-lg-7">
            <div class="card hero-card h-100 p-3 d-flex align-items-center justify-content-center">
        <img src="{{ asset('asset/images/education-features (1).jpg') }}" alt="Education Features" class="hero-image">
            </div>
          </div>

          <!-- RIGHT: Login Card -->
<div class="col-12 col-lg-5">
    <div class="card login-card h-100">
        <div class="card-body p-4 p-lg-5">
            <h3 class="fw-bold mb-2">Masuk ke Akun</h3>
            <p class="text-muted mb-4">Masukkan email dan password untuk mengakses platform e-learning</p>

          
         <form action="{{ route('authenticate') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" 
                   class="form-control" 
                   id="email" 
                   name="email"
                   placeholder="Masukkan email Anda" 
                   required>
        </div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
            <input type="password" 
                   class="form-control" 
                   id="password" 
                   name="password"
                   placeholder="Masukkan password Anda" 
                   required>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="ingat">
            <label class="form-check-label" for="ingat">Ingat saya</label>
        </div>
        <a class="text-muted small" href="#">Lupa password?</a>
    </div>

    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-grad py-2">
            <i class="fa-solid fa-right-to-bracket"></i> Masuk ke Platform
        </button>
    </div>
    <div class="text-center text-muted small">
        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
    </div>
</form>

        </div>
    </div>
</div>

        </div>
      </div>
    </main>

    <footer class="py-4 small text-center text-muted">
      © <span id="year"></span> SMK 2 Padang — E‑Learning Platform
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      document.getElementById('year').textContent = new Date().getFullYear();
    </script>
  </body>
</html>
