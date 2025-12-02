<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->nama_produk }} - PT Medlab Nusantara</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        /* Keyframe Animations */
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

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

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

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-fade-in-left {
            animation: fadeInLeft 0.8s ease-out forwards;
        }

        .animate-fade-in-right {
            animation: fadeInRight 0.8s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.8s ease-out forwards;
        }

        .delay-100 { animation-delay: 0.1s; opacity: 0; }
        .delay-200 { animation-delay: 0.2s; opacity: 0; }
        .delay-300 { animation-delay: 0.3s; opacity: 0; }
        .delay-400 { animation-delay: 0.4s; opacity: 0; }
        .delay-500 { animation-delay: 0.5s; opacity: 0; }
        .delay-600 { animation-delay: 0.6s; opacity: 0; }
        .delay-700 { animation-delay: 0.7s; opacity: 0; }
        .delay-800 { animation-delay: 0.8s; opacity: 0; }
        .delay-900 { animation-delay: 0.9s; opacity: 0; }
        .delay-1000 { animation-delay: 1s; opacity: 0; }

        /* Image Zoom Effect */
        .image-zoom-container {
            overflow: hidden;
            cursor: zoom-in;
        }

        .image-zoom-container img {
            transition: transform 0.5s ease;
        }

        .image-zoom-container:hover img {
            transform: scale(1.1);
        }

        /* Tab transition */
        .tab-content {
            animation: fadeInUp 0.4s ease-out;
        }
    </style>
</head>
<body class="w-full overflow-x-hidden bg-gray-50" x-data="productDetailApp()">

    {{-- Navbar --}}
    <x-public-navbar :active="'products'" />

    {{-- Main Content --}}
    <main class="w-full pt-32 pb-20 px-6 lg:px-12 xl:px-20">
        <div class="max-w-[1800px] mx-auto">
            
            {{-- Breadcrumb --}}
            <nav class="mb-12 animate-fade-in-up">
                <ol class="flex items-center gap-2 text-sm text-gray-500">
                    <li><a href="{{ route('welcome') }}" class="hover:text-[#B1252E] transition-colors">HOME</a></li>
                    <li>/</li>
                    <li><a href="{{ route('products.public') }}" class="hover:text-[#B1252E] transition-colors">PRODUCT</a></li>
                    <li>/</li>
                    <li class="text-[#B1252E] font-semibold">{{ strtoupper($produk->nama_produk) }}</li>
                </ol>
            </nav>

            {{-- Product Detail Container --}}
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="grid lg:grid-cols-2 gap-0">
                    
                    {{-- Left: Product Image --}}
                    <div class="bg-gradient-to-br from-gray-50 to-white p-8 lg:p-16 flex items-center justify-center animate-fade-in-left delay-200">
                        <div class="w-full max-w-xl">
                            <div class="image-zoom-container rounded-2xl bg-white shadow-lg p-8">
                                <img 
                                    :src="currentImage" 
                                    alt="{{ $produk->nama_produk }}" 
                                    class="w-full h-auto object-contain max-h-[500px]"
                                    x-transition
                                />
                            </div>

                            {{-- Thumbnail Gallery - jika ada gambar tambahan --}}
                            @if($produk->gambar_tambahan)
                                @php
                                    $gambarTambahan = is_string($produk->gambar_tambahan) 
                                        ? json_decode($produk->gambar_tambahan, true) 
                                        : $produk->gambar_tambahan;
                                @endphp
                                
                                @if(is_array($gambarTambahan) && count($gambarTambahan) > 0)
                                <div class="flex gap-4 mt-6 justify-center flex-wrap">
                                    <button 
                                        @click="currentImage = '{{ asset('storage/' . $produk->gambar_utama) }}'"
                                        :class="currentImage === '{{ asset('storage/' . $produk->gambar_utama) }}' ? 'ring-2 ring-[#B1252E]' : 'ring-1 ring-gray-200'"
                                        class="w-20 h-20 rounded-lg overflow-hidden hover:ring-2 hover:ring-[#B1252E] transition-all"
                                    >
                                        <img src="{{ asset('storage/' . $produk->gambar_utama) }}" alt="Main" class="w-full h-full object-cover">
                                    </button>
                                    @foreach($gambarTambahan as $gambar)
                                    <button 
                                        @click="currentImage = '{{ asset('storage/' . $gambar) }}'"
                                        :class="currentImage === '{{ asset('storage/' . $gambar) }}' ? 'ring-2 ring-[#B1252E]' : 'ring-1 ring-gray-200'"
                                        class="w-20 h-20 rounded-lg overflow-hidden hover:ring-2 hover:ring-[#B1252E] transition-all"
                                    >
                                        <img src="{{ asset('storage/' . $gambar) }}" alt="Thumbnail" class="w-full h-full object-cover">
                                    </button>
                                    @endforeach
                                </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- Right: Product Info --}}
                    <div class="p-8 lg:p-16 flex flex-col justify-center animate-fade-in-right delay-300">
                        
                        {{-- Company Logo --}}
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#B1252E] to-[#8f1d24] rounded-xl flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-xl">M</span>
                            </div>
                            <span class="font-bold text-lg text-gray-800">PT Medlab Nusantara</span>
                        </div>

                        {{-- Category Badge --}}
                        <div class="inline-block mb-6 animate-scale-in delay-400">
                            <span class="px-4 py-2 bg-[#B1252E]/10 text-[#B1252E] rounded-full text-sm font-semibold uppercase tracking-wider">
                                {{ $produk->kategori ?? 'Produk' }}
                            </span>
                        </div>

                        {{-- Product Name --}}
                        <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-4 animate-fade-in-up delay-500">
                            {{ $produk->nama_produk }}
                        </h1>

                        {{-- Brand --}}
                        <p class="text-gray-500 text-lg mb-8 animate-fade-in-up delay-600">
                            {{ $produk->pabrikan->nama_pabrikan ?? 'Unknown Brand' }}
                        </p>

                        {{-- Tabs --}}
                        <div class="mb-8 animate-fade-in-up delay-700">
                            <div class="flex gap-6 border-b border-gray-200 mb-6">
                                <button 
                                    @click="activeTab = 'spesifikasi'"
                                    :class="activeTab === 'spesifikasi' ? 'border-[#B1252E] text-[#B1252E]' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                    class="pb-4 px-2 border-b-2 font-semibold transition-all uppercase tracking-wide"
                                >
                                    Spesifikasi
                                </button>
                                <button 
                                    @click="activeTab = 'informasi'"
                                    :class="activeTab === 'informasi' ? 'border-[#B1252E] text-[#B1252E]' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                    class="pb-4 px-2 border-b-2 font-semibold transition-all uppercase tracking-wide"
                                >
                                    Informasi
                                </button>
                            </div>

                            {{-- Tab Content --}}
                            <div class="min-h-[200px]">
                                <div x-show="activeTab === 'spesifikasi'" class="tab-content text-gray-700 leading-relaxed">
                                    {!! $produk->spesifikasi_formatted !!}
                                </div>

                                <div x-show="activeTab === 'informasi'" x-cloak class="tab-content text-gray-700 leading-relaxed">
                                    @if($produk->deskripsi_singkat)
                                        <p>{{ $produk->deskripsi_singkat }}</p>
                                    @else
                                        <p class="text-gray-500">Informasi detail mengenai produk ini akan segera tersedia.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Order Button --}}
                        <div class="mb-8 animate-scale-in delay-800">
                            <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($produk->nama_produk) }}" 
                               target="_blank"
                               class="group inline-flex items-center justify-center gap-3 px-10 py-5 bg-gradient-to-r from-[#B1252E] to-[#8f1d24] text-white rounded-full text-lg font-bold shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 w-full lg:w-auto">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                                Pemesanan
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </div>

                        {{-- Share --}}
                        <div class="animate-fade-in-up delay-900">
                            <p class="text-sm text-gray-500 mb-4 uppercase tracking-wider font-semibold">Share</p>
                            <div class="flex gap-3">
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($produk->nama_produk) }}&url={{ urlencode(url()->current()) }}" 
                                   target="_blank"
                                   class="w-11 h-11 bg-gray-900 rounded-full flex items-center justify-center hover:bg-[#B1252E] hover:scale-110 transition-all duration-300">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.53.02C13.84 0 15.14.01 16.44 0c.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                    </svg>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                                   target="_blank"
                                   class="w-11 h-11 bg-[#0077B5] rounded-full flex items-center justify-center hover:scale-110 transition-all duration-300">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                   target="_blank"
                                   class="w-11 h-11 bg-[#1877F2] rounded-full flex items-center justify-center hover:scale-110 transition-all duration-300">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($produk->nama_produk . ' - ' . url()->current()) }}" 
                                   target="_blank"
                                   class="w-11 h-11 bg-[#25D366] rounded-full flex items-center justify-center hover:scale-110 transition-all duration-300">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Related Products --}}
            @if($relatedProducts->count() > 0)
            <div class="mt-20 animate-fade-in-up delay-1000">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Produk Terkait</h2>
                    <a href="{{ route('products.public') }}" class="text-[#B1252E] hover:underline font-semibold flex items-center gap-2">
                        Lihat Semua
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                    <a href="{{ route('products.show', $related->produk_id) }}" class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                        <div class="aspect-square bg-gray-100 overflow-hidden">
                            @if($related->gambar_utama)
                                <img src="{{ asset('storage/' . $related->gambar_utama) }}" alt="{{ $related->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <span class="text-gray-400 text-sm">No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-gray-900 mb-2 group-hover:text-[#B1252E] transition-colors line-clamp-2">{{ $related->nama_produk }}</h3>
                            <p class="text-sm text-gray-500">{{ $related->pabrikan->nama_pabrikan ?? 'Unknown Brand' }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </main>

    {{-- Footer --}}
    <x-footer />

    <script>
        function productDetailApp() {
            return {
                activeTab: 'spesifikasi',
                currentImage: '{{ $produk->gambar_utama ? asset("storage/" . $produk->gambar_utama) : asset("images/default-product.png") }}'
            }
        }
    </script>

</body>
</html>