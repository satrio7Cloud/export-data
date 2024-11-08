<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class RedirectIfAuthenticated
{
    /**
     * Menangani permintaan masuk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika pengguna sudah terautentikasi, alihkan ke halaman utama (home)
        if (Auth::check()) {
            return redirect()->route('home');  // Menggunakan redirect yang benar
        }

        return $next($request);
    }
}
