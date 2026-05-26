@extends('layouts.app')

@section('content')
<section class="pt-[150px] pb-[60px] bg-[#fcfcfc] min-h-screen px-5">
    <div class="max-w-[600px] mx-auto bg-white p-10 rounded-xl shadow-md text-center">

        <div class="w-20 h-20 bg-[#25D366] text-white rounded-full flex items-center justify-center text-[40px] mx-auto mb-5">
            <ion-icon name="logo-whatsapp"></ion-icon>
        </div>

        <h2 class="text-mp-primary mb-2.5 font-bold text-xl">Data Berhasil Terkirim!</h2>
        <p class="text-gray-500 mb-8 leading-relaxed">
            Terima kasih, <strong>{{ $inquiry->name }}</strong>. Pesanan Anda untuk paket <strong>{{ $inquiry->package->name }}</strong> telah kami catat.<br>
            Klik tombol di bawah untuk memulai percakapan dengan konsultan kami.
        </p>

        <a href="{{ $waLink }}" target="_blank" class="inline-block bg-[#25D366] text-white py-4 px-9 rounded-full no-underline font-bold text-lg shadow-[0_4px_15px_rgba(37,211,102,0.3)] hover:bg-[#1fb855] transition-colors">
            CHAT ADMIN SEKARANG
        </a>

        <p class="mt-6 text-[13px] text-gray-400">
            Jika WhatsApp tidak terbuka otomatis, klik tombol di atas.
        </p>
    </div>
</section>
@endsection