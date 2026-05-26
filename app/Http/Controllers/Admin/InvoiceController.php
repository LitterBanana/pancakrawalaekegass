<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Menampilkan semua booking sebagai invoice.
     * TIDAK terbatas hanya status 'paid' — admin bisa lihat semua status.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['package', 'payments', 'user']);

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search berdasarkan nama jamaah
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('customer_name', 'like', "%{$keyword}%")
                  ->orWhere('phone', 'like', "%{$keyword}%")
                  ->orWhereHas('package', function($q) use ($keyword) {
                      $q->where('name', 'like', "%{$keyword}%");
                  });
            });
        }

        $invoices = $query->latest()->paginate(20);

        // Statistik dari SEMUA data, bukan hanya halaman saat ini
        $totalInvoices = Booking::count();
        $paidInvoices = Booking::where('status', 'paid')->count();
        $pendingInvoices = Booking::whereIn('status', ['pending', 'dicicil'])->count();
        $totalRevenue = Payment::where('status', 'sudah_lunas')->sum('amount');
        $invoicesThisMonth = Booking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Calculate average invoice (total revenue / number of paid invoices)
        $averageInvoice = $paidInvoices > 0 ? $totalRevenue / $paidInvoices : 0;

        return view('admin.invoice.index', compact(
            'invoices',
            'totalInvoices',
            'paidInvoices',
            'pendingInvoices',
            'totalRevenue',
            'invoicesThisMonth',
            'averageInvoice'
        ));
    }

    /**
     * Detail invoice (booking + riwayat pembayaran)
     */
    public function show($id)
    {
        $invoice = Booking::with(['package', 'payments.user', 'user'])->findOrFail($id);
        
        $totalPaid = $invoice->payments->where('status', 'sudah_lunas')->sum('amount');
        $sisaTagihan = max(0, $invoice->total_price - $totalPaid);
        $percentage = $invoice->total_price > 0 
            ? min(round(($totalPaid / $invoice->total_price) * 100), 100) 
            : 0;

        return view('admin.invoice.show', compact('invoice', 'totalPaid', 'sisaTagihan', 'percentage'));
    }

    /**
     * Cetak invoice - halaman print-friendly untuk admin
     */
    public function print($id)
    {
        $invoice = Booking::with(['package', 'payments', 'user'])->findOrFail($id);
        
        $totalPaid = $invoice->payments->where('status', 'sudah_lunas')->sum('amount');
        $sisaTagihan = max(0, $invoice->total_price - $totalPaid);

        return view('admin.invoice.print', compact('invoice', 'totalPaid', 'sisaTagihan'));
    }

    /**
     * Download invoice sebagai PDF via browser print dialog.
     * Redirect ke halaman print yang bisa di-save as PDF.
     */
    public function download($id)
    {
        return redirect()->route('admin.invoice.print', $id);
    }
}