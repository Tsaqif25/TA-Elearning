<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    @keyframes slide {
      from { transform: translateX(0); }
      to { transform: translateX(-100%); }
    }
    .animate-slide { animation: slide 15s linear infinite; }
    .pause-animate { animation-play-state: paused; }
  </style>
</head>

<body class="text-[#0A090B]">
  <section id="signup" class="flex flex-col lg:flex-row w-full min-h-screen">
    <!-- 🟣 Navbar -->
    <nav class="flex items-center justify-between px-4 sm:px-6 lg:px-[50px] py-3 lg:pt-[30px] w-full absolute top-0 z-10 bg-transparent -mt-4">
      <div class="flex items-center">
         <a href="/" class="flex items-center">
  <img src="{{ asset('images/logo/logosmk2npadang.png') }}" 
       alt="logo" 
       class="w-24 sm:w-28 lg:w-32 object-contain relative -mt-5">
</a>
      </div>

      <!-- Desktop Menu -->
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

      <!-- Mobile Menu Button -->
      <button id="menuBtn" class="lg:hidden bg-[#0A090B] text-white px-4 py-2 rounded-full focus:outline-none text-sm font-semibold">☰</button>
    </nav>

    <!-- 🔹 Left Side - Form Section -->
    <div class="left-side min-h-screen flex flex-col justify-center items-center w-full lg:w-1/2 py-6 sm:py-10 lg:pt-[100px] lg:pb-[30px] px-4 sm:px-6">
      <form method="POST" action="{{ route('authenticate') }}" class="flex flex-col gap-5 sm:gap-6 lg:gap-[25px] w-full max-w-[400px] sm:max-w-[450px] bg-white rounded-2xl mt-16 sm:mt-20 lg:mt-0 shadow-lg p-6 sm:p-8 mb-4 sm:mb-6">
        @csrf
        <h1 class="font-bold text-xl sm:text-2xl lg:text-3xl leading-tight text-center">Sign In</h1>

        <!-- Email -->
        <div class="flex flex-col gap-2">
          <p class="font-semibold text-sm sm:text-base">Email Address</p>
          <div class="flex items-center w-full h-[44px] sm:h-[48px] lg:h-[52px] px-3 sm:px-4 lg:px-[16px] py-2 sm:py-3 lg:py-[14px] rounded-full border border-[#EEEEEE] focus-within:border-2 focus-within:border-[#0A090B] transition-all">
            <div class="mr-2 sm:mr-3 lg:mr-[14px] w-5 h-5 sm:w-5 sm:h-5 lg:w-6 lg:h-6 flex items-center justify-center overflow-hidden flex-shrink-0">
              <img src="{{ asset('images/icons/sms.svg') }}" alt="email icon" class="w-full h-full object-contain">
            </div>
            <input type="email" name="email" class="font-semibold placeholder:text-[#7F8190] placeholder:font-normal w-full outline-none text-sm sm:text-base" placeholder="your@email.com" required>
          </div>
        </div>

        <!-- Password -->
        <div class="flex flex-col gap-2">
          <p class="font-semibold text-sm sm:text-base">Password</p>
          <div class="flex items-center w-full h-[44px] sm:h-[48px] lg:h-[52px] px-3 sm:px-4 lg:px-[16px] py-2 sm:py-3 lg:py-[14px] rounded-full border border-[#EEEEEE] focus-within:border-2 focus-within:border-[#0A090B] transition-all">
            <div class="mr-2 sm:mr-3 lg:mr-[14px] w-5 h-5 sm:w-5 sm:h-5 lg:w-6 lg:h-6 flex items-center justify-center overflow-hidden flex-shrink-0">
              <img src="{{ asset('images/icons/lock.svg') }}" alt="lock icon" class="w-full h-full object-contain">
            </div>
            <input type="password" name="password" class="font-semibold placeholder:text-[#7F8190] placeholder:font-normal w-full outline-none text-sm sm:text-base" placeholder="Enter password" required>
          </div>
        </div>

        <!-- Button -->
        <button type="submit" class="w-full h-[44px] sm:h-[48px] lg:h-[52px] bg-[#6436F1] rounded-full font-bold text-white transition-all duration-300 hover:shadow-[0_4px_15px_0_#6436F14D] text-sm sm:text-base active:scale-95">
          Sign In to my Account
        </button>

        <div class="text-center text-sm sm:text-base">
          <p class="text-[#7F8190]">Don't have an account? <a href="{{ route('register') }}" class="text-[#6436F1] font-semibold">Sign Up</a></p>
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