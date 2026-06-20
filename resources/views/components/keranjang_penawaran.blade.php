<x-app-layout>
    <div class="container mx-auto px-4 sm:px-6 py-10 max-w-7xl">
        {{-- JUDUL HALAMAN --}}
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-950 tracking-tight">Daftar Keranjang Penawaran</h1>
            <p class="text-xs sm:text-sm text-gray-400 font-medium italic mt-1">Kelola daftar alat kesehatan dan ajukan
                penawaran harga resmi</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- SISI KIRI: TABEL KERANJANG & REKOMENDASI --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- KONTEN UTAMA TABEL --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[500px]">
                            <thead>
                                <tr
                                    class="border-b border-gray-100 text-gray-400 text-[10px] font-black uppercase tracking-widest">
                                    <th class="pb-4" colspan="2">Detail Produk</th>
                                    <th class="pb-4 text-center">Jumlah (Qty)</th>
                                    <th class="pb-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            {{-- Jarak vertical antar baris dikendalikan oleh class "divide-y" dan padding internal TD --}}
                            <tbody id="cart-table-body" class="divide-y divide-gray-50">
                                {{-- Diisi via JavaScript --}}
                            </tbody>
                        </table>
                    </div>

                    {{-- TOMBOL KEMBALI --}}
                    <div class="mt-8 pt-6 border-t border-gray-50">
                        <a href="{{ route('products.public') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold rounded-full border border-gray-200 shadow-sm transition-all duration-200">
                            &larr; Kembali Cari Produk
                        </a>
                    </div>
                </div>

                {{-- REKOMENDASI PRODUK TERKAIT --}}
                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-base font-bold text-gray-900 uppercase tracking-wide">Rekomendasi Produk
                                Terkait</h3>
                            <p class="text-[10px] text-gray-400 font-medium">Mungkin instansi Anda juga membutuhkan alat
                                kesehatan berikut</p>
                        </div>
                        <span
                            class="text-[10px] font-bold text-gray-400 bg-gray-50 px-2.5 py-1 rounded border border-gray-200 md:hidden">Geser
                            &rarr;</span>
                    </div>

                    <div class="flex overflow-x-auto pb-4 gap-5 snap-x scrollbar-thin scrollbar-thumb-gray-200">
                        @forelse ($relatedProducts ?? [] as $related)
                            <a href="{{ route('products.show', $related->produk_id) }}"
                                class="group block bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 w-48 shrink-0 snap-start">

                                <div
                                    class="aspect-square bg-gray-50/50 p-4 flex items-center justify-center overflow-hidden relative">
                                    @php
                                        $src = 'images/default-product.png';
                                        if ($related->gambar_utama) {
                                            $src = Str::startsWith($related->gambar_utama, 'uploads/')
                                                ? $related->gambar_utama
                                                : 'uploads/products/' . $related->gambar_utama;
                                        }
                                    @endphp
                                    <img src="{{ asset($src) }}" alt="{{ $related->nama_produk }}"
                                        class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-500"
                                        onerror="this.onerror=null; this.src='/images/default-product.png';">
                                </div>

                                <div class="p-4">
                                    <p
                                        class="text-[9px] font-black text-red-600 mb-0.5 uppercase tracking-widest truncate">
                                        {{ $related->pabrikan->nama_pabrikan ?? 'Unknown Brand' }}
                                    </p>
                                    <h4
                                        class="font-bold text-xs text-gray-800 leading-snug group-hover:text-[#B1252E] transition-colors duration-300 line-clamp-2 h-9">
                                        {{ $related->nama_produk }}
                                    </h4>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-8 text-gray-400 italic text-sm w-full">
                                Tidak ada produk terkait yang tersedia.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- SISI KANAN: FORM DATA PEMOHON --}}
            <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 h-fit sticky top-6">
                <div class="mb-5 border-b border-gray-50 pb-4">
                    <h2 class="text-base font-black text-gray-900 uppercase tracking-wide">Data Pemohon Penawaran</h2>
                    <p class="text-[10px] text-gray-400 font-medium">Lengkapi identitas untuk penerbitan berkas
                        penawaran resmi</p>
                </div>

                <form id="formSubmitPenawaran" class="space-y-5">
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-2 ml-0.5">Nama
                            Instansi / Pelanggan</label>
                        <input type="text" id="nama_pelanggan"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#B1252E] focus:border-transparent focus:bg-white focus:outline-none text-sm font-medium transition-all"
                            placeholder="Contoh: RS Swasta / Lab Merdeka" required>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-2 ml-0.5">
                            No. WhatsApp Aktif
                        </label>

                        {{-- Input tersembunyi yang akan dikirim ke database --}}
                        {{-- Pastikan atribut 'name' sesuai dengan kolom di database Anda --}}
                        <input type="hidden" name="whatsapp_pelanggan" id="whatsapp_pelanggan_hidden">

                        {{-- Container Input Group --}}
                        <div
                            class="flex items-center bg-gray-50 border border-gray-200 rounded-xl focus-within:ring-2 focus-within:ring-[#B1252E] focus-within:border-transparent focus-within:bg-white transition-all overflow-hidden">

                            {{-- Prefix +62 yang di-lock (tidak bisa diubah) --}}
                            <div
                                class="px-4 py-3 bg-gray-100 text-gray-500 font-bold text-sm border-r border-gray-200 select-none">
                                +62
                            </div>

                            {{-- Input utama untuk user --}}
                            {{-- Atribut 'name' tidak digunakan di sini agar tidak ikut terkirim --}}
                            <input type="text" id="whatsapp_pelanggan_input"
                                class="w-full px-4 py-3 bg-transparent border-none focus:ring-0 focus:outline-none text-sm font-medium"
                                placeholder="821xxxxxx"
                                oninput="
                // 1. Hanya izinkan angka
                let val = this.value.replace(/[^0-9]/g, '');
                
                // 2. (Opsional/Bonus) Mencegah user bandel yang tetap mengetik angka '0' di depan
                if(val.startsWith('0')) {
                    val = val.substring(1);
                }
                
                // 3. Tampilkan kembali ke input visible
                this.value = val;
                
                // 4. Gabungkan 62 dengan input user dan masukkan ke hidden input
                document.getElementById('whatsapp_pelanggan_hidden').value = val ? '62' + val : '';
            "
                                required>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1 ml-0.5 font-medium">*Tidak perlu menuliskan lagi angka
                            0 atau 62 di depan.</p>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full py-3.5 bg-gradient-to-r from-[#B1252E] to-[#8f1d24] text-white font-bold rounded-xl shadow-lg shadow-red-100 hover:shadow-xl hover:scale-[1.01] transition-all text-sm tracking-wide">
                            Kirim Permintaan Penawaran
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- CUSTOM CSS SCROLLBAR --}}
    <style>
        .scrollbar-thin::-webkit-scrollbar {
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    {{-- CORE LOGIC JAVASCRIPT --}}
    <script>
        // Kunci keranjang unik per user agar tidak bocor antar akun
        const CART_KEY = 'keranjang_penawaran_{{ auth()->id() ?? 'guest' }}';

        document.addEventListener('DOMContentLoaded', function() {
            renderCartTable();

            // Fungsi Render Tabel dari LocalStorage dengan Padding Lebih Longgar
            function renderCartTable() {
                const cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
                const tableBody = document.getElementById('cart-table-body');

                if (cart.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center py-16 text-gray-400 italic text-sm">
                                Keranjang masih kosong. Silakan pilih produk terlebih dahulu.
                            </td>
                        </tr>
                    `;
                    return;
                }

                tableBody.innerHTML = cart.map((item, index) => {
                    let imageUrl = '/images/default-product.png';

                    if (item.gambar_utama) {
                        if (item.gambar_utama.startsWith('uploads/')) {
                            imageUrl = `/${item.gambar_utama}`;
                        } else {
                            imageUrl = `/uploads/products/${item.gambar_utama}`;
                        }
                    }

                    return `
                        <tr class="group text-gray-700 hover:bg-gray-50/40 transition-colors">
                           <td class="py-5 w-20 align-middle">
                                <img src="${imageUrl}" 
                                    alt="${item.nama_produk}" 
                                    class="w-16 h-16 object-contain p-1.5 mix-blend-multiply rounded-xl border border-gray-100 bg-gray-50/50 shadow-sm group-hover:scale-105 transition-transform duration-300"
                                    onerror="this.onerror=null; this.src='/images/default-product.png';">
                            </td>
                            
                            <td class="py-5 pl-4 align-middle">
                                <div class="font-bold text-sm text-gray-900 leading-snug">${item.nama_produk}</div>
                            </td>
                            
                            <td class="py-5 align-middle">
                                <div class="flex items-center justify-center">
                                    <div class="flex items-center border border-gray-200 rounded-xl bg-gray-50 p-1 shadow-inner">
                                        <button type="button" onclick="changeQty(${index}, -1)" 
                                            class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-[#B1252E] hover:bg-white rounded-lg transition-all active:scale-90">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                        </button>
                                        
                                        <input type="number" min="1" value="${item.jumlah}" id="qty-input-${index}"
                                            class="w-12 text-center bg-transparent border-0 p-0 font-bold text-gray-800 text-sm focus:outline-none focus:ring-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                            onchange="updateQty(${index}, this.value)">
                                        
                                        <button type="button" onclick="changeQty(${index}, 1)" 
                                            class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-[#B1252E] hover:bg-white rounded-lg transition-all active:scale-90">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <td class="py-5 text-right align-middle">
                                <button type="button" class="text-xs font-bold text-gray-400 hover:text-red-600 bg-gray-50 hover:bg-red-50 px-3 py-1.5 rounded-lg border border-gray-200 hover:border-red-100 transition-all active:scale-95" onclick="removeItem(${index})">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');
            }

            window.changeQty = function(index, delta) {
                const inputElement = document.getElementById(`qty-input-${index}`);
                let currentVal = parseInt(inputElement.value) || 1;
                let newVal = currentVal + delta;

                if (newVal < 1) newVal = 1;

                inputElement.value = newVal;
                updateQty(index, newVal);
            }

            window.updateQty = function(index, value) {
                let cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
                let parsedValue = parseInt(value) || 1;
                if (parsedValue < 1) parsedValue = 1;

                cart[index].jumlah = parsedValue;
                localStorage.setItem(CART_KEY, JSON.stringify(cart));
                if (typeof updateCartBadge === 'function') updateCartBadge();
            }

            window.removeItem = function(index) {
                const namaTemp = document.getElementById('nama_pelanggan').value;
                const waTemp = document.getElementById('whatsapp_pelanggan_input').value;

                let cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
                cart.splice(index, 1);
                localStorage.setItem(CART_KEY, JSON.stringify(cart));

                renderCartTable();

                document.getElementById('nama_pelanggan').value = namaTemp;
                document.getElementById('whatsapp_pelanggan_input').value = waTemp;

                if (typeof updateCartBadge === 'function') updateCartBadge();
            }

            document.getElementById('formSubmitPenawaran').addEventListener('submit', function(e) {
                e.preventDefault();

                const cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
                if (cart.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Keranjang belanja Anda kosong!'
                    });
                    return;
                }

                const payload = {
                    nama_pelanggan: document.getElementById('nama_pelanggan').value,
                    whatsapp_pelanggan: document.getElementById('whatsapp_pelanggan_input').value,
                    items: cart.map((item) => {
                        const realProdukId = item.produk_id || item.id || item.id_produk || item
                            .product_id;
                        return {
                            produk_id: realProdukId,
                            jumlah: item.jumlah || item.qty || 1
                        }
                    })
                };

                fetch("{{ route('penawaran.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(async response => {
                        const isJson = response.headers.get('content-type')?.includes('application/json');
                        const data = isJson ? await response.json() : null;

                        if (!response.ok) {
                            let errorMsg = 'Terjadi kesalahan pada server.';
                            if (data) {
                                if (data.errors) {
                                    errorMsg = Object.values(data.errors).flat().join('\n');
                                } else if (data.message) {
                                    errorMsg = data.message;
                                }
                            }
                            throw new Error(errorMsg);
                        }
                        return data;
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                confirmButtonText: 'Lanjut ke WhatsApp'
                            }).then((result) => {
                                localStorage.removeItem(CART_KEY);
                                if (typeof updateCartBadge === 'function') updateCartBadge();

                                const nomorAdmin = "6282177629753";
                                const teksPesan = `Halo Admin, saya ingin mengajukan Permintaan Penawaran Harga.

*Data Pemohon:*
• *Nama Instansi:* ${document.getElementById('nama_pelanggan').value}
• *No. WhatsApp:* ${document.getElementById('whatsapp_pelanggan_input').value}
• *Kode Penawaran:* ${data.kode_penawaran}

*Dokumen PDF Penawaran:*
Silakan unduh lampiran dokumen resmi melalui tautan di bawah ini:
${data.pdf_url}

Terima kasih.`;

                                const encodePesan = encodeURIComponent(teksPesan);
                                const urlWhatsApp =
                                    `https://api.whatsapp.com/send?phone=${nomorAdmin}&text=${encodePesan}`;

                                window.location.href = urlWhatsApp;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal mengirim penawaran: ' + data.message
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: error.message
                        });
                    });
            });
        });
    </script>
</x-app-layout>
