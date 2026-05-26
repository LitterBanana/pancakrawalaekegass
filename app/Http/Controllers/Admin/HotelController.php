<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::latest()->get();
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('admin.hotels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|in:Makkah,Madinah,Lainnya',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Hotel::create([
            'name' => $request->name,
            'city' => $request->city,
            'rating' => $request->rating,
            'is_active' => true,
        ]);

        // Redirect ke rute admin yang benar
        return redirect()->route('admin.hotels.index')->with('success', 'Hotel baru berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        
        // Cek apakah hotel sedang dipakai di paket (Opsional, untuk keamanan data)
        if ($hotel->packages()->exists()) {
             return redirect()->route('admin.hotels.index')->with('error', 'Gagal hapus! Hotel ini sedang digunakan oleh Paket Umrah.');
        }

        $hotel->delete();
        return redirect()->route('admin.hotels.index')->with('success', 'Hotel berhasil dihapus.');
    }

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('admin.hotels.show', compact('hotel'));
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|in:Makkah,Madinah,Lainnya',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $hotel = Hotel::findOrFail($id);
        $hotel->update([
            'name' => $request->name,
            'city' => $request->city,
            'rating' => $request->rating,
        ]);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel berhasil diupdate.');
    }
}