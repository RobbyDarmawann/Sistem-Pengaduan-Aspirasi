@extends('layouts.instansi')

@section('title', 'Dashboard Instansi')

@section('content')

<div class="mb-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-[#C0392B] rounded-xl p-6 text-white shadow-md relative overflow-hidden">
            <div class="flex items-center gap-3 mb-4 border-b border-white/20 pb-2">
                <div class="p-2 bg-white/20 rounded-lg"><i class="ri-file-warning-line text-2xl"></i></div>
                <span class="font-bold">Belum Ditindaklanjut</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-lg font-medium">Aspirasi:</span>
                <span class="text-3xl font-bold bg-white/20 px-3 py-1 rounded">{{ $stats['aspirasi_belum'] }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-lg font-medium">Laporan:</span>
                <span class="text-3xl font-bold bg-white/20 px-3 py-1 rounded">{{ $stats['laporan_belum'] }}</span>
            </div>
        </div>

        <div class="bg-[#F1C40F] rounded-xl p-6 text-white shadow-md relative overflow-hidden">
            <div class="flex items-center gap-3 mb-4 border-b border-white/20 pb-2">
                <div class="p-2 bg-white/20 rounded-lg"><i class="ri-loader-2-line text-2xl"></i></div>
                <span class="font-bold">Sedang Ditindaklanjut</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-lg font-medium">Aspirasi:</span>
                <span class="text-3xl font-bold bg-white/20 px-3 py-1 rounded">{{ $stats['aspirasi_proses'] }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-lg font-medium">Laporan:</span>
                <span class="text-3xl font-bold bg-white/20 px-3 py-1 rounded">{{ $stats['laporan_proses'] }}</span>
            </div>
        </div>

        <div class="bg-[#2ECC71] rounded-xl p-6 text-white shadow-md relative overflow-hidden">
            <div class="flex items-center gap-3 mb-4 border-b border-white/20 pb-2">
                <div class="p-2 bg-white/20 rounded-lg"><i class="ri-checkbox-circle-line text-2xl"></i></div>
                <span class="font-bold">Sudah Ditindaklanjut</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-lg font-medium">Aspirasi:</span>
                <span class="text-3xl font-bold bg-white/20 px-3 py-1 rounded">{{ $stats['aspirasi_selesai'] }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-lg font-medium">Laporan:</span>
                <span class="text-3xl font-bold bg-white/20 px-3 py-1 rounded">{{ $stats['laporan_selesai'] }}</span>
            </div>
        </div>

    </div>
</div>

<div class="mb-12">
    <h3 class="text-xl font-bold text-gray-800 text-center mb-6 flex items-center justify-center gap-2">
        <i class="ri-file-warning-fill text-[#C0392B]"></i> Daftar Laporan Pengaduan
    </h3>
    
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
        @forelse($daftarLaporan as $item)
            <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition">
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <div class="text-xs text-gray-500 flex items-center gap-2">
                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded font-bold">Pengaduan</span>
                            <span>{{ $item->created_at->format('d M Y, H:i') }}</span>
                            <span class="text-gray-300">|</span>
                            <span class="font-mono">#{{ $item->id }}</span>
                        </div>
                        <span class="bg-[#FFC107] text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">
                            Sedang Diproses
                        </span>
                    </div>
                    
                    <h4 class="font-bold text-lg text-gray-900 mb-2">{{ $item->judul }}</h4>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $item->isi_laporan }}</p>
                    
                    <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                        <div class="text-xs text-gray-500">
                            Kategori: <span class="font-semibold text-gray-700">{{ $item->kategori }}</span>
                        </div>
                        <a href="{{ route('instansi.laporan.show', $item->id) }}" class="...">
                            Tindaklanjuti
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-400">
                <i class="ri-inbox-line text-3xl mb-2"></i>
                <p>Tidak ada laporan pengaduan baru.</p>
            </div>
        @endforelse
    </div>
</div>

<div class="mb-12">
    <h3 class="text-xl font-bold text-gray-800 text-center mb-6 flex items-center justify-center gap-2">
        <i class="ri-lightbulb-fill text-[#F1C40F]"></i> Daftar Aspirasi Masyarakat
    </h3>
    
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
        @forelse($daftarAspirasi as $item)
            <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition">
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <div class="text-xs text-gray-500 flex items-center gap-2">
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded font-bold">Aspirasi</span>
                            <span>{{ $item->created_at->format('d M Y, H:i') }}</span>
                            <span class="text-gray-300">|</span>
                            <span class="font-mono">#{{ $item->id }}</span>
                        </div>
                        <span class="bg-[#FFC107] text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">
                            Sedang Diproses
                        </span>
                    </div>
                    
                    <h4 class="font-bold text-lg text-gray-900 mb-2">{{ $item->judul }}</h4>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $item->isi_laporan }}</p>
                    
                    <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                        <div class="text-xs text-gray-500">
                            Kategori: <span class="font-semibold text-gray-700">{{ $item->kategori }}</span>
                        </div>
                        <a href="{{ route('instansi.laporan.show', $item->id) }}" class="...">
                            Tindaklanjuti
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-400">
                <i class="ri-inbox-line text-3xl mb-2"></i>
                <p>Tidak ada aspirasi baru.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection