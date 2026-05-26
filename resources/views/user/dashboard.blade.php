@extends('user.layouts.app')

@section('title', 'Dashboard — HMI Tour Travel')
@section('description', 'Dashboard HMI Tour Travel - Pantau pembayaran tour Anda')

@section('page_styles')
  <style>
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--space-6); margin-bottom: var(--space-8); }
    .quick-actions { display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-6); margin-bottom: var(--space-8); }
    .quick-action-card { background: var(--color-surface); border-radius: var(--radius-2xl); padding: var(--space-8) var(--space-6); border: 1px solid var(--color-border-light); box-shadow: var(--shadow-sm); text-align: center; cursor: pointer; transition: var(--transition-base); text-decoration: none; display: flex; flex-direction: column; align-items: center; gap: var(--space-4); }
    .quick-action-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); border-color: var(--color-primary-200); }
    .quick-action-icon { width: 64px; height: 64px; border-radius: var(--radius-2xl); display: flex; align-items: center; justify-content: center; font-size: var(--text-2xl); transition: var(--transition-base); }
    .quick-action-icon.pay { background: var(--color-primary-50); color: var(--color-primary); }
    .quick-action-card:hover .quick-action-icon.pay { background: var(--color-primary); color: var(--color-white); }
    .quick-action-icon.invoice { background: var(--color-info-bg); color: var(--color-info); }
    .quick-action-card:hover .quick-action-icon.invoice { background: var(--color-info); color: var(--color-white); }
    .quick-action-icon.profile { background: var(--color-success-bg); color: var(--color-success); }
    .quick-action-card:hover .quick-action-icon.profile { background: var(--color-success); color: var(--color-white); }
    .quick-action-title { font-size: var(--text-base); font-weight: var(--font-semibold); color: var(--color-text); }
    .quick-action-desc { font-size: var(--text-sm); color: var(--color-text-secondary); margin-bottom: 0; }
    .payment-progress-card { background: var(--color-surface); border-radius: var(--radius-2xl); padding: var(--space-6); border: 1px solid var(--color-border-light); box-shadow: var(--shadow-sm); margin-bottom: var(--space-8); }
    .progress-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-4); }
    .progress-info { display: flex; align-items: baseline; gap: var(--space-2); }
    .progress-percentage { font-family: var(--font-heading); font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-primary); }
    .progress-label { font-size: var(--text-sm); color: var(--color-text-secondary); }
    .progress-amounts { display: flex; gap: var(--space-8); margin-top: var(--space-4); }
    .progress-amount-item { display: flex; flex-direction: column; gap: var(--space-1); }
    .progress-amount-label { font-size: var(--text-xs); color: var(--color-text-muted); text-transform: uppercase; letter-spacing: 0.05em; }
    .progress-amount-value { font-size: var(--text-lg); font-weight: var(--font-semibold); color: var(--color-text); }
    .recent-transactions { background: var(--color-surface); border-radius: var(--radius-2xl); border: 1px solid var(--color-border-light); box-shadow: var(--shadow-sm); }
    .transaction-item { display: flex; align-items: center; gap: var(--space-4); padding: var(--space-4) var(--space-6); border-bottom: 1px solid var(--color-border-light); transition: var(--transition-fast); }
    .transaction-item:last-child { border-bottom: none; }
    .transaction-item:hover { background: var(--color-primary-50); }
    .transaction-icon { width: 44px; height: 44px; border-radius: var(--radius-xl); display: flex; align-items: center; justify-content: center; font-size: var(--text-lg); flex-shrink: 0; }
    .transaction-icon.transfer { background: var(--color-info-bg); color: var(--color-info); }
    .transaction-icon.cash { background: var(--color-success-bg); color: var(--color-success); }
    .transaction-details { flex: 1; min-width: 0; }
    .transaction-method { font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-text); margin-bottom: 2px; }
    .transaction-date { font-size: var(--text-xs); color: var(--color-text-muted); }
    .transaction-amount { text-align: right; }
    .transaction-value { font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-text); }
    .transaction-status { margin-top: 2px; }
    .welcome-banner { background: var(--color-primary-gradient); border-radius: var(--radius-2xl); padding: var(--space-8); margin-bottom: var(--space-8); position: relative; overflow: hidden; }
    .welcome-banner::before { content: ''; position: absolute; top: -50%; right: -10%; width: 300px; height: 300px; border-radius: 50%; background: rgba(255, 255, 255, 0.08); }
    .welcome-banner::after { content: ''; position: absolute; bottom: -60%; right: 15%; width: 200px; height: 200px; border-radius: 50%; background: rgba(255, 255, 255, 0.05); }
    .welcome-content { position: relative; z-index: 1; }
    .welcome-banner h2 { color: var(--color-white); font-size: var(--text-2xl); margin-bottom: var(--space-2); }
    .welcome-banner p { color: rgba(255, 255, 255, 0.85); font-size: var(--text-base); margin-bottom: var(--space-6); max-width: 600px; }
    .welcome-banner .btn { background: var(--color-white); color: var(--color-primary); font-weight: var(--font-semibold); }
    .welcome-banner .btn:hover { background: var(--color-primary-50); transform: translateY(-1px); }
    .dashboard-grid { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-6); }
  </style>
@endsection

@section('content')
  <!-- Welcome Banner -->
  <section class="welcome-banner animate-fade-in-up" aria-label="Banner selamat datang">
    <div class="welcome-content">
      <h2>Halo, {{ explode(' ', $user->name)[0] }}! 👋</h2>
      <p>Pantau progress pembayaran tour Anda dan lakukan pembayaran dengan mudah melalui sistem kami.</p>
      @if(session()->has('impersonate_user_id'))
      <button class="btn btn-lg" style="opacity: 0.7; cursor: not-allowed; background: var(--color-white); color: var(--color-text-muted);" onclick="alert('Fitur pembayaran dikunci selama Anda melakukan akses dari Dashboard Admin.')">
        🔒 Bayar Sekarang (Terkunci)
      </button>
      @else
      <a href="{{ route('user.payment') }}" class="btn btn-lg">
        💳 Bayar Sekarang
      </a>
      @endif
    </div>
  </section>

  <!-- Stats Grid -->
  <section class="stats-grid" aria-label="Statistik pembayaran">
    <div class="stat-card animate-fade-in-up delay-1">
      <div class="stat-card-icon primary">💰</div>
      <div class="stat-card-label">Total Tagihan</div>
      <div class="stat-card-value">Rp {{ number_format($totalCost, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card animate-fade-in-up delay-2">
      <div class="stat-card-icon success">✅</div>
      <div class="stat-card-label">Sudah Dibayar</div>
      <div class="stat-card-value">Rp {{ number_format($paidAmount, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card animate-fade-in-up delay-3">
      <div class="stat-card-icon warning">⏳</div>
      <div class="stat-card-label">Sisa Tagihan</div>
      <div class="stat-card-value">Rp {{ number_format($remaining, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card animate-fade-in-up delay-4">
      <div class="stat-card-icon info">📌</div>
      <div class="stat-card-label">Status</div>
      <div class="stat-card-value">
        @if($totalCost == 0)
          <span class="badge badge-neutral badge-dot">Belum Ada Tagihan</span>
        @elseif($isPaid)
          <span class="badge badge-success badge-dot">Lunas</span>
        @else
          <span class="badge badge-warning badge-dot">Belum Lunas</span>
        @endif
      </div>
    </div>
  </section>

  <!-- Quick Actions -->
  <section aria-label="Aksi cepat">
    <div class="section-header">
      <div>
        <h2 class="section-title">Aksi Cepat</h2>
        <p class="section-subtitle">Akses fitur utama dengan cepat</p>
      </div>
    </div>
    <div class="quick-actions">
      @if(session()->has('impersonate_user_id'))
      <div class="quick-action-card animate-fade-in-up delay-2" style="opacity: 0.6; cursor: not-allowed;" onclick="alert('Fitur pembayaran dikunci selama Anda melakukan akses dari Dashboard Admin.')">
        <div class="quick-action-icon" style="background:var(--color-bg-alt); color:var(--color-text-muted);">🔒</div>
        <div>
          <div class="quick-action-title">Bayar Sekarang</div>
          <p class="quick-action-desc" style="color:var(--color-danger);">Terkunci mode impersonasi</p>
        </div>
      </div>
      @else
      <a href="{{ route('user.payment') }}" class="quick-action-card animate-fade-in-up delay-2">
        <div class="quick-action-icon pay">💳</div>
        <div>
          <div class="quick-action-title">Bayar Sekarang</div>
          <p class="quick-action-desc">Lakukan pembayaran cicilan tour Anda</p>
        </div>
      </a>
      @endif
      <a href="{{ route('user.invoices') }}" class="quick-action-card animate-fade-in-up delay-3">
        <div class="quick-action-icon invoice">📋</div>
        <div>
          <div class="quick-action-title">Travel Invoices</div>
          <p class="quick-action-desc">Lihat & cetak invoice pembayaran</p>
        </div>
      </a>
      <a href="{{ route('user.profile') }}" class="quick-action-card animate-fade-in-up delay-4">
        <div class="quick-action-icon profile">👤</div>
        <div>
          <div class="quick-action-title">Profil Saya</div>
          <p class="quick-action-desc">Kelola informasi akun Anda</p>
        </div>
      </a>
    </div>
  </section>

  <!-- Dashboard Grid -->
  <div class="dashboard-grid">
    <!-- Payment Progress -->
    <section class="payment-progress-card animate-fade-in-up delay-3" aria-label="Progress pembayaran">
      <div class="card-header" style="border-bottom: none; padding-bottom: 0;">
        <h3 style="margin-bottom: 0; font-size: var(--text-base);">Progress Pembayaran</h3>
        @if($booking)
          <span class="badge badge-info badge-dot">Aktif</span>
        @else
          <span class="badge badge-neutral badge-dot">Belum Ada Booking</span>
        @endif
      </div>
      <div class="card-body">
        <div class="progress-header">
          <div class="progress-info">
            <span class="progress-percentage">{{ $percentage }}%</span>
            <span class="progress-label">terbayar</span>
          </div>
        </div>
        <div class="progress-bar" style="height: 12px; border-radius: var(--radius-full);">
          <div class="progress-fill {{ $isPaid ? 'success' : '' }}" style="width: {{ $percentage }}%;"></div>
        </div>
        <div class="progress-amounts">
          <div class="progress-amount-item">
            <span class="progress-amount-label">Dibayar</span>
            <span class="progress-amount-value">Rp {{ number_format($paidAmount, 0, ',', '.') }}</span>
          </div>
          <div class="progress-amount-item">
            <span class="progress-amount-label">Total</span>
            <span class="progress-amount-value">Rp {{ number_format($totalCost, 0, ',', '.') }}</span>
          </div>
          <div class="progress-amount-item">
            <span class="progress-amount-label">Sisa</span>
            <span class="progress-amount-value" style="color: var(--color-danger);">Rp {{ number_format($remaining, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Recent Transactions -->
    <section class="recent-transactions animate-fade-in-up delay-4" aria-label="Transaksi terbaru">
      <div class="card-header">
        <h3 style="margin-bottom: 0; font-size: var(--text-base);">Transaksi Terbaru</h3>
        <a href="{{ route('user.invoices') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
      </div>
      <div>
        @forelse($recentPayments as $payment)
          <div class="transaction-item">
            <div class="transaction-icon {{ $payment->payment_method === 'transfer' ? 'transfer' : 'cash' }}">
              {{ $payment->payment_method === 'transfer' ? '🏦' : '💵' }}
            </div>
            <div class="transaction-details">
              <div class="transaction-method">
                {{ ucfirst($payment->payment_method) }}{{ $payment->bank_name ? ' - ' . strtoupper($payment->bank_name) : '' }}
              </div>
              <div class="transaction-date">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</div>
            </div>
            <div class="transaction-amount">
              <div class="transaction-value">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
              <div class="transaction-status">
                @if($payment->status === 'sudah_lunas')
                  <span class="badge badge-success">Terverifikasi</span>
                @elseif($payment->status === 'ditolak')
                  <span class="badge badge-danger">Ditolak</span>
                @else
                  <span class="badge badge-warning">Pending</span>
                @endif
              </div>
            </div>
          </div>
        @empty
          <div class="empty-state" style="padding: var(--space-8);">
            <div class="empty-state-icon">💳</div>
            <h3 class="empty-state-title">Belum Ada Transaksi</h3>
            <p class="empty-state-text">Mulai pembayaran pertama Anda sekarang.</p>
          </div>
        @endforelse
      </div>
    </section>
  </div>
@endsection
