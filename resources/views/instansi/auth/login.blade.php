<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Instansi - SuaraGO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css" rel="stylesheet"/>
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 md:p-12 relative">
        
        <div class="mb-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-green-600 transition-colors font-medium text-sm">
                <i class="ri-arrow-left-line text-lg"></i> Kembali ke Beranda
            </a>
        </div>

        <img src="{{ asset('assets/images/logo icon.png') }}" alt="Logo" class="h-16 mx-auto mb-4 object-contain">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">Login Instansi</h1>
        <p class="text-center text-gray-500 text-sm mb-8">Masuk untuk menindaklanjuti laporan.</p>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('instansi.login') }}">
            @csrf
            
            <div class="mb-5">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Username Instansi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ri-building-line text-gray-400"></i>
                    </div>
                    <input type="text" name="username" 
                           class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" 
                           placeholder="Contoh: dinas_pu" required autofocus>
                </div>
                @error('username')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-8">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ri-lock-password-line text-gray-400"></i>
                    </div>
                    <input type="password" name="password" 
                           class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" 
                           placeholder="Masukkan password" required>
                </div>
            </div>
            
            <button type="submit" class="w-full py-3 px-6 rounded-lg font-bold bg-green-600 hover:bg-green-700 text-white transition-all shadow-md">
                Masuk
            </button>
        </form>
    </div>

</body>
</html>