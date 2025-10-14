{{-- <!doctype html>
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
          <img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/{{asset('/svg/1f393.svg')}}" alt="logo" width="28" height="28"/>
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
  </body> --}}



<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Poppins', sans-serif; }
    @keyframes slide { from { transform: translateX(0); } to { transform: translateX(-100%); } }
    .animate-slide { animation: slide 15s linear infinite; }
    .pause-animate { animation-play-state: paused; }
  </style>
</head>
<body class="text-[#0A090B]">
  <section id="signup" class="flex flex-col lg:flex-row w-full min-h-screen">
    <!-- 🟣 Navbar -->
    <nav class="flex items-center justify-between px-4 sm:px-6 lg:px-[50px] py-3 lg:pt-[30px] w-full absolute top-0 z-10 bg-transparent">
      <div class="flex items-center">
        {{-- <a href="/">
          <img src="{{ asset('images/logo/logo.svg') }}" alt="logo" class="w-24 sm:w-28 lg:w-32">
        </a> --}}
         <a href="/" class="flex items-center">
 <img src="{{ asset('images/logo/logosmk2npadang.png') }}" 
       alt="logo" 
       class="w-24 sm:w-28 lg:w-32 object-contain relative -mt-5">
</a>

      </div>
      <div class="hidden lg:flex items-center justify-end w-full">
        <ul class="flex items-center gap-[30px]">
          <li><a href="#" class="font-semibold text-white">Docs</a></li>
          <li><a href="#" class="font-semibold text-white">About</a></li>
          <li><a href="#" class="font-semibold text-white">Help</a></li>
          <li class="h-[52px] flex items-center">
            <a href="{{ route('login') }}" class="font-semibold text-white p-[14px_30px] bg-[#0A090B] rounded-full text-center">Sign In</a>
          </li>
        </ul>
      </div>
      <button id="menuBtn" class="lg:hidden bg-[#0A090B] text-white px-4 py-2 rounded-full focus:outline-none text-sm font-semibold">☰</button>
    </nav>

    <!-- 🔹 Left Side - Register Form -->
    <div class="left-side min-h-screen flex flex-col justify-center items-center w-full lg:w-1/2 py-6 sm:py-10 lg:pt-[100px] px-4 sm:px-6">
      <form method="POST" action="{{ route('validate') }}" class="flex flex-col gap-5 sm:gap-6 lg:gap-[25px] w-full max-w-[400px] sm:max-w-[450px] bg-white rounded-2xl mt-16 sm:mt-20 lg:mt-0 shadow-lg p-6 sm:p-8">
        @csrf
        <h1 class="font-bold text-xl sm:text-2xl lg:text-3xl leading-tight text-center">Sign Up</h1>

        <!-- Email -->
        <div class="flex flex-col gap-2">
          <p class="font-semibold text-sm sm:text-base">Email Address</p>
          <div class="flex items-center w-full h-[44px] sm:h-[48px] lg:h-[52px] px-3 sm:px-4 lg:px-[16px] py-2 sm:py-3 lg:py-[14px] rounded-full border border-[#EEEEEE] focus-within:border-[#0A090B] transition-all">
            <img src="{{ asset('images/icons/sms.svg') }}" alt="icon" class="w-5 h-5 sm:w-6 sm:h-6 mr-3">
            <input type="email" name="email" placeholder="your@email.com" class="font-semibold placeholder:text-[#7F8190] w-full outline-none text-sm sm:text-base" required>
          </div>
        </div>

        <!-- Phone -->
        <div class="flex flex-col gap-2">
          <p class="font-semibold text-sm sm:text-base">Nomor Telephone</p>
          <div class="flex items-center w-full h-[44px] sm:h-[48px] lg:h-[52px] px-3 sm:px-4 lg:px-[16px] py-2 sm:py-3 lg:py-[14px] rounded-full border border-[#EEEEEE] focus-within:border-[#0A090B] transition-all">
            <img src="{{ asset('images/icons/profile.svg') }}" alt="icon" class="w-5 h-5 sm:w-6 sm:h-6 mr-3">
            <input type="text" name="noTelp" placeholder="08xxxxxxxxxx" class="font-semibold placeholder:text-[#7F8190] w-full outline-none text-sm sm:text-base" required>
          </div>
        </div>

        <!-- Password -->
        <div class="flex flex-col gap-2">
          <p class="font-semibold text-sm sm:text-base">Password</p>
          <div class="flex items-center w-full h-[44px] sm:h-[48px] lg:h-[52px] px-3 sm:px-4 lg:px-[16px] py-2 sm:py-3 lg:py-[14px] rounded-full border border-[#EEEEEE] focus-within:border-[#0A090B] transition-all">
            <img src="{{ asset('images/icons/lock.svg') }}" alt="icon" class="w-5 h-5 sm:w-6 sm:h-6 mr-3">
            <input type="password" name="password" placeholder="Enter password" class="font-semibold placeholder:text-[#7F8190] w-full outline-none text-sm sm:text-base" required>
          </div>
        </div>

        <!-- Confirm Password -->
        <div class="flex flex-col gap-2">
          <p class="font-semibold text-sm sm:text-base">Confirm Password</p>
          <div class="flex items-center w-full h-[44px] sm:h-[48px] lg:h-[52px] px-3 sm:px-4 lg:px-[16px] py-2 sm:py-3 lg:py-[14px] rounded-full border border-[#EEEEEE] focus-within:border-[#0A090B] transition-all">
            <img src="{{ asset('images/icons/lock.svg') }}" alt="icon" class="w-5 h-5 sm:w-6 sm:h-6 mr-3">
            <input type="password" name="confirm-password" placeholder="Confirm password" class="font-semibold placeholder:text-[#7F8190] w-full outline-none text-sm sm:text-base" required>
          </div>
        </div>

        <!-- NIS -->
        <div class="flex flex-col gap-2">
          <p class="font-semibold text-sm sm:text-base">Nomor Induk Siswa (NIS)</p>
          <div class="flex items-center w-full h-[44px] sm:h-[48px] lg:h-[52px] px-3 sm:px-4 lg:px-[16px] py-2 sm:py-3 lg:py-[14px] rounded-full border border-[#EEEEEE] focus-within:border-[#0A090B] transition-all">
            <img src="{{ asset('images/icons/sms.svg') }}" alt="icon" class="w-5 h-5 sm:w-6 sm:h-6 mr-3">
            <input type="text" name="nis" placeholder="Masukkan NIS Anda" class="font-semibold placeholder:text-[#7F8190] w-full outline-none text-sm sm:text-base" required>
          </div>
        </div>

        <!-- Button -->
        <button type="submit" class="w-full h-[44px] sm:h-[48px] lg:h-[52px] bg-[#6436F1] rounded-full font-bold text-white transition-all duration-300 hover:shadow-[0_4px_15px_0_#6436F14D] text-sm sm:text-base active:scale-95">Create My Account</button>

        <div class="text-center text-sm sm:text-base">
          <p class="text-[#7F8190]">Sudah punya akun? <a href="{{ route('login') }}" class="text-[#6436F1] font-semibold">Masuk di Sini</a></p>
        </div>
      </form>
    </div>

    <!-- 🟣 Right Side - Illustration Section -->
    <div class="right-side min-h-[300px] sm:min-h-[400px] lg:min-h-screen flex flex-col w-full lg:w-[650px] shrink-0 py-8 sm:py-12 lg:pt-[82px] bg-[#6436F1] items-center justify-center text-center px-4 sm:px-6">
      <div class="w-full max-w-[280px] sm:max-w-[320px] md:max-w-[400px] lg:max-w-[500px]">
        <img src="{{ asset('images/thumbnail/sign-in-illustration.png') }}" class="w-full h-auto object-contain" alt="banner">
      </div>
      <div class="logos w-full overflow-hidden mt-8 sm:mt-12 lg:mt-[100px]">
        <div class="group/slider flex flex-nowrap w-max items-center justify-center">
          <div class="logo-container animate-slide hover:pause-animate flex gap-6 sm:gap-8 lg:gap-10 pl-6 sm:pl-8 lg:pl-10 items-center flex-nowrap">
            <img src="{{ asset('images/logo/logo-51.svg') }}" class="w-12 sm:w-16 lg:w-20 opacity-80 hover:opacity-100 transition-opacity" alt="logo">
            <img src="{{ asset('images/logo/logo-51-1.svg') }}" class="w-12 sm:w-16 lg:w-20 opacity-80 hover:opacity-100 transition-opacity" alt="logo">
            <img src="{{ asset('images/logo/logo-52.svg') }}" class="w-12 sm:w-16 lg:w-20 opacity-80 hover:opacity-100 transition-opacity" alt="logo">
            <img src="{{ asset('images/logo/logo-52-1.svg') }}" class="w-12 sm:w-16 lg:w-20 opacity-80 hover:opacity-100 transition-opacity" alt="logo">
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>