@extends('layouts.app')

@section('title', 'Jelajah Laporan - SuaraGO')

@section('content')

<div class="bg-[#1977B1] pt-24 pb-16">
    <div class="container mx-auto px-5 md:px-20 text-center">
        <h1 class="text-3xl font-bold text-white mb-6">Jelajah Laporan Publik</h1>
        
        <form action="{{ route('laporan.public') }}" method="GET" class="bg-white p-4 rounded-xl shadow-lg max-w-4xl mx-auto">
            <div class="flex flex-col md:flex-row gap-4">
                
                <div class="flex-1 relative">
                    <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full pl-12 pr-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                           placeholder="Cari kata kunci laporan...">
                </div>

                <div class="md:w-1/4">
                    <select name="tipe" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none cursor-pointer">
                        <option value="all">Semua Tipe</option>
                        <option value="pengaduan" {{ request('tipe') == 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                        <option value="aspirasi" {{ request('tipe') == 'aspirasi' ? 'selected' : '' }}>Aspirasi</option>
                    </select>
                </div>

                <div class="md:w-1/3 relative group">
                     <select name="instansi" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none cursor-pointer appearance-none">
                        <option value="all">Semua Instansi</option>
                        @foreach($listInstansi as $ins)
                            <option value="{{ $ins }}" {{ request('instansi') == $ins ? 'selected' : '' }}>{{ $ins }}</option>
                        @endforeach
                    </select>
                    <i class="ri-arrow-down-s-line absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>

                <button type="submit" class="bg-[#0F4C75] hover:bg-[#0B3C5D] text-white px-8 py-3 rounded-lg font-bold transition shadow-md">
                    Cari
                </button>

            </div>
        </form>
    </div>
</div>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-5 md:px-20">
        
        @if(request('search') || request('tipe') != 'all' || request('instansi') != 'all')
            <div class="mb-6 text-gray-600">
                Menampilkan hasil untuk: 
                @if(request('search')) <span class="font-bold text-black">"{{ request('search') }}"</span> @endif
                @if(request('tipe') != 'all') <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded ml-2">{{ ucfirst(request('tipe')) }}</span> @endif
                @if(request('instansi') != 'all') <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded ml-2">{{ request('instansi') }}</span> @endif
                <a href="{{ route('laporan.public') }}" class="text-red-500 text-sm hover:underline ml-4"><i class="ri-close-circle-line"></i> Reset Filter</a>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($laporans as $item)
                
                <a href="{{ route('laporan.show', $item->id) }}" class="block group">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300 h-full flex flex-col">
                        
                        <div class="p-5 flex items-center gap-4 border-b border-gray-50">
                            <img src="{{ $item->visibilitas == 'anonim' ? asset('assets/images/logo-icon.png') : ($item->pengguna->profile_photo_path ? asset('storage/'.$item->pengguna->profile_photo_path) : asset('assets/images/profil-pengguna.jpg')) }}" 
                                 class="w-10 h-10 rounded-full object-cover border border-gray-100">
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">
                                    {{ $item->visibilitas == 'anonim' ? 'Anonim' : explode(' ', $item->pengguna->full_name)[0] }}
                                </h4>
                                <p class="text-xs text-gray-400">{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="ml-auto">
                                @if($item->tipe_laporan == 'pengaduan')
                                    <span class="text-[10px] font-bold bg-red-50 text-red-600 px-2 py-1 rounded border border-red-100">PENGADUAN</span>
                                @else
                                    <span class="text-[10px] font-bold bg-blue-50 text-blue-600 px-2 py-1 rounded border border-blue-100">ASPIRASI</span>
                                @endif
                            </div>
                        </div>

                        @if($item->lampiran)
                            <div class="h-48 overflow-hidden bg-gray-100">
                                <img src="{{ asset('storage/' . $item->lampiran) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            </div>
                        @endif

                        <div class="p-5 flex-1">
                            <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-[#1977B1] transition">{{ $item->judul }}</h3>
                            <p class="text-gray-600 text-sm line-clamp-3 leading-relaxed">{{ $item->isi_laporan }}</p>
                            
                            <div class="mt-4 flex items-center gap-2 text-xs text-gray-500 bg-gray-50 p-2 rounded">
                                <i class="ri-building-4-line"></i>
                                <span class="truncate">{{ $item->instansi_tujuan }}</span>
                            </div>
                        </div>

                        <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center text-sm">
                            <div class="flex gap-4 text-gray-500">
                                <span class="flex items-center gap-1" title="Dukungan">
                                    <i class="ri-thumb-up-line"></i> {{ $item->jumlah_dukungan }}
                                </span>
                                
                                <span class="flex items-center gap-1" title="Komentar">
                                    <i class="ri-chat-1-line"></i> {{ $item->komentars->count() }}
                                </span>

                                <span class="flex items-center gap-1 text-blue-600 font-medium" title="Dilihat">
                                    <i class="ri-eye-line"></i> {{ $item->jumlah_dilihat }}
                                </span>
                            </div>

                            <div>
                                @if($item->status == 'selesai')
                                    <span class="text-xs font-bold text-green-600 flex items-center gap-1"><i class="ri-checkbox-circle-fill"></i> Selesai</span>
                                @elseif($item->status == 'diproses')
                                    <span class="text-xs font-bold text-yellow-600 flex items-center gap-1"><i class="ri-loader-4-fill"></i> Diproses</span>
                                @else
                                    <span class="text-xs font-bold text-gray-500">Menunggu</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20">
                    <div class="inline-block p-6 bg-white rounded-full shadow-sm mb-4">
                        <i class="ri-search-2-line text-5xl text-gray-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700">Tidak ada laporan ditemukan.</h3>
                    <p class="text-gray-500 mt-1">Coba gunakan kata kunci lain atau reset filter.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $laporans->links() }}
        </div>

    </div>
</div>

@endsection