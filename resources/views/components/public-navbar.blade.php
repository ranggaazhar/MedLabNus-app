{{-- resources/views/components/public-navbar.blade.php --}}
@props(['active' => ''])

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<nav class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-md shadow-sm z-50 border-b border-gray-100"
    x-data="{ mobileMenuOpen: false }">
    
    <div class="w-full px-6 lg:px-12 py-1"> 
        <div class="flex items-center justify-between">

            {{-- 1. LOGO --}}
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

            {{-- 2. DESKTOP MENU --}}
            <ul class="hidden md:flex items-center gap-10">
                <li><a href="{{ route('welcome') }}" class="text-sm font-bold transition-colors {{ $active === 'home' ? 'text-[#B1252E]' : 'text-gray-600 hover:text-[#B1252E]' }}">Home</a></li>
                <li><a href="{{ route('welcome') }}#visi-misi-section" class="text-sm font-bold transition-colors {{ $active === 'visi-misi' ? 'text-[#B1252E]' : 'text-gray-600 hover:text-[#B1252E]' }}">Visi & Misi</a></li>
                <li><a href="{{ route('welcome') }}#product-section" class="text-sm font-bold transition-colors {{ $active === 'products' ? 'text-[#B1252E]' : 'text-gray-600 hover:text-[#B1252E]' }}">Products</a></li>
            </ul>

            {{-- 3. RIGHT ACTIONS --}}
            <div class="flex items-center gap-3">
                
                {{-- Hanya cek Guard WEB (User Biasa) --}}
                @php $user = Auth::guard('web')->user(); @endphp

                {{-- DESKTOP ACTIONS --}}
                <div class="hidden md:flex items-center gap-5">
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