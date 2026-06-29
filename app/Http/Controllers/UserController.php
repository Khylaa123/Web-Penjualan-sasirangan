<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Penting untuk enkripsi password

class UserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        // Hanya menampilkan Admin dan Pegawai (Pembeli tidak perlu tampil di sini)
        $users = User::whereIn('role', ['Admin', 'Pegawai'])->get();
        return view('user.index', compact('users'));
    }

    // Fungsi menyimpan akun baru dari form Admin
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:Admin,Pegawai',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password otomatis
            'role'     => $request->role,
        ]);

        return redirect()->back()->with('success', 'Akun ' . $request->role . ' baru berhasil ditambahkan!');
    }
    
    // (Opsional) Tambahkan public function destroy($id) kalau mau bisa menghapus pegawai
}