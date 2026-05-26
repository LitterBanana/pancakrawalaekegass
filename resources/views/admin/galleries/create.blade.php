@extends('layouts.admin')
@section('title', 'Tambah Galeri - HMI Tour')
@section('page_title', 'Tambah Foto')
@section('page_subtitle', 'Upload foto galeri baru')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title" style="font-size: var(--text-lg);">Tambah Foto Galeri</h3>
        <a href="{{ route('admin.galleries.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Gambar (Maks 2MB)</label>
                <input type="file" name="image" accept="image/*" class="form-input" required>
                <div class="form-hint">Format: JPG, PNG, WEBP</div>
            </div>
            <div class="form-group">
                <label class="form-label">Keterangan / Caption (Opsional)</label>
                <input type="text" name="caption" class="form-input" placeholder="Cth: Jamaah di Masjidil Haram">
            </div>
            <div style="margin-top: var(--space-8);">
                <button type="submit" class="btn btn-primary btn-lg">Simpan Foto</button>
            </div>
        </form>
    </div>
</div>
@endsection