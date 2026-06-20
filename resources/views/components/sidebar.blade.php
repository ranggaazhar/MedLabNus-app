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
                    // Ambil data user yang login dari guard admin
                    $authAdmin = Auth::guard('admin')->user();

                    $isProductActive = request()->routeIs('produk.*');
                    $isPabrikanActive = request()->routeIs('pabrikan.*');

                    // 🌟 DAFTARKAN LOGIKA AKTIF
                    $isPenawaranActive = request()->routeIs('admin.penawaran.*');
                    $isInvoiceActive = request()->routeIs('admin.invoice.*');

                    $isAuditActive = request()->routeIs('log.index'); // Spatie Audit
                    $isMutasiActive = request()->routeIs('stok-mutasi.*'); // Stok Mutasi
                    $isLogGroupActive = $isAuditActive || $isMutasiActive;
                    $isStaffActive = request()->routeIs('staff.*');

                    $isDashboardStrict = request()->routeIs('admin.dashboard') || request()->routeIs('gudang.dashboard');
                    $dashboardRoute = ($authAdmin && $authAdmin->role === 'admin') ? route('admin.dashboard') : route('gudang.dashboard');

                    // 🌟 COCOKAN NEGASI agar Dashboard tidak ikut menyala saat menu lain diakses
                    $isActiveDashboard =
                        $isDashboardStrict ||
                        (!$isProductActive &&
                            !$isPabrikanActive &&
                            !$isPenawaranActive &&
                            !$isInvoiceActive &&
                            !$isLogGroupActive &&
                            !$isStaffActive);
                @endphp

                {{-- 1. Link Dashboard (Admin & Gudang Bisa Lihat) --}}
                <a href="{{ $dashboardRoute }}"
                    class="!flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors w-full
                    {{ $isActiveDashboard ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <img src="{{ asset('icons/dashboard.svg') }}"
                        class="w-6 h-6 object-contain flex-shrink-0 {{ $isActiveDashboard ? '' : 'opacity-50' }}">
                    <span>Dashboard</span>
                </a>

                {{-- 1.5. Link Produk (Admin & Gudang Bisa Lihat) --}}
                <a href="{{ route('produk.index') }}"
                    class="!flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors w-full
                    {{ $isProductActive ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="w-6 h-6 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-boxes text-lg {{ $isProductActive ? 'text-red-700' : 'text-gray-400' }}"></i>
                    </div>
                    <span>Produk</span>
                </a>

                {{-- 2. Link Pabrikan (Admin & Gudang Bisa Lihat) --}}
                <a href="{{ route('pabrikan.index') }}"
                    class="!flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors w-full
                    {{ $isPabrikanActive ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <img src="{{ asset('icons/pabrik.svg') }}"
                        class="w-6 h-6 object-contain flex-shrink-0 {{ $isPabrikanActive ? '' : 'opacity-50' }}">
                    <span>Pabrikan</span>
                </a>

                {{-- 3. Link Stok Mutasi (Hanya untuk Gudang, karena Admin mengakses melalui dropdown Log Aktivitas) --}}
                @if ($authAdmin->role === 'gudang')
                <a href="{{ route('stok-mutasi.index') }}"
                    class="!flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors w-full
                    {{ $isMutasiActive ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="w-6 h-6 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exchange-alt text-lg {{ $isMutasiActive ? 'text-red-700' : 'text-gray-400' }}"></i>
                    </div>
                    <span>Mutasi Stok</span>
                </a>
                @endif

                {{-- ==================== KHUSUS ROLE ADMIN (FINANSIAL & OPERATIONS) ==================== --}}
                @if ($authAdmin->role === 'admin')
                    
                    {{-- 3. LINK PENAWARAN --}}
                    <a href="{{ route('admin.penawaran.index') }}"
                        class="!flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors w-full
                        {{ $isPenawaranActive ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        <div class="w-6 h-6 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-file-invoice text-lg {{ $isPenawaranActive ? 'text-red-700' : 'text-gray-400' }}"></i>
                        </div>
                        <span>Penawaran</span>
                    </a>

                    {{-- 4. LINK INVOICE --}}
                    <a href="{{ route('admin.invoice.index') }}"
                        class="!flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors w-full
                        {{ $isInvoiceActive ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        <div class="w-6 h-6 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-file-invoice-dollar text-lg {{ $isInvoiceActive ? 'text-red-700' : 'text-gray-400' }}"></i>
                        </div>
                        <span>Invoice</span>
                    </a>

                    {{-- Link Manajemen Gudang --}}
                    <a href="{{ route('staff.index') }}"
                        class="!flex items-center gap-3 p-3 rounded-lg text-sm font-medium transition-colors w-full
                        {{ $isStaffActive ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        <div class="w-6 h-6 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user-shield text-lg {{ $isStaffActive ? 'text-red-700' : 'text-gray-400' }}"></i>
                        </div>
                        <span>Manajemen Gudang</span>
                    </a>

                    {{-- 5. Group Log Aktivitas (Dropdown) --}}
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
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                                :class="openLog ? 'rotate-180' : ''"></i>
                        </button>

                        {{-- Anakan Menu --}}
                        <div x-show="openLog" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             x-cloak 
                             class="mt-1 ml-4 space-y-1 border-l-2 border-gray-100 pl-4">

                            {{-- Anak 1: Audit Trail --}}
                            <a href="{{ route('log.index') }}"
                                class="flex items-center gap-3 p-2 text-sm rounded-lg transition-all 
                                {{ $isAuditActive ? 'text-red-700 bg-red-50 font-bold' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50' }}">
                                <div class="w-5 h-5 flex items-center justify-center">
                                    <i class="fas fa-clipboard-check text-base"></i>
                                </div>
                                <span>Riwayat Aktifitas</span>
                            </a>

                            {{-- Anak 2: Stok Mutasi --}}
                            <a href="{{ route('stok-mutasi.index') }}"
                                class="flex items-center gap-3 p-2 text-sm rounded-lg transition-all 
                                {{ $isMutasiActive ? 'text-red-700 bg-red-50 font-bold' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50' }}">
                                <div class="w-5 h-5 flex items-center justify-center">
                                    <i class="fas fa-boxes-stacked text-base"></i>
                                </div>
                                <span>Stok Mutasi</span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</aside>