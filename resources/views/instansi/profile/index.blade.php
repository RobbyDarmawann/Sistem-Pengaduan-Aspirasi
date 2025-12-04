@extends('layouts.instansi')

@section('title', 'Profil')

@section('content')

<div class="flex justify-center items-center min-h-[80vh]">
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-200">
        
        <div class="pt-12 pb-8 flex flex-col items-center bg-gray-50 border-b border-gray-100">
            <div class="relative mb-4">
                <div class="p-1 rounded-full bg-gradient-to-tr from-[#145D71] to-[#2ECC71]">
                    <img src="{{ $instansi->foto_profil ? asset('storage/' . $instansi->foto_profil) : asset('assets/images/gorontalo.png') }}" 
                         alt="Instansi Avatar" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-white bg-white">
                </div>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-800">{{ $instansi->full_name }}</h2>
            <p class="text-gray-500 font-bold text-lg">{{ $instansi->username }}</p>
        </div>

        <div class="p-10 md:px-20">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                    <p class="text-gray-500 font-medium text-lg">{{ $instansi->email }}</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">NIP</label>
                    <p class="text-gray-500 font-medium text-lg">{{ $instansi->nip ?? '-' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">No Telp.</label>
                    <p class="text-gray-500 font-medium text-lg">{{ $instansi->phone_number ?? '-' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Alamat</label>
                    <p class="text-gray-500 font-medium text-lg">{{ $instansi->address ?? '-' }}</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Instansi</label>
                    <p class="text-gray-700 font-bold text-lg">{{ $instansi->instance_name }}</p>
                </div>

            </div>
        </div>

        <div class="p-4 bg-gray-100 border-t border-gray-200">
            <form method="POST" action="{{ route('instansi.logout') }}">
                @csrf
                <button type="submit" class="w-full py-4 bg-[#C0392B] hover:bg-[#A93226] text-white font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2 text-lg">
                    <i class="ri-logout-box-r-line"></i>
                    Keluar Akun
                </button>
            </form>
        </div>

    </div>
</div>

@endsection