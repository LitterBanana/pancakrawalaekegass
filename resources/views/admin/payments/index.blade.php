@extends('layouts.admin')
@section('title', 'Pembayaran - HMI Tour')
@section('page_title', 'Pembayaran')
@section('page_subtitle', 'Riwayat seluruh pembayaran jamaah')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6 animate-fade-in-up">
        <div class="stat-card min-h-40">
            <div class="stat-card-label">Total Pemasukan</div>
            <div class="stat-card-value text-emerald-600">IDR {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card min-h-40">
            <div class="stat-card-label">Total Transaksi</div>
            <div class="stat-card-value">{{ $totalTransaksi }}</div>
        </div>
        <div class="stat-card min-h-40">
            <div class="stat-card-label">Pembayaran Bulan Ini</div>
            <div class="stat-card-value">{{ $paymentsThisMonth }}</div>
        </div>
        <div class="stat-card min-h-40">
            <div class="stat-card-label">Belum Lunas</div>
            <div class="stat-card-value">{{ $pendingPayments }}</div>
        </div>
    </div>

    <div class="card animate-fade-in-up delay-1">
        <div class="card-header pb-4 gap-4 flex-wrap">
            <div>
                <h3 class="section-title text-lg">Riwayat Semua Pembayaran</h3>
                <p class="m-0 text-gray-500">Kelola semua permintaan pembayaran jamaah dengan filter cepat dan ekspor laporan.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.payments.export', request()->all()) }}" class="btn btn-success btn-sm">Export Excel</a>
                <a href="{{ route('admin.payments.export_pdf', request()->all()) }}" target="_blank" class="btn btn-secondary btn-sm">Export PDF</a>
            </div>
        </div>

        <div class="card-body pt-0">
            <form action="{{ route('admin.payments.index') }}" method="GET" class="flex flex-wrap justify-between gap-4 items-center bg-white border border-gray-100 rounded-2xl px-6 py-4 mb-6">
                <div class="flex flex-wrap gap-3 items-center">
                    <label class="form-label mb-0">Metode</label>
                    <select name="method" class="form-select min-w-[180px]">
                        <option value="">Semua Metode</option>
                        <option value="transfer" {{ request('method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="tunai" {{ request('method') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                    </select>

                    <label class="form-label mb-0">Status</label>
                    <select name="status" class="form-select min-w-[180px]">
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
                                    <div class="text-xs text-gray-400">{{ $payment->booking->phone ?? '' }}</div>
                                </td>
                                <td>{{ $payment->booking->package->name ?? 'Paket Terhapus' }}</td>
                                <td>
                                    <span class="badge {{ $payment->payment_method === 'transfer' ? 'badge-info' : 'badge-neutral' }}">
                                        {{ ucfirst($payment->payment_method) }}
                                    </span>
                                </td>
                                <td class="font-semibold text-emerald-600">IDR {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="max-w-[220px] overflow-hidden text-ellipsis whitespace-nowrap text-xs text-gray-400">{{ $payment->notes ?? '-' }}</td>
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
                                        <a href="{{ asset('assets/images/payments/' . $payment->proof_of_payment) }}" target="_blank" class="text-primary text-xs">Lihat Bukti</a>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex gap-3 flex-wrap justify-end">
                                        <a href="{{ route('admin.bookings.show', $payment->booking_id) }}" class="btn btn-ghost btn-sm">Detail</a>

                                        @if($payment->status === 'belum_lunas')
                                            <form action="{{ route('admin.payments.updateStatus', $payment->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <input type="hidden" name="status" value="sudah_lunas">
                                                <button type="submit" class="btn btn-success btn-sm">Verify</button>
                                            </form>
                                            <form action="{{ route('admin.payments.updateStatus', $payment->id) }}" method="POST" class="m-0" onsubmit="return confirm('Tolak pembayaran ini?');">
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
                                <td colspan="9" class="text-center text-muted p-8">Belum ada pembayaran tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
