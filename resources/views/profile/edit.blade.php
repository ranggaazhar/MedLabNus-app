<x-app-layout>
    {{-- Header Section --}}
    <x-slot name="header">
        <div class="flex items-center gap-3 pt-4 sm:pt-0"> {{-- Tambah padding top di mobile --}}
            <div class="p-2 bg-red-50 rounded-lg">
                <i class="fas fa-user-cog text-[#B1252E] text-xl"></i>
            </div>
            <h2 class="font-bold text-xl sm:text-2xl text-gray-800 leading-tight">
                {{ __('Pengaturan Profil') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 sm:py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- Grid Utama --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Sisi Kiri: Informasi User (Muncul pertama di Mobile) --}}
                <div class="lg:col-span-1 order-first lg:order-none">
                    <div class="lg:sticky lg:top-24 space-y-4">
                        <div class="hidden lg:block">
                            <h3 class="text-lg font-bold text-gray-900">Informasi Pribadi</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Perbarui informasi profil akun dan alamat email Anda untuk memastikan data tetap valid.
                            </p>
                        </div>
                        
                        {{-- Ringkasan Profil Card --}}
                        <div class="p-5 bg-white rounded-2xl border border-gray-100 shadow-sm flex lg:flex-col items-center lg:items-start gap-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=B1252E&color=fff&size=128" 
                                 class="w-16 h-16 lg:w-20 lg:h-20 rounded-2xl shadow-inner" alt="Avatar">
                            <div>
                                <p class="text-base lg:text-lg font-bold text-gray-800 leading-tight">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-gray-500 break-all">{{ auth()->user()->email }}</p>
                                <span class="inline-block mt-2 px-3 py-1 bg-green-50 text-green-600 text-[10px] font-bold uppercase rounded-full border border-green-100">Akun Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sisi Kanan: Kumpulan Form --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Card Update Info --}}
                    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden transition-all hover:shadow-md">
                        <div class="p-6 sm:p-8">
                            <div class="flex items-center gap-2 mb-6 lg:hidden text-gray-800">
                                <i class="fas fa-info-circle text-[#B1252E]"></i>
                                <h3 class="font-bold text-lg">Update Profil</h3>
                            </div>
                            <div class="max-w-full lg:max-w-xl">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>

                    {{-- Card Update Password --}}
                    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden transition-all hover:shadow-md">
                        <div class="p-6 sm:p-8">
                            <div class="max-w-full lg:max-w-xl">
                                <div class="flex items-center gap-2 mb-6 text-gray-800">
                                    <i class="fas fa-lock text-[#B1252E]"></i>
                                    <h3 class="font-bold text-lg">Keamanan Kata Sandi</h3>
                                </div>
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>

                    {{-- Card Delete Account (Danger Zone) --}}
                    <div class="bg-white shadow-sm border border-red-50 rounded-2xl overflow-hidden border-l-4 border-l-red-500">
                        <div class="p-6 sm:p-8">
                            <div class="max-w-full lg:max-w-xl">
                                <div class="flex items-center gap-2 mb-6 text-red-600">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <h3 class="font-bold text-lg">Hapus Akun</h3>
                                </div>
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>

                </div> {{-- End Sisi Kanan --}}
            </div> {{-- End Grid --}}
        </div>
    </div>
</x-app-layout>