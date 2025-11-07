<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Penting untuk login
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Menentukan tabel database yang digunakan oleh model.
     */
    protected $table = 'pengguna';

    /**
     * Menentukan primary key.
     */
    protected $primaryKey = 'uid';

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'username',
        'password',
        'full_name',
        'gender',
        'email',
        'birthday',
        'phone_number',
        'nik',
        'job',
        'domicile',
        'address',
    ];

    /**
     * Kolom yang harus disembunyikan.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Kolom yang harus di-cast ke tipe data tertentu.
     */
    protected $casts = [
        'birthday' => 'date',
        'password' => 'hashed', // Otomatis hash password saat di-set
    ];
}   