<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Ambil booking aktif beserta relasi yang diperlukan untuk profil
        $booking = $user->bookings()
            ->with(['package', 'packagePrice', 'payments'])
            ->whereNotIn('status', ['cancel'])
            ->latest()
            ->first();

        // Hitung statistik pembayaran (hanya yang sudah diverifikasi)
        $totalCost    = $booking ? $booking->total_price : 0;
        $paidAmount   = $booking
            ? $booking->payments->where('status', 'sudah_lunas')->sum('amount')
            : 0;
        $remaining    = max(0, $totalCost - $paidAmount);
        $percentage   = $totalCost > 0 ? min(round(($paidAmount / $totalCost) * 100), 100) : 0;

        return view('user.profile', [
            'pageTitle'   => 'Profil Saya',
            'pageSubtitle' => 'Kelola informasi akun Anda',
            'user'        => $user,
            'booking'     => $booking,
            'totalCost'   => $totalCost,
            'paidAmount'  => $paidAmount,
            'remaining'   => $remaining,
            'percentage'  => $percentage,
        ]);
    }
}