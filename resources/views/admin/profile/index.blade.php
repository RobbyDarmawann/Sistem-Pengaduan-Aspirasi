@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')

<div class="flex justify-center items-center min-h-[80vh]">
    <div class="w-full max-w-2xl bg-white rounded-3xl shadow-xl overflow-hidden relative">
        
        <div class="h-32 bg-gradient-to-r from-[#0F4C75] to-[#3282B8]"></div>

        <div class="absolute top-16 left-1/2 transform -translate-x-1/2 group">
            <div class="relative">
                <img id="preview-image" 
                     src="{{ $admin->profile_photo_path ? asset('storage/' . $admin->profile_photo_path) : asset('assets/images/profil-admin.jpg') }}" 
                     alt="Admin Avatar" 
                     class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md bg-white">
                
                <div id="camera-icon" class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 transition cursor-pointer hidden" onclick="document.getElementById('photo-input').click()">
                    <i class="ri-camera-line text-white text-3xl"></i>
                </div>
            </div>
        </div>

        <form id="profile-form" action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data" class="pt-20 pb-8 px-8 md:px-16">
            @csrf
            @method('PUT')
            
            <input type="file" name="photo" id="photo-input" class="hidden" accept="image/*" onchange="previewImage(event)">

            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">{{ $admin->full_name }}</h2>
                <p class="text-gray-500 font-medium">Administrator</p>
            </div>

            <div class="space-y-5">
                
                <div>
                    <label class="block text-sm font-semibold text-center text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="full_name" id="input-name" value="{{ old('full_name', $admin->full_name) }}" 
                           class="w-full px-4 py-2.5 bg-gray-100 border border-gray-200 rounded-lg text-gray-800 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all   disabled:px-0 disabled:font-bold disabled:text-lg disabled:text-center"
                           disabled> </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-1">Username</label>
                        <div class="px-4 py-2.5 bg-gray-100 rounded-lg text-gray-500 text-sm font-mono">
                            {{ $admin->username }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-1">Email</label>
                        <div class="px-4 py-2.5 bg-gray-100 rounded-lg text-gray-500 text-sm font-mono">
                            {{ $admin->email }}
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-10">
                
                <div id="view-actions" class="flex flex-col gap-3">
                    <button type="button" onclick="enableEditMode()" class="w-full py-3 bg-[#3282B8] hover:bg-[#2672a6] text-white font-bold rounded-xl shadow-sm transition-colors flex justify-center items-center gap-2">
                        <i class="ri-edit-box-line text-lg"></i> Edit Profil
                    </button>
                    
                    </div>

                <div id="edit-actions" class="hidden flex flex-col gap-3">
                    <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-sm transition-colors flex justify-center items-center gap-2">
                        <i class="ri-save-3-line text-lg"></i> Simpan Perubahan
                    </button>
                    
                    <button type="button" onclick="cancelEditMode()" class="w-full py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl transition-colors">
                        Batal
                    </button>
                </div>

            </div>
        </form>

        <div id="logout-container" class="px-8 md:px-16 pb-8">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full py-3 border-2 border-red-100 text-red-500 font-bold rounded-xl hover:bg-red-50 hover:border-red-200 transition-colors flex justify-center items-center gap-2">
                    <i class="ri-logout-box-r-line text-lg"></i> Keluar Akun
                </button>
            </form>
        </div>

    </div>
</div>

<script>
    const inputName = document.getElementById('input-name');
    const viewActions = document.getElementById('view-actions');
    const editActions = document.getElementById('edit-actions');
    const logoutContainer = document.getElementById('logout-container');
    const cameraIcon = document.getElementById('camera-icon');
    const originalName = "{{ $admin->full_name }}"; // Simpan nama asli untuk batal
    const previewImg = document.getElementById('preview-image');
    const originalSrc = previewImg.src; // Simpan foto asli

    function enableEditMode() {
        // 1. Ubah tampilan input
        inputName.disabled = false;
        inputName.focus();
        
        // Hapus styling 'disabled' khusus agar terlihat seperti input biasa
        inputName.classList.remove('disabled:bg-transparent', 'disabled:border-none', 'disabled:px-0', 'disabled:text-center');

        // 2. Toggle Tombol
        viewActions.classList.add('hidden');
        logoutContainer.classList.add('hidden'); // Sembunyikan logout
        editActions.classList.remove('hidden');

        // 3. Munculkan ikon kamera di foto
        cameraIcon.classList.remove('hidden');
        setTimeout(() => cameraIcon.classList.remove('opacity-0'), 50); // Efek fade in
    }

    function cancelEditMode() {
        // 1. Kembalikan input ke readonly
        inputName.disabled = true;
        inputName.value = originalName; // Reset nilai nama
        
        // Kembalikan styling
        inputName.classList.add('disabled:bg-transparent', 'disabled:border-none', 'disabled:px-0', 'disabled:text-center');

        // 2. Toggle Tombol
        editActions.classList.add('hidden');
        viewActions.classList.remove('hidden');
        logoutContainer.classList.remove('hidden'); // Munculkan logout lagi

        // 3. Sembunyikan kamera & Reset foto
        cameraIcon.classList.add('opacity-0');
        setTimeout(() => cameraIcon.classList.add('hidden'), 300);
        
        // Reset preview foto ke awal
        previewImg.src = originalSrc;
        document.getElementById('photo-input').value = "";
    }

    // Fungsi Preview Gambar (Sama seperti sebelumnya)
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            previewImg.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection