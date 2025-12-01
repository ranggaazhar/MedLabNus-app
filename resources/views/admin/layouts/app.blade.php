<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Medlab</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/dashboard.css', 'resources/css/custom-utilities.css'])
</head>

<body class="bg-gray-100 font-sans text-gray-900 antialiased">

    <div class="flex h-screen w-full">

        {{-- SIDEBAR --}}
        <x-sidebar />

        {{-- MAIN WRAPPER (Sebelah Kanan Sidebar) --}}
        <div class="flex-1 flex flex-col ml-0 md:ml-64 transition-all duration-300 h-full relative">

            {{-- 
                WRAPPER SCROLL: 
                Kita bungkus Navbar DAN Content di dalam satu container scroll yang sama.
                Ini menjamin mereka selalu sejajar 100%.
            --}}
            <div id="scroll-container">
                
                {{-- NAVBAR --}}
                {{-- Pastikan Navbar tidak 'fixed' agar ikut discroll dan tetap sejajar --}}
                <div class="sticky top-0 z-40">
                    <x-navbar title="@yield('title')" />
                </div>

                {{-- CONTENT AREA --}}
                {{-- Perhatikan class px-8: Disamakan agar lurus dengan Navbar --}}
                <main class="p-6 md:p-8 w-full max-w-full">
                    @yield('content')
                </main>

            </div>

        </div>

    </div>

    {{-- Script Toggle Sidebar --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const wrapper = document.querySelector('.md\\:ml-64'); // Selector Wrapper
        const toggleBtn = document.getElementById('toggleSidebar');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                if (window.innerWidth >= 768) {
                    sidebar.classList.toggle('md:translate-x-0');
                    // Geser margin wrapper
                    if (sidebar.classList.contains('md:translate-x-0')) {
                        wrapper.classList.remove('md:ml-0');
                        wrapper.classList.add('md:ml-64');
                    } else {
                        wrapper.classList.add('md:ml-0');
                        wrapper.classList.remove('md:ml-64');
                    }
                } else {
                    sidebar.classList.toggle('-translate-x-full');
                }
            });
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')

</body>
</html>