@extends('layouts.leader')

@section('title', 'Tambah Anggota - HMI Leader')
@section('page-title', 'Tambah Anggota')
@section('page-description', 'Tambahkan anggota baru ke dalam jaringan afiliasi Anda.')

@section('content')
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden animate-fade-in-up">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 m-0">Form Tambah Anggota</h3>
        <a href="{{ route('leader.members.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-gray-600 bg-transparent border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors">Kembali</a>
    </div>
    <div class="p-6">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('leader.members.store') }}" method="POST" class="max-w-2xl space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8B1A1A] focus:border-transparent outline-none transition-all" placeholder="Contoh: Budi Santoso" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8B1A1A] focus:border-transparent outline-none transition-all" placeholder="Contoh: budi@gmail.com" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8B1A1A] focus:border-transparent outline-none transition-all" placeholder="Minimal 8 karakter" required>
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-[#8B1A1A] text-white font-semibold rounded-lg hover:bg-[#6B1010] transition-colors">Simpan Anggota</button>
            </div>
        </form>
    </div>
</div>
@endsection
