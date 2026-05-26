<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Gallery;
use App\Models\Destination; // WAJIB TAMBAHKAN INI

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil paket untuk grid utama (Hanya tampilkan 3 terbaru)
        $packages = Package::with(['category', 'prices'])
            ->where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        // 2. AMBIL DAFTAR SEMUA PAKET UNTUK DROPDOWN PENCARIAN
        // Kita hanya mengambil id dan nama agar query lebih ringan
        $searchPackages = Package::where('is_active', true)->select('id', 'name')->get();

        // 3. Ambil galeri & destinasi
        $galleries = Gallery::latest()->take(5)->get();
        $destinations = Destination::latest()->take(3)->get();

        // Kirim $searchPackages ke view
        return view('welcome', compact('packages', 'searchPackages', 'galleries', 'destinations'));
    }

    public function packages(Request $request)
    {
        // Mulai merangkai Query dasar
        $query = Package::with(['category', 'prices', 'hotelMakkah', 'hotelMadinah'])
            ->where('is_active', true);

        // 1. FILTER NAMA PAKET
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. FILTER DURASI (HARI)
        if ($request->filled('duration')) {
            $query->where('duration', $request->duration);
        }

        // 3. FILTER RATING HOTEL (BINTANG)
        if ($request->filled('hotel_rating')) {
            $rating = $request->hotel_rating;
            $query->where(function ($q) use ($rating) {
                $q->whereHas('hotelMakkah', function ($h) use ($rating) {
                    $h->where('rating', $rating);
                })->orWhereHas('hotelMadinah', function ($h) use ($rating) {
                    $h->where('rating', $rating);
                });
            });
        }

        // 4. FILTER KUOTA (PAX) - Otomatis menyembunyikan paket yang kursinya tidak cukup
        if ($request->filled('pax')) {
            $query->where('quota', '>=', $request->pax);
        }

        // 5. FILTER TANGGAL KEBERANGKATAN (Mulai dari tanggal X ke atas)
        if ($request->filled('departure_date')) {
            $query->whereDate('departure_date', '>=', $request->departure_date);
        }

        // 6. FILTER TANGGAL KEPULANGAN (Maksimal sampai tanggal Y)
        if ($request->filled('return_date')) {
            $query->whereDate('return_date', '<=', $request->return_date);
        }

        $packages = $query->get();

        // 7. SORTING (PENGURUTAN) HARGA
        if ($request->filled('sort')) {
            if ($request->sort == 'price_asc') {
                $packages = $packages->sortBy(function ($package) {
                    return $package->prices->min('price');
                });
            } elseif ($request->sort == 'price_desc') {
                $packages = $packages->sortByDesc(function ($package) {
                    return $package->prices->max('price');
                });
            }
        } else {
            $packages = $packages->sortByDesc('created_at');
        }

        return view('packages', compact('packages'));
    }
    public function showPackage($slug)
    {
        // Tambahkan 'hotelMakkah' dan 'hotelMadinah' ke dalam with()
        $package = \App\Models\Package::with(['prices', 'hotelMakkah', 'hotelMadinah'])->where('slug', $slug)->firstOrFail();

        return view('packages.show', compact('package'));
    }
    // Fungsi untuk menampilkan halaman About Us
    public function about()
    {
        return view('about');
    }
}