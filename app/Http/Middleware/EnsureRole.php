<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Pastikan user sudah terautentikasi di guard admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }

        $user = Auth::guard('admin')->user();

        // 2. Blokir akses jika akun dinonaktifkan (meski sesi masih aktif)
        if (!$user->is_active) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator untuk informasi lebih lanjut.',
            ]);
        }

        // 3. Cek apakah role user ada di dalam daftar role yang diperbolehkan
        if (!in_array($user->role, $roles)) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk membuka halaman ini.');
        }

        return $next($request);
    }
}
