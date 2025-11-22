@extends('layouts.admin')

@section('title', 'Daftar Laporan')

@section('content')

<div class="bg-white rounded-xl shadow-md overflow-visible relative"> <div class="p-6 border-b border-gray-100">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Daftar Laporan Masuk</h2>
            <p class="text-sm text-gray-500">Kelola dan filter laporan masyarakat.</p>
        </div>

        <form action="{{ route('admin.laporan.index') }}" method="GET" class="bg-gray-50 p-4 rounded-xl border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1 uppercase tracking-wider">Tipe</label>
                    <select name="tipe" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="all">Semua</option>
                        <option value="pengaduan" {{ request('tipe') == 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                        <option value="aspirasi" {{ request('tipe') == 'aspirasi' ? 'selected' : '' }}>Aspirasi</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1 uppercase tracking-wider">Status</label>
                    <select name="status" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="all">Semua</option>
                        <option value="belum_disetujui" {{ request('status') == 'belum_disetujui' ? 'selected' : '' }}>Belum Disetujui</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="relative">
                    <label class="block text-xs font-bold text-gray-600 mb-1 uppercase tracking-wider">Instansi Tujuan</label>
                    
                    <button type="button" onclick="toggleInstansiDropdown()" id="instansi-btn" class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white text-left text-sm flex justify-between items-center focus:ring-2 focus:ring-blue-500">
                        <span id="instansi-label" class="truncate block max-w-[150px]">
                            {{ request('instansi') && request('instansi') != 'all' ? ucwords(str_replace('_', ' ', request('instansi'))) : 'Semua Instansi' }}
                        </span>
                        <i class="ri-arrow-down-s-line text-gray-500"></i>
                    </button>

                    <div id="instansi-dropdown" class="hidden absolute z-50 mt-1 w-full md:w-64 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 overflow-y-auto custom-scrollbar">
                        <input type="hidden" name="instansi" id="instansi-input" value="{{ request('instansi', 'all') }}">
                        
                        <div onclick="selectInstansi('all', 'Semua Instansi')" class="px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm border-b border-gray-100 text-gray-700 font-semibold">
                            Semua Instansi
                        </div>
                        
                        @foreach($listInstansi as $ins)
                            <div onclick="selectInstansi('{{ $ins }}', '{{ $ins }}')" class="px-4 py-2 hover:bg-blue-50 cursor-pointer text-xs text-gray-600 border-b border-gray-50 last:border-0 leading-relaxed">
                                {{ $ins }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-[#3282B8] text-white font-semibold rounded-lg hover:bg-[#1B6CA8] transition-colors shadow-sm flex justify-center items-center gap-1 text-sm">
                        <i class="ri-filter-3-line"></i> Filter
                    </button>
                    
                    @if(request()->hasAny(['tipe', 'status', 'instansi']))
                        <a href="{{ route('admin.laporan.index') }}" class="px-3 py-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300 transition-colors" title="Reset">
                            <i class="ri-refresh-line"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[1000px]"> <thead class="bg-gray-50 text-gray-600 font-semibold text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 border-b border-gray-100">Klasifikasi</th>
                    <th class="px-6 py-4 border-b border-gray-100 w-64">Judul</th>
                    <th class="px-6 py-4 border-b border-gray-100">Instansi Tujuan</th> <th class="px-6 py-4 border-b border-gray-100">Pelapor</th>
                    <th class="px-6 py-4 border-b border-gray-100">Tanggal</th>
                    <th class="px-6 py-4 border-b border-gray-100 text-center">Status</th>
                    <th class="px-6 py-4 border-b border-gray-100 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                @forelse($laporan as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 capitalize font-bold text-gray-800">
                        <span class="px-2 py-1 rounded bg-gray-100 text-xs">
                            {{ $item->tipe_laporan }}
                        </span>
                    </td>
                    
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 mb-1 truncate max-w-[200px]" title="{{ $item->judul }}">{{ $item->judul }}</div>
                        <div class="text-gray-500 text-xs truncate max-w-[200px]">{{ $item->isi_laporan }}</div>
                    </td>

                    <td class="px-6 py-4">
                        <div class="text-xs font-medium text-blue-700 bg-blue-50 px-2 py-1 rounded-lg inline-block max-w-[180px] truncate" title="{{ ucwords(str_replace('_', ' ', $item->instansi_tujuan)) }}">
                            {{ ucwords(str_replace('_', ' ', $item->instansi_tujuan)) }}
                        </div>
                    </td>

                    <td class="px-6 py-4 font-medium text-gray-600">
                        {{ $item->pengguna->full_name ?? 'Anonim' }}
                    </td>

                    <td class="px-6 py-4 font-medium text-gray-500 text-xs">
                        {{ $item->created_at->format('d/m/Y') }} <br>
                        {{ $item->created_at->format('H:i') }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        @php
                            $statusClass = match($item->status) {
                                'belum_disetujui' => 'bg-red-100 text-red-600',
                                'diproses' => 'bg-yellow-100 text-yellow-700',
                                'selesai' => 'bg-green-100 text-green-700',
                                'ditolak' => 'bg-gray-200 text-gray-600',
                                default => 'bg-gray-100 text-gray-600',
                            };
                            $statusLabel = match($item->status) {
                                'belum_disetujui' => 'Belum Disetujui',
                                'diproses' => 'Diproses',
                                default => ucfirst($item->status),
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-center">
                        @if($item->status == 'belum_disetujui')
                            <a href="{{ route('admin.laporan.show', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-[#3282B8] text-white rounded hover:bg-[#1B6CA8] transition" title="Verifikasi">
                                <i class="ri-edit-box-line"></i>
                            </a>
                        @elseif($item->status == 'diproses' || $item->status == 'selesai')
                            <a href="{{ route('admin.laporan.progres', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded hover:bg-green-700 transition" title="Lihat Progres">
                                <i class="ri-eye-line"></i>
                            </a>
                        @else
                            <span class="text-gray-400 text-xl"><i class="ri-prohibited-line"></i></span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <i class="ri-inbox-line text-5xl text-gray-300 mb-3"></i>
                            <p>Tidak ada laporan sesuai filter.</p>
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

<script>
    function toggleInstansiDropdown() {
        const dropdown = document.getElementById('instansi-dropdown');
        dropdown.classList.toggle('hidden');
    }

    function selectInstansi(value, label) {
        document.getElementById('instansi-input').value = value;
        document.getElementById('instansi-label').innerText = label;
        
        // Tutup dropdown
        document.getElementById('instansi-dropdown').classList.add('hidden');
    }

    // Tutup dropdown jika klik di luar
    window.addEventListener('click', function(e) {
        const btn = document.getElementById('instansi-btn');
        const dropdown = document.getElementById('instansi-dropdown');
        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>

<style>
    /* Scrollbar Cantik untuk Dropdown */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #999; }
</style>

@endsection