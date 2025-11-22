@extends('layouts.app')

@section('title', 'Ubah Profil - SuaraGO')

@section('content')

<form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div id="header-cover-preview" 
         class="relative pt-24 pb-32 bg-cover bg-center transition-all duration-500" 
         style="background-color: #5D9FD6; 
                background-image: url('{{ $user->cover_photo_path ? asset('storage/' . $user->cover_photo_path) : '' }}');">
        
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="absolute top-8 right-20 z-10">
            <a href="{{ route('profil.index') }}" class="px-6 py-2 bg-white/20 hover:bg-white/30 border border-white/40 text-white rounded-lg font-semibold transition backdrop-blur-sm">
                Lihat Profil
            </a>
        </div>

        <div class="container mx-auto px-5 md:px-20 relative z-10">
            <div class="flex items-center gap-6">
                <div class="relative">
                    <img id="header-photo-preview" 
                         src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('assets/images/profil-pengguna.jpg') }}" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg bg-white">
                </div>
                <div class="text-white drop-shadow-md">
                    <h1 class="text-2xl font-bold">{{ $user->full_name }}</h1>
                    <p class="text-sm text-blue-100">{{ $user->username }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-5 md:px-20 -mt-12 pb-20 relative z-20">
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800 inline-block border-b-4 border-gray-300 pb-2">Perbarui Informasi Milik Anda</h2>
        </div>

        <div class="bg-[#99C8E9] px-6 py-3 flex justify-between items-center rounded-t-lg shadow-sm">
            <h3 class="font-bold text-gray-800 text-lg">Informasi Umum</h3>
            <button type="submit" class="bg-[#154c79] hover:bg-[#0f3a5d] text-white px-6 py-2 rounded-lg font-bold shadow-md transition text-sm">
                Simpan Perubahan
            </button>
        </div>

        <div class="bg-[#AECFE5] p-8 rounded-b-lg mb-8 shadow-sm">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <div class="space-y-6">
                    <div class="flex items-center">
                        <label class="w-32 font-bold text-gray-800 text-sm">Nama Lengkap</label>
                        <span class="mr-2 font-bold">:</span>
                        <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" class="flex-1 px-3 py-2 bg-white border border-gray-400 rounded text-gray-800 focus:outline-none font-bold">
                    </div>
                    
                    <div class="flex items-center">
                        <label class="w-32 font-bold text-gray-800 text-sm">Username</label>
                        <span class="mr-2 font-bold">:</span>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="flex-1 px-3 py-2 bg-white border border-gray-400 rounded text-gray-800 focus:outline-none font-bold">
                    </div>

                    <div class="pt-4 space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="show_aspirasi" value="1" class="w-5 h-5 rounded-full border-gray-500 bg-transparent text-black focus:ring-0" {{ $user->show_aspirasi ? 'checked' : '' }}> 
                            <span class="font-bold text-gray-800 text-sm">Perlihatkan Jumlah Aspirasi</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="show_pengaduan" value="1" class="w-5 h-5 rounded-full border-gray-500 bg-transparent text-black focus:ring-0" {{ $user->show_pengaduan ? 'checked' : '' }}> 
                            <span class="font-bold text-gray-800 text-sm">Perlihatkan Jumlah Laporan</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    
                    <div class="text-center">
                        <label class="block font-bold text-gray-800 mb-2 text-xs uppercase">Foto Profil</label>
                        <div class="bg-white border-2 border-dotted border-gray-400 h-32 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-50 relative overflow-hidden group" onclick="document.getElementById('input-photo').click()">
                            <div class="flex flex-col items-center z-10 transition opacity-100 group-hover:opacity-0">
                                <span class="text-4xl font-bold text-gray-800">+</span>
                                <span class="text-[10px] text-gray-400 italic block mt-1">Upload foto Anda di sini</span>
                            </div>
                            <img id="box-photo-preview" src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : '' }}" class="absolute inset-0 w-full h-full object-cover {{ $user->profile_photo_path ? '' : 'hidden' }}">
                        </div>
                        <input type="file" name="photo" id="input-photo" class="hidden" accept="image/*" 
                               onchange="previewImage(this, 'header-photo-preview', 'box-photo-preview')">
                    </div>

                    <div class="text-center">
                        <label class="block font-bold text-gray-800 mb-2 text-xs uppercase">Gambar Sampul</label>
                        <div class="bg-white border-2 border-dotted border-gray-400 h-32 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-50 relative overflow-hidden group" onclick="document.getElementById('input-cover').click()">
                            <div class="flex flex-col items-center z-10 transition opacity-100 group-hover:opacity-0">
                                <span class="text-4xl font-bold text-gray-800">+</span>
                                <span class="text-[10px] text-gray-400 italic block mt-1">Upload gambar di sini</span>
                            </div>
                            <img id="box-cover-preview" src="{{ $user->cover_photo_path ? asset('storage/' . $user->cover_photo_path) : '' }}" class="absolute inset-0 w-full h-full object-cover {{ $user->cover_photo_path ? '' : 'hidden' }}">
                        </div>
                        <input type="file" name="cover" id="input-cover" class="hidden" accept="image/*" 
                               onchange="previewBackground(this, 'header-cover-preview', 'box-cover-preview')">
                    </div>

                </div>
            </div>
        </div>

        <div class="bg-[#99C8E9] px-6 py-3 font-bold text-gray-800 text-lg rounded-t-lg shadow-sm">
            Informasi Pribadi
        </div>

        <div class="bg-[#AECFE5] p-8 rounded-b-lg shadow-sm">
            <div class="flex justify-center gap-16 mb-8">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="gender" value="Laki-laki" class="w-6 h-6 bg-transparent border-2 border-black text-black focus:ring-0" {{ $user->gender == 'Laki-laki' ? 'checked' : '' }}>
                    <span class="font-bold text-gray-800">Laki-laki</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="gender" value="Perempuan" class="w-6 h-6 bg-transparent border-2 border-black text-black focus:ring-0" {{ $user->gender == 'Perempuan' ? 'checked' : '' }}>
                    <span class="font-bold text-gray-800">Perempuan</span>
                </label>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-6">
                <div class="space-y-6">
                    <div class="flex items-center"><label class="w-32 font-bold text-gray-800 text-sm">Email</label><span class="mr-2 font-bold">:</span><input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Masukkan email Anda di sini" class="flex-1 px-3 py-2 bg-white border border-gray-400 rounded text-sm italic text-gray-500 focus:outline-none"></div>
                    <div class="flex items-center"><label class="w-32 font-bold text-gray-800 text-sm">No HP</label><span class="mr-2 font-bold">:</span><input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" placeholder="Masukkan nomor Anda di sini" class="flex-1 px-3 py-2 bg-white border border-gray-400 rounded text-sm italic text-gray-500 focus:outline-none"></div>
                    <div class="flex items-center"><label class="w-32 font-bold text-gray-800 text-sm">Kerjaan</label><span class="mr-2 font-bold">:</span><input type="text" name="job" value="{{ old('job', $user->job) }}" placeholder="Masukkan email Anda di sini" class="flex-1 px-3 py-2 bg-white border border-gray-400 rounded text-sm italic text-gray-500 focus:outline-none"></div>
                    <div class="flex items-center"><label class="w-32 font-bold text-gray-800 text-sm">Tempat Lahir</label><span class="mr-2 font-bold">:</span><input type="text" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}" placeholder="Masukkan nomor Anda di sini" class="flex-1 px-3 py-2 bg-white border border-gray-400 rounded text-sm italic text-gray-500 focus:outline-none"></div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center"><label class="w-32 font-bold text-gray-800 text-sm">Tanggal lahir</label><span class="mr-2 font-bold">:</span><input type="date" name="birthday" value="{{ old('birthday', optional($user->birthday)->format('Y-m-d')) }}" class="flex-1 px-3 py-2 bg-white border border-gray-400 rounded text-sm italic text-gray-500 focus:outline-none"></div>
                    <div class="flex items-center"><label class="w-32 font-bold text-gray-800 text-sm">NIK</label><span class="mr-2 font-bold">:</span><input type="text" name="nik" value="{{ old('nik', $user->nik) }}" placeholder="Masukkan nomor Anda di sini" class="flex-1 px-3 py-2 bg-white border border-gray-400 rounded text-sm italic text-gray-500 focus:outline-none"></div>
                    <div class="flex items-center"><label class="w-32 font-bold text-gray-800 text-sm">Alamat</label><span class="mr-2 font-bold">:</span><input type="text" name="domicile" value="{{ old('domicile', $user->domicile) }}" placeholder="Masukkan email Anda di sini" class="flex-1 px-3 py-2 bg-white border border-gray-400 rounded text-sm italic text-gray-500 focus:outline-none"></div>
                    <div class="flex items-center"><label class="w-32 font-bold text-gray-800 text-sm">Password</label><span class="mr-2 font-bold">:</span><input type="password" name="new_password" placeholder="Masukkan nomor Anda di sini" class="flex-1 px-3 py-2 bg-white border border-gray-400 rounded text-sm italic text-gray-500 focus:outline-none"></div>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('profil.index') }}" class="text-red-600 font-bold hover:underline text-sm tracking-wide">
                Batalkan Ubah Profil
            </a>
        </div>

    </div>
</form>

<script>
    // 1. Preview untuk Foto Profil (Ganti src <img>)
    function previewImage(input, headerImgId, boxImgId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Update Foto Bulat di Header
                document.getElementById(headerImgId).src = e.target.result;
                
                // Update Foto di Kotak Upload
                const boxImg = document.getElementById(boxImgId);
                boxImg.src = e.target.result;
                boxImg.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // 2. Preview untuk Sampul (Ganti style background-image)
    function previewBackground(input, headerDivId, boxImgId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Update Background Header Biru
                const headerDiv = document.getElementById(headerDivId);
                headerDiv.style.backgroundImage = `url('${e.target.result}')`;
                headerDiv.style.backgroundSize = 'cover';
                headerDiv.style.backgroundPosition = 'center';

                // Update Foto di Kotak Upload
                const boxImg = document.getElementById(boxImgId);
                boxImg.src = e.target.result;
                boxImg.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection