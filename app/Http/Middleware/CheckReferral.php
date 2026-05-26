<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckReferral
{
    /**
     * Tangkap parameter ?ref= dari URL dan simpan ke session.
     * Digunakan saat user mendaftar melalui link referral leader.
     *
     * Contoh URL: /login?ref=HMI-RADIT2026
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('ref') && !empty($request->ref)) {
            $referralCode = $request->query('ref');

            // Simpan ke session supaya bisa dipakai saat form register disubmit
            session(['referral_code' => $referralCode]);
        }

        return $next($request);
    }
}