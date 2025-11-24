@extends('admin.layouts.app')

@section('title', 'Edit Pabrikan')

@section('content')

    {{-- Form Pembungkus --}}
    <form id="pabrikanForm" action="{{ route('pabrikan.update', $pabrikan->pabrikan_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        {{-- HEADER: Breadcrumb, Title, Subtitle, dan Tombol Save --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            
            <div class="mb-4 md:mb-0">
                {{-- Breadcrumb --}}
                <p class="text-sm text-gray-500">
                    <a href="{{ route('pabrikan.index') }}" class="hover:text-red-700 transition duration-150">
                        Pabrikan
                    </a>
                    / Edit Pabrikan
                </p>
                
                {{-- Title & Subtitle --}}
                <h1 class="text-3xl font-extrabold text-gray-800 mt-1">Edit Pabrikan</h1>
                <p class="text-gray-500">Perbarui informasi pabrikan</p>
            </div>
            
            {{-- Tombol Save Pabrikan (Menggunakan styling Product) --}}
            <div class="flex gap-3">
                <a href="{{ route('pabrikan.show', $pabrikan->pabrikan_id) }}" 
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg px-6 py-3 text-base font-medium shadow-sm transition-colors flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" form="pabrikanForm" id="saveButton" class="bg-red-700 hover:bg-red-800 text-white rounded-lg px-6 py-3 text-base font-medium shadow-md transition-colors flex items-center gap-2">
                    <i class="fas fa-save"></i> Update Pabrikan
                </button>
            </div>
        </div>

        {{-- CONTAINER UTAMA FORM (Menggunakan styling Product) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Dasar Pabrikan</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- 1. Nama Pabrikan --}}
                <div>
                    <label for="nama_pabrikan" class="block text-sm font-semibold text-gray-700 mb-2">Nama Pabrikan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_pabrikan" id="nama_pabrikan" placeholder="Contoh: General Electric" 
                        value="{{ old('nama_pabrikan', $pabrikan->nama_pabrikan) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">
                    @error('nama_pabrikan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- 2. Asal Negara (Input Text) --}}
                <div>
                    <label for="asal_negara" class="block text-sm font-semibold text-gray-700 mb-2">Asal Negara <span class="text-red-500">*</span></label>
                    <input type="text" name="asal_negara" id="asal_negara" placeholder="Contoh: Amerika Serikat" 
                        value="{{ old('asal_negara', $pabrikan->asal_negara) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">
                    @error('asal_negara') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

            </div>
            
            {{-- 3. Logo Pabrikan (Dropzone Style, Full Width) --}}
            <div class="mt-6">
                <label for="logo_pabrikan_input" class="block text-sm font-semibold text-gray-700 mb-2">Logo Pabrikan</label>
                
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition duration-150 relative">
                    <div id="uploadPlaceholder" class="{{ $pabrikan->logo_pabrikan ? 'hidden' : '' }}">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l-5.172 5.172a4 4 0 01-5.656 0L12 32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">
                            Drag your file or 
                            <label for="logo_pabrikan_input" class="text-red-600 font-semibold cursor-pointer hover:text-red-500">browse</label>
                        </p>
                        <p class="text-xs text-gray-500">Max 10 MB files are allowed (PNG, JPG/JPEG)</p>
                    </div>
                    
                    {{-- Pratinjau Gambar Saat Ini --}}
                    <div id="imagePreviewContainer" class="absolute inset-0 flex items-center justify-center p-2 bg-white rounded-lg {{ $pabrikan->logo_pabrikan ? '' : 'hidden' }}">
                        @if($pabrikan->logo_pabrikan)
                            <img id="logoPreview" src="{{ asset('storage/' . $pabrikan->logo_pabrikan) }}" class="max-h-full max-w-full object-contain" alt="Logo Pabrikan" />
                        @else
                            <img id="logoPreview" class="max-h-full max-w-full object-contain" alt="Logo Pabrikan Preview" />
                        @endif
                    </div>
                    
                    {{-- Input File Sebenarnya (Disembunyikan, dipicu oleh label 'browse') --}}
                    <input type="file" name="logo_pabrikan" id="logo_pabrikan_input" accept="image/png, image/jpeg" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                </div>
                
                @error('logo_pabrikan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

    </form>

@vite('resources/js/admin/create.js')

@endsection
