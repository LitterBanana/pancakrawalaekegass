@extends('layouts.app')
@section('title, Travel Umroh Haji Terpercaya')
@section('content')

    <!-- Hero Section -->
    <section class="hero-bg grid place-items-center min-h-screen text-center py-[120px] px-5" id="home">
        <div class="max-w-[580px] sm:max-w-[580px] md:max-w-[800px] lg:max-w-[1050px] xl:max-w-[1180px] mx-auto px-4">
            <h2 class="text-white font-extrabold font-montserrat uppercase text-[calc(20px+3.5vw)] leading-tight mb-6">
                Travel Umrah <br> Terpercaya & Resmi</h2>

            <p class="text-white text-sm sm:text-[15px] mb-10 text-center">
                Wujudkan impian ke Tanah Suci bersama travel umrah hijrah madani istiqomah dengan paket umrah hemat
                harga terbaru. Fasilitas lengkap, penerbangan nyaman, hotel pilihan, serta pendampingan ibadah profesional
                kami
                hadirkan untuk memastikan perjalanan anda nyaman, dan penuh keberkahan.
            </p>

            <div class="flex flex-wrap justify-center items-center gap-2.5 sm:gap-5">

            </div>
        </div>
    </section>

    <!-- Tour Search Section -->
    <section class="batik-overlay bg-maroon-primary py-[60px] xl:py-[100px] overflow-hidden relative">
        <div class="container-inner max-w-[580px] sm:max-w-[580px] md:max-w-[800px] lg:max-w-[1050px] xl:max-w-[1180px] mx-auto px-4 relative z-10">
            <form action="{{ route('packages.index') }}" method="GET" class="sm:grid sm:grid-cols-2 lg:grid-cols-5 sm:items-end sm:gap-4">

                <div class="mb-4 sm:mb-0">
                    <label for="search" class="text-white text-[15px] ml-5 mb-2.5 block">Pilih Paket</label>
                    <select name="search" id="search" class="bg-white py-2.5 sm:py-4 px-4 sm:px-5 text-sm rounded-full w-full appearance-none cursor-pointer block">
                        <option value="">-- Semua Paket --</option>
                        @foreach ($searchPackages as $sp)
                            <option value="{{ $sp->name }}">{{ $sp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4 sm:mb-0">
                    <label for="pax" class="text-white text-[15px] ml-5 mb-2.5 block">Jumlah Jamaah</label>
                    <input type="number" name="pax" id="pax" min="1" placeholder="Contoh: 2"
                        class="bg-white py-2.5 sm:py-4 px-4 sm:px-5 text-sm rounded-full w-full placeholder:text-spanish-gray">
                </div>

                <div class="mb-4 sm:mb-0">
                    <label for="departure_date" class="text-white text-[15px] ml-5 mb-2.5 block">Mulai Keberangkatan</label>
                    <input type="date" name="departure_date" id="departure_date" class="bg-white py-2.5 sm:py-4 px-4 sm:px-5 text-sm rounded-full w-full text-spanish-gray uppercase">
                </div>

                <div class="mb-4 sm:mb-0">
                    <label for="return_date" class="text-white text-[15px] ml-5 mb-2.5 block">Maksimal Kepulangan</label>
                    <input type="date" name="return_date" id="return_date" class="bg-white py-2.5 sm:py-4 px-4 sm:px-5 text-sm rounded-full w-full text-spanish-gray uppercase">
                </div>

                <button type="submit" class="text-white uppercase text-sm sm:text-base border border-white rounded-full py-2 sm:py-4 px-5 font-semibold mt-9 sm:mt-5 lg:mt-0 w-full sm:col-span-2 lg:col-span-1 transition-all duration-300 ease-in-out hover:bg-white/10">Cari Paket</button>
            </form>
        </div>
    </section>

    <!-- Popular Destination Section -->
    <section class="py-[60px] xl:py-[100px]" id="destination">
        <div class="max-w-[580px] sm:max-w-[580px] md:max-w-[800px] lg:max-w-[1050px] xl:max-w-[1180px] mx-auto px-4">
            <p class="text-maroon-primary text-sm uppercase font-montserrat mb-2 text-center">Ziarah & Wisata Religi</p>
            <h2 class="text-gunmetal font-extrabold font-montserrat uppercase text-[calc(18px+1.6vw)] mb-4 text-center">Program City Tour</h2>
            <p class="text-black-coral mb-8 sm:mb-10 text-justify sm:text-center max-w-[60ch] sm:mx-auto">
               Kunjungan ke tempat-tempat bersejarah di Makkah dan Madinah seperti Jabal Uhud, Masjid Quba, Jabal Rahmah, dan lainnya untuk menambah wawasan serta memperdalam makna perjalanan ibadah Anda.
            </p>
            <ul class="md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-8 mb-0 md:mb-12">
                @forelse($destinations as $dest)
                    <li class="mb-8 md:mb-0">
                        <div class="popular-card-wrap relative overflow-hidden rounded-[25px] h-[430px] transition-transform duration-300">
                            <figure class="h-full">
                                <img src="{{ asset('assets/images/' . $dest->image) }}" alt="{{ $dest->name }}"
                                    loading="lazy" class="w-full h-full object-cover">
                            </figure>
                            <div class="absolute bottom-5 left-5 right-5 sm:right-auto md:right-5 bg-white rounded-[25px] p-5">
                                <div class="bg-maroon-primary text-white absolute top-0 right-6 flex items-center gap-px -translate-y-1/2 py-1.5 px-2.5 rounded-[20px] text-sm">
                                    @for ($i = 0; $i < $dest->rating; $i++)
                                        <ion-icon name="star"></ion-icon>
                                    @endfor
                                </div>

                                <p class="text-maroon-secondary text-[13px] uppercase mb-2">
                                    <a href="#">{{ $dest->location }}</a>
                                </p>

                                <h3 class="text-gunmetal font-bold font-montserrat uppercase text-[calc(16px+0.45vw)] mb-1">
                                    <a href="#" class="text-inherit">{{ $dest->name }}</a>
                                </h3>

                                <p class="text-black-coral text-sm text-justify">
                                    {{ $dest->description ?? 'Jelajahi keindahan dan nilai historis kota ini.' }}
                                </p>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="w-full text-center text-gray-500 col-span-full">
                        Belum ada destinasi populer yang ditambahkan.
                    </li>
                @endforelse
            </ul>
        </div>
    </section>
    <!-- paket Section -->
    <section class="py-[60px] xl:py-[100px]" id="package">
        <div class="max-w-[580px] sm:max-w-[580px] md:max-w-[800px] lg:max-w-[1050px] xl:max-w-[1180px] mx-auto px-4">
            <p class="text-maroon-primary text-sm uppercase font-montserrat mb-2 text-center">Paket Ekslusif & Terpercaya</p>
            <h2 class="text-gunmetal font-extrabold font-montserrat uppercase text-[calc(18px+1.6vw)] mb-4 text-center">Program Unggulan</h2>
            <p class="text-black-coral mb-8 sm:mb-10 text-justify sm:text-center max-w-[60ch] sm:mx-auto">
               Beragam pilihan paket umroh dengan fasilitas, hotel nyaman, penerbangan aman, serta pendamping ibadah berpengalaman untuk memastikan perjalanan Anda lebih khusyuk dan nyaman.
            </p>
            <ul class="mb-10 md:mb-12">
                @foreach ($packages as $package)
                    <li class="mb-8 md:mb-10 last:mb-0">
                        <div class="bg-cultured overflow-hidden rounded-[15px] md:grid md:grid-cols-[1.3fr_1.5fr_1fr]">
                            <figure class="h-[250px] md:h-full">
                                <img src="{{ asset('assets/images/' . ($package->thumbnail ?? 'default-umroh.jpg')) }}"
                                    alt="{{ $package->name }}" class="w-full h-full object-cover">
                            </figure>
                            <div class="py-8 px-5 md:p-10">
                                <h3 class="text-gunmetal font-bold font-montserrat uppercase text-[calc(16px+0.45vw)] mb-4">{{ $package->name }}</h3>
                                <p class="text-black-coral text-sm text-justify leading-relaxed mb-5">
                                    {{ $package->description }}
                                </p>
                                <ul class="bg-white max-w-max flex flex-wrap justify-center items-center p-2 shadow-sm rounded-full">
                                    <li class="relative">
                                        <div class="flex justify-center items-center gap-1 px-2 text-black-coral text-[11px] lg:text-[13px]">
                                            <ion-icon name="time" class="text-maroon-primary text-[13px] lg:text-[15px]"></ion-icon>
                                            <p class="text">{{ $package->duration }} Days | Kuota:
                                                {{ $package->quota ?? 'Tersedia' }} Pax</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="bg-maroon-accent text-white p-6 text-center md:grid md:place-content-center">
                                <p class="text-[calc(18px+1.6vw)] font-montserrat font-extrabold mb-5">
                                    IDR {{ number_format($package->prices->first()->price ?? 0, 0, ',', '.') }}
                                </p>

                                <a href="{{ route('package.show', $package->slug) }}" class="text-white uppercase text-sm border-2 border-white rounded-full py-2 px-5 transition-all duration-300 ease-in-out hover:bg-white/10 inline-block">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="flex justify-center mt-12 mb-12">
                <a href="{{ route('packages.index') }}" class="bg-maroon-primary border-2 border-maroon-primary text-white uppercase text-sm sm:text-base rounded-full py-4 px-10 transition-all duration-300 ease-in-out hover:bg-maroon-hover hover:border-maroon-hover w-max">
                    LIHAT SEMUA PAKET
                </a>
            </div>
        </div>
    </section>
    <!-- galeri Section -->
    <section class="py-[60px] xl:py-[100px]" id="gallery">
        <div class="max-w-[580px] sm:max-w-[580px] md:max-w-[800px] lg:max-w-[1050px] xl:max-w-[1180px] mx-auto px-4">
            <p class="text-maroon-primary text-sm uppercase font-montserrat mb-2 text-center">Momen Berharga di Tanah Suci</p>
            <h2 class="text-gunmetal font-extrabold font-montserrat uppercase text-[calc(18px+1.6vw)] mb-4 text-center">Dokumentasi Jamaah</h2>
            <p class="text-black-coral mb-8 sm:mb-10 text-justify sm:text-center max-w-[60ch] sm:mx-auto">
                Kumpulan foto perjalanan jamaah selama menjalankan ibadah umroh. Setiap momen menjadi kenangan indah dan pengalaman spiritual yang tak terlupakan bersama Travel Umroh HMI.
            </p>
            <ul class="grid grid-cols-2 md:grid-cols-3 gap-2.5 md:gap-5">
                @forelse($galleries as $gallery)
                    <li class="[&:nth-child(3)]:row-span-2 [&:nth-child(3)]:col-start-2 [&:nth-child(3)]:row-start-1">
                        <figure class="w-full h-full rounded-[15px] md:rounded-[25px] overflow-hidden">
                            <img src="{{ asset('assets/images/' . $gallery->image) }}"
                                alt="{{ $gallery->caption ?? 'Gallery image' }}" class="w-full h-full object-cover">
                        </figure>
                    </li>
                @empty
                    <li class="col-span-full text-center text-gray-500 p-5">
                        Belum ada foto galeri yang diunggah.
                    </li>
                @endforelse
            </ul>
        </div>
    </section>
    <section class="bg-white py-[60px] xl:py-[100px]" id="faq">
        <div class="max-w-[580px] sm:max-w-[580px] md:max-w-[800px] lg:max-w-[1050px] xl:max-w-[1180px] mx-auto px-4">
            <p class="text-maroon-primary text-sm uppercase font-montserrat mb-2 text-center">Informasi Penting</p>
            <h2 class="text-gunmetal font-extrabold font-montserrat uppercase text-[calc(18px+1.6vw)] mb-4 text-center">Pertanyaan & Ketentuan</h2>
            <p class="text-black-coral mb-8 sm:mb-10 text-justify sm:text-center max-w-[60ch] sm:mx-auto">
                Berikut adalah ketentuan resmi terkait pendaftaran, pembatalan, dan kebijakan perjalanan bersama Hijrah Madani Istiqomah Tour.
            </p>

            <div class="flex flex-col gap-4 max-w-[800px] mx-auto">
                <div class="bg-white border border-mp-border rounded-xl overflow-hidden shadow-sm transition-all duration-300 ease-in-out hover:border-maroon-primary hover:shadow-md">
                    <input type="checkbox" id="faq1" class="faq-toggle">
                    <label for="faq1" class="faq-question-label flex justify-between items-center py-4 sm:py-[18px] px-4 sm:px-6 cursor-pointer bg-white font-semibold text-mp-primary font-montserrat text-sm transition-all duration-300 ease-in-out">
                        <span>Bagaimana ketentuan pembatalan paket Umrah?</span>
                        <ion-icon name="chevron-down-outline" class="faq-icon-el text-[20px] text-maroon-primary transition-transform duration-300"></ion-icon>
                    </label>
                    <div class="faq-answer-wrap bg-[#fafafa]">
                        <div class="p-5 sm:px-6 text-mp-text text-sm leading-relaxed border-t border-mp-border">
                            <p>Sesuai surat pernyataan, ketentuan pembatalan adalah sebagai berikut:</p>
                            <ul class="list-disc pl-5 mt-2.5">
                                <li class="mb-1"><strong>45 hari sebelum berangkat:</strong> Potongan sesuai biaya yang telah dikeluarkan (tiket/akomodasi).</li>
                                <li class="mb-1"><strong>< 30 hari sebelum berangkat:</strong> Dikenakan potongan sebesar 50%.</li>
                                <li class="mb-1"><strong>14 hari sebelum berangkat:</strong> Dikenakan potongan sebesar 85% dari harga paket.</li>
                                <li class="mb-1"><strong>7 hari sebelum berangkat:</strong> Dikenakan potongan sebesar 100% (Hangus).</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-mp-border rounded-xl overflow-hidden shadow-sm transition-all duration-300 ease-in-out hover:border-maroon-primary hover:shadow-md">
                    <input type="checkbox" id="faq2" class="faq-toggle">
                    <label for="faq2" class="faq-question-label flex justify-between items-center py-4 sm:py-[18px] px-4 sm:px-6 cursor-pointer bg-white font-semibold text-mp-primary font-montserrat text-sm transition-all duration-300 ease-in-out">
                        <span>Bagaimana kebijakan pembatalan khusus Paket Haji?</span>
                        <ion-icon name="chevron-down-outline" class="faq-icon-el text-[20px] text-maroon-primary transition-transform duration-300"></ion-icon>
                    </label>
                    <div class="faq-answer-wrap bg-[#fafafa]">
                        <div class="p-5 sm:px-6 text-mp-text text-sm leading-relaxed border-t border-mp-border">
                            <p>Khusus untuk Paket Haji, pembatalan yang dilakukan <strong>45 hari sebelumnya</strong> akan dikenakan biaya pemotongan sebesar <strong>75%</strong> dari harga paket.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-mp-border rounded-xl overflow-hidden shadow-sm transition-all duration-300 ease-in-out hover:border-maroon-primary hover:shadow-md">
                    <input type="checkbox" id="faq3" class="faq-toggle">
                    <label for="faq3" class="faq-question-label flex justify-between items-center py-4 sm:py-[18px] px-4 sm:px-6 cursor-pointer bg-white font-semibold text-mp-primary font-montserrat text-sm transition-all duration-300 ease-in-out">
                        <span>Apa yang terjadi jika Visa tidak keluar?</span>
                        <ion-icon name="chevron-down-outline" class="faq-icon-el text-[20px] text-maroon-primary transition-transform duration-300"></ion-icon>
                    </label>
                    <div class="faq-answer-wrap bg-[#fafafa]">
                        <div class="p-5 sm:px-6 text-mp-text text-sm leading-relaxed border-t border-mp-border">
                            <p>Jika Visa tidak keluar, dana yang sudah disetor akan diproses <strong>Refund</strong> (dikurangi biaya yang sudah keluar seperti tiket & admin) ATAU dilakukan <strong>Reschedule Ulang</strong> dengan perhitungan dana tetap sama seperti awal.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-mp-border rounded-xl overflow-hidden shadow-sm transition-all duration-300 ease-in-out hover:border-maroon-primary hover:shadow-md">
                    <input type="checkbox" id="faq4" class="faq-toggle">
                    <label for="faq4" class="faq-question-label flex justify-between items-center py-4 sm:py-[18px] px-4 sm:px-6 cursor-pointer bg-white font-semibold text-mp-primary font-montserrat text-sm transition-all duration-300 ease-in-out">
                        <span>Bisakah saya keluar dari rombongan saat di Tanah Suci?</span>
                        <ion-icon name="chevron-down-outline" class="faq-icon-el text-[20px] text-maroon-primary transition-transform duration-300"></ion-icon>
                    </label>
                    <div class="faq-answer-wrap bg-[#fafafa]">
                        <div class="p-5 sm:px-6 text-mp-text text-sm leading-relaxed border-t border-mp-border">
                            <p>Tidak disarankan. Jika setelah keberangkatan jamaah mengajukan perpindahan atau keluar dari rombongan, maka jamaah <strong>tidak dapat menuntut pengembalian dana</strong> dalam bentuk apapun untuk fasilitas/kegiatan yang belum dilaksanakan.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-mp-border rounded-xl overflow-hidden shadow-sm transition-all duration-300 ease-in-out hover:border-maroon-primary hover:shadow-md">
                    <input type="checkbox" id="faq5" class="faq-toggle">
                    <label for="faq5" class="faq-question-label flex justify-between items-center py-4 sm:py-[18px] px-4 sm:px-6 cursor-pointer bg-white font-semibold text-mp-primary font-montserrat text-sm transition-all duration-300 ease-in-out">
                        <span>Apa saja fasilitas standar yang didapatkan?</span>
                        <ion-icon name="chevron-down-outline" class="faq-icon-el text-[20px] text-maroon-primary transition-transform duration-300"></ion-icon>
                    </label>
                    <div class="faq-answer-wrap bg-[#fafafa]">
                        <div class="p-5 sm:px-6 text-mp-text text-sm leading-relaxed border-t border-mp-border">
                            <p>Fasilitas mencakup: Tiket PP Ekonomis, Hotel/Apartemen, Makan (sesuai paket), Handling, City Tour, dan Tasreh Haji (khusus paket haji).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

