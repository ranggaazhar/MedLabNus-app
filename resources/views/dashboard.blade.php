<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard Admin') }}
            </h2>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <span class="font-medium">{{ Auth::user()->name }}</span> | 
                <span>{{ now()->isoFormat('dddd, D MMMM YYYY') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Welcome Card --}}
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-blue-100">Sistem Manajemen Produk Medlab Nusantara</p>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                
                {{-- Total Produk --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg hover:shadow-xl transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Total Produk</p>
                                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                                    {{ \App\Models\Produk::count() }}
                                </p>
                                <p class="text-xs text-green-600 dark:text-green-400 mt-2">
                                    <span class="font-semibold">↑ 12%</span> dari bulan lalu
                                </p>
                            </div>
                            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                                <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Reagen --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg hover:shadow-xl transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Produk Reagen</p>
                                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                                    {{ \App\Models\Produk::where('kategori', 'reagen')->count() }}
                                </p>
                                <p class="text-xs text-blue-600 dark:text-blue-400 mt-2">
                                    <span class="font-semibold">{{ number_format((\App\Models\Produk::where('kategori', 'reagen')->count() / max(\App\Models\Produk::count(), 1)) * 100, 1) }}%</span> dari total
                                </p>
                            </div>
                            <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                                <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Alat --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg hover:shadow-xl transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Produk Alat</p>
                                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                                    {{ \App\Models\Produk::where('kategori', 'alat')->count() }}
                                </p>
                                <p class="text-xs text-purple-600 dark:text-purple-400 mt-2">
                                    <span class="font-semibold">{{ number_format((\App\Models\Produk::where('kategori', 'alat')->count() / max(\App\Models\Produk::count(), 1)) * 100, 1) }}%</span> dari total
                                </p>
                            </div>
                            <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                                <svg class="w-10 h-10 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Pabrikan --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg hover:shadow-xl transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Total Pabrikan</p>
                                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                                    {{ \App\Models\Pabrikan::count() }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                                    Manufaktur aktif
                                </p>
                            </div>
                            <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-full">
                                <svg class="w-10 h-10 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <a href="{{ route('produk.create') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg hover:shadow-xl transition duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="bg-blue-500 p-3 rounded-lg group-hover:bg-blue-600 transition">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">Tambah Produk</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Buat produk baru</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('pabrikan.create') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg hover:shadow-xl transition duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="bg-green-500 p-3 rounded-lg group-hover:bg-green-600 transition">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">Tambah Pabrikan</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Daftar manufaktur baru</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('produk.index') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg hover:shadow-xl transition duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="bg-purple-500 p-3 rounded-lg group-hover:bg-purple-600 transition">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">Lihat Semua Produk</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Kelola produk</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                {{-- Produk Terbaru --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Produk Terbaru</h3>
                            <a href="{{ route('produk.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Lihat Semua →</a>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse(\App\Models\Produk::with('pabrikan')->latest()->take(5)->get() as $produk)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                <div class="flex items-center space-x-3">
                                    @if($produk->gambar_utama)
                                        <img src="{{ asset('storage/' . $produk->gambar_utama) }}" alt="{{ $produk->nama_produk }}" class="w-12 h-12 rounded object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-gray-300 dark:bg-gray-600 rounded flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $produk->nama_produk }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $produk->model_produk }} • {{ $produk->pabrikan->nama_pabrikan ?? '-' }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $produk->kategori === 'reagen' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' }}">
                                    {{ ucfirst($produk->kategori) }}
                                </span>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada produk</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Pabrikan --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Daftar Pabrikan</h3>
                            <a href="{{ route('pabrikan.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Lihat Semua →</a>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse(\App\Models\Pabrikan::withCount('produks')->latest()->take(5)->get() as $pabrikan)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                <div class="flex items-center space-x-3">
                                    @if($pabrikan->logo_pabrikan)
                                        <img src="{{ asset('storage/' . $pabrikan->logo_pabrikan) }}" alt="{{ $pabrikan->nama_pabrikan }}" class="w-12 h-12 rounded object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-gray-300 dark:bg-gray-600 rounded flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $pabrikan->nama_pabrikan }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $pabrikan->asal_negara }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $pabrikan->produks_count }} Produk
                                </span>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada pabrikan</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kategori Chart --}}
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Distribusi Produk per Kategori</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php
                            $totalProduk = \App\Models\Produk::count();
                            $totalReagen = \App\Models\Produk::where('kategori', 'reagen')->count();
                            $totalAlat = \App\Models\Produk::where('kategori', 'alat')->count();
                            $percentReagen = $totalProduk > 0 ? ($totalReagen / $totalProduk) * 100 : 0;
                            $percentAlat = $totalProduk > 0 ? ($totalAlat / $totalProduk) * 100 : 0;
                        @endphp
                        
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Reagen</span>
                                <span class="text-sm font-semibold text-green-600 dark:text-green-400">{{ $totalReagen }} ({{ number_format($percentReagen, 1) }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                                <div class="bg-green-500 h-4 rounded-full transition-all duration-500" style="width: {{ $percentReagen }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Alat</span>
                                <span class="text-sm font-semibold text-purple-600 dark:text-purple-400">{{ $totalAlat }} ({{ number_format($percentAlat, 1) }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                                <div class="bg-purple-500 h-4 rounded-full transition-all duration-500" style="width: {{ $percentAlat }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>