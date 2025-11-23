/**
 * resources/js/admin/modules/dropdown.js
 * Modul untuk menangani logika dropdown pada navbar (User Profile).
 */

export function initProfileDropdown() {
    const trigger = document.getElementById('profileDropdownTrigger');
    const menu = document.getElementById('profileDropdownMenu');
    
    // Pilih elemen ikon chevron untuk rotasi
    const chevron = trigger ? trigger.querySelector('.fa-chevron-down') : null;

    if (trigger && menu) {
        
        // --- Logika Utama Klik Trigger ---
        trigger.addEventListener('click', function (event) {
            event.stopPropagation(); // Mencegah klik menyebar ke body
            
            // Toggle display
            const isHidden = menu.classList.toggle('hidden');
            
            // Mengubah rotasi panah (jika elemen ditemukan)
            if (chevron) {
                if (isHidden) {
                    chevron.classList.remove('rotate-180');
                } else {
                    chevron.classList.add('rotate-180');
                }
            }
        });

        // --- Logika Menutup Ketika Klik di Luar ---
        document.addEventListener('click', function (event) {
            // Pastikan klik terjadi di luar menu DAN menu tidak tersembunyi
            if (!menu.classList.contains('hidden') && !menu.contains(event.target) && !trigger.contains(event.target)) {
                menu.classList.add('hidden');
                if (chevron) {
                    chevron.classList.remove('rotate-180');
                }
            }
        });
        
        // --- Logika Mencegah Penutupan Saat Klik di Dalam Menu ---
        menu.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    }
}