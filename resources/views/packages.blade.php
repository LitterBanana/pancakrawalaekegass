@extends('layouts.app')

@section('content')

    <section class="pt-[200px] pb-[100px] min-h-screen" style="background: linear-gradient(to bottom, var(--color-maroon-primary) 0%, var(--color-maroon-primary) 160px, var(--color-mp-bg) 160px, var(--color-mp-bg) 100%);">

        <div class="max-w-[1200px] mx-auto px-5 flex flex-col lg:flex-row gap-8 items-start">

            <aside class="mp-sidebar-wrap w-full lg:w-[280px] lg:shrink-0 bg-white rounded-xl border border-mp-border p-4 lg:p-6 lg:sticky lg:top-[120px]">

                <button type="button" class="flex lg:hidden w-full py-3 bg-white border border-mp-border rounded-lg font-bold text-mp-primary text-center items-center justify-center gap-2 mb-4 cursor-pointer text-sm" onclick="toggleMobileFilter()">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z" />
                    </svg>
                    Tampilkan Filter Pencarian
                </button>

                <form action="{{ route('packages.index') }}" method="GET">

                    @if (request('pax'))
                        <input type="hidden" name="pax" value="{{ request('pax') }}">
                    @endif
                    @if (request('departure_date'))
                        <input type="hidden" name="departure_date" value="{{ request('departure_date') }}">
                    @endif
                    @if (request('return_date'))
                        <input type="hidden" name="return_date" value="{{ request('return_date') }}">
                    @endif

                    <div class="mb-6 border-b border-mp-border pb-5">
                        <label class="text-[15px] font-bold text-mp-primary mb-3 block">Cari Nama Paket</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Ketik kata kunci..." class="w-full py-2.5 px-3 border border-mp-border rounded-lg text-sm text-mp-text bg-slate-50 transition-all duration-300 focus:border-mp-primary focus:outline-none focus:bg-white">
                    </div>

                    <div class="mb-6 border-b border-mp-border pb-5">
                        <label class="text-[15px] font-bold text-mp-primary mb-3 block">Lama Perjalanan</label>
                        <select name="duration" class="w-full py-2.5 px-3 border border-mp-border rounded-lg text-sm text-mp-text bg-slate-50 transition-all duration-300 focus:border-mp-primary focus:outline-none focus:bg-white">
                            <option value="">Semua Durasi</option>
                            <option value="9" {{ request('duration') == '9' ? 'selected' : '' }}>9 Hari</option>
                            <option value="10" {{ request('duration') == '10' ? 'selected' : '' }}>10 Hari</option>
                            <option value="12" {{ request('duration') == '12' ? 'selected' : '' }}>12 Hari</option>
                        </select>
                    </div>

                    <div class="mb-6 border-b border-mp-border pb-5">
                        <label class="text-[15px] font-bold text-mp-primary mb-3 block">Fasilitas Hotel</label>
                        <select name="hotel_rating" class="w-full py-2.5 px-3 border border-mp-border rounded-lg text-sm text-mp-text bg-slate-50 transition-all duration-300 focus:border-mp-primary focus:outline-none focus:bg-white">
                            <option value="">Semua Bintang</option>
                            <option value="3" {{ request('hotel_rating') == '3' ? 'selected' : '' }}>Bintang 3 (★★★)
                            </option>
                            <option value="4" {{ request('hotel_rating') == '4' ? 'selected' : '' }}>Bintang 4 (★★★★)
                            </option>
                            <option value="5" {{ request('hotel_rating') == '5' ? 'selected' : '' }}>Bintang 5 (★★★★★)
                            </option>
                        </select>
                    </div>

                    <div class="mb-0">
                        <button type="submit" class="w-full bg-mp-primary text-white border-none py-3 rounded-lg font-bold cursor-pointer transition-all duration-300 text-center mb-2.5 hover:bg-[#111d33]">Terapkan Filter</button>
                        <a href="{{ route('packages.index') }}" class="w-full bg-white text-mp-text-light border border-mp-border py-3 rounded-lg font-bold cursor-pointer text-center no-underline block hover:bg-gray-50">Reset Pencarian</a>
                    </div>
                </form>
            </aside>

            <div class="flex-1">

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 bg-white py-4 px-5 rounded-xl border border-mp-border gap-4">
                    <div>
                        <h1 class="text-xl text-mp-primary m-0 font-bold">Etalase Paket</h1>
                        <p class="text-[13px] text-mp-text-light m-0 mt-1">Menampilkan
                            {{ $packages->count() }} paket tersedia</p>
                    </div>

                    <form action="{{ route('packages.index') }}" method="GET"
                        class="flex items-center gap-2.5">
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if (request('duration'))
                            <input type="hidden" name="duration" value="{{ request('duration') }}">
                        @endif
                        @if (request('hotel_rating'))
                            <input type="hidden" name="hotel_rating" value="{{ request('hotel_rating') }}">
                        @endif

                        <label class="text-[13px] font-bold text-mp-text">Urutkan:</label>
                        <select name="sort" class="py-2 px-3 border border-mp-border rounded-lg text-sm text-mp-text bg-slate-50 transition-all duration-300 focus:border-mp-primary focus:outline-none focus:bg-white"
                            onchange="this.form.submit()">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga:
                                Terendah</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga:
                                Tertinggi</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                    @forelse ($packages as $package)
                        <a href="{{ route('package.show', $package->slug) }}" class="no-underline">
                            <div class="product-card-wrap bg-white border border-mp-border rounded-xl overflow-hidden transition-all duration-300 flex flex-col relative">
                                <span class="absolute top-2.5 right-2.5 bg-white/90 text-mp-primary py-1 px-2 rounded-md text-xs font-bold shadow-sm z-10">Sisa {{ $package->quota ?? 'TBA' }} Seat</span>
                                <img src="{{ asset('assets/images/' . ($package->thumbnail ?? 'default-umroh.jpg')) }}"
                                    alt="{{ $package->name }}" class="w-full h-[180px] object-cover">

                                <div class="p-4 flex flex-col flex-1">
                                    <h3 class="line-clamp-2 text-[15px] font-bold text-mp-primary mb-2 leading-snug">{{ $package->name }}</h3>

                                    <div class="text-xs text-mp-text-light mb-4 flex gap-2.5 items-center">
                                        <span>⏱️ {{ $package->duration ?? '9' }} Hari</span>
                                        <span>|</span>
                                        <span class="text-amber-400 text-xs">
                                            @php
                                                $rating = max(
                                                    $package->hotelMakkah->rating ?? 0,
                                                    $package->hotelMadinah->rating ?? 0,
                                                );
                                            @endphp
                                            @if ($rating > 0)
                                                @for ($i = 0; $i < $rating; $i++)
                                                    ★
                                                @endfor
                                            @else
                                                Hotel TBA
                                            @endif
                                        </span>
                                    </div>

                                    <div class="mt-auto border-t border-dashed border-mp-border pt-3">
                                        <div class="text-[11px] text-mp-text-light uppercase font-bold mb-0.5">Mulai Dari</div>
                                        <div class="text-lg font-extrabold text-mp-orange">IDR
                                            {{ number_format($package->prices->first()->price ?? 0, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full bg-white p-10 text-center rounded-xl border border-mp-border">
                            <h3 class="text-mp-primary mb-2.5 font-bold">Paket Tidak Ditemukan</h3>
                            <p class="text-mp-text-light">Coba ubah filter pencarian Anda atau reset filter.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </section>
    <script>
        function toggleMobileFilter() {
            const sidebar = document.querySelector('.mp-sidebar-wrap');
            sidebar.classList.toggle('show-filter');

            const btn = document.querySelector('.mp-sidebar-wrap button');
            if (sidebar.classList.contains('show-filter')) {
                btn.innerHTML = 'Tutup Filter ✖';
            } else {
                btn.innerHTML =
                    '<svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z"/></svg> Tampilkan Filter Pencarian';
            }
        }
    </script>
@endsection