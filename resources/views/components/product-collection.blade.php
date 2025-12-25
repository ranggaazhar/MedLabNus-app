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

        {{-- Section Kategori (Contoh ALAT & REAGEN) --}}
        <div class="max-w-[1800px] mx-auto space-y-16">
            {{-- Alat --}}
            <div class="grid lg:grid-cols-5 gap-16 items-center reveal">
                <div class="space-y-6 lg:col-span-3 lg:text-left text-center">
                    <div class="flex items-center lg:justify-start justify-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#B1252E] to-[#8f1d24] rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><polyline points="14 2 14 8 20 8" /><line x1="12" y1="18" x2="12" y2="12" /><line x1="9" y1="15" x2="15" y2="15" />
                            </svg>
                        </div>
                        <h3 class="text-4xl font-semibold text-gray-900">ALAT</h3>
                    </div>
                    <div class="h-1 w-16 bg-gradient-to-r from-[#B1252E] to-[#8f1d24] rounded-full mx-auto lg:mx-0"></div>
                    <p class="text-xl text-gray-600">Peralatan medis berkualitas tinggi untuk hasil pemeriksaan yang akurat.</p>
                    <a href="#" class="inline-flex items-center gap-2 text-[#B1252E] hover:translate-x-2 transition-transform">&gt; View more</a>
                </div>
                <div class="lg:col-span-2 h-[300px] lg:h-[400px] bg-gray-100 rounded-3xl overflow-hidden shadow-xl">
                    <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=800" class="w-full h-full object-cover" alt="Alat">
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