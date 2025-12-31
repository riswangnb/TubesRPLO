<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package; // <--- Jangan lupa import Model ini

class LandingController extends Controller
{
    public function index()
    {
        // Mengambil semua data paket, diurutkan berdasarkan nama
        $packages = Package::orderBy('nama', 'asc')->get();

        // Kirim variable $packages ke view 'welcome' (atau nama file blade Anda)
        return view('welcome', compact('packages'));
    }
}