@extends('user.layouts.app')

@section('title', 'Pembayaran — HMI Tour Travel')
@section('description', 'Form Pembayaran Tour - HMI Tour Travel')

@section('page_styles')
  <style>
    .payment-container { max-width: var(--content-max-width); margin: 0 auto; }
    .paid-banner { display: none; text-align: center; padding: var(--space-10) var(--space-8); background: var(--color-surface); border-radius: var(--radius-2xl); border: 2px solid var(--color-success-border); box-shadow: var(--shadow-md); margin-bottom: var(--space-8); animation: scaleIn 0.5s ease; }
    .paid-banner.visible { display: block; }
    .paid-banner-icon { font-size: 64px; margin-bottom: var(--space-4); animation: pulse 2s infinite; }
    .paid-banner h2 { font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-success); margin-bottom: var(--space-3); }
    .paid-banner p { font-size: var(--text-base); color: var(--color-text-secondary); max-width: 480px; margin: 0 auto var(--space-6); line-height: var(--leading-relaxed); }
    .paid-banner-actions { display: flex; justify-content: center; gap: var(--space-4); }
    .payment-form-card.payment-disabled { position: relative; }
    .payment-form-card.payment-disabled .payment-form-header { opacity: 0.5; }
    .section-disabled { opacity: 0.4; pointer-events: none; user-select: none; }
    .payment-form-card.payment-disabled .payment-summary { opacity: 0.4; }
    .payment-form-card.payment-disabled .payment-form-footer { opacity: 0.5; }
    .btn-disabled { opacity: 0.5 !important; cursor: not-allowed !important; pointer-events: none; }
    .payment-steps { display: flex; align-items: center; justify-content: center; gap: var(--space-2); margin-bottom: var(--space-8); padding: var(--space-6); background: var(--color-surface); border-radius: var(--radius-2xl); border: 1px solid var(--color-border-light); box-shadow: var(--shadow-sm); }
    .step-item { display: flex; align-items: center; gap: var(--space-2); }
    .step-number { width: 32px; height: 32px; border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center; font-size: var(--text-sm); font-weight: var(--font-bold); background: var(--color-bg-alt); color: var(--color-text-muted); transition: var(--transition-base); flex-shrink: 0; }
    .step-text { font-size: var(--text-sm); font-weight: var(--font-medium); color: var(--color-text-muted); transition: var(--transition-base); white-space: nowrap; }
    .step-item.active .step-number { background: var(--color-primary); color: var(--color-white); box-shadow: var(--shadow-primary); }
    .step-item.active .step-text { color: var(--color-primary); font-weight: var(--font-semibold); }
    .step-item.completed .step-number { background: var(--color-success); color: var(--color-white); }
    .step-item.completed .step-text { color: var(--color-success); }
    .step-connector { width: 40px; height: 2px; background: var(--color-border); flex-shrink: 0; transition: var(--transition-base); }
    .step-connector.active { background: var(--color-primary); }
    .payment-form-card { background: var(--color-surface); border-radius: var(--radius-2xl); border: 1px solid var(--color-border-light); box-shadow: var(--shadow-md); overflow: hidden; }
    .payment-form-header { padding: var(--space-6) var(--space-8); border-bottom: 1px solid var(--color-border-light); background: var(--color-bg); }
    .payment-form-header h2 { font-size: var(--text-xl); margin-bottom: var(--space-1); }
    .payment-form-header p { font-size: var(--text-sm); color: var(--color-text-secondary); margin-bottom: 0; }
    .payment-form-body { padding: var(--space-8); }
    .payment-form-footer { padding: var(--space-6) var(--space-8); border-top: 1px solid var(--color-border-light); background: var(--color-bg); display: flex; align-items: center; justify-content: space-between; gap: var(--space-4); }
    .form-section { margin-bottom: var(--space-8); }
    .form-section:last-child { margin-bottom: 0; }
    .form-section-title { font-size: var(--text-base); font-weight: var(--font-semibold); color: var(--color-text); margin-bottom: var(--space-4); padding-bottom: var(--space-3); border-bottom: 1px solid var(--color-border-light); display: flex; align-items: center; gap: var(--space-2); }
    .form-section-title .section-icon { color: var(--color-primary); font-size: var(--text-lg); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-5); }
    .bank-options { display: none; margin-top: var(--space-4); animation: fadeIn 0.3s ease; }
    .bank-options.visible { display: block; }
    .bank-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-3); }
    .bank-option { position: relative; }
    .bank-option input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
    .bank-option-label { display: flex; flex-direction: column; align-items: center; gap: var(--space-2); padding: var(--space-4); background: var(--color-white); border: 2px solid var(--color-border); border-radius: var(--radius-xl); cursor: pointer; transition: var(--transition-base); text-align: center; }
    .bank-option-label:hover { border-color: var(--color-primary-300); }
    .bank-option input[type="radio"]:checked+.bank-option-label { border-color: var(--color-primary); background: var(--color-primary-50); box-shadow: 0 0 0 3px rgba(139, 26, 26, 0.1); }
    .bank-logo { font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-text); height: 36px; display: flex; align-items: center; justify-content: center; }
    .bank-name { font-size: var(--text-xs); font-weight: var(--font-semibold); color: var(--color-text-secondary); }
    .bank-account-info { display: none; margin-top: var(--space-4); background: var(--color-white); border: 1px solid var(--color-primary-300); border-radius: var(--radius-xl); overflow: hidden; animation: fadeIn 0.3s ease, slideDown 0.3s ease; }
    .bank-account-info.visible { display: block; }
    .bank-account-info-header { display: flex; align-items: center; gap: var(--space-2); padding: var(--space-3) var(--space-4); background: var(--color-primary-50); border-bottom: 1px solid var(--color-primary-300); font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-primary); }
    .bank-account-info-icon { font-size: var(--text-base); }
    .bank-account-info-body { padding: var(--space-4); }
    .bank-account-row { display: flex; justify-content: space-between; align-items: center; padding: var(--space-2) 0; }
    .bank-account-row + .bank-account-row { border-top: 1px solid var(--color-border-light); }
    .bank-account-label { font-size: var(--text-sm); color: var(--color-text-secondary); }
    .bank-account-value { font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-text); }
    .bank-account-number { font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--color-primary); letter-spacing: 0.05em; font-family: 'Courier New', Courier, monospace; }
    .bank-copy-btn { display: block; width: 100%; padding: var(--space-3); background: var(--color-primary-50); border: none; border-top: 1px solid var(--color-primary-300); color: var(--color-primary); font-size: var(--text-sm); font-weight: var(--font-semibold); cursor: pointer; transition: var(--transition-base); }
    .bank-copy-btn:hover { background: var(--color-primary); color: var(--color-white); }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
    .amount-input-wrapper { position: relative; }
    .amount-prefix { position: absolute; left: var(--space-4); top: 50%; transform: translateY(-50%); font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-text-secondary); pointer-events: none; }
    .amount-input { padding-left: var(--space-12) !important; font-size: var(--text-lg) !important; font-weight: var(--font-semibold); letter-spacing: 0.02em; }
    .amount-shortcuts { display: flex; flex-wrap: wrap; gap: var(--space-2); margin-top: var(--space-3); }
    .amount-shortcut { padding: var(--space-2) var(--space-3); background: var(--color-bg-alt); border: 1px solid var(--color-border); border-radius: var(--radius-lg); font-size: var(--text-xs); font-weight: var(--font-medium); color: var(--color-text-secondary); cursor: pointer; transition: var(--transition-base); }
    .amount-shortcut:hover { background: var(--color-primary-50); border-color: var(--color-primary-300); color: var(--color-primary); }
    /* ---- File Upload Preview (Google Form style) ---- */
    .file-preview-card { display: flex; align-items: center; gap: var(--space-3); padding: var(--space-4); background: var(--color-surface); border: 1px solid var(--color-border-light); border-radius: var(--radius-xl); margin-top: var(--space-3); box-shadow: var(--shadow-sm); animation: fadeIn .25s ease; }
    .file-preview-thumb { width: 64px; height: 64px; border-radius: var(--radius-lg); object-fit: cover; border: 1px solid var(--color-border-light); flex-shrink: 0; }
    .file-preview-thumb-pdf { width: 64px; height: 64px; border-radius: var(--radius-lg); background: var(--color-primary-50); display: flex; align-items: center; justify-content: center; font-size: 28px; flex-shrink: 0; }
    .file-preview-info { flex: 1; min-width: 0; }
    .file-preview-name { font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; }
    .file-preview-size { font-size: var(--text-xs); color: var(--color-text-muted); margin-top: 2px; display: block; }
    .file-preview-status { font-size: var(--text-xs); color: var(--color-success); font-weight: var(--font-medium); display: flex; align-items: center; gap: 4px; margin-top: 4px; }
    .file-preview-remove { background: none; border: none; color: var(--color-text-muted); cursor: pointer; padding: var(--space-2); border-radius: var(--radius-full); transition: var(--transition-base); flex-shrink: 0; font-size: 18px; line-height: 1; }
    .file-preview-remove:hover { background: var(--color-error-bg, #ffeaea); color: var(--color-error, #c0392b); }
    .payment-summary { background: var(--color-bg); border-radius: var(--radius-xl); padding: var(--space-5); margin-top: var(--space-6); }
    .payment-summary-row { display: flex; justify-content: space-between; align-items: center; padding: var(--space-2) 0; font-size: var(--text-sm); }
    .payment-summary-row.total { border-top: 2px solid var(--color-border); margin-top: var(--space-3); padding-top: var(--space-3); font-weight: var(--font-bold); font-size: var(--text-base); color: var(--color-primary); }
    .payment-summary-label { color: var(--color-text-secondary); }
    .payment-summary-value { font-weight: var(--font-semibold); color: var(--color-text); }
    .payment-success { display: none; text-align: center; padding: var(--space-12) var(--space-8); animation: scaleIn 0.5s ease; }
    .payment-success.visible { display: block; }
    .success-icon { width: 80px; height: 80px; background: var(--color-success-bg); border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-6); font-size: var(--text-4xl); color: var(--color-success); border: 3px solid var(--color-success-border); }
    .payment-success h2 { font-size: var(--text-2xl); margin-bottom: var(--space-3); }
    .payment-success p { font-size: var(--text-base); color: var(--color-text-secondary); max-width: 400px; margin: 0 auto var(--space-8); }
    .success-details { background: var(--color-bg); border-radius: var(--radius-xl); padding: var(--space-6); max-width: 400px; margin: 0 auto var(--space-8); text-align: left; }
    .success-detail-row { display: flex; justify-content: space-between; padding: var(--space-2) 0; font-size: var(--text-sm); }
    .success-detail-label { color: var(--color-text-secondary); }
    .success-detail-value { font-weight: var(--font-semibold); color: var(--color-text); }
    .success-actions { display: flex; justify-content: center; gap: var(--space-4); }
    /* ---- Validasi Error State ---- */
    .form-input.error { border-color: #c0392b !important; box-shadow: 0 0 0 3px rgba(192,57,43,0.12) !important; }
    .radio-group.error-group .radio-card:not(:has(input:checked)) .radio-card-label {
      border-color: #c0392b;
    }
    .field-error-msg { display: none; align-items: center; gap: 6px; margin-top: var(--space-2); font-size: var(--text-xs); font-weight: var(--font-medium); color: #c0392b; animation: fadeIn .2s ease; }
    .field-error-msg.visible { display: flex; }
    /* Highlight seluruh group radio jika error */
    .radio-group.error-group .radio-card-label { border-color: #c0392b; background: #fff8f8; }
    .bank-grid.error-group .bank-option-label { border-color: #c0392b; background: #fff8f8; }
    /* Hapus highlight saat sudah dipilih */
    .radio-group.error-group input:checked + .radio-card-label,
    .bank-grid.error-group input:checked + .bank-option-label { border-color: var(--color-primary); background: var(--color-primary-50); box-shadow: 0 0 0 3px rgba(139,26,26,0.1); }
    .file-upload.error-upload { border-color: #c0392b !important; background: #fff8f8 !important; }
  </style>
@endsection

@section('page_scripts')
  <script src="{{ asset('assets/js/payment.js') }}"></script>
@endsection

@section('content')
  <div class="payment-container">

    <!-- Paid In Full Banner (hidden by default, shown by JS when lunas) -->
    <div class="paid-banner" id="paidBanner">
      <div class="paid-banner-icon">✅</div>
      <h2>Tagihan Anda Sudah Lunas!</h2>
      <p>Selamat! Seluruh pembayaran tour Anda telah lunas. Anda tidak perlu melakukan pembayaran lagi.</p>
      <div class="paid-banner-actions">
        <a href="{{ route('user.invoices') }}" class="btn btn-secondary">📋 Lihat Invoice</a>
        <a href="{{ route('user.dashboard') }}" class="btn btn-primary">📊 Ke Dashboard</a>
      </div>
    </div>

    <!-- Payment Form Card -->
    <div class="payment-form-card animate-fade-in-up" id="paymentFormCard">
      <div class="payment-form-header">
        <h2>📝 Formulir Pembayaran</h2>
        <p>Lengkapi formulir berikut untuk melakukan pembayaran tour Anda.</p>
      </div>

      <form id="paymentForm" class="payment-form-body" action="{{ route('user.payment.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Section: User Info (Auto-filled) -->
        <div class="form-section">
          <h3 class="form-section-title">
            <span class="section-icon">👤</span>
            Informasi Anggota
          </h3>
          <div class="form-row">
            <div class="form-group">
              <label for="userId" class="form-label">ID Member</label>
              <input type="text" id="userId" class="form-input" value="{{ $user->id }}" readonly aria-label="ID Member otomatis">
              <span class="form-hint">ID terisi otomatis dari sistem</span>
            </div>
            <div class="form-group">
              <label for="userNik" class="form-label">NIK / Email</label>
              <input type="text" id="userNik" class="form-input" value="{{ $user->email }}" readonly aria-label="NIK otomatis">
              <span class="form-hint">Email akun Anda</span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="userName" class="form-label">Nama Lengkap</label>
              <input type="text" id="userName" name="customer_name" class="form-input" value="{{ $user->name }}" readonly aria-label="Nama lengkap otomatis">
            </div>
            <div class="form-group">
              <label for="userPackage" class="form-label">Paket Tour</label>
              <input type="text" id="userPackage" class="form-input" value="{{ $activeBooking ? $activeBooking->package->name : 'Belum Ada Tagihan' }}" readonly aria-label="Paket tour otomatis">
            </div>
          </div>
        </div>

        <!-- Section: Payment Amount -->
        <div class="form-section">
          <h3 class="form-section-title">
            <span class="section-icon">💰</span>
            Nominal Pembayaran
          </h3>
          <div class="form-group">
            <label for="paymentAmount" class="form-label">
              Jumlah Pembayaran <span class="required">*</span>
            </label>
            <div class="amount-input-wrapper">
              <span class="amount-prefix">Rp</span>
              {{-- Pakai type="text" agar bisa format titik ribuan. Nilai asli disimpan di hidden input. --}}
              <input type="text" id="paymentAmount" class="form-input amount-input" placeholder="0"
                inputmode="numeric" autocomplete="off" aria-required="true">
              <input type="hidden" id="paymentAmountRaw" name="amount">
            </div>
            <span class="form-hint" id="remainingBalance">
                @if($sisaTagihan > 0)
                    Sisa Tagihan Maksimal: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
                @else
                    Tidak ada sisa tagihan.
                @endif
            </span>
            {{-- Pesan error nominal --}}
            <div class="field-error-msg" id="errorAmount">⚠ Masukkan nominal pembayaran terlebih dahulu.</div>
            <div class="amount-shortcuts">
              <button type="button" class="amount-shortcut" data-amount="1000000">Rp 1.000.000</button>
              <button type="button" class="amount-shortcut" data-amount="2500000">Rp 2.500.000</button>
              <button type="button" class="amount-shortcut" data-amount="5000000">Rp 5.000.000</button>
              <button type="button" class="amount-shortcut" data-amount="10000000">Rp 10.000.000</button>
            </div>
          </div>
        </div>

        <!-- Section: Payment Method -->
        <div class="form-section">
          <h3 class="form-section-title">
            <span class="section-icon">🏦</span>
            Metode Pembayaran <span class="required">*</span>
          </h3>
          {{-- id="paymentMethodGroup" dipakai JS untuk memberi class error-group --}}
          <div class="radio-group" id="paymentMethodGroup">
            <div class="radio-card">
              <input type="radio" name="payment_method" id="methodCash" value="tunai" required>
              <label for="methodCash" class="radio-card-label">
                <span class="radio-icon">💵</span>
                <span class="radio-text">Tunai</span>
                <span class="radio-desc">Bayar langsung</span>
              </label>
            </div>
            <div class="radio-card">
              <input type="radio" name="payment_method" id="methodTransfer" value="transfer" required>
              <label for="methodTransfer" class="radio-card-label">
                <span class="radio-icon">🏦</span>
                <span class="radio-text">Transfer Bank</span>
                <span class="radio-desc">Via rekening bank</span>
              </label>
            </div>
          </div>
          {{-- Pesan error metode --}}
          <div class="field-error-msg" id="errorMethod">⚠ Pilih metode pembayaran terlebih dahulu.</div>

          <!-- Bank Options (shown when transfer selected) -->
          <div class="bank-options" id="bankOptions">
            <label class="form-label" style="margin-top: var(--space-4); margin-bottom: var(--space-3);">
              Pilih Bank Tujuan <span class="required">*</span>
            </label>
            {{-- id="bankGrid" dipakai JS untuk class error-group --}}
            <div class="bank-grid" id="bankGrid" style="grid-template-columns: repeat(2,1fr)">
              <div class="bank-option">
                <input type="radio" name="bank" id="bankBRI" value="bri">
                <label for="bankBRI" class="bank-option-label">
                  <span class="bank-logo" style="color:#003d8f;font-size:var(--text-sm);font-weight:700">BRI</span>
                  <span class="bank-name">Bank BRI</span>
                  <span class="bank-name" style="font-size:10px;color:var(--color-text-muted)">KCP Puspitek Raya</span>
                </label>
              </div>
              <div class="bank-option">
                <input type="radio" name="bank" id="bankBSI" value="bsi">
                <label for="bankBSI" class="bank-option-label">
                  <span class="bank-logo" style="color:#3d9970;font-size:var(--text-sm);font-weight:700">BSI</span>
                  <span class="bank-name">Bank BSI</span>
                  <span class="bank-name" style="font-size:10px;color:var(--color-text-muted)">KCP Pamulang</span>
                </label>
              </div>
              <div class="bank-option">
                <input type="radio" name="bank" id="bankBCASyariah" value="bca_syariah">
                <label for="bankBCASyariah" class="bank-option-label">
                  <span class="bank-logo" style="color:#0066ae;font-size:var(--text-sm);font-weight:700">BCA</span>
                  <span class="bank-name">BCA Syariah</span>
                  <span class="bank-name" style="font-size:10px;color:var(--color-text-muted)">KCP Ciledug</span>
                </label>
              </div>
              <div class="bank-option">
                <input type="radio" name="bank" id="bankBTN" value="btn">
                <label for="bankBTN" class="bank-option-label">
                  <span class="bank-logo" style="color:#f7a600;font-size:var(--text-sm);font-weight:700">BTN</span>
                  <span class="bank-name">Bank BTN</span>
                  <span class="bank-name" style="font-size:10px;color:var(--color-text-muted)"> </span>
                </label>
              </div>
            </div>
            {{-- Pesan error bank --}}
            <div class="field-error-msg" id="errorBank">⚠ Pilih bank tujuan transfer terlebih dahulu.</div>

            <!-- Bank Account Info (shown when a bank is selected) -->
            <div class="bank-account-info" id="bankAccountInfo">
              <div class="bank-account-info-header">
                <span class="bank-account-info-icon">📋</span>
                <span>Informasi Rekening Tujuan</span>
              </div>
              <div class="bank-account-info-body">
                <div class="bank-account-row">
                  <span class="bank-account-label">Bank</span>
                  <span class="bank-account-value" id="bankInfoName">-</span>
                </div>
                <div class="bank-account-row">
                  <span class="bank-account-label">No. Rekening</span>
                  <span class="bank-account-value bank-account-number" id="bankInfoNumber">-</span>
                </div>
                <div class="bank-account-row">
                  <span class="bank-account-label">Atas Nama</span>
                  <span class="bank-account-value" id="bankInfoHolder">-</span>
                </div>
              </div>
              <button type="button" class="bank-copy-btn" id="copyAccountNumber" title="Salin nomor rekening">
                📋 Salin No. Rekening
              </button>
            </div>
          </div>
        </div>

        <!-- Section: Upload Proof -->
        <div class="form-section">
          <h3 class="form-section-title">
            <span class="section-icon">📎</span>
            Bukti Pembayaran
          </h3>
          <div class="file-upload" id="uploadArea">
            <input type="file" id="proofFile" name="proof_of_payment" accept="image/jpeg,image/png,image/jpg,application/pdf"
              aria-label="Upload bukti pembayaran">
            <div class="file-upload-icon">📤</div>
            <div class="file-upload-text">
              Drag & drop atau <strong>klik untuk upload</strong>
            </div>
            <div class="file-upload-hint">
              Format: JPG, PNG, PDF • Maksimal 5MB
            </div>
          </div>
          <div id="filePreview"></div>
          {{-- Pesan error bukti --}}
          <div class="field-error-msg" id="errorProof">⚠ Upload bukti pembayaran terlebih dahulu.</div>
          <span class="form-hint">Upload bukti transfer / foto struk pembayaran Anda</span>
        </div>

        <!-- Payment Summary -->
        <div class="payment-summary">
          <h4 style="font-size: var(--text-sm); font-weight: 600; margin-bottom: var(--space-3);">Ringkasan
            Pembayaran</h4>
          <div class="payment-summary-row">
            <span class="payment-summary-label">Nominal Pembayaran</span>
            <span class="payment-summary-value" id="summaryAmount">-</span>
          </div>
          <div class="payment-summary-row">
            <span class="payment-summary-label">Metode Pembayaran</span>
            <span class="payment-summary-value" id="summaryMethod">-</span>
          </div>
          <div class="payment-summary-row">
            <span class="payment-summary-label">Bank Tujuan</span>
            <span class="payment-summary-value" id="summaryBank">-</span>
          </div>
          <div class="payment-summary-row total">
            <span class="payment-summary-label">Total Dibayar</span>
            <span class="payment-summary-value" id="summaryTotal">-</span>
          </div>
        </div>

      </form>

      <div class="payment-form-footer">
        <a href="{{ route('user.dashboard') }}" class="btn btn-ghost">← Kembali</a>
        <button type="submit" form="paymentForm" class="btn btn-primary btn-lg">
          💳 Bayar Sekarang
        </button>
      </div>
    </div>

    <!-- Payment Success State -->
    <div class="payment-success" id="paymentSuccess">
      <div class="success-icon">✓</div>
      <h2>Pembayaran Berhasil!</h2>
      <p>Data pembayaran Anda telah berhasil dikirimkan dan akan segera diverifikasi oleh admin.</p>

      <div class="success-details">
        <div class="success-detail-row">
          <span class="success-detail-label">ID Transaksi</span>
          <span class="success-detail-value" id="successPaymentId">-</span>
        </div>
        <div class="success-detail-row">
          <span class="success-detail-label">Tanggal</span>
          <span class="success-detail-value" id="successDate">-</span>
        </div>
        <div class="success-detail-row">
          <span class="success-detail-label">Jumlah</span>
          <span class="success-detail-value" id="successAmount">-</span>
        </div>
        <div class="success-detail-row">
          <span class="success-detail-label">Metode</span>
          <span class="success-detail-value" id="successMethod">-</span>
        </div>
        <div class="success-detail-row">
          <span class="success-detail-label">Invoice</span>
          <span class="success-detail-value" id="successInvoiceId">-</span>
        </div>
      </div>

      <div class="success-actions">
        <a href="{{ route('user.invoices') }}" class="btn btn-secondary">📋 Lihat Invoice</a>
        <a href="{{ route('user.dashboard') }}" class="btn btn-primary">📊 Ke Dashboard</a>
      </div>
    </div>

  </div>
@endsection
