@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- STAT CARDS SECTION --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        {{-- Card 1: Product --}}
        <div
            class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex justify-between items-center relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-700 rounded-l-2xl"></div>

            <div class="pl-4">
                <p class="text-gray-500 text-sm font-medium mb-1">Product</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $totalProduk }}</h3>
            </div>
            <div class="bg-red-700 w-12 h-12 rounded-xl flex items-center justify-center shadow-red-200 shadow-lg">
                <i class="fas fa-box text-white text-xl"></i>
            </div>
        </div>

        {{-- Card 2: Alat --}}
        <div
            class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex justify-between items-center relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-700 rounded-l-2xl"></div>

            <div class="pl-4">
                <p class="text-gray-500 text-sm font-medium mb-1">Alat</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $totalAlat }}</h3>
            </div>
            <div class="bg-red-700 w-12 h-12 rounded-xl flex items-center justify-center shadow-red-200 shadow-lg">
                <i class="fas fa-briefcase-medical text-white text-xl"></i>
            </div>
        </div>

        {{-- Card 3: Reagen --}}
        <div
            class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex justify-between items-center relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-700 rounded-l-2xl"></div>

            <div class="pl-4">
                <p class="text-gray-500 text-sm font-medium mb-1">Reagen</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $totalReagen }}</h3>
            </div>
            <div class="bg-red-700 w-12 h-12 rounded-xl flex items-center justify-center shadow-red-200 shadow-lg">
                <i class="fas fa-flask text-white text-xl"></i>
            </div>
        </div>
    </div>

    {{-- TOOLBAR SECTION --}}
    <div
        class="bg-white rounded-2xl p-4 mb-6 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">

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
                class="px-4 py-2.5 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 shadow-sm flex items-center gap-2 transition-all">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('produk.create') }}"
                class="px-4 py-2.5 bg-red-700 text-white rounded-xl text-sm font-medium hover:bg-red-800 shadow-sm flex items-center gap-2 transition-all">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
    </div>

    {{-- TABLE SECTION (REVISI: Menambahkan data-label untuk Mobile Card View) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Hapus overflow-x-auto, karena kita akan menggunakan Card View di mobile --}}
        {{-- <div class="overflow-x-auto"> --}}
            <table class="w-full text-left border-collapse table"> {{-- Tambahkan class 'table' --}}
                <thead>
                    <tr class="border-b border-gray-100 bg-white">
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Product</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Kategori</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Merk</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Action
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($produkTerbaru as $item)
                        <tr class="hover:bg-gray-50 transition-colors">

                            {{-- Product (Kolom 1 - TIDAK ADA data-label) --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    @if($item->gambar_utama)
                                        <img src="{{ asset('storage/' . $item->gambar_utama) }}" alt="{{ $item->nama_produk }}"
                                            class="w-10 h-10 rounded-full object-cover border-2 border-red-200">
                                    @else
                                        <div
                                            class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center border border-red-200">
                                            <div class="w-5 h-5 bg-red-500 rounded-full"></div>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">{{ $item->nama_produk }}</p>
                                        <p class="text-xs text-gray-500">{{ Str::limit($item->deskripsi_singkat, 30) }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Kategori (Kolom 2) --}}
                            <td class="py-4 px-6" data-label="Kategori">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold 
                                    {{ $item->kategori == 'alat' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                    {{ ucfirst($item->kategori) }}
                                </span>
                            </td>

                            {{-- Merk (Kolom 3) --}}
                            <td class="py-4 px-6 text-sm font-medium text-gray-700" data-label="Merk">
                                {{ $item->pabrikan->nama_pabrikan ?? '-' }}
                            </td>

                            {{-- Tanggal (Kolom 4) --}}
                            <td class="py-4 px-6 text-sm text-gray-600" data-label="Tanggal">
                                {{ $item->created_at->format('d M Y') }}
                            </td>

                            {{-- Actions (Kolom 5) --}}
                            <td class="py-4 px-6" data-label="Action">
                                <div class="flex items-center justify-end gap-3 md:justify-center"> {{-- Rata kanan di mobile,
                                    tengah di desktop --}}

                                    <a href="{{ route('produk.show', $item->produk_id) }}"
                                        class="p-2 text-blue-600 hover:text-blue-800 transition" title="Detail">
                                        <i class="fas fa-eye text-lg"></i>
                                    </a>

                                    <a href="{{ route('produk.edit', $item->produk_id) }}"
                                        class="p-2 text-gray-600 hover:text-black transition" title="Edit">
                                        <i class="fas fa-pen-to-square text-lg"></i>
                                    </a>

                                    <form action="{{ route('produk.destroy', $item->produk_id) }}" method="POST"
                                        class="inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="p-2 text-red-500 hover:text-red-700 transition btn-delete"
                                            title="Hapus">
                                            <i class="fas fa-trash-can text-lg"></i>
                                        </button>
                                    </form>

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
            {{-- Hapus div overflow-x-auto --}}
        </div>

        {{-- Pagination --}}
        @if($produkTerbaru->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $produkTerbaru->links() }}
            </div>
        @endif
    </div>

    {{-- SWEETALERT DELETE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

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


            @if(session('success') || session('error'))
                            < script >
                            (function () {
                                const success = {!! json_encode(session('success')) !!};
                                const error = {!! json_encode(session('error')) !!};
                                if (success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses',
                                        text: success,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                                if (error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: error,
                                        timer: 3000,
                                        showConfirmButton: false
                                    });
                                }
                            })();
                </script>
            @endif
    </script>

@endsection