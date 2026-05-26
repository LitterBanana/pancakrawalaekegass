@extends('layouts.admin')
@section('title', 'Detail Galeri - HMI Tour')
@section('page_title', 'Detail Foto')
@section('page_subtitle', 'Lihat detail foto galeri')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title" style="font-size: var(--text-lg);">Detail Foto Galeri</h3>
        <div style="display: flex; gap: var(--space-2);">
            <a href="{{ route('admin.galleries.edit', $gallery->id) }}" class="btn btn-ghost btn-sm">Edit</a>
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-6);">
            <div>
                <h4 style="font-size: var(--text-lg); margin-bottom: var(--space-4);">Informasi Foto</h4>
                <div style="display: flex; flex-direction: column; gap: var(--space-3);">
                    <div>
                        <div class="form-hint" style="margin-bottom: 2px;">Caption</div>
                        <p style="margin: 0;">{{ $gallery->caption ?? 'Tidak ada caption' }}</p>
                    </div>
                    <div>
                        <div class="form-hint" style="margin-bottom: 2px;">Dibuat Pada</div>
                        <p style="margin: 0;">{{ $gallery->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <div class="form-hint" style="margin-bottom: 2px;">Diupdate Pada</div>
                        <p style="margin: 0;">{{ $gallery->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
            <div>
                <h4 style="font-size: var(--text-lg); margin-bottom: var(--space-4);">Gambar</h4>
                <img src="{{ asset('assets/images/' . $gallery->image) }}" alt="{{ $gallery->caption }}" style="width: 100%; height: 256px; object-fit: cover; border-radius: var(--radius-xl); border: 1px solid var(--color-border);">
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