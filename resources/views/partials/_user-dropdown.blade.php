{{-- Partial ini HANYA berisi konten menu dropdown (hanya Logout). --}}
<div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl py-1 hidden z-50">
    
    {{-- Tombol/Form Logout (Wajib menggunakan POST di Laravel) --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors focus:outline-none">
            <i class="fas fa-sign-out-alt mr-2"></i> Keluar (Logout)
        </button>
    </form>
</div>