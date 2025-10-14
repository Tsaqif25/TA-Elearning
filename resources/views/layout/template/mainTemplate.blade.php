{{-- layout/template/mainTemplate.blade.php --}}
<!doctype html>
<html lang="id">
<head>
    <title>@yield('title', 'SMK 2 Padang — E-Learning')</title>
    @include('partials.head')
</head>
<body class="font-poppins text-[#0A090B]">

    <section id="content" class="flex">
        {{-- Sidebar --}}
        @include('layout.navbar.sidebar')

        {{-- Konten utama --}}
        <div id="menu-content" class="flex flex-col w-full pb-[30px]">
            {{-- Topbar --}}
            @include('layout.navbar.topbar')

            {{-- Kontainer isi halaman --}}
            <main class="p-5">
                @yield('container')
            </main>
        </div>
    </section>

    {{-- Script Dropdown --}}
    <script>
        function toggleMaxHeight(button) {
            const menuDropdown = button.parentElement;
            menuDropdown.classList.toggle('max-h-fit');
            menuDropdown.classList.toggle('shadow-[0_10px_16px_0_#0A090B0D]');
            menuDropdown.classList.toggle('z-10');
        }

        document.addEventListener('click', function(event) {
            const menuDropdowns = document.querySelectorAll('.menu-dropdown');
            const clickedInsideDropdown = Array.from(menuDropdowns).some(function(dropdown) {
                return dropdown.contains(event.target);
            });
            
            if (!clickedInsideDropdown) {
                menuDropdowns.forEach(function(dropdown) {
                    dropdown.classList.remove('max-h-fit');
                    dropdown.classList.remove('shadow-[0_10px_16px_0_#0A090B0D]');
                    dropdown.classList.remove('z-10');
                });
            }
        });
    </script>

</body>
</html>
