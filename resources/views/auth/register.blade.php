<x-guest-layout>
    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Create Account</h2>
        <p class="text-gray-500 mt-2 text-sm">Join us and start your health journey today</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Name --}}
        <div class="space-y-1">
            <label for="name" class="text-sm font-bold text-gray-900">Full Name</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-900 focus:border-green-800 focus:ring-1 focus:ring-green-800 placeholder-gray-300 transition-all text-sm shadow-sm"
                placeholder="Enter your full name"
            >
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email Address --}}
        <div class="space-y-1">
            <label for="email" class="text-sm font-bold text-gray-900">Email Address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-900 focus:border-green-800 focus:ring-1 focus:ring-green-800 placeholder-gray-300 transition-all text-sm shadow-sm"
                placeholder="Enter your email"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="space-y-1">
            <label for="password" class="text-sm font-bold text-gray-900">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-900 focus:border-green-800 focus:ring-1 focus:ring-green-800 placeholder-gray-300 transition-all text-sm shadow-sm"
                placeholder="Create a password"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div class="space-y-1">
            <label for="password_confirmation" class="text-sm font-bold text-gray-900">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-900 focus:border-green-800 focus:ring-1 focus:ring-green-800 placeholder-gray-300 transition-all text-sm shadow-sm"
                placeholder="Repeat your password"
            >
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Button Register --}}
        <div class="pt-2">
            <button type="submit" class="w-full bg-red-600 text-white font-bold py-3.5 rounded-xl transition transform active:scale-95 shadow-lg shadow-green-900/20 text-sm tracking-wide uppercase">
                {{ __('Sign Up') }}
            </button>
        </div>
    </form>
    
    {{-- Footer Link --}}
    <div class="mt-8 text-center text-sm text-gray-600">
        Already have an account? 
        <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-500 transition">
            Sign In
        </a>
    </div>
</x-guest-layout>