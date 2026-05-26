<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckImpersonation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika admin memiliki session impersonate, ganti konteks Auth sementara
        if (session()->has('impersonate_user_id')) {
            // Gunakan Auth::onceUsingId() agar tidak mengubah sesi asli admin (tanpa persistent login state fallback).
            Auth::onceUsingId(session('impersonate_user_id'));
        }

        return $next($request);
    }
}
