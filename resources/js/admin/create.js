document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('logo_pabrikan_input');
    const dropzoneArea = document.getElementById('dropzoneArea');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const logoPreview = document.getElementById('logoPreview');

    // Event listener saat file diunggah
    fileInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            const uploadedFile = this.files[0];
            const fileType = uploadedFile.type;
            
            // Cek tipe file yang diizinkan
            if (!['image/png', 'image/jpeg'].includes(fileType)) {
                // Di aplikasi nyata, tampilkan pesan kesalahan ke pengguna di UI (bukan hanya console)
                console.error('Hanya file PNG atau JPEG yang didukung.');
                return;
            }
            
            // Tampilkan pratinjau logo
            const reader = new FileReader();
            reader.onload = (e) => {
                logoPreview.src = e.target.result;
                logoPreview.alt = uploadedFile.name;
                
                // Sembunyikan placeholder dan tampilkan pratinjau
                uploadPlaceholder.classList.add('hidden');
                imagePreviewContainer.classList.remove('hidden');
                
                // Ubah styling dropzone
                // p-2 dan h-auto menjaga agar box tetap kompak setelah ada gambar
                dropzoneArea.classList.add('p-2', 'border-red-500', 'h-auto'); 
                dropzoneArea.classList.remove('p-10');
            };
            reader.readAsDataURL(uploadedFile);
        } else {
            // Jika file dibatalkan, kembalikan ke tampilan placeholder
            logoPreview.src = '';
            uploadPlaceholder.classList.remove('hidden');
            imagePreviewContainer.classList.add('hidden');
            dropzoneArea.classList.remove('p-2', 'border-red-500', 'h-auto');
            dropzoneArea.classList.add('p-10');
        }
    });

    // Tambahkan event drag & drop untuk pengalaman pengguna yang lebih baik
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzoneArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzoneArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzoneArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropzoneArea.classList.add('ring-4', 'ring-red-300', 'bg-red-50');
    }

    function unhighlight(e) {
        dropzoneArea.classList.remove('ring-4', 'ring-red-300', 'bg-red-50');
    }

    dropzoneArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        let dt = e.dataTransfer;
        let files = dt.files;
        
        if (files.length > 0) {
            // Set file yang didrop ke input file
            fileInput.files = files;
            // Panggil event change secara manual untuk memicu pratinjau
            fileInput.dispatchEvent(new Event('change'));
        }
    }
});