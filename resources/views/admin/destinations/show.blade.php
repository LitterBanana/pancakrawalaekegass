@extends('layouts.admin')
@section('title', 'Detail Destinasi - HMI Tour')
@section('page_title', 'Detail Destinasi')
@section('page_subtitle', $destination->name)

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title" style="font-size: var(--text-lg);">Detail Destinasi</h3>
        <div style="display: flex; gap: var(--space-2);">
            <a href="{{ route('admin.destinations.edit', $destination->id) }}" class="btn btn-ghost btn-sm">Edit</a>
            <a href="{{ route('admin.destinations.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-6);">
            <div>
                <h4 style="font-size: var(--text-lg); margin-bottom: var(--space-4);">Informasi Destinasi</h4>
                <div style="display: flex; flex-direction: column; gap: var(--space-3);">
                    <div>
                        <div class="form-hint" style="margin-bottom: 2px;">Nama Destinasi</div>
                        <p class="font-semibold" style="margin: 0;">{{ $destination->name }}</p>
                    </div>
                    <div>
                        <div class="form-hint" style="margin-bottom: 2px;">Lokasi</div>
                        <p style="margin: 0;">{{ $destination->location }}</p>
                    </div>
                    <div>
                        <div class="form-hint" style="margin-bottom: 2px;">Rating</div>
                        <p style="margin: 0; color: var(--color-warning);">@for($i=0; $i<$destination->rating; $i++) ★ @endfor <span class="text-muted" style="font-size: var(--text-xs);">({{ $destination->rating }})</span></p>
                    </div>
                    <div>
                        <div class="form-hint" style="margin-bottom: 2px;">Deskripsi</div>
                        <p style="margin: 0;">{{ $destination->description }}</p>
                    </div>
                    <div>
                        <div class="form-hint" style="margin-bottom: 2px;">Dibuat Pada</div>
                        <p style="margin: 0;">{{ $destination->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <div class="form-hint" style="margin-bottom: 2px;">Diupdate Pada</div>
                        <p style="margin: 0;">{{ $destination->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
            <div>
                <h4 style="font-size: var(--text-lg); margin-bottom: var(--space-4);">Gambar Destinasi</h4>
                <img src="{{ asset('assets/images/' . $destination->image) }}" alt="{{ $destination->name }}" style="width: 100%; height: 256px; object-fit: cover; border-radius: var(--radius-xl); border: 1px solid var(--color-border);">
            </div>
        </div>
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