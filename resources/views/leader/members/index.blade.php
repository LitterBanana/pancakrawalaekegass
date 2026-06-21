@extends('layouts.leader')

@section('title', 'Daftar Anggota - HMI Leader')
@section('page-title', 'Daftar Anggota')
@section('page-description', 'Kelola anggota referral dan downline Anda dari halaman leader.')



@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6 animate-fade-in-up">
    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 hover:border-[#8B1A1A]">
        <div class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Total Anggota</div>
        <div class="text-3xl font-bold text-gray-900">{{ $members->total() }}</div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 hover:border-[#8B1A1A]">
        <div class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Anggota Aktif</div>
        <div class="text-3xl font-bold text-gray-900">{{ $members->total() }}</div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 hover:border-[#8B1A1A]">
        <div class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Kode Referral</div>
        <div class="text-xl font-bold text-gray-900 font-mono">{{ $leader->referral_code ?? '-' }}</div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 hover:border-[#8B1A1A]">
        <div class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Terakhir Bergabung</div>
        <div class="text-lg font-bold text-gray-900">
            {{ $members->first() ? $members->first()->created_at->format('d M Y') : '-' }}
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden animate-fade-in-up delay-1">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
        <h3 class="text-base font-semibold text-gray-900 m-0">Daftar Anggota Referral</h3>
        <a href="{{ route('leader.members.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-[#8B1A1A] rounded-lg hover:bg-[#6B1010] transition-colors">Tambah Anggota Baru</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Nama</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Email</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Peran</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Bergabung</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Status</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($members as $member)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $member->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $member->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">{{ ucfirst($member->role) }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $member->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold border border-emerald-200">Aktif</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 flex items-center gap-2">
                            <a href="{{ route('leader.members.edit', $member->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">Edit</a>
                            <form action="{{ route('leader.members.destroy', $member->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin melepas anggota ini dari afiliasi Anda?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-red-600 bg-white border border-red-300 rounded-md hover:bg-red-50 transition-colors">Lepas</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada anggota referral.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
