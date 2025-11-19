@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    
    {{-- STAT CARDS SECTION --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        {{-- Card 1: Product --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex justify-between items-center relative overflow-hidden">
            {{-- Red Accent Left Border --}}
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-700 rounded-l-2xl"></div>
            
            <div class="pl-4">
                <p class="text-gray-500 text-sm font-medium mb-1">Product</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $totalProduk ?? 29 }}</h3>
            </div>
            <div class="bg-red-700 w-12 h-12 rounded-xl flex items-center justify-center shadow-red-200 shadow-lg">
                <i class="fas fa-box text-white text-xl"></i>
            </div>
        </div>

        {{-- Card 2: Alat --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex justify-between items-center relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-700 rounded-l-2xl"></div>
            
            <div class="pl-4">
                <p class="text-gray-500 text-sm font-medium mb-1">Alat</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $totalAlat ?? 209 }}</h3>
            </div>
            <div class="bg-red-700 w-12 h-12 rounded-xl flex items-center justify-center shadow-red-200 shadow-lg">
                <i class="fas fa-briefcase-medical text-white text-xl"></i>
            </div>
        </div>

        {{-- Card 3: Reagen --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex justify-between items-center relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-700 rounded-l-2xl"></div>
            
            <div class="pl-4">
                <p class="text-gray-500 text-sm font-medium mb-1">Reagen</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $totalReagen ?? 209 }}</h3>
            </div>
            <div class="bg-red-700 w-12 h-12 rounded-xl flex items-center justify-center shadow-red-200 shadow-lg">
                <i class="fas fa-flask text-white text-xl"></i>
            </div>
        </div>
    </div>

  {{-- TOOLBAR SECTION (Search + Buttons) --}}
    {{-- SEKARANG DIBUNGKUS CARD: bg-white, rounded, shadow --}}
    <div class="bg-white rounded-2xl p-4 mb-6 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        
        {{-- Left: Search & Filter --}}
        <div class="flex w-full md:w-auto gap-3">
            <div class="relative w-full md:w-64">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                {{-- Saya ubah bg-white jadi bg-gray-50 supaya inputnya terlihat kontras di dalam card putih --}}
                <input type="text" placeholder="Search" 
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-sm transition-all">
            </div>
            <button class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-800 shadow-sm flex items-center gap-2 transition-all">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>

        {{-- Right: Actions --}}
        <div class="flex w-full md:w-auto gap-3 justify-end">
            <button class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-black shadow-sm flex items-center gap-2 transition-all">
                <i class="fas fa-download"></i> Import
            </button>
            <button class="px-4 py-2.5 bg-black text-white rounded-xl text-sm font-medium hover:bg-gray-800 shadow-sm flex items-center gap-2 transition-all">
                <i class="fas fa-upload"></i> Export
            </button>
            <a href="{{ route('produk.create') }}" class="px-4 py-2.5 bg-red-700 text-white rounded-xl text-sm font-medium hover:bg-red-800 shadow-sm flex items-center gap-2 transition-all">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
        </div>

    {{-- TABLE SECTION --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 bg-white">
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Product</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Merk</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Negara</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($produkTerbaru as $item)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            
                            {{-- Product Column --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 border border-red-200">
                                        {{-- Lingkaran Merah seperti di gambar --}}
                                        <div class="w-5 h-5 bg-red-500 rounded-full"></div>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">{{ $item->nama_produk }}</p>
                                        <p class="text-xs text-gray-500">Model: {{ $item->model ?? 'A15' }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Merk --}}
                            <td class="py-4 px-6 text-sm font-medium text-gray-700">
                                {{ $item->pabrikan->nama_pabrikan ?? 'Biosystem' }}
                            </td>

                            {{-- Tanggal --}}
                            <td class="py-4 px-6 text-sm text-gray-600">
                                {{ $item->created_at ? $item->created_at->format('d F Y') : '6 April 2023' }}
                            </td>

                            {{-- Negara --}}
                            <td class="py-4 px-6">
                                <div class="text-sm font-bold text-gray-800">{{ $item->pabrikan->nama_pabrikan ?? 'PT Medlab Nusantara' }}</div>
                                <div class="text-xs text-gray-500">{{ $item->negara ?? 'Indonesia' }}</div>
                            </td>

                            {{-- Actions --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('produk.edit', $item->id) }}" class="p-2 text-gray-600 hover:text-black transition">
                                        <i class="fas fa-pen-to-square text-lg"></i> {{-- Icon Edit Kotak --}}
                                    </a>
                                    <form action="{{ route('produk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:text-red-700 transition">
                                            <i class="fas fa-trash-can text-lg"></i> {{-- Icon Sampah --}}
                                        </button>
                                    </form>
                                    <a href="{{ route('produk.show', $item->id) }}" class="p-2 text-gray-400 hover:text-gray-800 transition">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($produkTerbaru->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-center">
            {{ $produkTerbaru->links() }}
        </div>
        @endif
    </div>

@endsection