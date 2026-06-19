@extends('layouts.admin')
@section('title', 'Destinasi - HMI Tour')
@section('page_title', 'Destinasi')
@section('page_subtitle', 'Kelola destinasi & objek wisata')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title text-lg">Destinasi & Objek Wisata</h3>
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
                    <td><img src="{{ asset('assets/images/' . $dest->image) }}" alt="Dest" class="w-20 h-[50px] object-cover rounded-md border border-gray-200"></td>
                    <td class="font-semibold">{{ $dest->name }}</td>
                    <td>{{ $dest->location }}</td>
                    <td class="text-amber-600">{{ $dest->rating }} ★</td>
                    <td>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.destinations.show', $dest->id) }}" class="btn btn-ghost btn-sm">Lihat</a>
                            <a href="{{ route('admin.destinations.edit', $dest->id) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form action="{{ route('admin.destinations.destroy', $dest->id) }}" method="POST" onsubmit="return confirm('Hapus destinasi ini?');" class="m-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted p-8">Belum ada destinasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection