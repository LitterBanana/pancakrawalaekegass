@extends('layouts.leader')

@section('title', 'Laporan Penjualan - HMI Tour')
@section('page-title', 'Laporan Penjualan')
@section('page-description', 'Ringkasan komisi dari downline yang sudah melunasi pembayaran')



@section('content')
    <!-- Statistik Ringkasan -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fade-in-up">
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-[#8B1A1A]">
            <div class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Total Komisi</div>
            <div class="text-2xl font-bold text-gray-900 font-sans">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-[#8B1A1A]">
            <div class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Komisi Bulan Ini</div>
            <div class="text-2xl font-bold text-gray-900 font-sans">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-[#8B1A1A]">
            <div class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Total Jamaah Lunas</div>
            <div class="text-2xl font-bold text-gray-900 font-sans">{{ $totalPeople }}</div>
        </div>
    </section>

    <!-- Tabel Komisi -->
    <section class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden animate-fade-in-up delay-1">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-900 m-0">Rekap Komisi per Booking</h3>
            <span class="inline-flex items-center bg-emerald-50 text-emerald-800 px-3 py-1 rounded-full text-xs font-semibold border border-emerald-200">Rp 200.000 / orang</span>
        </div>

        @if($commissionItems->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">#</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Jamaah</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Paket</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200 text-center">Jumlah Orang</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Tgl. Lunas</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200 text-right">Komisi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($commissionItems as $i => $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $i + 1 }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $item->user_name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->package_name }}</td>
                                <td class="px-6 py-4 text-sm text-center font-semibold text-gray-900">{{ $item->jumlah_orang }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->lunas_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm text-right font-bold text-emerald-700">
                                    Rp {{ number_format($item->commission, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-sm font-bold text-gray-900 border-t-2 border-gray-200">
                                TOTAL
                            </td>
                            <td class="px-6 py-4 text-sm text-center font-bold text-gray-900 border-t-2 border-gray-200">
                                {{ $totalPeople }}
                            </td>
                            <td class="px-6 py-4 border-t-2 border-gray-200"></td>
                            <td class="px-6 py-4 text-base text-right font-bold text-[#8B1A1A] border-t-2 border-gray-200">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="text-center py-12 px-6 text-gray-500">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Belum Ada Data Komisi</h3>
                <p class="text-sm">Belum ada downline yang melunasi pembayaran secara penuh.</p>
            </div>
        @endif
    </section>
@endsection
