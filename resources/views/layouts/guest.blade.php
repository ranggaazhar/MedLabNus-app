<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Reset dasar */
        html, body { height: 100%; margin: 0; }

        /* Warna khusus Monstera */
        .bg-monstera { background-color: #3e5636; }
        .hover-monstera:hover { background-color: #2f4229; }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-white h-full selection:bg-green-100 selection:text-green-900">

    {{-- CONTAINER UTAMA (Relative untuk menampung Absolute) --}}
    <div class="relative flex w-full min-h-screen overflow-hidden">

        {{-- 
            BAGIAN KIRI: FORM
            - Width 50%: Memberi ruang agar form tidak tertutup gambar yang menimpa.
            - z-10: Berada di layer bawah.
        --}}
        <div class="w-full lg:w-[50%] flex flex-col justify-center px-8 sm:px-12 lg:px-20 py-10 bg-white z-10 relative">
            <div class="w-full max-w-md mx-auto lg:mr-auto lg:ml-0">
                {{ $slot }}
            </div>
        </div>

        {{-- 
            BAGIAN KANAN: GAMBAR FULL & MENIMPA
            - absolute top-0 right-0 h-full: Menempel penuh dari atas ke bawah di sisi kanan.
            - w-[55%]: Lebar 55% dari layar (lebih lebar dari setengah) agar terlihat "Full".
            - rounded-l-[50px]: Memberikan lengkungan besar hanya di sisi kiri.
            - z-20: Layer di atas form (menimpa background putih).
            - shadow-2xl: Memberi efek bayangan agar terlihat mengambang di atas putih.
        --}}
        <div class="hidden lg:block absolute top-0 right-0 w-[55%] h-full z-20 shadow-2xl rounded-l-[50px] overflow-hidden">
            <img
                src="https://images.unsplash.com/photo-1598337854637-231a4038a379?q=80&w=1974&auto=format&fit=crop"
                alt="Monstera Leaf"
                class="w-full h-full object-cover object-center"
            >
            {{-- Overlay halus supaya gambar menyatu --}}
            <div class="absolute inset-0 bg-black/5"></div>
        </div>

    </div>
</body>
</html>