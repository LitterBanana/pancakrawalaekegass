@extends('layouts.admin')
@section('title', 'Tambah Destinasi - HMI Tour')
@section('page_title', 'Tambah Destinasi')
@section('page_subtitle', 'Tambahkan destinasi baru')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title text-lg">Tambah Destinasi Baru</h3>
        <a href="{{ route('admin.destinations.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Destinasi</label>
                <input type="text" name="name" class="form-input" placeholder="Cth: Burj Khalifa" required>
            </div>
            <div class="form-group">
                <label class="form-label">Lokasi (Negara/Kota)</label>
                <input type="text" name="location" class="form-input" placeholder="Cth: Dubai, UEA" required>
            </div>
            <div class="form-group">
                <label class="form-label">Rating (1-5)</label>
                <select name="rating" class="form-select" required>
                    <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Bagus)</option>
                    <option value="4">⭐⭐⭐⭐ (4 - Bagus)</option>
                    <option value="3">⭐⭐⭐ (3 - Standar)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Foto Destinasi</label>
                <input type="file" name="image" accept="image/*" class="form-input" required>
                <div class="form-hint">Format: JPG, PNG, WEBP (Max 2MB)</div>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Singkat</label>
                <textarea name="description" rows="4" class="form-textarea" placeholder="Ceritakan sedikit tentang tempat ini..."></textarea>
            </div>
            <div class="mt-8">
                <button type="submit" class="btn btn-primary btn-lg">Simpan Destinasi</button>
            </div>
        </form>
    </div>
</div>
@endsection