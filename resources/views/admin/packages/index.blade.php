@extends('layouts.admin')
@section('title', 'Kelola Paket - HMI Tour')
@section('page_title', 'Paket Umrah')
@section('page_subtitle', 'Master data paket umrah')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title" style="font-size: var(--text-lg);">Master Data Paket Umrah</h3>
        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary btn-sm">Tambah Paket Baru</a>
    </div>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Paket</th>
                    <th>Keberangkatan</th>
                    <th>Harga (Quad)</th>
                    <th>Sisa Seat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $package)
                <tr>
                    <td>
                        <img src="{{ asset('assets/images/' . $package->thumbnail) }}" alt="Thumbnail" style="width: 60px; height: 40px; object-fit: cover; border-radius: var(--radius-md); border: 1px solid var(--color-border);">
                    </td>
                    <td>
                        <div class="font-semibold">{{ $package->name }}</div>
                        <div style="font-size: var(--text-xs); color: var(--color-text-muted);">{{ $package->duration }} Hari | {{ $package->airline }}</div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($package->departure_date)->format('d M Y') }}</td>
                    <td class="font-semibold" style="color: var(--color-primary);">
                        IDR {{ number_format($package->prices->where('type', 'Quad')->first()->price ?? 0, 0, ',', '.') }}
                    </td>
                    <td><span class="badge badge-info">{{ $package->quota }}</span></td>
                    <td>
                        @if($package->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-neutral">Non-Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: var(--space-2); align-items: center;">
                            <a href="{{ route('admin.packages.show', $package->id) }}" class="btn btn-ghost btn-sm">Lihat</a>
                            <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Yakin hapus paket ini?');" style="margin: 0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted" style="padding: var(--space-8);">Belum ada paket tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection