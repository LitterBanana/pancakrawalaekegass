@extends('layouts.admin')
@section('title', 'Edit Paket - HMI Tour')
@section('page_title', 'Edit Paket')
@section('page_subtitle', 'Perbarui data paket umrah')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title" style="font-size: var(--text-lg);">Edit Paket: {{ $package->name }}</h3>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-5);">
                <div class="form-group">
                    <label class="form-label">Nama Paket</label>
                    <input type="text" name="name" value="{{ old('name', $package->name) }}" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $package->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: var(--space-5);">
                <div class="form-group">
                    <label class="form-label">Lokasi Keberangkatan</label>
                    <input type="text" name="departure_location" value="{{ old('departure_location', $package->departure_location) }}" class="form-input" placeholder="Cth: Jakarta (CGK)">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Keberangkatan</label>
                    <input type="date" name="departure_date" value="{{ old('departure_date', $package->departure_date) }}" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Durasi (Hari)</label>
                    <input type="number" name="duration" value="{{ old('duration', $package->duration) }}" class="form-input" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Kuota Seat</label>
                <input type="number" name="quota" value="{{ old('quota', $package->quota) }}" class="form-input" required>
            </div>

            <h4 style="margin: var(--space-6) 0 var(--space-4); color: var(--color-text-muted); border-bottom: 1px solid var(--color-border); padding-bottom: var(--space-2);">Akomodasi & Transportasi</h4>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: var(--space-5);">
                <div class="form-group">
                    <label class="form-label">Hotel Makkah</label>
                    <select name="hotel_makkah_id" class="form-select" required>
                        <option value="">-- Pilih Hotel --</option>
                        @foreach ($hotels as $hotel)
                            @if(strtolower($hotel->city) == 'makkah')
                                <option value="{{ $hotel->id }}" {{ $package->hotel_makkah_id == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }} ({{ $hotel->rating }} Bintang)</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Hotel Madinah</label>
                    <select name="hotel_madinah_id" class="form-select" required>
                        <option value="">-- Pilih Hotel --</option>
                        @foreach ($hotels as $hotel)
                            @if(strtolower($hotel->city) == 'madinah')
                                <option value="{{ $hotel->id }}" {{ $package->hotel_madinah_id == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }} ({{ $hotel->rating }} Bintang)</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Maskapai Penerbangan</label>
                    <select name="airline" class="form-select" required>
                        <option value="">-- Pilih Maskapai --</option>
                        @php $airlines = ['Saudia Airlines', 'Garuda Indonesia', 'Lion Air', 'Emirates', 'Qatar Airways', 'Etihad Airways', 'Oman Air', 'Lainnya']; @endphp
                        @foreach($airlines as $airline)
                            <option value="{{ $airline }}" {{ $package->airline == $airline ? 'selected' : '' }}>{{ $airline }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h4 style="margin: var(--space-6) 0 var(--space-4); color: var(--color-text-muted); border-bottom: 1px solid var(--color-border); padding-bottom: var(--space-2);">Pengaturan Harga (Per Orang)</h4>

            @php
                $priceQuad = $package->prices->where('type', 'Quad')->first()->price ?? '';
                $priceTriple = $package->prices->where('type', 'Triple')->first()->price ?? '';
                $priceDouble = $package->prices->where('type', 'Double')->first()->price ?? '';
            @endphp

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: var(--space-5);">
                <div class="form-group">
                    <label class="form-label">Kamar Quad (Ber-4) <span class="required">*</span></label>
                    <input type="number" name="price_quad" value="{{ old('price_quad', $priceQuad) }}" class="form-input" required placeholder="Wajib diisi">
                </div>
                <div class="form-group">
                    <label class="form-label">Kamar Triple (Ber-3)</label>
                    <input type="number" name="price_triple" value="{{ old('price_triple', $priceTriple) }}" class="form-input" placeholder="Opsional">
                </div>
                <div class="form-group">
                    <label class="form-label">Kamar Double (Ber-2)</label>
                    <input type="number" name="price_double" value="{{ old('price_double', $priceDouble) }}" class="form-input" placeholder="Opsional">
                </div>
            </div>

            <h4 style="margin: var(--space-6) 0 var(--space-4); color: var(--color-text-muted); border-bottom: 1px solid var(--color-border); padding-bottom: var(--space-2);">Media & Detail</h4>

            <div class="form-group">
                <label class="form-label">Gambar Thumbnail (Biarkan kosong jika tidak ingin mengubah)</label>
                @if($package->thumbnail)
                    <div style="margin-bottom: var(--space-3);">
                        <img src="{{ asset('assets/images/' . $package->thumbnail) }}" alt="Preview" style="height: 100px; border-radius: var(--radius-lg); border: 1px solid var(--color-border);">
                        <div class="form-hint">Gambar saat ini</div>
                    </div>
                @endif
                <input type="file" name="thumbnail" accept="image/*" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Singkat</label>
                <textarea name="description" rows="4" class="form-textarea" required>{{ old('description', $package->description) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Itinerary (Jadwal Perjalanan)</label>
                <textarea name="itinerary" rows="6" class="form-textarea">{{ old('itinerary', $package->itinerary) }}</textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-5);">
                <div class="form-group">
                    <label class="form-label">Termasuk (Include)</label>
                    <textarea name="include_facility" rows="5" class="form-textarea">{{ old('include_facility', $package->include_facility) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Tidak Termasuk (Exclude)</label>
                    <textarea name="exclude_facility" rows="5" class="form-textarea">{{ old('exclude_facility', $package->exclude_facility) }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Syarat & Ketentuan</label>
                <textarea name="terms_conditions" rows="4" class="form-textarea">{{ old('terms_conditions', $package->terms_conditions) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Status Publikasi</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ $package->is_active == 1 ? 'selected' : '' }}>Aktif (Tampil di Web)</option>
                    <option value="0" {{ $package->is_active == 0 ? 'selected' : '' }}>Non-Aktif (Sembunyikan)</option>
                </select>
            </div>

            <div style="margin-top: var(--space-8); padding-top: var(--space-5); border-top: 1px solid var(--color-border);">
                <button type="submit" class="btn btn-primary btn-full btn-lg">Simpan Perubahan Paket</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    @media (max-width: 768px) {
        [style*="grid-template-columns: 1fr 1fr 1fr"] { grid-template-columns: 1fr !important; }
        [style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
    }
</style>
@endpush
@endsection