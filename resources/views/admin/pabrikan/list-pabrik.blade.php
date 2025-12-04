@extends('admin.layouts.app')

@section('title', 'Pabrik')

@section('content')

        {{-- Session Messages --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                <p class="font-bold">Sukses!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                <p class="font-bold">Gagal!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        {{-- Search Form dan Tombol Aksi --}}
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-3">
            <form action="{{ route('pabrikan.index') }}" method="GET" class="flex-1 w-full flex items-center space-x-3">
                {{-- Search Input Container --}}
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 z-10"></i>
                    <input type="text" name="search" placeholder="Cari pabrikan..." value="{{ request('search') }}"
                        class="w-full border border-gray-200 pl-10 pr-4 py-2.5 rounded-xl bg-white focus:ring-red-500 focus:border-red-500 shadow-sm text-gray-700 placeholder-gray-400 transition duration-150">
                </div>
            </form>
            
            {{-- Tombol Tambah Pabrikan --}}
            <a href="{{ route('pabrikan.create') }}"
                class="bg-red-700 hover:bg-red-800 text-white font-semibold py-2.5 px-4 rounded-lg shadow-md transition duration-300 flex items-center gap-1 w-full sm:w-auto justify-center">
                <i class="fas fa-plus"></i> Tambah Pabrikan
            </a>
        </div>

        {{-- Container untuk Card Pabrikan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($pabrikans as $pabrikan)
                {{-- Memanggil komponen pabrikan-card --}}
                <x-pabrikan-card :pabrikan="$pabrikan" />
            @empty
                <div class="col-span-full bg-white shadow-xl rounded-xl p-6 text-center text-gray-500">
                    Tidak ada data pabrikan yang ditemukan.
                </div>
            @endforelse
        </div>

        {{-- Pagination Links --}}
        <div class="mt-8">
            {{ $pabrikans->links() }}
        </div>
    </div>

    {{-- Modal Edit Pabrikan (Tetap di sini, karena ini adalah view utama yang akan memicu modal) --}}
    <div id="editModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-70 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300 ease-in-out">
        <div
            class="relative top-20 mx-auto p-6 bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 ease-out">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-edit mr-2 text-red-700"></i> Edit Pabrikan
                </h3>
                <div class="mt-2 text-left">
                    <form id="editForm" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Input Nama Pabrikan --}}
                        <div class="mb-4">
                            <label for="modal_nama_pabrikan" class="block text-sm font-semibold text-gray-700 mb-1">Nama
                                Pabrikan</label>
                            <input type="text" name="nama_pabrikan" id="modal_nama_pabrikan" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">
                        </div>

                        {{-- Input Asal Negara --}}
                        <div class="mb-4">
                            <label for="modal_asal_negara" class="block text-sm font-semibold text-gray-700 mb-1">Asal
                                Negara</label>
                            <input type="text" name="asal_negara" id="modal_asal_negara" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-red-500 focus:ring-red-500 transition duration-150 shadow-sm">
                        </div>

                        {{-- Input Logo (jika perlu diubah) --}}
                        <div class="mb-6">
                            <label for="modal_logo_pabrikan" class="block text-sm font-semibold text-gray-700 mb-1">Logo
                                Pabrikan (Kosongkan jika tidak diubah)</label>
                            <div id="current_logo_container" class="my-3 flex items-center space-x-3">
                                <p class="text-sm text-gray-600">Logo Saat Ini: </p>
                                <img id="modal_current_logo" src="" alt="Logo Pabrikan Saat Ini"
                                    class="w-16 h-16 object-contain border rounded-lg p-1 bg-white">
                            </div>
                            <input type="file" name="logo_pabrikan" id="modal_logo_pabrikan"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition duration-150">
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" id="closeModalButton"
                                class="close-modal bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg px-4 py-2.5 transition duration-150 shadow-sm focus:outline-none">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2.5 bg-red-700 text-white font-medium rounded-lg shadow-md hover:bg-red-800 transition duration-300 focus:outline-none flex items-center gap-1">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection