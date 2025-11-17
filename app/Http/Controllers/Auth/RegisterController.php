<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;
// Kita tidak perlu 'Str' lagi karena tidak membuat 'uid'
// use Illuminate\Support\Str; 

class RegisterController extends Controller
{
    /**
     * Menangani permintaan registrasi baru.
     */
    public function store(Request $request)
    {
        // 1. VALIDASI DATA (Ini sudah benar)
        $validator = Validator::make($request->all(), [
            'full_name'    => 'required|string|max:255',
            'password'     => ['required', 'string', Password::min(8)],
            'terms'        => 'accepted',
            'username'     => 'nullable|string|max:100|unique:pengguna,username|required_without_all:email,phone_number',
            'email'        => 'nullable|string|email|max:255|unique:pengguna,email|required_without_all:username,phone_number',
            'phone_number' => 'nullable|string|max:15|unique:pengguna,phone_number|required_without_all:username,email',
            'nik'          => 'nullable|string|numeric|digits:16|unique:pengguna,nik',
            'domicile'     => 'nullable|string|max:255',
            'birthday'     => 'nullable|date',
            'gender'       => 'nullable|in:Laki-laki,Perempuan',
            'job'          => 'nullable|string|max:100',
        ], [
            // Pesan error (Sudah benar)
            'username.required_without_all' => 'Isi setidaknya username, email, atau nomor telepon.',
            'email.required_without_all'    => 'Isi setidaknya username, email, atau nomor telepon.',
            'phone_number.required_without_all' => 'Isi setidaknya username, email, atau nomor telepon.',
            'nik.unique'      => 'NIK ini sudah terdaftar.',
            'email.unique'    => 'Email ini sudah terdaftar.',
            'username.unique' => 'Username ini sudah digunakan.',
            'phone_number.unique'  => 'Nomor telepon ini sudah terdaftar.',
            'terms.accepted'  => 'Anda harus menyetujui Syarat dan Ketentuan.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 2. SIMPAN DATA (PERBAIKAN BESAR DI SINI)
        try {
            Pengguna::create([
                'full_name'     => $request->full_name,
                'password'      => Hash::make($request->password),
                
                // --- PERUBAHAN DI SINI ---
                // 'uid' dihapus
                // 'role' dihapus
                'report_count'     => 0, // <-- Tambahkan nilai default
                'aspiration_count' => 0, // <-- Tambahkan nilai default
                'address'          => $request->domicile ?? null, // <-- Kirim null jika kosong
                // --- AKHIR PERUBAHAN ---

                'nik'           => $request->nik,
                'domicile'      => $request->domicile,
                'birthday'      => $request->birthday,
                'gender'        => $request->gender,
                'job'           => $request->job,
                'email'         => $request->email,
                'username'      => $request->username,
                'phone_number'  => $request->phone_number,
            ]);
        } catch (\Exception $e) {
            // Kita kembalikan error asli untuk debug
            Log::error('Gagal Registrasi (DB Error): ' . $e->getMessage()); 
            return response()->json([
                'errors' => ['general' => [ $e->getMessage() ]] 
            ], 500);
        }

        // 3. KIRIM RESPON SUKSES
        return response()->json([
            'message' => 'Registrasi berhasil! Silakan masuk.'
        ], 201);
    }
}