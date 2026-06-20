@extends('layouts.leader')

@section('title', 'Kelola Anggota - HMI Leader')
@section('page-title', 'CRUD Anggota')
@section('page-description', 'Halaman manajemen anggota referral untuk leader.')

@section('content')
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden animate-fade-in-up">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 m-0">Manajemen Anggota</h3>
            <a href="{{ route('leader.members.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-gray-600 bg-transparent border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors">Kembali
                Ke Daftar</a>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-600 mb-6">Halaman CRUD ini menampilkan anggota referral Anda dengan struktur yang
                mudah dikembangkan: daftar anggota, detail, dan aksi manajemen.</p>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                Nama</th>
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                Email</th>
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                Peran</th>
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                Status</th>
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($members as $member)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $member->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $member->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <span
                                        class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">{{ ucfirst($member->role) }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <span
                                        class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold border border-emerald-200">Aktif</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 space-x-2">
                                    <button
                                        class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-gray-400 bg-transparent border border-gray-200 rounded-md cursor-not-allowed"
                                        disabled>Edit</button>
                                    <button
                                        class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-gray-400 bg-transparent border border-gray-200 rounded-md cursor-not-allowed"
                                        disabled>Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada anggota untuk
                                    ditampilkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection