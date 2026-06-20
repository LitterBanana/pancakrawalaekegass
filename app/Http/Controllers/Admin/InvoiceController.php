<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Package;
use App\Models\PackagePrice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    public function create()
    {
        $users = User::orderBy('name')->get();
        $packages = Package::with('prices')->get();
        return view('admin.invoice.create', compact('users', 'packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required_without:user_id|nullable|email|unique:users,email',
            'package_id' => 'required|exists:packages,id',
            'package_price_id' => 'required|exists:package_prices,id',
            'jumlah_orang' => 'required|integer|min:1',
            'status' => 'required|in:pending,dicicil,paid,cancel',
        ], [
            'email.required_without' => 'Email wajib diisi jika Anda membuat pengguna baru.',
            'email.unique' => 'Email sudah terdaftar di sistem, silakan pilih user yang sudah ada.',
        ]);

        try {
            DB::beginTransaction();

            $userId = $request->user_id;

            if (empty($userId)) {
                $user = User::create([
                    'name' => $request->customer_name,
                    'email' => $request->email,
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'referral_code' => User::generateReferralCode(),
                ]);
                $userId = $user->id;
            } else {
                $user = User::find($userId);
            }

            $packagePrice = PackagePrice::findOrFail($request->package_price_id);
            $totalPrice = $packagePrice->price * $request->jumlah_orang;

            $booking = Booking::create([
                'user_id' => $userId,
                'package_id' => $request->package_id,
                'package_price_id' => $request->package_price_id,
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'email' => $request->email ?? ($user->email ?? null),
                'jumlah_orang' => $request->jumlah_orang,
                'total_price' => $totalPrice,
                'status' => $request->status,
                'addons' => json_encode([]),
                'usd_rate' => 15000, 
            ]);

            DB::commit();

            return redirect()->route('admin.invoice.index')->with('success', 'Invoice berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat invoice: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $invoice = Booking::findOrFail($id);
        $users = User::orderBy('name')->get();
        $packages = Package::with('prices')->get();

        return view('admin.invoice.edit', compact('invoice', 'users', 'packages'));
    }

    public function update(Request $request, $id)
    {
        $invoice = Booking::findOrFail($id);

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'package_id' => 'required|exists:packages,id',
            'package_price_id' => 'required|exists:package_prices,id',
            'jumlah_orang' => 'required|integer|min:1',
            'status' => 'required|in:pending,dicicil,paid,cancel',
        ]);

        $packagePrice = PackagePrice::findOrFail($request->package_price_id);
        $totalPrice = $packagePrice->price * $request->jumlah_orang;

        $invoice->update([
            'package_id' => $request->package_id,
            'package_price_id' => $request->package_price_id,
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'jumlah_orang' => $request->jumlah_orang,
            'total_price' => $totalPrice,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $invoice = Booking::findOrFail($id);
        
        $invoice->payments()->delete();
        $invoice->delete();

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice berhasil dihapus.');
    }
}