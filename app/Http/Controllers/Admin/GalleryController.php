<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;

class GalleryController extends Controller
{
    // Gunakan storage public folder (public/assets/images)
    private $storagePath = 'assets/images';

    public function index()
    {
        $galleries = Gallery::latest('created_at')->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_gallery_' . $image->getClientOriginalName();

            // Simpan ke public/assets/images
            $image->move(public_path($this->storagePath), $imageName);
        }

        Gallery::create([
            'image' => $imageName,
            'caption' => $request->caption,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Foto Galeri berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        // Hapus file fisik dari public/assets/images
        $filePath = public_path($this->storagePath . '/' . $gallery->image);
        if ($gallery->image && file_exists($filePath)) {
            unlink($filePath);
        }

        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Foto berhasil dihapus!');
    }

    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.galleries.show', compact('gallery'));
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $gallery = Gallery::findOrFail($id);

        $imageName = $gallery->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari public/assets/images
            $oldFilePath = public_path($this->storagePath . '/' . $gallery->image);
            if ($gallery->image && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $image = $request->file('image');
            $imageName = time() . '_gallery_' . $image->getClientOriginalName();
            $image->move(public_path($this->storagePath), $imageName);
        }

        $gallery->update([
            'image' => $imageName,
            'caption' => $request->caption,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Foto berhasil diupdate!');
    }
}