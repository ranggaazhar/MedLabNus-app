<nav class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 sticky top-0 z-40">

    {{-- Bagian Kiri: Hamburger + Judul --}}
    <div class="flex items-center gap-4">
        
        {{-- Tombol Toggle Sidebar (untuk JS: initSidebarToggle) --}}
        <button id="toggleSidebar" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none transition-colors">
            <i class="fas fa-bars text-xl"></i>
        </button>

        {{-- Judul Halaman DINAMIS: Mengambil dari @section('title') di view --}}
        {{-- *Perubahan: Menambahkan kelas 'capitalize' dan menghapus strtoupper()* --}}
        <h1 class="text-xl font-bold text-gray-800 capitalize">
            {{-- 
                Judul akan ditampilkan dengan format yang dikirim dari @section('title').
                Kelas CSS 'capitalize' akan memastikan huruf pertama setiap kata menjadi kapital.
            --}}
            {{ View::yieldContent('title', 'Dashboard') }}
        </h1>
    </div>

   {{-- Bagian Kanan: User Profile (Trigger Dropdown) --}}
<div class="relative flex items-center gap-4">
    
    {{-- Tombol/Area Trigger Dropdown --}}
    {{-- Perubahan: Menggunakan rounded-full, border halus, dan efek shadow saat hover --}}
    <button id="profileDropdownTrigger" type="button" 
        class="group flex items-center gap-3 cursor-pointer 
               bg-white hover:bg-gray-50 border border-gray-200 hover:border-gray-300
               pl-1 pr-4 py-1 rounded-full shadow-sm hover:shadow-md 
               transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-500">
        
        {{-- Avatar Section --}}
        <div class="relative">
            <div class="w-9 h-9 rounded-full overflow-hidden ring-2 ring-white shadow-sm">
                <img 
                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'U') }}&background=0f172a&color=fff&size=128" 
                    alt="{{ auth()->user()->name ?? 'Pengguna' }}" 
                    class="w-full h-full object-cover transform transition-transform duration-300 group-hover:scale-110">
            </div>
            {{-- Status Indicator (Opsional: Titik hijau menandakan online) --}}
            <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-green-500 ring-2 ring-white"></span>
        </div>

        {{-- Text Section (Hidden on Mobile) --}}
        <div class="hidden md:flex flex-col items-start text-left">
            {{-- Nama User --}}
            <span class="text-sm font-bold text-gray-700 group-hover:text-gray-900 transition-colors">
                {{ auth()->user()->name ?? 'Pengguna' }}
            </span>
            {{-- Role/Subtitle Kecil (Opsional, jika tidak ada bisa dihapus) --}}
            <span class="text-[10px] uppercase tracking-wider text-gray-400 font-medium -mt-0.5">
                Admin
            </span>
        </div>

        {{-- Chevron Icon --}}
        <div class="hidden md:block pl-1">
            <i class="fas fa-chevron-down text-xs text-gray-400 group-hover:text-gray-600 transform transition-transform duration-300 group-hover:rotate-180"></i>
        </div>

    </button>
</div>

        {{-- INCLUDE PARTIAL DROP DOWN MENU --}}
        {{-- Memanggil partial yang baru dibuat: resources/views/partials/_user-dropdown.blade.php --}}
        @include('partials._user-dropdown') 
    </div>
</nav>