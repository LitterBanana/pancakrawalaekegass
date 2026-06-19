@extends('layouts.admin')
@section('title', 'Edit Galeri - HMI Tour')
@section('page_title', 'Edit Foto')
@section('page_subtitle', 'Perbarui foto galeri')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title text-lg">Edit Foto Galeri</h3>
        <a href="{{ route('admin.galleries.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Gambar (Maks 2MB)</label>
                <input type="file" name="image" accept="image/*" class="form-input">
                <div class="form-hint">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                @if($gallery->image)
                    <div class="mt-2">
                        <img src="{{ asset('assets/images/' . $gallery->image) }}" alt="Current" class="w-32 h-20 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="form-label">Keterangan / Caption (Opsional)</label>
                <input type="text" name="caption" value="{{ $gallery->caption }}" class="form-input" placeholder="Cth: Jamaah di Masjidil Haram">
            </div>
            <div class="mt-8">
                <button type="submit" class="btn btn-primary btn-lg">Update Foto</button>
            </div>
        </form>
    </div>
</div>
@endsection