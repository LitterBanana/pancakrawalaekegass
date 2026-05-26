<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Str;

class BookingOrderController extends Controller
{
    public function index()
    {
        // Tarik data pesanan lengkap dengan relasi paket dan harganya
        $bookings = Booking::with(['package', 'packagePrice'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            // Tambahkan 'dicicil' ke dalam aturan validasi
            'status' => 'required|in:pending,dicicil,paid,cancel'
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pembiayaan berhasil diperbarui!');
    }
    public function show($id)
    {
        // Tarik pesanan beserta riwayat pembayarannya
        $booking = Booking::with(['package', 'packagePrice', 'payments'])->findOrFail($id);
        
        // Hitung matematika dasarnya
        $totalPaid = $booking->payments->sum('amount');
        $sisaTagihan = $booking->total_price - $totalPaid;
        
        return view('admin.bookings.show', compact('booking', 'totalPaid', 'sisaTagihan'));
    }

    public function storePayment(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'proof_of_payment' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string'
        ]);

        $booking = Booking::findOrFail($id);

        // Proses unggah bukti transfer jika ada
        $imageName = null;
        if ($request->hasFile('proof_of_payment')) {
            $image = $request->file('proof_of_payment');
            $imageName = time() . '_' . $image->getClientOriginalName();
            // Simpan ke folder public/assets/images/payments
            $image->move(public_path('assets/images/payments'), $imageName);
        }

        // Simpan data uang masuk
        // invoice_number wajib diisi karena kolom unique di DB
        // user_id diambil dari booking untuk menjaga konsistensi data
        Payment::create([
            'invoice_number'   => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
            'booking_id'       => $booking->id,
            'user_id'          => $booking->user_id,
            'amount'           => $request->amount,
            'payment_date'     => $request->payment_date,
            'payment_method'   => $request->payment_method,
            'proof_of_payment' => $imageName,
            'notes'            => $request->notes,
            'status'           => 'sudah_lunas', // Admin yang input = langsung terverifikasi
        ]);

        // HITUNG ULANG OTOMATIS
        // Ambil total yang dibayar SETELAH pembayaran baru ini masuk
        $totalPaid = $booking->payments()->sum('amount');
        
        if ($totalPaid >= $booking->total_price) {
            // Jika uang masuk sudah menutupi harga, kunci jadi LUNAS
            $booking->update(['status' => 'paid']);
        } elseif ($booking->status == 'pending') {
            // Jika baru bayar DP, ubah dari pending ke DICICIL
            $booking->update(['status' => 'dicicil']);
        }

        return redirect()->back()->with('success', 'Pembayaran sebesar IDR ' . number_format($request->amount, 0, ',', '.') . ' berhasil dicatat!');
    }
}