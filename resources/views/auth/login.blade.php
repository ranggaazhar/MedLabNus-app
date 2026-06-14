<x-guest-layout>
    {{-- Header --}}
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Selamat Datang Kembali!</h2>
        <p class="text-gray-500 mt-2 text-sm">Masukkan email dan password anda</p>
    </div>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email Address --}}
        <div class="space-y-1 text-left">
            <label for="email" class="text-sm font-bold text-gray-900">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-900 focus:border-[#B1252E] focus:ring-1 focus:ring-[#B1252E] placeholder-gray-400 transition-all text-sm shadow-sm hover:border-gray-300"
                placeholder="Masukkan email Anda"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="space-y-1 text-left">
            <label for="password" class="text-sm font-bold text-gray-900">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-900 focus:border-[#B1252E] focus:ring-1 focus:ring-[#B1252E] placeholder-gray-400 transition-all text-sm shadow-sm hover:border-gray-300"
                placeholder="Masukkan password Anda"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember Me & Terms --}}
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" 
                    class="rounded border-gray-300 text-[#B1252E] shadow-sm focus:ring-[#B1252E] cursor-pointer transition-all" 
                    name="remember">
                <span class="ml-2 text-xs font-medium text-gray-600 group-hover:text-gray-900 transition">Ingat saya</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-gray-900 hover:text-[#B1252E] transition-colors" href="{{ route('password.request') }}">
                    Lupa Kata Sandi?
                </a>
            @endif
        </div>

        {{-- Button Sign In --}}
        <div class="pt-2">
            <button type="submit" class="w-full bg-[#B1252E] hover:bg-red-800 text-white font-bold py-3.5 rounded-xl transition-all transform active:scale-95 shadow-lg shadow-red-900/20 text-sm tracking-wide">
                Masuk
            </button>
        </div>

    </form>

    {{-- Footer Link --}}
    <div class="mt-8 text-center text-sm text-gray-600">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-bold text-[#B1252E] hover:underline transition-all">
            Daftar Sekarang
        </a>
    </div>
</x-guest-layout>