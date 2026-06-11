<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        // Hanya mengambil data staf yang memiliki role 'gudang'
        $stafGudang = Admin::where('role', 'gudang')->latest()->paginate(10);
        return view('admin.staff.index', compact('stafGudang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8',
        ]);

        // Langsung insert dengan role 'gudang' tanpa mengambil dari request
        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'gudang',     
        ]);

        return redirect()->route('staff.index')->with('success', 'Akun Staf Gudang Baru Berhasil Dibuat!');
    }
}