<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 - Sesi Berakhir | PT Medlab Nusantara</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo2.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="w-full overflow-x-hidden bg-white flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false }">

    @include('components.public-navbar')

    <main class="flex-grow flex items-center justify-center relative py-24">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/visi.jpg') }}" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-white/80 backdrop-blur-sm"></div>
        </div>

        <div class="relative z-10 text-center px-6 animate-fade-in-up max-w-2xl mx-auto">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-orange-50 text-orange-500 mb-6 shadow-sm border border-orange-100">
                <i class="fas fa-hourglass-end text-4xl"></i>
            </div>
            <h1 class="text-7xl md:text-9xl font-bold text-orange-500 mb-4 drop-shadow-md">419</h1>
            <h2 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4">Sesi Telah Berakhir</h2>
            <p class="text-gray-600 mb-10 text-lg leading-relaxed">
                Maaf, keamanan sistem mendeteksi bahwa halaman ini sudah terlalu lama tidak dimuat ulang. Silakan muat ulang halaman untuk melanjutkan aktivitas Anda.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 bg-white text-gray-700 px-8 py-3.5 rounded-full font-semibold border-2 border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-all duration-300">
                    <i class="fas fa-home"></i> Ke Beranda
                </a>
            </div>
        </div>
    </main>

    @include('components.footer')

</body>
</html>
