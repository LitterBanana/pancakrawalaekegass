@extends('layouts.leader')

@section('title', 'Analitik - HMI Tour')
@section('page-title', 'Analitik')
@section('page-description', 'Data performa tim dan tren referral')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 animate-fade-in-up">
        <!-- Grafik Revenue Bulanan -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden col-span-1 lg:col-span-2">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-base font-semibold text-gray-900 m-0">📊 Tren Revenue 6 Bulan Terakhir</h3>
                <p class="text-xs text-gray-500 mt-1 mb-0">Total pembayaran terverifikasi dari downline per bulan</p>
            </div>
            <div class="p-6">
                @php
                    $maxRevenue = collect($monthlyData)->max('revenue') ?: 1;
                @endphp

                @if($maxRevenue > 0)
                    <div class="flex flex-col gap-3">
                        @foreach($monthlyData as $data)
                            <div class="flex items-center gap-3">
                                <div class="min-w-[80px] text-xs font-medium text-gray-500 text-right">{{ $data['month'] }}</div>
                                <div class="flex-1 h-7 bg-gray-50 rounded-md overflow-hidden relative">
                                    <div class="h-full rounded-md bg-gradient-to-r from-[#8B1A1A] to-red-600 transition-all duration-600 flex items-center justify-end pr-2 text-[0.7rem] font-semibold text-white"
                                        style="width: {{ $maxRevenue > 0 ? ($data['revenue'] / $maxRevenue * 100) : 0 }}%;">
                                    </div>
                                </div>
                                <div class="text-xs font-semibold text-gray-900 min-w-[90px] text-right">Rp
                                    {{ number_format($data['revenue'], 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <div class="text-2xl mb-2">📊</div>
                        <p>Belum ada data revenue.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Grafik Anggota Baru -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-base font-semibold text-gray-900 m-0">👥 Anggota Baru per Bulan</h3>
                <p class="text-xs text-gray-500 mt-1 mb-0">Tren pertumbuhan downline</p>
            </div>
            <div class="p-6">
                @php
                    $maxMembers = collect($monthlyData)->max('new_members') ?: 1;
                @endphp

                @if($maxMembers > 0)
                    <div class="flex flex-col gap-3">
                        @foreach($monthlyData as $data)
                            <div class="flex items-center gap-3">
                                <div class="min-w-[80px] text-xs font-medium text-gray-500 text-right">{{ $data['month'] }}</div>
                                <div class="flex-1 h-7 bg-gray-50 rounded-md overflow-hidden relative">
                                    <div class="h-full rounded-md bg-gradient-to-r from-blue-500 to-blue-400 transition-all duration-600 flex items-center justify-end pr-2 text-[0.7rem] font-semibold text-white"
                                        style="width: {{ $maxMembers > 0 ? ($data['new_members'] / $maxMembers * 100) : 0 }}%;">
                                    </div>
                                </div>
                                <div class="text-xs font-semibold text-gray-900 min-w-[90px] text-right">{{ $data['new_members'] }}
                                    orang</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <div class="text-2xl mb-2">👥</div>
                        <p>Belum ada data anggota baru.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Top Downline -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-base font-semibold text-gray-900 m-0">🏆 Top Downline</h3>
                <p class="text-xs text-gray-500 mt-1 mb-0">5 downline dengan pembayaran terbesar</p>
            </div>
            <div class="p-6">
                @if($topDownlines->count() > 0 && $topDownlines->first()->total_paid > 0)
                    <div class="flex flex-col gap-3">
                        @foreach($topDownlines as $i => $member)
                            @php
                                $rankBg = $i === 0 ? 'bg-amber-100 text-amber-800' : ($i === 1 ? 'bg-gray-100 text-gray-700' : ($i === 2 ? 'bg-orange-100 text-orange-800' : 'bg-gray-50 text-gray-500'));
                            @endphp
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 hover:bg-red-50 transition-colors">
                                <div
                                    class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $rankBg }}">
                                    {{ $i + 1 }}</div>
                                <div class="flex-1 min-w-0">
                                    <div
                                        class="text-sm font-semibold text-gray-900 whitespace-nowrap overflow-hidden text-ellipsis">
                                        {{ $member->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $member->email }}</div>
                                </div>
                                <div class="text-sm font-bold text-[#8B1A1A] text-right shrink-0">
                                    Rp {{ number_format($member->total_paid ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <div class="text-2xl mb-2">🏆</div>
                        <p>Belum ada data pembayaran dari downline.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection