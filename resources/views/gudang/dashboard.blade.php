@extends('admin.layouts.app')

@section('title', 'Dashboard Gudang')

@section('content')

    {{-- TOP NAVBAR OVERVIEW / HEADER --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Dashboard Gudang</h1>
            <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mt-1">Sistem Manajemen Stok PT Medlab Nusantara</p>
        </div>
    </div>

    {{-- 1. FOUR TOP METRIC CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        
        {{-- Card 1: Total Stok --}}
        <div class="relative">
            <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
            <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
                <div class="mb-3 sm:mb-0">
                    <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">Total Stok</p>
                    <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ number_format($totalStok ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                    <i class="fa-solid fa-boxes-stacked text-white text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Card 2: Stok Menipis --}}
        <div class="relative">
            <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
            <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
                <div class="mb-3 sm:mb-0">
                    <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">Stok Menipis</p>
                    <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ number_format($stokMenipisCount ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                    <i class="fa-solid fa-triangle-exclamation text-white text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Card 3: Habis --}}
        <div class="relative">
            <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
            <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
                <div class="mb-3 sm:mb-0">
                    <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">Stok Habis</p>
                    <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ number_format($stokHabisCount ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                    <i class="fa-solid fa-circle-xmark text-white text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Card 4: Mutasi Hari Ini --}}
        <div class="relative">
            <div class="absolute inset-0 bg-red-700 rounded-2xl"></div>
            <div class="relative bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-1.5 h-full">
                <div class="mb-3 sm:mb-0">
                    <p class="text-gray-500 text-[11px] sm:text-sm font-medium mb-1 uppercase sm:normal-case">Mutasi Hari Ini</p>
                    <h3 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ number_format($mutasiHariIni ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-red-700 w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center self-end sm:self-center">
                    <i class="fa-solid fa-truck-ramp-box text-white text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. BOTTOM TABLES ROW (BARANG STOK MENIPIS & MUTASI TERBARU) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Kolom Kiri: Barang Stok Menipis --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-800">Barang Stok Menipis</h2>
                    <a href="{{ route('produk.index') }}" class="text-xs font-bold text-red-700 hover:underline">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-[10px] font-black text-gray-300 uppercase tracking-wider bg-gray-50/50">
                                <th class="py-3 px-4 font-semibold">Gambar</th>
                                <th class="py-3 px-4 font-semibold">Nama Produk</th>
                                <th class="py-3 px-4 font-semibold text-right">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs text-gray-600 divide-y divide-gray-50">
                            @forelse($stokMenipisList as $item)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden border border-gray-100 flex-shrink-0 bg-white">
                                            @if($item['produk']->gambar_utama)
                                                <img src="{{ asset($item['produk']->gambar_utama) }}" alt="{{ $item['produk']->nama_produk }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gray-50 flex items-center justify-center text-gray-300">
                                                    <i class="fa-regular fa-image text-base"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 font-bold text-gray-700">
                                        {{ $item['produk']->nama_produk }}
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <span class="px-2 py-1 rounded text-[9px] font-black uppercase tracking-tighter bg-red-50 text-red-600 border border-red-100">
                                            {{ $item['sisa'] }} Pcs
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-gray-400">Tidak ada barang dengan stok menipis saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Aktivitas Mutasi Terbaru --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-800">Aktivitas Mutasi Terbaru</h2>
                    <a href="{{ route('stok-mutasi.index') }}" class="text-xs font-bold text-red-700 hover:underline">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-[10px] font-black text-gray-300 uppercase tracking-wider bg-gray-50/50">
                                <th class="py-3 px-4 font-semibold">Tipe</th>
                                <th class="py-3 px-4 font-semibold">Nama Produk</th>
                                <th class="py-3 px-4 font-semibold text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs text-gray-600 divide-y divide-gray-50">
                            @forelse($mutasiTerbaru as $mutasi)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3 px-4">
                                        @if(strtolower($mutasi->tipe) == 'masuk')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-tighter bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                <i class="fa-solid fa-arrow-down-long text-[8px]"></i> Masuk
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-tighter bg-amber-50 text-amber-600 border border-amber-100">
                                                <i class="fa-solid fa-arrow-up-long text-[8px]"></i> Keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 font-bold text-gray-700">
                                        {{ $mutasi->produk->nama_produk ?? 'Produk Dihapus' }}
                                    </td>
                                    <td class="py-3 px-4 text-right font-medium text-gray-700">
                                        {{ $mutasi->jumlah }} Pcs
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-gray-400">Belum ada aktivitas mutasi terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection
