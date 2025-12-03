{{-- resources/views/components/public-navbar.blade.php --}}
@props(['active' => ''])

<nav class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50" x-data="{ mobileMenuOpen: false }">
    <div class="w-full px-6 lg:px-10 py-1">
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
                    <a href="{{ route('welcome') }}#visi-misi-section" 
                       class="text-gray-700 hover:text-[#B1252E] transition-colors {{ $active === 'visi-misi' ? 'text-[#B1252E] font-semibold border-b-2 border-[#B1252E] pb-1' : '' }}">
                        Visi & Misi
                    </a>
                </li>
                <li>
                    <a href="{{ route('welcome') }}#product-section" 
                       class="text-gray-700 hover:text-[#B1252E] transition-colors {{ $active === 'products' ? 'text-[#B1252E] font-semibold border-b-2 border-[#B1252E] pb-1' : '' }}">
                        Products
                    </a>
                </li>
            </ul>

            {{-- Shop Button --}}
            <a href="{{ route('products.public') }}" class="hidden md:flex items-center gap-2 px-6 py-2.5 bg-[#B1252E] text-white rounded-full hover:bg-[#8f1d24] transition-colors">
                <img src="{{ asset('icons/shop.svg') }}" alt="Shop Icon" class="w-4 h-4 brightness-0 invert">
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
                    <a href="{{ route('welcome') }}#visi-misi-section" 
                       class="block py-2 text-gray-700 hover:text-[#B1252E] transition-colors {{ $active === 'visi-misi' ? 'text-[#B1252E] font-semibold' : '' }}">
                        Visi & Misi
                    </a>
                </li>
                <li>
                    <a href="{{ route('welcome') }}#product-section" 
                       class="block py-2 text-gray-700 hover:text-[#B1252E] transition-colors {{ $active === 'products' ? 'text-[#B1252E] font-semibold' : '' }}">
                        Products
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.public') }}" class="flex items-center gap-2 px-6 py-2.5 bg-[#B1252E] text-white rounded-full hover:bg-[#8f1d24] transition-colors w-full justify-center">
                        <img src="{{ asset('icons/shop.svg') }}" alt="Shop Icon" class="w-4 h-4 brightness-0 invert">
                        Shop
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
// Handle smooth scroll when coming from another page with hash
document.addEventListener('DOMContentLoaded', function() {
    // Function to perform smooth scroll to target
    function smoothScrollToTarget(targetId) {
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            const navbarHeight = document.querySelector('nav').offsetHeight;
            const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight - 20;
            
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    }
    
    // Check if URL has a hash on page load
    if (window.location.hash) {
        const targetId = window.location.hash.substring(1); // Remove the # symbol
        
        // Wait a bit for the page to fully load
        setTimeout(() => {
            smoothScrollToTarget(targetId);
        }, 100);
    }
    
    // Listen for hash changes (when navigating between sections on same page)
    window.addEventListener('hashchange', function() {
        if (window.location.hash) {
            const targetId = window.location.hash.substring(1);
            
            // Small delay to ensure smooth transition
            setTimeout(() => {
                smoothScrollToTarget(targetId);
            }, 50);
        }
    });
    
    // Handle clicks on navigation links for same-page scrolling
    document.querySelectorAll('a[href*="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            const url = new URL(href, window.location.origin);
            
            // Check if it's a same-page anchor (same pathname, has hash)
            if (url.pathname === window.location.pathname && url.hash) {
                e.preventDefault();
                const targetId = url.hash.substring(1);
                
                // Update URL without reload
                history.pushState(null, null, url.hash);
                
                // Smooth scroll to target
                smoothScrollToTarget(targetId);
            }
            // If different page, let default behavior happen (navigate + hash will trigger on load)
        });
    });
});
</script>