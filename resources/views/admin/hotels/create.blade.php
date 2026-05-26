@extends('layouts.admin')
@section('title', 'Tambah Hotel - HMI Tour')
@section('page_title', 'Tambah Hotel')
@section('page_subtitle', 'Tambah hotel baru')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title" style="font-size: var(--text-lg);">Tambah Hotel Baru</h3>
        <a href="{{ route('admin.hotels.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.hotels.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Hotel</label>
                <input type="text" name="name" class="form-input" placeholder="Cth: Pullman Zamzam" required>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-5);">
                <div class="form-group">
                    <label class="form-label">Lokasi Kota</label>
                    <select name="city" class="form-select" required>
                        <option value="Makkah">Makkah</option>
                        <option value="Madinah">Madinah</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Rating (Bintang)</label>
                    <select name="rating" class="form-select" required>
                        <option value="5">⭐⭐⭐⭐⭐ (Bintang 5)</option>
                        <option value="4">⭐⭐⭐⭐ (Bintang 4)</option>
                        <option value="3">⭐⭐⭐ (Bintang 3)</option>
                        <option value="2">⭐⭐ (Bintang 2)</option>
                        <option value="1">⭐ (Bintang 1)</option>
                    </select>
                </div>
            </div>
            <div style="margin-top: var(--space-8);">
                <button type="submit" class="btn btn-primary btn-lg">Simpan Hotel</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    @media (max-width: 768px) {
        [style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
    }
</style>
@endpush
@endsection