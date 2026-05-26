@extends('layouts.admin')
@section('title', 'Detail Invoice - HMI Tour')
@section('page_title', 'Detail Invoice')
@section('page_subtitle', 'Invoice #INV-' . $invoice->id)

@section('content')
    <div style="max-width: 900px; margin: 0 auto;">
        <div class="card animate-fade-in-up">
            <div class="card-header">
                <h3 class="section-title" style="font-size: var(--text-lg);">Invoice #INV-{{ $invoice->id }}</h3>
                <a href="{{ route('admin.invoice.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-6); margin-bottom: var(--space-6);">
                    <div>
                        <h4 class="font-semibold mb-2">Informasi Jamaah</h4>
                        <p style="font-size: var(--text-sm); color: var(--color-text-muted);">Nama: {{ $invoice->customer_name }}</p>
                        <p style="font-size: var(--text-sm); color: var(--color-text-muted);">Telepon: {{ $invoice->phone }}</p>
                        <p style="font-size: var(--text-sm); color: var(--color-text-muted);">Email: {{ $invoice->email ?? '-' }}</p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Detail Paket</h4>
                        <p style="font-size: var(--text-sm); color: var(--color-text-muted);">Paket: {{ $invoice->package->name ?? '-' }}</p>
                        <p style="font-size: var(--text-sm); color: var(--color-text-muted);">Jumlah Orang: {{ $invoice->jumlah_orang }}</p>
                        <p style="font-size: var(--text-sm); color: var(--color-text-muted);">Tanggal Booking: {{ $invoice->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--color-border); padding-top: var(--space-6);">
                    <h4 class="font-semibold mb-4">Riwayat Pembayaran</h4>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoice->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date->format('d M Y') }}</td>
                                        <td>IDR {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                        <td>{{ ucfirst($payment->payment_method) }} {{ $payment->bank_name ? '('.$payment->bank_name.')' : '' }}</td>
                                        <td>
                                            @if($payment->status === 'sudah_lunas')
                                                <span class="badge badge-success">Lunas</span>
                                            @elseif($payment->status === 'belum_lunas')
                                                <span class="badge badge-warning">Pending</span>
                                            @else
                                                <span class="badge badge-danger">Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted" style="padding: var(--space-4);">Belum ada pembayaran.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--color-border); padding-top: var(--space-6); margin-top: var(--space-6); display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="font-size: var(--text-sm); color: var(--color-text-muted); margin-bottom: var(--space-1);">Total Pembayaran</p>
                        <p style="font-size: var(--text-2xl); font-weight: var(--font-bold); margin: 0;">IDR {{ number_format($invoice->total_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.invoice.download', $invoice->id) }}" class="btn btn-primary">Download Invoice</a>
                    </div>
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