@extends('admin.layouts.app')

@section('title', 'Tambah Invoice')

@section('content')

    <div class="py-4 px-2" x-data="invoiceForm">

        {{-- HEADER BANNER --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-5 mb-6 border-b border-gray-200 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Menerbitkan Invoice Resmi</h1>
                <p class="text-sm text-gray-500 mt-1">Pilih dokumen referensi surat penawaran untuk memetakan item secara otomatis.</p>
            </div>
            <div>
                <a href="{{ route('admin.invoice.index') }}"
                    class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl text-sm font-semibold shadow-sm hover:bg-gray-50 transition-all flex items-center gap-2">
                    <i class="fas fa-arrow-left text-xs text-gray-400"></i> Kembali
                </a>
            </div>
        </div>

        {{-- GRID UTAMA --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- SISI KIRI: CONFIGURATOR FORM --}}
            <div class="lg:col-span-7 space-y-6">

                {{-- CARD 1: DROPDOWN SELECTION (CARD PUTIH) --}}
                <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm space-y-3">
                    <label class="block text-xs font-bold text-red-700 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1.5 h-3 bg-red-700 rounded-sm"></span> Referensi Dokumen Penawaran
                    </label>
                    <div class="relative">
                        <select x-model="penawaran_id" @change="pilihPenawaran()"
                            class="w-full px-4 py-3 rounded-xl text-sm bg-white border border-gray-300 focus:ring-2 focus:ring-red-600 focus:border-red-600 focus:outline-none transition-all appearance-none font-medium text-gray-800 shadow-sm">
                            <option value="">-- Pilih Surat Penawaran --</option>
                            <template x-for="p in daftarPenawaran" :key="p.id">
                                <option :value="p.id" x-text="(p.kode_penawaran || 'PNW') + ' - ' + p.nama_pelanggan"></option>
                            </template>
                        </select>
                    </div>
                </div>

                {{-- CONTAINER FORM (Hanya tampil jika penawaran sudah dipilih) --}}
                <div x-show="penawaran_id" x-transition class="space-y-6" x-cloak>

                    {{-- CARD 2: INFORMASI PELANGGAN & STATUS (CARD PUTIH) --}}
                    <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm space-y-4">
                        <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                            <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-user-tie text-red-700"></i> 1. Informasi & Status
                            </h3>
                            <button type="button" @click="isEditing = !isEditing"
                                :class="isEditing ? 'bg-red-700 text-white hover:bg-red-800 shadow-md' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm">
                                <i class="fas" :class="isEditing ? 'fa-lock-open' : 'fa-lock'"></i>
                                <span x-text="isEditing ? 'Selesai Ubah' : 'Buka Kunci Edit'"></span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nama Pelanggan</label>
                                <input type="text" x-model="nama_pelanggan" :disabled="!isEditing"
                                    :class="!isEditing ? 'bg-gray-50 text-gray-500 border-gray-200 cursor-not-allowed shadow-inner' : 'bg-white border-gray-300 focus:ring-2 focus:ring-red-600 focus:border-red-600'"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm focus:outline-none transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nomor WhatsApp</label>
                                <input type="text" x-model="whatsapp_pelanggan" :disabled="!isEditing"
                                    :class="!isEditing ? 'bg-gray-50 text-gray-500 border-gray-200 cursor-not-allowed shadow-inner' : 'bg-white border-gray-300 focus:ring-2 focus:ring-red-600 focus:border-red-600'"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm focus:outline-none transition-all shadow-sm">
                            </div>
                            
                            {{-- 🌟 FITUR BARU: Dropdown Status Pembayaran --}}
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Status Pembayaran Saat Ini</label>
                                <div class="relative">
                                    <select x-model="status_pembayaran" :disabled="!isEditing"
                                        :class="!isEditing ? 'bg-gray-50 text-gray-500 border-gray-200 cursor-not-allowed shadow-inner' : 'bg-white border-gray-300 focus:ring-2 focus:ring-red-600 focus:border-red-600'"
                                        class="w-full px-4 py-2.5 rounded-xl text-sm appearance-none focus:outline-none transition-all shadow-sm font-bold">
                                        <option value="pending">Pending</option>
                                        <option value="lunas">Lunas</option>
                                        <option value="batal">Batal</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4" :class="isEditing ? 'text-gray-500' : 'text-transparent'">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 3: RINCIAN ALKES --}}
                    <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm space-y-4">
                        <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                            <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-boxes text-red-700"></i> 2. Rincian Item Alat Kesehatan
                            </h3>
                            <button type="button" x-show="isEditing" x-transition
                                @click="items.push({ nama: '', qty: 1, harga: 0 })"
                                class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-bold hover:bg-red-100 transition-all flex items-center gap-1">
                                <i class="fas fa-plus-circle"></i> Tambah Baris
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="flex gap-3 items-center p-3.5 rounded-xl border border-gray-200 bg-white shadow-sm">
                                    <div class="flex-1">
                                        <input type="text" x-model="item.nama" :disabled="!isEditing" required placeholder="Nama Produk Alkes"
                                            :class="!isEditing ? 'bg-transparent border-transparent text-gray-900 font-medium p-0 focus:ring-0 shadow-none' : 'bg-white border-gray-300 px-3 py-2 rounded-lg text-sm focus:ring-2 focus:ring-red-600 focus:border-red-600'"
                                            class="w-full text-sm focus:outline-none transition-all">
                                    </div>
                                    <div class="w-20">
                                        <input type="number" x-model.number="item.qty" :disabled="!isEditing" min="1" required placeholder="Qty"
                                            :class="!isEditing ? 'bg-transparent border-transparent text-center font-bold text-gray-800 p-0 focus:ring-0 shadow-none' : 'bg-white border-gray-300 py-2 rounded-lg text-sm text-center focus:ring-2 focus:ring-red-600 focus:border-red-600'"
                                            class="w-full text-sm focus:outline-none transition-all">
                                    </div>
                                    <div class="w-40">
                                        <div class="flex items-center relative">
                                            <span x-show="isEditing" class="absolute left-3 text-xs text-gray-400 font-semibold">Rp</span>
                                            <input type="number" x-model.number="item.harga" :disabled="!isEditing" min="0" required
                                                :class="!isEditing ? 'bg-transparent border-transparent text-right font-bold text-gray-900 p-0 focus:ring-0 shadow-none' : 'bg-white border-gray-300 pl-8 pr-3 py-2 rounded-lg text-sm font-medium focus:ring-2 focus:ring-red-600 focus:border-red-600'"
                                                class="w-full text-sm focus:outline-none transition-all">
                                        </div>
                                    </div>
                                    <div x-show="isEditing" x-transition>
                                        <button type="button" @click="if(items.length > 1) items.splice(index, 1)"
                                            class="text-gray-400 hover:text-red-600 p-1.5 hover:bg-gray-50 rounded-lg transition-all">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- TOMBOL SUBMIT --}}
                    <div class="pt-2 flex justify-end">
                        <button type="button" :disabled="isSubmitting" @click="kirimInvoice()"
                            class="w-full sm:w-auto px-6 py-3.5 bg-red-700 text-white rounded-xl text-sm font-bold shadow-md hover:bg-red-800 active:bg-red-950 transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fas fa-check-circle" x-show="!isSubmitting"></i>
                            <i class="fas fa-spinner animate-spin" x-show="isSubmitting" x-cloak></i>
                            <span x-text="isSubmitting ? 'Sedang Memproses Dokumen...' : 'Terbitkan & Cetak Invoice Resmi'"></span>
                        </button>
                    </div>
                </div>

                {{-- STATE KOSONG --}}
                <div x-show="!penawaran_id" class="p-16 text-center border-2 border-dashed border-gray-300 rounded-2xl bg-white text-gray-400 shadow-sm">
                    <div class="w-16 h-16 bg-red-50 text-red-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-invoice text-2xl"></i>
                    </div>
                    <h4 class="text-sm font-bold text-gray-700 mb-1">Menunggu Dokumen Acuan</h4>
                    <p class="text-xs text-gray-400 max-w-sm mx-auto">Silahkan pilih nomor kode surat penawaran di atas untuk mengaktifkan berkas pengisian invoice.</p>
                </div>
            </div>

            {{-- SISI KANAN: LIVE PREVIEW DOKUMEN --}}
            <div class="lg:col-span-5 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm sticky top-6">
                <div class="flex justify-between items-center pb-3 border-b border-gray-100 mb-5">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full" :class="penawaran_id ? 'animate-pulse' : ''"></span> Live Document Preview
                    </span>
                    
                    {{-- 🌟 FITUR BARU: Badge Status Dinamis --}}
                    <span class="text-[10px] px-2.5 py-1 rounded-md font-bold uppercase tracking-wider border transition-all"
                        :class="{
                            'bg-amber-50 text-amber-700 border-amber-200': status_pembayaran === 'pending',
                            'bg-emerald-50 text-emerald-700 border-emerald-200': status_pembayaran === 'lunas',
                            'bg-red-50 text-red-700 border-red-200': status_pembayaran === 'batal'
                        }"
                        x-text="status_pembayaran">
                    </span>
                </div>

                <div class="space-y-5 text-xs text-gray-700">
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <h2 class="text-base font-black tracking-tight text-red-700">PT MEDLAB NUSANTARA</h2>
                            <p class="text-[10px] text-gray-400 mt-0.5 font-medium">Distributor Bahan & Alat Laboratorium Kesehatan</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="font-bold text-gray-900 bg-gray-50 px-2 py-1 rounded border border-gray-200">INV/{{ date('Ymd') }}/XXXX</p>
                            <p class="text-gray-400 text-[10px] mt-1">{{ date('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-50/70 border border-gray-200 rounded-xl">
                        <p class="text-[10px] uppercase text-gray-400 font-bold mb-1 tracking-wide">Ditagihkan Kepada:</p>
                        <p class="font-bold text-gray-800 text-sm" x-text="nama_pelanggan || '(Belum memilih penawaran)'"></p>
                        <p class="text-gray-500 mt-1 font-medium flex items-center gap-1" x-show="whatsapp_pelanggan">
                            <i class="fab fa-whatsapp text-emerald-600"></i> +<span x-text="whatsapp_pelanggan"></span>
                        </p>
                    </div>

                    <div class="space-y-2">
                        <div class="border-y border-gray-200 divide-y divide-gray-100">
                            <div class="flex py-2.5 font-bold text-gray-400 text-[10px] uppercase tracking-wider">
                                <div class="flex-1">Nama Unit Alkes</div>
                                <div class="w-12 text-center">Qty</div>
                                <div class="w-28 text-right">Subtotal</div>
                            </div>

                            <template x-for="(item, index) in items" :key="index">
                                <div class="flex py-3 items-center">
                                    <div class="flex-1 font-medium text-gray-800 truncate pr-2" x-text="item.nama"></div>
                                    <div class="w-12 text-center text-gray-500 font-bold" x-text="item.qty"></div>
                                    <div class="w-28 text-right font-bold text-gray-900" x-text="formatRupiah(item.qty * (item.harga || 0))"></div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="space-y-2 pt-2 text-right">
                        <div class="text-xs text-gray-500 font-medium">Subtotal: <span class="font-bold text-gray-800 ml-1" x-text="formatRupiah(subtotal)"></span></div>
                        <div class="text-xs text-gray-500 font-medium">PPN (11%): <span class="font-bold text-gray-800 ml-1" x-text="formatRupiah(ppn)"></span></div>
                        <div class="flex justify-between items-center pt-3 mt-1 border-t border-dashed border-gray-300">
                            <span class="font-bold text-gray-400 uppercase tracking-wider text-[11px]">Total Pembayaran:</span>
                            <span class="text-xl font-black text-red-700" x-text="formatRupiah(total)"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('invoiceForm', () => ({
                isSubmitting: false,
                isEditing: false,
                penawaran_id: '',
                nama_pelanggan: '',
                whatsapp_pelanggan: '',
                status_pembayaran: 'pending', // 🌟 Variabel Baru
                items: [],
                daftarPenawaran: @json($daftarPenawaran ?? []),

                pilihPenawaran() {
                    if (!this.penawaran_id) {
                        this.resetForm();
                        return;
                    }

                    const penawaranTerpilih = this.daftarPenawaran.find(p => p.id == this.penawaran_id);

                    if (penawaranTerpilih) {
                        this.nama_pelanggan = penawaranTerpilih.nama_pelanggan || '';
                        this.whatsapp_pelanggan = penawaranTerpilih.whatsapp_pelanggan || '';
                        this.status_pembayaran = 'pending'; // Reset status ke default setiap ganti penawaran

                        const itemsMentah = penawaranTerpilih.items || [];
                        this.items = itemsMentah.map(item => {
                            const produkObj = item.produk ? item.produk : {};
                            return {
                                produk_id: item.produk_id || null,
                                nama: produkObj.nama_produk || 'Alat Kesehatan',
                                qty: parseInt(item.jumlah) || 1,
                                harga: parseFloat(produkObj.harga_acuan) || parseFloat(item.harga) || 0
                            };
                        });
                    }
                    this.isEditing = false;
                },

                resetForm() {
                    this.nama_pelanggan = '';
                    this.whatsapp_pelanggan = '';
                    this.status_pembayaran = 'pending'; // 🌟 Reset status
                    this.items = [];
                    this.isEditing = false;
                },

                get subtotal() {
                    return this.items.reduce((sum, item) => sum + (item.qty * (item.harga || 0)), 0);
                },
                get ppn() {
                    return this.subtotal * 0.11;
                },
                get total() {
                    return this.subtotal + this.ppn;
                },
                formatRupiah(angka) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
                },

                kirimInvoice() {
                    if (this.items.length === 0) {
                        Swal.fire({ icon: 'warning', title: 'File Kosong', text: 'Minimal harus ada 1 item alat kesehatan.' });
                        return;
                    }

                    this.isSubmitting = true;

                    const itemsFormatLaravel = this.items.map(item => ({
                        produk_id: item.produk_id || null,
                        nama: item.nama,
                        jumlah: parseInt(item.qty) || 1,
                        harga_satuan: parseFloat(item.harga) || 0
                    }));

                    fetch('{{ route("admin.invoice.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                penawaran_id: this.penawaran_id,
                                nama_pelanggan: this.nama_pelanggan,
                                whatsapp_pelanggan: this.whatsapp_pelanggan,
                                status_pembayaran: this.status_pembayaran, // 🌟 Kirim status ke server
                                items: itemsFormatLaravel
                            })
                        })
                        .then(async res => {
                            const data = await res.json();
                            if (!res.ok) throw new Error(data.message || 'Terjadi kesalahan pada validasi data server.');
                            return data;
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 2000, showConfirmButton: false });
                                if (data.pdf_url) window.open(data.pdf_url, '_blank');
                                window.location.href = '{{ route("admin.invoice.index") }}';
                            } else {
                                Swal.fire({ icon: 'error', title: 'Gagal Menyimpan', text: data.message });
                                this.isSubmitting = false;
                            }
                        })
                        .catch(err => {
                            console.error('Penyebab Error:', err);
                            Swal.fire({ icon: 'error', title: 'Terjadi Masalah', text: err.message || 'Gagal terhubung ke server atau terjadi gangguan jaringan.' });
                            this.isSubmitting = false;
                        });
                }
            }));
        });
    </script>
@endpush