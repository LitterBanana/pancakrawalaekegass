<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserInvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();

        $query = $user->payments()->with(['booking.package.category', 'booking.packagePrice', 'booking.payments'])->latest();

        // Apply filter tab
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('invoice_number', 'like', "%{$keyword}%")
                    ->orWhereHas('booking.package', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
            });
        }

        $payments = $query->get();

        // Hitung ringkasan per booking agar bisa ditampilkan di detail invoice
        // Masing-masing payment punya konteks booking-nya sendiri
        foreach ($payments as $payment) {
            if ($payment->booking) {
                $booking = $payment->booking;
                // Total sudah dibayar dan diverifikasi admin pada booking ini
                $payment->booking->sudah_dibayar = $booking->payments
                    ->where('status', 'sudah_lunas')
                    ->sum('amount');
                // Total yang sedang menunggu verifikasi (belum_lunas)
                $payment->booking->pending_verifikasi = $booking->payments
                    ->where('status', 'belum_lunas')
                    ->sum('amount');
                // Sisa tagihan = total - yang sudah diverifikasi
                $payment->booking->sisa_tagihan = max(
                    0,
                    $booking->total_price - $payment->booking->sudah_dibayar
                );
            }
        }

        // Count for stats
        $totalInvoices = $user->payments()->count();
        $paidInvoices = $user->payments()->where('status', 'sudah_lunas')->count();
        $unpaidInvoices = $user->payments()->whereIn('status', ['belum_lunas', 'ditolak'])->count();

        return view('user.invoices', compact('payments', 'totalInvoices', 'paidInvoices', 'unpaidInvoices'), [
            'pageTitle' => 'Travel Invoices',
            'pageSubtitle' => 'Kelola dan lihat invoice perjalanan Anda',
        ]);
    }

    public function print($id)
    {
        $user = Auth::user();
        $payment = $user->payments()
            ->with([
                'user.leader',
                'booking.package.category',
                'booking.packagePrice',
                'booking.payments' => fn($q) => $q->oldest('payment_date'),
            ])
            ->findOrFail($id);

        // Nomor urut invoice berdasarkan booking, bukan payment
        // 1 booking = 1 nomor invoice, meskipun cicilan berkali-kali
        $booking = $payment->booking;
        $invoiceSeq = str_pad($booking->id, 4, '0', STR_PAD_LEFT);

        // Angka romawi bulan untuk format nomor formal
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $bookingDate = $booking->created_at ?? now();
        $bulanRomawi = $romanMonths[$bookingDate->month - 1];
        $tahun = $bookingDate->year;
        $invoiceNo = "{$invoiceSeq}/HMI/INV/{$bulanRomawi}/{$tahun}";

        // Definisi add-on (harga per item)
        $addonDefs = [
            'paspor' => ['label' => 'Pembuatan E-Paspor Express', 'price_idr' => 1500000],
            'bisnis_class' => ['label' => 'Upgrade Bisnis Class', 'price_idr' => 8000000],
            'upgrade_kamar' => ['label' => 'Upgrade Kamar Hotel', 'price_idr' => 2500000],
            'vaksin' => ['label' => 'Vaksin', 'price_idr' => 350000],
        ];

        $addons = is_array($booking->addons) ? $booking->addons : (json_decode($booking->addons ?? 'null', true) ?? []);
        $usdRate = $booking->usd_rate ?? 17229;

        return view('user.invoice_print', compact(
            'payment',
            'invoiceNo',
            'addonDefs',
            'addons',
            'usdRate'
        ));
    }
}