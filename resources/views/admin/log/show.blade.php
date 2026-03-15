@extends('admin.layouts.app')

@section('title', 'Detail Audit Log')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Breadcrumb & Title --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2 font-sans">
            <a href="{{ route('log.index') }}" class="hover:text-red-600 transition-colors">Audit Trail</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-gray-800">Detail Log #{{ $log->id }}</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Rincian Aktivitas Sistem</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- SIDEBAR INFO: Siapa, Kapan, Dimana --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Informasi Pelaku</h3>
                
                <div class="flex items-center gap-4 mb-6 p-3 bg-gray-50 rounded-xl">
                    <div class="w-12 h-12 rounded-full bg-red-600 flex items-center justify-center text-white font-bold text-lg">
                        {{ substr($log->causer->name ?? 'S', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">{{ $log->causer->name ?? 'System/Automated' }}</p>
                        <p class="text-xs text-gray-500 italic">User ID: {{ $log->causer_id ?? '-' }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-xs text-gray-500">Tipe Aksi</span>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                            {{ $log->event == 'created' ? 'bg-green-100 text-green-700' : ($log->event == 'updated' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">
                            {{ $log->description }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-xs text-gray-500">Waktu</span>
                        <span class="text-xs font-semibold text-gray-800">{{ $log->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-xs text-gray-500">Model/Modul</span>
                        <span class="text-xs font-mono text-red-600">{{ str_replace('App\Models\\', '', $log->subject_type) }}</span>
                    </div>
                </div>
            </div>

            {{-- Metadata Perangkat (Hasil fungsi tap) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Metadata Perangkat</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-network-wired text-gray-300 mt-1"></i>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase">Alamat IP</p>
                            <p class="text-xs font-bold text-gray-700">{{ $log->properties['ip'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-desktop text-gray-300 mt-1"></i>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase">User Agent / Browser</p>
                            <p class="text-[10px] text-gray-600 leading-relaxed">{{ $log->properties['browser'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT: Perubahan Data --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden min-h-full">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-exchange-alt text-red-600"></i> 
                        Transformasi Data
                    </h3>
                </div>

                <div class="p-6">
                    @php 
                        $attributes = $log->properties['attributes'] ?? null;
                        $old = $log->properties['old'] ?? null;
                    @endphp

                    {{-- JIKA UPDATE --}}
                    @if($log->event == 'updated' && $old && $attributes)
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="text-[10px] text-gray-400 uppercase tracking-widest border-b border-gray-100">
                                        <th class="py-3 px-2 text-left">Nama Kolom</th>
                                        <th class="py-3 px-2 text-left">Data Lama (Sebelum)</th>
                                        <th class="py-3 px-2 text-left">Data Baru (Sesudah)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($attributes as $key => $newValue)
                                        @php $oldValue = $old[$key] ?? '-'; @endphp
                                        {{-- Hanya tampilkan jika datanya berbeda --}}
                                        @if($oldValue != $newValue)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-2 font-bold text-gray-600 text-xs uppercase">{{ str_replace('_', ' ', $key) }}</td>
                                            <td class="py-4 px-2">
                                                <span class="text-xs text-red-500 bg-red-50 px-2 py-1 rounded line-through decoration-red-300 italic">
                                                    {{ is_array($oldValue) ? json_encode($oldValue) : $oldValue }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-2">
                                                <span class="text-xs text-green-700 bg-green-50 px-2 py-1 rounded font-bold">
                                                    {{ is_array($newValue) ? json_encode($newValue) : $newValue }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    {{-- JIKA CREATE --}}
                    @elseif($log->event == 'created' && $attributes)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($attributes as $key => $value)
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">{{ str_replace('_', ' ', $key) }}</p>
                                    <p class="text-sm text-gray-800 font-semibold">{{ is_array($value) ? json_encode($value) : ($value ?? '-') }}</p>
                                </div>
                            @endforeach
                        </div>

                    {{-- JIKA DELETE --}}
                    @elseif($log->event == 'deleted' && $old)
                        <div class="bg-red-50 p-4 rounded-xl border border-red-100 mb-4 font-sans italic text-sm text-red-700">
                            Snapshot data terakhir sebelum dihapus dari database:
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($old as $key => $value)
                                <div class="p-3 bg-white rounded-lg border border-red-50 shadow-sm">
                                    <p class="text-[10px] text-gray-400 uppercase">{{ str_replace('_', ' ', $key) }}</p>
                                    <p class="text-sm text-gray-400 line-through">{{ is_array($value) ? json_encode($value) : ($value ?? '-') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-20">
                            <i class="fas fa-ghost text-gray-200 text-5xl mb-4"></i>
                            <p class="text-gray-400 italic">Tidak ada rincian data yang tersedia untuk log ini.</p>
                        </div>
                    @endif
                </div>
                
                {{-- Footer Button --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 mt-auto">
                    <a href="{{ route('log.index') }}" class="text-xs font-bold text-red-600 hover:text-red-700 flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Log
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection