<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dukungan extends Model
{
    use HasFactory;

    protected $fillable = ['laporan_id', 'user_id', 'user_type'];
}