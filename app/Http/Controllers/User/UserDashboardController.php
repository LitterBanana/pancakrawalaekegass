<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Ambil booking milik user beserta paket dan pembayarannya
        $booking = $user->bookings()
            ->with(['package', 'payments'])
            ->latest()
            ->first();

        // Hitung statistik pembayaran (hanya yang sudah diverifikasi admin)
        $totalCost = $booking ? $booking->total_price : 0;
        $paidAmount = $booking ? $booking->payments->where('status', 'sudah_lunas')->sum('amount') : 0;
        $remaining = $totalCost - $paidAmount;
        $percentage = $totalCost > 0 ? min(round(($paidAmount / $totalCost) * 100), 100) : 0;
        $isPaid = $paidAmount >= $totalCost && $totalCost > 0;

        // Ambil 5 transaksi terbaru milik user
        $recentPayments = $user->payments()
            ->with('booking.package')
            ->latest('payment_date')
            ->take(5)
            ->get();

        return view('user.dashboard', [
            'pageTitle' => 'Dashboard',
            'pageSubtitle' => 'Selamat datang kembali',
            'user' => $user,
            'booking' => $booking,
            'totalCost' => $totalCost,
            'paidAmount' => $paidAmount,
            'remaining' => $remaining,
            'percentage' => $percentage,
            'isPaid' => $isPaid,
            'recentPayments' => $recentPayments,
        ]);
    }
}