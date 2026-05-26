@extends('layouts.app')

@section('content')
<section class="pt-[200px] pb-[60px] min-h-screen bg-cultured px-5">
    <div class="max-w-[600px] mx-auto">
        <a href="{{ url('/') }}" class="text-gray-500 no-underline mb-4 inline-block hover:text-gray-700 transition-colors">← Kembali ke Beranda</a>
        <h2 class="text-2xl font-bold text-mp-primary mb-5">Form Pemesanan Paket</h2>

        <div class="bg-gray-50 p-4 mb-5 border-l-[5px] border-[#ff7b00] rounded">
            <h3 class="font-bold text-lg mb-1">{{ $package->name }}</h3>
            <p><strong>Keberangkatan:</strong> {{ $package->departure_date }}</p>
            <p><strong>Hotel Makkah:</strong> {{ $package->hotelMakkah->name ?? '-' }}</p>
            <p><strong>Hotel Madinah:</strong> {{ $package->hotelMadinah->name ?? '-' }}</p>
        </div>

        <form action="{{ route('booking.store', $package->slug) }}" method="POST" class="bg-white p-8 rounded-xl shadow-sm">
            @csrf

            <div class="mb-4">
                <label class="block font-bold mb-1">Nama Lengkap (Sesuai Paspor/KTP)</label>
                <input type="text" name="customer_name" required class="w-full py-2.5 px-3 border border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">Nomor WhatsApp/Telepon</label>
                <input type="text" name="phone" required class="w-full py-2.5 px-3 border border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">Email (Opsional)</label>
                <input type="email" name="email" class="w-full py-2.5 px-3 border border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">Jumlah Jamaah</label>
                <input type="number" name="jumlah_orang" min="1" required placeholder="Contoh: 2" class="w-full py-2.5 px-3 border border-gray-300 rounded">
            </div>

            <div class="mb-6">
                <label class="block font-bold mb-1">Pilih Tipe Kamar / Harga</label>
                <select name="package_price_id" required class="w-full py-2.5 px-3 border border-gray-300 rounded bg-white">
                    <option value="">-- Pilih Tipe Kamar --</option>
                    @foreach($package->prices as $price)
                        <option value="{{ $price->id }}">
                            Kamar {{ $price->type }} - {{ $price->currency }} {{ number_format($price->price, 0, ',', '.') }} / orang
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full py-3 bg-[#ff7b00] text-white border-none text-base font-bold cursor-pointer rounded hover:bg-[#e66e00] transition-colors">Proses Pemesanan</button>
        </form>
    </div>
</section>
@endsection