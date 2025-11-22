<?php

namespace App\Http\Controllers\Instansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $instansi = Auth::guard('instansi')->user();
        return view('instansi.profile.index', compact('instansi'));
    }
}