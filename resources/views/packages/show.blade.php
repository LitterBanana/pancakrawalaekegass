@extends('layouts.app')

@section('content')
    <section class="pt-[200px] max-lg:pt-[100px] pb-[100px] max-lg:pb-10 bg-cultured w-full overflow-x-hidden" style="background: linear-gradient(to bottom, var(--color-maroon-primary) 0%, var(--color-maroon-primary) 160px, var(--color-cultured) 160px, var(--color-cultured) 100%);">

        <div class="w-full max-w-[1200px] mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-[1.8fr_1fr] gap-5 lg:gap-10 items-start w-full">
                <div class="min-w-0 w-full">

                    <a href="javascript:history.back()"
                        class="inline-flex items-center gap-2 text-spanish-gray no-underline font-semibold mb-5 text-sm transition-colors duration-300 hover:text-maroon-primary">
                        <ion-icon name="arrow-back-outline"></ion-icon> Kembali
                    </a>

                    <h1 class="text-maroon-deep font-montserrat text-[clamp(22px,4vw,36px)] font-extrabold mb-4 leading-tight uppercase break-words">{{ $package->name }}</h1>

                    <div class="flex gap-2.5 flex-wrap mb-8">
                        <span class="flex items-center gap-1.5 bg-white py-2 px-3.5 rounded-full text-[13px] font-semibold text-maroon-primary border border-gainsboro whitespace-nowrap"><ion-icon name="time-outline"></ion-icon> {{ $package->duration }}
                            Hari</span>
                        <span class="flex items-center gap-1.5 bg-white py-2 px-3.5 rounded-full text-[13px] font-semibold text-maroon-primary border border-gainsboro whitespace-nowrap"><ion-icon name="airplane-outline"></ion-icon>
                            {{ $package->airline ?? 'Penerbangan Reguler' }}</span>
                        <span class="flex items-center gap-1.5 bg-white py-2 px-3.5 rounded-full text-[13px] font-semibold text-maroon-primary border border-gainsboro whitespace-nowrap">
    <ion-icon name="business-outline"></ion-icon> Hotel:
    {{ optional($package->hotelMakkah)->name ?? 'TBA' }}
    &
    {{ optional($package->hotelMadinah)->name ?? 'TBA' }}
</span>

                    <div class="rounded-[15px] overflow-hidden mb-8 shadow-md w-full">
                        <img src="{{ asset('assets/images/' . ($package->thumbnail ?? 'default-umroh.jpg')) }}"
                            alt="{{ $package->name }}" class="w-full h-[450px] max-lg:h-[220px] object-cover block">
                    </div>

                    <div class="scrollbar-hide flex overflow-x-auto border-b-2 border-gainsboro mb-8 gap-2.5 pb-1 w-full">
                        <button class="tab-btn-item bg-transparent border-none font-poppins text-sm font-semibold text-spanish-gray py-2.5 px-4 cursor-pointer whitespace-nowrap border-b-[3px] border-transparent transition-all duration-300 active text-maroon-primary !border-b-maroon-primary" onclick="openTab(event, 'deskripsi')">Deskripsi Program</button>
                        <button class="tab-btn-item bg-transparent border-none font-poppins text-sm font-semibold text-spanish-gray py-2.5 px-4 cursor-pointer whitespace-nowrap border-b-[3px] border-transparent transition-all duration-300" onclick="openTab(event, 'fasilitas')">Cakupan Biaya</button>
                        <button class="tab-btn-item bg-transparent border-none font-poppins text-sm font-semibold text-spanish-gray py-2.5 px-4 cursor-pointer whitespace-nowrap border-b-[3px] border-transparent transition-all duration-300" onclick="openTab(event, 'itinerary')">Itinerary</button>
                        <button class="tab-btn-item bg-transparent border-none font-poppins text-sm font-semibold text-spanish-gray py-2.5 px-4 cursor-pointer whitespace-nowrap border-b-[3px] border-transparent transition-all duration-300" onclick="openTab(event, 'syarat')">Syarat & Ketentuan</button>
                    </div>

                    <div id="deskripsi" class="tab-pane-item active bg-white p-8 max-lg:p-5 rounded-[15px] border border-gainsboro leading-[1.8] text-black-coral w-full break-words">
                        <h3 class="text-gunmetal font-bold font-montserrat uppercase text-[calc(16px+0.45vw)] mb-4">Deskripsi</h3>
                        <div class="whitespace-pre-line leading-[1.8] text-sm">{{ $package->description }}</div>
                    </div>

                    <div id="fasilitas" class="tab-pane-item bg-white p-8 max-lg:p-5 rounded-[15px] border border-gainsboro leading-[1.8] text-black-coral w-full break-words">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 w-full">
                            <div class="p-5 rounded-xl w-full break-words bg-[#f2f9f2] border border-[#d1e8d1]">
                                <h4 class="text-green-700 font-extrabold text-base mb-2.5">Termasuk</h4>
                                <div class="whitespace-pre-line leading-[1.8] text-sm">{{ $package->include_facility ?? 'Data belum diinput.' }}</div>
                            </div>
                            <div class="p-5 rounded-xl w-full break-words bg-[#fdf2f2] border border-[#f8d7d7]">
                                <h4 class="text-red-700 font-extrabold text-base mb-2.5">Tidak Termasuk</h4>
                                <div class="whitespace-pre-line leading-[1.8] text-sm">{{ $package->exclude_facility ?? 'Data belum diinput.' }}</div>
                            </div>
                        </div>
                    </div>

                    <div id="itinerary" class="tab-pane-item bg-white p-8 max-lg:p-5 rounded-[15px] border border-gainsboro leading-[1.8] text-black-coral w-full break-words">
                        <h3 class="text-gunmetal font-bold font-montserrat uppercase text-[calc(16px+0.45vw)] mb-4">Jadwal Perjalanan</h3>
                        <div class="whitespace-pre-line leading-[1.8] text-sm">{{ $package->itinerary ?? 'Jadwal belum tersedia.' }}</div>
                    </div>

                    <div id="syarat" class="tab-pane-item bg-white p-8 max-lg:p-5 rounded-[15px] border border-gainsboro leading-[1.8] text-black-coral w-full break-words">
                        <h3 class="text-gunmetal font-bold font-montserrat uppercase text-[calc(16px+0.45vw)] mb-4">Syarat & Ketentuan</h3>
                        <div class="whitespace-pre-line leading-[1.8] text-sm">
                            {{ $package->terms_conditions ?? 'Syarat dan ketentuan belum tersedia.' }}</div>
                    </div>
                </div>

                <div class="min-w-0 w-full">
                    <div class="bg-white rounded-[15px] p-8 max-lg:p-5 border-t-[6px] max-lg:border-t-0 max-lg:border-b-[6px] border-maroon-primary shadow-lg lg:sticky lg:top-[120px] w-full max-lg:mt-2.5">
                        <p class="text-spanish-gray text-[13px] uppercase font-bold mb-0">
                            Mulai Dari</p>
                        <h2 class="text-[clamp(24px,3vw,32px)] font-extrabold text-maroon-primary font-montserrat mt-1 mb-5 break-words">IDR
                            {{ number_format(optional($package->prices->first())->price ?? 0, 0, ',', '.') }}</h2>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gainsboro mb-6 w-full">
                            <p class="text-[11px] text-spanish-gray font-bold mb-2 uppercase">
                                Pilihan Kamar:</p>
                            <ul class="list-none p-0 m-0">
                                @foreach ($package->prices as $price)
                                    <li class="flex justify-between mb-2 border-b border-dashed border-gray-300 pb-1 text-[13px]">
                                        <span class="text-black-coral">{{ $price->type }}</span>
                                        <strong class="text-maroon-deep">IDR
                                            {{ number_format($price->price, 0, ',', '.') }}</strong>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <ul class="list-none p-0 mb-6 border-t border-gainsboro pt-4">
                            <li class="flex max-lg:flex-col justify-between max-lg:items-start mb-3 max-lg:border-b max-lg:border-gray-100 max-lg:pb-2 text-sm text-black-coral gap-2.5"><span>Sisa Kuota:</span> <strong
                                    class="text-green-700 bg-green-50 py-0.5 px-2 rounded max-lg:text-left">{{ $package->quota }}
                                    Seat</strong></li>
                            <li class="flex max-lg:flex-col justify-between max-lg:items-start mb-3 max-lg:border-b max-lg:border-gray-100 max-lg:pb-2 text-sm text-black-coral gap-2.5"><span>Berangkat:</span>
                                <strong class="max-lg:text-left">{{ \Carbon\Carbon::parse($package->departure_date)->translatedFormat('d F Y') }}</strong>
                            </li>
                            <li class="flex max-lg:flex-col justify-between max-lg:items-start mb-3 text-sm text-black-coral gap-2.5"><span>Lokasi:</span> <strong class="max-lg:text-left">{{ $package->departure_location ?? 'Jakarta (CGK)' }}</strong>
                            </li>
                        </ul>

                        <a href="{{ route('booking.simple', $package->slug) }}" class="w-full text-center py-3.5 font-bold rounded-lg text-[15px] mb-3 block no-underline bg-maroon-primary border-2 border-maroon-primary text-white transition-all duration-300 hover:bg-maroon-hover">
                            Booking Sekarang
                        </a>

                        <a href="https://wa.me/+6285695170953?text=Halo%20Admin,%20saya%20tertarik%20dengan%20paket%20{{ $package->name }}"
                            target="_blank" class="w-full text-center py-3.5 font-bold rounded-lg text-[15px] mb-3 no-underline bg-[#25d366] text-white flex justify-center items-center gap-2 border-none">
                            <ion-icon name="logo-whatsapp" class="text-xl"></ion-icon> Konsultasi WhatsApp
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        function openTab(evt, tabId) {
            const tabPanes = document.querySelectorAll('.tab-pane-item');
            tabPanes.forEach(pane => pane.classList.remove('active'));

            const tabBtns = document.querySelectorAll('.tab-btn-item');
            tabBtns.forEach(btn => {
                btn.classList.remove('active', 'text-maroon-primary', '!border-b-maroon-primary');
                btn.classList.add('text-spanish-gray');
            });

            document.getElementById(tabId).classList.add('active');
            evt.currentTarget.classList.add('active', 'text-maroon-primary', '!border-b-maroon-primary');
            evt.currentTarget.classList.remove('text-spanish-gray');
        }
    </script>
@endsection