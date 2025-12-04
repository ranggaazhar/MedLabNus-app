@extends('admin.layouts.app')

@section('title', 'Tambah Pabrikan')

@section('content')

    {{-- Form Pembungkus --}}
    <form id="pabrikanForm" action="{{ route('pabrikan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- HEADER: Breadcrumb, Title, Subtitle, dan Tombol Save --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            
            <div class="mb-4 md:mb-0">
                {{-- Breadcrumb --}}
                <p class="text-sm text-gray-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-red-700 transition duration-150">
                        Dashboard
                    </a>
                    / Add Pabrikan
                </p>
                
                {{-- Title & Subtitle --}}
                <h1 class="text-3xl font-extrabold text-gray-800 mt-1">Tambah Pabrikan</h1>
                <p class="text-gray-500">Lengkapi informasi Pabrikan berikut</p>
            </div>
            
            {{-- Tombol Save Pabrikan --}}
            <button type="submit" form="pabrikanForm" id="saveButton" class="bg-red-700 hover:bg-red-800 text-white rounded-lg px-6 py-3 text-base font-medium shadow-md transition-colors flex items-center gap-2">
                <i class="fas fa-save"></i> Save Pabrikan
            </button>
        </div>

        {{-- CONTAINER UTAMA FORM --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Dasar Pabrikan</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- 1. Nama Pabrikan --}}
                <div>
                    <label for="nama_pabrikan" class="block text-sm font-semibold text-gray-700 mb-2">Nama Pabrikan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_pabrikan" id="nama_pabrikan" placeholder="Contoh: General Electric" 
                        value="{{ old('nama_pabrikan') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm @error('nama_pabrikan') border-red-500 @enderror">
                    @error('nama_pabrikan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- 2. Asal Negara --}}
                <div>
                    <label for="asal_negara" class="block text-sm font-semibold text-gray-700 mb-2">Asal Negara <span class="text-red-500">*</span></label>
                    <input type="text" name="asal_negara" id="asal_negara" placeholder="Contoh: Amerika Serikat" 
                        value="{{ old('asal_negara') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm @error('asal_negara') border-red-500 @enderror">
                    @error('asal_negara') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

            </div>
            
            {{-- 3. Logo Pabrikan (UPDATED DRAG & DROP) --}}
            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Logo Pabrikan</label>
                
                {{-- AREA DROP ZONE dengan ID dropZone --}}
                <div id="dropZone" class="w-full border-2 border-dashed border-gray-300 rounded-lg p-10 text-center hover:border-red-500 hover:bg-gray-50 transition-colors transition-all duration-200 ease-in-out bg-white">
                    <input type="file" name="logo_pabrikan" id="logo_pabrikan" accept="image/png, image/jpeg, image/jpg" class="hidden">
                    <label for="logo_pabrikan" class="cursor-pointer block w-full h-full">
                        <div class="flex flex-col items-center pointer-events-none">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 mb-2 transition-colors" id="uploadIcon"></i>
                            <p class="text-sm text-gray-600 mb-1">Drag your logo here or <span class="text-red-600 font-semibold">browse</span></p>
                            <p class="text-xs text-gray-400">Max 10 MB files (PNG, JPG/JPEG)</p>
                        </div>
                    </label>
                </div>
                @error('logo_pabrikan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                {{-- PREVIEW IMAGE --}}
                <div id="imagePreview" class="hidden mt-4">
                    <p class="text-sm font-semibold text-gray-700 mb-2">Preview Logo:</p>
                    <div class="relative inline-block">
                        <img id="previewImg" src="" alt="Preview" class="h-40 w-auto object-contain rounded-lg border-2 border-gray-200 shadow-md bg-gray-50">
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
        // --- DRAG & DROP LOGIC ---
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('logo_pabrikan');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const removeBtn = document.getElementById('removeImageBtn');
        const uploadIcon = document.getElementById('uploadIcon');

        // Prevent browser default behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight drop zone saat file ditarik masuk
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('border-red-500', 'bg-red-50');
                if(uploadIcon) {
                    uploadIcon.classList.remove('text-gray-300');
                    uploadIcon.classList.add('text-red-500');
                }
            }, false);
        });

        // Unhighlight drop zone saat file keluar atau dijatuhkan
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-red-500', 'bg-red-50');
                if(uploadIcon) {
                    uploadIcon.classList.add('text-gray-300');
                    uploadIcon.classList.remove('text-red-500');
                }
            }, false);
        });

        // Handle saat file di-DROP
        dropZone.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                fileInput.files = files; // Masukkan file ke input hidden
                handleFiles(files[0]);
            }
        }, false);

        // Handle saat tombol BROWSE diklik
        fileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                handleFiles(this.files[0]);
            }
        });

        // Fungsi menampilkan preview
        function handleFiles(file) {
            // Validasi tipe file
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar!');
                fileInput.value = '';
                return;
            }
            // Validasi ukuran (10MB)
            if (file.size > 10485760) { 
                alert('Ukuran file maksimal 10MB!'); 
                fileInput.value = ''; 
                return; 
            }

            const reader = new FileReader();
            reader.onload = function(e) { 
                previewImg.src = e.target.result; 
                imagePreview.classList.remove('hidden'); 
            }
            reader.readAsDataURL(file);
        }

        // Tombol Hapus Preview
        removeBtn.addEventListener('click', function() { 
            fileInput.value = ''; 
            imagePreview.classList.add('hidden'); 
            previewImg.src = ''; 
        });
    });
</script>
@endsection

@endsection