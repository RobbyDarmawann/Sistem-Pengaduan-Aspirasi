@extends('layouts.admin')

@section('title', 'Progres Laporan')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="flex justify-center pb-20">
    <div class="w-full max-w-4xl">
        
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('admin.laporan.index') }}" class="px-4 py-2 bg-[#3282B8] text-white rounded-lg font-medium hover:bg-[#1B6CA8] transition-colors flex items-center gap-2">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 relative">
            
            <div class="p-8 border-b border-gray-100">
                <div class="flex items-start justify-between">
                    <div class="flex gap-4">
                        <img src="{{ asset('assets/images/profil-pengguna.jpg') }}" alt="User" class="w-14 h-14 rounded-full object-cover border border-gray-200">
                        
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-bold text-gray-800 text-lg">{{ $laporan->visibilitas == 'anonim' ? 'Anonim' : $laporan->pengguna->full_name }}</h3>
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full flex items-center gap-1 font-medium">
                                    <i class="ri-check-line text-green-500"></i> Terverifikasi
                                </span>
                            </div>
                            
                            <div class="text-sm text-gray-500 flex items-center gap-3">
                                <span><i class="ri-calendar-line mr-1"></i> {{ $laporan->created_at->format('d F, H:i') }}</span>
                                <span class="text-gray-300">|</span>
                                <span>Tracking ID: #{{ $laporan->id . Str::random(4) }}</span>
                            </div>

                            <div class="text-sm text-gray-600 mt-1">
                                Terdisposisi ke <span class="font-bold">{{ ucwords(str_replace('_', ' ', $laporan->instansi_tujuan)) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right text-sm text-gray-500">
                        {{ $laporan->updated_at->format('d M, H:i') }}
                    </div>
                </div>

                <div class="mt-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $laporan->judul }}</h1>
                    <p class="text-gray-700 leading-relaxed mb-4 whitespace-pre-line">{{ $laporan->isi_laporan }}</p>
                    
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                        <span class="flex items-center gap-1"><i class="ri-map-pin-line"></i> {{ $laporan->lokasi_kejadian ?? 'Lokasi tidak disebut' }}</span>
                        <span class="flex items-center gap-1"><i class="ri-price-tag-3-line"></i> {{ ucwords(str_replace('_', ' ', $laporan->kategori)) }}</span>
                        <span class="flex items-center gap-1"><i class="ri-eye-line"></i> {{ $laporan->jumlah_dilihat }}x dilihat</span>
                    </div>

                    @if($laporan->lampiran)
                        <div class="flex gap-3 overflow-hidden rounded-lg mt-4">
                            <img src="{{ asset('storage/' . $laporan->lampiran) }}" class="h-48 w-auto object-cover rounded-lg cursor-pointer hover:opacity-90 transition" onclick="window.open(this.src)">
                        </div>
                    @endif
                </div>
            </div>

            <div class="px-8 py-4 bg-gray-50 border-b border-gray-200 flex flex-wrap gap-6 text-sm font-medium text-gray-600">
                
                <button onclick="scrollToSection('section-tindak-lanjut')" class="flex items-center gap-2 hover:text-blue-600 transition">
                    <i class="ri-loop-left-line text-lg"></i> 
                    Tindak Lanjut <span class="bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded text-xs">{{ $laporan->tindakLanjuts->count() }}</span>
                </button>

                <button onclick="toggleKomentar()" class="flex items-center gap-2 hover:text-blue-600 transition">
                    <i class="ri-chat-1-line text-lg"></i> 
                    Komentar <span class="bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded text-xs">{{ $laporan->komentars->count() }}</span>
                </button>

                <button id="btn-dukung" onclick="tambahDukungan({{ $laporan->id }})" class="flex items-center gap-2 hover:text-blue-600 transition">
                    <i class="ri-thumb-up-line text-lg" id="icon-dukung"></i> 
                    Mendukung <span id="count-dukung">{{ $laporan->jumlah_dukungan }}</span>
                </button>

                <button onclick="bagikanLaporan()" class="flex items-center gap-2 hover:text-blue-600 transition ml-auto">
                    <i class="ri-share-forward-line text-lg"></i> Bagikan
                </button>
            </div>

            <div id="section-tindak-lanjut" class="bg-gray-50 px-8 py-6 border-b border-gray-200">
                <h3 class="font-bold text-gray-800 mb-4">Riwayat Tindak Lanjut</h3>
                
                <div class="space-y-4">
                    @forelse($laporan->tindakLanjuts as $tl)
                        <div class="flex gap-4">
                            <img src="{{ asset('assets/images/logo-icon.png') }}" class="w-10 h-10 rounded-full bg-white p-1 border">
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-gray-900 text-sm">{{ $tl->instansi_nama }}</h4>
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($tl->waktu_tindak_lanjut)->format('d M, H:i') }}</span>
                                </div>
                                <div class="text-xs text-gray-500 mb-1">Laporan didisposisikan</div>
                                <p class="text-sm text-gray-700 bg-white p-3 rounded-lg border border-gray-200 shadow-sm mt-1">
                                    {{ $tl->isi_tindak_lanjut }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 text-sm italic py-4">Belum ada tindak lanjut dari instansi.</p>
                    @endforelse
                </div>
            </div>

            <div id="section-komentar" class="bg-white px-8 py-6 hidden transition-all duration-300">
                <h3 class="font-bold text-gray-800 mb-4">Komentar</h3>
                
                <div class="space-y-6 mb-6 max-h-96 overflow-y-auto pr-2">
                    @forelse($laporan->komentars as $komen)
                        <div class="flex gap-3">
                            @if($komen->peran == 'admin')
                                <img src="{{ asset('assets/images/logo-icon.png') }}" class="w-8 h-8 rounded-full">
                            @else
                                <img src="{{ asset('assets/images/profil-pengguna.jpg') }}" class="w-8 h-8 rounded-full">
                            @endif

                            <div class="flex-1">
                                <div class="bg-gray-100 rounded-2xl px-4 py-2 inline-block">
                                    <h4 class="font-bold text-xs text-gray-900">
                                        {{ $komen->nama_pengomentar ?? 'Pengguna' }}
                                        @if($komen->peran == 'admin') <i class="ri-verified-badge-fill text-blue-500 ml-1"></i> @endif
                                    </h4>
                                    <p class="text-sm text-gray-800">{{ $komen->isi_komentar }}</p>
                                </div>
                                <div class="text-xs text-gray-500 mt-1 ml-2">
                                    {{ $komen->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-400 text-sm py-4">Belum ada komentar.</p>
                    @endforelse
                </div>

                <div class="bg-gray-50 p-4 rounded-lg flex gap-3 items-center border border-gray-200">
                    <img src="{{ asset('assets/images/logo-icon.png') }}" class="w-8 h-8 rounded-full">
                    <input type="text" placeholder="Tulis komentar sebagai Admin..." class="flex-1 bg-transparent border-none focus:ring-0 text-sm">
                    <button class="text-[#3282B8] font-bold text-sm hover:underline">Kirim</button>
                </div>
            </div>

            @if($laporan->status != 'selesai')
                <div class="p-8 border-t border-gray-200 flex justify-center bg-white">
                    <form id="form-selesai" action="{{ route('admin.laporan.selesai', $laporan->id) }}" method="POST" class="w-full">
                        @csrf
                        <button type="button" onclick="konfirmasiSelesai()" class="w-full py-3 bg-[#1565C0] hover:bg-[#0D47A1] text-white font-bold rounded-lg shadow-md transition-all text-lg">
                            Selesaikan Postingan
                        </button>
                    </form>
                </div>
            @else
                <div class="p-6 bg-green-50 text-center border-t border-green-100">
                    <span class="text-green-700 font-bold flex items-center justify-center gap-2">
                        <i class="ri-checkbox-circle-fill text-xl"></i> Postingan Telah Diselesaikan
                    </span>
                </div>
            @endif

        </div>
    </div>
</div>

<script>
    // 1. Scroll ke Bagian Tertentu
    function scrollToSection(id) {
        const element = document.getElementById(id);
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Efek highlight
        element.classList.add('bg-blue-50');
        setTimeout(() => {
            if(id !== 'section-tindak-lanjut') element.classList.remove('bg-blue-50');
        }, 1000);
    }

    // 2. Toggle (Buka/Tutup) Komentar
    function toggleKomentar() {
        const section = document.getElementById('section-komentar');
        if (section.classList.contains('hidden')) {
            section.classList.remove('hidden');
            scrollToSection('section-komentar');
        } else {
            section.classList.add('hidden');
        }
    }

    function tambahDukungan(id) {
        const btn = document.getElementById('btn-dukung');
        const icon = document.getElementById('icon-dukung');
        const counter = document.getElementById('count-dukung');

        // Ubah UI langsung biar responsif
        icon.classList.remove('ri-thumb-up-line');
        icon.classList.add('ri-thumb-up-fill');
        btn.classList.add('text-blue-600');

        fetch(`/admin/laporan/${id}/dukung`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                counter.textContent = data.new_count;
            }
        });
    }

    function bagikanLaporan() {
        Swal.fire({
            title: 'Bagikan Laporan',
            text: 'Pilih media sosial untuk membagikan:',
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonText: 'Tutup',
            html: `
                <div class="flex justify-center gap-4 mt-4">
                    <button class="p-3 bg-green-500 text-white rounded-full"><i class="ri-whatsapp-line text-2xl"></i></button>
                    <button class="p-3 bg-blue-600 text-white rounded-full"><i class="ri-facebook-fill text-2xl"></i></button>
                    <button class="p-3 bg-blue-400 text-white rounded-full"><i class="ri-twitter-x-line text-2xl"></i></button>
                    <button class="p-3 bg-gray-700 text-white rounded-full"><i class="ri-link text-2xl"></i></button>
                </div>
            `
        });
    }

    function konfirmasiSelesai() {
        Swal.fire({
            title: 'Selesaikan Postingan?',
            text: "Laporan akan ditandai sebagai selesai dan tidak dapat diubah lagi.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1565C0',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Selesaikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-selesai').submit();
            }
        });
    }
</script>

@endsection