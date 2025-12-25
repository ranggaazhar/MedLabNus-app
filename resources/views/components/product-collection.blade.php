{{-- resources/views/components/sections/product-collection.blade.php --}}
@props(['produks' => collect([])])

<style>
    /* CSS Tambahan untuk mendukung Infinite Loop & Swipe */
    .carousel-container {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        perspective: 1000px;
        overflow: visible;
    }

    .carousel-item {
        position: absolute;
        will-change: transform, opacity;
        user-select: none;
        -webkit-user-drag: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Animasi Reveal */
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease-out;
    }

    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }
    
    .hover-scale:hover {
        transform: scale(1.02);
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
    }
</style>

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

        {{-- Carousel Section --}}
        <div class="carousel-wrapper relative mb-16 max-w-[1800px] mx-auto reveal">
            <div class="flex items-center justify-center gap-8 lg:gap-16">
                {{-- Previous Button --}}
                <button id="prevBtn"
                    class="hidden md:flex items-center justify-center w-14 h-14 bg-white rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-110 active:scale-90 z-30">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                {{-- Images Container --}}
                <div class="carousel-container relative flex-1 max-w-5xl" style="height: 450px;">
                    @php
                        $carouselImages = [
                            asset('images/collections1.png'),
                            asset('images/collections2.png'),
                            asset('images/collections4.png'),
                        ];
                    @endphp

                    @foreach($carouselImages as $index => $path)
                        <div class="carousel-item overflow-hidden rounded-2xl shadow-2xl cursor-grab active:cursor-grabbing bg-white"
                            data-index="{{ $index }}">
                            <img src="{{ $path }}" alt="Product Collection Image {{ $index + 1 }}"
                                class="w-full h-full object-cover pointer-events-none">
                        </div>
                    @endforeach
                </div>

                {{-- Next Button --}}
                <button id="nextBtn"
                    class="hidden md:flex items-center justify-center w-14 h-14 bg-white rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-110 active:scale-90 z-30">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            {{-- Mobile Navigation --}}
            <div class="flex md:hidden items-center justify-center gap-6 mt-8">
                <button id="prevBtnMobile"
                    class="p-3 bg-white rounded-full shadow-lg active:scale-90 transition-transform">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextBtnMobile"
                    class="p-3 bg-white rounded-full shadow-lg active:scale-90 transition-transform">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            {{-- Dots Navigation --}}
            <div id="dotsContainer" class="flex items-center justify-center gap-2 mt-8">
                @foreach($carouselImages as $index => $path)
                    <button class="carousel-dot transition-all duration-300" data-index="{{ $index }}"></button>
                @endforeach
            </div>
        </div>

        {{-- FEATURE SECTIONS --}}
        <div class="max-w-[1800px] mx-auto space-y-16">
            {{-- 1. ALAT --}}
            <div class="grid lg:grid-cols-5 gap-16 items-center reveal">
                <div class="space-y-6 lg:col-span-3">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#B1252E] to-[#8f1d24] rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="12" y1="18" x2="12" y2="12" />
                                <line x1="9" y1="15" x2="15" y2="15" />
                            </svg>
                        </div>
                        <h3 class="text-4xl font-semibold text-gray-900">ALAT</h3>
                    </div>
                    <div class="h-1 w-16 bg-gradient-to-r from-[#B1252E] to-[#8f1d24] rounded-full"></div>
                    <p class="text-xl leading-relaxed text-gray-600">Peralatan medis berkualitas tinggi yang dirancang untuk mendukung proses pemeriksaan agar lebih akurat dan efisien.</p>
                    <a href="{{ route('products.public', ['kategori' => 'alat']) }}" class="inline-flex items-center gap-2 text-[#B1252E] group hover-lift">
                        <span>View more</span>
                        <span class="text-xl transition-transform group-hover:translate-x-2">&gt;</span>
                    </a>
                </div>
                <div class="relative overflow-hidden rounded-3xl shadow-2xl hover-scale bg-gray-100 p-8 h-[400px] flex items-center justify-center transition-transform duration-300 lg:col-span-2">
                    @if ($produks->where('kategori', 'alat')->count() > 0)
                        <img src="{{ asset('storage/' . $produks->where('kategori', 'alat')->first()->gambar_utama) }}" alt="Alat Medis" class="w-full h-full object-contain">
                    @else
                        <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=800" alt="Default Alat" class="w-full h-full object-cover">
                    @endif
                </div>
            </div>

            {{-- 2. REAGEN --}}
            <div class="grid lg:grid-cols-5 gap-16 items-center reveal">
                <div class="relative overflow-hidden rounded-3xl shadow-2xl hover-scale bg-gray-100 p-8 h-[400px] flex items-center justify-center transition-transform duration-300 order-2 lg:order-1 lg:col-span-2">
                    @php $reagen_utama = $produks->where('kategori', 'reagen')->first(); @endphp
                    @if ($reagen_utama)
                        <img src="{{ asset('storage/' . $reagen_utama->gambar_utama) }}" alt="Reagen Medis" class="w-full h-full object-contain">
                    @else
                        <img src="https://images.unsplash.com/photo-1579154204601-01588f351e67?q=80&w=800" alt="Default Reagen" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="space-y-6 order-1 lg:order-2 lg:col-span-3">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#B1252E] to-[#8f1d24] rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                <line x1="8" y1="12" x2="16" y2="12" />
                                <line x1="12" y1="8" x2="12" y2="16" />
                            </svg>
                        </div>
                        <h3 class="text-4xl font-semibold text-gray-900">REAGEN</h3>
                    </div>
                    <div class="h-1 w-16 bg-gradient-to-r from-[#B1252E] to-[#8f1d24] rounded-full"></div>
                    <p class="text-xl leading-relaxed text-gray-600">Reagen berkualitas tinggi yang memastikan hasil pengujian laboratorium yang akurat, cepat, dan dapat diandalkan.</p>
                    <a href="{{ route('products.public', ['kategori' => 'reagen']) }}" class="inline-flex items-center gap-2 text-[#B1252E] group hover-lift">
                        <span>View more</span>
                        <span class="text-xl transition-transform group-hover:translate-x-2">&gt;</span>
                    </a>
                </div>
            </div>

            {{-- 3. STERIL --}}
            <div class="grid lg:grid-cols-5 gap-16 items-center reveal">
                <div class="space-y-6 lg:col-span-3">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#B1252E] to-[#8f1d24] rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.01 12.01 0 002.944 12c0 3.078 1.488 5.99 3.944 8.056A11.955 11.955 0 0112 21.056c3.078 0 5.99-1.488 8.056-3.944A12.01 12.01 0 0021.056 12a12.01 12.01 0 00-.438-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-4xl font-semibold text-gray-900">STERIL</h3>
                    </div>
                    <div class="h-1 w-16 bg-gradient-to-r from-[#B1252E] to-[#8f1d24] rounded-full"></div>
                    <p class="text-xl leading-relaxed text-gray-600">Produk steril yang terjamin kebersihannya untuk mendukung prosedur medis yang aman dan bebas kontaminasi.</p>
                    <a href="{{ route('products.public', ['kategori' => 'steril']) }}" class="inline-flex items-center gap-2 text-[#B1252E] group hover-lift">
                        <span>View more</span>
                        <span class="text-xl transition-transform group-hover:translate-x-2">&gt;</span>
                    </a>
                </div>
                <div class="relative overflow-hidden rounded-3xl shadow-2xl hover-scale bg-gray-100 p-8 h-[400px] flex items-center justify-center transition-transform duration-300 lg:col-span-2">
                    @php $steril_utama = $produks->where('kategori', 'steril')->first(); @endphp
                    @if ($steril_utama)
                        <img src="{{ asset('storage/' . $steril_utama->gambar_utama) }}" alt="Produk Steril" class="w-full h-full object-contain">
                    @else
                        <img src="https://images.unsplash.com/photo-1584036561566-b93a90a63146?q=80&w=800" alt="Default Steril" class="w-full h-full object-cover">
                    @endif
                </div>
            </div>

            {{-- 4. NON STERIL --}}
            <div class="grid lg:grid-cols-5 gap-16 items-center reveal">
                <div class="relative overflow-hidden rounded-3xl shadow-2xl hover-scale bg-gray-100 p-8 h-[400px] flex items-center justify-center transition-transform duration-300 order-2 lg:order-1 lg:col-span-2">
                    @php $non_steril_utama = $produks->where('kategori', 'non steril')->first(); @endphp
                    @if ($non_steril_utama)
                        <img src="{{ asset('storage/' . $non_steril_utama->gambar_utama) }}" alt="Produk Non Steril" class="w-full h-full object-contain">
                    @else
                        <img src="https://images.unsplash.com/photo-1631549916768-4119b2e5f926?q=80&w=800" alt="Default Non Steril" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="space-y-6 order-1 lg:order-2 lg:col-span-3">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#B1252E] to-[#8f1d24] rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="text-4xl font-semibold text-gray-900">NON STERIL</h3>
                    </div>
                    <div class="h-1 w-16 bg-gradient-to-r from-[#B1252E] to-[#8f1d24] rounded-full"></div>
                    <p class="text-xl leading-relaxed text-gray-600">Perlengkapan medis umum dan pendukung laboratorium untuk kebutuhan operasional sehari-hari yang esensial.</p>
                    <a href="{{ route('products.public', ['kategori' => 'non steril']) }}" class="inline-flex items-center gap-2 text-[#B1252E] group hover-lift">
                        <span>View more</span>
                        <span class="text-xl transition-transform group-hover:translate-x-2">&gt;</span>
                    </a>
                </div>
            </div>

            {{-- 5. IN VITRO --}}
            <div class="grid lg:grid-cols-5 gap-16 items-center reveal">
                <div class="space-y-6 lg:col-span-3">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#B1252E] to-[#8f1d24] rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <h3 class="text-4xl font-semibold text-gray-900">IN VITRO</h3>
                    </div>
                    <div class="h-1 w-16 bg-gradient-to-r from-[#B1252E] to-[#8f1d24] rounded-full"></div>
                    <p class="text-xl leading-relaxed text-gray-600">Solusi diagnostik In Vitro mutakhir untuk analisis laboratorium yang presisi dan mendukung diagnosis klinis.</p>
                    <a href="{{ route('products.public', ['kategori' => 'invitro']) }}" class="inline-flex items-center gap-2 text-[#B1252E] group hover-lift">
                        <span>View more</span>
                        <span class="text-xl transition-transform group-hover:translate-x-2">&gt;</span>
                    </a>
                </div>
                <div class="relative overflow-hidden rounded-3xl shadow-2xl hover-scale bg-gray-100 p-8 h-[400px] flex items-center justify-center transition-transform duration-300 lg:col-span-2">
                    @php $invitro_utama = $produks->where('kategori', 'invitro')->first(); @endphp
                    @if ($invitro_utama)
                        <img src="{{ asset('storage/' . $invitro_utama->gambar_utama) }}" alt="Produk In Vitro" class="w-full h-full object-contain">
                    @else
                        <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=800" alt="Default In Vitro" class="w-full h-full object-cover">
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('.carousel-container');
    const items = document.querySelectorAll('.carousel-item');
    const dots = document.querySelectorAll('.carousel-dot');
    const total = items.length;
    
    let activeIndex = 0;
    let isAnimating = false;
    let startX = 0;
    let isDragging = false;
    let autoPlayInterval;

    // --- LOGIKA INFINITE ---
    function getRelativePosition(index, active) {
        let diff = index - active;
        // Penyesuaian agar melingkar (Infinite)
        if (diff > total / 2) diff -= total;
        if (diff < -total / 2) diff += total;
        return diff;
    }

    function updateCarousel(instant = false) {
        const isMobile = window.innerWidth < 768;

        items.forEach((item, i) => {
            const pos = getRelativePosition(i, activeIndex);
            
            // Set transisi (instan jika resize/load awal)
            item.style.transition = instant ? 'none' : 'all 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
            
            if (isMobile) {
                // Tampilan Mobile (Slide Sederhana)
                const xOffset = pos * 100; 
                const scale = pos === 0 ? 1 : 0.85;
                const opacity = pos === 0 ? 1 : 0.4;
                
                item.style.width = "85vw";
                item.style.height = "320px";
                item.style.zIndex = pos === 0 ? 20 : 10;
                item.style.opacity = Math.abs(pos) > 1 ? 0 : opacity;
                item.style.transform = `translateX(${xOffset}%) scale(${scale})`;
            } else {
                // Tampilan Desktop (3D Depth)
                let xTranslate = pos * 350;
                let scale = 1 - Math.abs(pos) * 0.2;
                let opacity = 1 - Math.abs(pos) * 0.6;
                let zIndex = 20 - Math.abs(pos);

                item.style.width = "500px";
                item.style.height = "380px";
                item.style.zIndex = zIndex;
                item.style.opacity = Math.abs(pos) > 1 ? 0 : opacity;
                item.style.transform = `translateX(${xTranslate}px) scale(${scale})`;
            }
            
            // Hanya item tengah yang bisa diklik
            item.style.pointerEvents = pos === 0 ? 'auto' : 'none';
        });

        // Update Dots
        dots.forEach((dot, i) => {
            dot.style.width = i === activeIndex ? '40px' : '10px';
            dot.style.height = '10px';
            dot.style.borderRadius = '5px';
            dot.style.backgroundColor = i === activeIndex ? '#B1252E' : '#D1D5DB';
        });
    }

    // --- NAVIGASI ---
    function nextSlide() {
        if (isAnimating) return;
        isAnimating = true;
        activeIndex = (activeIndex + 1) % total;
        updateCarousel();
        setTimeout(() => isAnimating = false, 600);
    }

    function prevSlide() {
        if (isAnimating) return;
        isAnimating = true;
        activeIndex = (activeIndex - 1 + total) % total;
        updateCarousel();
        setTimeout(() => isAnimating = false, 600);
    }

    // --- FITUR SWIPE (Touch & Mouse) ---
    function handleSwipeStart(e) {
        startX = e.type.includes('mouse') ? e.pageX : e.touches[0].pageX;
        isDragging = true;
    }

    function handleSwipeEnd(e) {
        if (!isDragging) return;
        const endX = e.type.includes('mouse') ? e.pageX : e.changedTouches[0].pageX;
        const threshold = 50;

        if (startX - endX > threshold) nextSlide();
        else if (endX - startX > threshold) prevSlide();
        
        isDragging = false;
    }

    // Mouse Events
    container.addEventListener('mousedown', handleSwipeStart);
    window.addEventListener('mouseup', handleSwipeEnd);

    // Touch Events
    container.addEventListener('touchstart', handleSwipeStart, { passive: true });
    container.addEventListener('touchend', handleSwipeEnd);

    // --- EVENT LISTENERS ---
    document.getElementById('nextBtn')?.addEventListener('click', nextSlide);
    document.getElementById('prevBtn')?.addEventListener('click', prevSlide);
    document.getElementById('nextBtnMobile')?.addEventListener('click', nextSlide);
    document.getElementById('prevBtnMobile')?.addEventListener('click', prevSlide);
    
    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            if (isAnimating) return;
            activeIndex = i;
            updateCarousel();
        });
    });

    // --- AUTO PLAY & UTILS ---
    function startAutoPlay() {
        autoPlayInterval = setInterval(nextSlide, 5000);
    }

    const wrapper = document.querySelector('.carousel-wrapper');
    wrapper?.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
    wrapper?.addEventListener('mouseleave', startAutoPlay);

    window.addEventListener('resize', () => updateCarousel(true));

    // Reveal Animation
    const revealObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // Init
    updateCarousel(true);
    startAutoPlay();
});
</script>