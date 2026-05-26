@extends('user.layouts.app')

@section('title', 'Travel Invoices — HMI Tour Travel')
@section('description', 'Travel Invoices - HMI Tour Travel')

@section('page_styles')
  <style>
    .invoices-container { max-width: var(--max-width); margin: 0 auto; }
    .invoice-toolbar { display: flex; align-items: center; justify-content: space-between; gap: var(--space-4); margin-bottom: var(--space-6); flex-wrap: wrap; }
    .invoice-search { position: relative; flex: 1; max-width: 360px; }
    .invoice-search .search-icon { position: absolute; left: var(--space-4); top: 50%; transform: translateY(-50%); color: var(--color-text-muted); pointer-events: none; font-size: var(--text-sm); }
    .invoice-search .form-input { padding-left: var(--space-10); }
    .invoice-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-4); margin-bottom: var(--space-6); }
    .invoice-stat-card { background: var(--color-surface); border-radius: var(--radius-xl); padding: var(--space-5); border: 1px solid var(--color-border-light); display: flex; align-items: center; gap: var(--space-4); }
    .invoice-stat-icon { width: 44px; height: 44px; border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; font-size: var(--text-lg); flex-shrink: 0; }
    .invoice-stat-info h4 { font-size: var(--text-lg); font-weight: var(--font-bold); margin-bottom: 0; }
    .invoice-stat-info p { font-size: var(--text-xs); color: var(--color-text-muted); margin-bottom: 0; }
    .invoice-list { display: flex; flex-direction: column; gap: var(--space-4); }
    .invoice-card { background: var(--color-surface); border-radius: var(--radius-2xl); border: 1px solid var(--color-border-light); box-shadow: var(--shadow-sm); transition: var(--transition-base); overflow: hidden; }
    .invoice-card:hover { box-shadow: var(--shadow-md); border-color: var(--color-primary-200); }
    .invoice-card-main { padding: var(--space-5) var(--space-6); display: flex; align-items: center; gap: var(--space-5); cursor: pointer; }
    .invoice-card-icon { width: 48px; height: 48px; border-radius: var(--radius-xl); display: flex; align-items: center; justify-content: center; font-size: var(--text-xl); flex-shrink: 0; }
    .invoice-card-icon.paid { background: var(--color-success-bg); color: var(--color-success); }
    .invoice-card-icon.unpaid { background: var(--color-warning-bg); color: var(--color-warning); }
    .invoice-card-info { flex: 1; min-width: 0; }
    .invoice-card-id { font-size: var(--text-sm); font-weight: var(--font-bold); color: var(--color-text); margin-bottom: 2px; }
    .invoice-card-tour { font-size: var(--text-xs); color: var(--color-text-secondary); }
    .invoice-card-meta { display: flex; align-items: center; gap: var(--space-6); flex-shrink: 0; }
    .invoice-card-amount { text-align: right; }
    .invoice-amount-label { font-size: var(--text-xs); color: var(--color-text-muted); }
    .invoice-amount-value { font-size: var(--text-base); font-weight: var(--font-bold); color: var(--color-text); }
    .invoice-card-actions { display: flex; gap: var(--space-2); }
    .invoice-detail { display: none; padding: 0 var(--space-6) var(--space-6); border-top: 1px solid var(--color-border-light); animation: fadeIn 0.3s ease; }
    .invoice-detail.visible { display: block; }
    .invoice-detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-6); padding-top: var(--space-5); }
    .invoice-detail-section h5 { font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-text); margin-bottom: var(--space-3); padding-bottom: var(--space-2); border-bottom: 1px solid var(--color-border-light); }
    .detail-row { display: flex; justify-content: space-between; padding: var(--space-2) 0; font-size: var(--text-sm); }
    .detail-label { color: var(--color-text-secondary); }
    .detail-value { font-weight: var(--font-medium); color: var(--color-text); }
    .payment-history-list { margin-top: var(--space-3); }
    .payment-history-item { display: flex; align-items: center; gap: var(--space-3); padding: var(--space-3); background: var(--color-bg); border-radius: var(--radius-lg); margin-bottom: var(--space-2); font-size: var(--text-sm); }
    .payment-history-item:last-child { margin-bottom: 0; }
    .payment-history-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .payment-history-dot.verified { background: var(--color-success); }
    .payment-history-dot.pending { background: var(--color-warning); }
    .payment-history-info { flex: 1; }
    .payment-history-amount { font-weight: var(--font-semibold); }
    @media print {
      .app-layout { display: block; }
      .sidebar, .sidebar-overlay, .top-header, .page-footer, .invoice-toolbar, .invoice-stats, .tabs, .invoice-card-actions, .btn, .toast-container { display: none !important; }
      .main-wrapper { margin-left: 0; }
      .main-content { padding: 0; }
      .invoice-card { break-inside: avoid; box-shadow: none; border: 1px solid #ddd; margin-bottom: 16px; }
      .invoice-detail { display: block !important; }
      .print-header { display: block !important; text-align: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid #8B1A1A; }
      .print-header h1 { font-size: 24px; color: #8B1A1A; margin-bottom: 4px; }
      .print-header p { font-size: 14px; color: #666; }
      .print-footer { display: block !important; margin-top: 40px; padding-top: 16px; border-top: 1px solid #ddd; text-align: center; font-size: 12px; color: #888; }
    }
    .print-header, .print-footer { display: none; }
  </style>
@endsection

@section('page_scripts')
  <script src="{{ asset('assets/js/invoices.js') }}"></script>
@endsection

@section('content')
  <div class="invoices-container">

    <!-- Print Header (only visible when printing) -->
    <div class="print-header">
      <h1>HMI Tour Travel — Travel Invoices</h1>
      <p>Cetak Invoice Pembayaran Tour</p>
    </div>

    <!-- Invoice Stats -->
    <section class="invoice-stats animate-fade-in-up" aria-label="Statistik invoice">
      <div class="invoice-stat-card">
        <div class="invoice-stat-icon" style="background: var(--color-info-bg); color: var(--color-info);">📋</div>
        <div class="invoice-stat-info">
          <h4 id="totalInvoices">{{ $totalInvoices }}</h4>
          <p>Total Invoice</p>
        </div>
      </div>
      <div class="invoice-stat-card">
        <div class="invoice-stat-icon" style="background: var(--color-success-bg); color: var(--color-success);">✅</div>
        <div class="invoice-stat-info">
          <h4 id="paidInvoices">{{ $paidInvoices }}</h4>
          <p>Sudah Lunas</p>
        </div>
      </div>
      <div class="invoice-stat-card">
        <div class="invoice-stat-icon" style="background: var(--color-warning-bg); color: var(--color-warning);">⏳</div>
        <div class="invoice-stat-info">
          <h4 id="unpaidInvoices">{{ $unpaidInvoices }}</h4>
          <p>Belum Lunas</p>
        </div>
      </div>
    </section>

    <!-- Filter Tabs & Search -->
    <section aria-label="Filter dan pencarian invoice">
      <div class="invoice-toolbar">
        <div class="tabs">
          <a href="{{ route('user.invoices', ['status' => 'all']) }}" class="tab-btn {{ !request('status') || request('status') === 'all' ? 'active' : '' }}" style="text-decoration: none;">Semua</a>
          <a href="{{ route('user.invoices', ['status' => 'sudah_lunas']) }}" class="tab-btn {{ request('status') === 'sudah_lunas' ? 'active' : '' }}" style="text-decoration: none;">✅ Sudah Lunas</a>
          <a href="{{ route('user.invoices', ['status' => 'belum_lunas']) }}" class="tab-btn {{ request('status') === 'belum_lunas' ? 'active' : '' }}" style="text-decoration: none;">⏳ Belum Lunas</a>
        </div>
        <form class="invoice-search" action="{{ route('user.invoices') }}" method="GET">
          @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
          @endif
          <span class="search-icon">🔍</span>
          <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-input" placeholder="Cari invoice..."
            aria-label="Cari invoice berdasarkan ID atau nama paket">
        </form>
      </div>
    </section>

    <!-- Invoice List -->
    <section id="invoiceList" class="invoice-list animate-fade-in-up" aria-label="Daftar invoice">
      @forelse($payments as $payment)
        <div class="invoice-card">
            <div class="invoice-card-main">
                <div class="invoice-card-icon {{ $payment->status === 'sudah_lunas' ? 'paid' : ($payment->status === 'belum_lunas' ? 'unpaid' : '') }}" style="background: {{ $payment->status === 'ditolak' ? 'var(--color-danger-bg)' : '' }}; color: {{ $payment->status === 'ditolak' ? 'var(--color-danger)' : '' }}">
                    @if($payment->status === 'sudah_lunas')
                        ✅
                    @elseif($payment->status === 'belum_lunas')
                        ⏳
                    @else
                        ❌
                    @endif
                </div>
                <div class="invoice-card-info">
                    <div class="invoice-card-id">{{ $payment->invoice_number }}</div>
                    <div class="invoice-card-tour">{{ $payment->booking->package->name ?? 'Paket Terhapus' }}</div>
                </div>
                <div class="invoice-card-meta">
                    <div class="invoice-card-amount">
                        <div class="invoice-amount-label">Jumlah Pembayaran</div>
                        <div class="invoice-amount-value">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="invoice-card-actions">
                    <a href="{{ route('user.invoices.print', $payment->id) }}" target="_blank" class="btn btn-ghost btn-sm" aria-label="Cetak invoice" style="text-decoration:none;">🖨️ Cetak</a>
                    <button class="btn btn-primary btn-sm btn-detail" onclick="this.closest('.invoice-card').querySelector('.invoice-detail').classList.toggle('visible')">Detail</button>
                </div>
            </div>
            
            <div class="invoice-detail">
                @php
                    $booking   = $payment->booking;
                    $pkg       = $booking->package ?? null;
                    $price     = $booking->packagePrice ?? null;
                    $usdRate   = $booking->usd_rate ?? 15800;
                    $addons    = is_array($booking->addons) ? $booking->addons : (json_decode($booking->addons, true) ?? []);

                    // Definisi add-on: key => [label, harga IDR per orang]
                    $addonDefs = [
                        'paspor'         => ['label' => 'Pembuatan E-Paspor Express', 'price_idr' => 1500000],
                        'bisnis_class'   => ['label' => 'Upgrade Bisnis Class',        'price_idr' => 8000000],
                        'upgrade_kamar'  => ['label' => 'Upgrade Kamar Hotel',          'price_idr' => 2500000],
                        'vaksin'         => ['label' => 'Vaksin',                        'price_idr' => 350000],
                    ];

                    // Hitung total add-ons
                    $totalAddons = 0;
                    foreach ($addonDefs as $key => $def) {
                        $qty = $addons[$key] ?? 0;
                        $totalAddons += $qty * $def['price_idr'];
                    }

                    // Total paket = harga kamar × jumlah orang
                    $hargaKamar   = $price->price ?? 0;
                    $totalPaket   = $hargaKamar * ($booking->jumlah_orang ?? 1);
                    $grandTotal   = $booking->total_price; // pakai total_price booking yg sudah dikunci
                    $sisa         = $booking->sisa_tagihan ?? max(0, $grandTotal - ($booking->sudah_dibayar ?? 0));
                @endphp

                {{-- ═══ BAGIAN 1: INFO PEMBAYARAN & TAGIHAN ═══ --}}
                <div class="invoice-detail-grid" style="padding-top: var(--space-5);">
                    <div class="invoice-detail-section">
                        <h5>Informasi Pembayaran</h5>
                        <div class="detail-row">
                            <span class="detail-label">Status</span>
                            <span class="detail-value">
                                @if($payment->status === 'sudah_lunas')
                                    <span style="color: var(--color-success)">✅ Lunas (Diverifikasi)</span>
                                @elseif($payment->status === 'belum_lunas')
                                    <span style="color: var(--color-warning)">⏳ Pending (Menunggu Verifikasi)</span>
                                @else
                                    <span style="color: var(--color-danger)">❌ Ditolak</span>
                                @endif
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Metode</span>
                            <span class="detail-value">{{ ucfirst($payment->payment_method) }} {{ $payment->bank_name ? '('.strtoupper($payment->bank_name).')' : '' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tanggal & Waktu</span>
                            <span class="detail-value">
                                {{ \Carbon\Carbon::parse($payment->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Jumlah Bayar Ini</span>
                            <span class="detail-value" style="font-weight:700;color:var(--color-primary)">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="invoice-detail-section">
                        <h5>Status Tagihan</h5>
                        <div class="detail-row">
                            <span class="detail-label">Total Tagihan</span>
                            <span class="detail-value">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Sudah Dibayar <small style="color:var(--color-text-muted);font-weight:400">(verified)</small></span>
                            <span class="detail-value" style="color: var(--color-success)">
                                Rp {{ number_format($booking->sudah_dibayar ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                        @if(($booking->pending_verifikasi ?? 0) > 0)
                        <div class="detail-row">
                            <span class="detail-label">Menunggu Verifikasi</span>
                            <span class="detail-value" style="color: var(--color-warning)">
                                Rp {{ number_format($booking->pending_verifikasi, 0, ',', '.') }}
                            </span>
                        </div>
                        @endif
                        <div class="detail-row" style="border-top:2px solid var(--color-border);margin-top:var(--space-2);padding-top:var(--space-2);">
                            <span class="detail-label" style="font-weight:600;color:var(--color-text)">Sisa Tagihan</span>
                            <span class="detail-value" style="font-weight:700;color:{{ $sisa == 0 ? 'var(--color-success)' : 'var(--color-primary)' }}">
                                @if($sisa == 0) ✅ Lunas @else Rp {{ number_format($sisa, 0, ',', '.') }} @endif
                            </span>
                        </div>
                        @if(($booking->pending_verifikasi ?? 0) > 0)
                        <p style="font-size:var(--text-xs);color:var(--color-text-muted);margin-top:var(--space-3);line-height:1.5;">
                            ℹ️ Sisa tagihan akan berkurang setelah admin memverifikasi pembayaran.
                        </p>
                        @endif
                    </div>
                </div>

                {{-- ═══ BAGIAN 2: RINCIAN PAKET ═══ --}}
                <div style="margin-top:var(--space-5);border-top:1px solid var(--color-border-light);padding-top:var(--space-4);">
                    <h5 style="font-size:var(--text-sm);font-weight:var(--font-semibold);margin-bottom:var(--space-3);padding-bottom:var(--space-2);border-bottom:1px solid var(--color-border-light);">
                        🕌 Rincian Paket
                    </h5>
                    <table style="width:100%;border-collapse:collapse;font-size:var(--text-xs);">
                        <thead>
                            <tr style="background:var(--color-bg);text-align:left;">
                                <th style="padding:var(--space-2) var(--space-3);color:var(--color-text-muted);font-weight:600;">Deskripsi</th>
                                <th style="padding:var(--space-2) var(--space-3);color:var(--color-text-muted);font-weight:600;text-align:center;">Jenis Kamar</th>
                                <th style="padding:var(--space-2) var(--space-3);color:var(--color-text-muted);font-weight:600;text-align:center;">Pax</th>
                                <th style="padding:var(--space-2) var(--space-3);color:var(--color-text-muted);font-weight:600;text-align:right;">Harga/Pax (IDR)</th>
                                <th style="padding:var(--space-2) var(--space-3);color:var(--color-text-muted);font-weight:600;text-align:right;">Harga/Pax (USD)</th>
                                <th style="padding:var(--space-2) var(--space-3);color:var(--color-text-muted);font-weight:600;text-align:right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-top:1px solid var(--color-border-light);">
                                <td style="padding:var(--space-3);">
                                    <div style="font-weight:600;color:var(--color-text);">{{ $pkg->name ?? 'Paket Umrah' }}</div>
                                    <div style="color:var(--color-text-muted);margin-top:2px;">{{ $pkg->category->name ?? '-' }} • {{ $pkg ? \Carbon\Carbon::parse($pkg->departure_date)->format('d M Y') : '-' }}</div>
                                </td>
                                <td style="padding:var(--space-3);text-align:center;">
                                    <span style="background:var(--color-primary-50);color:var(--color-primary);padding:2px 8px;border-radius:var(--radius-full);font-weight:600;">
                                        {{ $price->type ?? '-' }}
                                    </span>
                                </td>
                                <td style="padding:var(--space-3);text-align:center;font-weight:600;">{{ $booking->jumlah_orang ?? 1 }}</td>
                                <td style="padding:var(--space-3);text-align:right;">Rp {{ number_format($hargaKamar, 0, ',', '.') }}</td>
                                <td style="padding:var(--space-3);text-align:right;">$ {{ number_format(round($hargaKamar / $usdRate, 0), 0, ',', '.') }}</td>
                                <td style="padding:var(--space-3);text-align:right;font-weight:700;">Rp {{ number_format($totalPaket, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- ═══ BAGIAN 3: ADD-ONS / TAMBAHAN ═══ --}}
                <div style="margin-top:var(--space-5);border-top:1px solid var(--color-border-light);padding-top:var(--space-4);">
                    <h5 style="font-size:var(--text-sm);font-weight:var(--font-semibold);margin-bottom:var(--space-3);padding-bottom:var(--space-2);border-bottom:1px solid var(--color-border-light);">
                        ➕ Layanan Tambahan (Add-On)
                    </h5>
                    <table style="width:100%;border-collapse:collapse;font-size:var(--text-xs);">
                        <thead>
                            <tr style="background:var(--color-bg);text-align:left;">
                                <th style="padding:var(--space-2) var(--space-3);color:var(--color-text-muted);font-weight:600;width:32px;"></th>
                                <th style="padding:var(--space-2) var(--space-3);color:var(--color-text-muted);font-weight:600;">Layanan</th>
                                <th style="padding:var(--space-2) var(--space-3);color:var(--color-text-muted);font-weight:600;text-align:right;">Harga/item (IDR)</th>
                                <th style="padding:var(--space-2) var(--space-3);color:var(--color-text-muted);font-weight:600;text-align:right;">Harga/item (USD)</th>
                                <th style="padding:var(--space-2) var(--space-3);color:var(--color-text-muted);font-weight:600;text-align:center;">Qty</th>
                                <th style="padding:var(--space-2) var(--space-3);color:var(--color-text-muted);font-weight:600;text-align:right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($addonDefs as $key => $def)
                            @php
                                $qty      = $addons[$key] ?? 0;
                                $subtotal = $qty * $def['price_idr'];
                                $checked  = $qty > 0;
                            @endphp
                            <tr style="border-top:1px solid var(--color-border-light);{{ !$checked ? 'opacity:0.45;' : '' }}">
                                <td style="padding:var(--space-3);text-align:center;">
                                    @if($checked)
                                        <span style="color:var(--color-success);font-size:14px;">✅</span>
                                    @else
                                        <span style="color:var(--color-text-muted);font-size:14px;">☐</span>
                                    @endif
                                </td>
                                <td style="padding:var(--space-3);font-weight:{{ $checked ? '600' : '400' }};color:var(--color-text);">{{ $def['label'] }}</td>
                                <td style="padding:var(--space-3);text-align:right;">Rp {{ number_format($def['price_idr'], 0, ',', '.') }}</td>
                                <td style="padding:var(--space-3);text-align:right;">$ {{ number_format(round($def['price_idr'] / $usdRate, 0), 0, ',', '.') }}</td>
                                <td style="padding:var(--space-3);text-align:center;font-weight:600;">{{ $qty }}</td>
                                <td style="padding:var(--space-3);text-align:right;font-weight:{{ $checked ? '700' : '400' }};color:{{ $checked ? 'var(--color-text)' : 'var(--color-text-muted)' }};">
                                    {{ $checked ? 'Rp '.number_format($subtotal, 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ═══ BAGIAN 4: TOTAL AKHIR ═══ --}}
                <div style="margin-top:var(--space-5);border-top:2px solid var(--color-border);padding-top:var(--space-4);display:flex;justify-content:flex-end;">
                    <div style="min-width:320px;">
                        <div style="display:flex;justify-content:space-between;padding:var(--space-2) 0;font-size:var(--text-xs);color:var(--color-text-secondary);">
                            <span>Total Paket ({{ $booking->jumlah_orang ?? 1 }} pax)</span>
                            <span>Rp {{ number_format($totalPaket, 0, ',', '.') }}</span>
                        </div>
                        @if($totalAddons > 0)
                        <div style="display:flex;justify-content:space-between;padding:var(--space-2) 0;font-size:var(--text-xs);color:var(--color-text-secondary);">
                            <span>Total Add-On</span>
                            <span>Rp {{ number_format($totalAddons, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div style="display:flex;justify-content:space-between;padding:var(--space-3) 0;margin-top:var(--space-2);border-top:2px solid var(--color-primary);font-size:var(--text-base);font-weight:700;color:var(--color-primary);">
                            <span>TOTAL INVOICE</span>
                            <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding:var(--space-1) 0;font-size:var(--text-xs);color:var(--color-text-muted);">
                            <span>Dalam USD (kurs ~{{ number_format($usdRate, 0, ',', '.') }})</span>
                            <span>≈ $ {{ number_format(round($grandTotal / $usdRate, 0), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      @empty
        <div class="text-center py-12 bg-white rounded-2xl border border-gray-200">
            <h3 class="text-gray-500 font-medium">Tidak ada invoice ditemukan.</h3>
        </div>
      @endforelse
    </section>

    <!-- Print Footer (only visible when printing) -->
    <div class="print-footer">
      <p>Dicetak oleh sistem HMI Tour Travel | © 2024 HMI Tour Travel</p>
    </div>

  </div>
@endsection