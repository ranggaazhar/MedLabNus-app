{{-- resources/views/components/sections/product-collection.blade.php --}}
@props(['produks' => collect([])])

<section id="product-section"
    class="product-section w-full py-24 bg-gradient-to-br from-gray-50 to-white overflow-hidden">
    <div class="w-full px-6 lg:px-12 xl:px-20">
        {{-- Product Header --}}
        <div class="product-header text-center mb-16 reveal">
            <h2 class="text-5xl lg:text-6xl text-gray-900 mb-4 font-bold">Product Collection</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Temukan berbagai produk pilihan dengan kualitas<br class="hidden sm:block">
                terbaik untuk kebutuhan Anda.
            </p>
        </div>

        {{-- ... (Bagian Carousel JavaScript/HTML Anda di sini - Tidak ada perubahan di bagian ini) ... --}}
        
        {{-- Product Features --}}
        <div class="max-w-[1800px] mx-auto space-y-16">

            {{-- ALAT Feature --}}
            <div class="grid lg:grid-cols-5 gap-16 items-center reveal">
                <div class="space-y-6 lg:col-span-3">
                    {{-- ... (konten teks dan ikon) ... --}}

                    {{-- 💡 PERHATIAN: Route menggunakan 'kategori' => 'alat' (huruf kecil) --}}
                    <a href="{{ route('products.public', ['kategori' => 'alat']) }}"
                        class="inline-flex items-center gap-2 text-[#B1252E] group hover-lift">
                        <span>View more</span>
                        <span class="text-xl group-hover:translate-x-2 transition-transform">&gt;</span>
                    </a>
                </div>

                {{-- WADAH GAMBAR ALAT --}}
                <div
                    class="relative overflow-hidden rounded-3xl shadow-2xl hover-scale transition-transform duration-300 bg-gray-100 p-8 h-[400px] flex items-center justify-center lg:col-span-2">
                    @if($produks->count() > 0)
                        @php
                            // Ambil produk pertama yang kategorinya alat (walaupun ini tidak terlalu penting untuk filter)
                            $alat_utama = $produks->where('kategori', 'alat')->first() ?? $produks->first();
                        @endphp
                        <img src="{{ asset('storage/' . $alat_utama->gambar_utama) }}"
                            alt="{{ $alat_utama->nama_produk ?? 'Alat Medis' }}" class="w-full h-full object-contain">
                    @else
                        <img src="https://images.unsplash.com/photo-1656337426914-5e5ba162d606?q=80&w=800"
                            alt="Default Alat Medis" class="w-full h-full object-contain">
                    @endif
                </div>
                {{-- END WADAH GAMBAR ALAT --}}
            </div>

            <hr>

            {{-- REAGEN Feature --}}
            <div class="grid lg:grid-cols-5 gap-16 items-center reveal delay-200">
                {{-- WADAH GAMBAR REAGEN --}}
                <div
                    class="relative overflow-hidden rounded-3xl shadow-2xl hover-scale transition-transform duration-300 order-2 lg:order-1 bg-gray-100 p-8 h-[400px] flex items-center justify-center lg:col-span-2">
                    @php
                        $reagen_utama = $produks->where('kategori', 'reagen')->first();
                    @endphp

                    @if ($reagen_utama)
                        <img src="{{ asset('storage/' . $reagen_utama->gambar_utama) }}"
                            alt="{{ $reagen_utama->nama_produk ?? 'Reagen Medis' }}" class="w-full h-full object-contain">
                    @else
                        <img src="https://images.unsplash.com/photo-1713100380566-ca143913c853?q=80&w=800"
                            alt="Default Reagen Medis" class="w-full h-full object-contain">
                    @endif
                </div>

                <div class="space-y-6 order-1 lg:order-2 lg:col-span-3">
                    {{-- ... (konten teks dan ikon) ... --}}

                    {{-- 💡 PERHATIAN: Route menggunakan 'kategori' => 'reagen' (huruf kecil) --}}
                    <a href="{{ route('products.public', ['kategori' => 'reagen']) }}"
                        class="inline-flex items-center gap-2 text-[#B1252E] group hover-lift">
                        <span>View more</span>
                        <span class="text-xl group-hover:translate-x-2 transition-transform">&gt;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ... (Bagian script JavaScript Carousel Anda di sini - Tidak ada perubahan di bagian ini) ... --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Carousel functionality - 6 images but show only 3 at a time
        const carouselItems = document.querySelectorAll('.carousel-item');
        const dots = document.querySelectorAll('.carousel-dot');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtnMobile = document.getElementById('prevBtnMobile');
        const nextBtnMobile = document.getElementById('nextBtnMobile');

        let activeIndex = 1; // Start with second item (index 1)
        const totalItems = carouselItems.length; // 6 images
        let isAnimating = false; // Prevent rapid clicks during animation

        function getPositionForIndex(itemIndex, currentActive) {
            // Calculate relative position from active index
            let distance = itemIndex - currentActive;

            // Normalize distance for circular behavior
            // This ensures smooth infinite scrolling
            if (distance > totalItems / 2) {
                distance -= totalItems;
            } else if (distance < -totalItems / 2) {
                distance += totalItems;
            }

            return distance;
        }

        function updateCarousel(instant = false) {
            const isMobile = window.innerWidth < 768;

            carouselItems.forEach((item, index) => {
                const position = getPositionForIndex(index, activeIndex);

                // Temporarily disable transition for instant updates
                if (instant) {
                    item.style.transition = 'none';
                } else {
                    item.style.transition = 'all 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
                }

                if (isMobile) {
                    // Mobile: only show active item
                    if (position === 0) {
                        item.style.width = '90vw';
                        item.style.height = '300px';
                        item.style.opacity = '1';
                        item.style.transform = 'translateX(0) scale(1)';
                        item.style.zIndex = '10';
                        item.style.pointerEvents = 'auto';
                    } else if (position === 1) {
                        // Next item - positioned to the right
                        item.style.width = '90vw';
                        item.style.height = '300px';
                        item.style.opacity = '0';
                        item.style.transform = 'translateX(100%) scale(0.8)';
                        item.style.zIndex = '0';
                        item.style.pointerEvents = 'none';
                    } else if (position === -1) {
                        // Previous item - positioned to the left
                        item.style.width = '90vw';
                        item.style.height = '300px';
                        item.style.opacity = '0';
                        item.style.transform = 'translateX(-100%) scale(0.8)';
                        item.style.zIndex = '0';
                        item.style.pointerEvents = 'none';
                    } else {
                        // Hidden items
                        item.style.width = '0';
                        item.style.height = '300px';
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.8)';
                        item.style.zIndex = '0';
                        item.style.pointerEvents = 'none';
                    }
                } else {
                    // Desktop: show active + 2 side items
                    if (position === 0) {
                        // Active item - center
                        item.style.width = '500px';
                        item.style.height = '400px';
                        item.style.opacity = '1';
                        item.style.transform = 'translateX(0) scale(1)';
                        item.style.zIndex = '10';
                        item.style.pointerEvents = 'auto';
                    } else if (position === 1) {
                        // Right side item
                        item.style.width = '300px';
                        item.style.height = '400px';
                        item.style.opacity = '0.4';
                        item.style.transform = 'translateX(100px) scale(0.8)';
                        item.style.zIndex = '5';
                        item.style.pointerEvents = 'auto';
                    } else if (position === -1) {
                        // Left side item
                        item.style.width = '300px';
                        item.style.height = '400px';
                        item.style.opacity = '0.4';
                        item.style.transform = 'translateX(-100px) scale(0.8)';
                        item.style.zIndex = '5';
                        item.style.pointerEvents = 'auto';
                    } else if (position === 2) {
                        // Far right - hidden but positioned for smooth entry
                        item.style.width = '0';
                        item.style.height = '400px';
                        item.style.opacity = '0';
                        item.style.transform = 'translateX(200px) scale(0.6)';
                        item.style.zIndex = '0';
                        item.style.pointerEvents = 'none';
                    } else if (position === -2) {
                        // Far left - hidden but positioned for smooth entry
                        item.style.width = '0';
                        item.style.height = '400px';
                        item.style.opacity = '0';
                        item.style.transform = 'translateX(-200px) scale(0.6)';
                        item.style.zIndex = '0';
                        item.style.pointerEvents = 'none';
                    } else {
                        // Completely hidden
                        item.style.width = '0';
                        item.style.height = '400px';
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.6)';
                        item.style.zIndex = '0';
                        item.style.pointerEvents = 'none';
                    }
                }
            });

            // Force reflow if instant
            if (instant) {
                void carouselItems[0].offsetHeight;
            }

            // Update dots - 3 dots for 6 images (each dot represents 2 images)
            const activeDotIndex = Math.floor(activeIndex / 2);
            dots.forEach((dot, index) => {
                if (index === activeDotIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        function nextSlide() {
            if (isAnimating) return;
            isAnimating = true;

            activeIndex = (activeIndex + 1) % totalItems;
            updateCarousel();

            setTimeout(() => {
                isAnimating = false;
            }, 500); // Match transition duration
        }

        function prevSlide() {
            if (isAnimating) return;
            isAnimating = true;

            activeIndex = (activeIndex - 1 + totalItems) % totalItems;
            updateCarousel();

            setTimeout(() => {
                isAnimating = false;
            }, 500); // Match transition duration
        }

        // Event listeners
        prevBtn?.addEventListener('click', prevSlide);
        nextBtn?.addEventListener('click', nextSlide);
        prevBtnMobile?.addEventListener('click', prevSlide);
        nextBtnMobile?.addEventListener('click', nextSlide);

        // Dot navigation - clicking dot jumps to first image of that pair
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                if (isAnimating) return;
                isAnimating = true;

                activeIndex = index * 2; // Jump to first image of the pair
                updateCarousel();

                setTimeout(() => {
                    isAnimating = false;
                }, 500);
            });
        });

        // Click on carousel items to make them active
        carouselItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                if (index !== activeIndex && !isAnimating) {
                    isAnimating = true;
                    activeIndex = index;
                    updateCarousel();

                    setTimeout(() => {
                        isAnimating = false;
                    }, 500);
                }
            });
        });

        // Initialize
        updateCarousel(true); // Start without animation

        // Handle window resize with debounce
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => updateCarousel(true), 100);
        });

        // Auto-play carousel every 5 seconds
        let autoPlayInterval = setInterval(nextSlide, 5000);

        // Pause auto-play on hover
        const carouselWrapper = document.querySelector('.carousel-wrapper');
        carouselWrapper?.addEventListener('mouseenter', () => {
            clearInterval(autoPlayInterval);
        });

        carouselWrapper?.addEventListener('mouseleave', () => {
            autoPlayInterval = setInterval(nextSlide, 5000);
        });

        // Reveal animation on scroll
        const revealElements = document.querySelectorAll('.reveal');

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '-100px'
        });

        revealElements.forEach(el => {
            revealObserver.observe(el);
        });
    });
</script>