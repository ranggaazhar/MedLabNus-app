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
    </style>
</head>
<body class="min-h-screen bg-white" x-data="productApp()" x-cloak>

    {{-- Navbar --}}
    <x-public-navbar :active="'products'" />
    
    {{-- Main Content - Full Width --}}
    <main class="w-full px-6 lg:px-12 pt-32 pb-16">
        
        {{-- Breadcrumb --}}
        <div class="mb-10">
            <p class="text-xs tracking-widest text-gray-500">
                <a href="{{ route('welcome') }}" class="hover:text-[#B1252E] transition-colors">HOME</a> / <span class="text-[#B1252E] font-semibold">PRODUCT</span>
            </p>
        </div>

        {{-- Toolbar --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-12 pb-6 border-b border-gray-200">
            <div class="text-gray-600">
                <span x-text="`Showing ${filteredProducts.length > 0 ? startIndex + 1 : 0}-${Math.min(endIndex, filteredProducts.length)} of ${filteredProducts.length} result${filteredProducts.length !== 1 ? 's' : ''}`"></span>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                {{-- Category Filter Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button 
                        @click="open = !open"
                        class="flex items-center gap-2 text-gray-600 text-sm cursor-pointer hover:text-[#B1252E] transition-colors"
                    >
                        Product by <span x-show="!open">></span><span x-show="open">∨</span>
                    </button>
                    
                    <div 
                        x-show="open"
                        @click.outside="open = false"
                        x-transition
                        class="absolute top-full left-0 mt-2 w-40 bg-white border border-gray-300 rounded-lg shadow-lg z-10"
                    >
                        <button 
                            @click="filterCategory = 'semua'; open = false; currentPage = 1"
                            :class="filterCategory === 'semua' ? 'bg-[#B1252E] text-white' : 'text-gray-700 hover:bg-gray-50'"
                            class="w-full text-left px-4 py-2.5 text-sm transition-colors first:rounded-t-lg"
                        >
                            Semua
                        </button>
                        <button 
                            @click="filterCategory = 'alat'; open = false; currentPage = 1"
                            :class="filterCategory === 'alat' ? 'bg-[#B1252E] text-white' : 'text-gray-700 hover:bg-gray-50'"
                            class="w-full text-left px-4 py-2.5 text-sm transition-colors border-t border-gray-200"
                        >
                            Alat
                        </button>
                        <button 
                            @click="filterCategory = 'reagen'; open = false; currentPage = 1"
                            :class="filterCategory === 'reagen' ? 'bg-[#B1252E] text-white' : 'text-gray-700 hover:bg-gray-50'"
                            class="w-full text-left px-4 py-2.5 text-sm transition-colors border-t border-gray-200 last:rounded-b-lg"
                        >
                            Reagen
                        </button>
                    </div>
                </div>
                
                {{-- Search Box --}}
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input 
                        type="text" 
                        x-model="searchQuery"
                        @input="handleSearch()"
                        placeholder="Search products..." 
                        class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg outline-none focus:border-[#B1252E] transition-colors w-full sm:w-60 text-sm text-gray-700"
                    />
                </div>
            </div>
        </div>

        {{-- Product Grid - Responsive & Full Width --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-8 mb-16">
            <template x-if="currentProducts.length === 0">
                <div class="col-span-full text-center py-20">
                    <p class="text-gray-400">Tidak ada produk ditemukan.</p>
                </div>
            </template>

            <template x-for="product in currentProducts" :key="product.id">
                <div class="bg-[#F8F9FA] rounded-2xl p-7 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:bg-white hover:border-2 hover:border-[#B1252E] cursor-pointer group h-full min-h-[220px] border-2 border-transparent flex flex-col relative">
                    {{-- Category Badge (Top Right) --}}
                    <span 
                        :class="product.kategori === 'alat' 
                            ? 'bg-blue-100 text-blue-700' 
                            : 'bg-green-100 text-green-700'"
                        class="absolute top-4 right-4 inline-block px-3 py-1 rounded-full text-xs font-semibold"
                        x-text="product.kategori === 'alat' ? 'Alat' : product.kategori === 'reagen' ? 'Reagen' : 'Produk'"
                    ></span>

                    <div class="flex items-center gap-6 flex-1">
                        {{-- Product Image --}}
                        <div class="flex-shrink-0 w-24 h-24">
                            <img :src="product.image" :alt="product.name" class="w-full h-full object-contain" />
                        </div>

                        {{-- Product Details --}}
                        <div class="flex-1 flex flex-col justify-center gap-1.5">
                            <h3 class="text-[#B1252E] font-bold text-lg tracking-wide uppercase leading-tight" x-text="product.name"></h3>
                            
                            <span class="text-[#AAAAAA] text-[11px] font-medium tracking-widest uppercase" x-text="product.brand"></span>
                            
                            <p class="text-gray-600 text-xs leading-relaxed mt-2 line-clamp-3" x-text="product.description"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Pagination --}}
        <div x-show="totalPages > 1" class="flex justify-center items-center gap-2 mt-16">
            {{-- Previous Button --}}
            <button 
                @click="changePage(currentPage - 1)"
                :disabled="currentPage === 1"
                class="w-11 h-11 flex items-center justify-center border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 hover:border-[#B1252E] hover:text-[#B1252E] transition-all disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:border-gray-300 disabled:hover:text-gray-600"
            >
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>

            {{-- Page Numbers --}}
            <template x-for="page in totalPages" :key="page">
                <button 
                    @click="changePage(page)"
                    :class="page === currentPage 
                        ? 'bg-[#B1252E] text-white border-[#B1252E]' 
                        : 'border-gray-300 text-gray-600 hover:bg-gray-50 hover:border-[#B1252E] hover:text-[#B1252E]'"
                    class="w-11 h-11 flex items-center justify-center border rounded-lg font-medium transition-all"
                    x-text="page"
                ></button>
            </template>

            {{-- Next Button --}}
            <button 
                @click="changePage(currentPage + 1)"
                :disabled="currentPage === totalPages"
                class="w-11 h-11 flex items-center justify-center border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 hover:border-[#B1252E] hover:text-[#B1252E] transition-all disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:border-gray-300 disabled:hover:text-gray-600"
            >
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

                // Reset ke halaman 1 saat search
                handleSearch() {
                    this.currentPage = 1;
                },

                // Pindah halaman
                changePage(page) {
                    if (page >= 1 && page <= this.totalPages) {
                        this.currentPage = page;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                }
            }
        }
    </script>

</body>
</html>