@extends('layouts.leader')

@section('title', 'Kelola Anggota - HMI Leader')
@section('page-title', 'CRUD Anggota')
@section('page-description', 'Halaman manajemen anggota referral untuk leader.')

@section('content')
    <div class="card animate-fade-in-up">
        <div class="card-header">
            <h3 class="section-title" style="font-size: var(--text-lg);">Manajemen Anggota</h3>
            <a href="{{ route('leader.members.index') }}" class="btn btn-ghost btn-sm">Kembali Ke Daftar</a>
        </div>
        <div class="card-body">
            <p style="margin-bottom: var(--space-6);">Halaman CRUD ini menampilkan anggota referral Anda dengan struktur
                yang mudah dikembangkan: daftar anggota, detail, dan aksi manajemen.</p>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Peran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ ucfirst($member->role) }}</td>
                                <td><span class="badge badge-info">Aktif</span></td>
                                <td>
                                    <button class="btn btn-ghost btn-sm" disabled style="opacity: 0.7;">Edit</button>
                                    <button class="btn btn-ghost btn-sm" disabled style="opacity: 0.7;">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center" style="padding: var(--space-8);">Belum ada anggota untuk
                                    ditampilkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection