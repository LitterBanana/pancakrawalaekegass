@extends('layouts.admin')
@section('title', 'Detail Destinasi - HMI Tour')
@section('page_title', 'Detail Destinasi')
@section('page_subtitle', $destination->name)

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title text-lg">Detail Destinasi</h3>
        <div class="flex gap-2">
            <a href="{{ route('admin.destinations.edit', $destination->id) }}" class="btn btn-ghost btn-sm">Edit</a>
            <a href="{{ route('admin.destinations.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <h4 class="text-lg mb-4">Informasi Destinasi</h4>
                <div class="flex flex-col gap-3">
                    <div>
                        <div class="form-hint mb-0.5">Nama Destinasi</div>
                        <p class="font-semibold m-0">{{ $destination->name }}</p>
                    </div>
                    <div>
                        <div class="form-hint mb-0.5">Lokasi</div>
                        <p class="m-0">{{ $destination->location }}</p>
                    </div>
                    <div>
                        <div class="form-hint mb-0.5">Rating</div>
                        <p class="m-0 text-amber-600">@for($i=0; $i<$destination->rating; $i++) ★ @endfor <span class="text-muted text-xs">({{ $destination->rating }})</span></p>
                    </div>
                    <div>
                        <div class="form-hint mb-0.5">Deskripsi</div>
                        <p class="m-0">{{ $destination->description }}</p>
                    </div>
                    <div>
                        <div class="form-hint mb-0.5">Dibuat Pada</div>
                        <p class="m-0">{{ $destination->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <div class="form-hint mb-0.5">Diupdate Pada</div>
                        <p class="m-0">{{ $destination->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="text-lg mb-4">Gambar Destinasi</h4>
                <img src="{{ asset('assets/images/' . $destination->image) }}" alt="{{ $destination->name }}" class="w-full h-64 object-cover rounded-xl border border-gray-200">
            </div>
        </div>
    </div>
</div>
@endsection