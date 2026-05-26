<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class UserAuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function loginForm(): View
    {
        return view('user.auth.login');
    }
}