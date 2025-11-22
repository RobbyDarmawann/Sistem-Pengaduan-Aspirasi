<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Laporan;

class ProfilController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $laporanCount = Laporan::where('pengguna_id', $user->id)->where('tipe_laporan', 'pengaduan')->count();
        $aspirasiCount = Laporan::where('pengguna_id', $user->id)->where('tipe_laporan', 'aspirasi')->count();

        // Default tipe adalah 'aspirasi' (sesuai gambar Anda yang jumlahnya 7)
        $type = $request->query('type', 'aspirasi'); 
        $tab = $request->query('tab', 'all');

        $query = Laporan::where('pengguna_id', $user->id)->where('tipe_laporan', $type)->latest();

        if ($tab == 'pending') $query->where('status', 'belum_disetujui');
        elseif ($tab == 'process') $query->where('status', 'diproses');
        elseif ($tab == 'finished') $query->where('status', 'selesai');

        $laporans = $query->get();

        return view('profil.index', compact('user', 'laporans', 'laporanCount', 'aspirasiCount', 'tab', 'type'));
    }

    public function edit()
    {
        $user = Auth::user();
        // Hitung ulang untuk header di halaman edit
        $laporanCount = Laporan::where('pengguna_id', $user->id)->where('tipe_laporan', 'pengaduan')->count();
        $aspirasiCount = Laporan::where('pengguna_id', $user->id)->where('tipe_laporan', 'aspirasi')->count();

        return view('profil.edit', compact('user', 'laporanCount', 'aspirasiCount'));
    }

  public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'full_name' => 'required|string|max:255',
            
            // --- PERUBAHAN VALIDASI (OPSIONAL TAPI WAJIB SALAH SATU) ---
            'username' => [
                'nullable', 
                'string', 
                'max:255', 
                Rule::unique('pengguna')->ignore($user->id), // Abaikan user ini sendiri
                'required_without_all:email,phone_number'    // Wajib jika email & hp kosong
            ],
            'email' => [
                'nullable', 
                'email', 
                'max:255', 
                Rule::unique('pengguna')->ignore($user->id), 
                'required_without_all:username,phone_number' // Wajib jika username & hp kosong
            ],
            'phone_number' => [
                'nullable', 
                'string', 
                'max:15', 
                // Rule::unique('pengguna')->ignore($user->id), // Aktifkan jika no hp harus unik
                'required_without_all:username,email'        // Wajib jika username & email kosong
            ],
            // ----------------------------------------------------------

            'photo' => 'nullable|image|max:2048',
            'cover' => 'nullable|image|max:4096',
            'new_password' => 'nullable|min:8',
        ], [
            // Pesan Error Kustom (Supaya user paham)
            'username.required_without_all' => 'Mohon isi setidaknya Username, Email, atau Nomor HP.',
            'email.required_without_all' => 'Mohon isi setidaknya Username, Email, atau Nomor HP.',
            'phone_number.required_without_all' => 'Mohon isi setidaknya Username, Email, atau Nomor HP.',
        ]);

        // 1. Update Data Teks
        $user->full_name = $request->full_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->nik = $request->nik;
        $user->job = $request->job;
        $user->domicile = $request->domicile;
        $user->birth_place = $request->birth_place;
        $user->birthday = $request->birthday;
        $user->gender = $request->gender;

        // 2. Update Checkbox
        $user->show_aspirasi = $request->has('show_aspirasi') ? 1 : 0;
        $user->show_pengaduan = $request->has('show_pengaduan') ? 1 : 0;

        // 3. Update Password
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        // 4. Upload Foto Profil
        if ($request->hasFile('photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $user->profile_photo_path = $request->file('photo')->store('user-photos', 'public');
        }

        // 5. Upload Foto Sampul
        if ($request->hasFile('cover')) {
            if ($user->cover_photo_path) {
                Storage::disk('public')->delete($user->cover_photo_path);
            }
            $user->cover_photo_path = $request->file('cover')->store('user-covers', 'public');
        }

        $user->save();

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui!');
    }
}