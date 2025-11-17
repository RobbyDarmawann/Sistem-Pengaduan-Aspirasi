@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-xl shadow-md flex items-center gap-5">
        <div class="p-4 bg-orange-100 rounded-lg">
            <i class="ri-file-list-3-line text-3xl text-orange-600"></i>
        </div>
        <div>
            <div class="text-3xl font-bold text-gray-800">{{ $laporanBelumDisetujui }}</div>
            <div class="text-gray-500">Laporan Belum Disetujui</div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-md flex items-center gap-5">
        <div class="p-4 bg-gray-200 rounded-lg">
            <i class="ri-loader-line text-3xl text-gray-700"></i>
        </div>
        <div>
            <div class="text-3xl font-bold text-gray-800">{{ $laporanSedangDiproses }}</div>
            <div class="text-gray-500">Laporan Sedang Diproses</div>
        </div>
    </div>

    <div class="bg-blue-600 p-6 rounded-xl shadow-md flex items-center gap-5">
        <div class="p-4 bg-blue-500 rounded-lg">
            <i class="ri-checkbox-circle-line text-3xl text-white"></i>
        </div>
        <div>
            <div class="text-3xl font-bold text-white">{{ $laporanSelesai }}</div>
            <div class="text-blue-100">Laporan Selesai</div>
        </div>
    </div>
</div>

<div class="mt-10 bg-white rounded-xl shadow-md overflow-hidden">
    <div class="flex justify-between items-center p-6">
        <h2 class="text-xl font-semibold text-gray-800">Laporan Yang Menunggu Persetujuan Terbaru:</h2>
        <a href="#" class="px-5 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-colors">
            Lihat Semua <i class="ri-arrow-right-s-line"></i>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[800px]">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klasifikasi</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Laporan</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pembuat</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Laporan Dibuat</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($laporanTerbaru as $laporan)
                <tr>
                    <td class="py-4 px-6 whitespace-nowrap text-gray-800 capitalize">
                        {{ $laporan->tipe_laporan ?? 'Pengaduan' }}
                    </td>
                    <td class="py-4 px-6 max-w-sm text-gray-800">
                        <div class="truncate">{{ $laporan->judul }}</div>
                        <div class="text-sm text-gray-500 truncate">{{ Str::limit($laporan->isi, 80) }}</div>
                    </td>
                    <td class="py-4 px-6 whitespace-nowrap text-gray-800">
                        {{ $laporan->pengguna->full_name ?? 'Petakilan' }}
                    </td>
                    <td class="py-4 px-6 whitespace-nowrap text-gray-500">
                        {{ $laporan->created_at->format('d-m-Y – H:i') }}
                    </td>
                    <td class="py-4 px-6 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            {{ Str::title(str_replace('_', ' ', $laporan->status)) }}
                        </span>
                    </td>
                    <td class="py-4 px-6 whitespace-nowrap">
                        <a href="#" class="px-4 py-2 rounded-lg bg-blue-500 text-white text-sm font-semibold hover:bg-blue-600">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-gray-500">
                        Tidak ada laporan yang menunggu persetujuan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection