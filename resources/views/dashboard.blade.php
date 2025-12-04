@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- STAT CARDS SECTION --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- (Bagian Stat Cards tetap sama, tidak saya ubah) --}}
    {{-- Card 1: Product --}}
    <div class="relative">
        <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
        <div class="relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex justify-between items-center ml-1.5">
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Product</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $totalProduk }}</h3>
            </div>
            <div class="bg-red-700 w-14 h-14 rounded-xl flex items-center justify-center">
                <img src="{{ asset('icons/box.svg') }}" alt="Product Icon" class="w-7 h-7 object-contain filter brightness-0 invert">
            </div>
        </div>
    </div>

    {{-- Card 2: Alat --}}
    <div class="relative">
        <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
        <div class="relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex justify-between items-center ml-1.5">
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Alat</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $totalAlat }}</h3>
            </div>
            <div class="bg-red-700 w-14 h-14 rounded-xl flex items-center justify-center">
                <img src="{{ asset('icons/pk.svg') }}" alt="Alat Icon" class="w-7 h-7 object-contain filter brightness-0 invert">
            </div>
        </div>
    </div>

    {{-- Card 3: Reagen --}}
    <div class="relative">
        <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
        <div class="relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex justify-between items-center ml-1.5">
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Reagen</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $totalReagen }}</h3>
            </div>
            <div class="bg-red-700 w-14 h-14 rounded-xl flex items-center justify-center">
                <img src="{{ asset('icons/lab.svg') }}" alt="Reagen Icon" class="w-7 h-7 object-contain filter brightness-0 invert">
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
                        {{-- PERUBAHAN DI SINI --}}
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
                    {{-- 'stroke="currentColor"' memastikan warna mengikuti text-red-500 dari button --}}
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

    {{-- Pagination --}}
    @if($produkTerbaru->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $produkTerbaru->links() }}
        </div>
    @endif


    {{-- SWEETALERT LOGIC --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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