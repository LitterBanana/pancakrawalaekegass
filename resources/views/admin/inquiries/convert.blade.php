@extends('layouts.admin')
@section('title', 'Proses Booking - HMI Tour')
@section('page_title', 'Konversi Prospek')
@section('page_subtitle', 'Ubah prospek menjadi booking')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title" style="font-size: var(--text-lg);">Konversi Prospek ke Booking</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm">Batal</a>
    </div>
    <div class="card-body">
        <div style="background: var(--color-info-bg); border: 1px solid var(--color-info-border); padding: var(--space-4); border-radius: var(--radius-xl); margin-bottom: var(--space-6); color: var(--color-info);">
            <strong>Data dari Inquiry:</strong> {{ $inquiry->name }} ({{ $inquiry->phone }})
        </div>

        <form action="{{ route('admin.inquiry.process_convert', $inquiry->id) }}" method="POST">
            @csrf
            <input type="hidden" name="customer_name" value="{{ $inquiry->name }}">
            <input type="hidden" name="customer_phone" value="{{ $inquiry->phone }}">

            <div class="form-group">
                <label class="form-label">Pilih Paket Umrah</label>
                <select name="package_id" class="form-select" required>
                    <option value="">-- Pilih Paket --</option>
                    @foreach($packages as $package)
                        <option value="{{ $package->id }}" {{ ($inquiry->package_id == $package->id) ? 'selected' : '' }}>
                            {{ $package->name }} (Sisa Seat: {{ $package->quota }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-5);">
                <div class="form-group">
                    <label class="form-label">Tipe Kamar</label>
                    <select name="room_type" class="form-select" required>
                        <option value="Quad">Quad (Sekamar Ber-4)</option>
                        <option value="Triple">Triple (Sekamar Ber-3)</option>
                        <option value="Double">Double (Sekamar Ber-2)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah Jamaah</label>
                    <input type="number" name="quantity" class="form-input" value="1" min="1" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Catatan Tambahan</label>
                <textarea name="notes" class="form-textarea" rows="3" placeholder="Contoh: Jamaah req kursi roda, dll"></textarea>
            </div>

            <div style="margin-top: var(--space-8);">
                <button type="submit" class="btn btn-primary btn-full btn-lg">Buat Pesanan & Tagihan</button>
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