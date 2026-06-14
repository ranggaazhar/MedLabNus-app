<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | PT Medlab Nusantara</title>
    
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
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-red-50 text-[#B1252E] mb-6 shadow-sm border border-red-100">
                <i class="fas fa-compass text-4xl"></i>
            </div>
            <h1 class="text-7xl md:text-9xl font-bold text-[#B1252E] mb-4 drop-shadow-md">404</h1>
            <h2 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4">Halaman Tidak Ditemukan</h2>
            <p class="text-gray-600 mb-10 text-lg leading-relaxed">
                Maaf, halaman yang Anda cari mungkin telah dihapus, namanya berubah, atau untuk sementara tidak tersedia.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 bg-[#B1252E] text-white px-8 py-3.5 rounded-full font-semibold hover:bg-red-800 hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-red-900/30">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>

    @include('components.footer')

</body>
</html>
