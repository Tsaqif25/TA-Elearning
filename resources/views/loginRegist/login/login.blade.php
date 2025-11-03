<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>

<body class="bg-gray-50 text-[#0A090B]">
  <section class="flex flex-col lg:flex-row w-full min-h-screen">

    <!-- LEFT SIDE (LOGIN FORM) -->
    <div class="flex flex-col justify-center items-center w-full lg:w-1/2 px-6 lg:px-20 py-16 bg-white relative">
      <!-- Logo -->
      <div class="absolute top-8 left-8 flex items-center gap-2">
        <!-- Graduation Cap SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#2B82FE" class="w-7 h-7">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422A12.083 12.083 0 0118 10.5V17a2 2 0 01-2 2H8a2 2 0 01-2-2v-6.5a12.083 12.083 0 01-.16.078L12 14z" />
        </svg>
 <a href="{{ route('landing') }}">
  <h1 class="font-extrabold text-lg sm:text-xl">E-Learning SMK 2 Padang</h1>
</a>

      </div>
      <!-- Form -->
 @if (session('login-success'))
  <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm">
    {{ session('login-success') }}
  </div>
@endif

      <!-- Form -->
      <form method="POST" action="{{ route('authenticate') }}" class="w-full max-w-md mt-10">
        @csrf
        @if (session('login-error'))
  <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">
    {{ session('login-error') }}
  </div>
@endif

@if ($errors->any())
  <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">
    <ul class="list-disc list-inside">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
        <h2 class="text-3xl font-extrabold text-[#0A090B] mb-2 text-center">Sign In</h2>
        <p class="text-sm text-center text-[#7F8190] mb-8">Masuk untuk mengakses platform pembelajaran</p>

        <!-- Email -->
        <div class="mb-5">
          <label class="block text-sm font-semibold mb-2">Email Address</label>
          <div class="flex items-center border border-gray-300 rounded-full px-4 py-3 focus-within:border-[#2B82FE] transition-all">
            <!-- Mail SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#9CA3AF" class="w-5 h-5 mr-3">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8V6a2 2 0 00-2-2H5a2 2 0 00-2 2v2m18 0v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8m18 0l-9 6-9-6" />
            </svg>
            <input type="email" name="email" placeholder="your@email.com"
                   class="w-full outline-none text-sm text-gray-700 placeholder:text-gray-400 font-medium" required>
          </div>
        </div>

        <!-- Password -->
        <div class="mb-6">
          <label class="block text-sm font-semibold mb-2">Password</label>
          <div class="flex items-center border border-gray-300 rounded-full px-4 py-3 focus-within:border-[#2B82FE] transition-all">
            <!-- Lock SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#9CA3AF" class="w-5 h-5 mr-3">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 10V7a4 4 0 00-8 0v3m12 0H4a2 2 0 00-2 2v8a2 2 0 002 2h16a2 2 0 002-2v-8a2 2 0 00-2-2z" />
            </svg>
            <input type="password" name="password" placeholder="Enter password"
                   class="w-full outline-none text-sm text-gray-700 placeholder:text-gray-400 font-medium" required>
          </div>
        </div>

        <!-- Button -->
        <button type="submit"
                class="w-full py-3 bg-[#2B82FE] hover:bg-[#1E66E1] text-white font-semibold rounded-full shadow-md hover:shadow-lg transition-all duration-300 active:scale-[0.98]">
          Sign In to my Account
        </button>

        <p class="text-sm text-center mt-6 text-[#7F8190]">
          Don't have an account?
          <a href="{{ route('register') }}" class="text-[#2B82FE] font-semibold hover:underline">Sign Up</a>
        </p>
      </form>
    </div>

    <!-- RIGHT SIDE (INFORMATION PANEL) -->
    <div class="w-full lg:w-1/2 min-h-[400px] lg:min-h-screen bg-gradient-to-br from-[#2B82FE] to-[#60A5FA] text-white flex flex-col justify-center px-8 sm:px-16 lg:px-24 py-20 relative overflow-hidden">
      
      <!-- Background glow -->
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.15),_transparent)]"></div>

      <div class="relative z-10">
        <!-- Label -->
        <p class="text-sm font-medium bg-white/25 backdrop-blur-md w-max px-4 py-1 rounded-full shadow-sm mb-4">
          🌐 Platform Pembelajaran Digital
        </p>

        <!-- Title -->
        <h2 class="text-3xl sm:text-4xl font-extrabold leading-snug mb-4">
          Manage Courses & <br> Learn Better
        </h2>
        <p class="text-base text-white/90 mb-10 max-w-md">
          Provide high quality education to students with advanced learning management system.
        </p>

        <!-- Feature Cards -->
        <div class="flex flex-col gap-5">
          <!-- Materi Lengkap -->
          <div class="bg-white/20 backdrop-blur-md hover:bg-white/25 transition p-5 rounded-2xl flex items-center gap-4 shadow-sm">
            <div class="bg-white text-[#2B82FE] w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0">
              <!-- Book SVG -->
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#2B82FE" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m8-12v12M4 6v12m0-12l8 6 8-6" />
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-white text-base">Materi Lengkap</h3>
              <p class="text-sm text-white/90">Akses ribuan materi pembelajaran</p>
            </div>
          </div>

          <!-- Kolaborasi -->
          <div class="bg-white/20 backdrop-blur-md hover:bg-white/25 transition p-5 rounded-2xl flex items-center gap-4 shadow-sm">
            <div class="bg-white text-[#2B82FE] w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0">
              <!-- Users SVG -->
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#2B82FE" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V9h-5m-7 11h5v-9H5v9h5m2-13a4 4 0 110-8 4 4 0 010 8z" />
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-white text-base">Kolaborasi</h3>
              <p class="text-sm text-white/90">Belajar bersama guru dan siswa</p>
            </div>
          </div>

          <!-- Penilaian -->
          <div class="bg-white/20 backdrop-blur-md hover:bg-white/25 transition p-5 rounded-2xl flex items-center gap-4 shadow-sm">
            <div class="bg-white text-[#2B82FE] w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0">
              <!-- Chart SVG -->
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#2B82FE" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 19h16M9 15V9m6 6v-3m3 3v-5" />
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-white text-base">Penilaian</h3>
              <p class="text-sm text-white/90">Sistem penilaian terintegrasi</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
