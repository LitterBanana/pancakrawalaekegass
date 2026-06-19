@extends('user.layouts.app')

@section('title', 'Pembayaran — HMI Tour Travel')
@section('description', 'Form Pembayaran Tour - HMI Tour Travel')
@section('page-title', 'Pembayaran')

@section('page_styles')
  <!-- Styles moved to app.css -->
@endsection

@section('page_scripts')
  <script src="{{ asset('assets/js/payment.js') }}"></script>
@endsection

@section('content')
  <div class="max-w-[900px] mx-auto">

    <!-- Paid In Full Banner (hidden by default, shown by JS when lunas) -->
    <div class="hidden text-center p-10 bg-white rounded-2xl border-2 border-emerald-300 shadow-md mb-8 animate-scale-in" id="paidBanner">
      <h2 class="text-2xl font-bold text-emerald-600 mb-3">Tagihan Anda Sudah Lunas!</h2>
      <p class="text-base text-gray-500 max-w-md mx-auto mb-6 leading-relaxed">Selamat! Seluruh pembayaran tour Anda telah lunas. Anda tidak perlu melakukan pembayaran lagi.</p>
      <div class="flex justify-center gap-4">
        <a href="{{ route('user.invoices') }}" class="px-6 py-3 bg-white text-[#8B1A1A] border border-[#8B1A1A] font-semibold rounded-xl hover:bg-red-50 transition-colors">Lihat Invoice</a>
        <a href="{{ route('user.dashboard') }}" class="px-6 py-3 bg-[#8B1A1A] text-white font-semibold rounded-xl hover:bg-red-800 transition-colors">Ke Dashboard</a>
      </div>
    </div>

    <!-- Payment Form Card -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-md overflow-hidden animate-fade-in-up payment-form-card" id="paymentFormCard">
      <div class="p-6 md:p-8 border-b border-gray-200 bg-gray-50">
        <h2 class="text-xl font-bold text-gray-900 m-0 mb-1">Formulir Pembayaran</h2>
        <p class="text-sm text-gray-500 m-0">Lengkapi formulir berikut untuk melakukan pembayaran tour Anda.</p>
      </div>

      <form id="paymentForm" class="p-6 md:p-8" action="{{ route('user.payment.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Section: User Info (Auto-filled) -->
        <div class="mb-8 form-section">
          <h3 class="text-base font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">
            Informasi Anggota
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
            <div>
              <label for="userId" class="block text-sm font-semibold text-gray-900 mb-2">ID Member</label>
              <input type="text" id="userId" class="w-full px-4 py-3 text-sm text-gray-500 bg-gray-100 border border-gray-200 rounded-xl cursor-not-allowed" value="{{ $user->id }}" readonly aria-label="ID Member otomatis">
              <span class="text-xs text-gray-500 mt-1 block">ID terisi otomatis dari sistem</span>
            </div>
            <div>
              <label for="userNik" class="block text-sm font-semibold text-gray-900 mb-2">NIK / Email</label>
              <input type="text" id="userNik" class="w-full px-4 py-3 text-sm text-gray-500 bg-gray-100 border border-gray-200 rounded-xl cursor-not-allowed" value="{{ $user->email }}" readonly aria-label="NIK otomatis">
              <span class="text-xs text-gray-500 mt-1 block">Email akun Anda</span>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label for="userName" class="block text-sm font-semibold text-gray-900 mb-2">Nama Lengkap</label>
              <input type="text" id="userName" name="customer_name" class="w-full px-4 py-3 text-sm text-gray-500 bg-gray-100 border border-gray-200 rounded-xl cursor-not-allowed" value="{{ $user->name }}" readonly aria-label="Nama lengkap otomatis">
            </div>
            <div>
              <label for="userPackage" class="block text-sm font-semibold text-gray-900 mb-2">Paket Tour</label>
              <input type="text" id="userPackage" class="w-full px-4 py-3 text-sm text-gray-500 bg-gray-100 border border-gray-200 rounded-xl cursor-not-allowed" value="{{ $activeBooking ? $activeBooking->package->name : 'Belum Ada Tagihan' }}" readonly aria-label="Paket tour otomatis">
            </div>
          </div>
        </div>

        <!-- Section: Payment Amount -->
        <div class="mb-8 form-section">
          <h3 class="text-base font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">
            Nominal Pembayaran
          </h3>
          <div>
            <label for="paymentAmount" class="block text-sm font-semibold text-gray-900 mb-2">
              Jumlah Pembayaran <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500 pointer-events-none">Rp</span>
              <input type="text" id="paymentAmount" class="w-full pl-12 pr-4 py-3 text-lg font-semibold text-gray-900 bg-white border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#8B1A1A] focus:ring-4 focus:ring-red-50 transition-all amount-input" placeholder="0" inputmode="numeric" autocomplete="off" aria-required="true">
              <input type="hidden" id="paymentAmountRaw" name="amount">
            </div>
            <span class="text-xs text-gray-500 mt-2 block" id="remainingBalance">
                @if($sisaTagihan > 0)
                    Sisa Tagihan Maksimal: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
                @else
                    Tidak ada sisa tagihan.
                @endif
            </span>
            <div class="field-error-msg" id="errorAmount">⚠ Masukkan nominal pembayaran terlebih dahulu.</div>
            <div class="flex flex-wrap gap-2 mt-3">
              <button type="button" class="amount-shortcut px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs font-medium text-gray-600 hover:bg-red-50 hover:border-red-200 hover:text-[#8B1A1A] transition-colors" data-amount="1000000">Rp 1.000.000</button>
              <button type="button" class="amount-shortcut px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs font-medium text-gray-600 hover:bg-red-50 hover:border-red-200 hover:text-[#8B1A1A] transition-colors" data-amount="2500000">Rp 2.500.000</button>
              <button type="button" class="amount-shortcut px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs font-medium text-gray-600 hover:bg-red-50 hover:border-red-200 hover:text-[#8B1A1A] transition-colors" data-amount="5000000">Rp 5.000.000</button>
              <button type="button" class="amount-shortcut px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs font-medium text-gray-600 hover:bg-red-50 hover:border-red-200 hover:text-[#8B1A1A] transition-colors" data-amount="10000000">Rp 10.000.000</button>
            </div>
          </div>
        </div>

        <!-- Section: Payment Method -->
        <div class="mb-8 form-section">
          <h3 class="text-base font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">
            Metode Pembayaran <span class="text-red-500">*</span>
          </h3>
          
          <div class="flex flex-col sm:flex-row gap-4 radio-group" id="paymentMethodGroup">
            <div class="flex-1 relative radio-card">
              <input type="radio" name="payment_method" id="methodCash" value="tunai" required class="absolute opacity-0 w-0 h-0">
              <label for="methodCash" class="flex flex-col items-center gap-2 p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all hover:border-red-300 radio-card-label text-center">
                <span class="text-sm font-semibold text-gray-900">Tunai</span>
                <span class="text-xs text-gray-500">Bayar langsung</span>
              </label>
            </div>
            <div class="flex-1 relative radio-card">
              <input type="radio" name="payment_method" id="methodTransfer" value="transfer" required class="absolute opacity-0 w-0 h-0">
              <label for="methodTransfer" class="flex flex-col items-center gap-2 p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all hover:border-red-300 radio-card-label text-center">
                <span class="text-sm font-semibold text-gray-900">Transfer Bank</span>
                <span class="text-xs text-gray-500">Via rekening bank</span>
              </label>
            </div>
          </div>
          <div class="field-error-msg" id="errorMethod">⚠ Pilih metode pembayaran terlebih dahulu.</div>

          <!-- Bank Options (shown when transfer selected) -->
          <div class="hidden mt-4 animate-fade-in" id="bankOptions">
            <label class="block text-sm font-semibold text-gray-900 mb-3 mt-4">
              Pilih Bank Tujuan <span class="text-red-500">*</span>
            </label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 bank-grid" id="bankGrid">
              <div class="relative bank-option">
                <input type="radio" name="bank" id="bankBRI" value="bri" class="absolute opacity-0 w-0 h-0">
                <label for="bankBRI" class="flex flex-col items-center gap-2 p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all hover:border-red-300 text-center bank-option-label">
                  <span class="h-9 flex items-center justify-center font-bold text-[#003d8f] text-sm">BRI</span>
                  <span class="text-xs font-semibold text-gray-500">Bank BRI</span>
                  <span class="text-[10px] text-gray-400">KCP Puspitek Raya</span>
                </label>
              </div>
              <div class="relative bank-option">
                <input type="radio" name="bank" id="bankBSI" value="bsi" class="absolute opacity-0 w-0 h-0">
                <label for="bankBSI" class="flex flex-col items-center gap-2 p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all hover:border-red-300 text-center bank-option-label">
                  <span class="h-9 flex items-center justify-center font-bold text-[#3d9970] text-sm">BSI</span>
                  <span class="text-xs font-semibold text-gray-500">Bank BSI</span>
                  <span class="text-[10px] text-gray-400">KCP Pamulang</span>
                </label>
              </div>
              <div class="relative bank-option">
                <input type="radio" name="bank" id="bankBCASyariah" value="bca_syariah" class="absolute opacity-0 w-0 h-0">
                <label for="bankBCASyariah" class="flex flex-col items-center gap-2 p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all hover:border-red-300 text-center bank-option-label">
                  <span class="h-9 flex items-center justify-center font-bold text-[#0066ae] text-sm">BCA</span>
                  <span class="text-xs font-semibold text-gray-500">BCA Syariah</span>
                  <span class="text-[10px] text-gray-400">KCP Ciledug</span>
                </label>
              </div>
              <div class="relative bank-option">
                <input type="radio" name="bank" id="bankBTN" value="btn" class="absolute opacity-0 w-0 h-0">
                <label for="bankBTN" class="flex flex-col items-center gap-2 p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all hover:border-red-300 text-center bank-option-label">
                  <span class="h-9 flex items-center justify-center font-bold text-[#f7a600] text-sm">BTN</span>
                  <span class="text-xs font-semibold text-gray-500">Bank BTN</span>
                  <span class="text-[10px] text-gray-400">&nbsp;</span>
                </label>
              </div>
            </div>
            <div class="field-error-msg" id="errorBank">⚠ Pilih bank tujuan transfer terlebih dahulu.</div>

            <!-- Bank Account Info -->
            <div class="hidden mt-4 bg-white border border-red-300 rounded-xl overflow-hidden animate-fade-in bank-account-info" id="bankAccountInfo">
              <div class="flex items-center gap-2 px-4 py-3 bg-red-50 border-b border-red-300 text-sm font-semibold text-[#8B1A1A]">
                <span>Informasi Rekening Tujuan</span>
              </div>
              <div class="p-4">
                <div class="flex justify-between items-center py-2">
                  <span class="text-sm text-gray-500">Bank</span>
                  <span class="text-sm font-semibold text-gray-900" id="bankInfoName">-</span>
                </div>
                <div class="flex justify-between items-center py-2 border-t border-gray-100">
                  <span class="text-sm text-gray-500">No. Rekening</span>
                  <span class="text-lg font-bold text-[#8B1A1A] tracking-wider font-mono" id="bankInfoNumber">-</span>
                </div>
                <div class="flex justify-between items-center py-2 border-t border-gray-100">
                  <span class="text-sm text-gray-500">Atas Nama</span>
                  <span class="text-sm font-semibold text-gray-900" id="bankInfoHolder">-</span>
                </div>
              </div>
              <button type="button" class="w-full p-3 bg-red-50 border-t border-red-300 text-[#8B1A1A] text-sm font-semibold hover:bg-[#8B1A1A] hover:text-white transition-colors" id="copyAccountNumber" title="Salin nomor rekening">
                Salin No. Rekening
              </button>
            </div>
          </div>
        </div>

        <!-- Section: Upload Proof -->
        <div class="mb-8 form-section">
          <h3 class="text-base font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">
            Bukti Pembayaran
          </h3>
          <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer transition-colors hover:border-[#8B1A1A] hover:bg-red-50 file-upload" id="uploadArea">
            <input type="file" id="proofFile" name="proof_of_payment" accept="image/jpeg,image/png,image/jpg,application/pdf" class="absolute inset-0 opacity-0 cursor-pointer z-10" aria-label="Upload bukti pembayaran">
            <div class="text-sm text-gray-500 mb-1">
              Drag & drop atau <strong class="text-[#8B1A1A]">klik untuk upload</strong>
            </div>
            <div class="text-xs text-gray-400">
              Format: JPG, PNG, PDF • Maksimal 5MB
            </div>
          </div>
          <div id="filePreview"></div>
          <div class="field-error-msg" id="errorProof">⚠ Upload bukti pembayaran terlebih dahulu.</div>
          <span class="text-xs text-gray-500 mt-2 block">Upload bukti transfer / foto struk pembayaran Anda</span>
        </div>

        <!-- Payment Summary -->
        <div class="bg-gray-50 rounded-xl p-5 mt-6 payment-summary">
          <h4 class="text-sm font-semibold text-gray-900 mb-3">Ringkasan Pembayaran</h4>
          <div class="flex justify-between items-center py-2 text-sm">
            <span class="text-gray-500">Nominal Pembayaran</span>
            <span class="font-semibold text-gray-900" id="summaryAmount">-</span>
          </div>
          <div class="flex justify-between items-center py-2 text-sm">
            <span class="text-gray-500">Metode Pembayaran</span>
            <span class="font-semibold text-gray-900" id="summaryMethod">-</span>
          </div>
          <div class="flex justify-between items-center py-2 text-sm">
            <span class="text-gray-500">Bank Tujuan</span>
            <span class="font-semibold text-gray-900" id="summaryBank">-</span>
          </div>
          <div class="flex justify-between items-center mt-3 pt-3 border-t-2 border-gray-200 text-base font-bold text-[#8B1A1A]">
            <span>Total Dibayar</span>
            <span id="summaryTotal">-</span>
          </div>
        </div>

      </form>

      <div class="p-6 md:p-8 border-t border-gray-200 bg-gray-50 flex flex-col md:flex-row items-center justify-between gap-4 payment-form-footer">
        <a href="{{ route('user.dashboard') }}" class="px-6 py-3 text-gray-600 font-semibold hover:bg-gray-200 rounded-xl transition-colors w-full md:w-auto text-center">← Kembali</a>
        <button type="submit" form="paymentForm" class="px-8 py-3 bg-[#8B1A1A] text-white font-semibold rounded-xl hover:bg-red-800 transition-colors w-full md:w-auto text-center shadow-lg shadow-red-900/20">
          Bayar Sekarang
        </button>
      </div>
    </div>

    <!-- Payment Success State -->
    <div class="hidden text-center py-12 px-8 animate-scale-in" id="paymentSuccess">
      <div class="w-20 h-20 bg-emerald-50 border-4 border-emerald-200 text-emerald-500 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">✓</div>
      <h2 class="text-2xl font-bold text-gray-900 mb-3">Pembayaran Berhasil!</h2>
      <p class="text-base text-gray-500 max-w-md mx-auto mb-8 leading-relaxed">Data pembayaran Anda telah berhasil dikirimkan dan akan segera diverifikasi oleh admin.</p>

      <div class="bg-gray-50 rounded-xl p-6 max-w-md mx-auto mb-8 text-left border border-gray-200">
        <div class="flex justify-between py-2 text-sm">
          <span class="text-gray-500">ID Transaksi</span>
          <span class="font-semibold text-gray-900" id="successPaymentId">-</span>
        </div>
        <div class="flex justify-between py-2 text-sm border-t border-gray-100">
          <span class="text-gray-500">Tanggal</span>
          <span class="font-semibold text-gray-900" id="successDate">-</span>
        </div>
        <div class="flex justify-between py-2 text-sm border-t border-gray-100">
          <span class="text-gray-500">Jumlah</span>
          <span class="font-semibold text-gray-900" id="successAmount">-</span>
        </div>
        <div class="flex justify-between py-2 text-sm border-t border-gray-100">
          <span class="text-gray-500">Metode</span>
          <span class="font-semibold text-gray-900" id="successMethod">-</span>
        </div>
        <div class="flex justify-between py-2 text-sm border-t border-gray-100">
          <span class="text-gray-500">Invoice</span>
          <span class="font-semibold text-gray-900" id="successInvoiceId">-</span>
        </div>
      </div>

      <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="{{ route('user.invoices') }}" class="px-6 py-3 bg-white text-[#8B1A1A] border border-[#8B1A1A] font-semibold rounded-xl hover:bg-red-50 transition-colors">Lihat Invoice</a>
        <a href="{{ route('user.dashboard') }}" class="px-6 py-3 bg-[#8B1A1A] text-white font-semibold rounded-xl hover:bg-red-800 transition-colors">Ke Dashboard</a>
      </div>
    </div>

  </div>
@endsection
