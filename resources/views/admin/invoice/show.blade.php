@extends('layouts.admin')
@section('title', 'Detail Invoice - HMI Tour')
@section('page_title', 'Detail Invoice')
@section('page_subtitle', 'Invoice #INV-' . $invoice->id)

@section('content')
    <div class="max-w-[900px] mx-auto">
        <div class="card animate-fade-in-up">
            <div class="card-header">
                <h3 class="section-title text-lg">Invoice #INV-{{ $invoice->id }}</h3>
                <a href="{{ route('admin.invoice.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="font-semibold mb-2">Informasi Jamaah</h4>
                        <p class="text-sm text-gray-400">Nama: {{ $invoice->customer_name }}</p>
                        <p class="text-sm text-gray-400">Telepon: {{ $invoice->phone }}</p>
                        <p class="text-sm text-gray-400">Email: {{ $invoice->email ?? '-' }}</p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Detail Paket</h4>
                        <p class="text-sm text-gray-400">Paket: {{ $invoice->package->name ?? '-' }}</p>
                        <p class="text-sm text-gray-400">Jumlah Orang: {{ $invoice->jumlah_orang }}</p>
                        <p class="text-sm text-gray-400">Tanggal Booking: {{ $invoice->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
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
                                    <tr><td colspan="4" class="text-center text-muted p-4">Belum ada pembayaran.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6 mt-6 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Total Pembayaran</p>
                        <p class="text-2xl font-bold m-0">IDR {{ number_format($invoice->total_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.invoice.download', $invoice->id) }}" class="btn btn-primary">Download Invoice</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection