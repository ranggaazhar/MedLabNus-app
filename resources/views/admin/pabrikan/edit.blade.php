@extends('admin.layouts.app')

@section('title', 'Edit Pabrikan')

{{-- 1. STYLES DARI CREATE AGAR LAYOUT STABIL --}}
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
    {{-- PASTIKAN $pabrikan sudah dilempar dari controller --}}
    <form id="pabrikanForm" action="{{ route('pabrikan.update', $pabrikan->pabrikan_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        {{-- HEADER SECTION --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div class="mb-4 md:mb-0">
                {{-- Breadcrumb --}}
                <p class="text-sm text-gray-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-red-700 transition duration-150">Dashboard</a> / 
                    <a href="{{ route('pabrikan.index') }}" class="hover:text-red-700 transition duration-150">Pabrikan</a> / 
                    Edit
                </p>
                {{-- Title & Subtitle --}}
                <h1 class="text-3xl font-extrabold text-gray-800 mt-1">Edit Pabrikan: {{ $pabrikan->nama_pabrikan }}</h1>
                <p class="text-gray-500">Perbarui informasi dasar Pabrikan dan Logo</p>
            </div>
            
            {{-- Tombol Cancel & Update --}}
            <div class="flex gap-3">
                <a href="{{ route('pabrikan.show', $pabrikan->pabrikan_id) }}" 
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg px-6 py-3 text-base font-medium shadow-sm transition-colors flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" form="pabrikanForm" id="saveButton"
                    class="bg-red-700 hover:bg-red-800 text-white rounded-lg px-6 py-3 text-base font-medium shadow-md transition-colors flex items-center gap-2">
                    <i class="fas fa-save"></i> Update Pabrikan
                </button>
            </div>
        </div>

        <hr/>
        
        {{-- Alert Messages --}}
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg my-6 flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- CONTAINER UTAMA FORM (TIDAK PAKAI TAB, KARENA FIELD SEDIKIT) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Pabrikan</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- 1. Nama Pabrikan (DENGAN AJAX CHECK) --}}
                <div>
                    <label for="nama_pabrikan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Pabrikan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="nama_pabrikan" id="nama_pabrikan" 
                            placeholder="Contoh: Alifax" 
                            value="{{ old('nama_pabrikan', $pabrikan->nama_pabrikan) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 pr-10 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm @error('nama_pabrikan') border-red-500 @enderror">
                        
                        {{-- Loading Spinner (Icon) --}}
                        <div id="checkingSpinner" class="hidden absolute right-3 top-3">
                            <i class="fas fa-spinner fa-spin h-5 w-5 text-gray-400"></i>
                        </div>
                        
                        {{-- Success Icon (Checkmark) --}}
                        <div id="successIcon" class="hidden absolute right-3 top-3">
                            <i class="fas fa-check h-5 w-5 text-green-500"></i>
                        </div>
                        
                        {{-- Error Icon (X) --}}
                        <div id="errorIcon" class="hidden absolute right-3 top-3">
                            <i class="fas fa-times h-5 w-5 text-red-500"></i>
                        </div>
                    </div>
                    
                    {{-- Error Message (AJAX) --}}
                    <p id="namaPabrikanError" class="hidden text-red-500 text-xs mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Nama pabrikan sudah terdaftar, gunakan nama lain.</span>
                    </p>
                    
                    @error('nama_pabrikan') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- 2. Asal Negara (TEXTFIELD) --}}
                <div>
                    <label for="asal_negara" class="block text-sm font-semibold text-gray-700 mb-2">
                        Asal Negara <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="asal_negara" id="asal_negara" 
                        placeholder="Contoh: Jerman / Amerika Serikat" 
                        value="{{ old('asal_negara', $pabrikan->asal_negara) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm @error('asal_negara') border-red-500 @enderror">
                    
                    @error('asal_negara') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>
            </div>
            
            {{-- 3. Logo Pabrikan (CURRENT & DRAG & DROP) --}}
            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Pabrikan (Opsional)</label>
                
                {{-- Logo Saat Ini --}}
                @if($pabrikan->logo_pabrikan)
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-700 mb-3">Logo Saat Ini:</p>
                        <div class="relative inline-block">
                            {{-- Asumsikan 'storage' sudah di-link ke 'public/storage' --}}
                            <img id="currentLogo" src="{{ asset('storage/' . $pabrikan->logo_pabrikan) }}" 
                                alt="{{ $pabrikan->nama_pabrikan }} Logo" 
                                class="h-20 w-auto object-contain rounded-lg border border-gray-300 p-2 bg-white">
                            
                            {{-- Tombol Hapus Logo Eksisting (Jika ingin memberikan opsi hapus permanen) --}}
                            <button type="button" id="deleteCurrentLogoBtn" 
                                class="absolute -top-2 -right-2 bg-gray-400 text-white rounded-full p-1 hover:bg-gray-600 transition-colors shadow-lg text-xs"
                                title="Hapus logo yang sudah ada">
                                <i class="fas fa-trash"></i>
                            </button>
                            <input type="hidden" name="delete_logo" id="deleteLogoInput" value="0">
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Upload gambar baru untuk menggantinya</p>
                    </div>
                @endif


                {{-- AREA DROP ZONE UNTUK UPLOAD BARU --}}
                <div id="dropZone" class="w-full border-2 border-dashed border-gray-300 rounded-lg p-10 text-center hover:border-red-500 hover:bg-gray-50 transition-colors duration-200 ease-in-out bg-white">
                    <input type="file" name="logo_pabrikan" id="logo_pabrikan" accept="image/png, image/jpeg, image/jpg" class="hidden">
                    <label for="logo_pabrikan" class="cursor-pointer block w-full h-full">
                        <div class="flex flex-col items-center pointer-events-none">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 mb-2 transition-colors" id="uploadIcon"></i>
                            <p class="text-sm text-gray-600 mb-1">Drag your file(s) or <span class="text-red-600 font-semibold">browse</span></p>
                            <p class="text-xs text-gray-400">Max 10 MB files are allowed (PNG, JPG/JPEG)</p>
                        </div>
                    </label>
                </div>
                @error('logo_pabrikan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                {{-- PREVIEW IMAGE BARU --}}
                <div id="imagePreview" class="hidden mt-4">
                    <p class="text-sm font-semibold text-gray-700 mb-2">Preview Logo Baru:</p>
                    <div class="relative inline-block">
                        <img id="previewImg" src="" alt="Preview" class="h-20 w-auto object-contain rounded-lg border-2 border-gray-200 shadow-md bg-gray-50 p-1">
                        <button type="button" id="removeImageBtn" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-2 hover:bg-red-700 transition-colors shadow-lg">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div> {{-- End Content Wrapper --}}

    </form>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '{{ csrf_token() }}';
        const currentPabrikanId = {{ $pabrikan->pabrikan_id }};
        const submitButton = document.getElementById('saveButton'); 

        // --- 1. AJAX Check Nama Pabrikan Logic (UPDATE) ---
        let checkTimeout;
        const namaPabrikanInput = document.getElementById('nama_pabrikan');
        const checkingSpinner = document.getElementById('checkingSpinner');
        const successIcon = document.getElementById('successIcon');
        const errorIcon = document.getElementById('errorIcon');
        const errorMessage = document.getElementById('namaPabrikanError');

        function resetValidationState() {
            checkingSpinner.classList.add('hidden');
            successIcon.classList.add('hidden');
            errorIcon.classList.add('hidden');
            errorMessage.classList.add('hidden');
            namaPabrikanInput.classList.remove('border-red-500', 'border-green-500');
            submitButton.disabled = false; 
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }

        namaPabrikanInput.addEventListener('input', function() {
            const nama = this.value.trim();
            
            // Reset state kecuali jika nama tidak berubah
            if (nama === "{{ $pabrikan->nama_pabrikan }}") {
                resetValidationState();
                return;
            }
            
            resetValidationState();
            clearTimeout(checkTimeout);
            
            if (nama.length < 3) return;
            
            checkingSpinner.classList.remove('hidden');
            
            checkTimeout = setTimeout(() => {
                fetch('{{ route("pabrikan.checkNama") }}', { 
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ 
                        nama_pabrikan: nama,
                        pabrikan_id: currentPabrikanId // Kirim ID untuk mengecualikan diri sendiri
                    }) 
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    checkingSpinner.classList.add('hidden');
                    
                    if (data.exists) {
                        // Nama sudah ada (DUPLICATE)
                        errorIcon.classList.remove('hidden');
                        errorMessage.classList.remove('hidden'); 
                        errorMessage.classList.add('flex');
                        namaPabrikanInput.classList.add('border-red-500');
                        
                        // Kunci tombol Save
                        submitButton.disabled = true; 
                        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                    } else {
                        // Nama tersedia (OK)
                        successIcon.classList.remove('hidden');
                        namaPabrikanInput.classList.add('border-green-500');
                        
                        // Aktifkan tombol Save
                        submitButton.disabled = false; 
                        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                })
                .catch(error => {
                    console.error('AJAX Check Error:', error);
                    checkingSpinner.classList.add('hidden');
                    resetValidationState(); 
                });
            }, 500);
        });


        // --- 2. DRAG & DROP & PREVIEW LOGIC (LOGO) ---
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('logo_pabrikan');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const removeBtn = document.getElementById('removeImageBtn');
        const currentLogoContainer = document.getElementById('currentLogo') ? document.getElementById('currentLogo').closest('.mb-4') : null;
        const deleteCurrentLogoBtn = document.getElementById('deleteCurrentLogoBtn');
        const deleteLogoInput = document.getElementById('deleteLogoInput');
        const MAX_FILE_SIZE = 10485760; // 10 MB in bytes

        // Delete Current Logo Logic
        if (deleteCurrentLogoBtn) {
            deleteCurrentLogoBtn.addEventListener('click', function() {
                if (confirm('Anda yakin ingin menghapus logo yang sudah ada?')) {
                    // Set input hidden untuk memberi tahu controller agar menghapus file lama
                    deleteLogoInput.value = 1;
                    
                    // Sembunyikan container logo yang sudah ada
                    if (currentLogoContainer) {
                        currentLogoContainer.classList.add('hidden');
                    }
                    
                    // Pastikan file input kosong agar tidak ada upload baru
                    fileInput.value = '';
                    imagePreview.classList.add('hidden');
                }
            });
        }
        
        // Drag and Drop Handlers
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('border-red-500', 'bg-red-50');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-red-500', 'bg-red-50');
            }, false);
        });

        dropZone.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                fileInput.files = files; 
                handleFiles(files[0]);
            }
        }, false);

        fileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                handleFiles(this.files[0]);
            }
        });

        // Fungsi menampilkan preview dan validasi
        function handleFiles(file) {
            fileInput.setCustomValidity(''); 
            
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar!');
                fileInput.value = '';
                imagePreview.classList.add('hidden');
                return;
            }
            
            if (file.size > MAX_FILE_SIZE) { 
                alert('Ukuran file maksimal 10MB!');
                fileInput.value = ''; 
                imagePreview.classList.add('hidden');
                return; 
            }

            const reader = new FileReader();
            reader.onload = function(e) { 
                previewImg.src = e.target.result; 
                imagePreview.classList.remove('hidden');
                
                // Jika user upload file baru, batalkan niat hapus logo lama
                deleteLogoInput.value = 0;
                if (currentLogoContainer) {
                    currentLogoContainer.classList.remove('hidden');
                }
            }
            reader.readAsDataURL(file);
        }

        // Tombol Hapus Preview Gambar Baru
        removeBtn.addEventListener('click', function() { 
            fileInput.value = ''; 
            imagePreview.classList.add('hidden'); 
            previewImg.src = ''; 
            fileInput.setCustomValidity('');
            
            // Tampilkan kembali logo yang sudah ada
            if (currentLogoContainer && deleteLogoInput.value === '1') {
                 currentLogoContainer.classList.remove('hidden');
                 deleteLogoInput.value = 0;
            }
        });


        // --- 3. FORM VALIDATION Akhir ---
        document.getElementById('pabrikanForm').addEventListener('submit', function(e) {
            // Cek nama yang duplikat (melalui status disabled tombol submit)
            if (submitButton.disabled) {
                e.preventDefault();
                alert('Nama pabrikan sudah terdaftar, harap gunakan nama lain!');
                namaPabrikanInput.focus(); 
                return;
            }
        });
    });
</script>
@endsection

@endsection