<?php

namespace App\Http\Controllers\Instansi\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // Tampilkan Halaman Login
    public function showLoginForm()
    {
        return view('instansi.auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba login menggunakan guard 'instansi'
        // Kita gunakan 'username' sebagai kredensial utama
        if (Auth::guard('instansi')->attempt(['username' => $request->username, 'password' => $request->password])) {
            
            $request->session()->regenerate();
            
            // Redirect ke dashboard instansi
            return redirect()->intended(route('instansi.dashboard'));
        }

        // Jika gagal
        throw ValidationException::withMessages([
            'username' => ['Username atau password salah.'],
        ]);
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::guard('instansi')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('instansi.login')->with('success', 'Berhasil keluar.');
    }
}