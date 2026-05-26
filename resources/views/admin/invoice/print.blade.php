<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; margin: 0; padding: 20px; font-size: 14px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-size: 16px; line-height: 24px; color: #555; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.top table td.title { font-size: 28px; line-height: 45px; color: #333; font-weight: bold; }
        .invoice-box table tr.information table td { padding-bottom: 40px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; color: #333; }
        .invoice-box table tr.details td { padding-bottom: 20px; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; color: #333; font-size: 18px; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; color: white; }
        .bg-success { background-color: #28a745; }
        .bg-warning { background-color: #ffc107; color: #333; }
        .bg-danger { background-color: #dc3545; }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }
        .status-paid { background-color: #28a745; }
        .status-pending { background-color: #ffc107; color: #333; }
        .status-dicicil { background-color: #17a2b8; }
        .status-cancelled { background-color: #dc3545; }
        @media print {
            .invoice-box { box-shadow: none; border: 0; padding: 0; }
            .no-print { display: none; }
        }
        .btn-print { margin-bottom: 20px; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div style="text-align: center;" class="no-print">
        <button onclick="window.print()" class="btn-print">Cetak PDF / Print</button>
        <a href="{{ route('admin.invoice.show', $invoice->id) }}" style="margin-left: 10px;text-decoration:none;color:#007bff;">Kembali</a>
    </div>

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">HMI Tour</td>
                            <td>
                                Invoice #: {{ $invoice->id }}<br>
                                Tanggal: {{ \Carbon\Carbon::parse($invoice->created_at)->format('d F Y') }}<br>
                                Status: 
                                @if($invoice->status === 'paid')
                                    <span class="status-badge status-paid">Lunas</span>
                                @elseif($invoice->status === 'pending')
                                    <span class="status-badge status-pending">Pending</span>
                                @elseif($invoice->status === 'dicicil')
                                    <span class="status-badge status-dicicil">Dicicil</span>
                                @else
                                    <span class="status-badge status-cancelled">Dibatalkan</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <b>Pemesan:</b><br>
                                {{ $invoice->customer_name }}<br>
                                {{ $invoice->email }}<br>
                                No. Telepon: {{ $invoice->phone }}
                            </td>
                            <td>
                                <b>Tujuan Pembayaran:</b><br>
                                HMI Tour Travel<br>
                                Keuangan & Administrasi
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Deskripsi Paket</td>
                <td>Jumlah</td>
            </tr>

            <tr class="item">
                <td>
                    <b>Paket: {{ $invoice->package->name ?? 'Paket Terhapus' }}</b><br>
                    <small>Jumlah Jamaah: {{ $invoice->number_of_people ?? '-' }} orang</small><br>
                    <small>Booking Ref: #{{ $invoice->id }}</small>
                </td>
                <td>Rp {{ number_format($invoice->total_price, 0, ',', '.') }}</td>
            </tr>

            @if($totalPaid > 0)
            <tr class="item">
                <td><b>Pembayaran Diterima</b></td>
                <td>- Rp {{ number_format($totalPaid, 0, ',', '.') }}</td>
            </tr>
            @endif

            <tr class="total">
                <td>
                    @if($sisaTagihan > 0)
                        <b>Sisa Tagihan:</b>
                    @else
                        <b>Status:</b>
                    @endif
                </td>
                <td>
                    @if($sisaTagihan > 0)
                        Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
                    @else
                        <span class="status-badge status-paid">Lunas</span>
                    @endif
                </td>
            </tr>
        </table>

        @if($invoice->notes)
        <div style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-left: 4px solid #007bff;">
            <b>Catatan:</b><br>
            {{ $invoice->notes }}
        </div>
        @endif
        
        <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #888;">
            <p>Terima kasih telah mempercayakan perjalanan Anda bersama HMI Tour Travel.</p>
            <p>Invoice ini sah sebagai bukti pembayaran yang diterbitkan oleh sistem komputer.</p>
        </div>
    </div>
</body>
</html>
