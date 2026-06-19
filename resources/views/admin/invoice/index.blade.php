@extends('layouts.admin')
@section('title', 'Invoice Dashboard - HMI Tour')
@section('page_title', 'Invoice')
@section('page_subtitle', 'Kelola seluruh invoice')

@section('content')
    <div class="stats-grid animate-fade-in-up">
        <div class="stat-card">
            <div class="stat-card-label">Total Invoice</div>
            <div class="stat-card-value">{{ $totalInvoices }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Total Pendapatan</div>
            <div class="stat-card-value text-emerald-600">IDR {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Invoice Bulan Ini</div>
            <div class="stat-card-value">{{ $invoicesThisMonth }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Rata-rata Invoice</div>
            <div class="stat-card-value">IDR {{ number_format($averageInvoice, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="card animate-fade-in-up delay-1">
        <div class="card-header">
            <h3 class="section-title text-lg">Daftar Invoice</h3>
            <form action="{{ route('admin.invoice.index') }}" method="GET" class="flex gap-2 m-0">
                <select name="status" class="form-select w-auto text-xs px-3 py-2 pr-8">
                    <option value="">Semua Status</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No Invoice</th>
                        <th>Tanggal</th>
                        <th>Jamaah</th>
                        <th>Paket</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>#INV-{{ $invoice->id }}</td>
                            <td>{{ $invoice->created_at->format('d M Y') }}</td>
                            <td class="font-semibold">{{ $invoice->customer_name }}</td>
                            <td>{{ $invoice->package->name ?? '-' }}</td>
                            <td>IDR {{ number_format($invoice->total_price, 0, ',', '.') }}</td>
                            <td>
                                @if($invoice->status == 'paid') <span class="badge badge-success">Lunas</span>
                                @elseif($invoice->status == 'pending') <span class="badge badge-warning">Pending</span>
                                @else <span class="badge badge-danger">Batal</span> @endif
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.invoice.show', $invoice->id) }}" class="btn btn-ghost btn-sm">Detail</a>
                                    <a href="{{ route('admin.invoice.print', $invoice->id) }}" target="_blank" class="btn btn-secondary btn-sm">Cetak</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted p-8">Belum ada invoice.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection