@extends('layouts.app')

@section('title', 'Notifikasi - SuaraGO')

@section('content')

<div class="container mx-auto px-5 md:px-20 py-10 min-h-screen">
    
    <div class="flex items-center justify-between mb-8 border-b border-gray-200 pb-4">
        <h1 class="text-2xl font-bold text-gray-800">Notifikasi Anda</h1>
        <a href="{{ url('/') }}" class="text-blue-600 font-medium hover:underline">Kembali ke Beranda</a>
    </div>

    <div class="space-y-4 max-w-3xl">
        @forelse($notifikasi as $notif)
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex gap-4 items-start transition hover:bg-gray-50 {{ $notif->is_read ? 'opacity-75' : 'border-l-4 border-l-blue-500' }}">
                
                <div class="flex-shrink-0">
                    @if($notif->tipe == 'success')
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                            <i class="ri-checkbox-circle-line text-xl"></i>
                        </div>
                    @elseif($notif->tipe == 'danger')
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                            <i class="ri-close-circle-line text-xl"></i>
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="ri-information-line text-xl"></i>
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <h3 class="font-bold text-gray-800">{{ $notif->judul }}</h3>
                        <span class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-600 text-sm mt-1">{{ $notif->pesan }}</p>
                    
                    {{-- 
                    <a href="{{ route('laporan.show', $notif->laporan_id) }}" class="text-xs font-bold text-blue-500 mt-2 inline-block hover:underline">
                        Lihat Detail Laporan
                    </a> 
                    --}}
                </div>
                
                @if(!$notif->is_read)
                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                @endif
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-xl border border-dashed border-gray-300">
                <i class="ri-notification-off-line text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">Belum ada notifikasi baru.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection