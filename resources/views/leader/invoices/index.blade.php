@extends('layouts.leader')

@section('title', 'Invoice Komisi — HMI Leader')
@section('page-title', 'Invoice Downline')
@section('page-description', 'Rekap komisi Anda berdasarkan downline yang telah melunasi pembayaran')



@section('content')

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6 animate-fade-in-up">
        <div
            class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-[#8B1A1A]">
            <div class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Total Komisi</div>
            <div class="text-2xl font-bold text-[#8B1A1A] font-sans">Rp {{ number_format($totalCommission, 0, ',', '.') }}
            </div>
        </div>
        <div
            class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-[#8B1A1A]">
            <div class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Total Jamaah</div>
            <div class="text-2xl font-bold text-gray-900 font-sans">{{ $totalPeople }}</div>
        </div>
        <div
            class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-[#8B1A1A]">
            <div class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Booking Lunas</div>
            <div class="text-2xl font-bold text-gray-9 0 font-sans">{{ $totalBookings }}</div>
        </div>
        <div
            class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-[#8B1A1A]">
            <div class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Periode</div>
            <div class="text-xl font-bold text-gray-900 font-sans">{{ $totalMonths }} Bulan</div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden animate-fade-in-up delay-1">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-900 m-0">
                Invoice Komisi Downline
            </h3>
            <span
                class="inline-flex items-center bg-emerald-50 text-emerald-800 px-3 py-1 rounded-full text-xs font-semibold border border-emerald-200">Rp
                200.000 / orang</span>
        </div>

        {{-- Filter --}}
        <div class="p-4 md:px-6 border-b border-gray-200">
            <form method="GET" action="{{ route('leader.invoices.index') }}">
                <div class="flex items-center gap-3 flex-wrap">
                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                        placeholder="Cari nama jamaah atau paket..."
                        class="flex-1 min-w-[200px] px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:border-[#8B1A1A] transition-colors">
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-[#8B1A1A] rounded-lg hover:bg-[#6B1010] transition-colors">Cari</button>
                    @if(request('keyword'))
                        <a href="{{ route('leader.invoices.index') }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-gray-600 bg-transparent border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        @if($groupedByMonth->count() > 0)
            @foreach($groupedByMonth as $monthKey => $items)
                @php
                    $monthLabel = $items->first()['month_label'] ?? $monthKey;
                    $monthTotal = $items->sum('commission');
                    $monthPeople = $items->sum('jumlah_orang');
                @endphp
                <div class="mb-8">
                    <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <div>
                            <span class="text-base font-bold text-gray-900">{{ $monthLabel }}</span>
                            <span class="text-sm text-gray-500 ml-2">
                                ({{ $monthPeople }} orang, {{ $items->count() }} booking)
                            </span>
                        </div>
                        <span class="text-sm font-bold text-[#8B1A1A]">Rp {{ number_format($monthTotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                        #</th>
                                    <th
                                        class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                        Jamaah</th>
                                    <th
                                        class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                        Paket</th>
                                    <th
                                        class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                        Tipe Kamar</th>
                                    <th
                                        class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200 text-center">
                                        Jumlah Orang</th>
                                    <th
                                        class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                        Tgl. Lunas</th>
                                    <th
                                        class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200 text-right">
                                        Komisi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($items as $idx => $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $idx + 1 }}</td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-sm text-gray-900">
                                                {{ $item['user']->name ?? '—' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $item['user']->email ?? '' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item['package']->name ?? '—' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600 capitalize">{{ $item['price_type'] }}</td>
                                        <td class="px-6 py-4 text-sm text-center font-semibold text-gray-900">
                                            {{ $item['jumlah_orang'] }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item['lunas_date']->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-right font-bold text-emerald-700">
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
            <div class="text-center py-12 px-6 text-gray-500">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Belum Ada Invoice Komisi</h3>
                <p class="text-sm">
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