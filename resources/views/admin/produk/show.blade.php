@extends('admin.layouts.app')

@section('title', 'Detail Produk')

@section('content')

    {{-- Breadcrumb & Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <p class="text-sm text-gray-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-red-700 transition">Dashboard</a> / 

                Detail
            </p>
            <h1 class="text-3xl font-extrabold text-gray-800 mt-1">Detail Produk</h1>
        </div>
        
        <div class="flex gap-3 mt-4 md:mt-0">
            <a href="{{ route('produk.index') }}" 
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg px-6 py-3 text-base font-medium shadow-sm transition-colors flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Left Column: Image & Quick Info --}}
        <div class="lg:col-span-1 space-y-6">
            
            {{-- Product Image --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Gambar Produk</h3>
                @if($produk->gambar_utama)
                    <img src="{{ asset('storage/' . $produk->gambar_utama) }}" 
                        alt="{{ $produk->nama_produk }}"
                        class="w-full h-64 object-cover rounded-lg border-2 border-gray-200">
                @else
                    <div class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-gray-200">
                        <div class="text-center">
                            <i class="fas fa-image text-5xl text-gray-300 mb-2"></i>
                            <p class="text-sm text-gray-500">Tidak ada gambar</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Quick Info Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Cepat</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tag text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Kategori</p>
                            <p class="font-semibold text-gray-800">{{ ucfirst($produk->kategori) }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-industry text-red-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Pabrikan</p>
                            <p class="font-semibold text-gray-800">{{ $produk->pabrikan->nama_pabrikan ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Ditambahkan</p>
                            <p class="font-semibold text-gray-800">{{ $produk->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Details --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Basic Information --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $produk->nama_produk }}</h2>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $produk->kategori == 'alat' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($produk->kategori) }}
                            </span>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-building mr-1"></i>
                                {{ $produk->pabrikan->nama_pabrikan ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <h3 class="text-sm font-bold text-gray-400 uppercase mb-3">Deskripsi</h3>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $produk->deskripsi_singkat ?? 'Tidak ada deskripsi' }}
                    </p>
                </div>
            </div>

            {{-- Specifications --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Spesifikasi Teknis</h3>
                
                @if($produk->spesifikasis->count() > 0)
                    <div class="space-y-4">
                        @foreach($produk->spesifikasis as $spec)
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-red-300 transition-colors">
                                <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-cog text-red-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 mb-1">{{ $spec->nama_spesifikasi }}</p>
                                    <p class="text-sm text-gray-600">{{ $spec->nilai }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-clipboard-list text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Belum ada spesifikasi</p>
                        <a href="{{ route('produk.edit', $produk->produk_id) }}" class="text-red-700 hover:text-red-800 font-semibold text-sm mt-2 inline-block">
                            Tambah Spesifikasi
                        </a>
                    </div>
                @endif
            </div>

            {{-- Additional Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Informasi Tambahan</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">ID Produk</p>
                        <p class="font-mono text-sm font-semibold text-gray-800">#{{ $produk->produk_id }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">Terakhir Diupdate</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $produk->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection