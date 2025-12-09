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
                                <span><i class="ri-calendar-line mr-1"></i> {{ $laporan->created_at->format('d F Y, H:i') }}</span>
                                <span class="text-gray-300">|</span>
                                <span>Tracking ID: #{{ $laporan->id . Str::random(3) }}</span>
                            </div>
                            <div class="text-sm text-gray-600 mt-1">
                                Terdisposisi ke <span class="font-bold text-blue-600">{{ ucwords(str_replace('_', ' ', $laporan->instansi_tujuan)) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        @if($laporan->status == 'selesai')
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Selesai</span>
                        @else
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Sedang Diproses</span>
                        @endif
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

            <div class="px-8 py-4 bg-gray-50 border-b border-gray-200 flex flex-wrap gap-6 text-sm font-medium text-gray-600 select-none">
                
                <button id="btn-tindak-lanjut" onclick="toggleSection('section-tindak-lanjut')" class="flex items-center gap-2 hover:text-blue-600 transition focus:outline-none">
                    <i class="ri-loop-left-line text-lg"></i> 
                    Tindak Lanjut <span class="bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded text-xs">{{ $laporan->tindakLanjuts->count() }}</span>
                </button>

                <button id="btn-komentar" onclick="toggleSection('section-komentar')" class="flex items-center gap-2 hover:text-blue-600 transition focus:outline-none">
                    <i class="ri-chat-1-line text-lg"></i> 
                    Komentar <span class="bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded text-xs">{{ $laporan->komentars->count() }}</span>
                </button>

                @php 
                    $isLiked = \App\Models\Dukungan::where('laporan_id', $laporan->id)
                        ->where('user_id', Auth::guard('admin')->user()->aid)
                        ->where('user_type', 'admin')
                        ->exists();
                @endphp

                <button id="btn-dukung" onclick="tambahDukungan({{ $laporan->id }})" 
                        class="flex items-center gap-2 transition focus:outline-none {{ $isLiked ? 'text-blue-600' : 'hover:text-blue-600' }}">
                    <i class="{{ $isLiked ? 'ri-thumb-up-fill' : 'ri-thumb-up-line' }} text-lg" id="icon-dukung"></i> 
                    Mendukung <span id="count-dukung">{{ $laporan->jumlah_dukungan }}</span>
                </button>

                <button onclick="bagikanLaporan()" class="flex items-center gap-2 hover:text-blue-600 transition ml-auto focus:outline-none">
                    <i class="ri-share-forward-line text-lg"></i> Bagikan
                </button>
            </div>

            <div id="section-tindak-lanjut" class="bg-white px-8 py-6 border-b border-gray-200 hidden transition-all duration-300">
                
                <div class="flex items-center gap-2 mb-6 pb-2 border-b border-gray-100">
                    <i class="ri-history-line text-gray-500"></i>
                    <span class="text-sm font-bold text-gray-600">Riwayat Progres</span>
                    <span class="bg-blue-100 text-blue-600 text-xs px-2 py-0.5 rounded-full font-bold ml-auto">
                        {{ $laporan->tindakLanjuts->count() }} Aktivitas
                    </span>
                </div>
                
                <div class="space-y-6">
                    @forelse($laporan->tindakLanjuts as $tl)
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                @if($tl->instansi_nama == 'Tanggapan Pelapor')
                                    @if($laporan->visibilitas == 'anonim')
                                        <img src="{{ asset('assets/images/profil-pengguna.jpg') }}" class="w-10 h-10 rounded-full border border-gray-200 object-contain p-1">
                                    @else
                                        <img src="{{ $laporan->pengguna->profile_photo_path ? asset('storage/' . $laporan->pengguna->profile_photo_path) : asset('assets/images/profil-pengguna.jpg') }}" 
                                             class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                    @endif
                                @elseif($tl->instansi_nama == 'Admin SuaraGO')
                                    <img src="{{ Auth::guard('admin')->user()->profile_photo_path ? asset('storage/' . Auth::guard('admin')->user()->profile_photo_path) : asset('assets/images/profil-admin.jpg') }}" 
                                         class="w-10 h-10 rounded-full object-cover border border-gray-200">   
                                @else
                                    <img src="{{ asset('assets/images/gorontalo.png') }}" class="w-10 h-10 object-contain border border-gray-100 rounded-full p-1">
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-gray-900 text-base">{{ $tl->instansi_nama }}</h4>
                                    <span class="text-xs text-gray-400 mt-1">
                                        {{ \Carbon\Carbon::parse($tl->waktu_tindak_lanjut)->format('d M, H:i') }}
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 text-sm mt-1 leading-relaxed">
                                    @php
                                        $isi = $tl->isi_tindak_lanjut;
                                        $isi = str_replace('Laporan didisposisikan ke', 'Laporan didisposisikan ke <span class="font-bold text-gray-800">', $isi);
                                        if(str_contains($isi, '<span')) $isi .= '</span>'; 
                                    @endphp
                                    {!! $isi !!}
                                </p>
                            </div>
                        </div>
                        <hr class="border-gray-50 last:hidden">
                    @empty
                        <div class="text-center py-8">
                            <div class="inline-block p-3 bg-gray-50 rounded-full mb-2">
                                <i class="ri-inbox-line text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-500 text-sm">Belum ada tindak lanjut.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div id="section-komentar" class="bg-white px-8 py-6 hidden transition-all duration-300 border-b border-gray-200">
                <h3 class="font-bold text-gray-800 mb-4">Komentar</h3>
                
                <div id="list-komentar" class="space-y-6 mb-6 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($laporan->komentars as $komen)
                        <div class="flex gap-3">
                            @if($komen->peran == 'admin')
                                <img src="{{ Auth::guard('admin')->user()->profile_photo_path ? asset('storage/' . Auth::guard('admin')->user()->profile_photo_path) : asset('assets/images/profil-admin.jpg') }}" class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                            @else
                                <img src="{{ asset('assets/images/profil-pengguna.jpg') }}" class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                            @endif

                            <div class="flex-1">
                                <div class="bg-gray-100 rounded-2xl px-4 py-2 inline-block max-w-[90%]">
                                    <h4 class="font-bold text-xs text-gray-900 mb-1">
                                        {{ $komen->nama_pengomentar ?? 'Pengguna' }}
                                        @if($komen->peran == 'admin') 
                                            <i class="ri-verified-badge-fill text-blue-500 ml-1" title="Admin"></i> 
                                        @endif
                                    </h4>
                                    <p class="text-sm text-gray-800">{{ $komen->isi_komentar }}</p>
                                </div>
                                <div class="text-xs text-gray-400 mt-1 ml-2">
                                    {{ $komen->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="ri-chat-smile-2-line text-4xl text-gray-200"></i>
                            <p class="text-gray-400 text-sm mt-2">Belum ada komentar. Jadilah yang pertama!</p>
                        </div>
                    @endforelse
                </div>

                <div class="flex gap-3 items-center border-t border-gray-100 pt-4">
                    <img id="img-input-admin" src="{{ Auth::guard('admin')->user()->profile_photo_path ? asset('storage/' . Auth::guard('admin')->user()->profile_photo_path) : asset('assets/images/profil-admin.jpg') }}" 
                         class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                    
                    <div class="flex-1 relative">
                        <input type="text" id="input-komentar" placeholder="Tulis komentar sebagai Admin..." 
                               class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-blue-500 focus:border-blue-500 block pl-4 pr-12 py-2.5"
                               onkeypress="if(event.key === 'Enter') kirimKomentar({{ $laporan->id }})">
                        
                        <button onclick="kirimKomentar({{ $laporan->id }})" 
                                class="absolute right-2 top-1/2 -translate-y-1/2 text-blue-600 hover:text-blue-800 p-1 rounded-full hover:bg-blue-50 transition">
                            <i class="ri-send-plane-fill text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>

            @if($laporan->status != 'selesai')
                <div class="p-8 bg-white flex justify-center">
                    <form id="form-selesai" action="{{ route('admin.laporan.selesai', $laporan->id) }}" method="POST" class="w-full">
                        @csrf
                        <button type="button" onclick="konfirmasiSelesai()" class="w-full py-3.5 bg-[#1565C0] hover:bg-[#0D47A1] text-white font-bold rounded-xl shadow-md transition-all text-lg flex justify-center items-center gap-2">
                            <i class="ri-check-double-line"></i> Selesaikan Postingan
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
    // 1. TOGGLE SECTION
    function toggleSection(targetId) {
        const allSections = ['section-tindak-lanjut', 'section-komentar'];
        const targetEl = document.getElementById(targetId);
        const isCurrentlyOpen = !targetEl.classList.contains('hidden');

        allSections.forEach(id => {
            document.getElementById(id).classList.add('hidden');
        });

        if (!isCurrentlyOpen) {
            targetEl.classList.remove('hidden');
            setTimeout(() => {
                targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }
    }

    // 2. AJAX DUKUNGAN
    function tambahDukungan(id) {
        const btn = document.getElementById('btn-dukung');
        const icon = document.getElementById('icon-dukung');
        const counter = document.getElementById('count-dukung');

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
                if (data.status === 'liked') {
                    icon.classList.remove('ri-thumb-up-line');
                    icon.classList.add('ri-thumb-up-fill');
                    btn.classList.add('text-blue-600');
                } else {
                    icon.classList.remove('ri-thumb-up-fill');
                    icon.classList.add('ri-thumb-up-line');
                    btn.classList.remove('text-blue-600');
                }
            }
        });
    }

    // 3. KIRIM KOMENTAR (Perbaikan di sini agar tidak error sintaks)
    function kirimKomentar(id) {
        const input = document.getElementById('input-komentar');
        const container = document.getElementById('list-komentar');
        const adminImgSrc = document.getElementById('img-input-admin').src; // Ambil URL foto dari elemen HTML yang sudah ada
        const isi = input.value.trim();

        if (!isi) return;

        input.disabled = true;

        fetch(`/admin/laporan/${id}/komentar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ isi_komentar: isi })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Kita gunakan Template Literal JS (bukan Blade) di sini
                const htmlBaru = `
                    <div class="flex gap-3 animate-pulse"> 
                        <img src="${adminImgSrc}" class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                        <div class="flex-1">
                            <div class="bg-gray-100 rounded-2xl px-4 py-2 inline-block max-w-[90%]">
                                <h4 class="font-bold text-xs text-gray-900 mb-1">
                                    ${data.komentar.nama} 
                                    <i class="ri-verified-badge-fill text-blue-500 ml-1"></i>
                                </h4>
                                <p class="text-sm text-gray-800">${data.komentar.isi}</p>
                            </div>
                            <div class="text-xs text-gray-400 mt-1 ml-2">
                                Barusan
                            </div>
                        </div>
                    </div>
                `;

                if(container.innerHTML.includes('Belum ada komentar')) {
                    container.innerHTML = '';
                }
                
                container.insertAdjacentHTML('beforeend', htmlBaru);
                container.scrollTop = container.scrollHeight;

                input.value = '';
                input.disabled = false;
                input.focus();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            input.disabled = false;
            Swal.fire('Error', 'Gagal mengirim komentar.', 'error');
        });
    }

    function bagikanLaporan() {
        Swal.fire({
            title: 'Bagikan Laporan',
            showCloseButton: true,
            showConfirmButton: false,
            html: `
                <div class="flex justify-center gap-4 mt-2 mb-4">
                    <button class="w-12 h-12 bg-green-500 text-white rounded-full hover:scale-110 transition"><i class="ri-whatsapp-line text-2xl"></i></button>
                    <button class="w-12 h-12 bg-blue-600 text-white rounded-full hover:scale-110 transition"><i class="ri-facebook-fill text-2xl"></i></button>
                    <button class="w-12 h-12 bg-black text-white rounded-full hover:scale-110 transition"><i class="ri-twitter-x-line text-2xl"></i></button>
                    <button class="w-12 h-12 bg-gray-200 text-gray-700 rounded-full hover:scale-110 transition" onclick="copyLink()"><i class="ri-link text-2xl"></i></button>
                </div>
            `
        });
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href);
        Swal.showValidationMessage('Link tersalin!');
    }

    function konfirmasiSelesai() {
        Swal.fire({
            title: 'Selesaikan Postingan?',
            text: "Pastikan semua tindak lanjut telah dilakukan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1565C0',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Selesai!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-selesai').submit();
            }
        });
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #aaa; }
</style>

@endsection