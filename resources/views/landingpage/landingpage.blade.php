<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
  <title>E-Learning SMK 2 Padang</title>
</head>

<body class="bg-[#F9FAFB] text-[#0A090B]">

  <!--  NAVBAR -->
  <nav class="flex items-center justify-between px-6 lg:px-16 py-5 bg-white shadow-sm">
    <div class="flex items-center gap-2">
      <!-- Logo -->
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#2B82FE" class="w-7 h-7">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422A12.083 12.083 0 0118 10.5V17a2 2 0 01-2 2H8a2 2 0 01-2-2v-6.5a12.083 12.083 0 01-.16.078L12 14z" />
      </svg>
      <h1 class="font-extrabold text-lg sm:text-xl">E-Learning SMK 2 Padang</h1>
    </div>

    <div class="flex items-center gap-5">
      <a href="{{ route('repository.public') }}" class="font-medium text-[#0A090B] hover:text-[#2B82FE] transition">Repository</a>
      <a href="{{ route('login') }}" class="bg-gradient-to-tr from-blue-500 to-green-500 text-white font-semibold px-5 py-2 rounded-lg ">Login</a>
    </div>
  </nav>

  <!-- 🚀 HERO SECTION -->
  <section class="text-center py-20 px-6 lg:px-16 bg-[#F9FAFB]">
    <div class="max-w-3xl mx-auto">
      <span class="inline-block bg-[#E0ECFF] text-[#2B82FE] font-medium text-sm px-4 py-1 rounded-full mb-5">
        Platform Pembelajaran Digital Terpadu
      </span>
      <h2 class="text-4xl sm:text-5xl font-extrabold text-[#0A090B] leading-tight mb-4">
        Belajar <span class="text-[#2B82FE]">Tanpa Batas</span>
      </h2>
      <p class="text-[#7F8190] mb-10">
        Platform digital untuk siswa dan guru SMK 2 Padang. Akses materi lengkap kapan saja, di mana saja.
      </p>
      <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
        <a href="{{ route('login') }}" class="bg-gradient-to-tr from-blue-500 to-green-500 text-white px-8 py-3 rounded-lg font-semibold shadow  flex items-center gap-2 transition">
          Mulai Belajar Sekarang
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="white" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7-7l7 7-7 7" />
          </svg>
        </a>
        <a href="{{ route('repository.public') }}" class="bg-white px-8 py-3 rounded-lg font-semibold border border-gray-200 hover:border-[#2B82FE] transition flex items-center gap-2">
          Jelajahi Repository
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#2B82FE" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7-7l7 7-7 7" />
          </svg>
        </a>
      </div>
    </div>
  </section>

  <!--  FITUR UNGGULAN -->
  <section class="py-20 bg-white text-center px-6 lg:px-16">
    <h2 class="text-3xl font-extrabold mb-3">Fitur Unggulan</h2>
    <p class="text-[#7F8190] mb-12">
      Platform lengkap yang dirancang khusus untuk meningkatkan kualitas pembelajaran SMK 2 Padang
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
      <!-- Materi Lengkap -->
      <div class="bg-[#EAF2FF] rounded-2xl p-6 text-left shadow-sm hover:shadow-md transition">
        <div class="bg-[#2B82FE] text-white w-12 h-12 flex items-center justify-center rounded-xl mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="white" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m8-12v12M4 6v12m0-12l8 6 8-6" />
          </svg>
        </div>
        <h3 class="font-semibold text-lg mb-2">Materi Lengkap</h3>
        <p class="text-[#7F8190] text-sm">Akses ribuan materi pembelajaran dari berbagai mata pelajaran dengan format beragam.</p>
      </div>

      <!-- Tugas & Penilaian -->
      <div class="bg-[#E9FAEF] rounded-2xl p-6 text-left shadow-sm hover:shadow-md transition">
        <div class="bg-[#22C55E] text-white w-12 h-12 flex items-center justify-center rounded-xl mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="white" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8m2 8H6a2 2 0 01-2-2V6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2z" />
          </svg>
        </div>
        <h3 class="font-semibold text-lg mb-2">Tugas & Penilaian</h3>
        <p class="text-[#7F8190] text-sm">Sistem manajemen tugas dan penilaian terintegrasi yang efisien.</p>
      </div>

      <!-- Repository Materi -->
      <div class="bg-[#FFF5E7] rounded-2xl p-6 text-left shadow-sm hover:shadow-md transition">
        <div class="bg-[#FB923C] text-white w-12 h-12 flex items-center justify-center rounded-xl mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="white" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M5 8h14M5 16h14" />
          </svg>
        </div>
        <h3 class="font-semibold text-lg mb-2">Repository Materi</h3>
        <p class="text-[#7F8190] text-sm">Kumpulan lengkap materi SMK kelas 10–12, dapat diakses kapan saja.</p>
      </div>

      <!-- Quiz Interaktif -->
      <div class="bg-[#F6EEFF] rounded-2xl p-6 text-left shadow-sm hover:shadow-md transition">
        <div class="bg-[#A855F7] text-white w-12 h-12 flex items-center justify-center rounded-xl mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="white" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M12 4h9M3 4h9v16H3V4z" />
          </svg>
        </div>
        <h3 class="font-semibold text-lg mb-2">Quiz Interaktif</h3>
        <p class="text-[#7F8190] text-sm">Uji pemahaman dengan quiz interaktif dan dapatkan feedback langsung.</p>
      </div>
    </div>
  </section>

  <!--  STATISTIK PLATFORM -->
  <section class="py-20 bg-[#F9FAFB] text-center px-6 lg:px-16">
    <h2 class="text-3xl font-extrabold mb-3">Statistik Platform</h2>
    <p class="text-[#7F8190] mb-12">Dipercaya oleh ribuan siswa dan guru di SMK 2 Padang</p>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 max-w-5xl mx-auto">
      <div class="bg-[#EAF2FF] rounded-2xl py-8">
        <h3 class="text-3xl font-extrabold text-[#2B82FE]">500+</h3>
        <p class="text-[#7F8190] text-sm mt-2">Materi Pembelajaran</p>
      </div>
      <div class="bg-[#E9FAEF] rounded-2xl py-8">
        <h3 class="text-3xl font-extrabold text-[#22C55E]">1000+</h3>
        <p class="text-[#7F8190] text-sm mt-2">Siswa Aktif</p>
      </div>
      <div class="bg-[#FFF5E7] rounded-2xl py-8">
        <h3 class="text-3xl font-extrabold text-[#FB923C]">50+</h3>
        <p class="text-[#7F8190] text-sm mt-2">Guru Berpengalaman</p>
      </div>
      <div class="bg-[#F6EEFF] rounded-2xl py-8">
        <h3 class="text-3xl font-extrabold text-[#A855F7]">95%</h3>
        <p class="text-[#7F8190] text-sm mt-2">Tingkat Kepuasan</p>
      </div>
    </div>
  </section>

  <!--  CTA SECTION -->
  <section class="bg-[#0A0A0A] text-white py-20 text-center px-6 lg:px-16">
    <h2 class="text-3xl font-extrabold mb-4">Siap Memulai Perjalanan Belajar Anda?</h2>
    <p class="text-white/70 mb-10">Bergabunglah dengan ribuan siswa lain yang telah merasakan pengalaman belajar yang lebih baik</p>
    <div class="flex flex-col sm:flex-row justify-center gap-4">
      {{-- <a href="{{ route('register') }}" class="bg-[#2B82FE] px-8 py-3 rounded-lg font-semibold hover:bg-[#1E66E1] transition">Daftar Sekarang</a> --}}
      <a href="{{ route('repository.public') }}" class="border border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-[#0A090B] transition">Lihat Repository</a>
    </div>
  </section>

  <!--  FOOTER -->
<footer class="bg-[#0A0A0A] text-center text-white/80 py-6 text-sm border-t border-white/10">
  <p class="flex items-center justify-center gap-2 mb-2">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#2B82FE" class="w-5 h-5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422A12.083 12.083 0 0118 10.5V17a2 2 0 01-2 2H8a2 2 0 01-2-2v-6.5a12.083 12.083 0 01-.16.078L12 14z" />
    </svg>
    <span>E-Learning SMK 2 Padang</span>
  </p>

  <p class="mb-1">Dosen Pembimbing: <span class="font-semibold text-white">Dr. Titi Sriwahyuni, S.Pd., M.Eng</span></p>
  <p class="mb-1">Pengembang: <span class="font-semibold text-white">Tsaqif Luthfan</span></p>
  <p class="mb-3">Universitas Negeri Padang</p>

  <p>© 2025 SMK 2 Padang. All rights reserved.</p>
</footer>


</body>
</html>
