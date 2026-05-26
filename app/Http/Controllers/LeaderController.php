<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderController extends Controller
{
    /**
     * Halaman publik leader — landing page untuk calon jamaah
     * melihat profil leader.
     */
    public function index()
    {
        $leaders = User::where('role', 'leader')
            ->whereNotNull('referral_code')
            ->latest()
            ->get();

        return view('leader.index', compact('leaders'));
    }
}