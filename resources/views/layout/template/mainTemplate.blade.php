<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard | AnggaCBT')</title>

  {{-- Tailwind & Font --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

  <style>
    body { font-family: 'Poppins', sans-serif; }
    .sidebar { transition: transform 0.3s ease-in-out; }

    /* Mobile */
    @media (max-width: 1024px) {
      #sidebar { position: fixed; left: 0; top: 0; height: 100vh; width: 270px;
        z-index: 50; transform: translateX(-100%); }
      #sidebar.active { transform: translateX(0); }
    }

    /* Desktop */
    @media (min-width: 1025px) {
      #sidebar { transform: translateX(0) !important; }
    }
  </style>

  <style>
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
  <!-- Overlay -->
  <div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

  <section class="flex">
    @include('layout.navbar.sidebar')

    <div class="flex flex-col w-full pb-[30px]">
      @include('layout.navbar.topbar')

      <main class="p-6">
        @yield('container')
      </main>
    </div>
  </section>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      sidebar.classList.toggle('active');
      overlay.classList.toggle('hidden');
      document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
    }

    window.addEventListener('resize', () => {
      if (window.innerWidth > 1024) {
        document.getElementById('sidebar').classList.remove('active');
        document.getElementById('overlay').classList.add('hidden');
        document.body.style.overflow = '';
      }
    });
  </script>

<script>
  function showTab(tab) {
    const tabs = ['materi', 'tugas', 'quiz'];
    
    tabs.forEach(t => {
      const content = document.getElementById('content-' + t);
      const button = document.getElementById('tab-' + t);
      if (content && button) {
        content.classList.add('hidden');
        button.classList.remove('tab-active');
        button.classList.add('tab-inactive');
      }
    });

    const activeContent = document.getElementById('content-' + tab);
    const activeButton = document.getElementById('tab-' + tab);
    if (activeContent && activeButton) {
      activeContent.classList.remove('hidden');
      activeButton.classList.add('tab-active');
      activeButton.classList.remove('tab-inactive');
    }

    // ✅ Update URL tanpa reload (contoh: ?tab=tugas)
    const url = new URL(window.location.href);
    url.searchParams.set('tab', tab);
    window.history.replaceState({}, '', url);
  }

  // ✅ Saat reload halaman, buka tab sesuai URL
  document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const currentTab = params.get('tab') || 'materi';
    showTab(currentTab);
  });
</script>


</body>
</html>
