@extends('layouts.admin')
@section('title', 'Edit Pembayaran - HMI Tour')
@section('page_title', 'Edit Pembayaran')
@section('page_subtitle', 'Ubah data riwayat pembayaran')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title text-lg">Form Edit Pembayaran {{ $payment->invoice_number }}</h3>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Kolom Kiri -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 border-b pb-2">Informasi Invoice</h4>

                    <div class="form-group">
                        <label class="form-label">Pilih Tagihan (Invoice) <span class="text-red-500">*</span></label>
                        <select name="booking_id" id="booking_id" class="form-select" required>
                            @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}" {{ old('booking_id', $payment->booking_id) == $booking->id ? 'selected' : '' }}>
                                    #INV-{{ $booking->id }} - {{ $booking->customer_name }} ({{ $booking->package->name ?? 'Paket Terhapus' }})
                                </option>
                            @endforeach
                        </select>
                        @error('booking_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        <p class="text-xs text-gray-500 mt-1">Mengubah pilihan ini akan memindahkan alokasi dana ke invoice yang baru.</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nominal Pembayaran <span class="text-red-500">*</span></label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount', $payment->amount) }}" class="form-input" required min="1">
                        @error('amount') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Pembayaran <span class="text-red-500">*</span></label>
                        <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', $payment->payment_date) }}" class="form-input" required>
                        @error('payment_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 border-b pb-2">Detail Transaksi</h4>

                    <div class="form-group">
                        <label class="form-label">Metode Pembayaran <span class="text-red-500">*</span></label>
                        <select name="payment_method" class="form-select" required>
                            <option value="transfer" {{ old('payment_method', $payment->payment_method) == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="tunai" {{ old('payment_method', $payment->payment_method) == 'tunai' ? 'selected' : '' }}>Tunai / Cash</option>
                        </select>
                        @error('payment_method') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Bank (Jika Transfer)</label>
                        <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $payment->bank_name) }}" class="form-input" placeholder="BCA / Mandiri / BSI (Opsional)">
                        @error('bank_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Bukti Transfer</label>
                        <input type="file" name="proof_of_payment" accept="image/*" class="form-input">
                        @if($payment->proof_of_payment)
                            <div class="mt-2 text-sm text-gray-600">File saat ini: <a href="{{ asset('assets/images/payments/' . $payment->proof_of_payment) }}" target="_blank" class="text-blue-600 underline">Lihat Bukti</a></div>
                        @endif
                        @error('proof_of_payment') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        <p class="text-[11px] text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah foto bukti transfer.</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status Verifikasi <span class="text-red-500">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="sudah_lunas" {{ old('status', $payment->status) == 'sudah_lunas' ? 'selected' : '' }}>Diverifikasi (Masuk Saldo)</option>
                            <option value="belum_lunas" {{ old('status', $payment->status) == 'belum_lunas' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="ditolak" {{ old('status', $payment->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
                <label class="form-label">Catatan Tambahan</label>
                <textarea name="notes" class="form-textarea" rows="3" placeholder="Opsional...">{{ old('notes', $payment->notes) }}</textarea>
            </div>

            <div class="mt-8 pt-5 border-t border-gray-200">
                <button type="submit" class="btn btn-primary btn-full btn-lg">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
