@extends('layouts.leader')

@section('title', 'Laporan Penjualan - HMI Tour')
@section('page-title', 'Laporan Penjualan')
@section('page-description', 'Ringkasan komisi dari downline yang sudah melunasi pembayaran')

@push('styles')
    <style>
        .report-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .report-stats {
                grid-template-columns: 1fr;
            }
        }

        .report-stat-card {
            background: var(--color-fi-surface, #ffffff);
            border-radius: 0.75rem;
            padding: 1.5rem;
            border: 1px solid var(--color-fi-border, #e5e7eb);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .report-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .report-stat-value {
            font-size: 1.375rem;
            font-weight: 700;
            color: var(--color-fi-text-main, #111827);
            font-family: 'Inter', sans-serif;
        }

        .report-stat-label {
            font-size: 0.8rem;
            color: var(--color-fi-text-muted, #6b7280);
            font-weight: 500;
        }

        .report-table-wrapper {
            background: var(--color-fi-surface, #ffffff);
            border-radius: 0.75rem;
            border: 1px solid var(--color-fi-border, #e5e7eb);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .report-table-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--color-fi-border, #e5e7eb);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .report-table-header h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-fi-text-main, #111827);
            margin: 0;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table thead {
            background: var(--color-fi-bg, #f9fafb);
        }

        .report-table th {
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--color-fi-text-muted, #6b7280);
            border-bottom: 1px solid var(--color-fi-border, #e5e7eb);
        }

        .report-table td {
            padding: 0.875rem 1rem;
            font-size: 0.875rem;
            color: var(--color-fi-text-secondary, #4b5563);
            border-bottom: 1px solid var(--color-fi-border, #e5e7eb);
            vertical-align: middle;
        }

        .report-table tbody tr:hover {
            background: var(--color-fi-bg, #f9fafb);
        }

        .report-table tbody tr:last-child td {
            border-bottom: none;
        }

        .commission-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            background: #ecfdf5;
            color: #065f46;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--color-fi-text-muted, #6b7280);
        }

        .empty-state-icon {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
        }

        .empty-state h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-fi-text-main, #111827);
            margin-bottom: 0.25rem;
        }

        .empty-state p {
            font-size: 0.875rem;
        }
    </style>
@endpush

@section('content')
    <!-- Statistik Ringkasan -->
    <section class="report-stats animate-fade-in-up">
        <div class="report-stat-card">
            <div class="report-stat-icon" style="background:#ecfdf5;color:#10b981;">💰</div>
            <div>
                <div class="report-stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="report-stat-label">Total Komisi</div>
            </div>
        </div>
        <div class="report-stat-card">
            <div class="report-stat-icon" style="background:#eff6ff;color:#3b82f6;">📅</div>
            <div>
                <div class="report-stat-value">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</div>
                <div class="report-stat-label">Komisi Bulan Ini</div>
            </div>
        </div>
        <div class="report-stat-card">
            <div class="report-stat-icon" style="background:#fffbeb;color:#f59e0b;">👥</div>
            <div>
                <div class="report-stat-value">{{ $totalPeople }}</div>
                <div class="report-stat-label">Total Jamaah Lunas</div>
            </div>
        </div>
    </section>

    <!-- Tabel Komisi -->
    <section class="report-table-wrapper animate-fade-in-up delay-1">
        <div class="report-table-header">
            <h3>📋 Rekap Komisi per Booking</h3>
            <span class="commission-badge">💰 Rp 200.000 / orang</span>
        </div>

        @if($commissionItems->count() > 0)
            <div style="overflow-x:auto;">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Jamaah</th>
                            <th>Paket</th>
                            <th style="text-align:center;">Jumlah Orang</th>
                            <th>Tgl. Lunas</th>
                            <th style="text-align:right;">Komisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commissionItems as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td style="font-weight:500;color:var(--color-fi-text-main);">
                                    {{ $item->user_name }}
                                </td>
                                <td>{{ $item->package_name }}</td>
                                <td style="text-align:center;font-weight:600;">{{ $item->jumlah_orang }}</td>
                                <td>{{ $item->lunas_date->format('d M Y') }}</td>
                                <td style="text-align:right;font-weight:700;color:#065f46;">
                                    Rp {{ number_format($item->commission, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background:var(--color-fi-bg);">
                            <td colspan="3" style="font-weight:700;color:var(--color-fi-text-main);border-top:2px solid var(--color-fi-border);">
                                TOTAL
                            </td>
                            <td style="text-align:center;font-weight:700;color:var(--color-fi-text-main);border-top:2px solid var(--color-fi-border);">
                                {{ $totalPeople }}
                            </td>
                            <td style="border-top:2px solid var(--color-fi-border);"></td>
                            <td style="text-align:right;font-weight:700;color:var(--color-fi-primary);font-size:1rem;border-top:2px solid var(--color-fi-border);">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📊</div>
                <h3>Belum Ada Data Komisi</h3>
                <p>Belum ada downline yang melunasi pembayaran secara penuh.</p>
            </div>
        @endif
    </section>
@endsection
