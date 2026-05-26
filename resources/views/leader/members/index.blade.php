@extends('layouts.leader')

@section('title', 'Daftar Anggota - HMI Leader')
@section('page-title', 'Daftar Anggota')
@section('page-description', 'Kelola anggota referral dan downline Anda dari halaman leader.')

@push('styles')
<style>
    /* ── Stats Grid ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px)  { .stats-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: var(--color-fi-surface);
        border-radius: 0.75rem;
        border: 1px solid var(--color-fi-border);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        transition: box-shadow 0.15s ease;
    }

    .stat-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .stat-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 0.625rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
    }

    /* Warna icon per variant */
    .stat-card-icon.primary { background: var(--color-fi-primary-50); color: var(--color-fi-primary); }
    .stat-card-icon.success { background: #ecfdf5; color: #065f46; }
    .stat-card-icon.warning { background: #fffbeb; color: #92400e; }
    .stat-card-icon.info    { background: #eff6ff; color: #1e40af; }

    .stat-card-label {
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--color-fi-text-muted);
    }

    .stat-card-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--color-fi-text-main);
        line-height: 1.2;
    }

    /* ── Section Title ── */
    .section-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--color-fi-text-main);
        margin: 0;
    }
</style>
@endpush

@section('content')
<div class="stats-grid animate-fade-in-up">
    <div class="stat-card">
        <div class="stat-card-icon primary" style="font-size: 1.75rem;">👥</div>
        <div class="stat-card-label">Total Anggota</div>
        <div class="stat-card-value">{{ $members->total() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon success" style="font-size: 1.75rem;">📈</div>
        <div class="stat-card-label">Anggota Aktif</div>
        <div class="stat-card-value">{{ $members->total() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon warning" style="font-size: 1.75rem;">⭐</div>
        <div class="stat-card-label">Kode Referral</div>
        <div class="stat-card-value" style="font-size:1rem;font-family:monospace;">{{ $leader->referral_code ?? '-' }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon info" style="font-size: 1.75rem;">🗓️</div>
        <div class="stat-card-label">Terakhir Bergabung</div>
        <div class="stat-card-value" style="font-size:1rem;">
            {{ $members->first() ? $members->first()->created_at->format('d M Y') : '-' }}
        </div>
    </div>
</div>

<div class="card animate-fade-in-up delay-1">
    <div class="card-header">
        <h3 class="section-title">Daftar Anggota Referral</h3>
        <a href="{{ route('leader.members.crud') }}" class="btn btn-primary btn-sm">Kelola Anggota</a>
    </div>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Peran</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                    <tr>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ ucfirst($member->role) }}</td>
                        <td>{{ $member->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center" style="padding: 2rem;">Belum ada anggota referral.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
