<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- 🔴 FAVICON 🔴 --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo2.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo2.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  
    <title>PT Medlab Nusantara</title>
    

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Keyframe Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100px);
            }

            to {
                transform: translateY(0);
            }
        }

        @keyframe drawPath {
            to {
                stroke-dashoffset: 0;
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-fade-in-left {
            animation: fadeInLeft 0.8s ease-out forwards;
        }

        .animate-fade-in-right {
            animation: fadeInRight 0.8s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.8s ease-out forwards;
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .animate-slide-down {
            animation: slideDown 0.6s ease-out forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        .delay-500 {
            animation-delay: 0.5s;
        }

        .delay-600 {
            animation-delay: 0.6s;
        }

        /* Scroll Reveal */
        .reveal {
            opacity: 0;
        }

        .reveal.active {
            opacity: 1;
        }

        /* SVG Path Animation */
        .animated-svg {
            stroke-dasharray: 3000;
            stroke-dashoffset: 3000;
            animation: drawPath 2s ease-out forwards;
        }
    </style>
</head>

<body class="w-full overflow-x-hidden bg-white" x-data="{ mobileMenuOpen: false, currentSlide: 0, totalSlides: 3 }">

    {{-- Navbar --}}
    @include('components.public-navbar')

    {{-- Hero Section --}}
    @include('components.hero')

    {{-- Profile Section --}}
    @include('components.company-profile')

    {{-- Visi Misi Section --}}
    @include('components.vision-mission')

    {{-- Delivery Section --}}
    @include('components.delivery-banner')

    {{-- 🔥 Section Kategori Cepat (BARU DITAMBAHKAN) 🔥 --}}
    <section class="py-12 bg-gray-50 reveal">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Kategori Produk</h2>
                <div class="h-1 w-20 bg-[#B1252E] mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <a href="/products?kategori=alat" class="group bg-white p-6 rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 flex flex-col items-center justify-center gap-4">
                    <div class="w-14 h-14 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 group-hover:bg-[#B1252E] group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <span class="font-semibold text-gray-700 group-hover:text-[#B1252E] transition-colors">Alat</span>
                </a>

                <a href="/products?kategori=reagen" class="group bg-white p-6 rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 flex flex-col items-center justify-center gap-4">
                    <div class="w-14 h-14 bg-green-50 rounded-full flex items-center justify-center text-green-600 group-hover:bg-[#B1252E] group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <span class="font-semibold text-gray-700 group-hover:text-[#B1252E] transition-colors">Reagen</span>
                </a>

                <a href="/products?kategori=steril" class="group bg-white p-6 rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 flex flex-col items-center justify-center gap-4">
                    <div class="w-14 h-14 bg-purple-50 rounded-full flex items-center justify-center text-purple-600 group-hover:bg-[#B1252E] group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.01 12.01 0 002.944 12c0 3.078 1.488 5.99 3.944 8.056A11.955 11.955 0 0112 21.056c3.078 0 5.99-1.488 8.056-3.944A12.01 12.01 0 0021.056 12a12.01 12.01 0 00-.438-3.016z"></path></svg>
                    </div>
                    <span class="font-semibold text-gray-700 group-hover:text-[#B1252E] transition-colors">Steril</span>
                </a>

                <a href="/products?kategori=non steril" class="group bg-white p-6 rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 flex flex-col items-center justify-center gap-4">
                    <div class="w-14 h-14 bg-orange-50 rounded-full flex items-center justify-center text-orange-600 group-hover:bg-[#B1252E] group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <span class="font-semibold text-gray-700 group-hover:text-[#B1252E] transition-colors">Non Steril</span>
                </a>

                <a href="/products?kategori=invitro" class="group bg-white p-6 rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 flex flex-col items-center justify-center gap-4">
                    <div class="w-14 h-14 bg-pink-50 rounded-full flex items-center justify-center text-pink-600 group-hover:bg-[#B1252E] group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <span class="font-semibold text-gray-700 group-hover:text-[#B1252E] transition-colors">In Vitro</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Product Section --}}
    @include('components.product-collection')

    {{-- Footer --}}
    @include('components.footer')

    <script>
        // Scroll Reveal Animation
        function reveal() {
            const reveals = document.querySelectorAll('.reveal');

            reveals.forEach(element => {
                const windowHeight = window.innerHeight;
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementTop < windowHeight - elementVisible) {
                    element.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', reveal);
        reveal(); // Initial check

        // Smooth Scroll with Animation
        document.querySelectorAll('.smooth-scroll').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('data-scroll-target') || this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    // Add animation class to target section
                    targetElement.style.animation = 'none';
                    setTimeout(() => {
                        targetElement.style.animation = 'fadeInUp 0.8s ease-out forwards';
                    }, 10);

                    // Smooth scroll
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                    // Close mobile menu if open
                    const mobileMenu = document.querySelector('[x-data*="mobileMenuOpen"]');
                    if (mobileMenu && mobileMenu.__x && mobileMenu.__x.$data) {
                        mobileMenu.__x.$data.mobileMenuOpen = false;
                    }
                }
            });
        });
    </script>
</body>

</html>