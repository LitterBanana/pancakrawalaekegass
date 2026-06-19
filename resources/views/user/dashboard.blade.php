@extends('user.layouts.app')

@section('title', 'Dashboard — HMI Tour Travel')
@section('description', 'Dashboard HMI Tour Travel - Pantau pembayaran tour Anda')
@section('page-title', 'Dashboard')
@section('page-description', 'Pantau pembayaran tour Anda')

@section('content')
  <!-- Welcome Banner -->
  <section class="bg-gradient-to-br from-[#8B1A1A] to-[#6B1010] rounded-2xl p-8 mb-8 relative overflow-hidden animate-fade-in-up" aria-label="Banner selamat datang">
    <div class="absolute -top-[50%] -right-[10%] w-[300px] h-[300px] rounded-full bg-white/10"></div>
    <div class="absolute -bottom-[60%] right-[15%] w-[200px] h-[200px] rounded-full bg-white/5"></div>
    <div class="relative z-10">
      <h2 class="text-white text-2xl mb-2 font-bold font-display">Halo, {{ explode(' ', $user->name)[0] }}!</h2>
      <p class="text-white/85 text-base mb-6 max-w-xl">Pantau progress pembayaran tour Anda dan lakukan pembayaran dengan mudah melalui sistem kami.</p>
      @if(session()->has('impersonate_user_id'))
      <button class="bg-white/70 text-gray-500 font-semibold px-6 py-3 rounded-xl cursor-not-allowed flex items-center gap-2" onclick="alert('Fitur pembayaran dikunci selama Anda melakukan akses dari Dashboard Admin.')">
        <ion-icon name="lock-closed"></ion-icon> Bayar Sekarang (Terkunci)
      </button>
      @else
      <a href="{{ route('user.payment') }}" class="bg-white text-[#8B1A1A] font-semibold px-6 py-3 rounded-xl hover:bg-red-50 hover:-translate-y-px transition-all inline-flex items-center gap-2">
        <ion-icon name="card"></ion-icon> Bayar Sekarang
      </a>
      @endif
    </div>
  </section>

  <!-- Stats Grid -->
  <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" aria-label="Statistik pembayaran">
    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm transition-all hover:shadow-lg hover:-translate-y-1 animate-fade-in-up delay-1">
      <p class="text-sm text-gray-500 mb-1">Total Tagihan</p>
      <div class="font-display text-2xl font-bold text-gray-900">Rp {{ number_format($totalCost, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm transition-all hover:shadow-lg hover:-translate-y-1 animate-fade-in-up delay-2">
      <p class="text-sm text-gray-500 mb-1">Sudah Dibayar</p>
      <div class="font-display text-2xl font-bold text-gray-900">Rp {{ number_format($paidAmount, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm transition-all hover:shadow-lg hover:-translate-y-1 animate-fade-in-up delay-3">
      <p class="text-sm text-gray-500 mb-1">Sisa Tagihan</p>
      <div class="font-display text-2xl font-bold text-gray-900">Rp {{ number_format($remaining, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm transition-all hover:shadow-lg hover:-translate-y-1 animate-fade-in-up delay-4">
      <p class="text-sm text-gray-500 mb-1">Status</p>
      <div class="font-display text-lg font-bold text-gray-900 mt-1">
        @if($totalCost == 0)
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">Belum Ada Tagihan</span>
        @elseif($isPaid)
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">Lunas</span>
        @else
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-200">Belum Lunas</span>
        @endif
      </div>
    </div>
  </section>

  <!-- Quick Actions -->
  <section aria-label="Aksi cepat" class="mb-8">
    <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
      <div>
        <h2 class="text-xl font-bold text-gray-900 m-0">Aksi Cepat</h2>
        <p class="text-sm text-gray-500 mt-1 m-0">Akses fitur utama dengan cepat</p>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @if(session()->has('impersonate_user_id'))
      <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm text-center flex flex-col items-center justify-center opacity-60 cursor-not-allowed animate-fade-in-up delay-2">
        <h4 class="text-sm font-bold text-gray-900 m-0 mb-1">Bayar Sekarang</h4>
        <p class="text-xs text-red-500 m-0">Terkunci mode impersonasi</p>
      </div>
      @else
      <a href="{{ route('user.payment') }}" class="group bg-white rounded-2xl p-6 border border-gray-200 shadow-sm text-center flex flex-col items-center justify-center transition-all hover:shadow-lg hover:-translate-y-1 hover:border-red-200 animate-fade-in-up delay-2">
        <h4 class="text-sm font-bold text-gray-900 m-0 mb-1 group-hover:text-[#8B1A1A] transition-colors">Bayar Sekarang</h4>
        <p class="text-xs text-gray-500 m-0">Lakukan pembayaran cicilan tour Anda</p>
      </a>
      @endif
      <a href="{{ route('user.invoices') }}" class="group bg-white rounded-2xl p-6 border border-gray-200 shadow-sm text-center flex flex-col items-center justify-center transition-all hover:shadow-lg hover:-translate-y-1 hover:border-blue-200 animate-fade-in-up delay-3">
        <h4 class="text-sm font-bold text-gray-900 m-0 mb-1 group-hover:text-blue-600 transition-colors">Travel Invoices</h4>
        <p class="text-xs text-gray-500 m-0">Lihat & cetak invoice pembayaran</p>
      </a>
      <a href="{{ route('user.profile') }}" class="group bg-white rounded-2xl p-6 border border-gray-200 shadow-sm text-center flex flex-col items-center justify-center transition-all hover:shadow-lg hover:-translate-y-1 hover:border-emerald-200 animate-fade-in-up delay-4">
        <h4 class="text-sm font-bold text-gray-900 m-0 mb-1 group-hover:text-emerald-600 transition-colors">Profil Saya</h4>
        <p class="text-xs text-gray-500 m-0">Kelola informasi akun Anda</p>
      </a>
    </div>
  </section>

  <!-- Dashboard Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Payment Progress -->
    <section class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm mb-8 animate-fade-in-up delay-3" aria-label="Progress pembayaran">
      <div class="flex items-center justify-between mb-4">
        <h3 class="m-0 text-base font-bold text-gray-900">Progress Pembayaran</h3>
        @if($booking)
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-200">Aktif</span>
        @else
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">Belum Ada Booking</span>
        @endif
      </div>
      <div>
        <div class="flex items-center justify-between mb-4">
          <div class="flex items-baseline gap-2">
            <span class="font-display text-3xl font-bold text-[#8B1A1A]">{{ $percentage }}%</span>
            <span class="text-sm text-gray-500">terbayar</span>
          </div>
        </div>
        <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden mb-4 relative">
          <div class="h-full rounded-full transition-all duration-1000 ease-out absolute left-0 top-0 {{ $isPaid ? 'bg-gradient-to-r from-emerald-500 to-emerald-400' : 'bg-gradient-to-r from-[#8B1A1A] to-red-500' }}" style="width: {{ $percentage }}%;"></div>
        </div>
        <div class="flex flex-col sm:flex-row gap-6 mt-6">
          <div class="flex flex-col gap-1">
            <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Dibayar</span>
            <span class="text-lg font-semibold text-gray-900">Rp {{ number_format($paidAmount, 0, ',', '.') }}</span>
          </div>
          <div class="flex flex-col gap-1">
            <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total</span>
            <span class="text-lg font-semibold text-gray-900">Rp {{ number_format($totalCost, 0, ',', '.') }}</span>
          </div>
          <div class="flex flex-col gap-1">
            <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Sisa</span>
            <span class="text-lg font-semibold text-red-600">Rp {{ number_format($remaining, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Recent Transactions -->
    <section class="bg-white rounded-2xl border border-gray-200 shadow-sm animate-fade-in-up delay-4 flex flex-col" aria-label="Transaksi terbaru">
      <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <h3 class="m-0 text-base font-bold text-gray-900">Transaksi Terbaru</h3>
        <a href="{{ route('user.invoices') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors">Lihat Semua</a>
      </div>
      <div class="flex-1">
        @forelse($recentPayments as $payment)
          <div class="flex items-center gap-4 p-4 px-6 border-b border-gray-100 hover:bg-red-50/50 transition-colors last:border-0">
            <div class="flex-1 min-w-0">
              <div class="text-sm font-semibold text-gray-900 mb-0.5 truncate">
                {{ ucfirst($payment->payment_method) }}{{ $payment->bank_name ? ' - ' . strtoupper($payment->bank_name) : '' }}
              </div>
              <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</div>
            </div>
            <div class="text-right">
              <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
              <div class="mt-1">
                @if($payment->status === 'sudah_lunas')
                  <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Terverifikasi</span>
                @elseif($payment->status === 'ditolak')
                  <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700">Ditolak</span>
                @else
                  <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">Pending</span>
                @endif
              </div>
            </div>
          </div>
        @empty
          <div class="text-center p-12">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Transaksi</h3>
            <p class="text-sm text-gray-500 max-w-xs mx-auto m-0">Mulai pembayaran pertama Anda sekarang.</p>
          </div>
        @endforelse
      </div>
    </section>
  </div>
@endsection
