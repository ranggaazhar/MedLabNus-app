<aside id="sidebar" 
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 
            transform transition-transform duration-300 
            -translate-x-full md:translate-x-0">
    
    <div class="flex items-center gap-3 px-6 h-16 border-b border-gray-100">
    
    {{-- Logo --}}
    {{-- Tambahkan flex-shrink-0 agar logo tidak gepeng jika ruang sempit --}}
    <img src="{{ asset('images/logom.png') }}" 
            alt="Logo Medlab" 
            class="w-8 h-8 rounded-full object-cover flex-shrink-0">

    {{-- Teks --}}
    {{-- whitespace-nowrap: Paksa satu baris --}}
    {{-- text-base: Ukuran sedikit lebih pas dibanding text-lg --}}
    <span class="text-base font-bold text-gray-800 tracking-tight whitespace-nowrap">
        PT Medlab Nusantara
    </span>
    </div>

    {{-- Menu Items --}}
    <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">
        
        <div class="p-6 pt-0">
    <p class="text-xs text-gray-400 font-semibold uppercase mb-3">Main Menu</p>
    
    {{-- LOGIKA BARU UNTUK NAVIGASI AKTIF --}}
    @php 
        // Cek apakah route saat ini berada di bawah produk.* atau pabrikan.*
        $isProductActive = request()->routeIs('produk.*');
        $isPabrikanActive = request()->routeIs('pabrikan.*');
        $isDashboardStrict = request()->routeIs('dashboard');
        
        // Dashboard aktif jika route-nya adalah 'dashboard' atau jika tidak ada resource lain yang aktif (sebagai fallback)
        $isActiveDashboard = $isDashboardStrict || (!$isProductActive && !$isPabrikanActive);
    @endphp
    
    {{-- 1. Link Dashboard --}}
    <a href="{{ route('dashboard') }}" 
        class="flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors mb-2
        {{ $isActiveDashboard ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-tachometer-alt text-lg"></i>
        Dashboard
    </a>
    
    {{-- 2. Link Pabrikan (NEW) --}}
    <a href="{{ route('pabrikan.index') }}" 
        class="flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors
        {{ $isPabrikanActive ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-industry text-lg"></i>
        Pabrikan
    </a>
    
</div>
        
    </nav>
</aside>