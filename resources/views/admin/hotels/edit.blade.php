@extends('layouts.admin')
@section('title', 'Edit Hotel - HMI Tour')
@section('page_title', 'Edit Hotel')
@section('page_subtitle', 'Edit data hotel')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title text-lg">Edit Data Hotel</h3>
        <a href="{{ route('admin.hotels.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.hotels.update', $hotel->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Nama Hotel</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $hotel->name) }}" placeholder="Cth: Pullman Zamzam" required>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="form-group">
                    <label class="form-label">Lokasi Kota</label>
                    <select name="city" class="form-select" required>
                        <option value="Makkah" {{ old('city', $hotel->city) == 'Makkah' ? 'selected' : '' }}>Makkah</option>
                        <option value="Madinah" {{ old('city', $hotel->city) == 'Madinah' ? 'selected' : '' }}>Madinah</option>
                        <option value="Lainnya" {{ old('city', $hotel->city) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Rating (Bintang)</label>
                    <select name="rating" class="form-select" required>
                        <option value="5" {{ old('rating', $hotel->rating) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (Bintang 5)</option>
                        <option value="4" {{ old('rating', $hotel->rating) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (Bintang 4)</option>
                        <option value="3" {{ old('rating', $hotel->rating) == 3 ? 'selected' : '' }}>⭐⭐⭐ (Bintang 3)</option>
                        <option value="2" {{ old('rating', $hotel->rating) == 2 ? 'selected' : '' }}>⭐⭐ (Bintang 2)</option>
                        <option value="1" {{ old('rating', $hotel->rating) == 1 ? 'selected' : '' }}>⭐ (Bintang 1)</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-8">
                <button type="submit" class="btn btn-primary btn-full">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
