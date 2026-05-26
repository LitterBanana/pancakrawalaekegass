@extends('layouts.app')

@section('content')
<section class="pt-[200px] pb-[60px] min-h-screen" style="background: linear-gradient(to bottom, #1a2b4c 0%, #1a2b4c 160px, #f4f7f6 160px, #f4f7f6 100%);">
    <div class="max-w-[700px] mx-auto bg-white p-10 rounded-xl shadow-md">

        <div class="text-center mb-8">
            <div class="w-[60px] h-[60px] bg-green-600 text-white rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                ✓
            </div>
            <h2 class="text-mp-primary mb-1 font-bold text-xl">Pemesanan Berhasil!</h2>
            <p class="text-gray-500">Terima kasih, <strong>{{ $booking->customer_name }}</strong>. Berikut adalah rincian pesanan Anda.</p>
        </div>

        <div class="bg-[#fdfdfd] border border-gray-200 p-5 rounded-lg mb-8">
            <h3 class="border-b-2 border-[#ff7b00] pb-2.5 mb-4 text-lg font-bold">Rincian Tagihan (ID: #INV-{{ $booking->id }}{{ date('y') }})</h3>

            <table class="w-full text-left border-collapse">
                <tr class="border-b border-gray-200">
                    <th class="py-2.5 text-gray-500 font-semibold">Paket</th>
                    <td class="py-2.5 text-right font-bold">{{ $booking->package->name }}</td>
                </tr>
                <tr class="border-b border-gray-200">
                    <th class="py-2.5 text-gray-500 font-semibold">Tipe Kamar</th>
                    <td class="py-2.5 text-right">{{ $booking->packagePrice->type }} ({{ $booking->jumlah_orang }} Pax)</td>
                </tr>
                <tr>
                    <th class="py-4 text-lg text-mp-primary font-bold">Total Pembayaran</th>
                    <td class="py-4 text-right text-xl text-[#ff7b00] font-bold">
                        IDR {{ number_format($booking->total_price, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="bg-[#e9f7fd] border border-[#b8e2f2] p-5 rounded-lg mb-8">
            <h3 class="mb-2.5 text-base text-[#0c5460] font-bold">Instruksi Pembayaran</h3>
            <p class="text-sm leading-relaxed text-[#0c5460]">
                Silakan lakukan pembayaran DP atau Lunas ke rekening resmi perusahaan kami:<br><br>
                <strong>Bank Syariah Indonesia (BSI)</strong><br>
                No. Rekening: <strong>712-345-6789</strong><br>
                Atas Nama: <strong>PT. Hijrah Madani Istiqomah</strong>
            </p>
        </div>

        @php
            $waNumber = "6281234567890";
            $waMessage = "Assalamualaikum, saya " . $booking->customer_name . ". Saya ingin konfirmasi pemesanan tiket dengan ID: #INV-" . $booking->id . date('y') . " untuk paket " . $booking->package->name . ".";
            $waLink = "https://wa.me/" . $waNumber . "?text=" . urlencode($waMessage);
        @endphp

        <div class="text-center">
            <a href="{{ $waLink }}" target="_blank" class="inline-block bg-[#25D366] text-white py-3 px-6 rounded-md no-underline font-bold text-base hover:bg-[#1fb855] transition-colors">
                Konfirmasi Pembayaran via WhatsApp
            </a>
            <p class="mt-4 text-[13px] text-gray-400">Simpan tangkapan layar (screenshot) halaman ini sebagai bukti pemesanan Anda.</p>
        </div>

    </div>
</section>
@endsection