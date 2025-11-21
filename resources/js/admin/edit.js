document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('editModal');
    const editButtons = document.querySelectorAll('.edit-button');
    const closeModalButtons = document.querySelectorAll('.close-modal');
    const editForm = document.getElementById('editForm');
    const modalNamaPabrikan = document.getElementById('modal_nama_pabrikan');
    const modalAsalNegara = document.getElementById('modal_asal_negara');
    const currentLogoContainer = document.getElementById('current_logo_container');
    const modalCurrentLogo = document.getElementById('modal_current_logo');


    // Fungsi untuk menampilkan modal
    const openModal = (pabrikan) => {
        // Set action form untuk PUT request ke route update yang benar
        // Catatan: Pastikan server-side route Laravel sudah terdefinisi dengan benar
        editForm.action = `/admin/pabrikan/${pabrikan.id}`; 
        
        // Isi form dengan data pabrikan
        modalNamaPabrikan.value = pabrikan.nama;
        modalAsalNegara.value = pabrikan.negara;
        
        // Tampilkan logo saat ini (jika ada)
        if (pabrikan.logo) {
            // Tampilkan gambar logo saat ini
            modalCurrentLogo.src = pabrikan.logo;
            modalCurrentLogo.classList.remove('hidden');
            currentLogoContainer.querySelector('p').textContent = 'Logo Saat Ini:'; // Reset text
        } else {
            // Tampilkan placeholder jika tidak ada logo
            modalCurrentLogo.src = 'https://placehold.co/64x64/d1d5db/374151?text=N/A';
            modalCurrentLogo.classList.remove('hidden');
            currentLogoContainer.querySelector('p').textContent = 'Tidak Ada Logo Saat Ini';
        }

        modal.classList.remove('hidden');
    };

    // Fungsi untuk menyembunyikan modal
    const closeModal = () => {
        modal.classList.add('hidden');
    };

    // Event listener untuk tombol 'Edit' di baris tabel
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
        if (e.target === modal) {
            closeModal();
        }
    });
});