<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Menampilkan form login admin.
     */
    public function showLoginForm()
    {
        // Akan membuat view ini di langkah 5
        return view('admin.auth.login');
    }

    /**
     * Menangani proses login admin.
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'login_field' => 'required|string',
            'password' => 'required|string',
        ]);

        $login_field = $request->input('login_field');
        $password = $request->input('password');

        // 2. Tentukan field untuk login (bisa username atau email)
        $field = filter_var($login_field, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 3. Coba lakukan login menggunakan guard 'admin'
        if (Auth::guard('admin')->attempt([$field => $login_field, 'password' => $password])) {
            
            // 4. Jika berhasil, regenerate session
            $request->session()->regenerate();
            
            // 5. Redirect ke dashboard admin
            return redirect()->intended(route('admin.dashboard'));
        }

        // 6. Jika gagal, kirim error
        throw ValidationException::withMessages([
            'login_field' => ['Kredensial yang Anda masukkan tidak cocok.'],
        ]);
    }

    /**
     * Menangani proses logout admin.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah keluar.');
    }
}