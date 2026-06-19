@extends('layouts.admin')
@section('title', 'Galeri - HMI Tour')
@section('page_title', 'Galeri')
@section('page_subtitle', 'Kelola foto kegiatan')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title text-lg">Galeri Foto Kegiatan</h3>
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary btn-sm">Upload Foto</a>
    </div>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Preview</th>
                    <th>Caption</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galleries as $index => $gallery)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><img src="{{ asset('assets/images/' . $gallery->image) }}" alt="Gallery" class="w-20 h-[50px] object-cover rounded-md border border-gray-200"></td>
                    <td>{{ $gallery->caption ?? '-' }}</td>
                    <td>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.galleries.show', $gallery->id) }}" class="btn btn-ghost btn-sm">Lihat</a>
                            <a href="{{ route('admin.galleries.edit', $gallery->id) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini?');" class="m-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted p-8">Galeri kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection