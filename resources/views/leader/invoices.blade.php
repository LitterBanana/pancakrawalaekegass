@extends('layouts.leader')

@section('title', 'Invoice Komisi — HMI Leader')
@section('page-title', 'Invoice Downline')
@section('page-description', 'Rekap komisi Anda berdasarkan downline yang telah melunasi pembayaran')

@push('styles')
<style>
    /* ── Stat Grid ── */
    .inv-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 1024px) { .inv-stat-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px)  { .inv-stat-grid { grid-template-columns: 1fr; } }

    .inv-stat-card {
        background: var(--color-fi-surface);
        border-radius: 0.75rem;
        border: 1px solid var(--color-fi-border);
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: box-shadow .15s ease;
    }

    .inv-stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.08); }

    .inv-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 0.625rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .inv-stat-icon.green  { background: #ecfdf5; }
    .inv-stat-icon.blue   { background: #eff6ff; }
    .inv-stat-icon.yellow { background: #fffbeb; }
    .inv-stat-icon.red    { background: var(--color-fi-primary-50); }

    .inv-stat-label {
        font-size: 0.72rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--color-fi-text-muted);
        margin-bottom: 0.2rem;
    }

    .inv-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-fi-text-main);
        line-height: 1.2;
    }

    .inv-stat-value.revenue {
        font-size: 1.1rem;
        color: var(--color-fi-primary);
    }

    /* ── Filter Bar ── */
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .filter-input {
        flex: 1;
        min-width: 200px;
        padding: 0.5rem 0.875rem;
        border: 1px solid var(--color-fi-border);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-family: inherit;
        color: var(--color-fi-text-main);
        background: var(--color-fi-surface);
        outline: none;
        transition: border-color .15s ease;
    }

    .filter-input:focus { border-color: var(--color-fi-primary); }

    /* ── Month Section ── */
    .month-section {
        margin-bottom: 2rem;
    }

    .month-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        background: var(--color-fi-bg);
        border-bottom: 1px solid var(--color-fi-border);
    }

    .month-label {
        font-size: 1rem;
        font-weight: 700;
        color: var(--color-fi-text-main);
    }

    .month-total {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--color-fi-primary);
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--color-fi-text-muted);
    }

    .empty-state-icon { font-size: 2.5rem; margin-bottom: 0.75rem; }

    .empty-state h3 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--color-fi-text-main);
        margin-bottom: 0.25rem;
    }

    /* ── Commission per-person ── */
    .commission-rate {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        background: #ecfdf5;
        color: #065f46;
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

{{-- Stat Cards --}}
<div class="inv-stat-grid animate-fade-in-up">
    <div class="inv-stat-card">
        <div class="inv-stat-icon red">💰</div>
        <div>
            <div class="inv-stat-label">Total Komisi</div>
            <div class="inv-stat-value revenue">Rp {{ number_format($totalCommission, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="inv-stat-card">
        <div class="inv-stat-icon green">👥</div>
        <div>
            <div class="inv-stat-label">Total Jamaah</div>
            <div class="inv-stat-value">{{ $totalPeople }}</div>
        </div>
    </div>
    <div class="inv-stat-card">
        <div class="inv-stat-icon blue">📋</div>
        <div>
            <div class="inv-stat-label">Booking Lunas</div>
            <div class="inv-stat-value">{{ $totalBookings }}</div>
        </div>
    </div>
    <div class="inv-stat-card">
        <div class="inv-stat-icon yellow">📅</div>
        <div>
            <div class="inv-stat-label">Periode</div>
            <div class="inv-stat-value" style="font-size:1rem;">{{ $totalMonths }} Bulan</div>
        </div>
    </div>
</div>

{{-- Main Card --}}
<div class="card animate-fade-in-up delay-1">
    <div class="card-header">
        <h3 style="font-size:0.9rem;font-weight:600;margin:0;color:var(--color-fi-text-main);">
            🧾 Invoice Komisi Downline
        </h3>
        <span class="commission-rate">💰 Rp 200.000 / orang</span>
    </div>

    {{-- Filter --}}
    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--color-fi-border);">
        <form method="GET" action="{{ route('leader.invoices.index') }}">
            <div class="filter-bar">
                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="Cari nama jamaah atau paket..."
                    class="filter-input">
                <button type="submit" class="btn btn-primary btn-sm">🔍 Cari</button>
                @if(request('keyword'))
                    <a href="{{ route('leader.invoices.index') }}" class="btn btn-ghost btn-sm">✕ Reset</a>
                @endif
            </div>
        </form>
    </div>

    @if($groupedByMonth->count() > 0)
        @foreach($groupedByMonth as $monthKey => $items)
            @php
                $monthLabel    = $items->first()['month_label'] ?? $monthKey;
                $monthTotal    = $items->sum('commission');
                $monthPeople   = $items->sum('jumlah_orang');
            @endphp
            <div class="month-section">
                <div class="month-header">
                    <div>
                        <span class="month-label">📅 {{ $monthLabel }}</span>
                        <span style="font-size:0.8rem;color:var(--color-fi-text-muted);margin-left:0.5rem;">
                            ({{ $monthPeople }} orang, {{ $items->count() }} booking)
                        </span>
                    </div>
                    <span class="month-total">Rp {{ number_format($monthTotal, 0, ',', '.') }}</span>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Jamaah</th>
                                <th>Paket</th>
                                <th>Tipe Kamar</th>
                                <th style="text-align:center;">Jumlah Orang</th>
                                <th>Tgl. Lunas</th>
                                <th style="text-align:right;">Komisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $idx => $item)
                                <tr>
                                    <td style="color:var(--color-fi-text-muted);font-size:0.8rem;">{{ $idx + 1 }}</td>
                                    <td>
                                        <div style="font-weight:600;color:var(--color-fi-text-main);">
                                            {{ $item['user']->name ?? '—' }}
                                        </div>
                                        <div style="font-size:0.75rem;color:var(--color-fi-text-muted);">
                                            {{ $item['user']->email ?? '' }}
                                        </div>
                                    </td>
                                    <td>{{ $item['package']->name ?? '—' }}</td>
                                    <td style="text-transform:capitalize;">{{ $item['price_type'] }}</td>
                                    <td style="text-align:center;font-weight:600;">{{ $item['jumlah_orang'] }}</td>
                                    <td style="font-size:0.82rem;">{{ $item['lunas_date']->format('d M Y') }}</td>
                                    <td style="text-align:right;font-weight:700;color:#065f46;">
                                        Rp {{ number_format($item['commission'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <h3>Belum Ada Invoice Komisi</h3>
            <p style="font-size:0.875rem;">
                @if(request('keyword'))
                    Tidak ada data yang cocok dengan pencarian Anda.
                @else
                    Belum ada downline yang melunasi pembayaran secara penuh.
                @endif
            </p>
        </div>
    @endif
</div>

@endsection
