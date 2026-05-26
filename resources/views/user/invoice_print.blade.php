<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoiceNo }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #8B1A1A;
            --primary-lt: #f9f0f0;
            --ink: #1a1a2e;
            --ink-2: #4a4a6a;
            --ink-3: #8888a8;
            --line: #e8e8ef;
            --bg: #f7f7fa;
            --white: #ffffff;
            --success: #16a34a;
            --warning: #d97706;
            --danger: #dc2626;
            --success-bg: #f0fdf4;
            --warning-bg: #fffbeb;
            --danger-bg: #fef2f2;
            --radius: 8px;
            --radius-sm: 5px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
            background: var(--bg);
            color: var(--ink);
            font-size: 10px;
            line-height: 1.45;
            padding: 20px 16px;
        }

        /* ── ACTIONS (hidden on print) ── */
        .no-print {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 22px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            font-family: inherit;
            text-decoration: none;
            transition: opacity .15s;
        }

        .btn:hover {
            opacity: .85;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-ghost {
            background: #fff;
            color: var(--ink-2);
            border: 1.5px solid var(--line);
        }

        /* ── PAPER ── */
        .paper {
            max-width: 820px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 2px 24px rgba(0, 0, 0, .07);
            overflow: hidden;
        }

        /* ── TOP STRIPE ── */
        .paper-stripe {
            height: 4px;
            background: linear-gradient(90deg, var(--primary) 0%, #c0392b 100%);
        }

        /* ── HEADER ── */
        .paper-head {
            padding: 16px 26px 13px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid var(--line);
        }

        .brand {
            display: flex;
            align-items: flex-start;
            gap: 11px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            flex-shrink: 0;
            object-fit: contain;
        }

        .brand-name {
            font-size: 12.5px;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.3;
        }

        .brand-addr {
            font-size: 8px;
            color: var(--ink-3);
            margin-top: 3px;
            line-height: 1.5;
        }

        .brand-addr span {
            display: block;
        }

        /* ── SECTION WRAPPER ── */
        .section {
            padding: 12px 26px;
            border-bottom: 1px solid var(--line);
        }

        .section:last-child {
            border-bottom: none;
        }

        .section-label {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--ink-3);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 9px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--line);
        }

        /* ── INFO GRID ── */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .info-block h4 {
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--ink-3);
            padding-bottom: 5px;
            border-bottom: 1px solid var(--line);
            margin-bottom: 7px;
        }

        .info-row {
            display: flex;
            gap: 0;
            margin-bottom: 3px;
            font-size: 9px;
        }

        .info-lbl {
            min-width: 115px;
            color: var(--ink-3);
            font-weight: 400;
        }

        .info-val {
            color: var(--ink);
            font-weight: 600;
            flex: 1;
        }

        /* ── TABLE (shared base) ── */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        thead tr {
            background: var(--bg);
        }

        th {
            padding: 6px 9px;
            text-align: left;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .7px;
            color: var(--ink-3);
            border-bottom: 1px solid var(--line);
        }

        th.r {
            text-align: right;
        }

        th.c {
            text-align: center;
        }

        td {
            padding: 5px 9px;
            color: var(--ink-2);
            border-bottom: 1px solid var(--line);
            vertical-align: middle;
        }

        td.r {
            text-align: right;
        }

        td.c {
            text-align: center;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        /* tfoot subtotal */
        tfoot tr td {
            background: var(--bg);
            font-weight: 700;
            color: var(--ink);
            border-top: 1.5px solid var(--line);
            border-bottom: none;
        }

        /* ── Tag/badge kamar ── */
        .tag {
            display: inline-block;
            padding: 1px 7px;
            border-radius: 20px;
            font-size: 8px;
            font-weight: 700;
            background: #f0f0f8;
            color: var(--ink-2);
            border: 1px solid var(--line);
        }

        .tag-primary {
            background: var(--primary-lt);
            color: var(--primary);
            border-color: #e0c0c0;
        }

        /* ── Add-on: row inactive ── */
        .row-inactive td {
            color: #c0c0d0;
        }

        .row-inactive td:nth-child(2) {
            font-weight: 400;
        }

        .chk-yes {
            color: var(--success);
            font-size: 11px;
        }

        .chk-no {
            color: #d0d0e0;
            font-size: 11px;
        }

        /* ── Cicilan badge ── */
        .sb {
            display: inline-block;
            padding: 1px 7px;
            border-radius: 20px;
            font-size: 8px;
            font-weight: 700;
        }

        .sb-v {
            background: var(--success-bg);
            color: var(--success);
        }

        .sb-p {
            background: var(--warning-bg);
            color: var(--warning);
        }

        .sb-r {
            background: var(--danger-bg);
            color: var(--danger);
        }

        /* ── Empty row for future installments ── */
        .empty-row td {
            height: 22px;
            border-bottom: 1px dashed #e0e0e8;
            color: transparent;
        }

        /* ── Grand total panel ── */
        .totals-panel {
            padding: 12px 26px 14px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 22px;
        }

        .terms-note {
            font-size: 8px;
            color: var(--ink-3);
            line-height: 1.6;
            flex: 1;
            max-width: 310px;
        }

        .terms-note ul {
            margin: 3px 0 0 13px;
            padding: 0;
        }

        .terms-note li {
            margin-bottom: 1px;
        }

        .totals-table {
            width: 300px;
            border-collapse: collapse;
            font-size: 10px;
        }

        .totals-table td {
            padding: 3px 6px;
        }

        .totals-table .t-sub {
            color: var(--ink-3);
        }

        .totals-table .t-sub td:last-child {
            text-align: right;
            font-weight: 600;
            color: var(--ink-2);
        }

        .totals-table .t-divider td {
            padding: 0;
        }

        .totals-table .t-divider-line {
            height: 1px;
            background: var(--line);
            margin: 4px 0;
        }

        .totals-table .t-grand td {
            font-size: 12px;
            font-weight: 800;
            color: var(--primary);
            padding: 6px;
            background: var(--primary-lt);
            border-radius: 5px;
        }

        .totals-table .t-grand td:last-child {
            text-align: right;
        }

        .totals-table .t-usd td {
            color: var(--ink-3);
            font-size: 8px;
            text-align: right;
            padding-top: 2px;
        }

        /* ── Footer ── */
        .paper-foot {
            padding: 13px 26px 16px;
            border-top: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            background: var(--bg);
        }

        .foot-note {
            font-size: 8px;
            color: var(--ink-3);
            line-height: 1.6;
            max-width: 410px;
        }

        .sign-col {
            text-align: center;
        }

        .sign-line {
            width: 160px;
            border-bottom: 1px solid var(--ink-3);
            margin: 28px auto 4px;
        }

        .sign-name {
            font-size: 9px;
            font-weight: 700;
            color: var(--ink-2);
        }

        /* ── PRINT ── */
        @media print {
            @page {
                size: A4;
                margin: 9mm;
            }

            body {
                background: #fff;
                padding: 0;
                font-size: 9px;
            }

            .paper {
                box-shadow: none;
                border-radius: 0;
            }

            .paper-stripe {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }

            .section,
            .paper-head,
            .paper-foot,
            .totals-panel {
                padding-left: 20px;
                padding-right: 20px;
            }

            .paper-head {
                padding-top: 10px;
                padding-bottom: 9px;
            }

            .section {
                padding-top: 8px;
                padding-bottom: 8px;
            }

            .totals-panel {
                padding-top: 8px;
                padding-bottom: 10px;
            }

            .paper-foot {
                padding-top: 10px;
                padding-bottom: 12px;
            }

            .sign-line {
                margin-top: 20px;
                margin-bottom: 3px;
            }
        }
    </style>
</head>

<body>

    <div class="no-print">
        <button class="btn btn-primary" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
        <a href="{{ url()->previous() }}" class="btn btn-ghost">← Kembali</a>
    </div>

    @php
        $booking = $payment->booking;
        $pkg = $booking->package ?? null;
        $priceObj = $booking->packagePrice ?? null;
        $jamaah = $payment->user;
        $leader = $jamaah->leader ?? null;

        $hargaKamar = $priceObj->price ?? 0;
        $jumlahOrang = $booking->jumlah_orang ?? 1;
        $totalPaket = $hargaKamar * $jumlahOrang;

        // Add-on
        $addonGrandIdr = 0;
        $addonGrandUsd = 0;
        $addonRows = [];
        foreach ($addonDefs as $key => $def) {
            $qty = $addons[$key] ?? 0;
            $subtotal = $qty * $def['price_idr'];
            $subUsd = round($subtotal / $usdRate, 0);
            if ($qty > 0) {
                $addonGrandIdr += $subtotal;
                $addonGrandUsd += $subUsd;
            }
            $addonRows[] = array_merge($def, ['qty' => $qty, 'subtotal' => $subtotal, 'sub_usd' => $subUsd, 'key' => $key]);
        }

        $grandTotal = $booking->total_price;
        $grandUsd = round($grandTotal / $usdRate, 0);

        // Histori — selalu tampilkan semua pembayaran pada booking ini
        $isLunas = $payment->status === 'sudah_lunas';
        $rows = $booking->payments ?? collect();
        $totalBayar = $rows->sum('amount');

        $tglCetak = now()->timezone('Asia/Jakarta')->format('d F Y, H:i') . ' WIB';
    @endphp

    <div class="paper">
        <div class="paper-stripe"></div>

        {{-- ══ HEADER ══ --}}
        <div class="paper-head">
            <div class="brand">
                <img src="{{ asset('favicon.ico') }}" alt="HMI" class="brand-icon">
                <div>
                    <div class="brand-name">PT. HIJRAH MADANI ISTIQOMAH TOUR &amp; TRAVEL</div>
                    <div class="brand-addr">
                        <span>Kantor: Ruko Bukit Serpong Indah (BSI) R.1 No.25, Jl. Bukit Serpong Indah 1, Cidokom, Gunungsindur, Kabupaten Bogor 16340</span>
                        <span>Tlp: 081281276251 (WA) | Email: hijrahmadaniistiqomah@gmail.com</span>
                        <span>www.hijrahmadaniistiqomahtour.com</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- ══ SECTION 1: INFO JAMAAH & IDENTITAS ══ --}}
        <div class="section">
            <div class="section-label">Informasi Jamaah &amp; Invoice</div>
            <div class="info-grid">

                {{-- Kiri: Data Jamaah --}}
                <div class="info-block">
                    <h4>Data Jamaah</h4>
                    <div class="info-row"><span class="info-lbl">Nama Jamaah</span><span
                            class="info-val">{{ $booking->customer_name ?? $jamaah->name }}</span></div>
                    <div class="info-row"><span class="info-lbl">Nama Leader</span><span
                            class="info-val">{{ $leader->name ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-lbl">Koordinator / PJ</span><span class="info-val">—</span>
                    </div>
                    <div class="info-row"><span class="info-lbl">Jenis Paket</span><span
                            class="info-val">{{ $pkg->name ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-lbl">Kategori</span><span
                            class="info-val">{{ $pkg->category->name ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-lbl">Tgl. Keberangkatan</span><span
                            class="info-val">{{ $pkg ? \Carbon\Carbon::parse($pkg->departure_date)->translatedFormat('d F Y') : '—' }}</span>
                    </div>
                </div>

                {{-- Kanan: Identitas Invoice --}}
                <div class="info-block">
                    <h4>Identitas Invoice</h4>
                    <div class="info-row"><span class="info-lbl">No. Invoice</span><span class="info-val" style="color:var(--ink);">{{ $invoiceNo }}</span></div>
                    <div class="info-row"><span class="info-lbl">Tanggal Cetak</span><span
                            class="info-val">{{ $tglCetak }}</span></div>
                    <div class="info-row"><span class="info-lbl">Status Invoice</span>
                        <span class="info-val">
                            @if($isLunas) <span style="color:var(--success);font-weight:700;">Lunas</span>
                            @elseif($payment->status === 'belum_lunas') <span
                                style="color:var(--warning);font-weight:700;">Menunggu Verifikasi</span>
                            @else <span style="color:var(--danger);font-weight:700;">Ditolak</span>
                            @endif
                        </span>
                    </div>
                    <div style="height:6px;"></div>
                    <div class="info-row"><span class="info-lbl">Marketing</span><span class="info-val">—</span></div>
                    <div class="info-row"><span class="info-lbl">Kantor Cabang</span><span class="info-val">—</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ══ SECTION 2: PAKET UTAMA ══ --}}
        <div class="section">
            <div class="section-label">Paket Utama</div>
            <table>
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Jenis Kamar</th>
                        <th class="r">Harga/Pax (USD)</th>
                        <th class="r">Harga/Pax (IDR)</th>
                        <th class="c">Pax</th>
                        <th class="r">Total (IDR)</th>
                        <th class="r">Total (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight:600;color:var(--ink);">
                            {{ $booking->customer_name ?? $jamaah->name }}
                        </td>
                        <td><span class="tag tag-primary">{{ $priceObj->type ?? '—' }}</span></td>
                        <td class="r">$ {{ number_format(round($hargaKamar / $usdRate, 0), 0, ',', '.') }}</td>
                        <td class="r">Rp {{ number_format($hargaKamar, 0, ',', '.') }}</td>
                        <td class="c" style="font-weight:700;color:var(--ink);">{{ $jumlahOrang }}</td>
                        <td class="r" style="font-weight:700;color:var(--ink);">Rp
                            {{ number_format($totalPaket, 0, ',', '.') }}</td>
                        <td class="r" style="font-weight:700;color:var(--ink);">$
                            {{ number_format(round($totalPaket / $usdRate, 0), 0, ',', '.') }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="r"
                            style="font-size:8px;letter-spacing:.5px;text-transform:uppercase;padding-right:12px;">
                            Subtotal Paket</td>
                        <td class="r">Rp {{ number_format($totalPaket, 0, ',', '.') }}</td>
                        <td class="r">$ {{ number_format(round($totalPaket / $usdRate, 0), 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- ══ SECTION 3: ADD-ONS ══ --}}
        <div class="section">
            <div class="section-label">Layanan Tambahan (Add-On)</div>
            <table>
                <thead>
                    <tr>
                        <th class="c" style="width:28px;">Dipilih</th>
                        <th>Layanan</th>
                        <th class="r">Harga Satuan (IDR)</th>
                        <th class="r">Harga Satuan (USD)</th>
                        <th class="c">Qty</th>
                        <th class="r">Total (IDR)</th>
                        <th class="r">Total (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($addonRows as $row)
                        @php $active = $row['qty'] > 0; @endphp
                        <tr class="{{ !$active ? 'row-inactive' : '' }}">
                            <td class="c">
                                @if($active) <span class="chk-yes">✓</span>
                                @else <span class="chk-no">—</span>
                                @endif
                            </td>
                            <td style="{{ $active ? 'font-weight:600;color:var(--ink);' : '' }}">{{ $row['label'] }}</td>
                            <td class="r">Rp {{ number_format($row['price_idr'], 0, ',', '.') }}</td>
                            <td class="r">$ {{ number_format(round($row['price_idr'] / $usdRate, 0), 0, ',', '.') }}</td>
                            <td class="c">{{ $active ? $row['qty'] : '—' }}</td>
                            <td class="r" style="{{ $active ? 'font-weight:600;color:var(--ink);' : '' }}">
                                {{ $active ? 'Rp ' . number_format($row['subtotal'], 0, ',', '.') : '—' }}
                            </td>
                            <td class="r" style="{{ $active ? 'font-weight:600;color:var(--ink);' : '' }}">
                                {{ $active ? '$ ' . number_format($row['sub_usd'], 0, ',', '.') : '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="r"
                            style="font-size:8px;letter-spacing:.5px;text-transform:uppercase;padding-right:12px;">
                            Subtotal Add-On</td>
                        <td class="r">Rp {{ number_format($addonGrandIdr, 0, ',', '.') }}</td>
                        <td class="r">$ {{ number_format($addonGrandUsd, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- ══ SECTION 4: HISTORI CICILAN ══ --}}
        <div class="section">
            <div class="section-label">
                Rincian Pembayaran
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="c" style="width:24px;">#</th>
                        <th>No. Invoice</th>
                        <th>Tanggal Bayar</th>
                        <th>Metode</th>
                        <th>Bank / Ket.</th>
                        <th class="r">Jumlah Dibayar</th>
                        <th class="c">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalBayar = 0; @endphp
                    @forelse($rows as $i => $row)
                        @php $totalBayar += $row->amount; @endphp
                        <tr>
                            <td class="c" style="color:var(--ink-3);font-size:8px;">{{ $i + 1 }}</td>
                            <td style="font-size:8px;color:var(--ink);font-weight:600;letter-spacing:.2px;">{{ $invoiceNo }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->payment_date)->format('d M Y') }}</td>
                            <td>{{ ucfirst($row->payment_method) }}</td>
                            <td>{{ $row->bank_name ? strtoupper($row->bank_name) : '—' }}</td>
                            <td class="r" style="font-weight:700;color:var(--ink);">Rp
                                {{ number_format($row->amount, 0, ',', '.') }}</td>
                            <td class="c">
                                @if($row->status === 'sudah_lunas')
                                    <span class="sb sb-v">Terverifikasi</span>
                                @elseif($row->status === 'belum_lunas')
                                    <span class="sb sb-p">Pending</span>
                                @else
                                    <span class="sb sb-r">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="c" style="color:var(--ink-3);padding:10px;">Belum ada riwayat pembayaran.
                            </td>
                        </tr>
                    @endforelse

                    {{-- 4 baris kosong untuk cicilan mendatang --}}
                    @php
                        $existingCount = $rows->count();
                        $emptySlots = max(0, 4 - $existingCount);
                    @endphp
                    @for($j = 0; $j < $emptySlots; $j++)
                        <tr class="empty-row">
                            <td class="c">{{ $existingCount + $j + 1 }}</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endfor
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="r"
                            style="font-size:8px;letter-spacing:.5px;text-transform:uppercase;padding-right:12px;">
                            Total Terbayar</td>
                        <td class="r">Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- ══ GRAND TOTAL ══ --}}
        <div class="totals-panel">
            <div class="terms-note">
                Mohon konfirmasi setelah pembayaran, pembayaran kami anggap sah apabila bukti validasi dana sudah efektif masuk rekening kami.
                <div style="margin-top:4px;font-weight:700;">Note:</div>
                <ul>
                    <li>Pelunasan biaya umrah maksimal 45 hari sebelum keberangkatan</li>
                    <li>Pembatalan 1 bulan sebelum keberangkatan dipotong 50%</li>
                    <li>Pembatalan 3 minggu sebelum keberangkatan dipotong 75%</li>
                    <li>Pembatalan 2 minggu sebelum keberangkatan dipotong 100%</li>
                </ul>
            </div>
            <table class="totals-table">
                <tr class="t-sub">
                    <td>Subtotal Paket ({{ $jumlahOrang }} pax)</td>
                    <td style="text-align:right;font-weight:600;color:var(--ink-2);">Rp
                        {{ number_format($totalPaket, 0, ',', '.') }}</td>
                </tr>
                @if($addonGrandIdr > 0)
                    <tr class="t-sub">
                        <td>Subtotal Add-On</td>
                        <td style="text-align:right;font-weight:600;color:var(--ink-2);">Rp
                            {{ number_format($addonGrandIdr, 0, ',', '.') }}</td>
                    </tr>
                @endif
                <tr class="t-divider">
                    <td colspan="2">
                        <div class="t-divider-line"></div>
                    </td>
                </tr>
                <tr class="t-grand">
                    <td>Total Invoice</td>
                    <td>Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
                <tr class="t-usd">
                    <td colspan="2">≈ USD $ {{ number_format($grandUsd, 0, ',', '.') }} &nbsp;(kurs ~Rp
                        {{ number_format($usdRate, 0, ',', '.') }})</td>
                </tr>
                @php $kekurangan = max(0, $grandTotal - $totalBayar); @endphp
                @if($kekurangan > 0)
                <tr class="t-remaining">
                    <td colspan="2" style="font-size:11px;font-weight:700;color:var(--danger);padding:6px;background:#fff5f5;border-radius:5px;">
                        Kekurangan Pembayaran &nbsp;&nbsp; Rp {{ number_format($kekurangan, 0, ',', '.') }}
                    </td>
                </tr>
                @endif
            </table>
        </div>
        <div class="paper-foot">
            <div class="foot-note">
                <div style="font-weight:600;color:var(--ink-2);margin-bottom:2px;">Catatan</div>
                Invoice ini diterbitkan secara otomatis oleh sistem PT Hijrah Madani Istiqomah Tour & Travel.<br>
                Pembayaran dianggap sah setelah diverifikasi oleh bagian keuangan.<br>
                Simpan dokumen ini sebagai bukti pembayaran Anda.<br>
                <span style="color:#c0c0d0;">Dicetak: {{ $tglCetak }}</span>
            </div>
            <div class="sign-col">
                <div style="font-size:8px;color:var(--ink-3);margin-bottom:2px;">Hormat Kami,</div>
                <div style="font-size:8px;color:var(--ink-2);font-weight:600;">Direktur Utama,</div>
                <div class="sign-line"></div>
                <div class="sign-name">Cory Cahyati, S.Pd., M.M.</div>
            </div>
        </div>

    </div>{{-- /paper --}}
</body>

</html>