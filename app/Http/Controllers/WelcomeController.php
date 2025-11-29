<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; // Pastikan Model Anda bernama Produk

class WelcomeController extends Controller
{
    public function index()
    {
        $produks = Produk::all(); // Mengambil semua produk dari database

        // Kirim data ke view 'welcome'
        return view('welcome', compact('produks')); 
    }
}