{{-- resources/views/components/sections/product-collection.blade.php --}}
@props(['produks' => collect([])])

<section id="product-section" class="product-section w-full py-24 bg-gradient-to-br from-gray-50 to-white overflow-hidden">
    <div class="w-full px-6 lg:px-12 xl:px-20">
        {{-- Product Header --}}
        <div class="product-header text-center mb-16 reveal">
            <h2 class="text-5xl lg:text-6xl text-gray-900 mb-4 font-bold">Product Collection</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Temukan berbagai produk pilihan dengan kualitas<br class="hidden sm:block">
                terbaik untuk kebutuhan Anda.
            </p>
        </div>

        {{-- Carousel Section --}}
        <div class="carousel-wrapper relative mb-16 max-w-[1800px] mx-auto reveal delay-200">
            <div class="flex items-center justify-center gap-8 lg:gap-16">
                {{-- Previous Button --}}
                <button 
                    id="prevBtn" 
                    class="hidden md:flex items-center justify-center w-14 h-14 bg-white rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-110 active:scale-90 z-20"
                >
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                {{-- Images Container --}}
                <div class="carousel-container relative flex-1 max-w-6xl" style="height: 450px;">
                    <div class="flex items-center justify-center gap-4 h-full">
                        @php
                            $carouselImages = [
                                'https://images.unsplash.com/photo-1713100380566-ca143913c853?w=500',
                                'https://images.unsplash.com/photo-1656337426914-5e5ba162d606?w=500',
                                'https://images.unsplash.com/photo-1582719366702-9e0c8f5e7e8d?w=500',
                                'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=500',
                                'https://images.unsplash.com/photo-1631549916768-4119b2e5f926?w=500',
                                'https://images.unsplash.com/photo-1603398938378-e54eab446dde?w=500',
                            ];
                        @endphp

                        @foreach($carouselImages as $index => $path)
                            <div 
                                class="carousel-item overflow-hidden rounded-2xl shadow-2xl cursor-pointer flex-shrink-0"
                                data-index="{{ $index }}"
                                style="transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);"
                            >
                                <img 
                                    src="{{ $path }}" 
                                    alt="Product Collection Image {{ $index + 1 }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Next Button --}}
                <button 
                    id="nextBtn" 
                    class="hidden md:flex items-center justify-center w-14 h-14 bg-white rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-110 active:scale-90 z-20"
                >
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile Navigation --}}
            <div class="flex md:hidden items-center justify-center gap-4 mt-6">
                <button id="prevBtnMobile" class="p-2 bg-white rounded-full shadow-lg active:scale-90 transition-transform">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button id="nextBtnMobile" class="p-2 bg-white rounded-full shadow-lg active:scale-90 transition-transform">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            {{-- Dots Navigation - Only 3 dots for 6 images (2 images per dot group) --}}
            <div id="dotsContainer" class="flex items-center justify-center gap-2 mt-8">
                @for($i = 0; $i < 3; $i++)
                    <button 
                        class="carousel-dot transition-all rounded-full"
                        data-index="{{ $i }}"
                    ></button>
                @endfor
            </div>
        </div>

        {{-- Product Features --}}
        <div class="max-w-[1800px] mx-auto space-y-16">
            {{-- ALAT Feature --}}
            <div class="grid lg:grid-cols-2 gap-16 items-center reveal">
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#B1252E] to-[#8f1d24] rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="12" y1="18" x2="12" y2="12"></line>
                                <line x1="9" y1="15" x2="15" y2="15"></line>
                            </svg>
                        </div>
                        <h3 class="text-4xl text-gray-900 font-semibold">ALAT</h3>
                    </div>

                    <div class="h-1 w-16 bg-gradient-to-r from-[#B1252E] to-[#8f1d24] rounded-full"></div>

                    <p class="text-gray-600 leading-relaxed">
                        Peralatan medis berkualitas tinggi yang dirancang untuk mendukung proses pemeriksaan agar lebih
                        akurat dan efisien.
                    </p>

                    <a href="{{ route('products.public') }}" class="inline-flex items-center gap-2 text-[#B1252E] group hover-lift">
                        <span>View more</span>
                        <span class="text-xl group-hover:translate-x-2 transition-transform">&gt;</span>
                    </a>
                </div>

                <div class="relative overflow-hidden rounded-3xl shadow-2xl hover-scale transition-transform duration-300">
                    @if($produks->count() > 0)
                        <img 
                            src="{{ asset('storage/' . $produks->first()->gambar_utama) }}"
                            alt="{{ $produks->first()->nama_produk ?? 'Alat Medis' }}"
                            class="w-full h-[400px] object-cover"
                        >
                    @else
                        <img 
                            src="https://images.unsplash.com/photo-1656337426914-5e5ba162d606?w=800" 
                            alt="Default Alat Medis"
                            class="w-full h-[400px] object-cover"
                        >
                    @endif
                </div>
            </div>

            {{-- REAGEN Feature --}}
            <div class="grid lg:grid-cols-2 gap-16 items-center reveal delay-200">
                <div class="relative overflow-hidden rounded-3xl shadow-2xl hover-scale transition-transform duration-300 order-2 lg:order-1">
                    @php
                        $reagen_utama = $produks->count() > 0
                            ? $produks->where('kategori', 'reagen')->first()
                            : null;
                    @endphp

                    @if ($reagen_utama)
                        <img 
                            src="{{ asset('storage/' . $reagen_utama->gambar_utama) }}"
                            alt="{{ $reagen_utama->nama_produk ?? 'Reagen Medis' }}"
                            class="w-full h-[400px] object-cover"
                        >
                    @else
                        <img 
                            src="https://images.unsplash.com/photo-1713100380566-ca143913c853?w=800" 
                            alt="Default Reagen Medis"
                            class="w-full h-[400px] object-cover"
                        >
                    @endif
                </div>

                <div class="space-y-6 order-1 lg:order-2">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#B1252E] to-[#8f1d24] rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10 2v7.31"></path>
                                <path d="M14 9.3V1.99"></path>
                                <path d="M8.5 2h7"></path>
                                <path d="M14 9.3a6.5 6.5 0 1 1-4 0"></path>
                                <path d="M5.58 16.5h12.85"></path>
                            </svg>
                        </div>
                        <h3 class="text-4xl text-gray-900 font-semibold">REAGEN</h3>
                    </div>

                    <div class="h-1 w-16 bg-gradient-to-r from-[#B1252E] to-[#8f1d24] rounded-full"></div>

                    <p class="text-gray-600 leading-relaxed">
                        Reagen berkualitas tinggi untuk memastikan hasil pengujian yang konsisten dan dapat diandalkan.
                    </p>

                    <a href="{{ route('products.public') }}" class="inline-flex items-center gap-2 text-[#B1252E] group hover-lift">
                        <span>View more</span>
                        <span class="text-xl group-hover:translate-x-2 transition-transform">&gt;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Utility Classes */
.hover-scale:hover {
    transform: scale(1.05);
}

.hover-lift:hover {
    transform: translateX(5px) scale(1.05);
}

/* Carousel Dots Styling */
.carousel-dot {
    width: 12px;
    height: 12px;
    background-color: #d1d5db;
}

.carousel-dot.active {
    width: 32px;
    height: 12px;
    background-color: #dc2626;
}

.carousel-dot:hover {
    transform: scale(1.2);
}

/* Reveal Animation */
.reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s ease, transform 0.8s ease;
}

.reveal.delay-200 {
    transition-delay: 0.2s;
}

.reveal.active {
    opacity: 1;
    transform: translateY(0);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .carousel-container {
        height: 300px !important;
    }
    
    /* Center product feature titles on mobile */
    .product-section .space-y-6 {
        text-align: center;
    }
    
    .product-section .space-y-6 .flex.items-center {
        justify-content: center;
    }
    
    /* Center the decorative line on mobile */
    .product-section .space-y-6 .h-1 {
        margin-left: auto;
        margin-right: auto;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
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