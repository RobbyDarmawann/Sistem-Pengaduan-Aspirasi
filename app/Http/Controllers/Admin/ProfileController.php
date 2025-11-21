<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil data admin yang sedang login
        $admin = Auth::guard('admin')->user();
        
        return view('admin.profile.index', compact('admin'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Max 2MB
        ]);

        $admin = Auth::guard('admin')->user();

        // Update Nama (Opsional, sekalian saja)
        $admin->full_name = $request->full_name;

        // Logika Upload Foto
        if ($request->hasFile('photo')) {
            // 1. Hapus foto lama jika ada (bukan foto default)
            if ($admin->profile_photo_path) {
                Storage::disk('public')->delete($admin->profile_photo_path);
            }

            // 2. Simpan foto baru ke folder 'admin-photos' di storage public
            $path = $request->file('photo')->store('admin-photos', 'public');
            
            // 3. Simpan path ke database
            $admin->profile_photo_path = $path;
        }

        $admin->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}