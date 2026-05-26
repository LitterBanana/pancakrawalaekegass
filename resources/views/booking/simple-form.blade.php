@extends('layouts.app')

@section('content')
    <section class="pt-[300px] pb-[200px] min-h-screen" style="background: linear-gradient(to bottom, var(--color-maroon-primary) 0%, var(--color-maroon-primary) 160px, var(--color-cultured) 160px, var(--color-cultured) 100%);">
        <div class="max-w-[600px] mx-auto bg-white p-10 rounded-xl shadow-md">
            <div class="text-center mb-8">
                <p class="text-[#5a8bd4] font-bold tracking-wider mb-1">KONSULTASI &
                    PEMESANAN</p>
                <h2 class="text-mp-primary text-[28px] mb-4">{{ $package->name }}</h2>
                <p class="text-gray-500 text-[15px]">Silakan isi data diri Anda. Tim kami akan segera
                    menghubungi Anda via WhatsApp untuk detail paket dan ketersediaan kursi.</p>
            </div>

            <form action="{{ route('booking.storeSimple', $package->slug) }}" method="POST">
                @csrf

                <div class="hidden invisible absolute -left-[9999px]">
                    <label for="website_url">Kosongkan kolom ini jika Anda manusia</label>
                    <input type="text" id="website_url" name="website_url" value="" autocomplete="off">
                </div>

                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 mb-5 rounded-lg text-sm">
                        <strong class="block mb-1">Gagal mengirim data:</strong>
                        <ul class="m-0 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-5">
                    <label for="name"
                        class="block mb-2 text-mp-primary font-bold">Nama Lengkap
                        *</label>
                    <input type="text" id="name" name="name" required placeholder="Masukkan nama lengkap"
                        class="w-full py-3 px-4 border border-gray-300 rounded-lg text-base">
                </div>

                <div class="mb-5">
                    <label for="phone"
                        class="block mb-2 text-mp-primary font-bold">Nomor WhatsApp
                        *</label>
                    <input type="tel" id="phone" name="phone" required placeholder="Contoh: 081234567890"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="w-full py-3 px-4 border border-gray-300 rounded-lg text-base">
                </div>

                <div class="flex gap-4 mb-6">
                    <div class="flex-1">
                        <label for="room_type"
                            class="block mb-2 text-mp-primary font-bold">Tipe Kamar
                            *</label>
                        <select id="room_type" name="room_type" required
                            class="w-full py-3 px-4 border border-gray-300 rounded-lg text-base bg-white">
                            <option value="">-- Pilih Kamar --</option>
                            @foreach ($package->prices as $price)
                                <option value="{{ $price->type }} (IDR {{ number_format($price->price, 0, ',', '.') }})">
                                    {{ $price->type }} - IDR {{ number_format($price->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1">
                        <label for="pax"
                            class="block mb-2 text-mp-primary font-bold">Jml. Jamaah
                            *</label>
                        <input type="number" id="pax" name="pax" required min="1" value="1"
                            class="w-full py-3 px-4 border border-gray-300 rounded-lg text-base">
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-4 bg-maroon-primary text-white border-none rounded-lg text-base font-bold cursor-pointer transition-all duration-300 hover:bg-maroon-hover">
                    LANJUTKAN KE WHATSAPP
                </button>
        </div>
        <div class="mt-5">

            </form>
        </div>
    </section>
@endsection
