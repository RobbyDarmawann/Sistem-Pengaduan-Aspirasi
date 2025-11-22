<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instansi;
use Illuminate\Support\Facades\Hash;

class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh Akun untuk Kecamatan Dungingi
        Instansi::create([
            'username' => 'dungingi',
            'password' => Hash::make('password'),
            'full_name' => 'Admin Kecamatan Dungingi',
            'email' => 'dungingi@gorontalo.go.id',
            'instance_name' => 'Pemerintah Kecamatan Dungingi, Kota Gorontalo',
            'phone_number' => '081234567890',
            'nip' => '198501012010011001',
            'address' => 'Jl. Apel No. 10, Gorontalo'
        ]);
    }
}