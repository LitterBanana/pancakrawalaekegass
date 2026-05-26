@extends('layouts.leader')

@section('title', 'Analitik - HMI Tour')
@section('page-title', 'Analitik')
@section('page-description', 'Data performa tim dan tren referral')

@push('styles')
    <style>
        .analytics-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 1024px) {
            .analytics-grid {
                grid-template-columns: 1fr;
            }
        }

        .analytics-card {
            background: var(--color-fi-surface, #ffffff);
            border-radius: 0.75rem;
            border: 1px solid var(--color-fi-border, #e5e7eb);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .analytics-card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--color-fi-border, #e5e7eb);
        }

        .analytics-card-header h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-fi-text-main, #111827);
            margin: 0;
        }

        .analytics-card-header p {
            font-size: 0.8rem;
            color: var(--color-fi-text-muted, #6b7280);
            margin: 0.25rem 0 0;
        }

        .analytics-card-body {
            padding: 1.5rem;
        }

        /* Bar Chart */
        .bar-chart {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .bar-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .bar-label {
            min-width: 80px;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--color-fi-text-muted, #6b7280);
            text-align: right;
        }

        .bar-track {
            flex: 1;
            height: 28px;
            background: var(--color-fi-bg, #f9fafb);
            border-radius: 0.375rem;
            overflow: hidden;
            position: relative;
        }

        .bar-fill {
            height: 100%;
            border-radius: 0.375rem;
            transition: width 0.6s ease;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 0.5rem;
            font-size: 0.7rem;
            font-weight: 600;
            color: white;
            min-width: fit-content;
        }

        .bar-fill.revenue {
            background: linear-gradient(90deg, #8B1A1A, #b91c1c);
        }

        .bar-fill.members {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
        }

        .bar-value {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--color-fi-text-main, #111827);
            min-width: 90px;
            text-align: right;
        }

        /* Top Members */
        .top-member-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .top-member-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background: var(--color-fi-bg, #f9fafb);
            transition: background 0.15s ease;
        }

        .top-member-item:hover {
            background: var(--color-fi-primary-50, #fef2f2);
        }

        .top-member-rank {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .top-member-rank.gold {
            background: #fef3c7;
            color: #92400e;
        }

        .top-member-rank.silver {
            background: #f3f4f6;
            color: #374151;
        }

        .top-member-rank.bronze {
            background: #fed7aa;
            color: #9a3412;
        }

        .top-member-rank.normal {
            background: var(--color-fi-bg, #f9fafb);
            color: var(--color-fi-text-muted, #6b7280);
        }

        .top-member-info {
            flex: 1;
            min-width: 0;
        }

        .top-member-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--color-fi-text-main, #111827);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .top-member-email {
            font-size: 0.75rem;
            color: var(--color-fi-text-muted, #6b7280);
        }

        .top-member-amount {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--color-fi-primary, #8B1A1A);
            text-align: right;
            flex-shrink: 0;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--color-fi-text-muted, #6b7280);
        }

        .empty-state-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .full-width {
            grid-column: 1 / -1;
        }
    </style>
@endpush

@section('content')
    <div class="analytics-grid animate-fade-in-up">
        <!-- Grafik Revenue Bulanan -->
        <div class="analytics-card full-width">
            <div class="analytics-card-header">
                <h3>📊 Tren Revenue 6 Bulan Terakhir</h3>
                <p>Total pembayaran terverifikasi dari downline per bulan</p>
            </div>
            <div class="analytics-card-body">
                @php
                    $maxRevenue = collect($monthlyData)->max('revenue') ?: 1;
                @endphp

                @if($maxRevenue > 0)
                    <div class="bar-chart">
                        @foreach($monthlyData as $data)
                            <div class="bar-row">
                                <div class="bar-label">{{ $data['month'] }}</div>
                                <div class="bar-track">
                                    <div class="bar-fill revenue"
                                        style="width: {{ $maxRevenue > 0 ? ($data['revenue'] / $maxRevenue * 100) : 0 }}%;">
                                    </div>
                                </div>
                                <div class="bar-value">Rp {{ number_format($data['revenue'], 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📊</div>
                        <p>Belum ada data revenue.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Grafik Anggota Baru -->
        <div class="analytics-card">
            <div class="analytics-card-header">
                <h3>👥 Anggota Baru per Bulan</h3>
                <p>Tren pertumbuhan downline</p>
            </div>
            <div class="analytics-card-body">
                @php
                    $maxMembers = collect($monthlyData)->max('new_members') ?: 1;
                @endphp

                @if($maxMembers > 0)
                    <div class="bar-chart">
                        @foreach($monthlyData as $data)
                            <div class="bar-row">
                                <div class="bar-label">{{ $data['month'] }}</div>
                                <div class="bar-track">
                                    <div class="bar-fill members"
                                        style="width: {{ $maxMembers > 0 ? ($data['new_members'] / $maxMembers * 100) : 0 }}%;">
                                    </div>
                                </div>
                                <div class="bar-value">{{ $data['new_members'] }} orang</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">👥</div>
                        <p>Belum ada data anggota baru.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Top Downline -->
        <div class="analytics-card">
            <div class="analytics-card-header">
                <h3>🏆 Top Downline</h3>
                <p>5 downline dengan pembayaran terbesar</p>
            </div>
            <div class="analytics-card-body">
                @if($topDownlines->count() > 0 && $topDownlines->first()->total_paid > 0)
                    <div class="top-member-list">
                        @foreach($topDownlines as $i => $member)
                            @php
                                $rankClass = $i === 0 ? 'gold' : ($i === 1 ? 'silver' : ($i === 2 ? 'bronze' : 'normal'));
                            @endphp
                            <div class="top-member-item">
                                <div class="top-member-rank {{ $rankClass }}">{{ $i + 1 }}</div>
                                <div class="top-member-info">
                                    <div class="top-member-name">{{ $member->name }}</div>
                                    <div class="top-member-email">{{ $member->email }}</div>
                                </div>
                                <div class="top-member-amount">
                                    Rp {{ number_format($member->total_paid ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">🏆</div>
                        <p>Belum ada data pembayaran dari downline.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
