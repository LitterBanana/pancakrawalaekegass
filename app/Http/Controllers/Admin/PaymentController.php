<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Menampilkan daftar semua pembayaran dari seluruh booking.
     * Di-eager-load relasi booking->package agar bisa tampilkan
     * nama jamaah & paket tanpa N+1 query.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['booking.package']);

        // Filter berdasarkan metode pembayaran dan status
        if ($request->filled('method')) {
            $query->where('payment_method', $request->input('method'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $summaryQuery = (clone $query);
        $totalPemasukan = $summaryQuery->sum('amount');
        $totalTransaksi = $summaryQuery->count();
        $payments = $query->latest('payment_date')->paginate(20);

        // Ringkasan keuangan untuk summary cards
        $paymentsThisMonth = Payment::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->count();
        $pendingPayments = Payment::where('status', 'belum_lunas')->count();
        $averagePayment = $totalTransaksi > 0 ? $totalPemasukan / $totalTransaksi : 0;

        return view('admin.payments.index', compact(
            'payments',
            'totalPemasukan',
            'totalTransaksi',
            'paymentsThisMonth',
            'pendingPayments',
            'averagePayment'
        ));
    }

    public function exportPdf(Request $request)
    {
        $query = Payment::with(['booking.package', 'user'])->latest('payment_date');

        if ($request->filled('method')) {
            $query->where('payment_method', $request->input('method'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $payments = $query->get();

        return view('admin.payments.report-print', compact('payments'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:sudah_lunas,belum_lunas,ditolak'
        ]);

        $payment = Payment::with('booking')->findOrFail($id);
        $payment->update(['status' => $request->status]);

        // Jika diverifikasi, perbarui status booking
        if ($request->status === 'sudah_lunas' && $payment->booking) {
            $booking = $payment->booking;
            $totalPaid = $booking->payments()->where('status', 'sudah_lunas')->sum('amount');
            
            if ($totalPaid >= $booking->total_price) {
                $booking->update(['status' => 'paid']);
            } elseif ($booking->status === 'pending') {
                $booking->update(['status' => 'dicicil']);
            }
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        $query = Payment::with(['booking.package', 'user'])->latest('payment_date');

        if ($request->filled('method')) {
            $query->where('payment_method', $request->input('method'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $payments = $query->get();

        $csvHeader = ["Tanggal", "Invoice", "Nama", "Paket", "Metode", "Jumlah", "Status", "Catatan"];
        
        $callback = function() use ($payments, $csvHeader) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);
            
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->payment_date,
                    $payment->invoice_number,
                    $payment->booking->customer_name ?? '-',
                    $payment->booking->package->name ?? '-',
                    $payment->payment_method,
                    $payment->amount,
                    $payment->status,
                    $payment->notes
                ]);
            }
            fclose($file);
        };

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=Laporan_Pembayaran_HMI_Tour_" . date('Y-m-d_H-i') . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        return response()->stream($callback, 200, $headers);
    }

    public function create()
    {
        $bookings = Booking::with('user', 'package')->latest()->get();
        return view('admin.payments.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:tunai,transfer',
            'bank_name' => 'nullable|string|max:255',
            'proof_of_payment' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:belum_lunas,sudah_lunas,ditolak',
            'notes' => 'nullable|string'
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        $imageName = null;
        if ($request->hasFile('proof_of_payment')) {
            $image = $request->file('proof_of_payment');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/payments'), $imageName);
        }

        $payment = Payment::create([
            'invoice_number'   => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
            'booking_id'       => $booking->id,
            'user_id'          => $booking->user_id,
            'amount'           => $request->amount,
            'payment_date'     => $request->payment_date,
            'payment_method'   => $request->payment_method,
            'bank_name'        => $request->bank_name,
            'proof_of_payment' => $imageName,
            'notes'            => $request->notes,
            'status'           => $request->status,
        ]);

        $this->syncBookingStatus($booking);

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $bookings = Booking::with('user', 'package')->latest()->get();
        return view('admin.payments.edit', compact('payment', 'bookings'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $oldBookingId = $payment->booking_id;

        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:tunai,transfer',
            'bank_name' => 'nullable|string|max:255',
            'proof_of_payment' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:belum_lunas,sudah_lunas,ditolak',
            'notes' => 'nullable|string'
        ]);

        $imageName = $payment->proof_of_payment;
        if ($request->hasFile('proof_of_payment')) {
            $image = $request->file('proof_of_payment');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/payments'), $imageName);
        }

        $newBooking = Booking::findOrFail($request->booking_id);

        $payment->update([
            'booking_id'       => $newBooking->id,
            'user_id'          => $newBooking->user_id,
            'amount'           => $request->amount,
            'payment_date'     => $request->payment_date,
            'payment_method'   => $request->payment_method,
            'bank_name'        => $request->bank_name,
            'proof_of_payment' => $imageName,
            'notes'            => $request->notes,
            'status'           => $request->status,
        ]);

        $this->syncBookingStatus($newBooking);

        if ($oldBookingId != $newBooking->id) {
            $oldBooking = Booking::find($oldBookingId);
            if ($oldBooking) {
                $this->syncBookingStatus($oldBooking);
            }
        }

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $booking = $payment->booking;
        
        $payment->delete();

        if ($booking) {
            $this->syncBookingStatus($booking);
        }

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil dihapus.');
    }

    private function syncBookingStatus($booking)
    {
        $totalPaid = $booking->payments()->where('status', 'sudah_lunas')->sum('amount');
        
        if ($totalPaid >= $booking->total_price) {
            $booking->update(['status' => 'paid']);
        } elseif ($totalPaid > 0) {
            $booking->update(['status' => 'dicicil']);
        } else {
            $booking->update(['status' => 'pending']);
        }
    }
}
