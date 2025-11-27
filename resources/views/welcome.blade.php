<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Medlab Nusantara</title>

    @vite(['resources/css/welcome.css', 'resources/css/footer.css'])
</head>
<body>

    <nav>
        <div class="logo">
            <img src="{{ asset('images/logom.png') }}" alt="Logo" style="width: 50px;">
        </div>

        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Visi & Misi</a></li>
            <li><a href="#">Products</a></li>
        </ul>

        <a href="#" class="nav-shop-btn">
            <img src="{{ asset('icons/shop.svg') }}" class="icon-shop" alt="icon">
            Shop
        </a>
    </nav>

    <section class="hero">
        <div class="hero-text">
            <h1>PT Medlab<br>Nusantara</h1>
            <p>Welcome to our Company Profile Website</p>
            <a href="#" class="btn-shop">Shop Now</a>
        </div>

        <div class="hero-image">
            <img src="{{ asset('images/alatw.png') }}" alt="Lab Equipment">
        </div>
    </section>

    <section class="profile-section">
        <div class="profile-container">
            <div class="profile-image-wrapper reveal">
                <img src="{{ asset('images/alatw.png') }}" alt="Company Profile Activity">
            </div>

            <div class="profile-text reveal delay-200">
                <h2>Company<br>Profile</h2>
                <p>
                    PT Medlab Nusantara hadir untuk mendukung kebutuhan fasilitas kesehatan, 
                    laboratorium, dan institusi medis dengan menyediakan produk yang terpercaya, 
                    aman, dan sesuai standar nasional maupun internasional.
                </p>
                <p>
                    Dengan komitmen pada inovasi dan pelayanan profesional, kami memastikan 
                    setiap pelanggan mendapatkan solusi kesehatan terbaik untuk meningkatkan 
                    kualitas diagnosa dan layanan medis.
                </p>
            </div>
        </div>
    </section>

    <section class="visi-misi-section">
        <h2 class="section-title reveal">Visi & Misi</h2>

        <div class="visi-misi-container">
            
            <div class="vm-row">
                <div class="vm-content reveal">
                    <div class="accent-line"></div> 
                    <h3>Visi</h3>
                    <p>
                        Membantu dan Mempermudah Bagi Semua Kalangan Masyarakat 
                        untuk Kebutuhan Alat-Alat Kesehatan, Laboratorium, dan 
                        Kebutuhan Lainnya yang Sesuai dengan Kegiatan Perusahaan Kami.
                    </p>
                </div>
                <div class="vm-image-box reveal delay-200">
                    <img src="{{ asset('images/alatw.png') }}" alt="Ilustrasi Visi">
                </div>
            </div>

            <div class="vm-row">
                <div class="vm-image-box reveal">
                    <img src="{{ asset('images/alatw.png') }}" alt="Ilustrasi Misi">
                </div>
                <div class="vm-content reveal delay-200">
                    <div class="accent-line"></div>
                    <h3>Misi</h3>
                    <ol>
                        <li>Selalu berusaha untuk menjadi yang terbaik dalam melakukan sesuatu hal yang berkaitan dengan pelayanan terhadap konsumen.</li>
                        <li>Memberikan kepuasan dan menjamin mutu dalam penjualan produk sesuai dengan standar SNI.</li>
                        <li>Menjamin kinerja yang profesional dan tepat waktu sesuai keinginan konsumen.</li>
                    </ol>
                </div>
            </div>

        </div>
    </section>

    <section class="delivery-section">
        <div class="delivery-container">
            <div class="delivery-text reveal">
                <h2>
                    Order now <strong>for delivery</strong><br>
                    <strong>throughout Indonesia !</strong>
                </h2>
            </div>
            <div class="delivery-btn-wrapper reveal delay-200">
                <a href="#" class="btn-delivery">
                    View more <span class="arrow">&gt;</span>
                </a>
            </div>
        </div>
    </section>

    <section class="product-section">
        
        <div class="product-header reveal">
            <h2>Product Collection</h2>
            <p>Temukan berbagai produk pilihan dengan kualitas<br>terbaik untuk kebutuhan Anda.</p>
        </div>

        <div class="slider-container reveal delay-200">
            <div class="slider-track" id="sliderTrack">
                
                <div class="gallery-item">
                    <img src="{{ asset('images/alatw.png') }}" alt="Product 1">
                </div>
                
                <div class="gallery-item active">
                    <img src="{{ asset('images/alatw.png') }}" alt="Product 2">
                </div>
                
                <div class="gallery-item">
                    <img src="{{ asset('images/alatw.png') }}" alt="Product 3">
                </div>

            </div>
        </div>

        <div class="gallery-dots reveal">
            <span class="dot" onclick="moveSlide(0)"></span>
            <span class="dot active" onclick="moveSlide(1)"></span>
            <span class="dot" onclick="moveSlide(2)"></span>
        </div>

        <div class="product-features">
            
            <div class="feature-block">
                <div class="feature-info reveal">
                    <h3>ALAT</h3>
                    <p>Peralatan medis berkualitas tinggi yang dirancang untuk mendukung proses pemeriksaan agar lebih akurat dan efisien.</p>
                    <a href="#" class="btn-product">
                        View more <span class="arrow">&gt;</span>
                    </a>
                </div>
                <div class="feature-card-wrapper reveal delay-200">
                    <div class="product-card">
                        <img src="{{ asset('images/alatw.png') }}" alt="Alat Medis">
                    </div>
                </div>
            </div>

            <div class="feature-block">
                <div class="feature-card-wrapper reveal">
                    <div class="product-card">
                        <img src="{{ asset('images/alatw.png') }}" alt="Reagen Medis">
                    </div>
                </div>
                <div class="feature-info reveal delay-200">
                    <h3>REAGEN</h3>
                    <p>Reagen berkualitas tinggi untuk memastikan hasil pengujian yang konsisten dan dapat diandalkan.</p>
                    <a href="#" class="btn-product">
                        View more <span class="arrow">&gt;</span>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <x-footer />

    <script>
        /* --- 1. SLIDER LOGIC --- */
        let currentIndex = 1; // Default Tengah
        
        const track = document.getElementById('sliderTrack');
        const items = document.querySelectorAll('.gallery-item');
        const dots = document.querySelectorAll('.dot');
        const container = document.querySelector('.slider-container');

        function updateSlider() {
            // Ambil ukuran real-time
            const containerWidth = container.offsetWidth;
            const itemWidth = items[0].offsetWidth;
            
            // Baca Gap dari CSS
            const style = window.getComputedStyle(track);
            const gap = parseFloat(style.gap) || 20; 
            
            // Kalkulasi posisi geser
            const itemPosition = currentIndex * (itemWidth + gap);
            const centerOffset = (containerWidth / 2) - (itemWidth / 2);
            const moveAmount = -(itemPosition - centerOffset);
            
            // Terapkan geseran
            track.style.transform = `translateX(${moveAmount}px)`;

            // Update Class Active (Gambar)
            items.forEach(item => item.classList.remove('active'));
            if(items[currentIndex]) {
                items[currentIndex].classList.add('active');
            }

            // Update Class Active (Dots)
            dots.forEach(dot => dot.classList.remove('active'));
            if(dots[currentIndex]) {
                dots[currentIndex].classList.add('active');
            }
        }

        function moveSlide(index) {
            currentIndex = index;
            updateSlider();
        }

        /* --- 2. SCROLL ANIMATION LOGIC (INTERSECTION OBSERVER) --- */
        window.addEventListener('load', () => { 
            // Init Slider
            setTimeout(updateSlider, 100); 

            // Init Animation
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
        });

        window.addEventListener('resize', updateSlider);
    </script>

</body>
</html>