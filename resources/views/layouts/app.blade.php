<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo2.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo2.png') }}">
    <title>PT Medlab Nusantara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen">

        {{-- Memanggil Public Navbar untuk Customer --}}
        <x-public-navbar />

        @isset($header)
            <header class="bg-white shadow-sm mt-16">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="{{ isset($header) ? '' : 'pt-20' }}">
            {{ $slot }}
        </main>
    </div>
    <script>
        function updateCartBadge() {
            const badge = document.getElementById('cart-count');
            if (!badge) return;

            // Ambil data dari LocalStorage browser
            const cart = JSON.parse(localStorage.getItem('keranjang_penawaran')) || [];
            const totalJenisProduk = cart.length;

            // Logika Menampilkan / Menyembunyikan Badge Lingkaran Merah
            if (totalJenisProduk > 0) {
                badge.innerText = totalJenisProduk;
                badge.classList.remove('hidden');
                badge.classList.add('inline-flex');
            } else {
                badge.classList.add('hidden');
                badge.classList.remove('inline-flex');
            }
        }

        // Jalankan otomatis setiap kali halaman apa saja selesai di-load
        document.addEventListener('DOMContentLoaded', updateCartBadge);
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
</body>

</html>
