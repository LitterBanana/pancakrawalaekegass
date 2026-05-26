@extends('layouts.admin')
@section('title', 'Destinasi - HMI Tour')
@section('page_title', 'Destinasi')
@section('page_subtitle', 'Kelola destinasi & objek wisata')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title" style="font-size: var(--text-lg);">Destinasi & Objek Wisata</h3>
        <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary btn-sm">Tambah Destinasi</a>
    </div>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Destinasi</th>
                    <th>Lokasi</th>
                    <th>Rating</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($destinations as $dest)
                <tr>
                    <td><img src="{{ asset('assets/images/' . $dest->image) }}" alt="Dest" style="width: 80px; height: 50px; object-fit: cover; border-radius: var(--radius-md); border: 1px solid var(--color-border);"></td>
                    <td class="font-semibold">{{ $dest->name }}</td>
                    <td>{{ $dest->location }}</td>
                    <td style="color: var(--color-warning);">{{ $dest->rating }} ★</td>
                    <td>
                        <div style="display: flex; gap: var(--space-2);">
                            <a href="{{ route('admin.destinations.show', $dest->id) }}" class="btn btn-ghost btn-sm">Lihat</a>
                            <a href="{{ route('admin.destinations.edit', $dest->id) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form action="{{ route('admin.destinations.destroy', $dest->id) }}" method="POST" onsubmit="return confirm('Hapus destinasi ini?');" style="margin: 0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted" style="padding: var(--space-8);">Belum ada destinasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection