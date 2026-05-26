@extends('layouts.admin')
@section('title', 'Kelola Hotel - HMI Tour')
@section('page_title', 'Hotel')
@section('page_subtitle', 'Master data hotel')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title" style="font-size: var(--text-lg);">Master Data Hotel</h3>
        <a href="{{ route('admin.hotels.create') }}" class="btn btn-primary btn-sm">Tambah Hotel Baru</a>
    </div>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama Hotel</th>
                    <th>Kota</th>
                    <th>Bintang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hotels as $hotel)
                <tr>
                    <td class="font-semibold">{{ $hotel->name }}</td>
                    <td>
                        @if($hotel->city == 'Makkah')
                            <span class="badge badge-danger" style="background: #FDE8E8; color: #8B1A1A; border-color: #FACACB;">Makkah</span>
                        @elseif($hotel->city == 'Madinah')
                            <span class="badge badge-info">Madinah</span>
                        @else
                            <span class="badge badge-neutral">{{ $hotel->city }}</span>
                        @endif
                    </td>
                    <td style="color: var(--color-warning);">
                        @for($i=0; $i<$hotel->rating; $i++) ★ @endfor
                        <span class="text-muted" style="font-size: var(--text-xs);">({{ $hotel->rating }})</span>
                    </td>
                    <td><span class="badge badge-success">Aktif</span></td>
                    <td>
                        <div style="display: flex; gap: var(--space-2);">
                            <a href="{{ route('admin.hotels.edit', $hotel->id) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form action="{{ route('admin.hotels.destroy', $hotel->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus hotel ini?');" style="margin: 0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted" style="padding: var(--space-8);">Belum ada data hotel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection