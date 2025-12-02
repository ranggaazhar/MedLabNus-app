<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - PT Medlab Nusantara</title>
    
    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Alpine.js for interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Fade In Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Pulse Animation for Loading */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        /* Scale In Animation */
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        /* Slide Down Animation */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
        
        .animate-scale-in {
            animation: scaleIn 0.4s ease-out forwards;
        }
        
        .animate-slide-down {
            animation: slideDown 0.3s ease-out forwards;
        }
        
        /* Stagger delay for cards */
        .stagger-1 { animation-delay: 0.05s; }
        .stagger-2 { animation-delay: 0.1s; }
        .stagger-3 { animation-delay: 0.15s; }
        .stagger-4 { animation-delay: 0.2s; }
        .stagger-5 { animation-delay: 0.25s; }
        .stagger-6 { animation-delay: 0.3s; }
        .stagger-7 { animation-delay: 0.35s; }
        .stagger-8 { animation-delay: 0.4s; }
        .stagger-9 { animation-delay: 0.45s; }
        .stagger-10 { animation-delay: 0.5s; }
        .stagger-11 { animation-delay: 0.55s; }
        .stagger-12 { animation-delay: 0.6s; }
        .stagger-13 { animation-delay: 0.65s; }
        .stagger-14 { animation-delay: 0.7s; }
        .stagger-15 { animation-delay: 0.75s; }
        
        /* Loading Animation */
        .loading-pulse {
            animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Smooth opacity transition */
        .opacity-transition {
            transition: opacity 0.3s ease-in-out;
        }
        
        /* Badge Animation */
        @keyframes badgePop {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .badge-pop {
            animation: badgePop 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }
        
        /* Image Zoom on Hover */
        .product-image-container {
            overflow: hidden;
        }
        
        .product-image {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .product-card:hover .product-image {
            transform: scale(1.1) rotate(2deg);
        }
        
        /* Shine Effect on Hover */
        .shine-effect {
            position: relative;
            overflow: hidden;
        }
        
        .shine-effect::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent 30%,
                rgba(255, 255, 255, 0.1) 50%,
                transparent 70%
            );
            transform: translateX(-100%) translateY(-100%) rotate(45deg);
            transition: transform 0.6s;
        }
        
        .shine-effect:hover::before {
            transform: translateX(100%) translateY(100%) rotate(45deg);
        }
        
        /* Button Ripple Effect */
        .btn-ripple {
            position: relative;
            overflow: hidden;
        }
        
        .btn-ripple::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-ripple:active::after {
            width: 300px;
            height: 300px;
        }
    </style>
</head>
<body class="min-h-screen bg-white" x-data="productApp()" x-cloak>

    {{-- Navbar --}}
    <x-public-navbar active="" />
    
    {{-- Main Content - Full Width --}}
    <main class="w-full px-6 lg:px-12 pt-32 pb-16">
        
        {{-- Breadcrumb with Fade In --}}
        <div class="mb-10 animate-fade-in">
            <p class="text-xs tracking-widest text-gray-500">
                <a href="{{ route('welcome') }}" class="hover:text-[#B1252E] transition-colors">HOME</a> / <span class="text-[#B1252E] font-semibold">PRODUCT</span>
            </p>
        </div>

        {{-- Toolbar with Fade In --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-12 pb-6 border-b border-gray-200 animate-fade-in-up relative z-30">
            <div class="text-gray-600">
                <span x-text="`Showing ${filteredProducts.length > 0 ? startIndex + 1 : 0}-${Math.min(endIndex, filteredProducts.length)} of ${filteredProducts.length} result${filteredProducts.length !== 1 ? 's' : ''}`"></span>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 relative z-40">
                {{-- Category Filter Dropdown --}}
                <div class="relative z-50" x-data="{ open: false }">
                    <button 
                        @click="open = !open"
                        class="flex items-center gap-2 text-gray-600 text-sm cursor-pointer hover:text-[#B1252E] transition-all duration-300 hover:scale-105"
                    >
                        Product by <span x-show="!open" class="transition-transform duration-200">></span><span x-show="open" class="transition-transform duration-200">∨</span>
                    </button>
                    
                    <div 
                        x-show="open"
                        @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                        x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute top-full left-0 mt-2 w-40 bg-white border border-gray-300 rounded-lg shadow-2xl z-[9999] animate-slide-down"
                        style="position: absolute !important;"
                    >
                        <button 
                            @click="filterCategory = 'semua'; open = false; currentPage = 1"
                            :class="filterCategory === 'semua' ? 'bg-[#B1252E] text-white' : 'text-gray-700 hover:bg-gray-50'"
                            class="w-full text-left px-4 py-2.5 text-sm transition-all duration-200 first:rounded-t-lg hover:pl-5"
                        >
                            Semua
                        </button>
                        <button 
                            @click="filterCategory = 'alat'; open = false; currentPage = 1"
                            :class="filterCategory === 'alat' ? 'bg-[#B1252E] text-white' : 'text-gray-700 hover:bg-gray-50'"
                            class="w-full text-left px-4 py-2.5 text-sm transition-all duration-200 border-t border-gray-200 hover:pl-5"
                        >
                            Alat
                        </button>
                        <button 
                            @click="filterCategory = 'reagen'; open = false; currentPage = 1"
                            :class="filterCategory === 'reagen' ? 'bg-[#B1252E] text-white' : 'text-gray-700 hover:bg-gray-50'"
                            class="w-full text-left px-4 py-2.5 text-sm transition-all duration-200 border-t border-gray-200 last:rounded-b-lg hover:pl-5"
                        >
                            Reagen
                        </button>
                    </div>
                </div>
                
                {{-- Search Box with Animation --}}
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 transition-transform duration-300" 
                         :class="searchQuery ? 'scale-110' : ''"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input 
                        type="text" 
                        x-model="searchQuery"
                        @input="handleSearch()"
                        placeholder="Search products..." 
                        class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg outline-none focus:border-[#B1252E] focus:shadow-lg transition-all duration-300 w-full sm:w-60 text-sm text-gray-700 focus:scale-105"
                    />
                </div>
            </div>
        </div>

        {{-- Loading Indicator --}}
        <div x-show="isLoading" class="flex justify-center items-center py-20">
            <div class="flex gap-2">
                <div class="w-3 h-3 bg-[#B1252E] rounded-full loading-pulse"></div>
                <div class="w-3 h-3 bg-[#B1252E] rounded-full loading-pulse" style="animation-delay: 0.2s;"></div>
                <div class="w-3 h-3 bg-[#B1252E] rounded-full loading-pulse" style="animation-delay: 0.4s;"></div>
            </div>
        </div>

        {{-- Product Grid - Responsive & Full Width --}}
        <div x-show="!isLoading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-8 mb-16 opacity-transition">
            <template x-if="currentProducts.length === 0">
                <div class="col-span-full text-center py-20 animate-fade-in">
                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-400 text-lg">Tidak ada produk ditemukan.</p>
                </div>
            </template>

            <template x-for="(product, index) in currentProducts" :key="product.id">
                <a 
                    :href="`/products/${product.id}`" 
                    class="product-card bg-[#F8F9FA] rounded-2xl p-7 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:bg-white hover:border-2 hover:border-[#B1252E] cursor-pointer group h-full min-h-[220px] border-2 border-transparent flex flex-col relative shine-effect animate-scale-in opacity-0"
                    :class="`stagger-${(index % 15) + 1}`"
                    x-intersect="$el.style.opacity = '1'"
                >
                    {{-- Category Badge (Top Right) with Pop Animation --}}
                    <span 
                        :class="product.kategori === 'alat' 
                            ? 'bg-blue-100 text-blue-700' 
                            : 'bg-green-100 text-green-700'"
                        class="absolute top-4 right-4 inline-block px-3 py-1 rounded-full text-xs font-semibold badge-pop transform transition-all duration-300 group-hover:scale-110"
                        x-text="product.kategori === 'alat' ? 'Alat' : product.kategori === 'reagen' ? 'Reagen' : 'Produk'"
                    ></span>

                    <div class="flex items-center gap-6 flex-1">
                        {{-- Product Image with Zoom Effect --}}
                        <div class="flex-shrink-0 w-24 h-24 product-image-container rounded-lg">
                            <img :src="product.image" :alt="product.name" class="product-image w-full h-full object-contain" />
                        </div>

                        {{-- Product Details --}}
                        <div class="flex-1 flex flex-col justify-center gap-1.5">
                            <h3 class="text-[#B1252E] font-bold text-lg tracking-wide uppercase leading-tight transition-all duration-300 group-hover:text-[#8B1820]" x-text="product.name"></h3>
                            
                            <span class="text-[#AAAAAA] text-[11px] font-medium tracking-widest uppercase transition-colors duration-300 group-hover:text-gray-600" x-text="product.brand"></span>
                            
                            <p class="text-gray-600 text-xs leading-relaxed mt-2 line-clamp-3 transition-colors duration-300 group-hover:text-gray-700" x-text="product.description"></p>
                        </div>
                    </div>
                    
                    {{-- Hover Arrow Indicator --}}
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-2 group-hover:translate-x-0">
                        <svg class="w-5 h-5 text-[#B1252E]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>
            </template>
        </div>

        {{-- Pagination with Animations --}}
        <div x-show="totalPages > 1 && !isLoading" class="flex justify-center items-center gap-2 mt-16 animate-fade-in">
            {{-- Previous Button --}}
            <button 
                @click="changePage(currentPage - 1)"
                :disabled="currentPage === 1"
                class="btn-ripple w-11 h-11 flex items-center justify-center border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 hover:border-[#B1252E] hover:text-[#B1252E] transition-all duration-300 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:border-gray-300 disabled:hover:text-gray-600 hover:scale-110 active:scale-95"
            >
                <svg class="w-4 h-4 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>

            {{-- Page Numbers --}}
            <template x-for="page in totalPages" :key="page">
                <button 
                    @click="changePage(page)"
                    :class="page === currentPage 
                        ? 'bg-[#B1252E] text-white border-[#B1252E] scale-110' 
                        : 'border-gray-300 text-gray-600 hover:bg-gray-50 hover:border-[#B1252E] hover:text-[#B1252E]'"
                    class="btn-ripple w-11 h-11 flex items-center justify-center border rounded-lg font-medium transition-all duration-300 hover:scale-110 active:scale-95"
                    x-text="page"
                ></button>
            </template>

            {{-- Next Button --}}
            <button 
                @click="changePage(currentPage + 1)"
                :disabled="currentPage === totalPages"
                class="btn-ripple w-11 h-11 flex items-center justify-center border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 hover:border-[#B1252E] hover:text-[#B1252E] transition-all duration-300 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:border-gray-300 disabled:hover:text-gray-600 hover:scale-110 active:scale-95"
            >
                <svg class="w-4 h-4 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>

    </main>

    {{-- Footer --}}
    <x-footer />

    <script>
        function productApp() {
            return {
                // Data produk dari server (sudah di-transform di controller)
                allProducts: @json($productsJson),
                searchQuery: '',
                filterCategory: 'semua',
                currentPage: 1,
                itemsPerPage: 15,
                isLoading: false,

                // Filter produk berdasarkan search query dan kategori
                get filteredProducts() {
                    let filtered = this.allProducts;
                    
                    // Filter berdasarkan kategori
                    if (this.filterCategory !== 'semua') {
                        filtered = filtered.filter(product => {
                            // Jika kategori tidak ada di data produk, tampilkan semua
                            return !product.kategori || product.kategori === this.filterCategory;
                        });
                    }
                    
                    // Filter berdasarkan search query
                    if (this.searchQuery) {
                        const query = this.searchQuery.toLowerCase();
                        filtered = filtered.filter(product => 
                            product.name.toLowerCase().includes(query) ||
                            product.brand.toLowerCase().includes(query) ||
                            product.description.toLowerCase().includes(query)
                        );
                    }
                    
                    return filtered;
                },

                // Hitung total halaman berdasarkan produk yang sudah difilter
                get totalPages() {
                    return Math.ceil(this.filteredProducts.length / this.itemsPerPage);
                },

                // Index awal untuk slice
                get startIndex() {
                    return (this.currentPage - 1) * this.itemsPerPage;
                },

                // Index akhir untuk slice
                get endIndex() {
                    return this.startIndex + this.itemsPerPage;
                },

                // Produk yang ditampilkan di halaman saat ini
                get currentProducts() {
                    return this.filteredProducts.slice(this.startIndex, this.endIndex);
                },

                // Reset ke halaman 1 saat search dengan loading effect
                handleSearch() {
                    this.isLoading = true;
                    this.currentPage = 1;
                    
                    setTimeout(() => {
                        this.isLoading = false;
                    }, 300);
                },

                // Pindah halaman dengan loading effect
                changePage(page) {
                    if (page >= 1 && page <= this.totalPages) {
                        this.isLoading = true;
                        
                        setTimeout(() => {
                            this.currentPage = page;
                            this.isLoading = false;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }, 200);
                    }
                }
            }
        }
    </script>

</body>
</html>