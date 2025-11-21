<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <-- Gunakan ini
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'aid';
    public $incrementing = true; 
    protected $fillable = [
        'username',
        'password',
        'full_name',
        'email',
        'phone_number',
        'address',
        'profile_photo_path',
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