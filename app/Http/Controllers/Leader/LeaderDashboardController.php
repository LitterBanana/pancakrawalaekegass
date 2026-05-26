<?php

namespace App\Http\Controllers\Leader;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeaderDashboardController extends Controller
{
    public function index()
    {
        $leader = Auth::user();

        // Ambil semua ID downline milik leader ini
        $downlineIds = $leader->referrals()->pluck('id');

        // Jumlah total downline
        $totalDownline = $downlineIds->count();

        // Ambil semua booking downline yang belum cancel + payments verified
        $allBookings = Booking::with([
                'payments' => fn($q) => $q->where('status', 'sudah_lunas'),
            ])
            ->whereIn('user_id', $downlineIds)
            ->whereNotIn('status', ['cancel'])
            ->get();

        // Filter booking yang LUNAS PENUH (total bayar >= total_price)
        $lunasBookings = $allBookings->filter(function ($booking) {
            $totalVerified = $booking->payments->sum('amount');
            return $totalVerified >= $booking->total_price && $booking->total_price > 0;
        });

        // Total komisi: jumlah_orang × Rp200.000 per booking lunas
        $totalRevenue = $lunasBookings->sum(fn($b) => $b->jumlah_orang * 200000);

        // Komisi bulan ini: hanya booking yang lunas di bulan ini
        // (berdasarkan tanggal pembayaran terakhir)
        $monthlyRevenue = $lunasBookings->filter(function ($booking) {
            $lastPayment = $booking->payments->sortByDesc('payment_date')->first();
            if (!$lastPayment) return false;
            $lunasDate = Carbon::parse($lastPayment->payment_date);
            return $lunasDate->month === now()->month && $lunasDate->year === now()->year;
        })->sum(fn($b) => $b->jumlah_orang * 200000);

        // Ambil 10 downline terbaru untuk tabel di dashboard
        $downlines = $leader->referrals()->latest()->take(10)->get();

        return view('leader.dashboard', compact(
            'totalDownline',
            'totalRevenue',
            'monthlyRevenue',
            'downlines'
        ));
    }

    public function members()
    {
        $leader = Auth::user();

        // Gunakan paginate agar view bisa memanggil ->total()
        $members = $leader->referrals()->latest()->paginate(15);

        return view('leader.members.index', compact('leader', 'members'));
    }

    public function membersCrud()
    {
        $leader = Auth::user();

        // Gunakan paginate agar view bisa memanggil ->total()
        $members = $leader->referrals()->latest()->paginate(15);

        return view('leader.members.crud', compact('leader', 'members'));
    }

    public function reports()
    {
        $leader = Auth::user();

        // Ambil ID semua downline leader ini
        $downlineIds = $leader->referrals()->pluck('id');

        // Ambil semua booking downline beserta payments verified
        $allBookings = Booking::with([
                'user',
                'package',
                'payments' => fn($q) => $q->where('status', 'sudah_lunas')->orderBy('payment_date'),
            ])
            ->whereIn('user_id', $downlineIds)
            ->whereNotIn('status', ['cancel'])
            ->get();

        // Filter booking LUNAS PENUH
        $lunasBookings = $allBookings->filter(function ($booking) {
            $totalVerified = $booking->payments->sum('amount');
            return $totalVerified >= $booking->total_price && $booking->total_price > 0;
        });

        // Hitung komisi: jumlah_orang × Rp200.000
        $totalRevenue = $lunasBookings->sum(fn($b) => $b->jumlah_orang * 200000);

        // Komisi bulan ini
        $monthlyRevenue = $lunasBookings->filter(function ($booking) {
            $lastPayment = $booking->payments->sortByDesc('payment_date')->first();
            if (!$lastPayment) return false;
            $lunasDate = Carbon::parse($lastPayment->payment_date);
            return $lunasDate->month === now()->month && $lunasDate->year === now()->year;
        })->sum(fn($b) => $b->jumlah_orang * 200000);

        // Total jamaah dari booking yang sudah lunas
        $totalPeople = $lunasBookings->sum('jumlah_orang');

        // Susun data komisi untuk tabel
        $commissionItems = $lunasBookings->map(function ($booking) {
            $lastPayment = $booking->payments->sortByDesc('payment_date')->first();
            $lunasDate   = $lastPayment
                ? Carbon::parse($lastPayment->payment_date)
                : Carbon::parse($booking->updated_at);

            return (object) [
                'user_name'    => $booking->user->name ?? '—',
                'package_name' => $booking->package->name ?? '—',
                'jumlah_orang' => $booking->jumlah_orang,
                'commission'   => $booking->jumlah_orang * 200000,
                'lunas_date'   => $lunasDate,
            ];
        })->sortByDesc('lunas_date')->values();

        return view('leader.reports.index', compact(
            'totalRevenue',
            'monthlyRevenue',
            'totalPeople',
            'commissionItems'
        ));
    }

    public function reportsCrud()
    {
        $leader = Auth::user();

        // Ambil ID semua downline leader ini
        $downlineIds = $leader->referrals()->pluck('id');

        // Ambil semua booking downline yang lunas untuk perhitungan tren
        $allBookings = Booking::with([
                'user',
                'payments' => fn($q) => $q->where('status', 'sudah_lunas')->orderBy('payment_date'),
            ])
            ->whereIn('user_id', $downlineIds)
            ->whereNotIn('status', ['cancel'])
            ->get();

        // Filter booking lunas penuh
        $lunasBookings = $allBookings->filter(function ($booking) {
            $totalVerified = $booking->payments->sum('amount');
            return $totalVerified >= $booking->total_price && $booking->total_price > 0;
        });

        // Hitung komisi per bulan — 6 bulan terakhir
        $monthlyData = collect();
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);

            // Komisi bulan ini: booking yang lunas di bulan ini × Rp200.000/orang
            $monthCommission = $lunasBookings->filter(function ($booking) use ($bulan) {
                $lastPayment = $booking->payments->sortByDesc('payment_date')->first();
                if (!$lastPayment) return false;
                $lunasDate = Carbon::parse($lastPayment->payment_date);
                return $lunasDate->month === $bulan->month && $lunasDate->year === $bulan->year;
            })->sum(fn($b) => $b->jumlah_orang * 200000);

            // Jumlah downline baru yang bergabung pada bulan ini
            $newMembers = $leader->referrals()
                ->whereYear('created_at', $bulan->year)
                ->whereMonth('created_at', $bulan->month)
                ->count();

            $monthlyData->push([
                'month'       => $bulan->format('M Y'),
                'revenue'     => (int) $monthCommission,
                'new_members' => $newMembers,
            ]);
        }

        // Top 5 downline berdasarkan komisi (jumlah_orang × Rp200.000 dari booking lunas)
        $topDownlines = $lunasBookings
            ->groupBy('user_id')
            ->map(function ($bookings) {
                $user = $bookings->first()->user;
                $totalPeople = $bookings->sum('jumlah_orang');
                return (object) [
                    'name'       => $user->name ?? '—',
                    'email'      => $user->email ?? '',
                    'total_paid' => $totalPeople * 200000,
                ];
            })
            ->sortByDesc('total_paid')
            ->take(5)
            ->values();

        return view('leader.reports.crud', compact('monthlyData', 'topDownlines'));
    }

    /**
     * Generate ulang kode referral untuk leader yang sedang login.
     */
    public function regenerateReferral()
    {
        $user = Auth::user();
        $user->referral_code = User::generateReferralCode();
        $user->save();

        return back()->with('success', 'Kode referral berhasil di-generate: ' . $user->referral_code);
    }

    /**
     * Tampilkan halaman profil leader menggunakan leader layout.
     * Mengambil data yang sama dengan UserProfileController agar
     * leader bisa melihat info booking & pembayaran miliknya sendiri.
     */
    public function profile()
    {
        $user = Auth::user();

        // Ambil booking aktif leader (jika leader juga punya booking umroh pribadi)
        $booking = $user->bookings()
            ->with(['package', 'packagePrice', 'payments'])
            ->whereNotIn('status', ['cancel'])
            ->latest()
            ->first();

        $totalCost   = $booking ? $booking->total_price : 0;
        $paidAmount  = $booking ? $booking->payments->where('status', 'sudah_lunas')->sum('amount') : 0;
        $remaining   = $totalCost - $paidAmount;
        $percentage  = $totalCost > 0 ? min(round(($paidAmount / $totalCost) * 100), 100) : 0;

        return view('leader.profile', compact(
            'user',
            'booking',
            'totalCost',
            'paidAmount',
            'remaining',
            'percentage'
        ));
    }

    /**
     * Invoice Komisi Leader — ditampilkan di halaman "Invoice Downline".
     *
     * Logika:
     * - Ambil semua booking dari downline (user referred_by = leader.id)
     * - Filter hanya booking yang LUNAS PENUH (total pembayaran terverifikasi >= total_price)
     * - Komisi per booking = jumlah_orang × Rp 200.000
     * - Leader TIDAK bisa melihat invoice/detail pembayaran user
     * - Data dikelompokkan per bulan berdasarkan tanggal pelunasan
     */
    public function invoices(Request $request)
    {
        $leader      = Auth::user();
        $downlineIds = $leader->referrals()->pluck('id');

        // Ambil semua booking dari downline beserta relasinya
        $allBookings = Booking::with([
                'user',
                'package.category',
                'packagePrice',
                'payments' => fn($q) => $q->where('status', 'sudah_lunas')->orderBy('payment_date'),
            ])
            ->whereIn('user_id', $downlineIds)
            ->whereNotIn('status', ['cancel'])
            ->get();

        // Filter hanya booking yang sudah LUNAS PENUH:
        // total pembayaran terverifikasi >= total_price booking
        $lunasBookings = $allBookings->filter(function ($booking) {
            $totalVerified = $booking->payments->sum('amount');
            return $totalVerified >= $booking->total_price && $booking->total_price > 0;
        });

        // Susun data komisi per booking
        $commissionItems = $lunasBookings->map(function ($booking) {
            // Gunakan tanggal pembayaran terakhir yang verified sebagai "lunas date"
            $lastPayment  = $booking->payments->sortByDesc('payment_date')->first();
            $lunasDate    = $lastPayment
                ? Carbon::parse($lastPayment->payment_date)
                : Carbon::parse($booking->updated_at);

            $commission = $booking->jumlah_orang * 200000;

            return [
                'booking'       => $booking,
                'user'          => $booking->user,
                'package'       => $booking->package,
                'price_type'    => $booking->packagePrice?->type ?? '—',
                'jumlah_orang'  => $booking->jumlah_orang,
                'total_price'   => $booking->total_price,
                'commission'    => $commission,
                'lunas_date'    => $lunasDate,
                // Key untuk grouping: YYYY-MM (sortable)
                'month_key'     => $lunasDate->format('Y-m'),
                // Label yang ditampilkan: 'April 2026'
                'month_label'   => $lunasDate->translatedFormat('F Y'),
            ];
        });

        // Filter pencarian keyword
        if ($request->filled('keyword')) {
            $keyword = strtolower($request->keyword);
            $commissionItems = $commissionItems->filter(function ($item) use ($keyword) {
                return str_contains(strtolower($item['user']->name ?? ''), $keyword)
                    || str_contains(strtolower($item['package']->name ?? ''), $keyword);
            });
        }

        // Kelompokkan per bulan, urutkan dari terbaru
        $groupedByMonth = $commissionItems
            ->groupBy('month_key')
            ->sortKeysDesc();

        // Statistik ringkasan
        $totalCommission = $commissionItems->sum('commission');
        $totalPeople     = $commissionItems->sum('jumlah_orang');
        $totalBookings   = $commissionItems->count();
        $totalMonths     = $groupedByMonth->count();

        return view('leader.invoices', compact(
            'leader',
            'groupedByMonth',
            'totalCommission',
            'totalPeople',
            'totalBookings',
            'totalMonths'
        ));
    }

}