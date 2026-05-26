@extends('layouts.admin')
@section('title', 'Dashboard - HMI Tour')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Kelola seluruh operasional HMI Tour')

@section('content')

    <!-- Welcome Banner -->
    <section class="welcome-banner animate-fade-in-up" aria-label="Banner selamat datang">
      <div class="welcome-content" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--space-6);">
        <div>
            <h2>Halo, Admin! 👋</h2>
            <p>Kelola seluruh operasional sistem HMI Tour & Travel di sini.</p>
        </div>

        <form action="{{ route('admin.user.access') }}" method="POST" style="display: flex; gap: var(--space-2); margin: 0; background: rgba(255,255,255,0.2); padding: var(--space-2); border-radius: var(--radius-lg); backdrop-filter: blur(8px);">
            @csrf
            <input
                type="text"
                name="referral_code"
                placeholder="Akses Dashboard URL Kode..."
                class="form-input"
                style="width: 250px; border: none; box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);"
                required
            >
            <button type="submit" class="btn btn-secondary" style="border-color: white; color: white; background: rgba(255,255,255,0.2);">
                🔍
            </button>
        </form>
      </div>
    </section>

    <!-- Stats Grid -->
    <section class="stats-grid animate-fade-in-up delay-1" aria-label="Statistik Admin">
        <div class="stat-card">
            <div class="stat-card-icon success" style="font-size: 1.75rem;">💰</div>
            <div class="stat-card-label">Total Uang Kas Masuk</div>
            <div class="stat-card-value" style="color: var(--color-success);">IDR {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon primary" style="font-size: 1.75rem;">📋</div>
            <div class="stat-card-label">Total Transaksi Bookings</div>
            <div class="stat-card-value">{{ $totalBookings }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon warning" style="font-size: 1.75rem;">⏳</div>
            <div class="stat-card-label">Menunggu Pembayaran</div>
            <div class="stat-card-value" style="color: var(--color-warning);">{{ $pendingPayments }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon info" style="font-size: 1.75rem;">🕋</div>
            <div class="stat-card-label">Pemesanan Tertunda</div>
            <div class="stat-card-value">{{ $pendingBookings }}</div>
        </div>
    </section>

    {{-- Alert: Error --}}
    @if(session('error'))
        <div class="card" style="background: var(--color-danger-bg); border-color: var(--color-danger-border); margin-bottom: var(--space-6);">
            <div class="card-body" style="padding: var(--space-4) var(--space-6); color: var(--color-danger); font-weight: 600;">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="dashboard-grid animate-fade-in-up delay-2">
        <!-- User Leader Access -->
        <section class="card" aria-label="Daftar Akses Kode Akun">
            <div class="card-header">
                <h3 class="section-title" style="font-size: var(--text-lg);">Daftar User & Leader Referral</h3>
            </div>

            @if($users->count() > 0)
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Kode Referral</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: var(--space-3);">
                                    <div class="avatar" style="width: 32px; height: 32px; font-size: var(--text-xs);">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <span class="font-semibold">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td style="color: var(--color-text-muted);">{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'leader')
                                    <span class="badge badge-info">Leader</span>
                                @else
                                    <span class="badge badge-neutral">User</span>
                                @endif
                            </td>
                            <td>
                                <code style="background: var(--color-bg-alt); padding: var(--space-1) var(--space-2); border-radius: var(--radius-sm); font-size: var(--text-xs); user-select: all;">{{ $user->referral_code }}</code>
                            </td>
                            <td>
                                <form action="{{ route('admin.user.access') }}" method="POST" style="margin: 0; display: inline;">
                                    @csrf
                                    <input type="hidden" name="referral_code" value="{{ $user->referral_code }}">
                                    <button type="submit" class="btn btn-secondary btn-sm">
                                        🚀 Akses Dashboard
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="card-body text-center" style="padding: var(--space-12);">
                <div style="font-size: 2rem; margin-bottom: var(--space-3);">👥</div>
                <p class="text-muted" style="margin: 0;">Belum ada user dengan kode referral.</p>
            </div>
            @endif
        </section>

        <!-- Inquiries / Calon Jamaah -->
        <section class="card animate-fade-in-up delay-3" aria-label="Calon Jamaah">
            <div class="card-header">
                <h3 class="section-title" style="font-size: var(--text-lg);">Prospek Calon Jamaah</h3>
                <form action="{{ route('admin.dashboard') }}" method="GET" style="display: flex; gap: var(--space-2);">
                    <select name="status" onchange="this.form.submit()" class="form-select" style="width: auto; padding: var(--space-2) var(--space-8) var(--space-2) var(--space-3); font-size: var(--text-xs);">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Tertunda</option>
                        <option value="followed_up" {{ request('status') == 'followed_up' ? 'selected' : '' }}>Di-Follow Up</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Selesai/Batal</option>
                    </select>
                </form>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Waktu Masuk</th>
                            <th>Calon Jamaah</th>
                            <th>Minat Paket</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inquiries as $inquiry)
                            @php
                                $nomor_bersih = preg_replace('/[^0-9]/', '', $inquiry->phone);
                                $nomor_wa = substr($nomor_bersih, 0, 1) === '0' ? '62' . substr($nomor_bersih, 1) : $nomor_bersih;
                                $link_wa = "https://wa.me/" . $nomor_wa . "?text=Assalamu'alaikum...";
                            @endphp
                            <tr>
                                <td>{{ $inquiry->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <div class="font-semibold">{{ $inquiry->name }}</div>
                                    <div style="font-size: var(--text-xs); color: var(--color-text-muted);">{{ $inquiry->phone }}</div>
                                </td>
                                <td>{{ $inquiry->package->name ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('admin.inquiry.update_status', $inquiry->id) }}" method="POST">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="badge {{ $inquiry->status == 'pending' ? 'badge-warning' : 'badge-success' }}" style="border: none; cursor: pointer; appearance: none; padding: var(--space-1) var(--space-3);">
                                            <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : '' }}>Tertunda</option>
                                            <option value="followed_up" {{ $inquiry->status == 'followed_up' ? 'selected' : '' }}>Follow Up</option>
                                            <option value="closed" {{ $inquiry->status == 'closed' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <div style="display: flex; gap: var(--space-2);">
                                        <a href="{{ $link_wa }}" target="_blank" class="btn btn-success btn-sm">WA</a>
                                        <a href="{{ route('admin.inquiry.convert', $inquiry->id) }}" class="btn btn-primary btn-sm" style="background: var(--color-info); box-shadow: none;">Convert</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted" style="padding: var(--space-8);">Belum ada prospek.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Recent Bookings -->
        <section class="card animate-fade-in-up delay-4" aria-label="Pesanan Terbaru">
            <div class="card-header">
                <h3 class="section-title" style="font-size: var(--text-lg);">Riwayat Pesanan Terbaru</h3>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-ghost btn-sm">Lihat Semua →</a>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Jamaah</th>
                            <th>Paket</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $booking)
                            <tr>
                                <td>{{ $booking->created_at->format('d M Y, H:i') }}</td>
                                <td class="font-semibold">{{ $booking->customer_name }}</td>
                                <td>{{ $booking->package->name ?? '-' }}</td>
                                <td>
                                    @if($booking->status == 'pending') <span class="badge badge-warning">Pending</span>
                                    @elseif($booking->status == 'dicicil') <span class="badge badge-info">Dicicil</span>
                                    @elseif($booking->status == 'paid') <span class="badge badge-success">Lunas</span>
                                    @else <span class="badge badge-danger">Batal</span> @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-ghost btn-sm">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted" style="padding: var(--space-8);">Belum ada pesanan terbaru.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection