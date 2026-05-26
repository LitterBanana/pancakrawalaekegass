<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LeaderMiddleware
{
    /**
     * Pastikan user yang login memiliki role 'leader'.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'leader') {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Leader.');
        }

        return $next($request);
    }
}