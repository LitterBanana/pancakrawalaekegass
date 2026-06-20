@extends('layouts.leader')

@section('title', 'Ekspor Laporan - HMI Leader')
@section('page-title', 'Ekspor Laporan')
@section('page-description', 'Halaman untuk mengekspor data laporan ke PDF atau Excel.')

@section('content')
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden animate-fade-in-up">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 m-0">Ekspor Data</h3>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-600">Halaman ini merupakan template untuk struktur <code class="bg-gray-100 text-red-700 px-1 py-0.5 rounded text-xs font-mono">/reports/export.blade.php</code>. Gunakan sebagai basis ekspor pdf/excel, filter lanjutan, atau manajemen laporan.</p>
        </div>
    </div>
@endsection
