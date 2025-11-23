import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Modul Kustom Admin (PERBAIKAN JALUR IMPORT)
// Kita harus masuk ke folder './admin/modules/'
import { initProfileDropdown } from './admin/modules/dropdown';
import { initSidebarToggle } from './admin/modules/sidebar';

// 1. Jalankan Alpine.js
Alpine.start();


// 2. Jalankan Modul Kustom setelah DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    console.log("Admin App: Running custom modules.");
    
    // Inisialisasi komponen UI umum dari modul kustom
    initProfileDropdown();
    initSidebarToggle();
});