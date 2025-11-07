<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'nullable|string|size:16|unique:pengguna,nik',
            'tempat_tinggal' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'pekerjaan' => 'nullable|string|max:100',
            
            'name' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'telepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:pengguna,email',
            'username' => 'required|string|max:100|unique:pengguna,username',
            'password' => 'required|string|min:8',
            'terms' => 'required',
        ]);

        // 2. Buat Pengguna Baru (jika validasi lolos)
        $pengguna = new Pengguna();
        $pengguna->full_name = $validatedData['name']; 
        $pengguna->domicile = $validatedData['tempat_tinggal'] ?? null; 
        
        if (isset($validatedData['jenis_kelamin'])) {
            $pengguna->gender = $validatedData['jenis_kelamin'] == 'Laki-laki' ? 1 : 2;
        }

        $pengguna->job = $validatedData['pekerjaan'] ?? null;
        $pengguna->birthday = $validatedData['tanggal_lahir'];
        $pengguna->phone_number = $validatedData['telepon'];
        $pengguna->nik = $validatedData['nik'] ?? null;
        $pengguna->email = $validatedData['email'];
        $pengguna->username = $validatedData['username'];
        $pengguna->password = $validatedData['password']; // Otomatis di-hash oleh Model
        
        $pengguna->save();

        // 3. Kirim Respon Sukses (JSON)
        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil! Silakan login.'
        ], 200); // Status 200 OK
    }
}