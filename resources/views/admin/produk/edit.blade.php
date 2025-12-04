@extends('admin.layouts.app')

@section('title', 'Edit Product')

{{-- 1. COPY STYLES DARI CREATE AGAR LAYOUT STABIL --}}
@section('styles')
<style>
    /* Memaksa scrollbar selalu ada secara sistem agar layout stabil */
    html { overflow-y: scroll; }
    /* Sembunyikan visual scrollbar di Chrome/Safari/Opera */
    html::-webkit-scrollbar { display: none; }
    /* Sembunyikan di Firefox/IE/Edge */
    html { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection

@section('content')

    {{-- Form Pembungkus --}}
    <form id="productForm" action="{{ route('produk.update', $produk->produk_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        {{-- HEADER SECTION --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div class="mb-4 md:mb-0">
                <p class="text-sm text-gray-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-red-700 transition duration-150">Dashboard</a> / 
                    Edit
                </p>
                <h1 class="text-3xl font-extrabold text-gray-800 mt-1">Edit Product</h1>
                <p class="text-gray-500">Perbarui informasi produk medical equipment</p>
            </div>
            
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

        {{-- 2. TAB NAVIGATION (DESIGN DISAMAKAN DENGAN CREATE) --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-6 mb-6">
            <nav class="-mb-px grid grid-cols-3 w-full" aria-label="Tabs">
                
                {{-- Tab 1: Info Dasar --}}
                <button type="button" data-tab="info-dasar" 
                    class="tab-btn justify-self-start py-4 px-2 border-b-2 font-bold text-sm transition-colors duration-200 border-red-600 text-gray-900">
                    INFO DASAR
                </button>

                {{-- Tab 2: Spesifikasi --}}
                <button type="button" data-tab="spesifikasi" 
                    class="tab-btn justify-self-center py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-colors duration-200">
                    SPESIFIKASI
                </button>

                {{-- Tab 3: Gambar --}}
                <button type="button" data-tab="gambar" 
                    class="tab-btn justify-self-end py-4 px-2 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-colors duration-200">
                    GAMBAR
                </button>
            </nav>
        </div>

        {{-- 3. CONTENT WRAPPER (SATU CONTAINER BESAR UNTUK SEMUA TAB) --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">

            {{-- TAB CONTENT 1: INFO DASAR --}}
            <div id="tab-info-dasar" class="tab-content block">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Utama</h2>
                
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
                <p id="namaProdukError" class="hidden text-red-500 text-xs mt-1 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Nama produk sudah terdaftar, gunakan nama lain.</span>
                </p>
                
                @error('nama_produk') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

                    {{-- Merk (Pabrikan) --}}
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
                        @error('pabrikan_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kategori --}}
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
                        @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                {{-- Deskripsi Singkat --}}
                <div class="mt-6">
                    <label for="deskripsi_singkat" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi Singkat
                    </label>
                    <textarea name="deskripsi_singkat" id="deskripsi_singkat" rows="5" 
                        placeholder="Deskripsi singkat produk..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">{{ old('deskripsi_singkat', $produk->deskripsi_singkat) }}</textarea>
                    @error('deskripsi_singkat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- TAB CONTENT 2: SPESIFIKASI --}}
            <div id="tab-spesifikasi" class="tab-content hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Spesifikasi Produk</h2>
                    <button type="button" id="addSpecBtn" 
                        class="bg-red-700 hover:bg-red-800 text-white rounded-lg px-4 py-2 text-sm font-medium transition-colors flex items-center gap-2">
                        <i class="fas fa-plus"></i> Tambah Spesifikasi
                    </button>
                </div>

                <div id="specContainer" class="space-y-4">
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
            <div id="tab-gambar" class="tab-content hidden">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Upload Gambar Produk</h2>
                
                <div class=""> {{-- Container disamakan create --}}
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

        </div> {{-- End Content Wrapper --}}

    </form>

    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // AJAX Check Nama Produk (UPDATE) - Tambahkan sebelum penutup script
        let checkTimeout;
        const namaProdukInput = document.getElementById('nama_produk');
        const checkingSpinner = document.getElementById('checkingSpinner');
        const successIcon = document.getElementById('successIcon');
        const errorIcon = document.getElementById('errorIcon');
        const errorMessage = document.getElementById('namaProdukError');
        const submitButton = document.querySelector('button[type="submit"]');
        const currentProdukId = {{ $produk->produk_id }}; // ID produk yang sedang diedit

        namaProdukInput.addEventListener('input', function() {
        const nama = this.value.trim();
        
        // Reset icons
        checkingSpinner.classList.add('hidden');
        successIcon.classList.add('hidden');
        errorIcon.classList.add('hidden');
        errorMessage.classList.add('hidden');
        namaProdukInput.classList.remove('border-red-500', 'border-green-500');
        
        clearTimeout(checkTimeout);
        
        if (nama.length < 3) return;
        
        checkingSpinner.classList.remove('hidden');
        
        checkTimeout = setTimeout(() => {
            fetch('{{ route("produk.checkNama") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    nama_produk: nama,
                    produk_id: currentProdukId // Kirim ID untuk exclude dari check
                })
            })
            .then(response => response.json())
            .then(data => {
                checkingSpinner.classList.add('hidden');
                
                if (data.exists) {
                    errorIcon.classList.remove('hidden');
                    errorMessage.classList.remove('hidden');
                    namaProdukInput.classList.add('border-red-500');
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
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
        }, 500);
    });
            // TAB SWITCHING LOGIC (DISAMAKAN DENGAN CREATE)
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            // Class active & inactive persis create
            const activeClasses = ['border-red-600', 'text-gray-900', 'font-bold'];
            const inactiveClasses = ['border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'font-medium'];

            tabButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Reset semua button style
                    tabButtons.forEach(btn => {
                        btn.classList.remove(...activeClasses);
                        btn.classList.add(...inactiveClasses);
                    });
                    
                    // Set active style ke tombol yang diklik
                    this.classList.remove(...inactiveClasses);
                    this.classList.add(...activeClasses);
                    
                    // Sembunyikan semua konten dan tampilkan yang dituju
                    tabContents.forEach(content => content.classList.add('hidden'));
                    const targetContent = document.getElementById('tab-' + targetTab);
                    if (targetContent) targetContent.classList.remove('hidden');
                });
            });

            // SPECIFICATION & IMAGE LOGIC
            let specIndex = {{ $produk->spesifikasis->count() }};

            document.getElementById('addSpecBtn').addEventListener('click', function() {
                const container = document.getElementById('specContainer');
                const newSpec = `
                    <div class="spec-item bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Spesifikasi</label>
                                <input type="text" name="spesifikasi[${specIndex}][nama_spesifikasi]" placeholder="Contoh: Throughput, Kapasitas, Dimensi" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-red-500 focus:ring-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Spesifikasi</label>
                                <input type="text" name="spesifikasi[${specIndex}][nilai]" placeholder="Contoh: 200 tests/hour, 500 mL, 30 x 40 x 50 cm" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-red-500 focus:ring-red-500">
                            </div>
                            <div class="flex justify-end">
                                <button type="button" class="removeSpecBtn text-red-600 hover:text-red-800 transition-colors text-sm font-medium flex items-center gap-1"><i class="fas fa-trash"></i> Hapus</button>
                            </div>
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

            // Image Preview Logic
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

            removeBtn.addEventListener('click', function() {
                fileInput.value = '';
                preview.classList.add('hidden');
                previewImg.src = '';
            });

            // Form Validation on Submit
            document.getElementById('productForm').addEventListener('submit', function(e) {
                const nama = document.getElementById('nama_produk').value.trim();
                const pabrikan = document.getElementById('pabrikan_id').value;
                const kategori = document.getElementById('kategori').value;

                if (!nama || !pabrikan || !kategori) {
                    e.preventDefault();
                    alert('Mohon lengkapi field yang wajib diisi (Nama Product, Merk, dan Kategori)');
                    // Trigger klik ke tab info dasar jika ada yang kosong
                    document.querySelector('[data-tab="info-dasar"]').click();
                }
            });
        });
    </script>
    @endsection

@endsection