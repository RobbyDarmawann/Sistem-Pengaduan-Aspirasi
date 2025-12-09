@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between h-40">
        <div class="flex justify-between items-start">
            <span class="text-5xl font-bold text-gray-800">{{ $laporanBelumDisetujui }}</span>
            <div class="p-3 bg-blue-50 rounded-xl">
                <i class="ri-file-text-line text-2xl text-blue-600"></i>
            </div>
        </div>
        <span class="text-gray-600 font-medium">Laporan Belum Disetujui</span>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between h-40">
        <div class="flex justify-between items-start">
            <span class="text-5xl font-bold text-gray-800">{{ $laporanSedangDiproses }}</span>
            <div class="p-3 bg-orange-50 rounded-xl">
                <i class="ri-loader-2-line text-2xl text-orange-600"></i>
            </div>
        </div>
        <span class="text-gray-600 font-medium">Laporan Sedang Diproses</span>
    </div>

    <div class="bg-[#3282B8] rounded-2xl p-6 shadow-sm border border-blue-400 flex flex-col justify-between h-40 text-white">
        <div class="flex justify-between items-start">
            <span class="text-5xl font-bold">{{ $laporanSelesai }}</span>
            <div class="p-3 bg-white/20 rounded-xl">
                <i class="ri-checkbox-circle-line text-2xl text-white"></i>
            </div>
        </div>
        <span class="font-medium text-blue-100">Laporan Selesai</span>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800">Laporan Yang Menunggu Persetujuan Terbaru:</h3>
    <a href="{{ route('admin.laporan.index') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
        Lihat Semua <i class="ri-arrow-right-line ml-1"></i>
    </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider border-b border-gray-100">
                    <th class="px-6 py-4 font-semibold">Klasifikasi</th>
                    <th class="px-6 py-4 font-semibold">Judul Laporan</th>
                    <th class="px-6 py-4 font-semibold">Nama Pembuat</th>
                    <th class="px-6 py-4 font-semibold">Tanggal</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse($laporanTerbaru as $laporan)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 capitalize font-medium">{{ $laporan->tipe_laporan }}</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">{{ Str::limit($laporan->judul, 30) }}</div>
                        <div class="text-gray-500 text-xs mt-1">{{ Str::limit($laporan->isi_laporan, 50) }}</div>
                    </td>
                    <td class="px-6 py-4">{{ $laporan->pengguna->full_name ?? 'Anonim' }}</td>
                    <td class="px-6 py-4">{{ $laporan->created_at->format('d-m-Y • H:i') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                            Belum Disetujui
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{  route('admin.laporan.show', $laporan->id)  }}">
                        <button  class="px-3 py-1.5 bg-[#3282B8] text-white rounded-md text-xs font-semibold hover:bg-[#1B6CA8] transition-colors">
                            Lihat Detail
                        </button>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <i class="ri-inbox-line text-4xl text-gray-300 mb-2"></i>
                            <p>Tidak ada laporan baru yang menunggu.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection