<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SuaraGO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css" rel="stylesheet"/>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 md:p-12 relative">
        
        <div class="mb-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-[#3282B8] transition-colors font-medium text-sm">
                <i class="ri-arrow-left-line text-lg"></i> Kembali ke Beranda
            </a>
        </div>

        <img src="{{ asset('assets/images/logo icon.png') }}" alt="Logo SuaraGO" class="h-16 mx-auto mb-4 object-contain">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-8">Admin Login</h1>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative mb-6 flex items-center gap-2 text-sm" role="alert">
                <i class="ri-checkbox-circle-line text-lg"></i>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            
            <div class="mb-5">
                <label for="login_field" class="block mb-2 text-sm font-semibold text-gray-700">Username atau Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ri-user-line text-gray-400"></i>
                    </div>
                    <input type="text" id="login_field" name="login_field" 
                           class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-50 border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#3282B8] focus:border-transparent transition-all @error('login_field') border-red-500 @enderror" 
                           placeholder="Masukkan username/email" value="{{ old('login_field') }}" required autofocus>
                </div>
                
                @error('login_field')
                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                        <i class="ri-error-warning-line"></i> {{ $message }}
                    </p>
                @enderror
            </div>
            
            <div class="mb-8">
                <label for="password" class="block mb-2 text-sm font-semibold text-gray-700">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ri-lock-password-line text-gray-400"></i>
                    </div>
                    <input type="password" id="password" name="password" 
                           class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-50 border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#3282B8] focus:border-transparent transition-all @error('password') border-red-500 @enderror" 
                           placeholder="Masukkan password" required>
                </div>
            </div>
            
            <button type="submit" class="w-full py-3 px-6 rounded-lg font-bold bg-[#0F4C75] hover:bg-[#0B3C5D] text-white transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                Masuk
            </button>
        </form>
    </div>

</body>
</html>