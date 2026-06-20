<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use Illuminate\Support\Str;

class UserPaymentController extends Controller
{
    public function index(): View|\Illuminate\Http\RedirectResponse
    {
        if (session()->has('impersonate_user_id')) {
            return redirect()->route('user.dashboard')->with('error', 'Opsi pembayaran dikunci saat Anda berada dalam mode impersonasi.');
        }

        $user = Auth::user();
        $activeBooking = $user->bookings()->with('package')->whereNotIn('status', ['cancel'])->latest()->first();
        
        $totalTagihan = $activeBooking ? $activeBooking->total_price : 0;
        $sudahDibayar = $activeBooking ? $activeBooking->payments()->where('status', 'sudah_lunas')->sum('amount') : 0;
        $sisaTagihan = max(0, $totalTagihan - $sudahDibayar);

        return view('user.payments.index', compact('user', 'activeBooking', 'totalTagihan', 'sudahDibayar', 'sisaTagihan'), [
            'pageTitle' => 'Form Pembayaran',
            'pageSubtitle' => 'Lakukan pembayaran tour Anda',
        ]);
    }

    public function store(Request $request)
    {
        if (session()->has('impersonate_user_id')) {
            return redirect()->route('user.dashboard')->with('error', 'Transaksi pembayaran tidak diizinkan saat mode impersonasi.');
        }

        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|in:tunai,transfer',
            'bank' => 'required_if:payment_method,transfer|nullable|string',
            'proof_of_payment' => 'required_if:payment_method,transfer|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        $user = Auth::user();
        $activeBooking = $user->bookings()->whereNotIn('status', ['cancel'])->latest()->first();

        if (!$activeBooking) {
            return back()->with('error', 'Anda belum memiliki tagihan aktif.');
        }

        $imageName = null;
        if ($request->hasFile('proof_of_payment')) {
            $image = $request->file('proof_of_payment');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/payments'), $imageName);
        }

        $payment = Payment::create([
            'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
            'user_id' => $user->id,
            'booking_id' => $activeBooking->id,
            'amount' => $request->amount,
            'payment_date' => now()->toDateString(),
            'payment_method' => $request->payment_method,
            'bank_name' => $request->payment_method === 'transfer' ? $request->bank : null,
            'proof_of_payment' => $imageName,
            'status' => 'belum_lunas',
        ]);

        return redirect()->route('user.invoices')->with('success', 'Pembayaran berhasil dikirim dan menunggu verifikasi admin.');
    }
}