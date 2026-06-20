@extends('admin.layouts.app')

@section('title', 'Detail Produk')

@section('content')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.4s ease-out forwards;
    }
    /* Custom scrollbar for scrollable logs */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 2px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>

<div class="animate-fade-in-up">
    {{-- Breadcrumb & Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-red-600 transition-colors duration-200">Dashboard</a>
                <span class="mx-2 text-gray-300">/</span>
                <a href="{{ route('produk.index') }}" class="hover:text-red-600 transition-colors duration-200">Produk</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-gray-600">Detail</span>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-800 mt-1">Detail Produk</h1>
        </div>

        <div>
            <a href="{{ route('produk.index') }}"
                class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 hover:border-gray-300 rounded-xl px-5 py-2.5 text-sm font-bold shadow-sm transition-all duration-300 hover:-translate-x-1 active:scale-95 group">
                <i class="fas fa-arrow-left text-xs transition-transform group-hover:-translate-x-0.5"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- PARENT CARD BESAR --}}
    <div class="bg-white rounded-3xl shadow-xl shadow-gray-100/50 border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-gray-200/50">

        {{-- Header Di Dalam Parent Card --}}
        <div class="bg-gradient-to-r from-gray-50/80 via-white to-gray-50/30 border-b border-gray-100 p-8 sm:p-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="space-y-2">
                    <span class="inline-block px-3 py-1 bg-red-50 text-red-600 border border-red-100 text-[10px] font-black uppercase tracking-widest rounded-full">
                        {{ $produk->kategori }}
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 leading-tight tracking-tight">{{ $produk->nama_produk }}</h2>
                    <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
                        <span class="p-1.5 bg-red-50 rounded-lg text-red-500">
                            <i class="fas fa-industry text-xs"></i>
                        </span>
                        <span>{{ $produk->pabrikan->nama_pabrikan ?? 'Pabrikan tidak terdaftar' }}</span>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm text-left md:text-right min-w-[150px]">
                    <p class="text-[9px] text-gray-400 uppercase font-black tracking-widest mb-0.5">Internal ID</p>
                    <p class="font-mono text-lg font-black text-red-600">
                        #PROD-{{ str_pad($produk->produk_id, 4, '0', STR_PAD_LEFT) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Grid Konten Di Dalam Parent Card --}}
        <div class="p-8 sm:p-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- CHILD CARD: Visual & Identitas (Left Column - Col Span 4) --}}
                <div class="lg:col-span-4 space-y-6">
                    {{-- Image Container --}}
                    <div class="bg-gray-50/50 rounded-2xl p-4 border border-gray-100 flex items-center justify-center overflow-hidden group/image relative h-72">
                        @if ($produk->gambar_utama)
                            <img src="{{ asset($produk->gambar_utama) }}"
                                class="w-full h-full object-contain rounded-xl transition-all duration-500 group-hover/image:scale-105 filter drop-shadow-md">
                        @else
                            <div class="w-full h-full bg-gray-100 rounded-xl flex flex-col items-center justify-center border border-dashed border-gray-200 text-gray-400 gap-2">
                                <i class="fas fa-image text-4xl"></i>
                                <span class="text-xs font-semibold">Tidak Ada Gambar</span>
                            </div>
                        @endif
                    </div>

                    {{-- Stats & Info Cards --}}
                    <div class="space-y-4">
                        {{-- Harga Acuan --}}
                        <div class="relative overflow-hidden bg-gradient-to-br from-red-600 to-red-700 text-white p-5 rounded-2xl shadow-md border border-red-500/20 group/price">
                            {{-- Decorative Background Circle --}}
                            <div class="absolute -right-8 -bottom-8 w-24 h-24 bg-white/10 rounded-full blur-xl transition-all duration-500 group-hover/price:scale-110"></div>
                            
                            <div class="flex justify-between items-center relative z-10">
                                <div>
                                    <p class="text-[9px] text-red-100 font-black uppercase tracking-widest mb-1">Harga</p>
                                    <p class="text-2xl font-black tracking-tight">
                                        Rp {{ number_format($produk->harga_acuan, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center text-white border border-white/20">
                                    <i class="fas fa-tags text-lg"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Satuan & Stok Minimal Grid --}}
                        <div class="grid grid-cols-2 gap-4">
                            {{-- Satuan --}}
                            <div class="bg-white border border-gray-100 p-4 rounded-2xl shadow-sm hover:border-gray-200 transition-all duration-300">
                                <p class="text-[9px] text-gray-400 font-black uppercase tracking-widest mb-1.5 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Satuan
                                </p>
                                <p class="text-sm font-black text-gray-800 capitalize">
                                    {{ $produk->satuan ?? 'Pcs' }}
                                </p>
                            </div>

                            {{-- Stok Minimal --}}
                            <div class="bg-white border border-gray-100 p-4 rounded-2xl shadow-sm hover:border-gray-200 transition-all duration-300">
                                <p class="text-[9px] text-gray-400 font-black uppercase tracking-widest mb-1.5 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Min. Stok
                                </p>
                                <p class="text-sm font-black text-gray-800">
                                    {{ $produk->stok_minimal ?? '0' }}
                                </p>
                            </div>
                        </div>

                        {{-- Update Terakhir & Status Grid --}}
                        <div class="grid grid-cols-2 gap-4">
                            {{-- Update Terakhir --}}
                            <div class="bg-white border border-gray-100 p-4 rounded-2xl shadow-sm hover:border-gray-200 transition-all duration-300">
                                <p class="text-[9px] text-gray-400 font-black uppercase tracking-widest mb-1.5 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Terakhir Diubah
                                </p>
                                <p class="text-sm font-black text-gray-800">
                                    {{ $produk->updated_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CHILD CARD: Deskripsi & Spesifikasi (Middle Column - Col Span 5) --}}
                <div class="lg:col-span-5 space-y-6">
                    {{-- Deskripsi Card --}}
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:border-gray-200/80 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute right-4 top-4 text-gray-50/80 text-7xl font-serif pointer-events-none select-none">“</div>
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Deskripsi Produk</h4>
                        <p class="text-sm text-gray-600 leading-relaxed italic relative z-10">
                            "{{ $produk->deskripsi_singkat ?? 'Belum ada deskripsi untuk produk ini.' }}"
                        </p>
                    </div>

                    {{-- Spesifikasi Card --}}
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:border-gray-200/80 transition-all duration-300">
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Spesifikasi Utama</h4>
                        <div class="space-y-2.5">
                            @forelse($produk->spesifikasis as $spec)
                                <div class="flex justify-between items-center p-3 bg-gray-50/30 hover:bg-red-50/30 border border-gray-100 hover:border-red-100/50 rounded-xl transition-all duration-200">
                                    <span class="text-xs text-gray-500 font-semibold">{{ $spec->nama_spesifikasi }}</span>
                                    <span class="text-xs font-black text-gray-800">{{ $spec->nilai }}</span>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-400 italic">
                                    <span class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-3 text-gray-300 border border-gray-100">
                                        <i class="fas fa-microchip text-lg"></i>
                                    </span>
                                    <p class="text-xs">Belum ada spesifikasi teknis.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- CHILD CARD: Audit Trail (Right Column - Col Span 3) --}}
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl p-6 h-full border border-gray-100 shadow-sm flex flex-col justify-between hover:border-gray-200/80 transition-all duration-300">
                        <div>
                            <div class="flex items-center gap-2 mb-6">
                                <div class="w-1.5 h-5 bg-red-600 rounded-full"></div>
                                <h4 class="text-xs font-black text-gray-800 uppercase tracking-widest">Log Aktivitas</h4>
                            </div>

                            {{-- Scrollable Container --}}
                            <div class="overflow-y-auto pr-1 custom-scrollbar" style="max-height: 400px;">
                                <div class="space-y-6 relative">
                                    {{-- Line --}}
                                    <div class="absolute left-2.5 top-2.5 bottom-2.5 w-px bg-gray-100"></div>

                                    @forelse($produk->activities->take(10) as $index => $log)
                                        <div class="relative pl-8">
                                            {{-- Dot --}}
                                            <div class="absolute left-1.5 top-1 w-2.5 h-2.5 rounded-full flex items-center justify-center -translate-x-1/2">
                                                <span class="relative flex h-2.5 w-2.5">
                                                    @if($index == 0)
                                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-600"></span>
                                                    @else
                                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-gray-300"></span>
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="bg-gray-50/50 hover:bg-gray-50 p-3 rounded-xl border border-gray-100 transition-all duration-200 hover:border-red-100/40">
                                                {{-- Event description --}}
                                                <p class="text-xs font-black text-gray-700 capitalize">
                                                    {{ $log->description }}
                                                </p>

                                                {{-- Time --}}
                                                <p class="text-[9px] text-gray-400 mt-1 flex items-center gap-1 font-medium">
                                                    <i class="far fa-clock"></i> {{ $log->created_at->diffForHumans() }}
                                                </p>

                                                {{-- User --}}
                                                <div class="mt-2 flex items-center gap-1.5">
                                                    <span class="w-4 h-4 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-[8px] border border-red-100/30">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                    <span class="text-[9px] font-bold text-red-700">
                                                        {{ $log->causer->name ?? 'System' }}
                                                    </span>
                                                </div>

                                                {{-- Detail changes (Updates) --}}
                                                @if ($log->event == 'updated' && isset($log->changes['old']))
                                                    <div class="mt-2.5 pt-2.5 border-t border-gray-100">
                                                        <details class="group">
                                                            <summary class="text-[8px] font-black text-gray-400 hover:text-red-600 cursor-pointer list-none flex items-center gap-1 select-none">
                                                                <i class="fas fa-history transition-transform group-open:rotate-180"></i>
                                                                <span>DETAIL PERUBAHAN</span>
                                                            </summary>
                                                            <div class="mt-2 space-y-1.5">
                                                                @foreach ($log->changes['attributes'] as $key => $value)
                                                                    @php $oldValue = $log->changes['old'][$key] ?? '-'; @endphp
                                                                    @if ($oldValue != $value)
                                                                        <div class="text-[9px] bg-white p-2 rounded-lg border border-gray-100">
                                                                            <span class="text-[8px] text-gray-400 block uppercase font-black tracking-wider mb-0.5">
                                                                                {{ str_replace('_', ' ', $key) }}
                                                                            </span>
                                                                            <div class="flex flex-wrap items-center gap-1.5 mt-1 font-medium">
                                                                                <span class="text-red-500 line-through bg-red-50 px-1 py-0.5 rounded text-[8px]">
                                                                                    {{ Str::limit($oldValue, 20) }}
                                                                                </span>
                                                                                <i class="fas fa-long-arrow-alt-right text-gray-300"></i>
                                                                                <span class="text-emerald-600 font-bold bg-emerald-50 px-1 py-0.5 rounded text-[8px]">
                                                                                    {{ Str::limit($value, 20) }}
                                                                                </span>
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
                                        <div class="text-center py-8">
                                            <i class="fas fa-history text-gray-200 text-2xl mb-2"></i>
                                            <p class="text-xs text-gray-400 italic">Belum ada riwayat aktivitas.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- Footer Card - Action Button --}}
                        <div class="mt-6 pt-5 border-t border-gray-100">
                            <a href="{{ route('produk.edit', $produk->produk_id) }}"
                                class="relative overflow-hidden group flex items-center justify-between w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 p-3.5 rounded-xl shadow-sm hover:shadow transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0">
                                <span class="text-xs font-bold text-white tracking-wider">
                                    Edit Detail Data
                                </span>
                                <span class="w-7 h-7 bg-white/10 rounded-lg flex items-center justify-center text-white transition-transform group-hover:translate-x-1">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
