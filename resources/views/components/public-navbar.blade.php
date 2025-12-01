{{-- resources/views/components/public-navbar.blade.php --}}
@props(['active' => ''])

<nav class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50" x-data="{ mobileMenuOpen: false }">
    <div class="w-full px-6 lg:px-12 py-4">
        <div class="flex items-center justify-between">
            {{-- Logo --}}
            <a href="{{ route('welcome') }}" class="flex items-center">
                @if(file_exists(public_path('images/logo2.png')))
                    <img src="{{ asset('images/logo2.png') }}" alt="PT Medlab Nusantara" class="h-12 w-auto">
                @else
                    <div class="w-12 h-12 bg-[#B1252E] rounded-lg flex items-center justify-center">
                        <span class="text-white text-xl font-bold">M</span>
                    </div>
                @endif
            </a>

            {{-- Mobile Menu Button --}}
            <button 
                @click="mobileMenuOpen = !mobileMenuOpen" 
                class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 transition-colors"
            >
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            {{-- Desktop Navigation Links --}}
            <ul class="hidden md:flex items-center gap-8">
                <li>
                    <a href="{{ route('welcome') }}" 
                       class="text-gray-700 hover:text-[#B1252E] transition-colors {{ $active === 'home' ? 'text-[#B1252E] font-semibold border-b-2 border-[#B1252E] pb-1' : '' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="#visi-misi" 
                       class="text-gray-700 hover:text-[#B1252E] transition-colors {{ $active === 'visi-misi' ? 'text-[#B1252E] font-semibold border-b-2 border-[#B1252E] pb-1' : '' }}">
                        Visi & Misi
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.public') }}" 
                       class="text-gray-700 hover:text-[#B1252E] transition-colors {{ $active === 'products' ? 'text-[#B1252E] font-semibold border-b-2 border-[#B1252E] pb-1' : '' }}">
                        Products
                    </a>
                </li>
            </ul>

            {{-- Shop Button --}}
            <a href="#shop" class="hidden md:flex items-center gap-2 px-6 py-2.5 bg-[#B1252E] text-white rounded-full hover:bg-[#8f1d24] transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                Shop
            </a>
        </div>

        {{-- Mobile Menu --}}
        <div 
            x-show="mobileMenuOpen" 
            @click.outside="mobileMenuOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden mt-4 pt-4 border-t border-gray-200"
            style="display: none;"
        >
            <ul class="flex flex-col gap-4">
                <li>
                    <a href="{{ route('welcome') }}" 
                       class="block py-2 text-gray-700 hover:text-[#B1252E] transition-colors {{ $active === 'home' ? 'text-[#B1252E] font-semibold' : '' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="#visi-misi" 
                       class="block py-2 text-gray-700 hover:text-[#B1252E] transition-colors {{ $active === 'visi-misi' ? 'text-[#B1252E] font-semibold' : '' }}">
                        Visi & Misi
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.public') }}" 
                       class="block py-2 text-gray-700 hover:text-[#B1252E] transition-colors {{ $active === 'products' ? 'text-[#B1252E] font-semibold' : '' }}">
                        Products
                    </a>
                </li>
                <li>
                    <a href="#shop" class="flex items-center gap-2 px-6 py-2.5 bg-[#B1252E] text-white rounded-full hover:bg-[#8f1d24] transition-colors w-full justify-center">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                        Shop
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>