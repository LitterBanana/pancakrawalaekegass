@extends('layouts.user')

@section('title', 'Profil Saya — HMI Tour Travel')
@section('description', 'Profil Anggota - HMI Tour Travel')
@section('page-title', 'Profil Saya')

@section('content')
  <div class="max-w-[960px] mx-auto">

    <!-- Profile Header Card -->
    <section class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6 animate-fade-in-up" aria-label="Informasi profil utama">
      <div class="h-[140px] bg-gradient-to-br from-[#8B1A1A] via-red-700 to-orange-700 relative overflow-hidden">
        <div class="absolute -top-[60%] -right-[8%] w-[260px] h-[260px] rounded-full bg-white/10"></div>
        <div class="absolute -bottom-[50%] left-[10%] w-[180px] h-[180px] rounded-full bg-white/5"></div>
      </div>
      <div class="px-6 md:px-8 pb-7 flex items-end gap-6 -mt-11 relative z-10 flex-wrap">
        <div class="flex-shrink-0 relative">
          {{-- Inisial dari nama user asli --}}
          <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-[#8B1A1A] to-red-700 text-white flex items-center justify-center text-3xl font-bold font-sans border-4 border-white shadow-[0_6px_20px_rgba(139,26,26,0.25)]">
            {{ strtoupper(substr(explode(' ', trim($user->name))[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', trim($user->name))[1] ?? '', 0, 1)) }}
          </div>
          <div class="absolute bottom-1 right-1 w-4 h-4 rounded-full bg-emerald-500 border-[3px] border-white" title="Online"></div>
        </div>
        <div class="flex-1 min-w-0 pt-7">
          <h2 class="text-2xl font-bold text-gray-900 mt-2 mb-1.5 pt-2 leading-tight">{{ $user->name }}</h2>
          <div class="flex items-center gap-3 text-sm text-gray-500 flex-wrap">
            <span class="font-mono text-xs text-gray-500 bg-gray-50 px-2.5 py-1 rounded-md border border-gray-200">{{ 'HMI-' . str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span>
            <span class="bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">{{ ucfirst($user->role ?? 'Anggota HMI') }}</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Profile Content Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <!-- Personal Info Card -->
      <section class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md hover:-translate-y-1 animate-fade-in-up delay-1" aria-label="Informasi pribadi">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                <ion-icon name="person-outline" class="text-xl"></ion-icon>
            </div>
            <h3 class="text-base font-semibold text-gray-900 m-0">Informasi Pribadi</h3>
        </div>
        <div class="p-6">
          <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
            <span class="text-gray-500 shrink-0 min-w-[110px]">Email</span>
            <span class="font-semibold text-gray-900 text-right break-words">{{ $user->email ?? '-' }}</span>
          </div>
          <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
            <span class="text-gray-500 shrink-0 min-w-[110px]">Role</span>
            <span class="font-semibold text-gray-900 text-right break-words">{{ ucfirst($user->role ?? '-') }}</span>
          </div>
          @if($user->referred_by)
            @php $leaderUser = App\Models\User::find($user->referred_by); @endphp
            <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
              <span class="text-gray-500 shrink-0 min-w-[110px]">Leader Referral</span>
              <span class="font-bold text-gray-900 text-right break-words">{{ $leaderUser?->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
              <span class="text-gray-500 shrink-0 min-w-[110px]">Kode Referral</span>
              <span class="font-bold text-[#8B1A1A] font-mono text-right break-words">
                {{ $leaderUser?->referral_code ?? '-' }}
              </span>
            </div>
          @else
            <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
              <span class="text-gray-500 shrink-0 min-w-[110px]">Kode Referral</span>
              <span class="text-gray-400 text-right break-words">Tidak menggunakan referral</span>
            </div>
          @endif
          <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
            <span class="text-gray-500 shrink-0 min-w-[110px]">Bergabung</span>
            <span class="font-semibold text-gray-900 text-right break-words">{{ $user->created_at ? $user->created_at->timezone('Asia/Jakarta')->format('d M Y') : '-' }}</span>
          </div>
        </div>
      </section>

      <!-- Tour Package Card -->
      <section class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md hover:-translate-y-1 animate-fade-in-up delay-2 flex flex-col" aria-label="Paket tour">
        @if($booking)
          @php
            $pkg     = $booking->package;
            $price   = $booking->packagePrice;
            $usdRate = $booking->usd_rate ?? 15800; // fallback kurs
            $priceUSD = $price ? round($price->price / $usdRate, 0) : 0;
          @endphp
          <div class="p-6 bg-gradient-to-br from-[#8B1A1A] via-red-700 to-orange-700 text-white relative overflow-hidden">
            <div class="absolute -top-[40%] -right-[8%] w-[140px] h-[140px] rounded-full bg-white/10"></div>
            <div class="absolute -bottom-[30%] left-[5%] w-[80px] h-[80px] rounded-full bg-white/5"></div>
            <h3 class="text-white text-[1.05rem] font-bold m-0 mb-1 relative z-10">{{ $pkg->name ?? 'Paket Umrah' }}</h3>
            <p class="text-white/80 text-sm m-0 relative z-10">Keberangkatan: {{ $pkg ? \Carbon\Carbon::parse($pkg->departure_date)->format('d M Y') : '-' }}</p>
            @if($percentage >= 100)
                <div class="inline-flex items-center gap-1 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-white mt-2 relative z-10">Lunas</div>
            @elseif($percentage > 0)
                <div class="inline-flex items-center gap-1 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-white mt-2 relative z-10">Cicilan Berjalan</div>
            @else
                <div class="inline-flex items-center gap-1 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-white mt-2 relative z-10">Belum Bayar</div>
            @endif
          </div>
          <div class="p-6 flex-1">
            {{-- Rincian Paket --}}
            <div class="mb-5">
              <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-xs">
                <span class="text-gray-500 shrink-0 min-w-[110px]">Jenis Paket</span>
                <span class="font-medium text-gray-900 text-right break-words">{{ $pkg->category->name ?? '-' }}</span>
              </div>
              <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-xs">
                <span class="text-gray-500 shrink-0 min-w-[110px]">Jenis Kamar</span>
                <span class="font-medium text-gray-900 text-right break-words">{{ $price->type ?? '-' }}</span>
              </div>
              <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-xs">
                <span class="text-gray-500 shrink-0 min-w-[110px]">Jumlah Orang</span>
                <span class="font-medium text-gray-900 text-right break-words">{{ $booking->jumlah_orang }} orang</span>
              </div>
              <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-xs">
                <span class="text-gray-500 shrink-0 min-w-[110px]">Harga/orang (IDR)</span>
                <span class="font-medium text-gray-900 text-right break-words">Rp {{ number_format($price->price ?? 0, 0, ',', '.') }}</span>
              </div>
              <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-xs">
                <span class="text-gray-500 shrink-0 min-w-[110px]">Harga/orang (USD)</span>
                <span class="font-medium text-gray-900 text-right break-words">$ {{ number_format($priceUSD, 0, ',', '.') }}</span>
              </div>
              <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-xs">
                <span class="text-gray-500 shrink-0 min-w-[110px]">Total Tagihan</span>
                <span class="font-bold text-[#8B1A1A] text-right break-words">Rp {{ number_format($totalCost, 0, ',', '.') }}</span>
              </div>
            </div>
            
            {{-- Progress --}}
            <div class="mb-5">
              <div class="flex justify-between text-sm text-gray-500 mb-1.5">
                  <span>Progress Pembayaran (Verified)</span>
                  <span class="font-bold text-[#8B1A1A]">{{ $percentage }}%</span>
              </div>
              <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden relative">
                  <div class="h-full bg-gradient-to-r from-[#8B1A1A] via-red-700 to-orange-700 rounded-full transition-all duration-1000 ease-out relative" style="width:{{ $percentage }}%;"></div>
              </div>
            </div>

            {{-- Amounts --}}
            <div class="grid grid-cols-2 gap-3 mt-4">
                <div class="bg-gray-50 rounded-xl p-4 text-center border border-transparent hover:border-gray-200 transition-colors">
                    <div class="text-[0.7rem] text-gray-500 uppercase tracking-widest mb-1.5 font-bold">Sudah Dibayar</div>
                    <div class="text-base font-bold text-emerald-600">Rp {{ number_format($paidAmount, 0, ',', '.') }}</div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 text-center border border-transparent hover:border-gray-200 transition-colors">
                    <div class="text-[0.7rem] text-gray-500 uppercase tracking-widest mb-1.5 font-bold">Sisa Tagihan</div>
                    <div class="text-base font-bold text-red-600">Rp {{ number_format($remaining, 0, ',', '.') }}</div>
                </div>
            </div>
          </div>
        @else
          <div class="p-6 bg-gradient-to-br from-[#8B1A1A] via-red-700 to-orange-700 text-white relative overflow-hidden">
            <div class="absolute -top-[40%] -right-[8%] w-[140px] h-[140px] rounded-full bg-white/10"></div>
            <div class="absolute -bottom-[30%] left-[5%] w-[80px] h-[80px] rounded-full bg-white/5"></div>
            <h3 class="text-white text-[1.05rem] font-bold m-0 mb-1 relative z-10">Belum Ada Booking</h3>
            <p class="text-white/80 text-sm m-0 relative z-10">Anda belum memiliki paket umroh aktif</p>
          </div>
          <div class="p-6 flex-1 flex items-center justify-center">
            <p class="text-gray-500 text-sm text-center">Silakan hubungi admin untuk mendaftarkan paket umrah Anda.</p>
          </div>
        @endif
        
        <div class="p-4 border-t border-gray-200 flex gap-3">
          <a href="{{ route('user.invoices') }}" class="flex-1 bg-white border border-[#8B1A1A] text-[#8B1A1A] font-semibold px-4 py-2 rounded-lg hover:bg-red-50 transition-all text-center text-sm">
            📋 Lihat Invoice
          </a>
          <a href="{{ route('user.payment') }}" class="flex-1 bg-[#8B1A1A] text-white font-semibold px-4 py-2 rounded-lg hover:bg-red-800 transition-all text-center text-sm">
            💳 Bayar Sekarang
          </a>
        </div>
      </section>

    </div>
  </div>
@endsection