{{-- resources/views/components/public-navbar.blade.php --}}
@props(['active' => ''])

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<nav class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-md shadow-sm z-50 border-b border-gray-100"
    x-data="{ mobileMenuOpen: false }">
    
    <div class="w-full px-6 lg:px-12 py-1"> 
        <div class="flex items-center justify-between md:grid md:grid-cols-3">

            {{-- 1. LOGO (Kiri) --}}
            <div class="flex md:justify-start">
                <a href="{{ route('welcome') }}"
                    class="flex items-center transition-transform duration-300 hover:scale-105">
                    @if (file_exists(public_path('images/logo2.png')))
                        <img src="{{ asset('images/logo2.png') }}" alt="PT Medlab Nusantara" class="h-10 md:h-12 w-auto">
                    @else
                        <div class="w-10 h-10 bg-[#B1252E] rounded-lg flex items-center justify-center shadow-md">
                            <span class="text-white text-lg font-bold">M</span>
                        </div>
                    @endif
                </a>
            </div>

            {{-- 2. DESKTOP MENU (Tengah Sempurna) --}}
            <div class="hidden md:flex justify-center">
                <ul class="flex items-center gap-10">
                    <li><a href="{{ route('welcome') }}" class="text-sm font-bold transition-colors {{ $active === 'home' ? 'text-[#B1252E]' : 'text-gray-600 hover:text-[#B1252E]' }}">Home</a></li>
                    <li><a href="{{ route('welcome') }}#visi-misi-section" class="text-sm font-bold transition-colors {{ $active === 'visi-misi' ? 'text-[#B1252E]' : 'text-gray-600 hover:text-[#B1252E]' }}">Visi & Misi</a></li>
                    <li><a href="{{ route('welcome') }}#product-section" class="text-sm font-bold transition-colors {{ $active === 'products' ? 'text-[#B1252E]' : 'text-gray-600 hover:text-[#B1252E]' }}">Products</a></li>
                </ul>
            </div>

            {{-- 3. RIGHT ACTIONS (Kanan) --}}
            @php $user = Auth::guard('web')->user(); @endphp

            <div class="flex items-center justify-end gap-3">
                
                {{-- DESKTOP ACTIONS --}}
                <div class="hidden md:flex items-center gap-5">
                    
                    {{-- 🛒 PERUBAHAN: IKON KERANJANG DESKTOP DIKONDISIKAN HANYA JIKA USER SUDAH LOGIN --}}
                    @if ($user)
                        <a href="{{ route('penawaran.keranjang') }}" class="relative p-2 top-1 text-gray-600 hover:text-[#B1252E] transition-colors">
                            <i class="fa-solid fa-cart-shopping text-xl"></i>
                            <span id="cart-count" class="absolute -top-1 -right-1 hidden justify-center items-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white bg-[#B1252E] rounded-full min-w-[18px] h-[18px]">
                                0
                            </span>
                        </a>
                    @endif

                    @if ($user)
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-2 p-1 pr-3 bg-gray-50 rounded-full border border-transparent hover:border-red-100 transition-all">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=B1252E&color=fff" 
                                     class="w-8 h-8 rounded-full shadow-sm">
                                <i class="fa-solid fa-chevron-down text-[10px] text-gray-400" :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="open" x-transition class="absolute right-0 mt-3 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 p-2" style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 rounded-xl hover:bg-red-50 hover:text-[#B1252E]">
                                    <i class="fa-solid fa-user-gear"></i> Profil Saya
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 rounded-xl hover:bg-red-50">
                                        <i class="fa-solid fa-power-off"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-[#B1252E]">Login</a>
                    @endif

                    <a href="{{ route('products.public') }}" class="px-6 py-2 bg-[#B1252E] text-white text-sm font-bold rounded-full shadow-md hover:scale-105 transition-all">
                        Shop Now
                    </a>
                </div>

                {{-- MOBILE MENU TOGGLE --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl text-gray-700 hover:bg-gray-100">
                    <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark text-xl' : 'fa-bars-staggered text-xl'"></i>
                </button>
            </div>
        </div>

        {{-- 4. MOBILE MENU --}}
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-gray-100 mt-2 py-5" style="display: none;">
            <div class="flex flex-col gap-1">
                <a href="{{ route('welcome') }}" class="px-5 py-3 rounded-xl hover:bg-red-50 font-bold text-gray-700">Home</a>
                <a href="{{ route('welcome') }}#visi-misi-section" class="px-5 py-3 rounded-xl hover:bg-red-50 font-bold text-gray-700">Visi & Misi</a>
                <a href="{{ route('welcome') }}#product-section" class="px-5 py-3 rounded-xl hover:bg-red-50 font-bold text-gray-700">Products</a>
                
                {{-- 🛒 PERUBAHAN: LINK KERANJANG MOBILE JUGA DIKONDISIKAN HANYA JIKA LOGIN --}}
                @if ($user)
                    <a href="{{ route('penawaran.keranjang') }}" class="px-5 py-3 rounded-xl hover:bg-red-50 font-bold text-gray-700 flex justify-between items-center">
                        <span>Keranjang Penawaran</span>
                        <div class="relative">
                            <i class="fa-solid fa-cart-shopping text-[#B1252E] text-lg"></i>
                            <span id="cart-count-mobile" class="absolute -top-2 -right-2 hidden justify-center items-center px-1 py-0.5 text-[9px] font-bold leading-none text-white bg-[#B1252E] rounded-full min-w-[16px] h-[16px]">
                                0
                            </span>
                        </div>
                    </a>
                @endif

                <div class="h-px bg-gray-100 my-3 mx-5"></div>

                <a href="{{ route('products.public') }}" class="mx-5 mb-4 flex items-center justify-center gap-2 px-4 py-3 bg-[#B1252E] text-white rounded-xl font-bold">
                    <i class="fa-solid fa-bag-shopping"></i> Shop Now
                </a>

                @if ($user)
                    <div class="mx-5 p-4 bg-gray-50 rounded-2xl flex items-center gap-4 border border-gray-100">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=B1252E&color=fff" class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-800">{{ $user->name }}</p>
                            <a href="{{ route('profile.edit') }}" class="text-xs font-bold text-[#B1252E] border-b border-[#B1252E]">Profil</a>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-10 h-10 flex items-center justify-center bg-white rounded-full text-red-500 shadow-sm">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="mx-5 px-4 py-3 text-center border-2 border-gray-100 rounded-xl font-bold text-gray-600">Login Account</a>
                @endif
            </div>
        </div>
    </div>
</nav>

{{-- 🛠️ SCRIPT JAVASCRIPT DINAMIS UNTUK MENGHITUNG ISI KERANJANG SINKRON DENGAN HALAMAN DETAIL --}}
<script>
    function updateCartBadge() {
        // Ambil data keranjang dari localStorage browser pelanggan
        const cart = JSON.parse(localStorage.getItem('keranjang_penawaran')) || [];
        
        // Menghitung total QUANTITY semua produk (misal: 1 produk BA200 + 1 Erlenmeyer = 2 item)
        // Jika Anda ingin menghitung jumlah baris jenis produknya saja, ganti baris ini menjadi: const totalItems = cart.length;
        const totalItems = cart.reduce((total, item) => total + parseInt(item.jumlah || 0), 0);

        // Update Badge Desktop jika elemennya ada di halaman
        const badgeDesktop = document.getElementById('cart-count');
        if (badgeDesktop) {
            if (totalItems > 0) {
                badgeDesktop.innerText = totalItems;
                badgeDesktop.classList.remove('hidden');
                badgeDesktop.classList.add('inline-flex');
            } else {
                badgeDesktop.classList.add('hidden');
                badgeDesktop.classList.remove('inline-flex');
            }
        }

        // Update Badge Mobile jika elemennya ada di halaman
        const badgeMobile = document.getElementById('cart-count-mobile');
        if (badgeMobile) {
            if (totalItems > 0) {
                badgeMobile.innerText = totalItems;
                badgeMobile.classList.remove('hidden');
                badgeMobile.classList.add('inline-flex');
            } else {
                badgeMobile.classList.add('hidden');
                badgeMobile.classList.remove('inline-flex');
            }
        }
    }

    // Jalankan fungsi saat halaman pertama kali selesai dimuat oleh browser
    document.addEventListener('DOMContentLoaded', updateCartBadge);

    // Daftarkan fungsi ke objek window agar bisa diakses/dipanggil dari halaman detail produk setelah klik tombol
    window.updateCartBadge = updateCartBadge;
</script>