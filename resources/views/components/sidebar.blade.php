<aside id="sidebar" 
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 
            transform transition-transform duration-300 
            -translate-x-full md:translate-x-0 flex flex-col">
    
    {{-- HEADER (TIDAK DIUBAH POSISINYA) --}}
    <div class="flex items-center gap-3 px-6 h-16 border-b border-gray-100">
        <img src="{{ asset('images/logo2.png') }}" 
            alt="Logo Medlab" 
            class="w-8 h-8 rounded-full object-cover flex-shrink-0">

        <span class="text-base font-bold text-gray-800 tracking-tight whitespace-nowrap">
            PT Medlab Nusantara
        </span>
    </div>

    {{-- MENU ITEMS --}}
    {{-- Penjelasan Logika Alignment:
         1. Header menggunakan px-6 (padding kiri 1.5rem / 24px).
         2. Agar lurus, konten menu harus mulai di titik 24px juga.
         3. Tombol menu (<a>) memiliki padding internal p-3 (0.75rem / 12px) untuk efek hover.
         4. Maka, Container Nav harus menggunakan px-3 (12px).
         5. Hasil: 12px (Nav) + 12px (Tombol) = 24px (Lurus dengan Logo).
    --}}
    <nav class="flex-1 overflow-y-auto px-3 mt-6">
        
        {{-- Label "MAIN MENU" --}}
        {{-- Diberi px-3 agar sejajar dengan ikon tombol --}}
        <p class="px-3 text-xs text-gray-400 font-semibold uppercase mb-2">
            Main Menu
        </p>
        
        <div class="space-y-1">
            @php 
                $isProductActive = request()->routeIs('produk.*');
                $isPabrikanActive = request()->routeIs('pabrikan.*');
                $isDashboardStrict = request()->routeIs('dashboard');
                
                $isActiveDashboard = $isDashboardStrict || (!$isProductActive && !$isPabrikanActive);
            @endphp
            
            {{-- 1. Link Dashboard --}}
            <a href="{{ route('dashboard') }}" 
                class="flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors
                {{ $isActiveDashboard ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                
                 {{-- Icon Pabrikan dari folder public/css --}}
                <img src="{{ asset('icons/dashboard.svg') }}" 
                     alt="Pabrikan Icon" 
                     class="w-6 h-6 object-contain">
                
                Dashboard
            </a>
            
            {{-- 2. Link Pabrikan --}}
            <a href="{{ route('pabrikan.index') }}" 
                class="flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors
                {{ $isPabrikanActive ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                
                <img src="{{ asset('icons/pabrik.svg') }}" 
                     alt="Pabrikan Icon" 
                     class="w-6 h-6 object-contain">
                
                Pabrikan
            </a>
        </div>
        
    </nav>
</aside>