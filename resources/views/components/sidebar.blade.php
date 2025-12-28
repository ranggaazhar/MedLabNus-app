<aside id="sidebar" 
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 
            transform transition-transform duration-300 
            -translate-x-full md:translate-x-0 flex flex-col font-sans">
    
    {{-- HEADER LOGO --}}
    <div class="flex items-center gap-3 px-6 h-16 border-b border-gray-100 flex-shrink-0">
        <img src="{{ asset('images/logo2.png') }}" 
            alt="Logo Medlab" 
            class="w-8 h-8 rounded-full object-cover flex-shrink-0">

        <span class="text-base font-bold text-gray-800 tracking-tight whitespace-nowrap">
            PT Medlab Nusantara
        </span>
    </div>

    {{-- MENU ITEMS --}}
    {{-- Tambahkan class 'block' untuk mematikan 'flex' dari CSS luar --}}
    <div class="flex-1 overflow-y-auto px-3 mt-6 block">
        
        {{-- Label "MAIN MENU" --}}
        {{-- Kita bungkus label dan menu dalam div dengan class flex-col agar pasti lurus ke bawah --}}
        <div class="flex flex-col w-full">
            <p class="px-3 text-xs text-gray-400 font-semibold uppercase mb-4 block leading-none">
                Main Menu
            </p>
            
            <div class="space-y-1 flex flex-col w-full">
                @php 
                    $isProductActive = request()->routeIs('produk.*');
                    $isPabrikanActive = request()->routeIs('pabrikan.*');
                    $isDashboardStrict = request()->routeIs('dashboard');
                    $isActiveDashboard = $isDashboardStrict || (!$isProductActive && !$isPabrikanActive);
                @endphp
                
                {{-- 1. Link Dashboard --}}
                {{-- Gunakan !flex untuk memaksa display flex milik Tailwind --}}
                <a href="{{ route('dashboard') }}" 
                    class="!flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors w-full
                    {{ $isActiveDashboard ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    
                    <img src="{{ asset('icons/dashboard.svg') }}" 
                         alt="Dashboard Icon" 
                         class="w-6 h-6 object-contain flex-shrink-0 {{ $isActiveDashboard ? '' : 'opacity-50' }}">
                    
                    <span class="block">Dashboard</span>
                </a>
                
                {{-- 2. Link Pabrikan --}}
                <a href="{{ route('pabrikan.index') }}" 
                    class="!flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors w-full
                    {{ $isPabrikanActive ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    
                    <img src="{{ asset('icons/pabrik.svg') }}" 
                         alt="Pabrikan Icon" 
                         class="w-6 h-6 object-contain flex-shrink-0 {{ $isPabrikanActive ? '' : 'opacity-50' }}">
                    
                    <span class="block">Pabrikan</span>
                </a>
            </div>
        </div>
    </div>
</aside>