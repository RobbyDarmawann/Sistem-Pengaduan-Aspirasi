<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // <-- PENTING: Import Hash
use Illuminate\Validation\ValidationException;
use App\Models\Pengguna; // <-- PENTING: Import model Pengguna

class LoginController extends Controller
{
    /**
     * Menangani percobaan autentikasi secara manual.
     */
    public function store(Request $request)
    {
        $request->validate([
            'login_field' => 'required|string',
            'password' => 'required|string',
        ]);

        $login_field = $request->input('login_field');
        $password = $request->input('password');

        // 2. Lakukan pencarian manual (BYPASS Auth::attempt)
        // Coba cari sebagai email, ATAU username, ATAU phone_number
        $user = Pengguna::where('email', $login_field)
                        ->orWhere('username', $login_field)
                        ->orWhere('phone_number', $login_field)
                        ->first();

        // 3. Cek apakah user ditemukan DAN password-nya cocok
        // Kita gunakan Hash::check() yang sudah terbukti true di Tinker
            if ($user && $password == $user->password) {
            
            // 4. Jika sukses, loginkan user secara manual
            Auth::login($user); // <-- Ini adalah "manual attempt"
            
            $request->session()->regenerate();

            // 5. Kirim respon JSON
            return response()->json([
                'success' => true,
                'redirect_url' => '/home'
            ], 200);
        }

        // 6. Jika user tidak ditemukan ATAU password salah
        throw ValidationException::withMessages([
            'login_field' => ['Kredensial yang Anda masukkan tidak cocok.'],
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Mengirim respon JSON, bukan redirect
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}


