<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return response()->view('403', [], Response::HTTP_FORBIDDEN);
        }

        // Cek apakah department-nya QA atau Produksi
        if (Auth::user()->role === 'Admin') {
            return $next($request); // Lanjut ke controller
        }

        return response()->view('403', [], Response::HTTP_FORBIDDEN);
    }
}
