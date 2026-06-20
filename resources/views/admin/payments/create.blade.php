@extends('layouts.admin')
@section('title', 'Tambah Pembayaran - HMI Tour')
@section('page_title', 'Tambah Pembayaran')
@section('page_subtitle', 'Catat penerimaan dana secara manual')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title text-lg">Form Pencatatan Pembayaran</h3>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.payments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Kolom Kiri -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 border-b pb-2">Informasi Invoice</h4>

                    <div class="form-group">
                        <label class="form-label">Pilih Tagihan (Invoice) <span class="text-red-500">*</span></label>
                        <select name="booking_id" id="booking_id" class="form-select" required>
                            <option value="">-- Pilih Invoice --</option>
                            @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}" {{ old('booking_id') == $booking->id ? 'selected' : '' }}>
                                    #INV-{{ $booking->id }} - {{ $booking->customer_name }} ({{ $booking->package->name ?? 'Paket Terhapus' }})
                                </option>
                            @endforeach
                        </select>
                        @error('booking_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        <p class="text-xs text-gray-500 mt-1">Pembayaran akan otomatis dihubungkan dengan pelanggan dari invoice yang dipilih.</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nominal Pembayaran <span class="text-red-500">*</span></label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount') }}" class="form-input" required min="1" placeholder="Contoh: 5000000">
                        @error('amount') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Pembayaran <span class="text-red-500">*</span></label>
                        <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" class="form-input" required>
                        @error('payment_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 border-b pb-2">Detail Transaksi</h4>

                    <div class="form-group">
                        <label class="form-label">Metode Pembayaran <span class="text-red-500">*</span></label>
                        <select name="payment_method" class="form-select" required>
                            <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="tunai" {{ old('payment_method') == 'tunai' ? 'selected' : '' }}>Tunai / Cash</option>
                        </select>
                        @error('payment_method') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Bank (Jika Transfer)</label>
                        <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name') }}" class="form-input" placeholder="BCA / Mandiri / BSI (Opsional)">
                        @error('bank_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Bukti Transfer (Opsional)</label>
                        <input type="file" name="proof_of_payment" accept="image/*" class="form-input">
                        @error('proof_of_payment') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status Verifikasi <span class="text-red-500">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="sudah_lunas" {{ old('status', 'sudah_lunas') == 'sudah_lunas' ? 'selected' : '' }}>Diverifikasi (Masuk Saldo)</option>
                            <option value="belum_lunas" {{ old('status') == 'belum_lunas' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Status booking akan otomatis disesuaikan (Lunas/Dicicil) hanya jika status pembayaran <b>Diverifikasi</b>.</p>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
                <label class="form-label">Catatan Tambahan</label>
                <textarea name="notes" class="form-textarea" rows="3" placeholder="Opsional...">{{ old('notes') }}</textarea>
            </div>

            <div class="mt-8 pt-5 border-t border-gray-200">
                <button type="submit" class="btn btn-primary btn-full btn-lg">Simpan Pembayaran</button>
            </div>
        </form>
    </div>
</div>
@endsection
