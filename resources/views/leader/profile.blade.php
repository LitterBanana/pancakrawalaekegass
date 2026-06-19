@extends('layouts.leader')

@section('title', 'Profil Saya — HMI Leader')
@section('page-title', 'Profil Saya')
@section('page-description', 'Informasi akun dan data keanggotaan leader')



@section('content')
<div class="max-w-[960px] mx-auto">

    {{-- Profile Header --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6 animate-fade-in-up">
        <div class="h-[140px] bg-gradient-to-br from-[#8B1A1A] via-red-700 to-orange-700 relative overflow-hidden">
            <div class="absolute -top-[60%] -right-[8%] w-[260px] h-[260px] rounded-full bg-white/10"></div>
            <div class="absolute -bottom-[50%] left-[10%] w-[180px] h-[180px] rounded-full bg-white/5"></div>
        </div>
        <div class="px-6 md:px-8 pb-7 flex items-end gap-6 -mt-11 relative z-10 flex-wrap">
            <div class="flex-shrink-0 relative">
                <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-[#8B1A1A] to-red-700 text-white flex items-center justify-center text-3xl font-bold font-sans border-4 border-white shadow-[0_6px_20px_rgba(139,26,26,0.25)]">
                    {{ strtoupper(substr(explode(' ', trim($user->name))[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', trim($user->name))[1] ?? '', 0, 1)) }}
                </div>
                <div class="absolute bottom-1 right-1 w-4 h-4 rounded-full bg-emerald-500 border-[3px] border-white" title="Online"></div>
            </div>
            <div class="flex-1 min-w-0 pt-7">
                <h2 class="text-2xl font-bold text-gray-900 mt-2 pt-2 mb-1.5 leading-tight">{{ $user->name }}</h2>
                <div class="flex items-center gap-3 text-sm text-gray-500 flex-wrap">
                    <span class="flex items-center gap-1">{{ $user->email }}</span>
                    <span class="font-mono text-xs text-gray-500 bg-gray-50 px-2.5 py-1 rounded-md border border-gray-200">HMI-{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span>
                    <span class="bg-red-50 text-[#8B1A1A] border border-red-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Leader</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Leader Stats Ribbon --}}
    @php
        $downlineCount = $user->referrals()->count();
        $activeBookings = \App\Models\Booking::whereIn('user_id', $user->referrals()->pluck('id'))
            ->whereNotIn('status', ['cancel'])
            ->count();
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-3 gap-px bg-gray-200 rounded-xl overflow-hidden mb-6 shadow-sm animate-fade-in-up delay-1">
        <div class="bg-white p-5 text-center transition-colors hover:bg-gray-50">
            <div class="text-xl font-bold text-gray-900 leading-tight mb-1">{{ $downlineCount }}</div>
            <div class="text-[0.7rem] text-gray-500 uppercase tracking-widest">Total Downline</div>
        </div>
        <div class="bg-white p-5 text-center transition-colors hover:bg-gray-50">
            <div class="text-xl font-bold text-gray-900 leading-tight mb-1">{{ $activeBookings }}</div>
            <div class="text-[0.7rem] text-gray-500 uppercase tracking-widest">Booking Aktif</div>
        </div>
        <div class="bg-white p-5 text-center transition-colors hover:bg-gray-50">
            <div class="text-xl font-bold text-gray-900 leading-tight mb-1">{{ $user->created_at ? $user->created_at->timezone('Asia/Jakarta')->format('d M Y') : '-' }}</div>
            <div class="text-[0.7rem] text-gray-500 uppercase tracking-widest">Bergabung Sejak</div>
        </div>
    </div>

    {{-- Profile Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Info Akun --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md hover:-translate-y-1 animate-fade-in-up delay-2">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900 m-0">Informasi Akun</h3>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
                    <span class="text-gray-500 shrink-0 min-w-[110px]">Nama Lengkap</span>
                    <span class="font-semibold text-gray-900 text-right break-words">{{ $user->name }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
                    <span class="text-gray-500 shrink-0 min-w-[110px]">Email</span>
                    <span class="font-semibold text-gray-900 text-right break-words">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
                    <span class="text-gray-500 shrink-0 min-w-[110px]">Role</span>
                    <span class="font-semibold text-gray-900 text-right break-words">
                        <span class="bg-emerald-50 text-emerald-800 px-3 py-1 rounded-full text-xs font-semibold">Leader</span>
                    </span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
                    <span class="text-gray-500 shrink-0 min-w-[110px]">Bergabung</span>
                    <span class="font-semibold text-gray-900 text-right break-words">{{ $user->created_at ? $user->created_at->timezone('Asia/Jakarta')->format('d M Y') : '-' }}</span>
                </div>
                @if($user->referred_by)
                <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
                    <span class="text-gray-500 shrink-0 min-w-[110px]">Direkrut Oleh</span>
                    <span class="text-[#8B1A1A] font-bold text-right break-words">
                        {{ optional(\App\Models\User::find($user->referred_by))->name ?? '-' }}
                    </span>
                </div>
                @endif

                {{-- Referral Section --}}
                <div class="mt-5 bg-gradient-to-br from-red-50 to-orange-50 border border-red-200 rounded-xl p-5">
                    <div class="text-[0.7rem] font-bold uppercase tracking-widest text-gray-500 mb-3">Kode Referral Saya</div>
                    @if($user->referral_code)
                        <div class="flex items-center gap-3 flex-wrap">
                            <div class="bg-white border border-red-200 rounded-lg px-4 py-2.5 flex items-center gap-3 flex-1 min-w-0">
                                <span class="text-lg font-bold text-[#8B1A1A] font-mono tracking-widest flex-1" id="ref-code">{{ $user->referral_code }}</span>
                                <button type="button" class="bg-transparent border border-red-200 rounded-md px-2.5 py-1.5 cursor-pointer text-xs font-semibold text-[#8B1A1A] hover:bg-red-50 hover:border-[#8B1A1A] transition-all flex items-center shrink-0" onclick="copyCode()" title="Salin kode referral">
                                    Salin
                                </button>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <input type="text" class="flex-1 bg-white border border-gray-200 rounded-md px-3 py-2 text-xs text-gray-500 font-mono overflow-hidden text-ellipsis whitespace-nowrap focus:outline-none" id="referral-link"
                                   value="{{ url('/login?ref=' . $user->referral_code) }}" readonly>
                            <button type="button" class="bg-transparent border border-red-200 rounded-md px-2.5 py-1.5 cursor-pointer text-xs font-semibold text-[#8B1A1A] hover:bg-red-50 hover:border-[#8B1A1A] transition-all shrink-0" onclick="copyLink()" title="Salin link referral">
                                Link
                            </button>
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <form action="{{ route('leader.referral.regenerate') }}" method="POST" class="shrink-0">
                                @csrf
                                <button type="submit" class="bg-white border border-gray-200 text-gray-700 px-3 py-1.5 rounded-md text-xs font-semibold hover:bg-gray-50 transition-colors cursor-pointer">
                                    Generate Ulang
                                </button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('leader.referral.regenerate') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-[#8B1A1A] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-800 transition-colors cursor-pointer">
                                Generate Kode Referral
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Info Paket / Booking Pribadi --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md hover:-translate-y-1 animate-fade-in-up delay-3">
            @if($booking)
                @php
                    $pkg   = $booking->package;
                    $price = $booking->packagePrice;
                @endphp
                <div class="p-6 bg-gradient-to-br from-[#8B1A1A] via-red-700 to-orange-700 text-white relative overflow-hidden">
                    <div class="absolute -top-[40%] -right-[8%] w-[140px] h-[140px] rounded-full bg-white/10"></div>
                    <div class="absolute -bottom-[30%] left-[5%] w-[80px] h-[80px] rounded-full bg-white/5"></div>
                    <h3 class="text-white text-[1.05rem] font-bold m-0 mb-1 relative z-10">{{ $pkg->name ?? 'Paket Umroh' }}</h3>
                    <p class="text-white/80 text-sm m-0 relative z-10">Keberangkatan: {{ $pkg ? \Carbon\Carbon::parse($pkg->departure_date)->format('d M Y') : '-' }}</p>
                    @if($percentage >= 100)
                        <div class="inline-flex items-center gap-1 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-white mt-2 relative z-10">Lunas</div>
                    @elseif($percentage > 0)
                        <div class="inline-flex items-center gap-1 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-white mt-2 relative z-10">Cicilan Berjalan</div>
                    @else
                        <div class="inline-flex items-center gap-1 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-white mt-2 relative z-10">Belum Bayar</div>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
                        <span class="text-gray-500 shrink-0 min-w-[110px]">Jenis Paket</span>
                        <span class="font-semibold text-gray-900 text-right break-words">{{ $pkg->category->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
                        <span class="text-gray-500 shrink-0 min-w-[110px]">Jenis Kamar</span>
                        <span class="font-semibold text-gray-900 text-right break-words">{{ $price->type ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
                        <span class="text-gray-500 shrink-0 min-w-[110px]">Jumlah Orang</span>
                        <span class="font-semibold text-gray-900 text-right break-words">{{ $booking->jumlah_orang }} orang</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100 text-sm">
                        <span class="text-gray-500 shrink-0 min-w-[110px]">Total Tagihan</span>
                        <span class="text-[#8B1A1A] font-bold text-right break-words">
                            Rp {{ number_format($totalCost, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Progress --}}
                    <div class="mt-5">
                        <div class="flex justify-between text-sm text-gray-500 mb-1.5">
                            <span>Progress Pembayaran</span>
                            <span class="font-bold text-[#8B1A1A]">{{ $percentage }}%</span>
                        </div>
                        <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden relative">
                            <div class="h-full bg-gradient-to-r from-[#8B1A1A] via-red-700 to-orange-700 rounded-full transition-all duration-1000 ease-out relative" style="width:{{ $percentage }}%;">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <div class="bg-gray-50 rounded-lg p-4 text-center border border-transparent hover:border-gray-200 transition-colors">
                            <div class="text-[0.7rem] text-gray-500 uppercase tracking-widest mb-1.5">Sudah Dibayar</div>
                            <div class="text-base font-bold text-emerald-800">Rp {{ number_format($paidAmount, 0, ',', '.') }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center border border-transparent hover:border-gray-200 transition-colors">
                            <div class="text-[0.7rem] text-gray-500 uppercase tracking-widest mb-1.5">Sisa Tagihan</div>
                            <div class="text-base font-bold text-red-800">Rp {{ number_format($remaining, 0, ',', '.') }}</div>
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
                <div class="p-6">
                    <div class="text-center py-10 px-6">
                        <p class="text-gray-500 text-sm leading-relaxed">
                            Belum ada booking paket umroh atas nama Anda.<br>
                            Hubungi admin untuk mendaftar.
                        </p>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>

{{-- Copy Toast --}}
<div class="fixed bottom-8 left-1/2 -translate-x-1/2 translate-y-32 opacity-0 bg-emerald-800 text-white px-6 py-3 rounded-lg text-sm font-semibold shadow-xl z-[9999] transition-all duration-300 ease-out pointer-events-none" id="copyToast">Berhasil disalin!</div>

@endsection

@push('scripts')
<script>
    function showToast(message) {
        const toast = document.getElementById('copyToast');
        toast.textContent = message;
        toast.classList.remove('translate-y-32', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-32', 'opacity-0');
        }, 2000);
    }

    function copyCode() {
        const code = document.getElementById('ref-code').textContent.trim();
        navigator.clipboard.writeText(code).then(() => {
            showToast('Kode referral disalin!');
        }).catch(() => {
            // Fallback untuk browser lama
            fallbackCopy(code);
            showToast('Kode referral disalin!');
        });
    }

    function copyLink() {
        const link = document.getElementById('referral-link').value;
        navigator.clipboard.writeText(link).then(() => {
            showToast('Link referral disalin!');
        }).catch(() => {
            fallbackCopy(link);
            showToast('Link referral disalin!');
        });
    }

    function fallbackCopy(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
    }
</script>
@endpush
