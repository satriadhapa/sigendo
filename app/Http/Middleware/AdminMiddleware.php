<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        // Cek apakah pengguna terautentikasi dan adalah admin
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }
        // Redirect jika bukan admin
        return redirect('/')->with('error', 'Anda tidak memiliki akses sebagai admin.');
    }
}
