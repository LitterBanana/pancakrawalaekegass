@extends('layouts.leader')

@section('title', 'Profil Saya — HMI Leader')
@section('page-title', 'Profil Saya')
@section('page-description', 'Informasi akun dan data keanggotaan leader')

@push('styles')
<style>
    /* ── Profile Container ── */
    .profile-container {
        max-width: 960px;
        margin: 0 auto;
    }

    /* ── Header Card ── */
    .profile-header-card {
        background: var(--color-fi-surface);
        border-radius: 1rem;
        border: 1px solid var(--color-fi-border);
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .profile-cover {
        height: 140px;
        background: linear-gradient(135deg, #8B1A1A 0%, #b91c1c 50%, #c2410c 100%);
        position: relative;
        overflow: hidden;
    }

    .profile-cover::before {
        content: '';
        position: absolute;
        top: -60%;
        right: -8%;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
    }

    .profile-cover::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: 10%;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
    }

    .profile-info-section {
        padding: 0 2rem 1.75rem;
        display: flex;
        align-items: flex-end;
        gap: 1.5rem;
        margin-top: -44px;
        position: relative;
        z-index: 1;
        flex-wrap: wrap;
    }

    /* ── Avatar ── */
    .profile-avatar-wrapper {
        flex-shrink: 0;
        position: relative;
    }

    .profile-avatar {
        width: 96px;
        height: 96px;
        border-radius: 1rem;
        background: linear-gradient(135deg, #8B1A1A, #b91c1c);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 800;
        font-family: 'Inter', sans-serif;
        border: 4px solid white;
        box-shadow: 0 6px 20px rgba(139, 26, 26, 0.25);
    }

    .avatar-status {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #10b981;
        border: 3px solid white;
    }

    /* ── Main Info ── */
    .profile-main-info {
        flex: 1;
        min-width: 0;
        padding-top: 1.75rem;
    }

    .profile-name {
        font-size: 1.375rem;
        font-weight: 700;
        color: var(--color-fi-text-main);
        margin: 0.5rem 0 0.375rem;
        line-height: 1.3;
    }

    .profile-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.8rem;
        color: var(--color-fi-text-muted);
        flex-wrap: wrap;
    }

    .profile-meta-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .role-badge {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        color: #8B1A1A;
        padding: 3px 12px;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: 1px solid #fecaca;
    }

    .member-id {
        font-family: monospace;
        font-size: 0.75rem;
        color: var(--color-fi-text-muted);
        background: var(--color-fi-bg);
        padding: 2px 8px;
        border-radius: 0.25rem;
    }

    /* ── Leader Stats Ribbon ── */
    .leader-stats-ribbon {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1px;
        background: var(--color-fi-border);
        border-radius: 0.75rem;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }

    .ribbon-stat {
        background: var(--color-fi-surface);
        padding: 1.25rem 1rem;
        text-align: center;
        transition: background 0.2s ease;
    }

    .ribbon-stat:hover {
        background: var(--color-fi-bg);
    }

    .ribbon-stat-icon {
        font-size: 1.25rem;
        margin-bottom: 0.375rem;
    }

    .ribbon-stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--color-fi-text-main);
        line-height: 1.2;
    }

    .ribbon-stat-label {
        font-size: 0.7rem;
        color: var(--color-fi-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-top: 0.125rem;
    }

    /* ── Profile Grid ── */
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    @media (max-width: 768px) {
        .profile-grid { grid-template-columns: 1fr; }
        .leader-stats-ribbon { grid-template-columns: repeat(3, 1fr); }
        .profile-info-section { padding: 0 1.25rem 1.5rem; gap: 1rem; }
    }

    @media (max-width: 480px) {
        .leader-stats-ribbon { grid-template-columns: 1fr; }
    }

    /* ── Info Card ── */
    .info-card {
        background: var(--color-fi-surface);
        border-radius: 1rem;
        border: 1px solid var(--color-fi-border);
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
        overflow: hidden;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .info-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }

    .info-card-header {
        padding: 1.125rem 1.5rem;
        border-bottom: 1px solid var(--color-fi-border);
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }

    .card-icon {
        width: 32px;
        height: 32px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .card-icon.account {
        background: #eff6ff;
        color: #3b82f6;
    }

    .card-icon.package {
        background: #fef2f2;
        color: #8B1A1A;
    }

    .info-card-header h3 {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--color-fi-text-main);
        margin: 0;
    }

    .info-card-body {
        padding: 1.25rem 1.5rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--color-fi-border);
        font-size: 0.85rem;
    }

    .info-row:last-child { border-bottom: none; }

    .info-label {
        color: var(--color-fi-text-muted);
        flex-shrink: 0;
        min-width: 110px;
    }

    .info-value {
        font-weight: 600;
        color: var(--color-fi-text-main);
        text-align: right;
        word-break: break-word;
    }

    /* ── Referral Box ── */
    .referral-section {
        margin-top: 1.25rem;
        background: linear-gradient(135deg, #fef2f2, #fff7ed);
        border: 1px solid #fecaca;
        border-radius: 0.75rem;
        padding: 1.25rem;
    }

    .referral-section-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--color-fi-text-muted);
        margin-bottom: 0.75rem;
    }

    .referral-code-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .referral-code-display {
        background: white;
        border: 1px solid #fecaca;
        border-radius: 0.5rem;
        padding: 0.625rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex: 1;
        min-width: 0;
    }

    .referral-code-text {
        font-size: 1.1rem;
        font-weight: 800;
        color: #8B1A1A;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.08em;
        flex: 1;
    }

    .referral-copy-btn {
        background: none;
        border: 1px solid #fecaca;
        border-radius: 0.375rem;
        padding: 0.375rem 0.625rem;
        cursor: pointer;
        font-size: 0.8rem;
        color: #8B1A1A;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        flex-shrink: 0;
    }

    .referral-copy-btn:hover {
        background: #fef2f2;
        border-color: #8B1A1A;
    }

    .referral-link-row {
        margin-top: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .referral-link-input {
        flex: 1;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
        color: var(--color-fi-text-muted);
        font-family: monospace;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .referral-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }

    /* ── Tour / Booking Card ── */
    .tour-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, #8B1A1A 0%, #b91c1c 60%, #c2410c 100%);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .tour-header::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -8%;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
    }

    .tour-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: 5%;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }

    .tour-header h3 {
        color: white;
        font-size: 1.05rem;
        font-weight: 700;
        margin: 0 0 0.25rem;
        position: relative;
    }

    .tour-header p {
        color: rgba(255,255,255,0.8);
        font-size: 0.8rem;
        margin: 0;
        position: relative;
    }

    .tour-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(4px);
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 600;
        color: white;
        margin-top: 0.5rem;
        position: relative;
    }

    /* ── Progress ── */
    .progress-section {
        margin-top: 1.25rem;
    }

    .progress-label-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        color: var(--color-fi-text-muted);
        margin-bottom: 0.375rem;
    }

    .progress-pct {
        font-weight: 700;
        color: var(--color-fi-primary);
    }

    .progress-bar-track {
        height: 10px;
        background: var(--color-fi-bg);
        border-radius: 9999px;
        overflow: hidden;
        position: relative;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #8B1A1A, #b91c1c, #c2410c);
        border-radius: 9999px;
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .progress-bar-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(
            90deg,
            transparent 0%,
            rgba(255,255,255,0.3) 50%,
            transparent 100%
        );
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* ── Amount Grid ── */
    .amount-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .amount-item {
        background: var(--color-fi-bg);
        border-radius: 0.625rem;
        padding: 1rem;
        text-align: center;
        border: 1px solid transparent;
        transition: border-color 0.2s ease;
    }

    .amount-item:hover {
        border-color: var(--color-fi-border);
    }

    .amount-label {
        font-size: 0.7rem;
        color: var(--color-fi-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.375rem;
    }

    .amount-value {
        font-size: 1rem;
        font-weight: 700;
        color: var(--color-fi-text-main);
    }

    .amount-value.paid    { color: #065f46; }
    .amount-value.due     { color: #991b1b; }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 2.5rem 1.5rem;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 0.75rem;
        display: block;
    }

    .empty-state-text {
        color: var(--color-fi-text-muted);
        font-size: 0.875rem;
        line-height: 1.6;
    }

    /* ── Copy feedback toast ── */
    .copy-toast {
        position: fixed;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: #065f46;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        z-index: 9999;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
    }

    .copy-toast.show {
        transform: translateX(-50%) translateY(0);
    }
</style>
@endpush

@section('content')
<div class="profile-container">

    {{-- Profile Header --}}
    <div class="profile-header-card animate-fade-in-up">
        <div class="profile-cover"></div>
        <div class="profile-info-section">
            <div class="profile-avatar-wrapper">
                <div class="profile-avatar">
                    {{ strtoupper(substr(explode(' ', trim($user->name))[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', trim($user->name))[1] ?? '', 0, 1)) }}
                </div>
                <div class="avatar-status" title="Online"></div>
            </div>
            <div class="profile-main-info">
                <h2 class="profile-name margin-top">{{ $user->name }}</h2>
                <div class="profile-meta">
                    <span class="profile-meta-item">📧 {{ $user->email }}</span>
                    <span class="member-id">HMI-{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span>
                    <span class="role-badge">Leader</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Leader Stats Ribbon --}}
    @php
        $downlineCount = $user->referrals()->count();
        $activeBookings = \App\Models\Booking::whereIn('user_id', $user->referrals()->pluck('id'))
            ->whereNotIn('status', ['cancel'])
            ->count();
    @endphp
    <div class="leader-stats-ribbon animate-fade-in-up delay-1">
        <div class="ribbon-stat">
            <div class="ribbon-stat-icon">👥</div>
            <div class="ribbon-stat-value">{{ $downlineCount }}</div>
            <div class="ribbon-stat-label">Total Downline</div>
        </div>
        <div class="ribbon-stat">
            <div class="ribbon-stat-icon">📦</div>
            <div class="ribbon-stat-value">{{ $activeBookings }}</div>
            <div class="ribbon-stat-label">Booking Aktif</div>
        </div>
        <div class="ribbon-stat">
            <div class="ribbon-stat-icon">📅</div>
            <div class="ribbon-stat-value">{{ $user->created_at ? $user->created_at->timezone('Asia/Jakarta')->format('d M Y') : '-' }}</div>
            <div class="ribbon-stat-label">Bergabung Sejak</div>
        </div>
    </div>

    {{-- Profile Grid --}}
    <div class="profile-grid">

        {{-- Info Akun --}}
        <div class="info-card animate-fade-in-up delay-2">
            <div class="info-card-header">
                <div class="card-icon account">👤</div>
                <h3>Informasi Akun</h3>
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value">{{ $user->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Role</span>
                    <span class="info-value">
                        <span style="background:#ecfdf5;color:#065f46;padding:2px 10px;border-radius:9999px;font-size:0.75rem;font-weight:600;">Leader</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Bergabung</span>
                    <span class="info-value">{{ $user->created_at ? $user->created_at->timezone('Asia/Jakarta')->format('d M Y') : '-' }}</span>
                </div>
                @if($user->referred_by)
                <div class="info-row">
                    <span class="info-label">Direkrut Oleh</span>
                    <span class="info-value" style="color:var(--color-fi-primary);font-weight:700;">
                        {{ optional(\App\Models\User::find($user->referred_by))->name ?? '-' }}
                    </span>
                </div>
                @endif

                {{-- Referral Section --}}
                <div class="referral-section">
                    <div class="referral-section-title">🔗 Kode Referral Saya</div>
                    @if($user->referral_code)
                        <div class="referral-code-row">
                            <div class="referral-code-display">
                                <span class="referral-code-text" id="ref-code">{{ $user->referral_code }}</span>
                                <button type="button" class="referral-copy-btn" onclick="copyCode()" title="Salin kode referral">
                                    📋 Salin
                                </button>
                            </div>
                        </div>
                        <div class="referral-link-row">
                            <input type="text" class="referral-link-input" id="referral-link"
                                   value="{{ url('/login?ref=' . $user->referral_code) }}" readonly>
                            <button type="button" class="referral-copy-btn" onclick="copyLink()" title="Salin link referral">
                                🔗 Link
                            </button>
                        </div>
                        <div class="referral-actions">
                            <form action="{{ route('leader.referral.regenerate') }}" method="POST" style="flex-shrink:0;">
                                @csrf
                                <button type="submit" class="btn btn-ghost btn-sm">
                                    🔄 Generate Ulang
                                </button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('leader.referral.regenerate') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">
                                ✨ Generate Kode Referral
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Info Paket / Booking Pribadi --}}
        <div class="info-card animate-fade-in-up delay-3">
            @if($booking)
                @php
                    $pkg   = $booking->package;
                    $price = $booking->packagePrice;
                @endphp
                <div class="tour-header">
                    <h3>{{ $pkg->name ?? 'Paket Umroh' }}</h3>
                    <p>Keberangkatan: {{ $pkg ? \Carbon\Carbon::parse($pkg->departure_date)->format('d M Y') : '-' }}</p>
                    @if($percentage >= 100)
                        <div class="tour-status-badge">✅ Lunas</div>
                    @elseif($percentage > 0)
                        <div class="tour-status-badge">⏳ Cicilan Berjalan</div>
                    @else
                        <div class="tour-status-badge">🔴 Belum Bayar</div>
                    @endif
                </div>
                <div class="info-card-body">
                    <div class="info-row">
                        <span class="info-label">Jenis Paket</span>
                        <span class="info-value">{{ $pkg->category->name ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jenis Kamar</span>
                        <span class="info-value">{{ $price->type ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jumlah Orang</span>
                        <span class="info-value">{{ $booking->jumlah_orang }} orang</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Total Tagihan</span>
                        <span class="info-value" style="color:var(--color-fi-primary);font-weight:700;">
                            Rp {{ number_format($totalCost, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Progress --}}
                    <div class="progress-section">
                        <div class="progress-label-row">
                            <span>Progress Pembayaran</span>
                            <span class="progress-pct">{{ $percentage }}%</span>
                        </div>
                        <div class="progress-bar-track">
                            <div class="progress-bar-fill" style="width:{{ $percentage }}%;"></div>
                        </div>
                    </div>

                    <div class="amount-grid">
                        <div class="amount-item">
                            <div class="amount-label">Sudah Dibayar</div>
                            <div class="amount-value paid">Rp {{ number_format($paidAmount, 0, ',', '.') }}</div>
                        </div>
                        <div class="amount-item">
                            <div class="amount-label">Sisa Tagihan</div>
                            <div class="amount-value due">Rp {{ number_format($remaining, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="tour-header">
                    <h3>Belum Ada Booking</h3>
                    <p>Anda belum memiliki paket umroh aktif</p>
                </div>
                <div class="info-card-body">
                    <div class="empty-state">
                        <span class="empty-state-icon">🕌</span>
                        <p class="empty-state-text">
                            Belum ada booking paket umroh atas nama Anda.<br>
                            Hubungi admin untuk mendaftar.
                        </p>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>

{{-- Copy Toast --}}
<div class="copy-toast" id="copyToast">✅ Berhasil disalin!</div>

@endsection

@push('scripts')
<script>
    function showToast(message) {
        const toast = document.getElementById('copyToast');
        toast.textContent = '✅ ' + message;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2000);
    }

    function copyCode() {
        const code = document.getElementById('ref-code').textContent.trim();
        navigator.clipboard.writeText(code).then(() => {
            showToast('Kode referral disalin!');
        }).catch(() => {
            // Fallback untuk browser lama
            fallbackCopy(code);
            showToast('Kode referral disalin!');
        });
    }

    function copyLink() {
        const link = document.getElementById('referral-link').value;
        navigator.clipboard.writeText(link).then(() => {
            showToast('Link referral disalin!');
        }).catch(() => {
            fallbackCopy(link);
            showToast('Link referral disalin!');
        });
    }

    function fallbackCopy(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
    }
</script>
@endpush
