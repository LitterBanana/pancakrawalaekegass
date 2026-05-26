@extends('layouts.admin')
@section('title', 'Data Pesanan - HMI Tour')
@section('page_title', 'Pesanan')
@section('page_subtitle', 'Daftar seluruh transaksi masuk')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title" style="font-size: var(--text-lg);">Daftar Transaksi Masuk</h3>
    </div>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal Booking</th>
                    <th>Nama Jamaah</th>
                    <th>Paket Dipilih</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td style="color: var(--color-text-muted);">#{{ $booking->id }}</td>
                    <td>{{ $booking->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="font-semibold">{{ $booking->customer_name }}</span>
                        <div style="font-size: var(--text-xs); color: var(--color-text-muted);">{{ $booking->customer_phone }}</div>
                    </td>
                    <td>{{ $booking->package->name ?? 'Paket Terhapus' }}</td>
                    <td class="font-semibold">IDR {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    <td>
                        @if($booking->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($booking->status == 'dicicil')
                            <span class="badge badge-info">Dicicil</span>
                        @elseif($booking->status == 'paid')
                            <span class="badge badge-success">Lunas</span>
                        @else
                            <span class="badge badge-danger">Batal</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-secondary btn-sm">Detail & Pembayaran</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted" style="padding: var(--space-8);">Belum ada data pesanan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection