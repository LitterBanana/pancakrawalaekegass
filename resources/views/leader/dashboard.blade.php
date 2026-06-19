@extends('layouts.leader')

@section('title', 'Dashboard Leader - HMI Tour')
@section('page-title', 'Dashboard Leader')
@section('page-description', 'Pantau performa tim dan aktivitas referral')



@section('content')
    <!-- Welcome Banner -->
    <section class="bg-gradient-to-br from-[#8B1A1A] to-[#6B1010] rounded-2xl p-8 mb-8 relative overflow-hidden animate-fade-in-up" aria-label="Banner selamat datang">
        <div class="absolute -top-1/2 -right-[10%] w-[300px] h-[300px] rounded-full bg-white/10"></div>
        <div class="absolute -bottom-[60%] right-[15%] w-[200px] h-[200px] rounded-full bg-white/5"></div>
        <div class="relative z-10">
            <h2 class="text-white text-2xl mb-2 font-bold border-none p-0">Halo, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
            <p class="text-white/90 text-base mb-6 max-w-2xl">Pantau performa tim dan aktivitas referral Anda di dashboard Leader.</p>
            <div class="flex items-center gap-3">
                @if(Auth::user()->referral_code)
                    <div
                        class="bg-white/20 backdrop-blur-sm px-4 py-2.5 rounded-lg border border-white/30 text-white font-mono text-sm inline-flex items-center gap-3">
                        <span id="ref-code">{{ Auth::user()->referral_code }}</span>
                        <button onclick="copyToClipboard('{{ Auth::user()->referral_code }}')"
                            class="bg-white/20 hover:bg-white/30 cursor-pointer rounded-md px-3 py-1.5 text-xs font-medium transition-colors"
                            title="Salin kode">
                            Salin Kode
                        </button>
                        <input type="hidden" id="referral-link" value="{{ url('/login?ref=' . Auth::user()->referral_code) }}">
                        <button onclick="copyReferralLink()"
                            class="bg-white/20 hover:bg-white/30 cursor-pointer rounded-md px-3 py-1.5 text-xs font-medium transition-colors"
                            title="Salin link">
                            Link
                        </button>
                    </div>
                @else
                    <form action="{{ route('leader.referral.regenerate') }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="bg-white text-[#8B1A1A] font-semibold px-6 py-3 rounded-lg inline-flex border-0 cursor-pointer hover:bg-orange-50 hover:-translate-y-px transition-all">
                            Generate Kode Referral
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <!-- Stats Grid -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fade-in-up delay-1" aria-label="Statistik Leader">
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-[#8B1A1A]">
            <div class="text-sm text-gray-500 mb-1 font-medium">Total Downline</div>
            <div class="text-3xl font-bold text-gray-900 font-sans">{{ $totalDownline }}</div>
        </div>
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-[#8B1A1A]">
            <div class="text-sm text-gray-500 mb-1 font-medium">Revenue Bulan Ini</div>
            <div class="text-2xl font-bold text-gray-900 font-sans">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-[#8B1A1A]">
            <div class="text-sm text-gray-500 mb-1 font-medium">Total Revenue</div>
            <div class="text-2xl font-bold text-gray-900 font-sans">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-[#8B1A1A]">
            <div class="text-sm text-gray-500 mb-1 font-medium">Status</div>
            <div class="text-2xl font-bold text-gray-900 font-sans text-green-600 text-lg flex items-center pt-1">
                <span
                    class="inline-flex rounded-full bg-green-100 text-green-800 px-3 py-1 font-semibold text-sm">Aktif</span>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section aria-label="Aksi cepat" class="animate-fade-in-up delay-2">
        <div class="mb-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-1">Aksi Cepat</h2>
                <p class="text-sm text-gray-500 mb-6">Akses fitur utama dengan cepat</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('leader.reports.index') }}" class="group bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex items-center justify-between cursor-pointer transition-all duration-300 hover:shadow-md hover:-translate-y-1 hover:border-[#8B1A1A] no-underline">
                <div class="text-left">
                    <div class="text-lg font-bold text-gray-900 mb-1">Laporan Penjualan</div>
                    <p class="text-sm text-gray-500 mb-0">Pantau performa penjualan tim</p>
                </div>
                <div class="text-gray-400 group-hover:text-[#8B1A1A] transition-colors text-xl font-bold">&rarr;</div>
            </a>
            <a href="{{ route('leader.members.index') }}" class="group bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex items-center justify-between cursor-pointer transition-all duration-300 hover:shadow-md hover:-translate-y-1 hover:border-[#8B1A1A] no-underline">
                <div class="text-left">
                    <div class="text-lg font-bold text-gray-900 mb-1">Manajemen Tim</div>
                    <p class="text-sm text-gray-500 mb-0">Kelola referensi downline Anda</p>
                </div>
                <div class="text-gray-400 group-hover:text-[#8B1A1A] transition-colors text-xl font-bold">&rarr;</div>
            </a>
            <a href="{{ route('leader.reports.crud') }}" class="group bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex items-center justify-between cursor-pointer transition-all duration-300 hover:shadow-md hover:-translate-y-1 hover:border-[#8B1A1A] no-underline">
                <div class="text-left">
                    <div class="text-lg font-bold text-gray-900 mb-1">Analitik</div>
                    <p class="text-sm text-gray-500 mb-0">Lihat data laporan lebih detail</p>
                </div>
                <div class="text-gray-400 group-hover:text-[#8B1A1A] transition-colors text-xl font-bold">&rarr;</div>
            </a>
        </div>
    </section>

    <!-- Dashboard Layout -->
    <div class="animate-fade-in-up delay-3">
        <!-- Downline Table -->
        <section class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm" aria-label="Daftar Downline">
            <div class="flex items-center justify-between pb-4 border-b border-gray-200 mb-4">
                <h3 class="mb-0 text-lg font-semibold text-gray-900">
                    Daftar Downline Anda</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left whitespace-nowrap">
                    <thead>
                        <tr>
                            <th
                                class="py-3 px-4 text-xs font-semibold uppercase text-fi-text-muted border-b border-fi-border">
                                Nama</th>
                            <th
                                class="py-3 px-4 text-xs font-semibold uppercase text-fi-text-muted border-b border-fi-border">
                                Email</th>
                            <th
                                class="py-3 px-4 text-xs font-semibold uppercase text-fi-text-muted border-b border-fi-border">
                                Bergabung</th>
                            <th
                                class="py-3 px-4 text-xs font-semibold uppercase text-fi-text-muted border-b border-fi-border">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($downlines as $downline)
                            <tr class="hover:bg-fi-bg transition-colors duration-150">
                                <td
                                    class="py-4 px-4 text-sm text-fi-text-main border-b border-fi-border align-middle font-medium">
                                    {{ $downline->name }}</td>
                                <td class="py-4 px-4 text-sm text-fi-text-muted border-b border-fi-border align-middle">
                                    {{ $downline->email }}</td>
                                <td class="py-4 px-4 text-sm text-fi-text-main border-b border-fi-border align-middle">
                                    {{ $downline->created_at->format('d M Y') }}</td>
                                <td class="py-4 px-4 text-sm border-b border-fi-border align-middle">
                                    <span
                                        class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $downline->role === 'user' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($downline->role) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-fi-text-muted bg-gray-50 rounded-lg">Belum ada
                                    downline.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const codeEl = document.getElementById('ref-code');
                const original = codeEl.textContent;
                codeEl.textContent = 'Tersalin!';
                codeEl.style.color = '#10b981';
                setTimeout(() => {
                    codeEl.textContent = original;
                    codeEl.style.color = '';
                }, 1500);
            }).catch(() => {
                // Fallback untuk browser lama
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
            });
        }

        function copyReferralLink() {
            const linkInput = document.getElementById('referral-link');
            const link = linkInput.value;

            navigator.clipboard.writeText(link).then(() => {
                showCopyFeedback(event.target);
            }).catch(() => {
                linkInput.select();
                document.execCommand('copy');
                showCopyFeedback(event.target);
            });
        }

        function showCopyFeedback(button) {
            const originalText = button.textContent;
            button.textContent = '✓';
            button.style.background = 'rgba(16,185,129,0.5)';
            setTimeout(() => {
                button.textContent = originalText;
                button.style.background = '';
            }, 1500);
        }
    </script>
@endpush