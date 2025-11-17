<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <-- Gunakan ini
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Tentukan tabel yang digunakan
     */
    protected $table = 'admin';

    /**
     * Tentukan primary key
     */
    protected $primaryKey = 'aid';

    /**
     * Primary key BUKAN auto-increment
     */
    public $incrementing = true; // 'id' (default) adalah int, 'aid' Anda juga 'id()', jadi true

    /**
     * Atribut yang boleh diisi
     */
    protected $fillable = [
        'username',
        'password',
        'full_name',
        'email',
        'phone_number',
        'address',
        'received_report',
        'processing_count',
        'completed_count',
    ];

    /**
     * Atribut yang disembunyikan
     */
    protected $hidden = [
        'password',
    ];
}