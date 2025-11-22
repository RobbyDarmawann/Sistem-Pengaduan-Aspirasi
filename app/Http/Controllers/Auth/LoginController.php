<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Pengguna; 

class LoginController extends Controller
{
    /**
     * Menangani percobaan autentikasi secara manual.
     * (Untuk Login Modal AJAX)
     */
    public function store(Request $request)
    {
        $request->validate([
            'login_field' => 'required|string',
            'password' => 'required|string',
        ]);

        $login_field = $request->input('login_field');
        $password = $request->input('password');

        $user = Pengguna::where('email', $login_field)
                        ->orWhere('username', $login_field)
                        ->orWhere('phone_number', $login_field)
                        ->first();

        if ($user && Hash::check($password, $user->password)) {

            Auth::login($user); // Otomatis menggunakan guard 'web'
            
            $request->session()->regenerate();

            // 4. Kirim respon JSON (SUDAH BENAR)
            return response()->json([
                'success' => true,
                'redirect_url' => url('/') // Pastikan rute ini ada
            ], 200);
        }

        // 6. Jika user tidak ditemukan ATAU password salah
        throw ValidationException::withMessages([
            'login_field' => ['Kredensial yang Anda masukkan tidak cocok.'],
        ]);
    }

    /**
     * Menangani proses logout.
     * (Untuk Logout AJAX dari landing.js)
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout(); // Hanya logout 'web' (Pengguna)

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Mengirim respon JSON (SUDAH BENAR)
        return response()->json([
            'success' => true,
            'message' => 'Anda telah berhasil keluar.',
            'redirect_url' => url('/') // Beri tahu JS ke mana harus pergi
        ], 200);
    }
}