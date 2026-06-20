@extends('layouts.admin')
@section('title', 'Tambah Invoice - HMI Tour')
@section('page_title', 'Tambah Invoice')
@section('page_subtitle', 'Buat tagihan atau pemesanan baru secara manual')

@section('content')
<div class="card animate-fade-in-up">
    <div class="card-header">
        <h3 class="section-title text-lg">Form Pembuatan Invoice</h3>
        <a href="{{ route('admin.invoice.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.invoice.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Kolom Kiri -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 border-b pb-2">Informasi Pelanggan</h4>

                    <div class="form-group">
                        <label class="form-label">Pilih Akun User (Opsional)</label>
                        <select name="user_id" id="user_id" class="form-select" onchange="toggleUserForm()">
                            <option value="">-- Buat User Baru --</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" data-name="{{ $u->name }}" data-email="{{ $u->email }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} ({{ $u->email }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Kosongkan untuk mendaftarkan akun baru secara otomatis.</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap Pelanggan <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" class="form-input" required placeholder="Cth: Fulan bin Fulan">
                        @error('customer_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group" id="email_container">
                        <label class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input" placeholder="email@contoh.com">
                        @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Handphone / WA <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-input" required placeholder="08123456789">
                        @error('phone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 border-b pb-2">Detail Pemesanan</h4>

                    <div class="form-group">
                        <label class="form-label">Paket Umrah/Tour <span class="text-red-500">*</span></label>
                        <select name="package_id" id="package_id" class="form-select" required onchange="updateRoomTypes()">
                            <option value="">-- Pilih Paket --</option>
                            @foreach($packages as $pkg)
                                <option value="{{ $pkg->id }}" {{ old('package_id') == $pkg->id ? 'selected' : '' }}>
                                    {{ $pkg->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('package_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tipe Kamar <span class="text-red-500">*</span></label>
                        <select name="package_price_id" id="package_price_id" class="form-select" required disabled>
                            <option value="">-- Pilih Tipe Kamar --</option>
                        </select>
                        @error('package_price_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Jumlah Pax <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah_orang" id="jumlah_orang" value="{{ old('jumlah_orang', 1) }}" min="1" class="form-input" required onchange="calculateTotal()">
                            @error('jumlah_orang') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status <span class="text-red-500">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="dicicil" {{ old('status') == 'dicicil' ? 'selected' : '' }}>Dicicil</option>
                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                                <option value="cancel" {{ old('status') == 'cancel' ? 'selected' : '' }}>Batal</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700">Estimasi Total Harga:</span>
                            <span class="text-xl font-bold text-gray-900" id="total_display">IDR 0</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-5 border-t border-gray-200">
                <button type="submit" class="btn btn-primary btn-full btn-lg">Simpan Invoice</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const packages = @json($packages);
    const oldPriceId = "{{ old('package_price_id') }}";
    
    function toggleUserForm() {
        const userSelect = document.getElementById('user_id');
        const nameInput = document.getElementById('customer_name');
        const emailInput = document.getElementById('email');
        
        if (userSelect.value) {
            const selectedOption = userSelect.options[userSelect.selectedIndex];
            nameInput.value = selectedOption.getAttribute('data-name');
            emailInput.value = selectedOption.getAttribute('data-email');
            
            emailInput.readOnly = true;
            emailInput.classList.add('bg-gray-100');
        } else {
            nameInput.value = '';
            emailInput.value = '';
            emailInput.readOnly = false;
            emailInput.classList.remove('bg-gray-100');
        }
    }

    function updateRoomTypes() {
        const packageId = document.getElementById('package_id').value;
        const priceSelect = document.getElementById('package_price_id');
        
        priceSelect.innerHTML = '<option value="">-- Pilih Tipe Kamar --</option>';
        priceSelect.disabled = true;
        
        if (!packageId) {
            calculateTotal();
            return;
        }

        const pkg = packages.find(p => p.id == packageId);
        if (pkg && pkg.prices && pkg.prices.length > 0) {
            priceSelect.disabled = false;
            pkg.prices.forEach(price => {
                const opt = document.createElement('option');
                opt.value = price.id;
                opt.dataset.price = price.price;
                const formattedPrice = new Intl.NumberFormat('id-ID').format(price.price);
                opt.textContent = `${price.type} (IDR ${formattedPrice})`;
                
                if (oldPriceId == price.id) {
                    opt.selected = true;
                }
                
                priceSelect.appendChild(opt);
            });
        }
        
        calculateTotal();
    }

    function calculateTotal() {
        const priceSelect = document.getElementById('package_price_id');
        const qtyInput = document.getElementById('jumlah_orang');
        const display = document.getElementById('total_display');
        
        if (priceSelect.value && priceSelect.selectedIndex > 0) {
            const price = parseFloat(priceSelect.options[priceSelect.selectedIndex].dataset.price);
            const qty = parseInt(qtyInput.value) || 1;
            const total = price * qty;
            
            display.textContent = 'IDR ' + new Intl.NumberFormat('id-ID').format(total);
        } else {
            display.textContent = 'IDR 0';
        }
    }

    document.getElementById('package_price_id').addEventListener('change', calculateTotal);

    document.addEventListener('DOMContentLoaded', () => {
        if(document.getElementById('user_id').value) toggleUserForm();
        if(document.getElementById('package_id').value) {
            updateRoomTypes();
        }
    });
</script>
@endpush
