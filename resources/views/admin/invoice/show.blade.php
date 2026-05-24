@extends('admin.layouts.app')

@section('title', 'Detail Invoice ' . $invoice->kode_invoice)

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- TOMBOL BACK --}}
        <div class="mb-6">
            <a href="{{ route('admin.invoice.index') }}"
                class="text-gray-400 hover:text-gray-800 transition text-sm font-bold flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Invoice
            </a>
        </div>

        {{-- KARTU DETAIL --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- HEADER KARTU --}}
            <div
                class="p-8 border-b border-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-black text-gray-800">{{ $invoice->kode_invoice }}</h1>
                    <p class="text-gray-400 text-xs mt-1 uppercase tracking-widest font-bold">Dibuat pada
                        {{ $invoice->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    @if ($invoice->status_pembayaran == 'lunas')
                        <span
                            class="px-4 py-1.5 rounded-lg text-xs font-black uppercase bg-emerald-50 text-emerald-700 border border-emerald-100">Lunas</span>
                    @elseif($invoice->status_pembayaran == 'batal')
                        <span
                            class="px-4 py-1.5 rounded-lg text-xs font-black uppercase bg-rose-50 text-rose-700 border border-rose-100">Batal</span>
                    @else
                        <span
                            class="px-4 py-1.5 rounded-lg text-xs font-black uppercase bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                    @endif

                    <a href="{{ route('admin.invoice.download-pdf', $invoice->id) }}"
                        class="px-4 py-2 bg-red-700 text-white rounded-lg text-xs font-bold hover:bg-red-800 transition">
                        <i class="fas fa-file-pdf mr-2"></i> Download PDF
                    </a>
                </div>
            </div>

            {{-- INFORMASI PELANGGAN --}}
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 bg-gray-50/50">
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase">Instansi Pelanggan</label>
                    <p class="text-sm font-bold text-gray-800 mt-1">{{ $invoice->nama_pelanggan }}</p>
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase">Kontak WhatsApp</label>
                    <p class="text-sm font-bold text-gray-800 mt-1 flex items-center gap-2">
                        <i class="fab fa-whatsapp text-emerald-500"></i> {{ $invoice->whatsapp_pelanggan }}
                    </p>
                </div>
            </div>

            {{-- TABEL ITEM --}}
            <div class="p-8">
                <h2 class="text-xs font-black text-gray-400 uppercase mb-4">Daftar Item Tagihan</h2>
                <div class="border border-gray-100 rounded-xl overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-6 text-[10px] font-black text-gray-500 uppercase">Produk</th>
                                <th class="py-3 px-6 text-[10px] font-black text-gray-500 uppercase text-center">Qty</th>
                                <th class="py-3 px-6 text-[10px] font-black text-gray-500 uppercase text-right">Harga Satuan
                                </th>
                                <th class="py-3 px-6 text-[10px] font-black text-gray-500 uppercase text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($invoice->invoiceItems as $item)
                                <tr>
                                    {{-- Mengambil nama dari kolom nama, jika null ambil dari relasi produk --}}
                                    <td class="py-4 px-6 text-sm font-bold text-gray-800">
                                        {{ $item->nama ?? ($item->produk->nama_produk ?? 'Produk Tidak Diketahui') }}
                                    </td>

                                    <td class="py-4 px-6 text-sm text-center text-gray-600">
                                        {{ $item->jumlah }}
                                    </td>

                                    <td class="py-4 px-6 text-sm text-right text-gray-600">
                                        Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                    </td>

                                    <td class="py-4 px-6 text-sm text-right font-bold text-gray-800">
                                        Rp {{ number_format($item->total_item_harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- RINGKASAN HARGA --}}
                <div class="flex justify-end mt-8">
                    <div class="w-full md:w-64 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Subtotal</span>
                            <span class="font-bold text-gray-800">Rp
                                {{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">PPN (11%)</span>
                            <span class="font-bold text-gray-800">Rp
                                {{ number_format($invoice->pajak_ppn, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3 flex justify-between">
                            <span class="text-xs font-black uppercase text-gray-800">Total Tagihan</span>
                            <span class="font-black text-lg text-red-700">Rp
                                {{ number_format($invoice->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
