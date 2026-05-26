<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Category;
use App\Models\Hotel;

class PackageController extends Controller
{
    // DEFINISI PATH HOSTING SECARA MANUAL (JALUR KERAS)
    // Sesuaikan ini jika nanti nama folder berubah
    private $hostingPath = '/home/whisefu1/hmitour.site/assets/images';

    public function index()
    {
        $packages = Package::with('category')->latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $hotelsMakkah = Hotel::where('city', 'Makkah')->where('is_active', true)->get();
        $hotelsMadinah = Hotel::where('city', 'Madinah')->where('is_active', true)->get();

        return view('admin.packages.create', compact('categories', 'hotelsMakkah', 'hotelsMadinah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required',
            'departure_location' => 'nullable|string|max:255',
            'include_facility' => 'nullable|string',
            'exclude_facility' => 'nullable|string',
            'itinerary' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after:departure_date',
            'duration' => 'required|integer',
            'quota' => 'required|integer',
            'hotel_makkah_id' => 'required|exists:hotels,id',
            'hotel_madinah_id' => 'required|exists:hotels,id',
            'airline' => 'required|string|max:255',
            'price_quad' => 'required|numeric',
            'price_triple' => 'nullable|numeric',
            'price_double' => 'nullable|numeric',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            // PERBAIKAN: Gunakan Path Hosting Absolut
            $image->move($this->hostingPath, $imageName);
        }

        $package = Package::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'departure_location' => $request->departure_location,
            'include_facility' => $request->include_facility,
            'exclude_facility' => $request->exclude_facility,
            'itinerary' => $request->itinerary,
            'terms_conditions' => $request->terms_conditions,
            'departure_date' => $request->departure_date,
            'return_date' => $request->return_date,
            'duration' => $request->duration,
            'quota' => $request->quota,
            'hotel_makkah_id' => $request->hotel_makkah_id,
            'hotel_madinah_id' => $request->hotel_madinah_id,
            'airline' => $request->airline,
            'thumbnail' => $imageName,
        ]);

        \App\Models\PackagePrice::create([
            'package_id' => $package->id,
            'type' => 'Quad',
            'price' => $request->price_quad,
            'currency' => 'IDR'
        ]);

        if ($request->filled('price_triple')) {
            \App\Models\PackagePrice::create([
                'package_id' => $package->id,
                'type' => 'Triple',
                'price' => $request->price_triple,
                'currency' => 'IDR'
            ]);
        }

        if ($request->filled('price_double')) {
            \App\Models\PackagePrice::create([
                'package_id' => $package->id,
                'type' => 'Double',
                'price' => $request->price_double,
                'currency' => 'IDR'
            ]);
        }

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $package = Package::with('prices')->findOrFail($id);
        $categories = Category::all();
        $hotels = Hotel::all();

        return view('admin.packages.edit', compact('package', 'categories', 'hotels'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'departure_date' => 'required|date',
            'duration' => 'required|integer',
            'quota' => 'required|integer',
            'hotel_makkah_id' => 'required',
            'hotel_madinah_id' => 'required',
            'price_quad' => 'required|numeric',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['thumbnail', 'price_quad', 'price_triple', 'price_double']);
        
        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama jika ada
            if ($package->thumbnail && file_exists($this->hostingPath . '/' . $package->thumbnail)) {
                unlink($this->hostingPath . '/' . $package->thumbnail);
            }

            $imageName = time() . '.' . $request->thumbnail->extension();
            
            // PERBAIKAN: Gunakan Path Hosting Absolut
            $request->thumbnail->move($this->hostingPath, $imageName);
            
            $data['thumbnail'] = $imageName;
        }

        $package->update($data);

        $package->prices()->delete();

        $package->prices()->create([
            'type' => 'Quad',
            'price' => $request->price_quad
        ]);

        if ($request->filled('price_triple')) {
            $package->prices()->create([
                'type' => 'Triple',
                'price' => $request->price_triple
            ]);
        }

        if ($request->filled('price_double')) {
            $package->prices()->create([
                'type' => 'Double',
                'price' => $request->price_double
            ]);
        }

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil diperbarui');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);

        // PERBAIKAN: Gunakan Path Hosting Absolut untuk menghapus
        if ($package->thumbnail && file_exists($this->hostingPath . '/' . $package->thumbnail)) {
            unlink($this->hostingPath . '/' . $package->thumbnail);
        }

        $package->delete(); 
        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dihapus!');
    }
}