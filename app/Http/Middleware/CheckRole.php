<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  (Menerima banyak role sekaligus menggunakan splat operator)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Cek apakah pengguna sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role pengguna saat ini ada di dalam daftar role yang diizinkan
        if (in_array(auth()->user()->role, $roles)) {
            return $next($request); // Silakan lewat
        }

        // 3. Jika tidak punya hak akses, lempar error 403 (Forbidden)
        abort(403, 'Maaf, Anda tidak memiliki akses untuk halaman ini.');
    }
}
