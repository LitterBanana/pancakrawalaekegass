@extends('layouts.admin')
@section('title', 'Detail Galeri - HMI Tour')
@section('page_title', 'Detail Foto')
@section('page_subtitle', 'Lihat detail foto galeri')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title text-lg">Detail Foto Galeri</h3>
        <div class="flex gap-2">
            <a href="{{ route('admin.galleries.edit', $gallery->id) }}" class="btn btn-ghost btn-sm">Edit</a>
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <h4 class="text-lg mb-4">Informasi Foto</h4>
                <div class="flex flex-col gap-3">
                    <div>
                        <div class="form-hint mb-0.5">Caption</div>
                        <p class="m-0">{{ $gallery->caption ?? 'Tidak ada caption' }}</p>
                    </div>
                    <div>
                        <div class="form-hint mb-0.5">Dibuat Pada</div>
                        <p class="m-0">{{ $gallery->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <div class="form-hint mb-0.5">Diupdate Pada</div>
                        <p class="m-0">{{ $gallery->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="text-lg mb-4">Gambar</h4>
                <img src="{{ asset('assets/images/' . $gallery->image) }}" alt="{{ $gallery->caption }}" class="w-full h-64 object-cover rounded-xl border border-gray-200">
            </div>
        </div>
    </div>
</div>
@endsection