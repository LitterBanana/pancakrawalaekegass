@extends('user.layouts.app')

@section('title', 'Profil Saya — HMI Tour Travel')
@section('description', 'Profil Anggota - HMI Tour Travel')

@section('page_styles')
  <style>
    .profile-container { max-width: var(--content-max-width); margin: 0 auto; }
    .profile-header-card { background: var(--color-surface); border-radius: var(--radius-2xl); overflow: hidden; border: 1px solid var(--color-border-light); box-shadow: var(--shadow-md); margin-bottom: var(--space-6); }
    .profile-cover { height: 120px; background: var(--color-primary-gradient); position: relative; }
    .profile-cover::before { content: ''; position: absolute; top: -50%; right: -10%; width: 300px; height: 300px; border-radius: 50%; background: rgba(255, 255, 255, 0.08); }
    .profile-info-section { padding: var(--space-5) var(--space-8) var(--space-6); display: flex; align-items: flex-end; gap: var(--space-6); margin-top: -36px; position: relative; z-index: 1; flex-wrap: wrap; }
    .profile-avatar-wrapper { flex-shrink: 0; }
    .profile-avatar { width: 88px; height: 88px; border-radius: var(--radius-2xl); background: var(--color-primary-gradient); color: var(--color-white); display: flex; align-items: center; justify-content: center; font-size: var(--text-3xl); font-weight: var(--font-bold); font-family: var(--font-heading); border: 4px solid var(--color-white); box-shadow: var(--shadow-lg); }
    .profile-main-info { flex: 1; min-width: 0; padding-top: var(--space-6); }
    .profile-name { font-size: var(--text-xl); font-weight: var(--font-bold); color: var(--color-text); margin-bottom: var(--space-1); line-height: 1.3; }
    .profile-member-id { font-size: var(--text-sm); color: var(--color-text-secondary); display: flex; align-items: center; gap: var(--space-2); }
    .profile-member-id .member-badge { background: var(--color-primary-50); color: var(--color-primary); padding: 2px 8px; border-radius: var(--radius-full); font-size: var(--text-xs); font-weight: var(--font-semibold); }
    .profile-actions { display: flex; gap: var(--space-3); flex-shrink: 0; padding-bottom: var(--space-2); }
    .profile-grid { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-6); }
    .info-card { background: var(--color-surface); border-radius: var(--radius-2xl); border: 1px solid var(--color-border-light); box-shadow: var(--shadow-sm); }
    .info-card-header { padding: var(--space-5) var(--space-6); border-bottom: 1px solid var(--color-border-light); display: flex; align-items: center; gap: var(--space-3); }
    .info-card-header h3 { font-size: var(--text-base); font-weight: var(--font-semibold); margin-bottom: 0; flex: 1; }
    .info-card-header .card-icon { color: var(--color-primary); font-size: var(--text-lg); }
    .info-card-body { padding: var(--space-6); }
    .info-row { display: flex; justify-content: space-between; align-items: flex-start; padding: var(--space-3) 0; border-bottom: 1px solid var(--color-border-light); }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-size: var(--text-sm); color: var(--color-text-secondary); flex-shrink: 0; min-width: 120px; }
    .info-value { font-size: var(--text-sm); font-weight: var(--font-medium); color: var(--color-text); text-align: right; }
    .tour-package-card { background: var(--color-surface); border-radius: var(--radius-2xl); border: 1px solid var(--color-border-light); box-shadow: var(--shadow-sm); overflow: hidden; }
    .tour-package-header { padding: var(--space-6); background: var(--color-primary-gradient); color: var(--color-white); position: relative; overflow: hidden; }
    .tour-package-header::before { content: ''; position: absolute; top: -40%; right: -10%; width: 150px; height: 150px; border-radius: 50%; background: rgba(255, 255, 255, 0.1); }
    .tour-package-header h3 { color: var(--color-white); font-size: var(--text-lg); margin-bottom: var(--space-1); position: relative; }
    .tour-package-header p { color: rgba(255, 255, 255, 0.8); font-size: var(--text-sm); margin-bottom: 0; position: relative; }
    .tour-package-body { padding: var(--space-6); }
    .tour-payment-progress { margin-bottom: var(--space-5); }
    .progress-header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-3); }
    .progress-text { font-size: var(--text-sm); color: var(--color-text-secondary); }
    .progress-percentage-text { font-size: var(--text-sm); font-weight: var(--font-bold); color: var(--color-primary); }
    .tour-amounts { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-4); margin-top: var(--space-5); }
    .tour-amount-item { padding: var(--space-4); background: var(--color-bg); border-radius: var(--radius-xl); text-align: center; }
    .tour-amount-label { font-size: var(--text-xs); color: var(--color-text-muted); margin-bottom: var(--space-1); text-transform: uppercase; letter-spacing: 0.05em; }
    .tour-amount-value { font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--color-text); }
    .tour-amount-value.remaining { color: var(--color-danger); }
    .tour-amount-value.paid { color: var(--color-success); }
    .tour-package-footer { padding: var(--space-4) var(--space-6); border-top: 1px solid var(--color-border-light); display: flex; gap: var(--space-3); }
  </style>
@endsection

@section('content')
  <div class="profile-container">

    <!-- Profile Header Card -->
    <section class="profile-header-card animate-fade-in-up" aria-label="Informasi profil utama">
      <div class="profile-cover"></div>
      <div class="profile-info-section">
        <div class="profile-avatar-wrapper">
          {{-- Inisial dari nama user asli --}}
          <div class="profile-avatar">
            {{ strtoupper(substr(explode(' ', trim($user->name))[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', trim($user->name))[1] ?? '', 0, 1)) }}
          </div>
        </div>
        <div class="profile-main-info">
          <h2 class="profile-name">{{ $user->name }}</h2>
          <div class="profile-member-id">
            {{-- Tampilkan badge role saja; referral code leader ditampilkan di card info --}}
            <span>{{ 'HMI-' . str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span>
            <span class="member-badge">{{ ucfirst($user->role ?? 'Anggota HMI') }}</span>
          </div>
        </div>
        <div class="profile-actions">
          <a href="{{ route('user.invoices') }}" class="btn btn-primary">
            📋 Travel Invoices
          </a>
          <a href="{{ route('user.payment') }}" class="btn btn-secondary">
            💳 Bayar
          </a>
        </div>
      </div>
    </section>

    <!-- Profile Content Grid -->
    <div class="profile-grid">

      <!-- Personal Info Card -->
      <section class="info-card animate-fade-in-up delay-1" aria-label="Informasi pribadi">
        <div class="info-card-header">
          <span class="card-icon">👤</span>
          <h3>Informasi Pribadi</h3>
        </div>
        <div class="info-card-body">
          <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value">{{ $user->email ?? '-' }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">Role</span>
            <span class="info-value">{{ ucfirst($user->role ?? '-') }}</span>
          </div>
          @if($user->referred_by)
            @php $leaderUser = App\Models\User::find($user->referred_by); @endphp
            <div class="info-row">
              <span class="info-label">Leader Referral</span>
              <span class="info-value" style="font-weight:700;">{{ $leaderUser?->name ?? '-' }}</span>
            </div>
            <div class="info-row">
              <span class="info-label">Kode Referral</span>
              {{-- Tampilkan kode referral leader, bukan kode user sendiri --}}
              <span class="info-value" style="font-family:monospace;font-weight:700;color:var(--color-primary);">
                {{ $leaderUser?->referral_code ?? '-' }}
              </span>
            </div>
          @else
            <div class="info-row">
              <span class="info-label">Kode Referral</span>
              <span class="info-value" style="color:var(--color-text-muted);">Tidak menggunakan referral</span>
            </div>
          @endif
          <div class="info-row">
            <span class="info-label">Bergabung</span>
            <span class="info-value">{{ $user->created_at ? $user->created_at->timezone('Asia/Jakarta')->format('d M Y') : '-' }}</span>
          </div>
        </div>
      </section>

      <!-- Tour Package Card -->
      <section class="tour-package-card animate-fade-in-up delay-2" aria-label="Paket tour">
        @if($booking)
          @php
            $pkg     = $booking->package;
            $price   = $booking->packagePrice;
            $usdRate = $booking->usd_rate ?? 15800; // fallback kurs
            $priceUSD = $price ? round($price->price / $usdRate, 0) : 0;
          @endphp
          <div class="tour-package-header">
            <h3>{{ $pkg->name ?? 'Paket Umrah' }}</h3>
            <p>Keberangkatan: {{ $pkg ? \Carbon\Carbon::parse($pkg->departure_date)->format('d M Y') : '-' }}</p>
          </div>
          <div class="tour-package-body">
            {{-- Rincian Paket --}}
            <div style="margin-bottom:var(--space-4);">
              <div class="info-row" style="border-color:var(--color-border-light);">
                <span class="info-label" style="font-size:var(--text-xs);color:var(--color-text-muted);">Jenis Paket</span>
                <span class="info-value" style="font-size:var(--text-xs);">{{ $pkg->category->name ?? '-' }}</span>
              </div>
              <div class="info-row" style="border-color:var(--color-border-light);">
                <span class="info-label" style="font-size:var(--text-xs);color:var(--color-text-muted);">Jenis Kamar</span>
                <span class="info-value" style="font-size:var(--text-xs);">{{ $price->type ?? '-' }}</span>
              </div>
              <div class="info-row" style="border-color:var(--color-border-light);">
                <span class="info-label" style="font-size:var(--text-xs);color:var(--color-text-muted);">Jumlah Orang</span>
                <span class="info-value" style="font-size:var(--text-xs);">{{ $booking->jumlah_orang }} orang</span>
              </div>
              <div class="info-row" style="border-color:var(--color-border-light);">
                <span class="info-label" style="font-size:var(--text-xs);color:var(--color-text-muted);">Harga/orang (IDR)</span>
                <span class="info-value" style="font-size:var(--text-xs);">Rp {{ number_format($price->price ?? 0, 0, ',', '.') }}</span>
              </div>
              <div class="info-row" style="border-color:var(--color-border-light);">
                <span class="info-label" style="font-size:var(--text-xs);color:var(--color-text-muted);">Harga/orang (USD)</span>
                <span class="info-value" style="font-size:var(--text-xs);">$ {{ number_format($priceUSD, 0, ',', '.') }}</span>
              </div>
              <div class="info-row" style="border-color:var(--color-border-light);">
                <span class="info-label" style="font-size:var(--text-xs);color:var(--color-text-muted);">Total Tagihan</span>
                <span class="info-value" style="font-size:var(--text-xs);font-weight:700;color:var(--color-primary);">Rp {{ number_format($totalCost, 0, ',', '.') }}</span>
              </div>
            </div>
            {{-- Progress --}}
            <div class="tour-payment-progress">
              <div class="progress-header-row">
                <span class="progress-text">Progress Pembayaran (Verified)</span>
                <span class="progress-percentage-text">{{ $percentage }}%</span>
              </div>
              <div class="progress-bar" style="height: 10px;">
                <div class="progress-fill" style="width: {{ $percentage }}%;"></div>
              </div>
            </div>
            {{-- Amounts --}}
            <div class="tour-amounts">
              <div class="tour-amount-item">
                <div class="tour-amount-label">Sudah Dibayar</div>
                <div class="tour-amount-value paid">Rp {{ number_format($paidAmount, 0, ',', '.') }}</div>
              </div>
              <div class="tour-amount-item">
                <div class="tour-amount-label">Sisa Tagihan</div>
                <div class="tour-amount-value remaining">Rp {{ number_format($remaining, 0, ',', '.') }}</div>
              </div>
            </div>
          </div>
        @else
          <div class="tour-package-header">
            <h3>Belum Ada Paket</h3>
            <p>Anda belum memiliki booking aktif</p>
          </div>
          <div class="tour-package-body">
            <p style="color:var(--color-text-muted);font-size:var(--text-sm);text-align:center;padding:var(--space-6) 0;">Silakan hubungi admin untuk mendaftarkan paket umrah Anda.</p>
          </div>
        @endif
        <div class="tour-package-footer">
          <a href="{{ route('user.invoices') }}" class="btn btn-secondary btn-sm" style="flex: 1;">
            📋 Lihat Invoice
          </a>
          <a href="{{ route('user.payment') }}" class="btn btn-primary btn-sm" style="flex: 1;">
            💳 Bayar Sekarang
          </a>
        </div>
      </section>

    </div>
  </div>
@endsection