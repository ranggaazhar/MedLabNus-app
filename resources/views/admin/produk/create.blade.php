@extends('admin.layouts.app')

@section('title', 'Add Product')

@section('content')

    {{-- Form Pembungkus --}}
    <form id="productForm" action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            
            <div class="mb-4 md:mb-0">
                {{-- Breadcrumb --}}
                <p class="text-sm text-gray-500">
                    {{-- Mengubah teks 'Dashboard' menjadi link --}}
                    <a href="{{ route('dashboard') }}" class="hover:text-red-700 transition duration-150">
                        Dashboard
                    </a>
                    / Add Product
                </p>
                
                {{-- Title & Subtitle --}}
                <h1 class="text-3xl font-extrabold text-gray-800 mt-1">Tambah Product</h1>
                <p class="text-gray-500">Lengkapi informasi produk medical equipment</p>
            </div>
            
            {{-- Tombol Save Product --}}
            {{-- Menggunakan type="submit" untuk mengirim form di atas --}}
            <button type="submit" form="productForm" class="bg-red-700 hover:bg-red-800 text-white rounded-lg px-6 py-3 text-base font-medium shadow-md transition-colors flex items-center gap-2">
                <i class="fas fa-save"></i> Save Product
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-1 mb-8">
            <div class="flex text-gray-500 font-semibold text-sm">
                
                {{-- Tab Aktif: INFO DASAR --}}
                <div class="px-6 py-3 cursor-pointer text-gray-800 border-b-2 border-red-600">
                    INFO DASAR
                </div>
                
                {{-- Tab Non-Aktif --}}
                <div class="px-6 py-3 cursor-pointer hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors">
                    SPESIFIKASI
                </div>
                
                <div class="px-6 py-3 cursor-pointer hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors">
                    FITUR
                </div>
                
                <div class="px-6 py-3 cursor-pointer hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors">
                    GAMBAR
                </div>

            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Utama</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- 1. Nama Product --}}
                <div>
                    <label for="nama_produk" class="block text-sm font-semibold text-gray-700 mb-2">Nama Product</label>
                    <input type="text" name="nama_produk" id="nama_produk" placeholder="Contoh: Chemistry Analyzer" 
                        value="{{ old('nama_produk') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">
                    @error('nama_produk') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- 2. Model Product --}}
                <div>
                    <label for="model_produk" class="block text-sm font-semibold text-gray-700 mb-2">Model Product</label>
                    <input type="text" name="model_produk" id="model_produk" placeholder="Contoh: A15" 
                        value="{{ old('model_produk') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">
                    @error('model_produk') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- 3. Merk (Pabrikan) --}}
                <div>
                    <label for="pabrikan_id" class="block text-sm font-semibold text-gray-700 mb-2">Merk</label>
                    <select name="pabrikan_id" id="pabrikan_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">
                        <option value="">Pilih Merk / Pabrikan</option>
                        {{-- Looping data Pabrikan dari Controller --}}
                        @foreach ($pabrikans as $pabrikan)
                            <option value="{{ $pabrikan->id }}" {{ old('pabrikan_id') == $pabrikan->id ? 'selected' : '' }}>
                                {{ $pabrikan->nama_pabrikan }}
                            </option>
                        @endforeach
                    </select>
                    @error('pabrikan_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

            </div>
            
            {{-- 5. Deskripsi (Full Width) --}}
            <div class="mt-6">
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="5" placeholder="Deskripsi Lengkap Product"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
        </div>

    </form>

@endsection