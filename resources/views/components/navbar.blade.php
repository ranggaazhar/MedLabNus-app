<nav class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 sticky top-0 z-40">

    {{-- Bagian Kiri: Hamburger + Judul --}}
    <div class="flex items-center gap-4">
        
        {{-- Tombol Toggle (Sekarang muncul di semua ukuran layar) --}}
        <button id="toggleSidebar" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none transition-colors">
            <i class="fas fa-bars text-xl"></i>
        </button>

        {{-- Judul Halaman --}}
        <h1 class="text-xl font-bold text-gray-800">
           DASHBOARD
        </h1>
    </div>

    {{-- Bagian Kanan: User Profile (Tetap sama) --}}
    <div class="flex items-center gap-4">
        <div class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-1 rounded-lg transition">
            <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden border border-gray-300">
                <img src="https://ui-avatars.com/api/?name=Harsh&background=random" alt="User" class="w-full h-full object-cover">
            </div>
            <div class="hidden md:flex items-center gap-2 text-sm font-medium text-gray-700">
                <span>Harsh</span>
                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
            </div>
        </div>
    </div>

</nav>