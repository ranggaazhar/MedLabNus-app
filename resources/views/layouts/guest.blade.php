<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Medlab Nusantara') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo2.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo2.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Reset dasar */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        /* Warna khusus Monstera */
        .bg-monstera {
            background-color: #3e5636;
        }

        .hover-monstera:hover {
            background-color: #2f4229;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased bg-white h-full selection:bg-green-100 selection:text-green-900">

    {{-- CONTAINER UTAMA --}}
    <div class="relative flex w-full min-h-screen overflow-x-hidden">

        {{-- 
            BAGIAN KIRI: FORM 
            REVISI: 
            - px-6 (Mobile): Agar form lebih luas di layar HP.
            - lg:w-[50%]: Tetap setengah layar saat di desktop.
        --}}
        <div class="w-full lg:w-[50%] flex flex-col justify-center px-6 sm:px-12 lg:px-20 py-10 bg-white z-10 relative">
            {{-- mx-auto membuat form tetap di tengah saat layar kecil --}}
            <div class="w-full max-w-md mx-auto lg:mr-auto lg:ml-0">
                {{ $slot }}
            </div>
        </div>

        {{-- 
            BAGIAN KANAN: GAMBAR 
            REVISI: Tetap tersembunyi di mobile (hidden), muncul di desktop (lg:block).
        --}}
        <div class="hidden lg:block absolute top-0 right-0 w-[55%] h-full z-20 shadow-2xl rounded-l-[50px] overflow-hidden">
            <img src="{{ asset('images/login.png') }}" alt="Medlab Nusantara"
                class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-black/5"></div>
        </div>

    </div>
</body>
</html>