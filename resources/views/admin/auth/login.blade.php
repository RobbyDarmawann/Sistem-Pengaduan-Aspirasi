<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SuaraGO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 md:p-12">
        
        <img src="{{ asset('assets/images/logo-suarago.png') }}" alt="Logo SuaraGO" class="h-16 mx-auto mb-6">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-8">Admin Login</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            
            <div class="mb-5">
                <label for="login_field" class="block mb-2 text-sm font-medium text-gray-700">Username atau Email</label>
                <input type="text" id="login_field" name="login_field" 
                       class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('login_field') border border-red-500 @enderror" 
                       placeholder="Masukkan username/email" value="{{ old('login_field') }}" required autofocus>
                
                @error('login_field')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-8">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" 
                       class="w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border border-red-500 @enderror" 
                       placeholder="Masukkan password" required>
            </div>
            
            <button type="submit" class="w-full py-3 px-6 rounded-lg font-semibold bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                Masuk
            </button>
        </form>
    </div>

</body>
</html>