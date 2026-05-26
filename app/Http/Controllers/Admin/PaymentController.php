<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

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
}
