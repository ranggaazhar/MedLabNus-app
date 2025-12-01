<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Medlab Nusantara</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>


    @vite(['resources/css/welcome.css', 'resources/css/footer.css'])
</head>

<body>

    <x-public-navbar active="home" />
    
    <section class="hero">
        <div style="position: absolute; right: 0; top: 0; width: 55%; height: 100%; pointer-events: none; z-index: 0;">
            <svg style="position: absolute; right: -8%; top: 5%; width: 100%; height: 90%;" viewBox="0 0 763 772"
                fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMin slice">
                <path class="animated-svg"
                    d="M1522.02 173.667C1532.65 122.466 1512.32 79.8514 1462.81 49.5997C1413.3 19.3481 1336.14 2.39258 1238.18 0.235254C1140.22 -1.92207 1024.47 10.7853 901.196 37.2318C777.917 63.6783 650.91 103.048 531.427 151.852C411.944 200.657 303.671 257.391 216.2 317.028C128.73 376.666 64.7604 437.366 29.9592 493.752C-4.84212 550.138 -9.40129 600.47 16.6855 640.289C42.7723 680.108 98.6998 708.186 179.514 722.034L274.45 664.033C206.799 652.44 159.98 628.936 138.142 595.602C116.305 562.269 120.121 520.135 149.254 472.933C178.387 425.73 231.937 374.917 305.161 324.993C378.385 275.069 469.022 227.576 569.044 186.72C669.067 145.865 775.387 112.908 878.587 90.7687C981.786 68.6298 1078.68 57.9921 1160.69 59.7981C1242.69 61.604 1307.28 75.7978 1348.72 101.122C1390.17 126.447 1407.2 162.12 1398.29 204.982L1522.02 173.667Z"
                    fill="url(#paint0_linear_0_1)" />
                <path class="animated-svg"
                    d="M1413.58 240.835C1396.64 194.308 1360.85 155.275 1308.67 126.436C1256.5 97.5981 1189.18 79.6431 1111.39 73.8139C1033.6 67.9848 947.186 74.4207 858.132 92.6764C769.079 110.932 679.511 140.572 595.627 179.544C511.743 218.516 435.547 265.89 372.31 318.387C309.074 370.885 260.308 427.253 229.387 483.589C198.466 539.926 186.129 594.887 193.228 644.668C200.328 694.449 226.695 737.861 270.506 771.901L348.395 726.884C310.934 697.777 288.387 660.655 282.316 618.088C276.245 575.52 286.795 528.524 313.235 480.351C339.676 432.178 381.375 383.978 435.448 339.088C489.521 294.198 554.676 253.688 626.404 220.364C698.133 187.039 774.721 161.694 850.87 146.084C927.019 130.474 1000.91 124.971 1067.43 129.955C1133.95 134.94 1191.51 150.293 1236.12 174.952C1280.74 199.612 1311.35 232.989 1325.83 272.773L1413.58 240.835Z"
                    fill="url(#paint1_linear_0_1)" />
                <defs>
                    <linearGradient id="paint0_linear_0_1" x1="816.418" y1="51.1381" x2="438.158" y2="623.663"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#B1252E" />
                        <stop offset="1" stop-color="#4E1519" />
                    </linearGradient>
                    <linearGradient id="paint1_linear_0_1" x1="691.127" y1="140.087" x2="367.384" y2="475.681"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#B1252E" />
                        <stop offset="1" stop-color="#4E1519" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <div class="hero-text">
            <h1>PT Medlab<br>Nusantara</h1>
            <p>Welcome to our Company Profile Website</p>
            <a href="#" class="btn-shop">Shop Now</a>
        </div>

        <div class="hero-image">
            <img src="{{ asset('images/welcome.png') }}" alt="Lab Equipment">
        </div>
    </section>

    <section class="profile-section">
        <div class="profile-container">
            <div class="profile-image-wrapper reveal">
                <img src="{{ asset('images/company.png') }}" alt="Company Profile Activity">
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
                    <img src="{{ asset('images/visi.jpg') }}" alt="Ilustrasi Visi">
                </div>
            </div>

            <div class="vm-row">
                <div class="vm-image-box reveal">
                    <img src="{{ asset('images/misi.jpg') }}" alt="Ilustrasi Misi">
                </div>
                <div class="vm-content reveal delay-200">
                    <div class="accent-line"></div>
                    <h3>Misi</h3>
                    <ol>
                        <li>Selalu berusaha untuk menjadi yang terbaik dalam melakukan sesuatu hal yang berkaitan dengan
                            pelayanan terhadap konsumen.</li>
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

                {{-- LOOPING UNTUK 3 GAMBAR DIMULAI DI SINI --}}
                @php
                    $imagePaths = [
                        'images/collections2.png', // Index 0
                        'images/collections1.png', // Index 1
                        'images/collections3.png', // Index 2
                    ];
                    $activeIndex = 1; // Mengatur indeks aktif ke 1 (gambar kedua)
                @endphp

                @foreach($imagePaths as $index => $path)
                    <div class="gallery-item {{ $index === $activeIndex ? 'active' : '' }}">
                        {{-- Mengambil foto dari folder public/ berdasarkan path yang ditentukan --}}
                        <img src="{{ asset($path) }}" alt="Product Collection Image {{ $index + 1 }}">
                    </div>
                @endforeach
                {{-- LOOPING 3 GAMBAR SELESAI --}}

            </div>
        </div>

        {{-- DOTS SEKARANG DIBUAT SECARA DINAMIS OLEH JAVASCRIPT --}}
        <div class="gallery-dots reveal">
            {{-- Dots akan diisi oleh fungsi createDots() di JS --}}
        </div>

        <div class="product-features">

            <div class="feature-block">
                <div class="feature-info reveal">
                    <h3>ALAT</h3>
                    <p>Peralatan medis berkualitas tinggi yang dirancang untuk mendukung proses pemeriksaan agar lebih
                        akurat dan efisien.</p>
                    <a href="#" class="btn-product">
                        View more <span class="arrow">&gt;</span>
                    </a>
                </div>
                <div class="feature-card-wrapper reveal delay-200">
                    <div class="product-card">

                        @if(isset($produks) && $produks->count() > 0)
                            <img src="{{ asset('storage/' . $produks->first()->gambar_utama) }}"
                                alt="{{ $produks->first()->nama_produk ?? 'Alat Medis' }}">
                        @else
                            {{-- Fallback image jika koleksi $produks kosong --}}
                            <img src="{{ asset('images/default-alat.png') }}" alt="Default Alat Medis">
                        @endif
                    </div>
                </div>
            </div>

            <div class="feature-block">
                {{-- Memastikan urutan terbalik di desktop (gambar di kiri, info di kanan) --}}
                <div class="feature-card-wrapper reveal">
                    <div class="product-card">

                        @php
                            // 1. Filter koleksi $produks untuk mencari item dengan kategori 'Reagen'.
                            // 2. Ambil produk pertama yang ditemukan.
                            $reagen_utama = (isset($produks) && $produks->count() > 0)
                                ? $produks->where('kategori', 'reagen')->first()
                                : null;
                        @endphp

                        @if ($reagen_utama)
                            {{-- Tampilkan gambar dari database jika produk Reagen ditemukan --}}
                            <img src="{{ asset('storage/' . $reagen_utama->gambar_utama) }}"
                                alt="{{ $reagen_utama->nama_produk ?? 'Reagen Medis' }}">
                        @else
                            {{-- Fallback image jika koleksi kosong atau tidak ada produk Reagen --}}
                            <img src="{{ asset('images/default-reagen.png') }}" alt="Default Reagen Medis">
                        @endif
                    </div>
                </div>

                <div class="feature-info reveal delay-200">
                    <h3>REAGEN</h3>
                    <p>Reagen berkualitas tinggi untuk memastikan hasil pengujian yang konsisten dan dapat diandalkan.
                    </p>
                    <a href="#" class="btn-product">
                        View more <span class="arrow">&gt;</span>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <x-footer />
    {{-- 1. MEMUAT LIBRARY EKSTERNAL (GSAP) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    {{-- 2. MEMUAT FILE JAVASCRIPT LOKAL BARU ANDA DENGAN VITE --}}
    {{-- PASTIKAN ANDA SUDAH MENAMBAHKAN FILE slider.js KE DALAM vite.config.js --}}
    @vite(['resources/js/slider.js'])


</body>

</html>