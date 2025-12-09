<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instansi;
use Illuminate\Support\Facades\Hash;

class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        Instansi::create([
            'username' => 'kota',
            'password' => Hash::make('kotagorontalo'),
            'full_name' => 'Admin kota gorontalo',
            'email' => 'kotagorontalo@gorontalo.go.id',
            'instance_name' => 'Pemerintah Kota Gorontalo',
            'phone_number' => '081234567890',
            'nip' => '198501012010011002',
            'address' => 'Jl. Apel No. 10, Gorontalo'
        ]);
    }
}