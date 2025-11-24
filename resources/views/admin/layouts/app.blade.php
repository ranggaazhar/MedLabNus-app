<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <title>@yield('title') - Medlab</title>
    {{-- Pastikan Font Awesome sudah terload --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Scrollbar halus */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans text-gray-900 antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <x-sidebar />

        {{-- Tambahkan ID "main-content" di sini --}}
        <div id="main-content"
            class="flex-1 flex flex-col ml-0 md:ml-64 transition-all duration-300 relative h-full overflow-y-auto">

            <x-navbar title="@yield('title')" />

            <main class="p-6 md:p-8">
                @yield('content')
            </main>
        </div>

    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const toggleBtn = document.getElementById('toggleSidebar');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {

                if (window.innerWidth >= 768) {
                    // --- LOGIKA DESKTOP ---

                    // 1. Hapus/Pasang class yang memaksa sidebar tampil di desktop
                    // Ini kuncinya: kita toggle 'md:translate-x-0'
                    sidebar.classList.toggle('md:translate-x-0');

                    // 2. Geser konten utama agar memenuhi layar
                    mainContent.classList.toggle('md:ml-64');

                } else {
                    // --- LOGIKA MOBILE ---

                    // Di mobile, sidebar defaultnya hidden (-translate-x-full).
                    // Kita cukup toggle class itu untuk menampilkan/sembunyikan.
                    sidebar.classList.toggle('-translate-x-full');
                }

            });
        }
    </script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@yield('scripts')
</body>


</html>