@extends('layouts.admin')
@section('title', 'Edit Destinasi - HMI Tour')
@section('page_title', 'Edit Destinasi')
@section('page_subtitle', 'Perbarui data destinasi')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title" style="font-size: var(--text-lg);">Edit Destinasi</h3>
        <a href="{{ route('admin.destinations.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.destinations.update', $destination->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Destinasi</label>
                <input type="text" name="name" value="{{ $destination->name }}" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Lokasi (Negara/Kota)</label>
                <input type="text" name="location" value="{{ $destination->location }}" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Rating (1-5)</label>
                <select name="rating" class="form-select" required>
                    <option value="5" {{ $destination->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 - Sangat Bagus)</option>
                    <option value="4" {{ $destination->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 - Bagus)</option>
                    <option value="3" {{ $destination->rating == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 - Standar)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Foto Destinasi</label>
                <input type="file" name="image" accept="image/*" class="form-input">
                <div class="form-hint">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                @if($destination->image)
                    <div style="margin-top: var(--space-2);">
                        <img src="{{ asset('assets/images/' . $destination->image) }}" alt="Current" style="width: 80px; height: 80px; object-fit: cover; border-radius: var(--radius-lg); border: 1px solid var(--color-border);">
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Singkat</label>
                <textarea name="description" rows="4" class="form-textarea">{{ $destination->description }}</textarea>
            </div>
            <div style="margin-top: var(--space-8);">
                <button type="submit" class="btn btn-primary btn-lg">Update Destinasi</button>
            </div>
        </form>
    </div>
</div>
@endsection