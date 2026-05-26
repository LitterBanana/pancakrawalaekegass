<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;

class DestinationController extends Controller
{
    // JALUR KERAS: Menembak langsung folder domain kedua
    private $hostingPath = '/home/whisefu1/hmitour.site/assets/images';

    public function index()
    {
        $destinations = Destination::latest()->get();
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            // Tambahkan webp di sini
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', 
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'nullable|string',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_dest_' . $image->getClientOriginalName();
            
            // Gunakan path hosting absolut
            $image->move($this->hostingPath, $imageName);
        }

        Destination::create([
            'name' => $request->name,
            'location' => $request->location,
            'image' => $imageName,
            'rating' => $request->rating,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);
        
        // Hapus file fisik menggunakan path absolut
        if ($destination->image && file_exists($this->hostingPath . '/' . $destination->image)) {
            unlink($this->hostingPath . '/' . $destination->image);
        }

        $destination->delete();
        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil dihapus!');
    }

    public function show($id)
    {
        $destination = Destination::findOrFail($id);
        return view('admin.destinations.show', compact('destination'));
    }

    public function edit($id)
    {
        $destination = Destination::findOrFail($id);
        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'nullable|string',
        ]);

        $destination = Destination::findOrFail($id);

        $imageName = $destination->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($destination->image && file_exists($this->hostingPath . '/' . $destination->image)) {
                unlink($this->hostingPath . '/' . $destination->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_dest_' . $image->getClientOriginalName();
            $image->move($this->hostingPath, $imageName);
        }

        $destination->update([
            'name' => $request->name,
            'location' => $request->location,
            'image' => $imageName,
            'rating' => $request->rating,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil diupdate!');
    }
}