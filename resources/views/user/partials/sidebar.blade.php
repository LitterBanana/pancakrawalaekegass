<div class="h-16 flex items-center px-6 border-b border-gray-200">

    <div class="flex flex-col">
        <span class="text-lg font-bold text-gray-900 font-display leading-tight">HMI Tour</span>
        <span class="text-xs text-gray-500 font-medium">Payment System</span>
    </div>
</div>

<div class="flex-1 overflow-y-auto p-4 flex flex-col gap-1">
    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-2 px-3">Menu Utama</div>
    
    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->is('user/dashboard*') ? 'bg-red-50 text-maroon-primary font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
        <ion-icon name="grid-outline" class="text-xl"></ion-icon>
        <span>Dashboard</span>
    </a>

    @if(session()->has('impersonate_user_id'))
        <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-400 font-medium cursor-not-allowed opacity-60" onclick="alert('Fitur pembayaran dikunci selama Anda melakukan akses dari Dashboard Admin.')">
            <ion-icon name="lock-closed-outline" class="text-xl"></ion-icon>
            <span>Bayar Sekarang</span>
        </div>
    @else
        <a href="{{ route('user.payment') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->is('user/payment*') ? 'bg-red-50 text-maroon-primary font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
            <ion-icon name="card-outline" class="text-xl"></ion-icon>
            <span>Bayar Sekarang</span>
        </a>
    @endif

    <a href="{{ route('user.invoices') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->is('user/invoices*') ? 'bg-red-50 text-maroon-primary font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
        <ion-icon name="document-text-outline" class="text-xl"></ion-icon>
        <span>Travel Invoices</span>
    </a>

    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-6 px-3">Akun</div>

    <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->is('user/profile*') ? 'bg-red-50 text-maroon-primary font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
        <ion-icon name="person-outline" class="text-xl"></ion-icon>
        <span>Profil Saya</span>
    </a>
</div>

<div class="p-4 border-t border-gray-200">
    @if(session()->has('impersonate_user_id'))
        <a href="{{ route('admin.stop.impersonating') }}" class="flex items-center justify-center gap-2 w-full px-4 py-2 bg-amber-50 text-amber-700 rounded-xl hover:bg-amber-100 transition-colors font-bold text-sm border border-amber-200">
            <ion-icon name="return-up-back-outline" class="text-lg"></ion-icon>
            <span>Kembali ke Admin</span>
        </a>
    @else
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-red-600 hover:bg-red-50 rounded-xl transition-colors font-semibold text-sm">
                <ion-icon name="log-out-outline" class="text-lg"></ion-icon>
                <span>Logout</span>
            </button>
        </form>
    @endif
</div>
