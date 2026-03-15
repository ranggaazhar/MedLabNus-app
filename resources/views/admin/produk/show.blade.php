@extends('admin.layouts.app')

@section('title', 'Detail Produk')

@section('content')

    {{-- Breadcrumb & Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <p class="text-sm text-gray-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-red-700 transition">Dashboard</a> /
                <a href="{{ route('produk.index') }}" class="hover:text-red-700 transition">Produk</a> / Detail
            </p>
            <h1 class="text-3xl font-extrabold text-gray-800 mt-1">Detail Produk</h1>
        </div>

        <div class="flex gap-3 mt-4 md:mt-0">
            <a href="{{ route('produk.index') }}"
                class="bg-white hover:bg-red-600 text-gray-700 hover:text-white border border-gray-200 hover:border-red-600 rounded-lg px-6 py-3 text-base font-medium shadow-sm transition-all duration-300 flex items-center gap-2 group">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Kembali
            </a>
        </div>
    </div>

    {{-- PARENT CARD BESAR --}}
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

        {{-- Header Di Dalam Parent Card --}}
        <div class="bg-gray-50/50 border-b border-gray-100 p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full uppercase tracking-wider">
                        {{ $produk->kategori }}
                    </span>
                    <h2 class="text-3xl font-bold text-gray-900 mt-2">{{ $produk->nama_produk }}</h2>
                    <p class="text-gray-500 flex items-center mt-1">
                        <i class="fas fa-industry mr-2 text-red-400"></i>
                        {{ $produk->pabrikan->nama_pabrikan ?? 'Pabrikan tidak terdaftar' }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase font-semibold">Internal ID</p>
                    <p class="font-mono text-lg font-bold text-gray-800">
                        #PROD-{{ str_pad($produk->produk_id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>

        {{-- Grid Konten Di Dalam Parent Card --}}
        <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- CHILD CARD: Visual & Identitas (Left) --}}
                <div class="lg:col-span-4 space-y-6">
                    {{-- Card Kecil: Image --}}
                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200">
                        @if ($produk->gambar_utama)
                            <img src="{{ asset($produk->gambar_utama) }}"
                                class="w-full h-64 object-cover rounded-xl shadow-inner">
                        @else
                            <div
                                class="w-full h-64 bg-gray-200 rounded-xl flex items-center justify-center border-2 border-dashed border-gray-300">
                                <i class="fas fa-image text-5xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Card Kecil: Stats/Quick Info (Harga, Satuan, Stok) --}}
                    <div class="grid grid-cols-1 gap-4">
                        {{-- Harga Acuan --}}
                        <div
                            class="bg-red-50 p-4 rounded-2xl border border-red-100 flex justify-between items-center shadow-sm">
                            <div>
                                <p class="text-[10px] text-red-500 font-bold uppercase tracking-tight">Harga Acuan</p>
                                <p class="text-xl font-black text-red-700">Rp
                                    {{ number_format($produk->harga_acuan, 0, ',', '.') }}</p>
                            </div>
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm">
                                <i class="fas fa-tag text-red-600"></i>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- Satuan --}}
                            <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100">
                                <p class="text-[10px] text-blue-500 font-bold uppercase tracking-tight">Satuan</p>
                                <p class="text-sm font-bold text-blue-900 capitalize">{{ $produk->satuan ?? 'Pcs' }}</p>
                            </div>
                            {{-- Stok Minimal --}}
                            <div class="bg-orange-50 p-4 rounded-2xl border border-orange-100">
                                <p class="text-[10px] text-orange-500 font-bold uppercase tracking-tight">Stok Minimal</p>
                                <p class="text-sm font-bold text-orange-900">{{ $produk->stok_minimal ?? '0' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- Update Terakhir --}}
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-tight">Update Terakhir</p>
                                <p class="text-sm font-bold text-gray-800">{{ $produk->updated_at->format('d/m/Y') }}</p>
                            </div>
                            {{-- Status --}}
                            <div class="bg-green-50 p-4 rounded-2xl border border-green-100">
                                <p class="text-[10px] text-green-500 font-bold uppercase tracking-tight">Status</p>
                                <p class="text-sm font-bold text-green-900 uppercase">Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CHILD CARD: Deskripsi & Spesifikasi (Middle) --}}
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                        <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Informasi Produk</h4>
                        <p class="text-gray-700 leading-relaxed italic">
                            "{{ $produk->deskripsi_singkat ?? 'Belum ada deskripsi untuk produk ini.' }}"
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                        <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Spesifikasi Utama</h4>
                        <div class="space-y-3">
                            @forelse($produk->spesifikasis as $spec)
                                <div
                                    class="flex justify-between items-center p-3 hover:bg-red-50 rounded-xl transition-colors border-b border-gray-50 last:border-0">
                                    <span class="text-sm text-gray-600 font-medium">{{ $spec->nama_spesifikasi }}</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $spec->nilai }}</span>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-400 italic">
                                    <i class="fas fa-microchip mb-2 block text-2xl"></i>
                                    <p class="text-sm">Belum ada spesifikasi teknis.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- CHILD CARD: Audit Trail (Right) --}}
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl p-6 h-full border border-gray-100 shadow-sm flex flex-col">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="w-2 h-6 bg-red-600 rounded-full"></div>
                            <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Log Aktivitas</h4>
                        </div>

                        {{-- Scrollable Container jika log sangat banyak --}}
                        <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar" style="max-height: 450px;">
                            <div class="space-y-8 relative">
                                {{-- Line (Garis Timeline) --}}
                                <div class="absolute left-2.5 top-2 bottom-2 w-0.5 bg-gray-100"></div>

                                {{-- Loop Data Log dari Spatie --}}
                                @forelse($produk->activities->take(10) as $index => $log)
                                    <div class="relative pl-10">
                                        {{-- Dot: Merah untuk log terbaru, Abu-abu untuk log lama --}}
                                        <div
                                            class="absolute left-0 top-1 w-5 h-5 {{ $index == 0 ? 'bg-red-50' : 'bg-gray-100' }} rounded-full flex items-center justify-center">
                                            <div
                                                class="w-2 h-2 {{ $index == 0 ? 'bg-red-600' : 'bg-gray-400' }} rounded-full">
                                            </div>
                                        </div>

                                        <div
                                            class="{{ $index == 0 ? 'bg-gray-50 border-gray-100' : 'border-transparent' }} p-3 rounded-xl border transition-colors hover:border-red-100">
                                            {{-- Deskripsi Event (Created/Updated/Deleted) --}}
                                            <p class="text-xs font-bold text-gray-800 capitalize">
                                                {{ $log->description }}
                                            </p>

                                            {{-- Waktu --}}
                                            <p class="text-[10px] text-gray-500 mt-1">
                                                <i class="far fa-clock mr-1"></i> {{ $log->created_at->diffForHumans() }}
                                            </p>

                                            {{-- Info User --}}
                                            <div class="mt-2 flex items-center gap-1">
                                                <span
                                                    class="w-4 h-4 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-[8px]">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                                <span class="text-[10px] font-medium text-red-700">
                                                    {{ $log->causer->name ?? 'System' }}
                                                </span>
                                            </div>

                                            {{-- Detail Perubahan (Hanya muncul jika Update) --}}
                                            @if ($log->event == 'updated' && isset($log->changes['old']))
                                                <div class="mt-3 pt-2 border-t border-gray-200">
                                                    <details class="group">
                                                        <summary
                                                            class="text-[9px] font-bold text-gray-400 cursor-pointer list-none flex items-center gap-1">
                                                            <i
                                                                class="fas fa-history transition-transform group-open:rotate-180"></i>
                                                            DETAIL PERUBAHAN
                                                        </summary>
                                                        <div class="mt-2 space-y-1">
                                                            @foreach ($log->changes['attributes'] as $key => $value)
                                                                @php $oldValue = $log->changes['old'][$key] ?? '-'; @endphp
                                                                @if ($oldValue != $value)
                                                                    <div
                                                                        class="text-[9px] bg-white p-1.5 rounded border border-gray-100">
                                                                        <span
                                                                            class="text-gray-500 block uppercase font-bold">{{ str_replace('_', ' ', $key) }}</span>
                                                                        <div class="flex items-center gap-1 mt-0.5">
                                                                            <span
                                                                                class="text-red-500 line-through">{{ Str::limit($oldValue, 20) }}</span>
                                                                            <i
                                                                                class="fas fa-long-arrow-alt-right text-gray-300"></i>
                                                                            <span
                                                                                class="text-green-600 font-bold">{{ Str::limit($value, 20) }}</span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </details>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10">
                                        <i class="fas fa-history text-gray-200 text-3xl mb-2"></i>
                                        <p class="text-xs text-gray-400 italic">Belum ada riwayat aktivitas.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- Footer Card --}}
                        <div class="mt-8 pt-6 border-t border-gray-50">
                            <a href="{{ route('produk.edit', $produk->produk_id) }}"
                                class="group flex items-center justify-between w-full bg-red-50 hover:bg-red-600 p-4 rounded-xl transition-all duration-300">
                                <span class="text-xs font-bold text-red-700 group-hover:text-white transition-colors">
                                    Edit Detail Data
                                </span>
                                <i
                                    class="fas fa-chevron-right text-red-400 group-hover:text-white group-hover:translate-x-1 transition-all"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
