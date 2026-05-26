@extends('layouts.admin')
@section('title', 'Tambah Paket Baru - HMI Tour')
@section('page_title', 'Tambah Paket')
@section('page_subtitle', 'Buat paket tour baru')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title" style="font-size: var(--text-lg);">Tambah Paket Tour Baru</h3>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div style="background: var(--color-danger-bg); color: var(--color-danger); padding: var(--space-4) var(--space-6); border-radius: var(--radius-xl); margin-bottom: var(--space-6); border: 1px solid var(--color-danger-border);">
                <strong>Data Gagal Disimpan:</strong>
                <ul style="margin: var(--space-2) 0 0; padding-left: var(--space-5);">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="category_id" required class="form-select">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Paket</label>
                <input type="text" name="name" required placeholder="Cth: Umroh Plus Turki" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Singkat</label>
                <textarea name="description" required class="form-textarea"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Lokasi Keberangkatan</label>
                <input type="text" name="departure_location" placeholder="Cth: Jakarta (CGK)" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Fasilitas Termasuk (Include)</label>
                <textarea name="include_facility" rows="4" placeholder="Gunakan tanda strip (-) untuk daftar." class="form-textarea"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Fasilitas Tidak Termasuk (Exclude)</label>
                <textarea name="exclude_facility" rows="4" placeholder="Cth:&#10;- Pembuatan Paspor" class="form-textarea"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Jadwal Perjalanan (Itinerary)</label>
                <textarea name="itinerary" rows="8" placeholder="Tulis jadwal lengkap di sini..." class="form-textarea"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Syarat & Ketentuan</label>
                <textarea name="terms_conditions" rows="5" placeholder="Tulis syarat pendaftaran..." class="form-textarea"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-5);">
                <div class="form-group">
                    <label class="form-label">Tanggal Keberangkatan</label>
                    <input type="date" name="departure_date" required class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Kepulangan</label>
                    <input type="date" name="return_date" required class="form-input">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-5);">
                <div class="form-group">
                    <label class="form-label">Durasi (Hari)</label>
                    <input type="number" name="duration" required class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Kuota Jamaah</label>
                    <input type="number" name="quota" required class="form-input">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-5);">
                <div class="form-group">
                    <label class="form-label">Hotel Makkah</label>
                    <select name="hotel_makkah_id" required class="form-select">
                        <option value="">-- Pilih Hotel Makkah --</option>
                        @foreach ($hotelsMakkah as $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->name }} (Bintang {{ $hotel->rating }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Hotel Madinah</label>
                    <select name="hotel_madinah_id" required class="form-select">
                        <option value="">-- Pilih Hotel Madinah --</option>
                        @foreach ($hotelsMadinah as $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->name }} (Bintang {{ $hotel->rating }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Maskapai Penerbangan</label>
                <select name="airline" required class="form-select">
                    <option value="">-- Pilih Maskapai --</option>
                    <option value="Saudia Airlines">Saudia Airlines</option>
                    <option value="Garuda Indonesia">Garuda Indonesia</option>
                    <option value="Lion Air">Lion Air</option>
                    <option value="Emirates">Emirates</option>
                    <option value="Qatar Airways">Qatar Airways</option>
                    <option value="Etihad Airways">Etihad Airways</option>
                    <option value="Oman Air">Oman Air</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: var(--space-5);">
                <div class="form-group">
                    <label class="form-label">Harga Kamar Quad (Ber-4) <span class="required">*</span></label>
                    <input type="number" name="price_quad" required placeholder="Cth: 28000000" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Kamar Triple (Ber-3)</label>
                    <input type="number" name="price_triple" placeholder="Opsional" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Kamar Double (Ber-2)</label>
                    <input type="number" name="price_double" placeholder="Opsional" class="form-input">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Gambar Thumbnail Paket</label>
                <input type="file" name="thumbnail" accept="image/*" required class="form-input">
            </div>

            <div style="margin-top: var(--space-8); padding-top: var(--space-5); border-top: 1px solid var(--color-border);">
                <button type="submit" class="btn btn-primary btn-full btn-lg">Simpan Paket</button>
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
