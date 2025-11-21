<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil data admin yang sedang login
        $admin = Auth::guard('admin')->user();
        
        return view('admin.profile.index', compact('admin'));
    }
}