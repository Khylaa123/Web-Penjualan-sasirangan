<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Menampilkan daftar semua user
    public function index()
    {
        // Mengambil semua data user, diurutkan berdasarkan role
        $users = User::orderBy('role', 'asc')->get();
        
        // PERBAIKAN: Hapus "admin." agar langsung membaca folder users
        return view('users.index', compact('users'));
    }

    // Menyimpan user baru (misal Admin menambahkan Pegawai)
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,pegawai,pembeli' // Sesuaikan dengan enum di databasemu
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Password wajib di-hash demi keamanan
            'role'     => $request->role,
        ]);

        return redirect()->back()->with('success', 'Akun pengguna berhasil ditambahkan!');
    }

    // Mengupdate data user (misal ganti password atau ubah role)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            // Validasi email ini mengecualikan email milik user itu sendiri agar tidak error "email sudah dipakai"
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,pegawai,pembeli'
        ]);

        // Update data dasar
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->role  = $request->role;

        // Jika form password diisi, berarti admin ingin mereset password user tersebut
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Data akun berhasil diperbarui!');
    }

    // Menghapus akun
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Validasi Ekstra Keamanan: Admin tidak boleh menghapus akunnya sendiri!
        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'Tindakan ditolak! Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        
        return redirect()->back()->with('success', 'Akun berhasil dihapus!');
    }
}