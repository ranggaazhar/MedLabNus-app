{{-- resources/views/components/sections/product-collection.blade.php --}}
@props(['produks' => collect([])])

<style>
    .carousel-container {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        perspective: 1200px;
        overflow: visible;
        touch-action: pan-y;
        width: 100%;
        /* Tinggi dinamis akan diatur oleh JS */
    }

    .carousel-item {
        position: absolute;
        will-change: transform, opacity;
        user-select: none;
        display: flex;
        align-items: center;
        justify-content: center;
        /* Force reset gaya dari app.css */
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        margin: auto !important;
        background: transparent;
    }

    .carousel-item img {
        width: 100%;
        height: 100%;
        /* 'contain' memastikan seluruh gambar terlihat tanpa terpotong */
        object-fit: contain !important;
        filter: drop-shadow(0 10px 20px rgba(0,0,0,0.1));
    }

    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease-out;
    }

    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    .carousel-dot {
        cursor: pointer;
        border: none;
        outline: none;
    }
</style>

<section id="product-section" class="product-section w-full py-24 bg-gradient-to-br from-gray-50 to-white overflow-hidden">
    <div class="w-full px-6 lg:px-12 xl:px-20">
        <div class="product-header text-center mb-16 reveal">
            <h2 class="text-5xl lg:text-6xl text-gray-900 mb-4 font-bold">Product Collection</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Temukan berbagai produk pilihan dengan kualitas terbaik untuk kebutuhan Anda.
            </p>
        </div>

        <div class="carousel-wrapper relative mb-16 max-w-[1800px] mx-auto reveal">
            <div class="flex items-center justify-center gap-8 lg:gap-16">
                <button id="prevBtn" class="hidden md:flex items-center justify-center w-14 h-14 bg-white rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-110 active:scale-90 z-30">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <div class="carousel-container relative flex-1 max-w-5xl">
                    @php
                        $carouselImages = [
                            asset('images/collections1.png'),
                            asset('images/collections2.png'),
                            asset('images/collections4.png'),
                        ];
                    @endphp

                    @foreach($carouselImages as $index => $path)
                        <div class="carousel-item cursor-grab active:cursor-grabbing" data-index="{{ $index }}">
                            <img src="{{ $path }}" alt="Product {{ $index + 1 }}" class="pointer-events-none">
                        </div>
                    @endforeach
                </div>

                <button id="nextBtn" class="hidden md:flex items-center justify-center w-14 h-14 bg-white rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-110 active:scale-90 z-30">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <div class="flex md:hidden items-center justify-center gap-6 mt-8">
                <button id="prevBtnMobile" class="p-3 bg-white rounded-full shadow-lg active:scale-90 transition-transform">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextBtnMobile" class="p-3 bg-white rounded-full shadow-lg active:scale-90 transition-transform">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

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
                               <rect x="3" y="4" width="18" height="14" rx="2" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M7 8h4M7 12h2M15 8h2v6h-2z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M3 14h18" stroke="currentColor" stroke-width="1.8"/>
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
<path d="M9 3h6v3a4 4 0 0 1-4 4 4 4 0 0 1-4-4V3z" fill="none" stroke="currentColor" stroke-width="1.8"/><rect x="7" y="10" width="10" height="10" rx="1" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 14v2M12 14c-.5 0-1 .5-1 1s.5 1 1 1" stroke="currentColor" stroke-width="1.2"/>
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
                                <rect x="3" y="14" width="18" height="6" rx="1" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M6 14V7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v7" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M10 10h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
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
                                <path d="M9 3h6M10 3v13a3 3 0 0 0 6 0V3M10 8h6M10 12h6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
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

    function getRelativePosition(index, active) {
        let diff = index - active;
        if (diff > total / 2) diff -= total;
        if (diff < -total / 2) diff += total;
        return diff;
    }

    function updateCarousel(instant = false) {
        const isMobile = window.innerWidth < 768;

        items.forEach((item, i) => {
            const pos = getRelativePosition(i, activeIndex);
            item.style.transition = instant ? 'none' : 'all 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
            
            if (isMobile) {
                container.style.height = "320px";
                const xOffset = pos * 65; // Persentase geser slide belakang
                const scale = pos === 0 ? 1 : 0.75;
                const opacity = pos === 0 ? 1 : (Math.abs(pos) > 1 ? 0 : 0.4);
                
                item.style.width = "85vw";
                item.style.height = "250px";
                item.style.zIndex = 20 - Math.abs(pos);
                item.style.opacity = opacity;
                item.style.transform = `translate3d(${xOffset}%, 0, 0) scale(${scale})`;
            } else {
                container.style.height = "450px";
                const xTranslate = pos * 350;
                const scale = 1 - Math.abs(pos) * 0.2;
                const opacity = 1 - Math.abs(pos) * 0.6;
                
                item.style.width = "500px";
                item.style.height = "380px";
                item.style.zIndex = 20 - Math.abs(pos);
                item.style.opacity = Math.abs(pos) > 1 ? 0 : opacity;
                item.style.transform = `translate3d(${xTranslate}px, 0, 0) scale(${scale})`;
            }
            item.style.pointerEvents = pos === 0 ? 'auto' : 'none';
        });

        dots.forEach((dot, i) => {
            dot.style.width = i === activeIndex ? '32px' : '10px';
            dot.style.height = '10px';
            dot.style.borderRadius = '5px';
            dot.style.backgroundColor = i === activeIndex ? '#B1252E' : '#D1D5DB';
        });
    }

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

    // Touch/Mouse Events
    container.addEventListener('mousedown', e => { startX = e.pageX; isDragging = true; });
    window.addEventListener('mouseup', e => {
        if (!isDragging) return;
        if (startX - e.pageX > 50) nextSlide();
        else if (e.pageX - startX > 50) prevSlide();
        isDragging = false;
    });

    container.addEventListener('touchstart', e => { startX = e.touches[0].pageX; isDragging = true; }, {passive: true});
    container.addEventListener('touchend', e => {
        if (!isDragging) return;
        const endX = e.changedTouches[0].pageX;
        if (startX - endX > 50) nextSlide();
        else if (endX - startX > 50) prevSlide();
        isDragging = false;
    });

    document.getElementById('nextBtn')?.addEventListener('click', nextSlide);
    document.getElementById('prevBtn')?.addEventListener('click', prevSlide);
    document.getElementById('nextBtnMobile')?.addEventListener('click', nextSlide);
    document.getElementById('prevBtnMobile')?.addEventListener('click', prevSlide);
    
    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => { activeIndex = i; updateCarousel(); });
    });

    window.addEventListener('resize', () => updateCarousel(true));
    updateCarousel(true);

    // AutoPlay
    setInterval(() => { if(!isDragging) nextSlide(); }, 6000);

    // Reveal Logic
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('active'); });
    }, {threshold: 0.1});
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
});
</script>