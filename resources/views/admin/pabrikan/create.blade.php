@extends('admin.layouts.app')

@section('title', 'Tambah Pabrikan')

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
            <button type="submit" form="pabrikanForm" id="saveButton"
                class="bg-red-700 hover:bg-red-800 text-white rounded-lg px-6 py-3 text-base font-medium shadow-md transition-colors flex items-center gap-2">
                <i class="fas fa-save"></i> Save Pabrikan
            </button>
        </div>

        {{-- CONTAINER UTAMA FORM --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            {{-- Bagian Info Dasar (Nama & Negara) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- 1. Nama Pabrikan (DITAMBAHKAN AJAX CHECK) --}}
                <div>
                    <label for="nama_pabrikan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Pabrikan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="nama_pabrikan" id="nama_pabrikan" placeholder="Contoh: Biosystem"
                            value="{{ old('nama_pabrikan') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 pr-10 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm @error('nama_pabrikan') border-red-500 @enderror">

                        {{-- Loading Spinner (Icon) --}}
                        <div id="checkingSpinner" class="hidden absolute right-3 top-3">
                            <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>

                        {{-- Success Icon (Checkmark) --}}
                        <div id="successIcon" class="hidden absolute right-3 top-3">
                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>

                        {{-- Error Icon (X) --}}
                        <div id="errorIcon" class="hidden absolute right-3 top-3">
                            <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
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
                    <input type="text" name="asal_negara" id="asal_negara" placeholder="Contoh: Jerman "
                        value="{{ old('asal_negara') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm @error('asal_negara') border-red-500 @enderror">

                    @error('asal_negara')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- 3. Logo Pabrikan (DRAG & DROP) --}}
            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Logo Pabrikan</label>

                {{-- AREA DROP ZONE dengan ID dropZone --}}
                <div id="dropZone"
                    class="w-full border-2 border-dashed border-gray-300 rounded-lg p-10 text-center hover:border-red-500 hover:bg-gray-50 transition-colors transition-all duration-200 ease-in-out bg-white">
                    <input type="file" name="logo_pabrikan" id="logo_pabrikan" accept="image/png, image/jpeg, image/jpg"
                        class="hidden">
                    <label for="logo_pabrikan" class="cursor-pointer block w-full h-full">
                        <div class="flex flex-col items-center pointer-events-none">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 mb-2 transition-colors"
                                id="uploadIcon"></i>
                            <p class="text-sm text-gray-600 mb-1">Drag your file(s) or <span
                                    class="text-red-600 font-semibold">browse</span></p>
                            <p class="text-xs text-gray-400">Max 10 MB files are allowed (PNG, JPG/JPEG)</p>
                        </div>
                    </label>
                </div>
                @error('logo_pabrikan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                {{-- PREVIEW IMAGE --}}
                <div id="imagePreview" class="hidden mt-4">
                    <p class="text-sm font-semibold text-gray-700 mb-2">Preview Logo:</p>
                    <div class="relative inline-block">
                        <img id="previewImg" src="" alt="Preview"
                            class="h-40 w-auto object-contain rounded-lg border-2 border-gray-200 shadow-md bg-gray-50">
                        <button type="button" id="removeImageBtn"
                            class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-2 hover:bg-red-700 transition-colors shadow-lg">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </form>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // --- 1. AJAX Check Nama Pabrikan ---
                let checkTimeout;
                const namaPabrikanInput = document.getElementById('nama_pabrikan');
                const checkingSpinner = document.getElementById('checkingSpinner');
                const successIcon = document.getElementById('successIcon');
                const errorIcon = document.getElementById('errorIcon');
                const errorMessage = document.getElementById('namaPabrikanError');
                const submitButton = document.getElementById('saveButton');
                // Ambil token CSRF. Pastikan Anda memiliki tag <meta name="csrf-token" content="{{ csrf_token() }}"> di layout utama (admin.layouts.app)
                const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '{{ csrf_token() }}';

                function resetValidationState() {
                    // Sembunyikan semua indikator
                    checkingSpinner.classList.add('hidden');
                    successIcon.classList.add('hidden');
                    errorIcon.classList.add('hidden');
                    errorMessage.classList.add('hidden');

                    // Hapus semua border validasi
                    namaPabrikanInput.classList.remove('border-red-500', 'border-green-500');

                    // Aktifkan tombol save secara default (akan dinonaktifkan jika nama duplikat)
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }

                namaPabrikanInput.addEventListener('input', function () {
                    const nama = this.value.trim();

                    resetValidationState();

                    clearTimeout(checkTimeout);

                    if (nama.length < 3) {
                        // Jika input terlalu pendek, tidak perlu cek AJAX
                        return;
                    }

                    // Tampilkan loading spinner
                    checkingSpinner.classList.remove('hidden');

                    // Debounce check: Tunggu sebentar setelah user berhenti mengetik
                    checkTimeout = setTimeout(() => {
                        fetch('{{ route("pabrikan.checkNama") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': CSRF_TOKEN
                            },
                            body: JSON.stringify({ nama_pabrikan: nama })
                        })
                            .then(response => {
                                // Pastikan respons HTTP sukses
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                checkingSpinner.classList.add('hidden'); // Sembunyikan loading

                                if (data.exists) {
                                    // Nama sudah ada (DUPLICATE)
                                    errorIcon.classList.remove('hidden');
                                    errorMessage.classList.remove('hidden');
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
                                // Jika ada error pada fetch (misal: koneksi, server down), 
                                // kita tidak boleh mengunci form (biarkan validasi server yang handle)
                                // Tapi kita harus hapus ikon sukses/error
                                successIcon.classList.add('hidden');
                                errorIcon.classList.add('hidden');
                                errorMessage.classList.add('hidden');
                            });
                    }, 500); // Debounce time: 500ms
                });


                // --- 2. DRAG & DROP LOGIC ---
                const dropZone = document.getElementById('dropZone');
                const fileInput = document.getElementById('logo_pabrikan');
                const imagePreview = document.getElementById('imagePreview');
                const previewImg = document.getElementById('previewImg');
                const removeBtn = document.getElementById('removeImageBtn');
                const uploadIcon = document.getElementById('uploadIcon');
                const MAX_FILE_SIZE = 10485760; // 10 MB in bytes

                // Prevent browser default behaviors
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                // Highlight drop zone
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => {
                        dropZone.classList.add('border-red-500', 'bg-red-50');
                        if (uploadIcon) {
                            uploadIcon.classList.remove('text-gray-300');
                            uploadIcon.classList.add('text-red-500');
                        }
                    }, false);
                });

                // Unhighlight drop zone
                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => {
                        dropZone.classList.remove('border-red-500', 'bg-red-50');
                        if (uploadIcon) {
                            uploadIcon.classList.add('text-gray-300');
                            uploadIcon.classList.remove('text-red-500');
                        }
                    }, false);
                });

                // Handle file drop
                dropZone.addEventListener('drop', function (e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    if (files.length > 0) {
                        fileInput.files = files;
                        handleFiles(files[0]);
                    }
                }, false);

                // Handle file browse
                fileInput.addEventListener('change', function (e) {
                    if (this.files.length > 0) {
                        handleFiles(this.files[0]);
                    }
                });

                // Fungsi menampilkan preview dan validasi
                function handleFiles(file) {
                    // Validasi tipe file
                    if (!file.type.startsWith('image/')) {
                        alert('File harus berupa gambar!');
                        fileInput.value = '';
                        return;
                    }
                    // Validasi ukuran (10MB)
                    if (file.size > MAX_FILE_SIZE) {
                        alert('Ukuran file maksimal 10MB!');
                        fileInput.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }

                // Tombol Hapus Preview
                removeBtn.addEventListener('click', function () {
                    fileInput.value = '';
                    imagePreview.classList.add('hidden');
                    previewImg.src = '';
                });

                // --- 3. FORM VALIDATION Akhir ---
                document.getElementById('pabrikanForm').addEventListener('submit', function (e) {
                    const nama = document.getElementById('nama_pabrikan').value.trim();
                    const negara = document.getElementById('asal_negara').value;

                    // Cek nama yang duplikat (melalui status disabled tombol submit)
                    if (submitButton.disabled) {
                        e.preventDefault();
                        alert('Nama pabrikan sudah terdaftar, harap gunakan nama lain!');
                        namaPabrikanInput.focus();
                        return;
                    }

                    // Cek input wajib diisi
                    if (!nama || negara === "") {
                        e.preventDefault();
                        alert('Mohon lengkapi field Nama Pabrikan dan Asal Negara.');
                    }
                });
            });
        </script>
    @endsection

@endsection