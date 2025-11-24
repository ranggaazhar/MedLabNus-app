@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')

    {{-- Form Pembungkus --}}
    <form id="productForm" action="{{ route('produk.update', $produk->produk_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            
            <div class="mb-4 md:mb-0">
                {{-- Breadcrumb --}}
                <p class="text-sm text-gray-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-red-700 transition duration-150">Dashboard</a> / 
                    Edit
                </p>
                
                {{-- Title & Subtitle --}}
                <h1 class="text-3xl font-extrabold text-gray-800 mt-1">Edit Product</h1>
                <p class="text-gray-500">Perbarui informasi produk medical equipment</p>
            </div>
            
            {{-- Action Buttons --}}
            <div class="flex gap-3">
                <a href="{{ route('produk.show', $produk->produk_id) }}" 
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg px-6 py-3 text-base font-medium shadow-sm transition-colors flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" form="productForm" 
                    class="bg-red-700 hover:bg-red-800 text-white rounded-lg px-6 py-3 text-base font-medium shadow-md transition-colors flex items-center gap-2">
                    <i class="fas fa-save"></i> Update Product
                </button>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Tab Navigation --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-1 mb-8">
            <div class="flex text-gray-500 font-semibold text-sm">
                
                <button type="button" data-tab="info-dasar" class="tab-btn px-6 py-3 cursor-pointer text-gray-800 border-b-2 border-red-600 transition-colors">
                    INFO DASAR
                </button>
                
                <button type="button" data-tab="spesifikasi" class="tab-btn px-6 py-3 cursor-pointer text-gray-500 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors">
                    SPESIFIKASI
                </button>
                
                <button type="button" data-tab="gambar" class="tab-btn px-6 py-3 cursor-pointer text-gray-500 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors">
                    GAMBAR
                </button>

            </div>
        </div>

        {{-- TAB CONTENT 1: INFO DASAR --}}
        <div id="tab-info-dasar" class="tab-content bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Utama</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- 1. Nama Product --}}
                <div>
                    <label for="nama_produk" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Product <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_produk" id="nama_produk" 
                        placeholder="Contoh: Chemistry Analyzer" 
                        value="{{ old('nama_produk', $produk->nama_produk) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">
                    @error('nama_produk') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- 2. Merk (Pabrikan) --}}
                <div>
                    <label for="pabrikan_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Merk <span class="text-red-500">*</span>
                    </label>
                    <select name="pabrikan_id" id="pabrikan_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">
                        <option value="">Pilih Merk / Pabrikan</option>
                        @foreach ($pabrikans as $pabrikan)
                            <option value="{{ $pabrikan->pabrikan_id }}" 
                                {{ old('pabrikan_id', $produk->pabrikan_id) == $pabrikan->pabrikan_id ? 'selected' : '' }}>
                                {{ $pabrikan->nama_pabrikan }}
                            </option>
                        @endforeach
                    </select>
                    @error('pabrikan_id') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- 3. Kategori --}}
                <div>
                    <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori" id="kategori" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">
                        <option value="">Pilih Kategori</option>
                        <option value="reagen" {{ old('kategori', $produk->kategori) == 'reagen' ? 'selected' : '' }}>Reagen</option>
                        <option value="alat" {{ old('kategori', $produk->kategori) == 'alat' ? 'selected' : '' }}>Alat</option>
                    </select>
                    @error('kategori') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

            </div>
            
            {{-- 5. Deskripsi Singkat (Full Width) --}}
            <div class="mt-6">
                <label for="deskripsi_singkat" class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi Singkat
                </label>
                <textarea name="deskripsi_singkat" id="deskripsi_singkat" rows="5" 
                    placeholder="Deskripsi singkat produk..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">{{ old('deskripsi_singkat', $produk->deskripsi_singkat) }}</textarea>
                @error('deskripsi_singkat') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>
        </div>

        {{-- TAB CONTENT 2: SPESIFIKASI --}}
        <div id="tab-spesifikasi" class="tab-content hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Spesifikasi Produk</h2>
                <button type="button" id="addSpecBtn" 
                    class="bg-red-700 hover:bg-red-800 text-white rounded-lg px-4 py-2 text-sm font-medium transition-colors flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Spesifikasi
                </button>
            </div>

            <div id="specContainer" class="space-y-4">
                {{-- Existing Specifications --}}
                @foreach($produk->spesifikasis as $index => $spec)
                    <div class="spec-item bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Spesifikasi</label>
                                <input type="text" name="spesifikasi[{{ $index }}][nama_spesifikasi]" 
                                    placeholder="Contoh: Throughput, Kapasitas, Dimensi" 
                                    value="{{ old('spesifikasi.'.$index.'.nama_spesifikasi', $spec->nama_spesifikasi) }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-red-500 focus:ring-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Spesifikasi</label>
                                <input type="text" name="spesifikasi[{{ $index }}][nilai]" 
                                    placeholder="Contoh: 200 tests/hour, 500 mL, 30 x 40 x 50 cm" 
                                    value="{{ old('spesifikasi.'.$index.'.nilai', $spec->nilai) }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-red-500 focus:ring-red-500">
                            </div>
                            <div class="flex justify-end">
                                <button type="button" class="removeSpecBtn text-red-600 hover:text-red-800 transition-colors text-sm font-medium flex items-center gap-1">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Tips:</strong> Tambahkan spesifikasi teknis seperti throughput, kapasitas, dimensi, berat, voltase, dll.
                </p>
            </div>
        </div>

        {{-- TAB CONTENT 3: GAMBAR --}}
        <div id="tab-gambar" class="tab-content hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Upload Gambar Produk</h2>
            
            <div class="max-w-2xl">
                {{-- Current Image --}}
                @if($produk->gambar_utama)
                    <div class="mb-6">
                        <p class="text-sm font-semibold text-gray-700 mb-3">Gambar Saat Ini:</p>
                        <div class="relative inline-block">
                            <img src="{{ asset('storage/' . $produk->gambar_utama) }}" 
                                alt="{{ $produk->nama_produk }}" 
                                class="h-48 w-auto object-cover rounded-lg border-2 border-gray-200 shadow-md">
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Upload gambar baru untuk menggantinya</p>
                    </div>
                @endif

                {{-- Upload New Image --}}
                <div class="mb-6">
                    <label for="gambar_utama" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ $produk->gambar_utama ? 'Ganti Gambar Produk' : 'Gambar Utama Produk' }}
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-red-500 transition-colors">
                        <input type="file" name="gambar_utama" id="gambar_utama" accept="image/*" class="hidden">
                        <label for="gambar_utama" class="cursor-pointer">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-600 mb-1">Klik untuk upload gambar baru</p>
                                <p class="text-xs text-gray-500">Format: JPG, PNG, GIF (Max: 2MB)</p>
                            </div>
                        </label>
                    </div>
                    @error('gambar_utama') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>
                
                {{-- Preview Gambar Baru --}}
                <div id="imagePreview" class="hidden">
                    <p class="text-sm font-semibold text-gray-700 mb-3">Preview Gambar Baru:</p>
                    <div class="relative inline-block">
                        <img src="" alt="Preview" class="h-48 w-auto object-cover rounded-lg border-2 border-gray-200 shadow-md">
                        <button type="button" id="removeImageBtn" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-2 hover:bg-red-700 transition-colors shadow-lg">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>

    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetTab = this.getAttribute('data-tab');
                    
                    console.log('Switching to tab:', targetTab); 
                    
                    tabButtons.forEach(btn => {
                        btn.classList.remove('text-gray-800', 'border-b-2', 'border-red-600');
                        btn.classList.add('text-gray-500');
                    });
                    
                    this.classList.remove('text-gray-500');
                    this.classList.add('text-gray-800', 'border-b-2', 'border-red-600');
                    
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    
                    const targetContent = document.getElementById('tab-' + targetTab);
                    if (targetContent) {
                        targetContent.classList.remove('hidden');
                    }
                });
            });

            let specIndex = {{ $produk->spesifikasis->count() }};

            document.getElementById('addSpecBtn').addEventListener('click', function() {
                const container = document.getElementById('specContainer');
                const newSpec = `
                    <div class="spec-item bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Spesifikasi</label>
                                <input type="text" name="spesifikasi[${specIndex}][nama_spesifikasi]" 
                                    placeholder="Contoh: Throughput, Kapasitas, Dimensi" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-red-500 focus:ring-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Spesifikasi</label>
                                <input type="text" name="spesifikasi[${specIndex}][nilai]" 
                                    placeholder="Contoh: 200 tests/hour, 500 mL, 30 x 40 x 50 cm" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-red-500 focus:ring-red-500">
                            </div>
                            <div class="flex justify-end">
                                <button type="button" class="removeSpecBtn text-red-600 hover:text-red-800 transition-colors text-sm font-medium flex items-center gap-1">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', newSpec);
                specIndex++;
            });

            document.addEventListener('click', function(e) {
                if (e.target.closest('.removeSpecBtn')) {
                    if (confirm('Hapus spesifikasi ini?')) {
                        e.target.closest('.spec-item').remove();
                    }
                }
            });

            const fileInput = document.getElementById('gambar_utama');
            const preview = document.getElementById('imagePreview');
            const previewImg = preview.querySelector('img');
            const removeBtn = document.getElementById('removeImageBtn');

            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 2048000) {
                        alert('Ukuran file maksimal 2MB!');
                        fileInput.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });

            removeBtn.addEventListener('click', function() {
                fileInput.value = '';
                preview.classList.add('hidden');
                previewImg.src = '';
            });

            document.getElementById('productForm').addEventListener('submit', function(e) {
                const nama = document.getElementById('nama_produk').value.trim();
                const pabrikan = document.getElementById('pabrikan_id').value;
                const kategori = document.getElementById('kategori').value;

                if (!nama || !pabrikan || !kategori) {
                    e.preventDefault();
                    alert('Mohon lengkapi field yang wajib diisi (Nama Product, Merk, dan Kategori)');
                    
                    document.querySelector('[data-tab="info-dasar"]').click();
                    return false;
                }
            });
        });
    </script>
    @endsection

@endsection