<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Keranjang Penawaran Anda</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-gray-500 text-sm">
                                    <th class="pb-3" colspan="2">Produk</th>
                                    <th class="pb-3 text-center">Jumlah (Qty)</th>
                                    <th class="pb-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="cart-table-body">
                                {{-- Diisi via JavaScript --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('products.public') }}"
                            class="inline-block px-6 py-2 bg-[#B1252E] text-white text-sm font-bold rounded-full shadow-md hover:scale-105 transition-all">
                            &larr; Kembali Cari Produk
                        </a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Rekomendasi Produk Terkait</h3>
                        <span class="text-xs text-gray-400 md:hidden">Geser &rarr;</span>
                    </div>

                    <div class="flex overflow-x-auto pb-4 gap-4 snap-x scrollbar-thin scrollbar-thumb-gray-200">
                        @forelse ($relatedProducts ?? [] as $related)
                            <a href="{{ route('products.show', $related->produk_id) }}"
                                class="group block bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 w-48 shrink-0 snap-start">

                                <div
                                    class="aspect-square bg-gray-100 p-4 flex items-center justify-center overflow-hidden relative">
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
                                        class="text-[10px] text-gray-400 mb-0.5 font-medium uppercase tracking-wider truncate">
                                        {{ $related->pabrikan->nama_pabrikan ?? 'Unknown Brand' }}
                                    </p>
                                    <h4
                                        class="font-bold text-sm text-gray-900 leading-tight group-hover:text-[#B1252E] transition-colors duration-300 line-clamp-2 h-10">
                                        {{ $related->nama_produk }}
                                    </h4>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-6 text-gray-400 w-full">
                                Tidak ada produk terkait yang tersedia.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
                <h2 class="text-lg font-bold mb-4 text-gray-700">Data Pemohon Penawaran</h2>

                <form id="formSubmitPenawaran">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Nama Instansi /
                                Pelanggan</label>
                            <input type="text" id="nama_pelanggan"
                                class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#B1252E] focus:outline-none text-sm"
                                placeholder="RS Swasta / Lab Merdeka" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">No. WhatsApp</label>
                            <input type="text" id="whatsapp_pelanggan"
                                class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#B1252E] focus:outline-none text-sm"
                                placeholder="Contoh: 62821xxx" required>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-gradient-to-r from-[#B1252E] to-[#8f1d24] text-white font-bold rounded-lg shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all text-sm">
                        Kirim Permintaan Penawaran
                    </button>
                </form>
            </div>

        </div>
    </div>

    <style>
        .scrollbar-thin::-webkit-scrollbar {
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            renderCartTable();

            // Fungsi Render Tabel dari LocalStorage
            function renderCartTable() {
                const cart = JSON.parse(localStorage.getItem('keranjang_penawaran')) || [];
                const tableBody = document.getElementById('cart-table-body');

                if (cart.length === 0) {
                    tableBody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-400">
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
                <tr class="border-b border-gray-100 text-gray-700 hover:bg-gray-50/50 transition-colors">
                    <td class="py-4 w-20">
                        <img src="${imageUrl}" 
                            alt="${item.nama_produk}" 
                            class="w-16 h-16 object-cover rounded-xl border border-gray-100 shadow-sm"
                            onerror="this.onerror=null; this.src='/images/default-product.png';">
                    </td>
                    <td class="py-4 pl-2 font-medium align-middle">${item.nama_produk}</td>
                    
                    <td class="py-4 align-middle">
                        <div class="flex items-center justify-center">
                            <div class="flex items-center border border-gray-200 rounded-lg bg-gray-50 p-0.5 shadow-sm">
                                <button type="button" onclick="changeQty(${index}, -1)" 
                                    class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-[#B1252E] hover:bg-white rounded-md transition-all active:scale-95">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                                
                                <input type="number" min="1" value="${item.jumlah}" id="qty-input-${index}"
                                    class="w-12 text-center bg-transparent border-0 p-0 font-semibold text-gray-800 text-sm focus:outline-none focus:ring-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    onchange="updateQty(${index}, this.value)">
                                
                                <button type="button" onclick="changeQty(${index}, 1)" 
                                    class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-[#B1252E] hover:bg-white rounded-md transition-all active:scale-95">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </td>

                    <td class="py-4 text-right align-middle">
                        <button type="button" class="text-red-500 hover:text-red-700 text-sm font-semibold transition-colors" onclick="removeItem(${index})">
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
                let cart = JSON.parse(localStorage.getItem('keranjang_penawaran')) || [];
                let parsedValue = parseInt(value) || 1;
                if (parsedValue < 1) parsedValue = 1;

                cart[index].jumlah = parsedValue;
                localStorage.setItem('keranjang_penawaran', JSON.stringify(cart));
                if (typeof updateCartBadge === 'function') updateCartBadge();
            }

            window.removeItem = function(index) {
                // SOLUSI BUG 1: Ambil dan amankan nilai input sementara sebelum render ulang tabel
                const namaTemp = document.getElementById('nama_pelanggan').value;
                const waTemp = document.getElementById('whatsapp_pelanggan').value;

                let cart = JSON.parse(localStorage.getItem('keranjang_penawaran')) || [];
                cart.splice(index, 1);
                localStorage.setItem('keranjang_penawaran', JSON.stringify(cart));

                renderCartTable();

                // Kembalikan nilai input user yang diamankan tadi
                document.getElementById('nama_pelanggan').value = namaTemp;
                document.getElementById('whatsapp_pelanggan').value = waTemp;

                if (typeof updateCartBadge === 'function') updateCartBadge();
            }

            document.getElementById('formSubmitPenawaran').addEventListener('submit', function(e) {
                e.preventDefault();

                const cart = JSON.parse(localStorage.getItem('keranjang_penawaran')) || [];
                if (cart.length === 0) {
                    alert('Keranjang belanja Anda kosong!');
                    return;
                }

                const payload = {
                    nama_pelanggan: document.getElementById('nama_pelanggan').value,
                    whatsapp_pelanggan: document.getElementById('whatsapp_pelanggan').value,
                    items: cart.map((item, index) => {
                        // 🔍 MENCARI KEY ID YANG SEBENARNYA ADA DI LOCALSTORAGE
                        // Kita cek semua kemungkinan nama properti yang sering kamu pakai
                        const realProdukId = item.produk_id || item.id || item.id_produk || item
                            .product_id;

                        // Cetak di console F12 untuk pembuktian
                        console.log(`Item indeks ke-${index}:`, item);
                        console.log(`ID Produk yang berhasil ditangkap:`, realProdukId);

                        return {
                            produk_id: realProdukId, // Dikirim ke Laravel dengan nama 'produk_id'
                            jumlah: item.jumlah || item.qty || 1
                        }
                    })
                };

                fetch("{{ route('penawaran.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);

                            localStorage.removeItem('keranjang_penawaran');
                            if (typeof updateCartBadge === 'function') updateCartBadge();

                            const nomorAdmin = "62895335992588"; // 🌟 Silakan disesuaikan

                            // SOLUSI BUG 2: Menghapus spasi tabulasi sebelah kiri agar chat WA rapi rapat kiri
                            const teksPesan = `Halo Admin, saya ingin mengajukan Permintaan Penawaran Harga.

*Data Pemohon:*
• *Nama Instansi:* ${document.getElementById('nama_pelanggan').value}
• *No. WhatsApp:* ${document.getElementById('whatsapp_pelanggan').value}
• *Kode Penawaran:* ${data.kode_penawaran}

*Dokumen PDF Penawaran:*
Silakan unduh lampiran dokumen resmi melalui tautan di bawah ini:
${data.pdf_url}

Terima kasih.`;

                            const encodePesan = encodeURIComponent(teksPesan);
                            const urlWhatsApp =
                                `https://api.whatsapp.com/send?phone=${nomorAdmin}&text=${encodePesan}`;

                            window.location.href = urlWhatsApp;

                        } else {
                            alert('Gagal mengirim penawaran: ' + data.message);
                        }
                    });
            });
        });
    </script>
</x-app-layout>
