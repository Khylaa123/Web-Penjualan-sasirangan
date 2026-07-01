<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::orderBy('ID_VOUCHER', 'desc')->get();
        return view('admin.voucher.index', compact('vouchers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'KODE_VOUCHER' => 'required|string|max:50|unique:voucher,KODE_VOUCHER',
            'POTONGAN_HARGA' => 'required|numeric|min:0',
            'STATUS_AKTIF' => 'required|in:Aktif,Tidak Aktif',
        ]);

        Voucher::create($request->all());

        return redirect()->back()->with('success', 'Voucher baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'KODE_VOUCHER' => 'required|string|max:50|unique:voucher,KODE_VOUCHER,' . $id . ',ID_VOUCHER',
            'POTONGAN_HARGA' => 'required|numeric|min:0',
            'STATUS_AKTIF' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $voucher->update($request->all());

        return redirect()->back()->with('success', 'Voucher diskon berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->back()->with('success', 'Voucher berhasil dihapus dari sistem!');
    }
}