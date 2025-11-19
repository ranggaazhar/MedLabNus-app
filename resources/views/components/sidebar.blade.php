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
        
        <div class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider mt-4 mb-1">
            Main Menu
        </div>

        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors
           {{ request()->routeIs('dashboard') ? 'text-red-600 bg-red-50' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <i class="fas fa-home w-5"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('produk.index') }}" 
           class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors
           {{ request()->routeIs('produk*') ? 'text-red-600 bg-red-50' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <i class="fas fa-box w-5"></i>
            <span>Categories</span>
        </a>

        {{-- Item tambahan sesuai kode lama Anda, disembunyikan jika tidak perlu --}}
        {{-- 
        <a href="{{ route('pabrikan.index') }}" class="...">Manufacturers</a>
        --}}
    </nav>
</aside>