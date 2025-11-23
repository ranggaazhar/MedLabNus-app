document.addEventListener('DOMContentLoaded', function () {
    console.log("Edit Pabrikan Script Loaded.");

    const modal = document.getElementById('editModal');
    // .edit-button sekarang ada di dalam komponen pabrikan-card
    const editButtons = document.querySelectorAll('.edit-button'); 
    const closeModalButtons = document.querySelectorAll('.close-modal');
    const editForm = document.getElementById('editForm');
    const modalNamaPabrikan = document.getElementById('modal_nama_pabrikan');
    const modalAsalNegara = document.getElementById('modal_asal_negara');
    const currentLogoContainer = document.getElementById('current_logo_container');
    const modalCurrentLogo = document.getElementById('modal_current_logo');
    
    // URL Placeholder Icon default (jika tidak ada logo di database)
    const DEFAULT_LOGO_PLACEHOLDER = 'https://placehold.co/64x64/f3f4f6/374151?text=NO+LOGO';


    // Fungsi untuk menampilkan modal dengan transisi
    const openModal = (pabrikan) => {
        
        // 1. Set action form untuk PUT request
        // Sesuaikan dengan rute Laravel Anda, misalnya: /admin/pabrikan/123
        editForm.action = `/admin/pabrikan/${pabrikan.id}`; 
        
        // 2. Isi form dengan data pabrikan
        modalNamaPabrikan.value = pabrikan.nama;
        modalAsalNegara.value = pabrikan.negara;
        
        // 3. Penanganan Logo saat ini
        if (pabrikan.logo) {
            // Jika ada logo dari database
            modalCurrentLogo.src = pabrikan.logo;
            currentLogoContainer.querySelector('p').textContent = 'Logo Saat Ini:';
        } else {
            // Jika tidak ada logo, tampilkan placeholder
            modalCurrentLogo.src = DEFAULT_LOGO_PLACEHOLDER;
            currentLogoContainer.querySelector('p').textContent = 'Tidak Ada Logo Saat Ini';
        }
        
        // 4. Tampilkan modal dengan transisi
        modal.classList.remove('hidden');
        // Tambahkan opacity setelah sedikit delay untuk mengaktifkan transisi CSS
        setTimeout(() => {
            modal.classList.add('opacity-100');
        }, 10);
    };

    // Fungsi untuk menyembunyikan modal dengan transisi
    const closeModal = () => {
        // Hilangkan opacity lebih dulu
        modal.classList.remove('opacity-100');
        
        // Tambahkan 'hidden' setelah transisi selesai (300ms, sesuai transisi Tailwind default)
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    };

    // Event listener untuk tombol 'Edit'
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const pabrikanData = {
                id: this.getAttribute('data-id'),
                nama: this.getAttribute('data-nama'),
                negara: this.getAttribute('data-negara'),
                logo: this.getAttribute('data-logo')
            };
            openModal(pabrikanData);
        });
    });

    // Event listener untuk tombol 'Batal' di dalam modal
    closeModalButtons.forEach(button => {
        button.addEventListener('click', closeModal);
    });

    // Event listener untuk menutup modal saat klik di luar area modal
    modal.addEventListener('click', function(e) {
        // Hanya tutup jika yang diklik adalah backdrop (modal itu sendiri)
        if (e.target === modal) {
            closeModal();
        }
    });
});