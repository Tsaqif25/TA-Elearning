<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SMK 2 Padang — E-Learning</title>

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

      .hero-card{ border:0; border-radius:1rem; box-shadow:0 10px 30px rgba(16,24,40,.08); }
      .hero-image{ width:100%; max-height:400px; border-radius:18px; object-fit:cover; }
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
          <span class="text-muted ms-2 small">E-Learning Platform</span>
        </a>
        <div class="ms-auto">
          <a class="btn btn-outline-primary" href="/login">Masuk</a>
        </div>
      </div>
    </nav>

    <!-- MAIN -->
    <main class="py-5">
      <div class="container">
        <div class="row g-4 align-items-stretch">
          <!-- Kiri: Form Register -->
          <div class="col-12 col-lg-6">
            <div class="card login-card h-100">
              <div class="card-body p-4 p-lg-5">
                <h3 class="fw-bold mb-2">Daftar Akun Baru</h3>
                <p class="text-muted mb-4">Bergabunglah dengan platform e-learning SMK 2 Padang</p>

                <form action="{{ route('validate') }}" method="POST">
                  @csrf
                  <!-- Email -->
                  <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                      <input type="email" name="email" id="email" class="form-control" placeholder="nama@email.com" required>
                    </div>
                  </div>

                  <!-- Nomor Telepon -->
                  <div class="mb-3">
                    <label for="noTelp" class="form-label">Nomor Telepon <span class="text-secondary small">(Opsional)</span></label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                      <input type="number" name="noTelp" id="noTelp" class="form-control" placeholder="0851xxx">
                    </div>
                  </div>

                  <div class="row">
                    <!-- Password -->
                    <div class="col-md-6 mb-3">
                      <label for="password" class="form-label">Password *</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 karakter" required>
                      </div>
                    </div>
                    <!-- Konfirmasi Password -->
                    <div class="col-md-6 mb-3">
                      <label for="confirm-password" class="form-label">Konfirmasi Password *</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="confirm-password" id="confirm-password" class="form-control" placeholder="Ulangi password" required>
                      </div>
                    </div>
                  </div>

                  <!-- NIS -->
                  <div class="mb-3">
                    <label for="nis" class="form-label">Nomor Induk Siswa (NIS) *</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                      <input type="text" name="nis" id="nis" class="form-control" placeholder="Masukkan NIS anda..." required>
                    </div>
                  </div>

                  <!-- Checkbox -->
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="checkAgree" required>
                    <label class="form-check-label small" for="checkAgree">
                      Saya mengisi data saya dengan benar.
                    </label>
                  </div>

                  <!-- Tombol -->
                  <div class="d-grid">
                    <button type="submit" class="btn btn-grad py-2">
                      <i class="fa-regular fa-circle-check"></i> Daftar Sekarang
                    </button>
                  </div>
                </form>

                <div class="text-center mt-3 small text-muted">
                  Sudah punya akun? <a href="/login">Masuk di sini</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Kanan: Hero Image -->
          <div class="col-12 col-lg-6">
            <div class="hero-card h-100 d-flex align-items-center justify-content-center">
           <img src="{{ asset('asset/images/education-features (1).jpg') }}" alt="Education Features" class="hero-image">
            </div>
          </div>
        </div>
      </div>
    </main>

    <footer class="py-4 small text-center text-muted">
      © <span id="year"></span> SMK 2 Padang — E-Learning Platform
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      document.getElementById('year').textContent = new Date().getFullYear();
    </script>
  </body>
</html>
