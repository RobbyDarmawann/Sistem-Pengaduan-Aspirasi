@extends('layouts.app')

@section('title', 'Detail Laporan - SuaraGO')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mx-auto px-5 md:px-20 py-10">
    <div class="w-full max-w-4xl mx-auto">
        
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#3996AF] text-white rounded-lg font-medium hover:bg-[#2C7A90] transition-colors">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 relative">
            
            <div class="p-8 border-b border-gray-100">
                <div class="flex items-start justify-between">
                    <div class="flex gap-4">
                        <img src="{{ $laporan->visibilitas == 'anonim' 
                                    ? asset('assets/images/profil-pengguna.jpg') 
                                    : ($laporan->pengguna->profile_photo_path ? asset('storage/' . $laporan->pengguna->profile_photo_path) : asset('assets/images/profil-pengguna.jpg')) }}" 
                             class="w-14 h-14 rounded-full object-cover border border-gray-200">
                        
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
                        </div>
                    </div>
                    
                    <div class="text-right">
                        @php
                            $statusData = match($laporan->status) {
                                'belum_disetujui' => ['bg-red-100', 'text-red-700', 'Menunggu Verifikasi'],
                                'diproses' => ['bg-yellow-100', 'text-yellow-700', 'Sedang Diproses'],
                                'selesai' => ['bg-green-100', 'text-green-700', 'Selesai'],
                                default => ['bg-gray-100', 'text-gray-700', ucfirst($laporan->status)],
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusData[0] }} {{ $statusData[1] }}">
                            {{ $statusData[2] }}
                        </span>
                    </div>
                </div>

                <div class="mt-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $laporan->judul }}</h1>
                    <p class="text-gray-700 leading-relaxed mb-4 whitespace-pre-line">{{ $laporan->isi_laporan }}</p>
                    
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                        <span class="flex items-center gap-1"><i class="ri-map-pin-line"></i> {{ $laporan->lokasi_kejadian ?? '-' }}</span>
                        <span class="flex items-center gap-1"><i class="ri-price-tag-3-line"></i> {{ $laporan->kategori }}</span>
                        <span class="flex items-center gap-1"><i class="ri-eye-line"></i> {{ $laporan->jumlah_dilihat }}x</span>
                    </div>

                    @if($laporan->lampiran)
                        <img src="{{ asset('storage/' . $laporan->lampiran) }}" class="h-64 w-auto object-cover rounded-lg cursor-pointer hover:opacity-90 transition shadow-sm" onclick="window.open(this.src)">
                    @endif
                </div>
            </div>

            <div class="px-8 py-4 bg-gray-50 border-b border-gray-200 flex flex-wrap gap-6 text-sm font-medium text-gray-600 select-none">
                <button onclick="toggleSection('section-tindak-lanjut')" class="flex items-center gap-2 hover:text-[#3996AF] transition focus:outline-none">
                    <i class="ri-loop-left-line text-lg"></i> 
                    Tindak Lanjut <span class="bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded text-xs">{{ $laporan->tindakLanjuts->count() }}</span>
                </button>

                <button onclick="toggleSection('section-komentar')" class="flex items-center gap-2 hover:text-[#3996AF] transition focus:outline-none">
                    <i class="ri-chat-1-line text-lg"></i> 
                    Komentar <span class="bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded text-xs">{{ $laporan->komentars->count() }}</span>
                </button>

                @auth
                    @php 
                        $isLiked = \App\Models\Dukungan::where('laporan_id', $laporan->id)
                            ->where('user_id', Auth::id())
                            ->where('user_type', 'pengguna')
                            ->exists();
                    @endphp
                    <button id="btn-dukung" onclick="tambahDukungan({{ $laporan->id }})" class="flex items-center gap-2 transition focus:outline-none {{ $isLiked ? 'text-[#3996AF]' : 'hover:text-[#3996AF]' }}">
                        <i class="{{ $isLiked ? 'ri-thumb-up-fill' : 'ri-thumb-up-line' }} text-lg" id="icon-dukung"></i> 
                        Mendukung <span id="count-dukung">{{ $laporan->jumlah_dukungan }}</span>
                    </button>
                @else
                    <button onclick="saranLogin('mendukung')" class="flex items-center gap-2 hover:text-[#3996AF] transition focus:outline-none">
                        <i class="ri-thumb-up-line text-lg"></i> 
                        Mendukung <span id="count-dukung">{{ $laporan->jumlah_dukungan }}</span>
                    </button>
                @endauth
                
                <button onclick="bagikanLaporan()" class="flex items-center gap-2 hover:text-[#3996AF] transition ml-auto focus:outline-none">
                    <i class="ri-share-forward-line text-lg"></i> Bagikan
                </button>
            </div>

            <div id="section-tindak-lanjut" class="bg-white px-8 py-6 border-b border-gray-200 hidden transition-all duration-300">
                <h3 class="font-bold text-gray-800 mb-4">Riwayat Tindak Lanjut</h3>
                
                @auth
                    @if($laporan->pengguna_id == Auth::id() && $laporan->status != 'selesai' && $laporan->status != 'belum_disetujui')
                        <div class="mb-8 bg-blue-50 p-4 rounded-xl border border-blue-100">
                            <form action="{{ route('laporan.tindak-lanjut.store', $laporan->id) }}" method="POST">
                                @csrf
                                <label class="block text-sm font-bold text-blue-800 mb-2">Tanggapi Tindak Lanjut Ini:</label>
                                <textarea name="isi_tindak_lanjut" rows="2" class="w-full p-3 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" placeholder="Contoh: Terima kasih, tim sudah tiba di lokasi..." required></textarea>
                                <div class="text-right mt-2">
                                    <button type="submit" class="bg-[#3996AF] hover:bg-[#2C7A90] text-white px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm">
                                        Kirim Tanggapan
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                @endauth

                <div class="space-y-6">
                    @forelse($laporan->tindakLanjuts()->latest()->get() as $tl)
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                @if($tl->instansi_nama == 'Admin SuaraGO')
                                     @php
                                        $adminData = \App\Models\Admin::first();
                                        $fotoAdmin = $adminData && $adminData->profile_photo_path ? asset('storage/' . $adminData->profile_photo_path) : asset('assets/images/profil-admin.jpg');
                                    @endphp
                                    <img src="{{ $fotoAdmin }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                @elseif($tl->instansi_nama == 'Tanggapan Pelapor')
                                    <img src="{{ $laporan->pengguna->profile_photo_path ? asset('storage/' . $laporan->pengguna->profile_photo_path) : asset('assets/images/profil-pengguna.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                @else
                                    <img src="{{ asset('assets/images/gorontalo.png') }}" class="w-10 h-10 object-contain border border-gray-100 rounded-full p-1">
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-gray-900 text-base">
                                        @if($tl->instansi_nama == 'Tanggapan Pelapor')
                                            {{ $laporan->pengguna->full_name }} <span class="text-xs text-gray-500 font-normal">(Pelapor)</span>
                                        @else
                                            {{ $tl->instansi_nama }}
                                        @endif
                                    </h4>
                                    <span class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($tl->waktu_tindak_lanjut)->format('d M, H:i') }}</span>
                                </div>
                                <p class="text-gray-600 text-sm mt-1 leading-relaxed bg-gray-50 p-3 rounded-lg border border-gray-100">
                                    {!! nl2br(e($tl->isi_tindak_lanjut)) !!}
                                </p>
                            </div>
                        </div>
                        <hr class="border-gray-50 last:hidden">
                    @empty
                        <p class="text-center text-gray-500 text-sm italic">Belum ada riwayat tindak lanjut.</p>
                    @endforelse
                </div>
            </div>

            <div id="section-komentar" class="bg-white px-8 py-6 hidden transition-all duration-300 border-b border-gray-200">
                <h3 class="font-bold text-gray-800 mb-4">Diskusi & Komentar</h3>
                
                <div id="list-komentar" class="space-y-6 mb-6 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($laporan->komentars as $komen)
                        <div class="flex gap-3">
                            @if($komen->peran == 'instansi')
                                <img src="{{ asset('assets/images/logo-icon.png') }}" class="w-8 h-8 rounded-full border border-gray-200 object-contain p-1">
                            @elseif($komen->peran == 'admin')
                                @php
                                    $adminData = \App\Models\Admin::where('full_name', $komen->nama_pengomentar)->first();
                                    $foto = $adminData && $adminData->profile_photo_path ? asset('storage/' . $adminData->profile_photo_path) : asset('assets/images/profil-admin.jpg');
                                @endphp
                                <img src="{{ $foto }}" class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                            @else
                                <img src="{{ $komen->pengguna && $komen->pengguna->profile_photo_path ? asset('storage/' . $komen->pengguna->profile_photo_path) : asset('assets/images/profil-pengguna.jpg') }}" class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                            @endif

                            <div class="flex-1">
                                <div class="bg-gray-100 rounded-2xl px-4 py-2 inline-block max-w-[90%]">
                                    <h4 class="font-bold text-xs text-gray-900 mb-1">
                                        {{ $komen->nama_pengomentar }}
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

                @auth
                    <div class="flex gap-3 items-center border-t border-gray-100 pt-4">
                        <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : asset('assets/images/profil-pengguna.jpg') }}" class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                        <div class="flex-1 relative">
                            <input type="text" id="input-komentar" placeholder="Tulis komentar..." 
                                   class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-[#3996AF] focus:border-[#3996AF] block pl-4 pr-12 py-2.5"
                                   onkeypress="if(event.key === 'Enter') kirimKomentar({{ $laporan->id }})">
                            <button onclick="kirimKomentar({{ $laporan->id }})" class="absolute right-2 top-1/2 -translate-y-1/2 text-[#3996AF] hover:text-[#2C7A90] p-1 rounded-full transition">
                                <i class="ri-send-plane-fill text-lg"></i>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="border-t border-gray-100 pt-4 text-center">
                        <p class="text-gray-500 text-sm mb-2">Ingin ikut berdiskusi?</p>
                        <a href="{{ url('/#masuk') }}" class="inline-block bg-[#3996AF] text-white px-6 py-2 rounded-full font-bold text-sm hover:bg-[#2C7A90] transition">
                            Masuk untuk Berkomentar
                        </a>
                    </div>
                @endauth
            </div>

        </div>
    </div>
</div>

<script>
    // Fungsi Saran Login (SweetAlert)
    function saranLogin(aksi) {
        Swal.fire({
            title: 'Login Diperlukan',
            text: `Anda harus login untuk ${aksi} laporan ini.`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3996AF',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Login Sekarang',
            cancelButtonText: 'Nanti'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ url('/#masuk') }}";
            }
        });
    }

    function toggleSection(targetId) {
        const allSections = ['section-tindak-lanjut', 'section-komentar'];
        const targetEl = document.getElementById(targetId);
        const isCurrentlyOpen = !targetEl.classList.contains('hidden');
        allSections.forEach(id => document.getElementById(id).classList.add('hidden'));
        if (!isCurrentlyOpen) {
            targetEl.classList.remove('hidden');
            setTimeout(() => targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' }), 100);
        }
    }

    // Sisanya sama (tambahDukungan, kirimKomentar, bagikanLaporan)
    // Hanya pastikan tambahDukungan bisa handle error 401 jika tidak pakai saranLogin
    
    function tambahDukungan(id) {
        const btn = document.getElementById('btn-dukung');
        const icon = document.getElementById('icon-dukung');
        const counter = document.getElementById('count-dukung');

        fetch(`/laporan/${id}/dukung`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        })
        .then(r => {
            if(r.status === 401) {
                saranLogin('mendukung');
                return null;
            }
            return r.json();
        })
        .then(data => {
            if(data && data.success) {
                counter.textContent = data.new_count;
                if(data.status === 'liked') {
                    icon.classList.replace('ri-thumb-up-line', 'ri-thumb-up-fill');
                    btn.classList.replace('hover:text-[#3996AF]', 'text-[#3996AF]');
                } else {
                    icon.classList.replace('ri-thumb-up-fill', 'ri-thumb-up-line');
                    btn.classList.remove('text-[#3996AF]');
                    btn.classList.add('hover:text-[#3996AF]');
                }
            }
        });
    }

    function kirimKomentar(id) {
        // ... (Kode kirim komentar sama seperti sebelumnya) ...
        const input = document.getElementById('input-komentar');
        const container = document.getElementById('list-komentar');
        const isi = input.value.trim();
        if(!isi) return;
        input.disabled = true;

        fetch(`/laporan/${id}/komentar`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            body: JSON.stringify({ isi_komentar: isi })
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                const html = `
                    <div class="flex gap-3 animate-pulse">
                        <img src="${data.komentar.foto}" class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                        <div class="flex-1">
                            <div class="bg-gray-100 rounded-2xl px-4 py-2 inline-block max-w-[90%]">
                                <h4 class="font-bold text-xs text-gray-900 mb-1">${data.komentar.nama}</h4>
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
        Swal.fire({ title: 'Bagikan', text: 'Link tersalin!', icon: 'success', timer: 1500, showConfirmButton: false });
        navigator.clipboard.writeText(window.location.href);
    }
</script>
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
</style>

@endsection