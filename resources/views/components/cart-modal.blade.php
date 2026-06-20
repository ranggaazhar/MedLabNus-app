@props(['relatedProducts' => []])

<div id="cartModal"
    class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-all duration-300">
    
    <div
        class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden origin-center animate-scale-in">

        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
            <h3 class="text-base font-bold text-gray-800 tracking-wide uppercase">Product Added to Cart</h3>
            <button type="button" onclick="closeCartModal()"
                class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-full hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6 bg-gray-50/50">
            <div
                class="flex items-center justify-between bg-white p-4 rounded-2xl border border-gray-100 shadow-sm gap-4">
                <div class="flex items-center gap-4">
                    <img id="modalProductImg" src="/images/default-product.png" alt="Produk"
                        class="w-16 h-16 object-cover rounded-xl border border-gray-100 shadow-sm">
                    <div>
                        <h4 id="modalProductName" class="font-bold text-gray-800 text-base line-clamp-1">-</h4>
                        <p class="text-xs text-gray-500 mt-0.5 font-medium"><span id="modalProductQty">1</span> items
                        </p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('penawaran.keranjang') }}"
                        class="px-4 py-2 text-xs font-bold border border-[#B1252E] text-[#B1252E] rounded-full hover:bg-red-50 transition-all">
                        View Cart
                    </a>
                </div>
            </div>
        </div>

        <div class="px-6 pb-6 pt-2">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-bold text-gray-700">Related Products</h4>
                <div class="flex gap-1">
                    <button class="p-1 text-gray-400 hover:text-gray-600 rounded hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button class="p-1 text-gray-400 hover:text-gray-600 rounded hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-3">
                @foreach (collect($relatedProducts)->take(4) as $related)
                    <a href="{{ route('products.show', $related->produk_id) }}" 
                       class="group block bg-white border border-gray-100 p-2 rounded-xl text-center hover:shadow-md transition-all duration-300">
                        
                        <div class="relative overflow-hidden rounded-lg bg-gray-100 aspect-square mb-2 flex items-center justify-center p-2">
                            @php
                                $src = 'images/default-product.png';
                                if ($related->gambar_utama) {
                                    $src = Str::startsWith($related->gambar_utama, 'uploads/') 
                                        ? $related->gambar_utama 
                                        : 'uploads/products/' . $related->gambar_utama;
                                }
                            @endphp

                            @if ($related->gambar_utama)
                                <img src="{{ asset($src) }}" alt="{{ $related->nama_produk }}"
                                    class="w-full h-full object-contain mix-blend-multiply transition-transform duration-300 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 rounded-lg">
                                    <span class="text-[10px] text-gray-400 font-medium">No Image</span>
                                </div>
                            @endif
                        </div>

                        <p class="text-[9px] text-gray-400 uppercase tracking-tight text-left truncate">
                            {{ $related->pabrikan->nama_pabrikan ?? 'Brand' }}
                        </p>
                        
                        <p class="text-[11px] font-bold text-gray-700 line-clamp-1 text-left group-hover:text-[#B1252E] transition-colors mt-0.5">
                            {{ $related->nama_produk }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</div>

<style>
    @keyframes scaleIn {
        0% {
            transform: scale(0.9);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .animate-scale-in {
        animation: scaleIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }
</style>