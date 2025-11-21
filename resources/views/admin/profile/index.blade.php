@extends('layouts.admin')

@section('title', 'Profil')

@section('content')

<div class="flex justify-center items-center min-h-[80vh]">
    <div class="w-full max-w-3xl bg-white rounded-3xl shadow-xl overflow-hidden">
        
        <div class="pt-10 pb-6 flex flex-col items-center">
            <div class="relative mb-4">
                <img src="{{ asset('assets/images/profil-admin.jpg') }}" 
                     alt="Admin Avatar" 
                     class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
            </div>
            
            <h2 class="text-2xl font-bold text-gray-800">{{ $admin->full_name }}</h2>
            <p class="text-gray-500 font-medium">Admin</p>
        </div>

        <div class="px-10 md:px-20 pb-10 space-y-6">
            <div>
                <label class="block text-sm font-bold text-gray-800 mb-1">Username</label>
                <p class="text-gray-500 font-medium">{{ $admin->username }}</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-800 mb-1">Email</label>
                <p class="text-gray-500 font-medium">{{ $admin->email }}</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-800 mb-1">No Telp.</label>
                <p class="text-gray-500 font-medium">{{ $admin->phone_number ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-800 mb-1">Alamat</label>
                <p class="text-gray-500 font-medium">{{ $admin->address ?? '-' }}</p>
            </div>
        </div>

        <div class="p-4 bg-gray-50">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full py-3 bg-[#C0392B] hover:bg-[#A93226] text-white font-bold rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                    <i class="ri-logout-box-r-line text-xl"></i>
                    Keluar Akun
                </button>
            </form>
        </div>

    </div>
</div>

@endsection