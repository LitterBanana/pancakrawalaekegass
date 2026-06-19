@extends('layouts.admin')
@section('title', 'Pembayaran - HMI Tour')
@section('page_title', 'Pembayaran')
@section('page_subtitle', 'Riwayat seluruh pembayaran jamaah')

@push('styles')
<style>
    .payment-dashboard-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 1024px) {
        .payment-dashboard-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .payment-dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    .payment-filter-panel {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 1rem;
        align-items: center;
        background: var(--color-bg);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-2xl);
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .payment-filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: center;
    }

    .payment-filter-group .form-select {
        min-width: 180px;
    }

    .payment-action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .payment-summary-card {
        min-height: 160px;
    }

    .invoice-table-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .data-table th,
    .data-table td {
        padding: 1rem 1.25rem;
    }

    .data-table tbody tr:hover {
        background: var(--color-primary-50);
    }

    .card-body {
        padding-top: 0;
    }
</style>
@endpush

@section('content')
    <div class="payment-dashboard-grid animate-fade-in-up">
        <div class="stat-card payment-summary-card">
            <div class="stat-card-label">Total Pemasukan</div>
            <div class="stat-card-value" style="color: var(--color-success);">IDR {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card payment-summary-card">
            <div class="stat-card-label">Total Transaksi</div>
            <div class="stat-card-value">{{ $totalTransaksi }}</div>
        </div>
        <div class="stat-card payment-summary-card">
            <div class="stat-card-label">Pembayaran Bulan Ini</div>
            <div class="stat-card-value">{{ $paymentsThisMonth }}</div>
        </div>
        <div class="stat-card payment-summary-card">
            <div class="stat-card-label">Belum Lunas</div>
            <div class="stat-card-value">{{ $pendingPayments }}</div>
        </div>
    </div>

    <div class="card animate-fade-in-up delay-1">
        <div class="card-header" style="padding-bottom: 1rem; gap: 1rem; flex-wrap: wrap;">
            <div>
                <h3 class="section-title" style="font-size: var(--text-lg);">Riwayat Semua Pembayaran</h3>
                <p style="margin: 0; color: var(--color-text-secondary);">Kelola semua permintaan pembayaran jamaah dengan filter cepat dan ekspor laporan.</p>
            </div>
            <div class="payment-action-buttons">
                <a href="{{ route('admin.payments.export', request()->all()) }}" class="btn btn-success btn-sm">Export Excel</a>
                <a href="{{ route('admin.payments.export_pdf', request()->all()) }}" target="_blank" class="btn btn-secondary btn-sm">Export PDF</a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.payments.index') }}" method="GET" class="payment-filter-panel">
                <div class="payment-filter-group">
                    <label class="form-label" style="margin-bottom: 0;">Metode</label>
                    <select name="method" class="form-select">
                        <option value="">Semua Metode</option>
                        <option value="transfer" {{ request('method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="tunai" {{ request('method') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                    </select>

                    <label class="form-label" style="margin-bottom: 0;">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="sudah_lunas" {{ request('status') == 'sudah_lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="belum_lunas" {{ request('status') == 'belum_lunas' ? 'selected' : '' }}>Pending</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            </form>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jamaah</th>
                            <th>Paket</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                            <th>Catatan</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                <td>
                                    <div class="font-semibold">{{ $payment->booking->customer_name ?? '-' }}</div>
                                    <div style="font-size: var(--text-xs); color: var(--color-text-muted);">{{ $payment->booking->phone ?? '' }}</div>
                                </td>
                                <td>{{ $payment->booking->package->name ?? 'Paket Terhapus' }}</td>
                                <td>
                                    <span class="badge {{ $payment->payment_method === 'transfer' ? 'badge-info' : 'badge-neutral' }}">
                                        {{ ucfirst($payment->payment_method) }}
                                    </span>
                                </td>
                                <td class="font-semibold" style="color: var(--color-success);">IDR {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td style="max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: var(--text-xs); color: var(--color-text-muted);">{{ $payment->notes ?? '-' }}</td>
                                <td>
                                    @if($payment->status === 'sudah_lunas')
                                        <span class="badge badge-success">Lunas</span>
                                    @elseif($payment->status === 'belum_lunas')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    @if($payment->proof_of_payment)
                                        <a href="{{ asset('assets/images/payments/' . $payment->proof_of_payment) }}" target="_blank" class="text-primary" style="font-size: var(--text-xs);">Lihat Bukti</a>
                                    @else
                                        <span style="font-size: var(--text-xs); color: var(--color-text-muted);">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="invoice-table-actions">
                                        <a href="{{ route('admin.bookings.show', $payment->booking_id) }}" class="btn btn-ghost btn-sm">Detail</a>

                                        @if($payment->status === 'belum_lunas')
                                            <form action="{{ route('admin.payments.updateStatus', $payment->id) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                <input type="hidden" name="status" value="sudah_lunas">
                                                <button type="submit" class="btn btn-success btn-sm">Verify</button>
                                            </form>
                                            <form action="{{ route('admin.payments.updateStatus', $payment->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Tolak pembayaran ini?');">
                                                @csrf
                                                <input type="hidden" name="status" value="ditolak">
                                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted" style="padding: var(--space-8);">Belum ada pembayaran tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
