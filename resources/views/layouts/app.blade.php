<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'SuaraGO')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css" rel="stylesheet"/>

    {{-- Memanggil Script Utama & Landing JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/landing.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        html {
            scroll-behavior: smooth;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">

    {{-- Navbar Partial --}}
    @include('partials.navbar')
    
    <main>
        @yield('content')
    </main>

    {{-- Footer Partial --}}
    @include('partials.footer')

    {{-- Modal Auth Partial --}}
    @include('partials.auth-modal')

    {{-- Script Tambahan untuk Logout & Toast (Jika tidak ada di landing.js) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // --- Fungsi Toast Notification ---
            window.showToast = function(message, type = 'success') {
                const toastId = 'dynamic-toast-message';
                let toastMessage = document.getElementById(toastId);
                if (toastMessage) toastMessage.remove(); 
                
                const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
                toastMessage = document.createElement('div');
                toastMessage.id = toastId;
                toastMessage.className = `fixed top-24 right-5 z-[100] text-white py-3 px-5 rounded-lg shadow-lg ${bgColor} transition-opacity duration-500`;
                toastMessage.textContent = message;
                
                document.body.appendChild(toastMessage);
                
                // Hapus otomatis setelah 3 detik
                setTimeout(() => {
                    toastMessage.style.opacity = '0';
                    setTimeout(() => toastMessage.remove(), 500);
                }, 3000);
            };

            // --- Cek Flash Message dari Session (PHP) ---
            @if(session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif

            @if(session('error'))
                showToast("{{ session('error') }}", 'error');
            @endif


        });
    </script>
    
    @stack('scripts')
</body>
</html>