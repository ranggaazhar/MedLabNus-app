<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - PT Medlab Nusantara</title>

    {{-- Tetap load CSS welcome agar Navbar & Footer konsisten --}}
    @vite(['resources/css/welcome.css', 'resources/css/footer.css'])

    <style>
        /* CSS KHUSUS HALAMAN PRODUK (Agar mirip desain referensi) */
        body {
            background-color: #fff;
            font-family: sans-serif; /* Sesuaikan dengan font project Anda */
            color: #333;
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 80px; /* Jarak dari Navbar */
        }

        /* Breadcrumb & Header */
        .page-header {
            margin-bottom: 30px;
        }
        .breadcrumb {
            font-size: 14px;
            color: #888;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .breadcrumb span {
            color: #999;
        }
        
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 20px;
        }
        .result-count {
            color: #888;
            font-size: 14px;
        }

        /* Filter & Search Area kanan */
        .filter-area {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .sort-by {
            font-size: 14px;
            color: #666;
            cursor: pointer;
        }
        .search-box {
            position: relative;
        }
        .search-box input {
            padding: 8px 15px 8px 35px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            color: #666;
            width: 200px;
        }
        .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            opacity: 0.5;
        }

        /* PRODUCT GRID */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .product-card {
            background: #F8F9FA; /* Warna abu-abu sangat muda seperti di gambar */
            border-radius: 10px;
            padding: 30px;
            display: flex;
            flex-direction: column; /* Ubah ke column agar teks di kanan/bawah rapi */
            align-items: flex-start; /* Rata kiri */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            position: relative;
            min-height: 250px;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            background: #fff; /* Jadi putih saat hover biar elegan */
        }

        /* Layout Kartu: Gambar di Kiri/Atas, Teks di Kanan/Bawah */
        .card-content {
            display: flex;
            align-items: center;
            width: 100%;
            gap: 20px;
        }
        
        .card-image {
            width: 120px;
            height: 120px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .card-details {
            flex-grow: 1;
        }

        .product-title {
            font-size: 20px;
            font-weight: 700;
            color: #B1252E; /* Merah Brand */
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        .product-brand {
            font-size: 14px;
            color: #999;
            margin-bottom: 15px;
            display: block;
        }

        .product-desc {
            font-size: 12px;
            color: #555;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* CUSTOM PAGINATION (Kotak-kotak angka) */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
            gap: 10px;
        }
        .page-link {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #eee;
            border-radius: 5px;
            color: #333;
            text-decoration: none;
            transition: 0.2s;
        }
        .page-link.active {
            background-color: #B1252E;
            color: white;
            border-color: #B1252E;
        }
        .page-link:hover:not(.active) {
            background-color: #f0f0f0;
        }

        /* Responsive untuk HP */
        @media (max-width: 768px) {
            .card-content {
                flex-direction: column;
                text-align: center;
            }
            .product-grid {
                grid-template-columns: 1fr;
            }
            .toolbar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    {{-- 1. NAVBAR (Sama Persis dengan Welcome) --}}
    <nav>
        <div class="logo">
            <img src="{{ asset('images/logom.png') }}" alt="Logo" style="width: 50px;">
        </div>

        <ul>
            <li><a href="{{ route('welcome') }}">Home</a></li>
            <li><a href="#">Visi & Misi</a></li>
            <li><a href="{{ route('products.public') }}" class="active-nav">Products</a></li>
        </ul>

        <a href="#" class="nav-shop-btn">
            <img src="{{ asset('icons/shop.svg') }}" class="icon-shop" alt="icon">
            Shop
        </a>
    </nav>

    {{-- 2. MAIN CONTENT (Sesuai Desain Gambar) --}}
    <div class="main-container">
        
        {{-- Header Section --}}
        <div class="page-header">
            <div class="breadcrumb">
                HOME / <span style="color: #333; font-weight: bold;">PRODUCT</span>
            </div>

            <div class="toolbar">
                <div class="result-count">
                    {{-- Menampilkan info "Showing 1-9 of 57 result" --}}
                    Showing {{ $produks->firstItem() ?? 0 }}-{{ $produks->lastItem() ?? 0 }} of {{ $produks->total() }} result
                </div>

                <div class="filter-area">
                    <div class="sort-by">
                        Product by <span style="margin-left:5px;">&gt;</span>
                    </div>
                    <form action="{{ route('products.public') }}" method="GET">
                        <div class="search-box">
                            {{-- Icon Search SVG --}}
                            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Grid Produk --}}
        <div class="product-grid">
            @forelse($produks as $produk)
                <div class="product-card">
                    <div class="card-content">
                        {{-- Gambar Produk --}}
                        <img src="{{ asset('storage/' . $produk->gambar_utama) }}" alt="{{ $produk->nama_produk }}" class="card-image">
                        
                        {{-- Detail Produk --}}
                        <div class="card-details">
                            <h3 class="product-title">{{ $produk->nama_produk }}</h3>
                            <span class="product-brand">{{ $produk->pabrikan->nama_pabrikan ?? 'No Brand' }}</span>
                            
                            {{-- Deskripsi atau Placeholder text jika kosong --}}
                            <p class="product-desc">
                                {{ $produk->deskripsi ?? 'Lorem Ipsum Dolor Sit Amet Consectetur Adipiscing Elit Malesuada Integer Id Diam.' }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                    <p>Tidak ada produk ditemukan.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination Custom --}}
        <div class="pagination-wrapper">
             {{-- Laravel Links (akan menggunakan styling default tailwind jika tidak di customize, 
                  tapi logika di bawah ini meniru gaya kotak-kotak di gambar) --}}
             
             {{-- Tombol Previous --}}
             @if ($produks->onFirstPage())
                <span class="page-link disabled">&lt;</span>
             @else
                <a href="{{ $produks->previousPageUrl() }}" class="page-link">&lt;</a>
             @endif

             {{-- Nomor Halaman (Simple loop) --}}
             @foreach ($produks->getUrlRange(1, $produks->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="page-link {{ $page == $produks->currentPage() ? 'active' : '' }}">
                    {{ $page }}
                </a>
             @endforeach

             {{-- Tombol Next --}}
             @if ($produks->hasMorePages())
                <a href="{{ $produks->nextPageUrl() }}" class="page-link">&gt;</a>
             @else
                <span class="page-link disabled">&gt;</span>
             @endif
        </div>

    </div>

    {{-- 3. FOOTER (Sama seperti Welcome) --}}
    <x-footer />

</body>
</html>