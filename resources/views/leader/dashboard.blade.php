@extends('layouts.leader')

@section('title', 'Dashboard Leader - HMI Tour')
@section('page-title', 'Dashboard Leader')
@section('page-description', 'Pantau performa tim dan aktivitas referral')

@push('styles')
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .quick-actions {
                grid-template-columns: 1fr;
            }
        }

        .quick-action-card {
            background: var(--color-fi-surface, #ffffff);
            border-radius: 1rem;
            padding: 2rem 1.5rem;
            border: 1px solid var(--color-fi-border, #e5e7eb);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .quick-action-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-4px);
            border-color: rgba(217, 119, 6, 0.3);
        }

        .quick-action-icon {
            width: 64px;
            height: 64px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .quick-action-icon.users {
            background: #eff6ff;
            color: #3b82f6;
        }

        .quick-action-card:hover .quick-action-icon.users {
            background: #3b82f6;
            color: white;
        }

        .quick-action-icon.report {
            background: #fee2e2;
            color: #8B1A1A;
        }

        .quick-action-card:hover .quick-action-icon.report {
            background: #8B1A1A;
            color: white;
        }

        .quick-action-icon.chart {
            background: #ecfdf5;
            color: #10b981;
        }

        .quick-action-card:hover .quick-action-icon.chart {
            background: #10b981;
            color: white;
        }

        .quick-action-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-fi-text-main, #111827);
        }

        .quick-action-desc {
            font-size: 0.875rem;
            color: var(--color-fi-text-muted, #6b7280);
            margin-bottom: 0;
        }

        .welcome-banner {
            background: linear-gradient(135deg, var(--color-fi-primary, #8B1A1A) 0%, var(--color-fi-primary-hover, #6B1010) 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -60%;
            right: 15%;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        .welcome-content {
            position: relative;
            z-index: 1;
        }

        .welcome-banner h2 {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
            border: none;
            padding: 0;
        }

        .welcome-banner p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            margin-bottom: 1.5rem;
            max-width: 600px;
        }

        .welcome-banner form {
            display: inline-block;
        }

        .welcome-banner .btn {
            background: white;
            color: #8B1A1A;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            display: inline-flex;
            border: none;
            cursor: pointer;
        }

        .welcome-banner .btn:hover {
            background: #fff7ed;
            transform: translateY(-1px);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media(max-width:1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            background: var(--color-fi-surface, #ffffff);
            border-radius: 0.75rem;
            padding: 1.5rem;
            border: 1px solid var(--color-fi-border, #e5e7eb);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-color: var(--color-fi-primary, #8B1A1A);
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .stat-card-icon.primary {
            background: #fee2e2;
            color: #8B1A1A;
        }

        .stat-card-icon.success {
            background: #ecfdf5;
            color: #10b981;
        }

        .stat-card-icon.warning {
            background: #fffbeb;
            color: #f59e0b;
        }

        .stat-card-icon.info {
            background: #eff6ff;
            color: #3b82f6;
        }

        .stat-card-label {
            font-size: 0.875rem;
            color: var(--color-fi-text-muted, #6b7280);
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .stat-card-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-fi-text-main, #111827);
            font-family: 'Inter', sans-serif;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--color-fi-text-main, #111827);
            margin-bottom: 0.25rem;
        }

        .section-subtitle {
            font-size: 0.875rem;
            color: var(--color-fi-text-muted, #6b7280);
            margin-bottom: 1.5rem;
        }

        .card-wrapper {
            background: var(--color-fi-surface, #ffffff);
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid var(--color-fi-border, #e5e7eb);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--color-fi-border, #e5e7eb);
            margin-bottom: 1rem;
        }
    </style>
@endpush

@section('content')
    <!-- Welcome Banner -->
    <section class="welcome-banner animate-fade-in-up" aria-label="Banner selamat datang">
        <div class="welcome-content">
            <h2>Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h2>
            <p>Pantau performa tim dan aktivitas referral Anda di dashboard Leader.</p>
            <div class="flex items-center gap-3">
                @if(Auth::user()->referral_code)
                    <div
                        class="bg-white/20 backdrop-blur-sm px-4 py-2.5 rounded-lg border border-white/30 text-white font-mono text-sm inline-flex items-center gap-3">
                        <span id="ref-code">{{ Auth::user()->referral_code }}</span>
                        <button onclick="copyToClipboard('{{ Auth::user()->referral_code }}')"
                            class="bg-white/30 hover:bg-white/40 cursor-pointer rounded p-1 transition-colors"
                            title="Salin kode">
                            📋
                        </button>
                        <input type="hidden" id="referral-link" value="{{ url('/login?ref=' . Auth::user()->referral_code) }}">
                        <button onclick="copyReferralLink()"
                            class="bg-white/30 hover:bg-white/40 cursor-pointer rounded p-1 transition-colors"
                            title="Salin link">
                            🔗
                        </button>
                    </div>
                @else
                    <form action="{{ route('leader.referral.regenerate') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn">
                            ✨ Generate Kode Referral
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <!-- Stats Grid -->
    <section class="stats-grid animate-fade-in-up delay-1" aria-label="Statistik Leader">
        <div class="stat-card">
            <div class="stat-card-icon primary">👥</div>
            <div class="stat-card-label">Total Downline</div>
            <div class="stat-card-value">{{ $totalDownline }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon success">💰</div>
            <div class="stat-card-label">Revenue Bulan Ini</div>
            <div class="stat-card-value">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon info">💎</div>
            <div class="stat-card-label">Total Revenue</div>
            <div class="stat-card-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon warning">⭐</div>
            <div class="stat-card-label">Status</div>
            <div class="stat-card-value text-green-600 text-lg flex items-center pt-1">
                <span
                    class="inline-flex rounded-full bg-green-100 text-green-800 px-3 py-1 font-semibold text-sm">Aktif</span>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section aria-label="Aksi cepat" class="animate-fade-in-up delay-2">
        <div class="section-header">
            <div>
                <h2 class="section-title">Aksi Cepat</h2>
                <p class="section-subtitle">Akses fitur utama dengan cepat</p>
            </div>
        </div>
        <div class="quick-actions">
            <a href="{{ route('leader.reports.index') }}" class="quick-action-card">
                <div class="quick-action-icon report">📊</div>
                <div>
                    <div class="quick-action-title">Laporan Penjualan</div>
                    <p class="quick-action-desc">Pantau performa penjualan tim</p>
                </div>
            </a>
            <a href="{{ route('leader.members.index') }}" class="quick-action-card">
                <div class="quick-action-icon users">👥</div>
                <div>
                    <div class="quick-action-title">Manajemen Tim</div>
                    <p class="quick-action-desc">Kelola referensi downline Anda</p>
                </div>
            </a>
            <a href="{{ route('leader.reports.crud') }}" class="quick-action-card">
                <div class="quick-action-icon chart">📈</div>
                <div>
                    <div class="quick-action-title">Analitik</div>
                    <p class="quick-action-desc">Lihat data laporan lebih detail</p>
                </div>
            </a>
        </div>
    </section>

    <!-- Dashboard Grid -->
    <div class="dashboard-grid animate-fade-in-up delay-3">
        <!-- Downline Table -->
        <section class="card-wrapper" style="grid-column: 1 / -1;" aria-label="Daftar Downline">
            <div class="card-header">
                <h3 style="margin-bottom: 0; font-size: 1.125rem; font-weight: 600; color: var(--color-fi-text-main);">
                    Daftar Downline Anda</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left whitespace-nowrap">
                    <thead>
                        <tr>
                            <th
                                class="py-3 px-4 text-xs font-semibold uppercase text-fi-text-muted border-b border-fi-border">
                                Nama</th>
                            <th
                                class="py-3 px-4 text-xs font-semibold uppercase text-fi-text-muted border-b border-fi-border">
                                Email</th>
                            <th
                                class="py-3 px-4 text-xs font-semibold uppercase text-fi-text-muted border-b border-fi-border">
                                Bergabung</th>
                            <th
                                class="py-3 px-4 text-xs font-semibold uppercase text-fi-text-muted border-b border-fi-border">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($downlines as $downline)
                            <tr class="hover:bg-fi-bg transition-colors duration-150">
                                <td
                                    class="py-4 px-4 text-sm text-fi-text-main border-b border-fi-border align-middle font-medium">
                                    {{ $downline->name }}</td>
                                <td class="py-4 px-4 text-sm text-fi-text-muted border-b border-fi-border align-middle">
                                    {{ $downline->email }}</td>
                                <td class="py-4 px-4 text-sm text-fi-text-main border-b border-fi-border align-middle">
                                    {{ $downline->created_at->format('d M Y') }}</td>
                                <td class="py-4 px-4 text-sm border-b border-fi-border align-middle">
                                    <span
                                        class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $downline->role === 'user' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($downline->role) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-fi-text-muted bg-gray-50 rounded-lg">Belum ada
                                    downline.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const codeEl = document.getElementById('ref-code');
                const original = codeEl.textContent;
                codeEl.textContent = 'Tersalin!';
                codeEl.style.color = '#10b981';
                setTimeout(() => {
                    codeEl.textContent = original;
                    codeEl.style.color = '';
                }, 1500);
            }).catch(() => {
                // Fallback untuk browser lama
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
            });
        }

        function copyReferralLink() {
            const linkInput = document.getElementById('referral-link');
            const link = linkInput.value;

            navigator.clipboard.writeText(link).then(() => {
                showCopyFeedback(event.target);
            }).catch(() => {
                linkInput.select();
                document.execCommand('copy');
                showCopyFeedback(event.target);
            });
        }

        function showCopyFeedback(button) {
            const originalText = button.textContent;
            button.textContent = '✓';
            button.style.background = 'rgba(16,185,129,0.5)';
            setTimeout(() => {
                button.textContent = originalText;
                button.style.background = '';
            }, 1500);
        }
    </script>
@endpush