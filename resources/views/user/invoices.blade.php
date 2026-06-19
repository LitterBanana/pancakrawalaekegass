@extends('user.layouts.app')

@section('title', 'Travel Invoices — HMI Tour Travel')
@section('description', 'Travel Invoices - HMI Tour Travel')
@section('page-title', 'Travel Invoices')

@section('page_scripts')
  <script>
    function toggleInvoiceDetail(btn) {
        const detail = btn.closest('.invoice-card').querySelector('.invoice-detail');
        detail.classList.toggle('hidden');
    }
  </script>
@endsection

@section('content')
  <div class="max-w-[1200px] mx-auto">

    <!-- Print Header (only visible when printing) -->
    <div class="hidden print:block text-center mb-6 pb-4 border-b-2 border-[#8B1A1A]">
      <h1 class="text-2xl text-[#8B1A1A] mb-1 font-bold">HMI Tour Travel — Travel Invoices</h1>
      <p class="text-sm text-gray-600">Cetak Invoice Pembayaran Tour</p>
    </div>

    <!-- Invoice Stats -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 animate-fade-in-up print:hidden" aria-label="Statistik invoice">
      <div class="bg-white rounded-2xl p-5 border border-gray-200">
        <p class="text-xs text-gray-500 m-0 mb-1">Total Invoice</p>
        <h4 class="text-2xl font-bold m-0" id="totalInvoices">{{ $totalInvoices }}</h4>
      </div>
      <div class="bg-white rounded-2xl p-5 border border-gray-200">
        <p class="text-xs text-gray-500 m-0 mb-1">Sudah Lunas</p>
        <h4 class="text-2xl font-bold m-0" id="paidInvoices">{{ $paidInvoices }}</h4>
      </div>
      <div class="bg-white rounded-2xl p-5 border border-gray-200">
        <p class="text-xs text-gray-500 m-0 mb-1">Belum Lunas</p>
        <h4 class="text-2xl font-bold m-0" id="unpaidInvoices">{{ $unpaidInvoices }}</h4>
      </div>
    </section>

    <!-- Filter Tabs & Search -->
    <section aria-label="Filter dan pencarian invoice" class="print:hidden">
      <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 mb-6">
        <div class="flex gap-1 bg-gray-100 p-1 rounded-xl overflow-x-auto">
          <a href="{{ route('user.invoices', ['status' => 'all']) }}" class="flex-1 min-w-[100px] text-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all whitespace-nowrap {{ !request('status') || request('status') === 'all' ? 'bg-white text-[#8B1A1A] shadow-sm font-semibold' : 'text-gray-500 hover:text-gray-900' }}">Semua</a>
          <a href="{{ route('user.invoices', ['status' => 'sudah_lunas']) }}" class="flex-1 min-w-[130px] text-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all whitespace-nowrap {{ request('status') === 'sudah_lunas' ? 'bg-white text-[#8B1A1A] shadow-sm font-semibold' : 'text-gray-500 hover:text-gray-900' }}">Sudah Lunas</a>
          <a href="{{ route('user.invoices', ['status' => 'belum_lunas']) }}" class="flex-1 min-w-[130px] text-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all whitespace-nowrap {{ request('status') === 'belum_lunas' ? 'bg-white text-[#8B1A1A] shadow-sm font-semibold' : 'text-gray-500 hover:text-gray-900' }}">Belum Lunas</a>
        </div>
        <form class="relative flex-1 max-w-[360px] w-full" action="{{ route('user.invoices') }}" method="GET">
          @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
          @endif
          <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
          </span>
          <input type="text" name="keyword" value="{{ request('keyword') }}" class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#8B1A1A] focus:ring-2 focus:ring-red-100 transition-all" placeholder="Cari invoice..." aria-label="Cari invoice berdasarkan ID atau nama paket">
        </form>
      </div>
    </section>

    <!-- Invoice List -->
    <section id="invoiceList" class="flex flex-col gap-4 animate-fade-in-up" aria-label="Daftar invoice">
      @forelse($payments as $payment)
        <div class="invoice-card bg-white rounded-2xl border border-gray-200 shadow-sm transition-all hover:shadow-md hover:border-red-200 overflow-hidden print:border print:border-gray-300 print:shadow-none print:mb-4 print:break-inside-avoid">
            <div class="p-5 md:px-6 flex flex-wrap md:flex-nowrap items-center gap-4 cursor-pointer" onclick="toggleInvoiceDetail(this)">
                <div class="flex-1 min-w-0 w-full md:w-auto">
                    <div class="text-sm font-bold text-gray-900 mb-0.5">{{ $payment->invoice_number }}</div>
                    <div class="text-xs text-gray-500 truncate">{{ $payment->booking->package->name ?? 'Paket Terhapus' }}</div>
                </div>
                <div class="flex items-center gap-6 shrink-0 w-full md:w-auto justify-between md:justify-end mt-4 md:mt-0">
                    <div class="text-left md:text-right">
                        <div class="text-xs text-gray-500">Jumlah Pembayaran</div>
                        <div class="text-base font-bold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    </div>
                    <div class="flex gap-2 print:hidden">
                        <a href="{{ route('user.invoices.print', $payment->id) }}" target="_blank" class="px-3 py-1.5 text-sm font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors flex items-center gap-1" aria-label="Cetak invoice" onclick="event.stopPropagation()">Cetak</a>
                        <button class="px-3 py-1.5 text-sm font-medium text-white bg-[#8B1A1A] hover:bg-red-800 rounded-lg transition-colors" onclick="event.stopPropagation(); toggleInvoiceDetail(this)">Detail</button>
                    </div>
                </div>
            </div>
            
            <div class="invoice-detail hidden print:block px-6 pb-6 pt-2 border-t border-gray-100 bg-gray-50/50">
                @php
                    $booking   = $payment->booking;
                    $pkg       = $booking->package ?? null;
                    $price     = $booking->packagePrice ?? null;
                    $usdRate   = $booking->usd_rate ?? 15800;
                    $addons    = is_array($booking->addons) ? $booking->addons : (json_decode($booking->addons, true) ?? []);

                    $addonDefs = [
                        'paspor'         => ['label' => 'Pembuatan E-Paspor Express', 'price_idr' => 1500000],
                        'bisnis_class'   => ['label' => 'Upgrade Bisnis Class',        'price_idr' => 8000000],
                        'upgrade_kamar'  => ['label' => 'Upgrade Kamar Hotel',          'price_idr' => 2500000],
                        'vaksin'         => ['label' => 'Vaksin',                        'price_idr' => 350000],
                    ];

                    $totalAddons = 0;
                    foreach ($addonDefs as $key => $def) {
                        $qty = $addons[$key] ?? 0;
                        $totalAddons += $qty * $def['price_idr'];
                    }

                    $hargaKamar   = $price->price ?? 0;
                    $totalPaket   = $hargaKamar * ($booking->jumlah_orang ?? 1);
                    $grandTotal   = $booking->total_price;
                    $sisa         = $booking->sisa_tagihan ?? max(0, $grandTotal - ($booking->sudah_dibayar ?? 0));
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                    <div>
                        <h5 class="text-sm font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-200">Informasi Pembayaran</h5>
                        <div class="flex justify-between py-1.5 text-sm">
                            <span class="text-gray-500">Status</span>
                            <span class="font-medium">
                                @if($payment->status === 'sudah_lunas')
                                    <span class="text-emerald-600">Lunas (Diverifikasi)</span>
                                @elseif($payment->status === 'belum_lunas')
                                    <span class="text-amber-600">Pending (Menunggu Verifikasi)</span>
                                @else
                                    <span class="text-red-600">Ditolak</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between py-1.5 text-sm">
                            <span class="text-gray-500">Metode</span>
                            <span class="font-medium text-gray-900">{{ ucfirst($payment->payment_method) }} {{ $payment->bank_name ? '('.strtoupper($payment->bank_name).')' : '' }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 text-sm">
                            <span class="text-gray-500">Tanggal & Waktu</span>
                            <span class="font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($payment->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                            </span>
                        </div>
                        <div class="flex justify-between py-1.5 text-sm mt-1">
                            <span class="text-gray-500">Jumlah Bayar Ini</span>
                            <span class="font-bold text-[#8B1A1A]">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <h5 class="text-sm font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-200">Status Tagihan</h5>
                        <div class="flex justify-between py-1.5 text-sm">
                            <span class="text-gray-500">Total Tagihan</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 text-sm">
                            <span class="text-gray-500">Sudah Dibayar <small class="text-gray-400 font-normal">(verified)</small></span>
                            <span class="font-medium text-emerald-600">
                                Rp {{ number_format($booking->sudah_dibayar ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                        @if(($booking->pending_verifikasi ?? 0) > 0)
                        <div class="flex justify-between py-1.5 text-sm">
                            <span class="text-gray-500">Menunggu Verifikasi</span>
                            <span class="font-medium text-amber-600">
                                Rp {{ number_format($booking->pending_verifikasi, 0, ',', '.') }}
                            </span>
                        </div>
                        @endif
                        <div class="flex justify-between py-2.5 mt-2 border-t-2 border-gray-200">
                            <span class="font-semibold text-gray-900">Sisa Tagihan</span>
                            <span class="font-bold {{ $sisa == 0 ? 'text-emerald-600' : 'text-[#8B1A1A]' }}">
                                @if($sisa == 0) Lunas @else Rp {{ number_format($sisa, 0, ',', '.') }} @endif
                            </span>
                        </div>
                        @if(($booking->pending_verifikasi ?? 0) > 0)
                        <p class="text-xs text-gray-500 mt-2 italic leading-relaxed">
                            ℹ️ Sisa tagihan akan berkurang setelah admin memverifikasi pembayaran.
                        </p>
                        @endif
                    </div>
                </div>

                {{-- RINCIAN PAKET --}}
                <div class="mt-6 border-t border-gray-200 pt-5">
                    <h5 class="text-sm font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-100">
                        Rincian Paket
                    </h5>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-gray-100 text-gray-600 uppercase">
                                <tr>
                                    <th class="px-3 py-2 font-semibold rounded-tl-lg">Deskripsi</th>
                                    <th class="px-3 py-2 font-semibold text-center">Jenis Kamar</th>
                                    <th class="px-3 py-2 font-semibold text-center">Pax</th>
                                    <th class="px-3 py-2 font-semibold text-right">Harga/Pax (IDR)</th>
                                    <th class="px-3 py-2 font-semibold text-right">Harga/Pax (USD)</th>
                                    <th class="px-3 py-2 font-semibold text-right rounded-tr-lg">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100 bg-white">
                                    <td class="px-3 py-3">
                                        <div class="font-semibold text-gray-900">{{ $pkg->name ?? 'Paket Umrah' }}</div>
                                        <div class="text-gray-500 mt-1">{{ $pkg->category->name ?? '-' }} • {{ $pkg ? \Carbon\Carbon::parse($pkg->departure_date)->format('d M Y') : '-' }}</div>
                                    </td>
                                    <td class="px-3 py-3 text-center">
                                        <span class="bg-red-50 text-[#8B1A1A] px-2.5 py-1 rounded-full font-semibold border border-red-100">
                                            {{ $price->type ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center font-semibold">{{ $booking->jumlah_orang ?? 1 }}</td>
                                    <td class="px-3 py-3 text-right">Rp {{ number_format($hargaKamar, 0, ',', '.') }}</td>
                                    <td class="px-3 py-3 text-right">$ {{ number_format(round($hargaKamar / $usdRate, 0), 0, ',', '.') }}</td>
                                    <td class="px-3 py-3 text-right font-bold text-gray-900">Rp {{ number_format($totalPaket, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ADD-ONS --}}
                <div class="mt-6 border-t border-gray-200 pt-5">
                    <h5 class="text-sm font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-100">
                        Layanan Tambahan (Add-On)
                    </h5>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-gray-100 text-gray-600 uppercase">
                                <tr>
                                    <th class="px-3 py-2 font-semibold w-8 rounded-tl-lg"></th>
                                    <th class="px-3 py-2 font-semibold">Layanan</th>
                                    <th class="px-3 py-2 font-semibold text-right">Harga/item (IDR)</th>
                                    <th class="px-3 py-2 font-semibold text-right">Harga/item (USD)</th>
                                    <th class="px-3 py-2 font-semibold text-center">Qty</th>
                                    <th class="px-3 py-2 font-semibold text-right rounded-tr-lg">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($addonDefs as $key => $def)
                                @php
                                    $qty      = $addons[$key] ?? 0;
                                    $subtotal = $qty * $def['price_idr'];
                                    $checked  = $qty > 0;
                                @endphp
                                <tr class="border-b border-gray-100 {{ $checked ? 'bg-white' : 'bg-gray-50/50 opacity-60' }}">
                                    <td class="px-3 py-2.5 text-center">
                                        @if($checked)
                                            <span class="text-emerald-500 text-sm">✓</span>
                                        @else
                                            <span class="text-gray-300 text-sm">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2.5 font-medium {{ $checked ? 'text-gray-900 font-semibold' : 'text-gray-500' }}">{{ $def['label'] }}</td>
                                    <td class="px-3 py-2.5 text-right">Rp {{ number_format($def['price_idr'], 0, ',', '.') }}</td>
                                    <td class="px-3 py-2.5 text-right">$ {{ number_format(round($def['price_idr'] / $usdRate, 0), 0, ',', '.') }}</td>
                                    <td class="px-3 py-2.5 text-center font-semibold">{{ $qty }}</td>
                                    <td class="px-3 py-2.5 text-right font-bold {{ $checked ? 'text-gray-900' : 'text-gray-400 font-normal' }}">
                                        {{ $checked ? 'Rp '.number_format($subtotal, 0, ',', '.') : '-' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TOTAL AKHIR --}}
                <div class="mt-6 border-t-2 border-gray-200 pt-5 flex justify-end">
                    <div class="w-full max-w-sm">
                        <div class="flex justify-between py-1.5 text-xs text-gray-500">
                            <span>Total Paket ({{ $booking->jumlah_orang ?? 1 }} pax)</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($totalPaket, 0, ',', '.') }}</span>
                        </div>
                        @if($totalAddons > 0)
                        <div class="flex justify-between py-1.5 text-xs text-gray-500">
                            <span>Total Add-On</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($totalAddons, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between py-3 mt-2 border-t-2 border-[#8B1A1A] text-base font-bold text-[#8B1A1A]">
                            <span>TOTAL INVOICE</span>
                            <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-1 text-xs text-gray-500">
                            <span>Dalam USD (kurs ~{{ number_format($usdRate, 0, ',', '.') }})</span>
                            <span>≈ $ {{ number_format(round($grandTotal / $usdRate, 0), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      @empty
        <div class="text-center py-16 bg-white rounded-2xl border border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Tidak Ada Invoice</h3>
            <p class="text-sm text-gray-500 m-0">Anda belum memiliki riwayat invoice.</p>
        </div>
      @endforelse
    </section>

    <!-- Print Footer (only visible when printing) -->
    <div class="hidden print:block mt-10 pt-4 border-t border-gray-300 text-center text-xs text-gray-500">
      <p>Dicetak oleh sistem HMI Tour Travel | &copy; 2024 HMI Tour Travel</p>
    </div>

  </div>
@endsection