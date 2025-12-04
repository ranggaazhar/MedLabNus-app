@extends('admin.layouts.app')

@section('title', 'Edit Pabrikan')

{{-- 1. STYLES UTAMA --}}
@section('styles')
<style>
    /* Memaksa scrollbar selalu ada secara sistem agar layout stabil */
    html { overflow-y: scroll; }
    /* Sembunyikan visual scrollbar di Chrome/Safari/Opera */
    html { -ms-overflow-style: none; scrollbar-width: none; }
    /* Animasi halus untuk drag & drop */
    #dropZone { transition: all 0.2s ease-in-out; }
    
    /* Style untuk div yang menahan preview logo */
    #imagePreviewContainer {
        min-height: 100px; /* Sesuaikan tinggi agar area tidak terlalu kecil saat ada logo */
    }
</style>
@endsection

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
            
            {{-- Tombol Save Pabrikan --}}
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

        {{-- Alert Messages --}}
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- CONTAINER UTAMA FORM --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
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
                
                {{-- Drop Zone --}}
                <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition duration-150 relative cursor-pointer">
                    
                    {{-- Placeholder Saat Kosong/Baru --}}
                    <div id="uploadPlaceholder" class="{{ $pabrikan->logo_pabrikan ? 'hidden' : '' }} pointer-events-none">
                        <svg id="uploadIcon" class="mx-auto h-12 w-12 text-gray-400 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l-5.172 5.172a4 4 0 01-5.656 0L12 32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">
                            Drag your file or 
                            <label for="logo_pabrikan_input" class="text-red-600 font-semibold cursor-pointer hover:text-red-500">browse</label>
                        </p>
                        <p class="text-xs text-gray-500">Max 10 MB files are allowed (PNG, JPG/JPEG)</p>
                    </div>
                    
                    {{-- Pratinjau Gambar Saat Ini / Baru --}}
                    <div id="imagePreviewContainer" class="absolute inset-0 flex items-center justify-center p-2 bg-white rounded-lg {{ $pabrikan->logo_pabrikan ? '' : 'hidden' }}">
                        
                        {{-- Hapus Tombol jika sudah ada logo --}}
                        @if($pabrikan->logo_pabrikan)
                            <button type="button" id="removeExistingLogoBtn" class="absolute top-1 right-1 bg-gray-700 text-white rounded-full p-1 w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors shadow-lg z-20">
                                <i class="fas fa-times"></i>
                            </button>
                            <img id="logoPreview" src="{{ asset('storage/' . $pabrikan->logo_pabrikan) }}" class="max-h-full max-w-full object-contain" alt="Logo Pabrikan" />
                        @else
                            <img id="logoPreview" class="max-h-full max-w-full object-contain" alt="Logo Pabrikan Preview" />
                            <button type="button" id="removeNewLogoBtn" class="absolute top-1 right-1 bg-gray-700 text-white rounded-full p-1 w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors shadow-lg z-20 hidden">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                        
                        {{-- Hidden input untuk menandai penghapusan logo (jika logo saat ini dihapus) --}}
                        <input type="hidden" name="hapus_logo_lama" id="hapusLogoLama" value="0">
                    </div>
                    
                    {{-- Input File Sebenarnya (Menutupi seluruh area dropzone) --}}
                    <input type="file" name="logo_pabrikan" id="logo_pabrikan_input" accept="image/png, image/jpeg" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                </div>
                
                @error('logo_pabrikan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

    </form>
    
@endsection

{{-- 2. SCRIPTS LOGIC --}}
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- DRAG AND DROP & IMAGE PREVIEW LOGIC ---
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('logo_pabrikan_input');
        const placeholder = document.getElementById('uploadPlaceholder');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const logoPreview = document.getElementById('logoPreview');
        const uploadIcon = document.getElementById('uploadIcon');
        
        // Tombol Hapus (untuk logo yang sudah ada)
        const removeExistingLogoBtn = document.getElementById('removeExistingLogoBtn');
        const hapusLogoLamaInput = document.getElementById('hapusLogoLama');

        // Tombol Hapus (untuk logo baru yang diupload)
        // Jika ada logo lama, tombol ini mungkin tidak ada, jadi kita cek.
        let removeNewLogoBtn = document.getElementById('removeNewLogoBtn');
        if (!removeNewLogoBtn) {
            // Jika tombol belum ada (karena sudah ada logo lama), buat tombol untuk logo baru
            const existingBtn = document.getElementById('removeExistingLogoBtn');
            if(existingBtn) {
                removeNewLogoBtn = existingBtn; // Gunakan tombol yang sama untuk fungsi hapus file input
            } else {
                // Jika tidak ada logo lama, tombol ini sudah ada di HTML dan kita ambil
                removeNewLogoBtn = document.getElementById('removeNewLogoBtn');
            }
        }
        
        // Cek status awal (apakah sudah ada logo)
        const hasExistingLogo = '{{ $pabrikan->logo_pabrikan }}' !== '';

        // Fungsi untuk menampilkan preview
        function showPreview(file) {
            if (file) {
                // Batasan ukuran file (10MB)
                if (file.size > 10 * 1024 * 1024) { 
                    alert('Ukuran file maksimal 10MB!'); 
                    resetImage();
                    return; 
                }
                
                const reader = new FileReader();
                reader.onload = function(e) { 
                    logoPreview.src = e.target.result; 
                    previewContainer.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    
                    // Sembunyikan input hapus logo lama jika upload logo baru
                    hapusLogoLamaInput.value = '0'; 

                    // Tampilkan tombol hapus logo baru
                    if(removeNewLogoBtn) removeNewLogoBtn.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // Fungsi Reset Gambar (menghapus input file baru)
        function resetImage() {
            fileInput.value = '';
            
            if (hasExistingLogo) {
                // Jika sebelumnya ada logo lama, kembalikan preview ke logo lama
                logoPreview.src = '{{ asset('storage/' . $pabrikan->logo_pabrikan) }}';
                previewContainer.classList.remove('hidden');
                placeholder.classList.add('hidden');
                
                if(removeExistingLogoBtn) removeExistingLogoBtn.classList.remove('hidden');
                if(removeNewLogoBtn) removeNewLogoBtn.classList.add('hidden');

            } else {
                // Jika tidak ada logo lama, sembunyikan preview dan tampilkan placeholder
                previewContainer.classList.add('hidden');
                placeholder.classList.remove('hidden');
                
                if(removeNewLogoBtn) removeNewLogoBtn.classList.add('hidden');
            }
            
            // Pastikan flag hapus logo lama di-reset
            hapusLogoLamaInput.value = '0'; 
        }

        // Event Listener untuk Input File Biasa
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            showPreview(file);
        });

        // Drag & Drop Events (Prevent Default)
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight Effect
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-red-500', 'bg-red-50');
            dropZone.classList.remove('border-gray-300', 'bg-white');
            uploadIcon.classList.add('text-red-500');
            uploadIcon.classList.remove('text-gray-400');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-red-500', 'bg-red-50');
            dropZone.classList.add('border-gray-300', 'bg-white');
            uploadIcon.classList.remove('text-red-500');
            uploadIcon.classList.add('text-gray-400');
        }

        // Handle Drop
        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            unhighlight(e);
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                fileInput.files = files; // Assign files ke input
                showPreview(files[0]);
            }
        }
        
        // LOGIC HAPUS LOGO
        
        // 1. Jika tombol yang diklik adalah tombol yang muncul saat ada logo lama
        if (removeExistingLogoBtn) {
            removeExistingLogoBtn.addEventListener('click', function() {
                // Ini berarti pengguna ingin menghapus logo yang sudah ada di database
                if (confirm('Anda yakin ingin menghapus logo ini? Logo akan dihapus permanen saat form di-update.')) {
                    // 1. Sembunyikan preview
                    previewContainer.classList.add('hidden');
                    // 2. Tampilkan placeholder
                    placeholder.classList.remove('hidden');
                    // 3. Set flag untuk penghapusan di backend
                    hapusLogoLamaInput.value = '1';
                    // 4. Kosongkan input file (jika ada file baru yang sempat di-drag/di-klik)
                    fileInput.value = '';
                    // 5. Sembunyikan tombol hapus
                    removeExistingLogoBtn.classList.add('hidden');
                }
            });
        }
        
        // 2. Jika tombol yang diklik adalah tombol yang muncul saat upload file baru
        if (removeNewLogoBtn && !hasExistingLogo) {
             removeNewLogoBtn.addEventListener('click', resetImage); // Gunakan fungsi resetImage biasa
        }
        
        // 3. Jika ada logo lama dan logo baru diupload (tombolnya sama dengan removeExistingLogoBtn)
        if (removeNewLogoBtn && hasExistingLogo) {
            // Tombol ini berfungsi ganda: jika ada input file baru, dia mereset input file.
            removeNewLogoBtn.addEventListener('click', function() {
                if (fileInput.files.length > 0) {
                    resetImage(); // Reset input file baru
                } else {
                    // Jika tidak ada input file baru, berarti user mau menghapus logo lama
                    if (confirm('Anda yakin ingin menghapus logo ini? Logo akan dihapus permanen saat form di-update.')) {
                        previewContainer.classList.add('hidden');
                        placeholder.classList.remove('hidden');
                        hapusLogoLamaInput.value = '1';
                        removeNewLogoBtn.classList.add('hidden');
                    }
                }
            });
        }

        // Karena kita menggunakan tombol yang sama, kita perlu memastikan 
        // tombol itu muncul saat ada logo lama, atau saat ada logo baru (jika tidak ada logo lama).
        if (hasExistingLogo) {
            // Ketika ada logo lama, tombol hapus logo lama sudah ada
            // Kita tidak perlu logika tambahan.
        } else {
             // Jika tidak ada logo lama, tombol hapus logo baru harusnya tersembunyi
             if(removeNewLogoBtn) removeNewLogoBtn.classList.add('hidden');
        }

    });
</script>
@endsection