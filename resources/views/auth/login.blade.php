<x-guest-layout>
    {{-- Header --}}
    <div class="mb-10">
        <h2 class="text-4xl font-bold text-gray-900 tracking-tight">Welcome back!</h2>
        <p class="text-gray-500 mt-2 text-sm">Enter your credentials to access your account</p>
    </div>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Kolom Nama (OPSIONAL: Jika ingin dijadikan Register, uncomment ini) --}}
        {{-- 
        <div class="space-y-1">
            <label for="name" class="text-sm font-semibold text-gray-900">Name</label>
            <input id="name" type="text" name="name" 
                class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-900 focus:border-green-700 focus:ring-1 focus:ring-green-700 placeholder-gray-300 transition-all text-sm"
                placeholder="Enter your name">
        </div> 
        --}}

        {{-- Email Address --}}
        <div class="space-y-1">
            <label for="email" class="text-sm font-bold text-gray-900">Email address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-900 focus:border-green-800 focus:ring-1 focus:ring-green-800 placeholder-gray-300 transition-all text-sm shadow-sm"
                placeholder="Enter your email"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="space-y-1">
            <label for="password" class="text-sm font-bold text-gray-900">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-900 focus:border-green-800 focus:ring-1 focus:ring-green-800 placeholder-gray-300 transition-all text-sm shadow-sm"
                placeholder="Enter your password"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember Me & Terms --}}
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" 
                    class="rounded border-gray-300 text-green-800 shadow-sm focus:ring-green-800 cursor-pointer" 
                    name="remember">
                <span class="ml-2 text-xs font-medium text-gray-600 group-hover:text-gray-900 transition">{{ __('I agree to the terms & policy') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-gray-900 hover:text-green-700 transition" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </a>
            @endif
        </div>

        {{-- Button Sign In --}}
        <div class="pt-2">
            <button type="submit" class="w-full bg-red-600 hover-bg-red-300 text-white font-bold py-3.5 rounded-xl transition transform active:scale-95 shadow-lg shadow-green-900/20 text-sm tracking-wide">
                {{ __('Login') }} 
                {{-- Teks tombol saya tulis Signup agar sesuai gambar, tapi fungsinya Login --}}
            </button>
        </div>
    </form>

    {{-- Footer Link --}}
    <div class="mt-8 text-center text-sm text-gray-600">
        Don’t have an account?
        <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-500 transition">
            Sign Up
        </a>
    </div>
</x-guest-layout>