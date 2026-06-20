    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 w-[260px] h-screen bg-white border-r border-gray-200 z-50 flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0" id="sidebar">
        <div class="px-6 py-5 border-b border-gray-200 flex items-center gap-3">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/side-logo.png') }}" alt="Logo HMI Tour" class="max-w-[150px] h-auto">
            </a>
        </div>

        <nav class="flex-1 px-3 py-4 overflow-y-auto">
            <div class="text-[0.7rem] font-bold uppercase tracking-widest text-gray-500 px-3 py-2 mt-2">Menu Utama</div>

            <a href="{{ route('leader.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 mb-0.5 {{ request()->routeIs('leader.dashboard') ? 'bg-red-50 text-[#8B1A1A] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>

            <a href="{{ route('leader.members.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 mb-0.5 {{ request()->routeIs('leader.members.*') ? 'bg-red-50 text-[#8B1A1A] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Anggota Tim
            </a>

            <a href="{{ route('leader.reports.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 mb-0.5 {{ request()->routeIs('leader.reports.index') ? 'bg-red-50 text-[#8B1A1A] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Laporan Penjualan
            </a>

            <a href="{{ route('leader.reports.analytics') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 mb-0.5 {{ request()->routeIs('leader.reports.analytics') ? 'bg-red-50 text-[#8B1A1A] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                Analitik
            </a>

            <a href="{{ route('leader.invoices.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 mb-0.5 {{ request()->routeIs('leader.invoices.*') ? 'bg-red-50 text-[#8B1A1A] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                Invoice Downline
            </a>


            <div class="text-[0.7rem] font-bold uppercase tracking-widest text-gray-500 px-3 py-2 mt-2">Akun</div>

            <a href="{{ route('leader.profile') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 mb-0.5 {{ request()->routeIs('leader.profile') ? 'bg-red-50 text-[#8B1A1A] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Profil Saya
            </a>

        </nav>

        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center gap-3 p-2 rounded-lg">
                <div class="w-9 h-9 rounded-full bg-red-100 text-[#8B1A1A] flex items-center justify-center font-bold text-sm shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="text-sm font-semibold text-gray-900 whitespace-nowrap overflow-hidden text-ellipsis">{{ Auth::user()->name }}</div>
                    <div class="text-[0.7rem] text-gray-500">Leader</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="m-0 mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-150 border-none bg-transparent cursor-pointer font-inherit">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>
