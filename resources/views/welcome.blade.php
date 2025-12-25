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
        [x-cloak] { display: none !important; }

        /* Keyframe Animations */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.8); } to { opacity: 1; transform: scale(1); } }

        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-scale-in { animation: scaleIn 0.8s ease-out forwards; }

        /* Scroll Reveal */
        .reveal { opacity: 0; transition: all 0.8s ease-out; }
        .reveal.active { opacity: 1; }

        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="w-full overflow-x-hidden bg-white" x-data="{ mobileMenuOpen: false }">

    @include('components.public-navbar')
    @include('components.hero')
    @include('components.company-profile')
    @include('components.vision-mission')
    @include('components.delivery-banner')

    {{-- 🔥 Section Kategori Produk 🔥 --}}
    <section class="py-20 bg-[#fbfbfb] reveal">
        <div class="container mx-auto px-6 lg:px-12">
            
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Kategori Produk</h2>
                <div class="mt-6 h-1 w-20 bg-[#B1252E] mx-auto rounded-full"></div>
            </div>

            <div class="flex overflow-x-auto pb-8 gap-5 hide-scrollbar snap-x md:grid md:grid-cols-5 md:gap-8 md:overflow-visible">
                
                @php
                    $categories = [
                        [
                            'name' => 'Alat', 
                            'slug' => 'alat',
                            'color' => 'blue', 
                            // Analyzer (Representasi BA400/A15)
                            'icon' => '<rect x="3" y="4" width="18" height="14" rx="2" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M7 8h4M7 12h2M15 8h2v6h-2z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M3 14h18" stroke="currentColor" stroke-width="1.8"/>'
                        ],
                        [
                            'name' => 'Reagen', 
                            'slug' => 'reagen',
                            'color' => 'green', 
                            // Reagent Bottle with Drop
                            'icon' => '<path d="M9 3h6v3a4 4 0 0 1-4 4 4 4 0 0 1-4-4V3z" fill="none" stroke="currentColor" stroke-width="1.8"/><rect x="7" y="10" width="10" height="10" rx="1" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 14v2M12 14c-.5 0-1 .5-1 1s.5 1 1 1" stroke="currentColor" stroke-width="1.2"/>'
                        ],
                        [
                            'name' => 'Steril', 
                            'slug' => 'steril',
                            'color' => 'purple', 
                            // Syringe & Scalpel Combined
                            'icon' => '<path d="m18 2 2 2-11 11-4-1 1-4Z" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M13 7l2 2M2 22l4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="19" cy="5" r="1" fill="currentColor"/>'
                        ],
                        [
                            'name' => 'Non Steril', 
                            'slug' => 'non-steril',
                            'color' => 'orange', 
                            // Digital Scale (Timbangan)
                            'icon' => '<rect x="3" y="14" width="18" height="6" rx="1" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M6 14V7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v7" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M10 10h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>'
                        ],
                        [
                            'name' => 'In Vitro', 
                            'slug' => 'invitro',
                            'color' => 'pink', 
                            // Original Test Tube
                            'icon' => '<path d="M9 3h6M10 3v13a3 3 0 0 0 6 0V3M10 8h6M10 12h6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>'
                        ],
                    ];
                @endphp

                @foreach($categories as $cat)
                <a href="/products?kategori={{ $cat['slug'] }}" 
                    class="category-card min-w-[150px] snap-center group bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 flex flex-col items-center gap-5 md:min-w-0">
                    
                    <div class="icon-box w-20 h-20 bg-{{ $cat['color'] }}-50 rounded-2xl flex items-center justify-center text-{{ $cat['color'] }}-600 group-hover:bg-[#B1252E] group-hover:text-white transition-all duration-500">
                        <svg class="w-10 h-10 transition-colors duration-500 group-hover:text-white" viewBox="0 0 24 24">
                            {!! $cat['icon'] !!}
                        </svg>
                    </div>

                    <span class="font-semibold text-gray-700 text-lg group-hover:text-[#B1252E] transition-colors duration-300 whitespace-nowrap">
                        {{ $cat['name'] }}
                    </span>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    @include('components.product-collection')
    @include('components.footer')

    <script>
        // --- LOGIKA CAROUSEL ---
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.querySelector('.carousel-container');
            const items = document.querySelectorAll('.carousel-item');
            const dots = document.querySelectorAll('.carousel-dot');
            if(!container || items.length === 0) return;

            let activeIndex = 0;
            const total = items.length;
            let isAnimating = false;

            function getRelativePosition(index, active) {
                let diff = index - active;
                if (diff > total / 2) diff -= total;
                if (diff < -total / 2) diff += total;
                return diff;
            }

            function updateCarousel() {
                const isMobile = window.innerWidth < 768;
                items.forEach((item, i) => {
                    const pos = getRelativePosition(i, activeIndex);
                    if (isMobile) {
                        item.style.transform = `translateX(${pos * 100}%) scale(${pos === 0 ? 1 : 0.8})`;
                        item.style.opacity = pos === 0 ? 1 : 0.4;
                    } else {
                        item.style.transform = `translateX(${pos * 350}px) scale(${1 - Math.abs(pos) * 0.2})`;
                        item.style.opacity = 1 - Math.abs(pos) * 0.5;
                    }
                    item.style.zIndex = 20 - Math.abs(pos);
                });
                dots.forEach((dot, i) => {
                    dot.style.width = i === activeIndex ? '30px' : '10px';
                    dot.style.backgroundColor = i === activeIndex ? '#B1252E' : '#D1D5DB';
                });
            }

            function moveNext() { 
                if(isAnimating) return;
                isAnimating = true;
                activeIndex = (activeIndex + 1) % total; 
                updateCarousel(); 
                setTimeout(() => isAnimating = false, 600);
            }

            document.getElementById('nextBtn')?.addEventListener('click', moveNext);
            document.getElementById('prevBtn')?.addEventListener('click', () => {
                activeIndex = (activeIndex - 1 + total) % total;
                updateCarousel();
            });

            window.addEventListener('resize', updateCarousel);
            updateCarousel();
            setInterval(moveNext, 5000);
        });

        function reveal() {
            const reveals = document.querySelectorAll('.reveal');
            reveals.forEach(element => {
                if (element.getBoundingClientRect().top < window.innerHeight - 150) {
                    element.classList.add('active');
                }
            });
        }
        window.addEventListener('scroll', reveal);
        reveal();
    </script>
</body>
</html>