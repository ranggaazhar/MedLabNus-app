<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 
            transform transition-transform duration-300 
            -translate-x-full md:translate-x-0 flex flex-col font-sans">

    {{-- HEADER LOGO --}}
    <div class="flex items-center gap-3 px-6 h-16 border-b border-gray-100 flex-shrink-0">
        <img src="{{ asset('images/logo2.png') }}" alt="Logo Medlab"
            class="w-8 h-8 rounded-full object-cover flex-shrink-0">
        <span class="text-base font-bold text-gray-800 tracking-tight whitespace-nowrap">
            PT Medlab Nusantara
        </span>
    </div>

    {{-- MENU ITEMS --}}
    <div class="flex-1 overflow-y-auto px-3 mt-6 block">
        <div class="flex flex-col w-full">
            <p class="px-3 text-xs text-gray-400 font-semibold uppercase mb-4 block leading-none">
                Main Menu
            </p>

            <div class="space-y-1 flex flex-col w-full" x-data="{ openLog: {{ request()->is('admin/log*') ? 'true' : 'false' }} }">
                @php
                    $isProductActive = request()->routeIs('produk.*');
                    $isPabrikanActive = request()->routeIs('pabrikan.*');
                    $isAuditActive = request()->routeIs('log.index'); // Spatie Audit
                    $isMutasiActive = request()->routeIs('stok-mutasi.*'); // Stok Mutasi
                    $isLogGroupActive = $isAuditActive || $isMutasiActive;
                    
                    $isDashboardStrict = request()->routeIs('dashboard');
                    $isActiveDashboard = $isDashboardStrict || (!$isProductActive && !$isPabrikanActive && !$isLogGroupActive);
                @endphp

                {{-- 1. Link Dashboard --}}
                <a href="{{ route('dashboard') }}"
                    class="!flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors w-full
                    {{ $isActiveDashboard ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <img src="{{ asset('icons/dashboard.svg') }}" class="w-6 h-6 object-contain flex-shrink-0 {{ $isActiveDashboard ? '' : 'opacity-50' }}">
                    <span>Dashboard</span>
                </a>

                {{-- 2. Link Pabrikan --}}
                <a href="{{ route('pabrikan.index') }}"
                    class="!flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors w-full
                    {{ $isPabrikanActive ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <img src="{{ asset('icons/pabrik.svg') }}" class="w-6 h-6 object-contain flex-shrink-0 {{ $isPabrikanActive ? '' : 'opacity-50' }}">
                    <span>Pabrikan</span>
                </a>

                {{-- 3. Group Log Aktivitas (Dropdown) --}}
                <div class="w-full">
                    <button @click="openLog = !openLog" 
                        class="!flex items-center justify-between p-3 rounded-lg text-sm font-medium transition-colors w-full
                        {{ $isLogGroupActive ? 'bg-gray-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-history text-lg {{ $isLogGroupActive ? 'text-red-600' : 'text-gray-400' }}"></i>
                            </div>
                            <span>Log Aktivitas</span>
                        </div>

                        {{-- Icon Panah --}}
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="openLog ? 'rotate-180' : ''"></i>
                    </button>

                    {{-- Anakan Menu --}}
                    <div x-show="openLog" x-cloak class="mt-1 ml-9 space-y-1">
                        {{-- Anak 1: Audit Trail --}}
                        <a href="{{ route('log.index') }}" 
                            class="block p-2 text-sm rounded-lg transition-colors {{ $isAuditActive ? 'text-red-600 font-bold' : 'text-gray-500 hover:text-gray-800' }}">
                            • Audit Trail
                        </a>
                        
                        {{-- Anak 2: Stok Mutasi --}}
                        <a href="{{ route('stok-mutasi.index') }}" 
                            class="block p-2 text-sm rounded-lg transition-colors {{ $isMutasiActive ? 'text-red-600 font-bold' : 'text-gray-500 hover:text-gray-800' }}">
                            • Stok Mutasi
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</aside>