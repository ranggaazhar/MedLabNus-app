@props(['pabrikan'])

{{-- Card container --}}
{{-- Diperkecil: h-60 -> h-52, p-6 -> p-5 --}}
<div class="bg-white rounded-2xl shadow-md p-5 flex flex-col justify-between h-52 transition-all duration-300 ease-in-out hover:shadow-xl hover:scale-[1.01] border border-gray-100">
    
    {{-- Bagian Atas: Logo (Telah Menyatu dengan Nama di dalam Gambar) dan Ikon Panah --}}
    {{-- Diperkecil: mb-4 -> mb-3 --}}
    <div class="flex items-center justify-between mb-3">
        {{-- Logo Pabrikan --}}
        <div class="flex items-center space-x-2">
            @if ($pabrikan->logo_pabrikan)
                {{-- Logo diperbesar sedikit (h-8) agar teks di dalamnya lebih terbaca --}}
                <img src="{{ asset('storage/' . $pabrikan->logo_pabrikan) }}"
                    alt="{{ $pabrikan->nama_pabrikan }}"
                    class="h-8 w-auto max-h-8 object-contain"> 
            @else
                {{-- Placeholder jika tidak ada logo --}}
                <div class="h-8 w-8 flex items-center justify-center text-gray-400">
                    <i class="fas fa-industry text-base"></i>
                </div>
            @endif
            
            {{-- Nama Pabrikan Kecil (Sejajar Logo) TELAH DIHAPUS, karena sudah menyatu dengan gambar logo. --}}
        </div>
        
        {{-- Ikon Panah Kanan --}}
        <a href="#" class="text-gray-400 hover:text-red-600 transition-colors">
            <i class="fas fa-chevron-right text-base font-bold"></i>
        </a>
    </div>

    {{-- Bagian Tengah: Nama Pabrikan Utama (Text Inputan) --}}
    <div class="flex-1 -mt-2">
        <h3 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ $pabrikan->nama_pabrikan }}
        </h3>
        
        {{-- Asal Negara (Tanpa Ikon) --}}
        <p class="text-base text-gray-500 mt-1">
            {{ $pabrikan->asal_negara }}
        </p>
    </div>

    {{-- Bagian Bawah: Tombol Aksi (Tanpa Shadow) --}}
    {{-- Diperkecil: mt-4 -> mt-3 --}}
    <div class="flex justify-start space-x-3 mt-3">
        
        {{-- Tombol Edit (Tanpa Shadow) --}}
        <button type="button" title="Edit Data Pabrikan"
            class="edit-button bg-gray-800 text-white hover:bg-gray-900 
                   font-medium py-2 px-5 rounded-lg 
                   transition duration-300 ease-in-out flex items-center space-x-2 
                   focus:outline-none focus:ring-2 focus:ring-gray-300 transform hover:scale-[1.03]"
            data-id="{{ $pabrikan->id }}" 
            data-nama="{{ $pabrikan->nama_pabrikan }}"
            data-negara="{{ $pabrikan->asal_negara }}"
            data-logo="{{ $pabrikan->logo_pabrikan ? asset('storage/' . $pabrikan->logo_pabrikan) : '' }}">
            {{-- Menggunakan ikon yang lebih kecil (text-xs) --}}
            <i class="fas fa-pencil-alt text-xs"></i> 
            <span class="text-sm">Edit</span>
        </button>

        {{-- Tombol Hapus (Tanpa Shadow) --}}
        <form action="{{ route('pabrikan.destroy', $pabrikan) }}" method="POST"
            onsubmit="return confirm('Yakin ingin menghapus pabrikan {{ $pabrikan->nama_pabrikan }}? Tindakan ini tidak dapat dibatalkan.');">
            @csrf
            @method('DELETE')
            <button type="submit" title="Hapus Data Pabrikan"
                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-5 rounded-lg 
                       transition duration-300 ease-in-out 
                       flex items-center space-x-2 focus:outline-none focus:ring-2 focus:ring-red-300 transform hover:scale-[1.03]">
                {{-- Menggunakan ikon yang lebih kecil (text-xs) --}}
                <i class="fas fa-trash-alt text-xs"></i>
                <span class="text-sm">Delete</span>
            </button>
        </form>
    </div>
</div>