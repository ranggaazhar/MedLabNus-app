<x-guest-layout>
    {{-- Header --}}
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Buat Akun Baru</h2>
        <p class="text-gray-500 mt-2 text-sm">Bergabunglah dengan kami dan mulai perjalanan kesehatan Anda hari ini</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Name --}}
        <div class="space-y-1 text-left">
            <label for="name" class="text-sm font-bold text-gray-900">Nama Lengkap</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-900 focus:border-[#B1252E] focus:ring-1 focus:ring-[#B1252E] placeholder-gray-400 transition-all text-sm shadow-sm hover:border-gray-300"
                placeholder="Masukkan nama lengkap Anda"
            >
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email Address --}}
        <div class="space-y-1 text-left">
            <label for="email" class="text-sm font-bold text-gray-900">Alamat Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-900 focus:border-[#B1252E] focus:ring-1 focus:ring-[#B1252E] placeholder-gray-400 transition-all text-sm shadow-sm hover:border-gray-300"
                placeholder="Masukkan email Anda"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="space-y-1 text-left">
            <label for="password" class="text-sm font-bold text-gray-900">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-900 focus:border-[#B1252E] focus:ring-1 focus:ring-[#B1252E] placeholder-gray-400 transition-all text-sm shadow-sm hover:border-gray-300"
                placeholder="Buat kata sandi yang kuat"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div class="space-y-1 text-left">
            <label for="password_confirmation" class="text-sm font-bold text-gray-900">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-900 focus:border-[#B1252E] focus:ring-1 focus:ring-[#B1252E] placeholder-gray-400 transition-all text-sm shadow-sm hover:border-gray-300"
                placeholder="Ulangi kata sandi Anda"
            >
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Button Register --}}
        <div class="pt-2">
            <button type="submit" class="w-full bg-[#B1252E] hover:bg-red-800 text-white font-bold py-3.5 rounded-xl transition-all transform active:scale-95 shadow-lg shadow-red-900/20 text-sm tracking-wide">
                Daftar Sekarang
            </button>
        </div>
    </form>
    
    {{-- Footer Link --}}
    <div class="mt-8 text-center text-sm text-gray-600">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="font-bold text-[#B1252E] hover:underline transition-all">
            Masuk
        </a>
    </div>
</x-guest-layout>