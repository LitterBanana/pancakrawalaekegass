@extends('layouts.admin')
@section('title', 'Detail Pesanan #' . $booking->id)
@section('page_title', 'Detail Pesanan #' . $booking->id)
@section('page_subtitle', 'Informasi lengkap pesanan jamaah')

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: var(--space-6);">

    <div>
        <!-- Info Jamaah & Paket -->
        <div class="card mb-6 animate-fade-in-up">
            <div class="card-header">
                <h3 class="section-title" style="font-size: var(--text-lg);">Informasi Jamaah & Paket</h3>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-5); margin-bottom: var(--space-5);">
                    <div>
                        <div class="form-hint" style="margin-bottom: var(--space-1);">Nama Jamaah</div>
                        <div class="font-semibold" style="font-size: var(--text-base);">{{ $booking->customer_name }}</div>
                    </div>
                    <div>
                        <div class="form-hint" style="margin-bottom: var(--space-1);">Nomor WhatsApp</div>
                        <div class="font-semibold" style="font-size: var(--text-base);">
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $booking->customer_phone) }}" target="_blank" style="color: var(--color-success);">
                                {{ $booking->customer_phone }} ↗
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class="form-hint" style="margin-bottom: var(--space-1);">Paket Umrah</div>
                        <div class="font-semibold" style="font-size: var(--text-base);">{{ $booking->package->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="form-hint" style="margin-bottom: var(--space-1);">Tipe Kamar</div>
                        <div class="font-semibold" style="font-size: var(--text-base);">{{ $booking->room_type }}</div>
                    </div>
                </div>

                <div style="background: var(--color-bg); padding: var(--space-4); border-radius: var(--radius-xl); border: 1px solid var(--color-border-light);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--space-2);">
                        <span>Harga Paket</span>
                        <strong>IDR {{ number_format($booking->package_price, 0, ',', '.') }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--space-2);">
                        <span>Jumlah Jamaah</span>
                        <strong>{{ $booking->quantity }} Orang</strong>
                    </div>
                    <hr style="border: none; height: 1px; background: var(--color-border); margin: var(--space-3) 0;">
                    <div style="display: flex; justify-content: space-between; font-size: var(--text-lg); color: var(--color-primary);">
                        <strong>Total Tagihan</strong>
                        <strong>IDR {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pembayaran -->
        <div class="card animate-fade-in-up delay-1">
            <div class="card-header">
                <h3 class="section-title" style="font-size: var(--text-lg);">Riwayat Pembayaran</h3>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Metode</th>
                            <th>Jumlah Masuk</th>
                            <th>Catatan</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->payments as $payment)
                        <tr>
                            <td>{{ $payment->created_at->format('d M Y') }}</td>
                            <td>{{ ucfirst($payment->method) }}</td>
                            <td class="font-semibold" style="color: var(--color-success);">+ IDR {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td style="font-size: var(--text-xs); color: var(--color-text-muted);">{{ $payment->notes ?? '-' }}</td>
                            <td>
                                @if($payment->proof_image)
                                    <a href="{{ asset('assets/images/payments/' . $payment->proof_image) }}" target="_blank" style="font-size: var(--text-xs); color: var(--color-primary);">Lihat Bukti</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted" style="padding: var(--space-5);">Belum ada pembayaran tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr style="background: var(--color-bg);">
                            <td colspan="2" class="text-right font-semibold">Total Terbayar:</td>
                            <td class="font-bold" style="color: var(--color-success);">IDR {{ number_format($booking->payments->sum('amount'), 0, ',', '.') }}</td>
                            <td colspan="2">
                                @php $sisa = $booking->total_price - $booking->payments->sum('amount'); @endphp
                                (Sisa: <span style="color: {{ $sisa > 0 ? 'var(--color-danger)' : 'var(--color-success)' }};">IDR {{ number_format($sisa, 0, ',', '.') }}</span>)
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div>
        <!-- Update Status -->
        <div class="card mb-6 animate-fade-in-up delay-2">
            <div class="card-header">
                <h3 class="section-title" style="font-size: var(--text-lg);">Update Status</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.bookings.update_status', $booking->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Status Pesanan</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending (Belum Bayar)</option>
                            <option value="dicicil" {{ $booking->status == 'dicicil' ? 'selected' : '' }}>Dicicil (Sebagian)</option>
                            <option value="paid" {{ $booking->status == 'paid' ? 'selected' : '' }}>Lunas (Selesai)</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Simpan Status</button>
                </form>
            </div>
        </div>

        <!-- Catat Pembayaran -->
        <div class="card animate-fade-in-up delay-3">
            <div class="card-header">
                <h3 class="section-title" style="font-size: var(--text-lg);">Catat Pembayaran</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.bookings.store_payment', $booking->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Jumlah Uang (IDR)</label>
                        <input type="number" name="amount" class="form-input" placeholder="Cth: 5000000" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Metode</label>
                        <select name="method" class="form-select">
                            <option value="transfer">Transfer Bank</option>
                            <option value="cash">Tunai / Cash</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Bukti Transfer (Opsional)</label>
                        <input type="file" name="proof_image" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan</label>
                        <input type="text" name="notes" class="form-input" placeholder="Cth: DP Tahap 1">
                    </div>
                    <button type="submit" class="btn btn-secondary btn-full">Tambah Pembayaran</button>
                </form>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    @media (max-width: 1024px) {
        [style*="grid-template-columns: 2fr 1fr"] { grid-template-columns: 1fr !important; }
    }
</style>
@endpush
@endsection