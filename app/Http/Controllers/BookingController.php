<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Inquiry;

class BookingController extends Controller
{
    public function create($slug)
    {
        // Cari paket berdasarkan slug, dan WAJIB bawa data relasi harganya
        // Jika slug tidak ditemukan di database, batalkan dan tampilkan error 404
        $package = Package::with(['prices', 'hotelMakkah', 'hotelMadinah'])->where('slug', $slug)->firstOrFail();
        // Kirim data paket ke halaman form pemesanan
        return view('booking.create', compact('package'));
    }

    public function store(Request $request, $slug)
    {
        // 1. Cari paket yang sedang di-booking menggunakan jalur absolut
        $package = Package::where('slug', $slug)->firstOrFail();

        // 2. Validasi ketat input dari user
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'jumlah_orang' => 'required|integer|min:1',
            'package_price_id' => 'required|exists:package_prices,id'
        ]);

        // 3. Ambil data harga yang dipilih langsung dari database
        $packagePrice = \App\Models\PackagePrice::where('id', $request->package_price_id)
            ->where('package_id', $package->id)
            ->firstOrFail();

        // 4. Kalkulasi Total Harga (Harga per kamar x Jumlah Orang)
        $totalPrice = $packagePrice->price * $request->jumlah_orang;

        // 5. Simpan transaksi ke tabel bookings. 
        $booking = \App\Models\Booking::create([
            'package_id' => $package->id,
            'package_price_id' => $packagePrice->id,
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'jumlah_orang' => $request->jumlah_orang,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        // 6. Lempar ke halaman invoice
        return redirect()->route('booking.invoice', $booking->id);
    }

    public function invoice($id)
    {
        // Ambil data booking beserta relasi paket dan harganya sekaligus (Eager Loading)
        $booking = \App\Models\Booking::with(['package', 'packagePrice'])->findOrFail($id);

        // Lempar ke halaman invoice
        return view('booking.invoice', compact('booking'));
    }

    public function simpleForm($slug)
    {
        // WAJIB tambahkan with('prices') agar formulir tahu kamar apa saja yang tersedia
        $package = Package::with('prices')->where('slug', $slug)->firstOrFail();

        return view('booking.simple-form', compact('package'));
    }

    public function storeSimple(Request $request, $slug)
    {
        // 1. CEK HONEYPOT: Jika kolom jebakan bot terisi, langsung buang dan pura-pura sukses.
        if (!empty($request->website_url)) {
            return redirect('/');
        }

        // 2. Lanjut ke validasi normal
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'room_type' => 'required|string', // WAJIB ADA UNTUK MENANGKAP PILIHAN KAMAR
            'pax' => 'required|integer|min:1', // WAJIB ADA UNTUK MENANGKAP JUMLAH ORANG
        ]);

        $package = Package::where('slug', $slug)->firstOrFail();

        // MERAKIT DATA KAMAR DAN JUMLAH ORANG MENJADI CATATAN
        $notes = "Kamar: " . $request->room_type . " | Jumlah Jamaah: " . $request->pax . " Orang";

        $inquiry = Inquiry::create([
            'package_id' => $package->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'notes' => $notes,
        ]);

        return redirect()->route('booking.waRedirect', $inquiry->id);
    }

    public function waRedirect($id)
    {
        $inquiry = Inquiry::with('package')->findOrFail($id);

        $waNumber = "6285695170953"; // GANTI DENGAN NOMOR ADMIN ASLI ANDA

        // MERAKIT PESAN WHATSAPP BARU
        $message = "Assalamualaikum Admin, saya *" . $inquiry->name . "*.\n\n";
        $message .= "Saya ingin memesan paket umroh:\n";
        $message .= "🕋 *" . $inquiry->package->name . "*\n";
        $message .= "📝 Detail: " . $inquiry->notes . "\n\n";
        $message .= "Apakah kuota untuk pesanan ini masih tersedia?";

        $waLink = "https://wa.me/" . $waNumber . "?text=" . urlencode($message);

        return view('booking.wa-redirect', compact('inquiry', 'waLink'));
    }
}