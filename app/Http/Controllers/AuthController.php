<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Cek jika sudah login, langsung ke dashboard sesuai role
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if (Auth::user()->role === 'leader') {
                return redirect()->route('leader.dashboard');
            }
            // User biasa → ke dashboard user
            return redirect()->route('user.dashboard');
        }
        
        // Return view halaman login stand-alone Anda
        return view('auth.login'); 
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'referral_code' => 'nullable|string|max:255',
        ]);

        // 1. Cek referral_code dari input form terlebih dahulu
        $referredBy = null;
        if ($request->filled('referral_code')) {
            $leader = User::where('referral_code', $request->referral_code)->first();
            if ($leader) {
                $referredBy = $leader->id;
            }
        } else {
            // Jika tidak ada di form, cek cookie
            $referralCookie = Cookie::get('referral_code');
            if ($referralCookie) {
                $leader = User::where('referral_code', $referralCookie)->first();
                if ($leader) {
                    $referredBy = $leader->id;
                }
            }
        }

        // 2. Buat user baru
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            // Jangan bcrypt manual — User model punya cast 'password' => 'hashed'
            // yang otomatis hash password. Double-hashing akan membuat login gagal.
            'password'    => $request->password,
            // referral_code TIDAK digenerate untuk user biasa.
            // Hanya role 'leader' yang membutuhkan referral_code.
            // Masukkan ID Leader yang mereferensikan (jika ada)
            'referred_by' => $referredBy,
        ]);

        // Hapus cookie setelah berhasil mendaftar
        Cookie::queue(Cookie::forget('referral_code'));

        // Login otomatis setelah register
        Auth::login($user);

        // User baru langsung ke dashboard mereka
        return redirect()->route('user.dashboard')->with('success', 'Registrasi berhasil!');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba cocokkan dengan database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Arahkan berdasarkan role user
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if (Auth::user()->role === 'leader') {
                return redirect()->route('leader.dashboard');
            }

            // User biasa → ke dashboard user
            return redirect()->route('user.dashboard');
        }

        // Jika gagal, kembalikan dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah. Akses ditolak.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}