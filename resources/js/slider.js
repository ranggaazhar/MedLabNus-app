// --- File: resources/js/slider.js ---

/* --- 1. SLIDER LOGIC --- */
// Inisialisasi awal ke indeks 0, karena jumlah produk dinamis
let currentIndex = 1;

// Ambil elemen DOM. Pastikan elemen ini ada di HTML Anda.
const track = document.getElementById('sliderTrack');
const container = document.querySelector('.slider-container');
let items; 
let dotsContainer = document.querySelector('.gallery-dots');

// LOGIKA AUTO-SLIDE
let slideInterval; 
const SLIDE_DURATION = 2000; // 3000 milidetik (3 detik)

// Fungsi untuk membuat DOTS secara dinamis
function createDots() {
    if (!track) return; // Lindungi jika sliderTrack tidak ada
    items = document.querySelectorAll('.gallery-item');
    dotsContainer = document.querySelector('.gallery-dots'); // Ambil ulang dots container
    
    // Bersihkan dots lama
    if (dotsContainer) dotsContainer.innerHTML = '';

    if (items.length === 0 || !dotsContainer) return;

    if (currentIndex >= items.length) {
        currentIndex = 0;
    }

    items.forEach((item, index) => {
        const dot = document.createElement('span');
        dot.classList.add('dot');
        if (index === currentIndex) {
            dot.classList.add('active');
        }
        dot.onclick = function () {
            moveSlide(index);
            resetAutoSlide(); 
        };
        dotsContainer.appendChild(dot);
    });
}

// FUNGSI UTAMA UNTUK MENGGESER SLIDER MENGGUNAKAN GSAP
function updateSlider() {
    items = document.querySelectorAll('.gallery-item');
    if (items.length === 0 || !track || !container) return; 

    const containerWidth = container.offsetWidth;
    const itemWidth = items[0].offsetWidth;
    
    // Baca Gap dari CSS (asumsi tetap)
    const style = window.getComputedStyle(track);
    const gap = parseFloat(style.gap) || 20;

    let itemPosition = 0;
    for (let i = 0; i < currentIndex; i++) {
        itemPosition += (items[i].offsetWidth + gap);
    }

    // Kalkulasi posisi geser untuk menempatkan item saat ini di tengah
    const centerOffset = (containerWidth / 2) - (itemWidth / 2);
    const targetX = -(itemPosition - centerOffset);

    // GUNAKAN GSAP UNTUK ANIMASI TRANSLATE
    if (typeof gsap !== 'undefined') {
        gsap.to(track, {
            x: targetX, 
            duration: 0.3, 
            ease: "power2.out" 
        });
    } else {
        // Fallback jika GSAP gagal dimuat
        track.style.transform = `translateX(${targetX}px)`;
    }

    // Update Class Active (Gambar)
    items.forEach(item => item.classList.remove('active'));
    if (items[currentIndex]) {
        items[currentIndex].classList.add('active');
    }

    // Update Class Active (Dots)
    const dots = document.querySelectorAll('.dot');
    dots.forEach(dot => dot.classList.remove('active'));
    if (dots[currentIndex]) {
        dots[currentIndex].classList.add('active');
    }
}

function moveSlide(index) {
    items = document.querySelectorAll('.gallery-item');
    if (index >= 0 && index < items.length) {
        currentIndex = index;
        updateSlider();
    }
}

// FUNGSI AUTO-SLIDE
function nextSlide() {
    items = document.querySelectorAll('.gallery-item');
    let nextIndex = currentIndex + 1;
    
    if (nextIndex >= items.length) {
        nextIndex = 0;
    }
    moveSlide(nextIndex);
}

function startAutoSlide() {
    clearInterval(slideInterval); 
    slideInterval = setInterval(nextSlide, SLIDE_DURATION); 
}

function stopAutoSlide() {
    clearInterval(slideInterval);
}

function resetAutoSlide() {
    stopAutoSlide();
    startAutoSlide();
}

/* --- LOGIKA HAMBURGER MENU --- */
const hamburger = document.getElementById('hamburgerMenu');
const navLinks = document.getElementById('navLinks');
const body = document.body;

function initHamburger() {
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('open');
            body.classList.toggle('no-scroll'); 
        });
    }
}


/* --- 2. SCROLL ANIMATION LOGIC (INTERSECTION OBSERVER) --- */
function initScrollAnimations() {
    const reveals = document.querySelectorAll('.reveal');
    const revealOnScroll = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, {
        threshold: 0.15,
        rootMargin: "0px 0px -50px 0px"
    });

    reveals.forEach(reveal => revealOnScroll.observe(reveal));
}


/* --- INIT SEMUA FUNGSI (Saat DOM siap) --- */
window.addEventListener('load', () => {
    // Inisialisasi Slider
    createDots();
    setTimeout(() => {
        updateSlider();
        startAutoSlide(); 
    }, 100);

    // Inisialisasi Interaksi
    if (container) {
        container.addEventListener('mouseenter', stopAutoSlide);
        container.addEventListener('mouseleave', startAutoSlide);
    }
    initHamburger();
    initScrollAnimations();

});

// Penanganan Resize Window
window.addEventListener('resize', () => {
    // Slider Logic saat resize
    createDots();
    updateSlider();

    // Hamburger Logic saat resize
    if (window.innerWidth > 768) {
        if (navLinks && navLinks.classList.contains('open')) {
            navLinks.classList.remove('open');
            body.classList.remove('no-scroll');
        }
    }
});