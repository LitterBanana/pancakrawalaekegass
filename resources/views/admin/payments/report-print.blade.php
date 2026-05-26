@extends('layouts.admin')

@section('title', 'Laporan Pembayaran PDF - HMI Tour')
@section('page_title', 'Laporan Pembayaran PDF')
@section('page_subtitle', 'Halaman cetak laporan pembayaran')

@section('content')
    <div style="max-width: 1000px; margin: 0 auto;">
        <div class="card animate-fade-in-up">
            <div class="card-header">
                <h3 class="section-title">Laporan Pembayaran</h3>
                <button onclick="window.print()" class="btn btn-primary btn-sm">Cetak / Simpan PDF</button>
            </div>
            <div class="card-body">
                <p style="margin-bottom: var(--space-4);">Gunakan tombol cetak browser untuk menyimpan laporan sebagai PDF.</p>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Invoice</th>
                                <th>Nama Jamaah</th>
                                <th>Paket</th>
                                <th>Metode</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                    <td>{{ $payment->invoice_number }}</td>
                                    <td>{{ $payment->booking->customer_name ?? '-' }}</td>
                                    <td>{{ $payment->booking->package->name ?? '-' }}</td>
                                    <td>{{ ucfirst($payment->payment_method) }}{{ $payment->bank_name ? ' (' . strtoupper($payment->bank_name) . ')' : '' }}</td>
                                    <td>IDR {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if($payment->status === 'sudah_lunas')
                                            Lunas
                                        @elseif($payment->status === 'belum_lunas')
                                            Pending
                                        @else
                                            Ditolak
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center" style="padding: var(--space-8);">Belum ada pembayaran.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
