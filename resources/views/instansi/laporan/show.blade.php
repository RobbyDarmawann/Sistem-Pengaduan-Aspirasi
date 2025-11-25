@extends('layouts.instansi')

@section('title', 'Tindak Lanjut Laporan')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="flex justify-center pb-20">
    <div class="w-full max-w-4xl">
        
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('instansi.dashboard') }}" class="px-4 py-2 bg-[#145D71] text-white rounded-lg font-medium hover:bg-[#0F4C5C] transition-colors flex items-center gap-2">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 relative">
            
            <div class="p-8 border-b border-gray-100">
                <div class="flex items-start justify-between">
                    <div class="flex gap-4">
                        <img src="{{ asset('assets/images/profil-pengguna.jpg') }}" class="w-14 h-14 rounded-full object-cover border border-gray-200">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-bold text-gray-800 text-lg">{{ $laporan->visibilitas == 'anonim' ? 'Anonim' : $laporan->pengguna->full_name }}</h3>
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full flex items-center gap-1 font-medium">
                                    <i class="ri-check-line text-green-500"></i> Terverifikasi
                                </span>
                            </div>
                            <div class="text-sm text-gray-500 flex items-center gap-3">
                                <span><i class="ri-calendar-line mr-1"></i> {{ $laporan->created_at->format('d F Y, H:i') }}</span>
                                <span class="text-gray-300">|</span>
                                <span>Tracking ID: #{{ $laporan->id }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        @if($laporan->status == 'selesai')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Selesai</span>
                        @else
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Sedang Diproses</span>
                        @endif
                    </div>
                </div>

                <div class="mt-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $laporan->judul }}</h1>
                    <p class="text-gray-700 leading-relaxed mb-4 whitespace-pre-line">{{ $laporan->isi_laporan }}</p>
                    @if($laporan->lampiran)
                        <img src="{{ asset('storage/' . $laporan->lampiran) }}" class="h-48 w-auto object-cover rounded-lg cursor-pointer hover:opacity-90" onclick="window.open(this.src)">
                    @endif
                </div>
            </div>

            <div class="px-8 py-4 bg-gray-50 border-b border-gray-200 flex flex-wrap gap-6 text-sm font-medium text-gray-600 select-none">
                <button onclick="toggleSection('section-tindak-lanjut')" class="flex items-center gap-2 hover:text-[#145D71] transition focus:outline-none">
                    <i class="ri-loop-left-line text-lg"></i> 
                    Tindak Lanjut <span class="bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded text-xs">{{ $laporan->tindakLanjuts->count() }}</span>
                </button>

                <button onclick="toggleSection('section-komentar')" class="flex items-center gap-2 hover:text-[#145D71] transition focus:outline-none">
                    <i class="ri-chat-1-line text-lg"></i> 
                    Komentar <span class="bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded text-xs">{{ $laporan->komentars->count() }}</span>
                </button>

                @php $isLiked = session()->has('liked_laporan_' . $laporan->id); @endphp
                <button id="btn-dukung" onclick="tambahDukungan({{ $laporan->id }})" class="flex items-center gap-2 transition focus:outline-none {{ $isLiked ? 'text-[#145D71] cursor-default' : 'hover:text-[#145D71]' }}">
                    <i class="{{ $isLiked ? 'ri-thumb-up-fill' : 'ri-thumb-up-line' }} text-lg" id="icon-dukung"></i> 
                    Mendukung <span id="count-dukung">{{ $laporan->jumlah_dukungan }}</span>
                </button>
                
                <button onclick="bagikanLaporan()" class="flex items-center gap-2 hover:text-[#145D71] transition ml-auto focus:outline-none">
                    <i class="ri-share-forward-line text-lg"></i> Bagikan
                </button>
            </div>

            <div id="section-tindak-lanjut" class="bg-white px-8 py-6 border-b border-gray-200 hidden transition-all duration-300">
                
                <h3 class="font-bold text-gray-800 mb-4">Riwayat Tindak Lanjut</h3>
                
                @if($laporan->status != 'selesai')
                <form action="{{ route('instansi.laporan.tindak-lanjut', $laporan->id) }}" method="POST" class="mb-8 bg-blue-50 p-4 rounded-xl border border-blue-100">
                    @csrf
                    <label class="block text-sm font-bold text-blue-800 mb-2">Tambah Progres Tindak Lanjut:</label>
                    <textarea name="isi_tindak_lanjut" rows="3" class="w-full p-3 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" placeholder="Jelaskan langkah apa yang sudah dilakukan... (Contoh: Tim sudah turun ke lokasi)" required></textarea>
                    <div class="text-right mt-2">
                        <button type="submit" class="bg-[#145D71] hover:bg-[#0F4C5C] text-white px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm">
                            Kirim Update
                        </button>
                    </div>
                </form>
                @endif

                <div class="space-y-6">
                    @forelse($laporan->tindakLanjuts()->latest()->get() as $tl)
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('assets/images/logo-icon.png') }}" class="w-10 h-10 object-contain">
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-gray-900 text-base">{{ $tl->instansi_nama }}</h4>
                                    <span class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($tl->waktu_tindak_lanjut)->format('d M, H:i') }}</span>
                                </div>
                                <p class="text-gray-600 text-sm mt-1 leading-relaxed bg-gray-50 p-3 rounded-lg border border-gray-100">
                                    {!! nl2br(e($tl->isi_tindak_lanjut)) !!}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 text-sm italic">Belum ada riwayat.</p>
                    @endforelse
                </div>
            </div>

            <div id="section-komentar" class="bg-white px-8 py-6 hidden transition-all duration-300 border-b border-gray-200">
                <h3 class="font-bold text-gray-800 mb-4">Komentar</h3>
                
                <div id="list-komentar" class="space-y-6 mb-6 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($laporan->komentars as $komen)
                        <div class="flex gap-3">
                            @if($komen->peran == 'instansi')
                                <img src="{{ asset('assets/images/logo-icon.png') }}" class="w-8 h-8 rounded-full border border-gray-200 object-contain p-1">
                            @elseif($komen->peran == 'admin')
                                <img src="{{ asset('assets/images/profil-admin.jpg') }}" class="w-8 h-8 rounded-full">
                            @else
                                <img src="{{ asset('assets/images/profil-pengguna.jpg') }}" class="w-8 h-8 rounded-full">
                            @endif

                            <div class="flex-1">
                                <div class="bg-gray-100 rounded-2xl px-4 py-2 inline-block max-w-[90%]">
                                    <h4 class="font-bold text-xs text-gray-900 mb-1">
                                        {{ $komen->nama_pengomentar ?? 'Pengguna' }}
                                        @if($komen->peran == 'instansi') <i class="ri-building-4-fill text-green-600 ml-1"></i> @endif
                                        @if($komen->peran == 'admin') <i class="ri-verified-badge-fill text-blue-500 ml-1"></i> @endif
                                    </h4>
                                    <p class="text-sm text-gray-800">{{ $komen->isi_komentar }}</p>
                                </div>
                                <div class="text-xs text-gray-400 mt-1 ml-2">{{ $komen->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-400 text-sm">Belum ada komentar.</p>
                    @endforelse
                </div>

                <div class="flex gap-3 items-center border-t border-gray-100 pt-4">
                    <img src="{{ asset('assets/images/logo-icon.png') }}" class="w-8 h-8 rounded-full border border-gray-200 object-contain p-1">
                    <div class="flex-1 relative">
                        <input type="text" id="input-komentar" placeholder="Tulis komentar sebagai Instansi..." 
                               class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-[#145D71] focus:border-[#145D71] block pl-4 pr-12 py-2.5"
                               onkeypress="if(event.key === 'Enter') kirimKomentar({{ $laporan->id }})">
                        <button onclick="kirimKomentar({{ $laporan->id }})" class="absolute right-2 top-1/2 -translate-y-1/2 text-[#145D71] hover:text-[#0F4C5C] p-1 rounded-full transition">
                            <i class="ri-send-plane-fill text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>

            @if($laporan->status != 'selesai')
                <div class="p-8 bg-white flex justify-center">
                    <form id="form-selesai" action="{{ route('instansi.laporan.selesai', $laporan->id) }}" method="POST" class="w-full">
                        @csrf
                        <button type="button" onclick="konfirmasiSelesai()" class="w-full py-3.5 bg-[#27AE60] hover:bg-[#219150] text-white font-bold rounded-xl shadow-md transition-all text-lg flex justify-center items-center gap-2">
                            <i class="ri-check-double-line"></i> Selesaikan Laporan
                        </button>
                    </form>
                </div>
            @else
                <div class="p-6 bg-green-50 text-center border-t border-green-100">
                    <span class="text-green-700 font-bold flex items-center justify-center gap-2">
                        <i class="ri-checkbox-circle-fill text-xl"></i> Laporan Telah Diselesaikan
                    </span>
                </div>
            @endif

        </div>
    </div>
</div>

<script>
    // 1. Toggle Section
    function toggleSection(targetId) {
        const allSections = ['section-tindak-lanjut', 'section-komentar'];
        const targetEl = document.getElementById(targetId);
        const isCurrentlyOpen = !targetEl.classList.contains('hidden');
        allSections.forEach(id => document.getElementById(id).classList.add('hidden'));
        if (!isCurrentlyOpen) {
            targetEl.classList.remove('hidden');
            setTimeout(() => targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
        }
    }

    // 2. Like (URL Instansi)
    function tambahDukungan(id) {
        const btn = document.getElementById('btn-dukung');
        const icon = document.getElementById('icon-dukung');
        const counter = document.getElementById('count-dukung');

        fetch(`/instansi/laporan/${id}/dukung`, { // URL INSTANSI
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                counter.textContent = data.new_count;
                if(data.status === 'liked') {
                    icon.classList.replace('ri-thumb-up-line', 'ri-thumb-up-fill');
                    btn.classList.add('text-[#145D71]');
                } else {
                    icon.classList.replace('ri-thumb-up-fill', 'ri-thumb-up-line');
                    btn.classList.remove('text-[#145D71]');
                }
            }
        });
    }

    // 3. Komentar (URL Instansi)
    function kirimKomentar(id) {
        const input = document.getElementById('input-komentar');
        const container = document.getElementById('list-komentar');
        const isi = input.value.trim();
        if(!isi) return;
        input.disabled = true;

        fetch(`/instansi/laporan/${id}/komentar`, { // URL INSTANSI
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            body: JSON.stringify({ isi_komentar: isi })
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                // HTML Template Komentar Baru
                const html = `
                    <div class="flex gap-3 animate-pulse">
                        <img src="{{ asset('assets/images/logo-icon.png') }}" class="w-8 h-8 rounded-full border border-gray-200 p-1 object-contain">
                        <div class="flex-1">
                            <div class="bg-gray-100 rounded-2xl px-4 py-2 inline-block max-w-[90%]">
                                <h4 class="font-bold text-xs text-gray-900 mb-1">
                                    ${data.komentar.nama} <i class="ri-building-4-fill text-green-600 ml-1"></i>
                                </h4>
                                <p class="text-sm text-gray-800">${data.komentar.isi}</p>
                            </div>
                            <div class="text-xs text-gray-400 mt-1 ml-2">Barusan</div>
                        </div>
                    </div>`;
                container.insertAdjacentHTML('beforeend', html);
                container.scrollTop = container.scrollHeight;
                input.value = '';
                input.disabled = false;
                input.focus();
            }
        });
    }

    function bagikanLaporan() {
        Swal.fire({ title: 'Bagikan', text: 'Fitur bagikan belum aktif', icon: 'info' });
    }

    function konfirmasiSelesai() {
        Swal.fire({
            title: 'Selesaikan Laporan?',
            text: "Pastikan masalah di lapangan benar-benar sudah teratasi.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#27AE60',
            confirmButtonText: 'Ya, Selesai!',
            cancelButtonText: 'Batal'
        }).then((r) => {
            if (r.isConfirmed) document.getElementById('form-selesai').submit();
        });
    }
</script>
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
</style>

@endsection