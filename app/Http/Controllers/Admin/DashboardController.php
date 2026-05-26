<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Payment;
use App\Models\User;
use App\Models\Inquiry; // WAJIB ADA
use Illuminate\Http\Request; // WAJIB ADA

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tarik metrik dasar
        $totalPackages = Package::count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $pendingPayments = Payment::where('status', 'belum_lunas')->count();
        $totalRevenue = Payment::sum('amount');
        $recentBookings = Booking::with('package')->latest()->take(5)->get();

        // 2. QUERY INQUIRY (PROSPEK) DENGAN FILTER DAN PAGINATION
        $inquiriesQuery = Inquiry::with('package')->latest();

        // Jika admin memilih filter status di dropdown
        if ($request->filled('status') && in_array($request->status, ['pending', 'followed_up', 'closed'])) {
            $inquiriesQuery->where('status', $request->status);
        }

        // Jangan pernah gunakan get() di sini. Gunakan paginate. 
        // 20 berarti hanya 20 data yang diload per halaman.
        $inquiries = $inquiriesQuery->paginate(20);

        // 3. Ambil semua user non-admin yang punya referral_code untuk fitur akses dashboard
        $users = User::whereNotNull('referral_code')
            ->where('referral_code', '!=', '')
            ->select('id', 'name', 'email', 'role', 'referral_code')
            ->orderBy('name')
            ->get();

        return view('admin.dashboard', compact(
            'totalPackages',
            'totalBookings',
            'pendingBookings',
            'pendingPayments',
            'totalRevenue',
            'recentBookings',
            'inquiries', // Kirim data prospek ke view
            'users' // Kirim daftar user untuk akses dashboard
        ));
    }

    /**
     * Akses dashboard user berdasarkan referral code.
     * Admin bisa "mengintip" dashboard user tanpa harus login sebagai user.
     */
    public function accessUserDashboard(Request $request)
    {
        $request->validate([
            'referral_code' => 'required|string|max:50',
        ]);

        $user = User::where('referral_code', $request->referral_code)->first();

        if (!$user) {
            return back()->with('error', 'User dengan kode "' . $request->referral_code . '" tidak ditemukan.');
        }

        // Simpan user ID di session agar admin bisa melihat dashboard user
        session(['impersonate_user_id' => $user->id]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Anda sedang melihat dashboard milik: ' . $user->name);
    }

    /**
     * Hentikan impersonasi dan kembali ke admin dashboard.
     */
    public function stopImpersonating()
    {
        session()->forget('impersonate_user_id');
        return redirect()->route('admin.dashboard')
            ->with('success', 'Sesi impersonasi dihentikan.');
    }

    // FUNGSI UNTUK MENGUBAH STATUS (JANGAN SAMPAI HILANG LAGI)
    public function updateInquiryStatus(Request $request, $id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->update(['status' => $request->status]);
        return back()->with('success', 'Status prospek berhasil diperbarui!');
    }
    // 1. Menampilkan Form Konversi dengan data yang sudah terisi (Pre-filled)
    public function convertToBooking($id)
    {
        // Tarik data inquiry beserta paket dan daftar harganya
        $inquiry = Inquiry::with('package.prices')->findOrFail($id);
        return view('admin.inquiries.convert', compact('inquiry'));
    }

    // 2. Memproses Konversi dan Menyimpan ke Tabel Bookings
    public function processConversion(Request $request, $id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $package = Package::findOrFail($inquiry->package_id);

        $request->validate([
            'package_price_id' => 'required|exists:package_prices,id',
            'jumlah_orang' => 'required|integer|min:1',
        ]);

        $packagePrice = \App\Models\PackagePrice::findOrFail($request->package_price_id);
        $totalPrice = $packagePrice->price * $request->jumlah_orang;

        // Buat Pesanan Baru
        $booking = Booking::create([
            'package_id' => $package->id,
            'package_price_id' => $packagePrice->id,
            'customer_name' => $inquiry->name, // Otomatis dari Inquiry
            'phone' => $inquiry->phone,       // Otomatis dari Inquiry
            'email' => null,
            'jumlah_orang' => $request->jumlah_orang,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        // Tutup status prospek agar tidak difollow-up berulang kali oleh tim
        $inquiry->update(['status' => 'closed']);

        // Lempar ke halaman detail pesanan
        return redirect()->route('admin.bookings.show', $booking->id)
            ->with('success', 'Prospek berhasil dikonversi menjadi Pesanan Resmi!');
    }
}