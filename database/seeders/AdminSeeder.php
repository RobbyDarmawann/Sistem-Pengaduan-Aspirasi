<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Tambahkan baris ini:
        Admin::truncate(); // Hapus semua admin lama sebelum menambah baru
        
        Admin::create([
            'full_name' => 'Admin SuaraGO',
            'username'  => 'admin',
            'email'     => 'admin@suarago.com',
            'password'  => Hash::make('admin'), 
        ]);
    }
}