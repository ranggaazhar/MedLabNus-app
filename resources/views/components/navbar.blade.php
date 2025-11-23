<nav class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 sticky top-0 z-40">

    {{-- Bagian Kiri: Hamburger + Judul --}}
    <div class="flex items-center gap-4">
        
        {{-- Tombol Toggle Sidebar (untuk JS: initSidebarToggle) --}}
        <button id="toggleSidebar" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none transition-colors">
            <i class="fas fa-bars text-xl"></i>
        </button>

        {{-- Judul Halaman --}}
        <h1 class="text-xl font-bold text-gray-800">
            DASHBOARD
        </h1>
    </div>

    {{-- Bagian Kanan: User Profile (Trigger Dropdown) --}}
    <div class="relative flex items-center gap-4">
        
        {{-- Tombol/Area Trigger Dropdown (Untuk JS: initProfileDropdown) --}}
        <div id="profileDropdownTrigger" class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-1 rounded-lg transition">
            <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden border border-gray-300">
                <img 
                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'U') }}&background=random" 
                    alt="{{ auth()->user()->name ?? 'Pengguna' }}" 
                    class="w-full h-full object-cover">
            </div>
            <div class="hidden md:flex items-center gap-2 text-sm font-medium text-gray-700">
                <span>{{ auth()->user()->name ?? 'Pengguna' }}</span>
                <i class="fas fa-chevron-down text-xs text-gray-400 transform transition-transform duration-200"></i>
            </div>
        </div>

        {{-- INCLUDE PARTIAL DROP DOWN MENU --}}
        {{-- Memanggil partial yang baru dibuat: resources/views/partials/_user-dropdown.blade.php --}}
        @include('partials._user-dropdown') 
    </div>
</nav>