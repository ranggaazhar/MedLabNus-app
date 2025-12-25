@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- STAT CARDS SECTION (DISESUAIKAN) --}}
{{-- Ubah layout grid untuk menampung 6 kartu --}}
<div class="grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-6 mb-8">

    {{-- Gunakan pola ini untuk ke-6 Card Anda --}}
    
    {{-- Card 1: Total Produk --}}
    <div class="relative">
        <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
        {{-- Perubahan: flex-col di mobile (items-start), flex-row di desktop (items-center) --}}
        <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
            <div class="mb-3 sm:mb-0">
                <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">Total Produk</p>
                <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ $totalProduk }}</h3>
            </div>
            {{-- Perubahan: Ukuran box ikon lebih kecil di mobile --}}
            <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                <img src="{{ asset('icons/box.svg') }}" alt="Product Icon" class="w-5 h-5 sm:w-7 sm:h-7 object-contain filter brightness-0 invert">
            </div>
        </div>
    </div>

    {{-- Card 2: Alat --}}
    <div class="relative">
        <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
        <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
            <div class="mb-3 sm:mb-0">
                <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">Alat</p>
                <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ $totalAlat }}</h3>
            </div>
            <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                <img src="{{ asset('icons/pk.svg') }}" alt="Alat Icon" class="w-5 h-5 sm:w-7 sm:h-7 object-contain filter brightness-0 invert">
            </div>
        </div>
    </div>

    {{-- Card 3: Reagen --}}
    <div class="relative">
        <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
        <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
            <div class="mb-3 sm:mb-0">
                <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">Reagen</p>
                <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ $totalReagen }}</h3>
            </div>
            <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                <img src="{{ asset('icons/lab.svg') }}" alt="Reagen Icon" class="w-5 h-5 sm:w-7 sm:h-7 object-contain filter brightness-0 invert">
            </div>
        </div>
    </div>

    {{-- Card 4: Steril --}}
    <div class="relative">
        <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
        <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
            <div class="mb-3 sm:mb-0">
                <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">Steril</p>
                <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ $totalSteril }}</h3>
            </div>
            <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-7 sm:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.01 12.01 0 002.944 12c0 3.078 1.488 5.99 3.944 8.056A11.955 11.955 0 0112 21.056c3.078 0 5.99-1.488 8.056-3.944A12.01 12.01 0 0021.056 12a12.01 12.01 0 00-.438-3.016z" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Card 5: Non Steril --}}
    <div class="relative">
        <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
        <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
            <div class="mb-3 sm:mb-0">
                <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">Non Steril</p>
                <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ $totalNonSteril }}</h3>
            </div>
            <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-7 sm:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Card 6: In Vitro --}}
    <div class="relative">
        <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
        <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
            <div class="mb-3 sm:mb-0">
                <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">In Vitro</p>
                <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ $totalInvitro }}</h3>
            </div>
            <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-7 sm:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
        </div>
    </div>

</div>

 {{-- TOOLBAR SECTION --}}
    <div class="bg-white rounded-2xl p-4 mb-6 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        {{-- Left: Search & Filter --}}
        <div class="flex w-full md:w-auto gap-3">
            <form method="GET" action="{{ route('dashboard') }}" class="flex gap-3 items-center">
                <div class="relative w-full md:w-64">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search"
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-sm transition-all">
                </div>

                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = !open"
                        class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-800 shadow-sm flex items-center gap-2 transition-all">
                        <i class="fas fa-filter"></i> Filter
                    </button>

                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute mt-2 right-0 w-40 bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden z-50">
                        <a href="{{ route('dashboard', ['kategori' => 'semua']) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            Semua
                        </a>
                        <a href="{{ route('dashboard', ['kategori' => 'alat']) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            Alat
                        </a>
                        <a href="{{ route('dashboard', ['kategori' => 'reagen']) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            Reagen
                        </a>
                        {{-- Opsi Kategori Baru --}}
                        <a href="{{ route('dashboard', ['kategori' => 'steril', 'search' => request('search')]) }}"
                            class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 {{ request('kategori') == 'steril' ? 'bg-red-50 text-red-700 font-semibold' : '' }}">
                            Steril
                        </a>

                        <a href="{{ route('dashboard', ['kategori' => 'non steril', 'search' => request('search')]) }}"
                            class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 {{ request('kategori') == 'non steril' ? 'bg-red-50 text-red-700 font-semibold' : '' }}">
                            Non Steril
                        </a>

                        <a href="{{ route('dashboard', ['kategori' => 'invitro', 'search' => request('search')]) }}"
                            class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 {{ request('kategori') == 'invitro' ? 'bg-red-50 text-red-700 font-semibold' : '' }}">
                            In Vitro
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Right: Actions --}}
        <div class="flex w-full md:w-auto gap-3 justify-end">
            <a href="{{ route('produk.export', ['kategori' => request('kategori', 'semua'), 'search' => request('search')]) }}"
                class="px-4 py-2.5 bg-black text-white rounded-xl text-sm font-medium hover:bg-green-700 shadow-sm flex items-center gap-2 transition-all">
                <img src="{{ asset('icons/export.svg') }}" 
         alt="Export Excel" 
         class="w-5 h-5"> Export Excel
            </a>
            <a href="{{ route('produk.create') }}"
                class="px-4 py-2.5 bg-red-700 text-white rounded-xl text-sm font-medium hover:bg-red-800 shadow-sm flex items-center gap-2 transition-all">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
    </div>

{{-- TABLE SECTION --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left border-collapse table">
        <thead>
            <tr class="border-b border-gray-100 bg-white">
                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Product</th>
                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Kategori</th>
                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Pabrikan</th>
                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal</th>
                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-left">
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse ($produkTerbaru as $item)
                <tr class="hover:bg-gray-50 transition-colors">

                    {{-- Product --}}
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-4">
                            @if($item->gambar_utama)
                                <img src="{{ asset('storage/' . $item->gambar_utama) }}" alt="{{ $item->nama_produk }}"
                                    class="w-10 h-10 rounded-full object-cover border-2 border-red-200">
                            @else
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center border border-red-200">
                                    <div class="w-5 h-5 bg-red-500 rounded-full"></div>
                                </div>
                            @endif
                            <div>
                                <p class="font-bold text-gray-800 text-sm">{{ $item->nama_produk }}</p>
                                <p class="text-xs text-gray-500">{{ Str::limit($item->deskripsi_singkat, 30) }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Kategori --}}
                   <td class="py-4 px-6 text-black" data-label="Kategori">
                        {{ ucfirst($item->kategori) }}
                    </td>

                    {{-- Merk / Pabrikan --}}
                    <td class="py-4 px-6" data-label="Pabrikan">
                        <div class="flex flex-col">
                            {{-- Nama Pabrikan --}}
                            <span class="text-sm font-bold text-gray-700">
                                {{ $item->pabrikan->nama_pabrikan ?? '-' }}
                            </span>
                            {{-- Negara (Asumsi nama kolom di db adalah 'negara') --}}
                            <span class="text-xs text-gray-500 mt-0.5">
                                {{ $item->pabrikan->asal_negara ?? '-' }}
                            </span>
                        </div>
                    </td>

                    {{-- Tanggal --}}
                    <td class="py-4 px-6 text-sm text-gray-600" data-label="Tanggal">
                        {{ $item->created_at->format('d M Y') }}
                    </td>

                    {{-- Actions (Kolom 5) --}}
                    <td class="py-4 px-6" data-label="Action">
                        <div class="flex items-center justify-between w-full">

                            {{-- GRUP KIRI: Edit & Delete --}}
                            <div class="flex items-center gap-4">

                                {{-- Edit Button (SVG Image) --}}
                                <a href="{{ route('produk.edit', $item->produk_id) }}"
                                   class="group transition transform hover:scale-110" title="Edit">
                                    {{-- Pastikan nama file sesuai, misal: edit.svg --}}
                                    <img src="{{ asset('icons/edit.svg') }}" 
                                        alt="Edit" 
                                        class="w-5 h-5">
                                </a>

                                {{-- Delete Button (SVG Image) --}}
                                <form action="{{ route('produk.destroy', $item->produk_id) }}" method="POST"
                                        class="inline delete-form">
                                    @csrf @method('DELETE')
                                    {{-- Perhatikan class text-red-500 dan hover:text-red-700 di button ini --}}
                                    <button type="button" class="text-red-500 hover:text-red-700 transition btn-delete transform hover:scale-110 flex items-center"
                                            title="Hapus">
                                        
                                        {{-- Kode SVG Trash/Sampah ditaruh langsung di sini --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>

                                    </button>
                                </form>
                            </div>

                            {{-- GRUP KANAN: Detail Arrow --}}
                            <a href="{{ route('produk.show', $item->produk_id) }}"
                               class="text-gray-900 hover:text-gray-600 transition transform hover:scale-110 ml-4" title="Detail">
                                <i class="fas fa-chevron-right text-lg font-bold"></i>
                            </a>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <i class="fas fa-box-open text-5xl text-gray-300"></i>
                            <p class="text-gray-500 font-medium">Belum ada produk</p>
                            <a href="{{ route('produk.create') }}"
                                class="text-red-700 hover:text-red-800 font-semibold text-sm">
                                + Tambah Produk Pertama
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ---------------------------------------------------------------- --}}
@if($produkTerbaru->hasPages())
    {{-- Kontainer Paginasi di luar Card. Hanya menggunakan margin-top dan padding. --}}
    <div class="flex flex-col md:flex-row justify-between items-center mt-6 py-3 px-1">
        
        {{-- 1. Show Result Info (Menggunakan text-gray-500 untuk kesan transparan/halus) --}}
        <div class="text-gray-500 text-sm font-medium py-2 order-2 md:order-1">
            @if($produkTerbaru->total() > 0)
                <span class="text-sm tracking-wide">
                    Showing 
                    <span class="font-bold text-gray-700">{{ $produkTerbaru->firstItem() }}</span>
                    -
                    <span class="font-bold text-gray-700">{{ $produkTerbaru->lastItem() }}</span> 
                    of 
                    <span class="font-bold text-gray-700">{{ $produkTerbaru->total() }}</span> 
                    result{{ $produkTerbaru->total() !== 1 ? 's' : '' }}
                </span>
            @else
                <span class="text-sm tracking-wide text-gray-400">0 results found</span>
            @endif
        </div>

        {{-- 2. Tombol Paginasi (Tetap dengan desain kotak bulat) --}}
        <div class="flex items-center gap-2 order-1 md:order-2 mb-4 md:mb-0">

            {{-- Previous Button --}}
            <a href="{{ $produkTerbaru->previousPageUrl() }}" 
               @class([
                   'w-10 h-10 flex items-center justify-center border rounded-lg text-gray-600 transition-all duration-300 hover:scale-110 active:scale-95 text-sm',
                   'border-gray-300 hover:bg-gray-50 hover:border-red-700 hover:text-red-700' => !$produkTerbaru->onFirstPage(),
                   'opacity-30 cursor-not-allowed' => $produkTerbaru->onFirstPage(),
               ])
               title="Previous"
               >
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </a>

            {{-- Page Numbers --}}
            @foreach ($produkTerbaru->getUrlRange(1, $produkTerbaru->lastPage()) as $page => $url)
                <a href="{{ $url }}"
                   @class([
                       'w-10 h-10 flex items-center justify-center border rounded-lg font-medium transition-all duration-300 hover:scale-110 active:scale-95 text-sm',
                       'bg-red-700 text-white border-red-700 scale-110' => $page == $produkTerbaru->currentPage(),
                       'border-gray-300 text-gray-600 hover:bg-gray-50 hover:border-red-700 hover:text-red-700' => $page != $produkTerbaru->currentPage(),
                   ])
                   >{{ $page }}</a>
            @endforeach

            {{-- Next Button --}}
            <a href="{{ $produkTerbaru->nextPageUrl() }}" 
               @class([
                   'w-10 h-10 flex items-center justify-center border rounded-lg text-gray-600 transition-all duration-300 hover:scale-110 active:scale-95 text-sm',
                   'border-gray-300 hover:bg-gray-50 hover:border-red-700 hover:text-red-700' => $produkTerbaru->hasMorePages(),
                   'opacity-30 cursor-not-allowed' => !$produkTerbaru->hasMorePages(),
               ])
               title="Next"
               >
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        </div>
    </div>
@endif


{{-- SWEETALERT LOGIC --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ... (SweetAlert Logic Anda tetap sama)
        // Logic Hapus
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data produk tidak dapat dikembalikan setelah dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Logic Alert Success/Error
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>

@endsection