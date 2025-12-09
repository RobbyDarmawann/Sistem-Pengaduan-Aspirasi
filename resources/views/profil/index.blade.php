@extends('layouts.app')

@section('title', 'Profil Saya - SuaraGO')

@section('content')

<div class="relative pt-16 pb-12 bg-[#5D9FD6]" 
     style="{{ $user->cover_photo_path ? 'background-image: url('.asset('storage/'.$user->cover_photo_path).'); background-size: cover; background-position: center;' : '' }}">
    
    @if($user->cover_photo_path) <div class="absolute inset-0 bg-[#5D9FD6]/80"></div> @endif

    <div class="container mx-auto px-5 md:px-20 relative z-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 text-white">
            
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="relative">
                    <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('assets/images/profil-pengguna.jpg') }}" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-white bg-white">
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-2xl font-bold">{{ $user->full_name }}</h1>
                </div>
            </div>

            <div class="flex items-center gap-12">
                <div class="flex gap-10 text-center">
                    @if($user->show_pengaduan)
                    <div>
                        <span class="block text-lg font-medium">Laporan</span>
                        <span class="block text-2xl font-bold">{{ $laporanCount }}</span>
                    </div>
                    @endif
                    @if($user->show_aspirasi)
                    <div>
                        <span class="block text-lg font-medium">Aspirasi</span>
                        <span class="block text-2xl font-bold">{{ $aspirasiCount }}</span>
                    </div>
                    @endif
                </div>
                <div>
                    <a href="{{ route('profil.edit') }}" class="px-6 py-2 border border-white rounded-lg font-medium hover:bg-white/10 transition text-white">
                        Ubah Profil
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="container mx-auto px-5 md:px-20 py-10">
    
    <div class="text-center mb-8 relative">
        <h2 class="text-xl font-bold text-black inline-block border-b-2 border-black pb-1">Daftar Laporan dan Aspirasi Anda</h2>
    </div>

    <div class="flex flex-col md:flex-row border-2 border-[#5D9FD6] rounded-t-lg overflow-hidden">
        
        <div class="w-full md:w-1/4 bg-[#5D9FD6] text-white flex flex-col min-h-[500px]">
            <div class="py-4 text-center font-bold text-lg border-b border-white/30">
                Filter
            </div>
            <nav class="flex flex-col font-bold text-sm md:text-base">
                <a href="{{ route('profil.index', ['tab' => 'all', 'type' => $type]) }}" 
                   class="px-6 py-4 hover:bg-white/20 border-b border-white/30 transition {{ $tab == 'all' ? 'bg-white/20' : '' }}">
                    Semua Unggahan
                </a>
                <a href="{{ route('profil.index', ['tab' => 'pending', 'type' => $type]) }}" 
                   class="px-6 py-4 hover:bg-white/20 border-b border-white/30 transition {{ $tab == 'pending' ? 'bg-white/20' : '' }}">
                    Menunggu Persetujuan
                </a>
                <a href="{{ route('profil.index', ['tab' => 'process', 'type' => $type]) }}" 
                   class="px-6 py-4 hover:bg-white/20 border-b border-white/30 transition {{ $tab == 'process' ? 'bg-white/20' : '' }}">
                    Menunggu Tanggapan
                </a>
                <a href="{{ route('profil.index', ['tab' => 'finished', 'type' => $type]) }}" 
                   class="px-6 py-4 hover:bg-white/20 border-b border-white/30 transition {{ $tab == 'finished' ? 'bg-white/20' : '' }}">
                    Selesai Ditanggapi
                </a>
            </nav>
        </div>

        <div class="w-full md:w-3/4 bg-[#ECF6FC] flex flex-col">
            
            <div class="flex bg-[#5D9FD6] text-white font-bold text-lg text-center">
                <a href="{{ route('profil.index', ['type' => 'aspirasi', 'tab' => $tab]) }}" 
                   class="w-1/2 py-3 border-r border-white/30 hover:bg-white/10 transition {{ $type == 'aspirasi' ? 'bg-[#ECF6FC] text-[#5D9FD6]' : '' }}">
                    Aspirasi
                </a>
                <a href="{{ route('profil.index', ['type' => 'pengaduan', 'tab' => $tab]) }}" 
                   class="w-1/2 py-3 hover:bg-white/10 transition {{ $type == 'pengaduan' ? 'bg-[#ECF6FC] text-[#5D9FD6]' : '' }}">
                    Laporan
                </a>
            </div>

            <div class="p-6 space-y-4 flex-1">
                @forelse($laporans as $item)
                    
                    <a href="{{ route('laporan.show', $item->id) }}" class="block group cursor-pointer">
                        
                        <div class="bg-white rounded-xl border-2 border-[#5D9FD6] p-4 flex flex-col md:flex-row gap-4 items-center relative shadow-sm group-hover:shadow-md transition transform group-hover:-translate-y-1">
                            
                            <div class="flex flex-col items-center w-24 flex-shrink-0">
                                <img src="{{ $item->visibilitas == 'anonim' ? asset('assets/images/profil-pengguna.jpg') : ($user->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : asset('assets/images/profil-pengguna.jpg')) }}" 
                                     class="w-16 h-16 rounded-full object-cover border border-gray-300 mb-2">
                                <span class="text-sm font-bold text-gray-700 text-center break-words w-full">
                                    {{ $item->visibilitas == 'anonim' ? 'Anonim' : explode(' ', $user->full_name)[0] }}
                                </span>
                            </div>

                            <div class="flex-1 border-l border-gray-200 pl-4 py-1 w-full overflow-hidden">
                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                    <div class="flex items-center gap-2">
                                        <i class="ri-calendar-line"></i> {{ $item->created_at->format('d F, H:i') }}
                                    </div>
                                    <div class="font-mono">Tracking ID: #{{ $item->id . Str::random(3) }}</div>
                                </div>

                                <h3 class="font-bold text-lg text-black mb-1 leading-snug truncate group-hover:text-[#3282B8] transition-colors">{{ $item->judul }}</h3>
                                <p class="text-sm text-gray-700 mb-2 line-clamp-2">{{ $item->isi_laporan }}</p>
                                
                                <div class="text-xs text-gray-600 truncate">
                                    Terdisposisi ke <span class="font-bold">{{ $item->instansi_tujuan }}</span>
                                </div>
                            </div>

                            <div class="flex-shrink-0 w-32 flex justify-center">
                                @php
                                    $badgeClass = match($item->status) {
                                        'belum_disetujui' => 'bg-gray-200 text-gray-700',
                                        'diproses' => 'bg-[#FFC107] text-white border-2 border-[#FFC107]',
                                        'selesai' => 'bg-green-500 text-white',
                                        default => 'bg-red-500 text-white'
                                    };
                                    $statusText = match($item->status) {
                                        'belum_disetujui' => 'Menunggu',
                                        'diproses' => 'Sedang Diproses',
                                        'selesai' => 'Selesai',
                                        default => 'Ditolak'
                                    };
                                @endphp
                                <span class="{{ $badgeClass }} font-bold px-2 py-3 rounded-lg text-xs text-center w-full block shadow-sm leading-tight">
                                    {!! str_replace(' ', '<br>', $statusText) !!}
                                </span>
                            </div>

                        </div>
                    </a>
                    @empty
                    <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                        <p>Belum ada data {{ $type }} di sini.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection