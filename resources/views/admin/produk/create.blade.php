@extends('admin.layouts.app')

@section('title', 'Add Product')

{{-- CSS FIX: Mencegah Navbar Lompat/Bergeser --}}
@section('styles')
<style>
    /* Memaksa scrollbar selalu ada secara sistem agar layout stabil */
    html {
        overflow-y: scroll; 
    }

    /* Sembunyikan visual scrollbar di Chrome/Safari/Opera biar bersih */
    html::-webkit-scrollbar {
        display: none;
    }

    /* Sembunyikan di Firefox/IE/Edge */
    html {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection

@section('content')

    <form id="productForm" action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- SECTION 1: HEADER & SAVE BUTTON --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div class="mb-4 md:mb-0">
                <p class="text-sm text-gray-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-red-700 transition duration-150">Dashboard</a>
                    / Add Product
                </p>
                <h1 class="text-3xl font-extrabold text-gray-800 mt-1">Tambah Product</h1>
                <p class="text-gray-500">Lengkapi informasi produk medical equipment</p>
            </div>
            
            <button type="submit" form="productForm" class="bg-red-700 hover:bg-red-800 text-white rounded-lg px-6 py-3 text-base font-medium shadow-md transition-colors flex items-center gap-2">
                <i class="fas fa-save"></i> Save Product
            </button>
        </div>

       {{-- SECTION 2: TAB NAVIGATION --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-6 mb-6">
            
            {{-- PERUBAHAN: Gunakan Grid 3 Kolom agar Spesifikasi PAS di Tengah --}}
            <nav class="-mb-px grid grid-cols-3 w-full" aria-label="Tabs">
                
                {{-- Tab 1: Info Dasar (Rata Kiri / justify-self-start) --}}
                <button type="button" data-tab="info-dasar" 
                    class="tab-btn justify-self-start py-4 px-2 border-b-2 font-bold text-sm transition-colors duration-200 border-red-600 text-gray-900">
                    INFO DASAR
                </button>

                {{-- Tab 2: Spesifikasi (Rata Tengah / justify-self-center) --}}
                <button type="button" data-tab="spesifikasi" 
                    class="tab-btn justify-self-center py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-colors duration-200">
                    SPESIFIKASI
                </button>

                {{-- Tab 3: Gambar (Rata Kanan / justify-self-end) --}}
                <button type="button" data-tab="gambar" 
                    class="tab-btn justify-self-end py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-colors duration-200">
                    GAMBAR
                </button>
            </nav>
        </div>

        {{-- SECTION 3: CONTENT AREA --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            
            {{-- KONTEN 1: INFO DASAR --}}
            <div id="tab-info-dasar" class="tab-content block">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Utama</h2>
                
                @php
                    $styleTrigger = "w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-left flex items-center justify-between transition duration-150 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500";
                    $styleItem    = "cursor-pointer px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 flex justify-between items-center transition-colors duration-150";
                    $styleActive  = "font-bold text-red-600 bg-red-50"; 
                @endphp

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Nama Product --}}
                    {{-- Nama Product - Ganti seluruh div ini --}}
<div>
    <label for="nama_produk" class="block text-sm font-semibold text-gray-700 mb-2">
        Nama Product <span class="text-red-500">*</span>
    </label>
    <div class="relative">
        <input type="text" name="nama_produk" id="nama_produk" 
            placeholder="Contoh: Chemistry Analyzer" 
            value="{{ old('nama_produk') }}" required
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 pr-10 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">
        
        {{-- Loading Spinner --}}
        <div id="checkingSpinner" class="hidden absolute right-3 top-3">
            <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        
        {{-- Success Icon --}}
        <div id="successIcon" class="hidden absolute right-3 top-3">
            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        {{-- Error Icon --}}
        <div id="errorIcon" class="hidden absolute right-3 top-3">
            <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>
    </div>
    
    {{-- Error Message --}}
    <p id="namaProdukError" class="hidden text-red-500 text-xs mt-1 items-center gap-1">
        <i class="fas fa-exclamation-circle"></i>
        <span>Nama produk sudah terdaftar, gunakan nama lain.</span>
    </p>
    
    @error('nama_produk') 
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
    @enderror
</div>

                    {{-- Pabrikan (Dropdown) --}}
                    <div class="relative" 
                        x-data="{ selectedId: '{{ old('pabrikan_id') }}', selectedName: '{{ old('pabrikan_id') ? $pabrikans->firstWhere('pabrikan_id', old('pabrikan_id'))->nama_pabrikan : 'Pilih Pabrikan' }}' }">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pabrik <span class="text-red-500">*</span></label>
                        <input type="hidden" name="pabrikan_id" id="pabrikan_id" :value="selectedId">
                        
                        <div class="relative z-20"> 
                            <x-dropdown align="left" width="w-full" contentClasses="py-1 bg-white border border-gray-200 shadow-xl max-h-60 overflow-y-auto z-50">
                                <x-slot name="trigger">
                                    <button type="button" class="{{ $styleTrigger }}">
                                        <span class="truncate block" x-text="selectedName" :class="!selectedId ? 'text-gray-500' : 'text-gray-900 font-medium'"></span>
                                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="cursor-pointer px-4 py-2.5 text-sm text-gray-500 hover:bg-gray-100 border-b border-gray-100" @click="selectedId = ''; selectedName = 'Pilih Pabrikan'; open = false">-- Reset Pilihan --</div>
                                    @forelse ($pabrikans as $pabrikan)
                                        <div class="{{ $styleItem }}" :class="selectedId == '{{ $pabrikan->pabrikan_id }}' ? '{{ $styleActive }}' : ''" @click="selectedId = '{{ $pabrikan->pabrikan_id }}'; selectedName = '{{ $pabrikan->nama_pabrikan }}'; open = false">
                                            <span>{{ $pabrikan->nama_pabrikan }}</span>
                                            <span x-show="selectedId == '{{ $pabrikan->pabrikan_id }}'"><svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>
                                        </div>
                                    @empty
                                        <div class="px-4 py-4 text-center text-sm text-gray-500 italic">Data Pabrikan belum ada.</div>
                                    @endforelse
                                </x-slot>
                            </x-dropdown>
                        </div>
                        @error('pabrikan_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kategori (Dropdown) --}}
                    <div class="relative" 
                         x-data="{ selectedId: '{{ old('kategori') }}', selectedName: '{{ old('kategori') == 'reagen' ? 'Reagen' : (old('kategori') == 'alat' ? 'Alat' : 'Pilih Kategori') }}' }">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <input type="hidden" name="kategori" id="kategori" :value="selectedId">

                        <div class="relative z-10">
                            <x-dropdown align="left" width="w-full" contentClasses="py-1 bg-white border border-gray-200 shadow-xl z-50">
                                <x-slot name="trigger">
                                    <button type="button" class="{{ $styleTrigger }}">
                                        <span class="truncate block" x-text="selectedName" :class="!selectedId ? 'text-gray-500' : 'text-gray-900 font-medium'"></span>
                                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="{{ $styleItem }}" :class="selectedId == 'reagen' ? '{{ $styleActive }}' : ''" @click="selectedId = 'reagen'; selectedName = 'Reagen'; open = false">
                                        <span>Reagen</span> <span x-show="selectedId == 'reagen'"><svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>
                                    </div>
                                    <div class="{{ $styleItem }}" :class="selectedId == 'alat' ? '{{ $styleActive }}' : ''" @click="selectedId = 'alat'; selectedName = 'Alat'; open = false">
                                        <span>Alat</span> <span x-show="selectedId == 'alat'"><svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="deskripsi_singkat" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Singkat</label>
                    <textarea name="deskripsi_singkat" id="deskripsi_singkat" rows="5" placeholder="Deskripsi singkat produk..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">{{ old('deskripsi_singkat') }}</textarea>
                    @error('deskripsi_singkat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- KONTEN 2: SPESIFIKASI --}}
            <div id="tab-spesifikasi" class="tab-content hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Spesifikasi Produk</h2>
                    <button type="button" id="addSpecBtn" class="bg-red-700 hover:bg-red-800 text-white rounded-lg px-4 py-2 text-sm font-medium transition-colors flex items-center gap-2">
                        <i class="fas fa-plus"></i> Tambah Spesifikasi
                    </button>
                </div>

                <div id="specContainer" class="space-y-4">
                    @if(old('spesifikasi'))
                        @foreach(old('spesifikasi') as $index => $spec)
                            <div class="spec-item bg-gray-50 rounded-lg border border-gray-200 p-4">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Spesifikasi</label>
                                        <input type="text" name="spesifikasi[{{ $index }}][nama_spesifikasi]" value="{{ $spec['nama_spesifikasi'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-red-500 focus:ring-red-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Spesifikasi</label>
                                        <input type="text" name="spesifikasi[{{ $index }}][nilai]" value="{{ $spec['nilai'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-red-500 focus:ring-red-500">
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="button" class="removeSpecBtn text-red-600 hover:text-red-800 transition-colors text-sm font-medium flex items-center gap-1"><i class="fas fa-trash"></i> Hapus</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-800"><i class="fas fa-info-circle"></i> <strong>Tips:</strong> Tambahkan spesifikasi teknis seperti throughput, kapasitas, dimensi, berat, voltase, dll.</p>
                </div>
            </div>

            {{-- KONTEN 3: GAMBAR --}}
            <div id="tab-gambar" class="tab-content hidden">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Upload Gambar Produk</h2>
                <div class="">
                    <div class="mb-6">
                        <label for="gambar_utama" class="block text-sm font-semibold text-gray-700 mb-2">Gambar Utama Produk</label>
                        <div class="w-full border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-red-500 transition-colors">
                            <input type="file" name="gambar_utama" id="gambar_utama" accept="image/*" class="hidden">
                            <label for="gambar_utama" class="cursor-pointer">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-sm text-gray-600 mb-1">Drag your file(s) or <span class="text-red-600 font-semibold">browse</span></p>
                                    <p class="text-xs text-gray-400">Max 10 MB files are allowed</p>
                                </div>
                            </label>
                        </div>
                        @error('gambar_utama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div id="imagePreview" class="hidden">
                        <p class="text-sm font-semibold text-gray-700 mb-3">Preview Gambar:</p>
                        <div class="relative inline-block">
                            <img src="" alt="Preview" class="h-48 w-auto object-cover rounded-lg border-2 border-gray-200 shadow-md">
                            <button type="button" id="removeImageBtn" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-2 hover:bg-red-700 transition-colors shadow-lg"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>

    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // AJAX Check Nama Produk - Tambahkan sebelum penutup script
        let checkTimeout;
        const namaProdukInput = document.getElementById('nama_produk');
        const checkingSpinner = document.getElementById('checkingSpinner');
        const successIcon = document.getElementById('successIcon');
        const errorIcon = document.getElementById('errorIcon');
        const errorMessage = document.getElementById('namaProdukError');
        const submitButton = document.querySelector('button[type="submit"]');

        namaProdukInput.addEventListener('input', function() {
            const nama = this.value.trim();
            
            // Reset icons
            checkingSpinner.classList.add('hidden');
            successIcon.classList.add('hidden');
            errorIcon.classList.add('hidden');
            errorMessage.classList.add('hidden');
            namaProdukInput.classList.remove('border-red-500', 'border-green-500');
            
            // Clear previous timeout
            clearTimeout(checkTimeout);
            
            if (nama.length < 3) return;
            
            // Show loading
            checkingSpinner.classList.remove('hidden');
            
            // Debounce check
            checkTimeout = setTimeout(() => {
                fetch('{{ route("produk.checkNama") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ nama_produk: nama })
                })
                .then(response => response.json())
                .then(data => {
                    checkingSpinner.classList.add('hidden');
                    
                    if (data.exists) {
                        // Nama sudah ada
                        errorIcon.classList.remove('hidden');
                        errorMessage.classList.remove('hidden');
                        namaProdukInput.classList.add('border-red-500');
                        submitButton.disabled = true;
                        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                    } else {
                        // Nama tersedia
                        successIcon.classList.remove('hidden');
                        namaProdukInput.classList.add('border-green-500');
                        submitButton.disabled = false;
                        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    checkingSpinner.classList.add('hidden');
                });
            }, 500); // Wait 500ms after user stops typing
        });
            // TAB SWITCHING LOGIC
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            const activeClasses = ['border-red-600', 'text-gray-900', 'font-bold'];
            const inactiveClasses = ['border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'font-medium'];

            tabButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetTab = this.getAttribute('data-tab');

                    tabButtons.forEach(btn => {
                        btn.classList.remove(...activeClasses);
                        btn.classList.add(...inactiveClasses);
                    });

                    this.classList.remove(...inactiveClasses);
                    this.classList.add(...activeClasses);

                    tabContents.forEach(content => content.classList.add('hidden'));
                    const targetContent = document.getElementById('tab-' + targetTab);
                    if (targetContent) targetContent.classList.remove('hidden');
                });
            });

            // SPECIFICATION & IMAGE LOGIC
            let specIndex = {{ old('spesifikasi') ? count(old('spesifikasi')) : 0 }};
            document.getElementById('addSpecBtn').addEventListener('click', function() {
                const container = document.getElementById('specContainer');
                const newSpec = `
                    <div class="spec-item bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="grid grid-cols-1 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Nama Spesifikasi</label><input type="text" name="spesifikasi[${specIndex}][nama_spesifikasi]" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-red-500 focus:ring-red-500"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Nilai Spesifikasi</label><input type="text" name="spesifikasi[${specIndex}][nilai]" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-red-500 focus:ring-red-500"></div>
                            <div class="flex justify-end"><button type="button" class="removeSpecBtn text-red-600 hover:text-red-800 transition-colors text-sm font-medium flex items-center gap-1"><i class="fas fa-trash"></i> Hapus</button></div>
                        </div>
                    </div>`;
                container.insertAdjacentHTML('beforeend', newSpec);
                specIndex++;
            });
            document.addEventListener('click', function(e) {
                if (e.target.closest('.removeSpecBtn') && confirm('Hapus spesifikasi ini?')) {
                    e.target.closest('.spec-item').remove();
                }
            });

            // Image Preview
            const fileInput = document.getElementById('gambar_utama');
            const preview = document.getElementById('imagePreview');
            const previewImg = preview.querySelector('img');
            const removeBtn = document.getElementById('removeImageBtn');

            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 2048000) { alert('Ukuran file maksimal 2MB!'); fileInput.value = ''; return; }
                    const reader = new FileReader();
                    reader.onload = function(e) { previewImg.src = e.target.result; preview.classList.remove('hidden'); }
                    reader.readAsDataURL(file);
                }
            });
            removeBtn.addEventListener('click', function() { fileInput.value = ''; preview.classList.add('hidden'); previewImg.src = ''; });

            // Form Validation
            document.getElementById('productForm').addEventListener('submit', function(e) {
                const nama = document.getElementById('nama_produk').value.trim();
                const pabrikan = document.getElementById('pabrikan_id').value;
                const kategori = document.getElementById('kategori').value;
                if (!nama || !pabrikan || !kategori) {
                    e.preventDefault();
                    alert('Mohon lengkapi field yang wajib diisi (Nama Product, Pabrik, dan Kategori)');
                    document.querySelector('[data-tab="info-dasar"]').click();
                }
            });
        });
    </script>
    @endsection

@endsection