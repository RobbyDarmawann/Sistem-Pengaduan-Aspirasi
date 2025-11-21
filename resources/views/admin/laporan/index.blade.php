@extends('layouts.admin')

@section('title', 'Daftar Laporan')

@section('content')

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-4">
            <h2 class="text-xl font-bold text-gray-800">Daftar Laporan Masuk</h2>
        </div>

        <form action="{{ route('admin.laporan.index') }}" method="GET" class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <div class="flex flex-col md:flex-row gap-4 items-end">
                
                <div class="w-full md:w-1/3">
                    <label for="tipe" class="block text-sm font-semibold text-gray-700 mb-1">Tipe Laporan</label>
                    <select name="tipe" id="tipe" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                        <option value="all">Semua Tipe</option>
                        <option value="pengaduan" {{ request('tipe') == 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                        <option value="aspirasi" {{ request('tipe') == 'aspirasi' ? 'selected' : '' }}>Aspirasi</option>
                    </select>
                </div>

                <div class="w-full md:w-1/3">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status Laporan</label>
                    <select name="status" id="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                        <option value="all">Semua Status</option>
                        <option value="belum_disetujui" {{ request('status') == 'belum_disetujui' ? 'selected' : '' }}>Belum Disetujui</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="w-full md:w-auto flex gap-2">
                    <button type="submit" class="px-6 py-2 bg-[#3282B8] text-white font-semibold rounded-lg hover:bg-[#1B6CA8] transition-colors shadow-sm flex items-center gap-2">
                        <i class="ri-filter-3-line"></i> Terapkan
                    </button>
                    
                    @if(request('tipe') || request('status'))
                        <a href="{{ route('admin.laporan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors" title="Reset Filter">
                            <i class="ri-refresh-line"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            {{-- ... Isi tabel sama seperti sebelumnya ... --}}
            <thead class="bg-gray-50 text-gray-600 font-semibold text-sm uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 border-b border-gray-100">Klasifikasi</th>
                    <th class="px-6 py-4 border-b border-gray-100 w-1/3">Judul Laporan</th>
                    <th class="px-6 py-4 border-b border-gray-100">Nama Pembuat</th>
                    <th class="px-6 py-4 border-b border-gray-100">Laporan Dibuat</th>
                    <th class="px-6 py-4 border-b border-gray-100">Status</th>
                    <th class="px-6 py-4 border-b border-gray-100 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                @forelse($laporan as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 capitalize font-bold text-gray-800">{{ $item->tipe_laporan }}</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 mb-1">{{ Str::limit($item->judul, 40) }}</div>
                        <div class="text-gray-500 text-xs leading-relaxed">{{ Str::limit($item->isi_laporan, 60) }}</div>
                    </td>
                    <td class="px-6 py-4 font-medium">{{ $item->pengguna->full_name ?? 'Anonim' }}</td>
                    <td class="px-6 py-4 font-medium text-gray-600">{{ $item->created_at->format('d-m-Y • H:i') }}</td>
                    <td class="px-6 py-4">
                        @php
                            $statusClass = match($item->status) {
                                'belum_disetujui' => 'bg-red-500 text-white',
                                'diproses' => 'bg-yellow-400 text-white',
                                'selesai' => 'bg-blue-500 text-white',
                                default => 'bg-gray-500 text-white',
                            };
                            $statusLabel = match($item->status) {
                                'belum_disetujui' => 'Belum Disetujui',
                                'diproses' => 'Sedang Diproses',
                                default => ucfirst($item->status),
                            };
                        @endphp
                        <span class="px-3 py-1.5 rounded-md text-xs font-bold {{ $statusClass }} shadow-sm">
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="#" class="inline-block px-4 py-2 bg-[#3282B8] text-white text-xs font-bold rounded-md hover:bg-[#1B6CA8] transition-colors shadow-sm">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <i class="ri-inbox-line text-5xl text-gray-300 mb-3"></i>
                            <p class="text-lg">Belum ada laporan sesuai filter.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-6 border-t border-gray-100">
        {{ $laporan->withQueryString()->links() }}
    </div>
</div>

@endsection