<?php

namespace App\Http\Controllers;

use App\Models\AadbKategori;
use Illuminate\Http\Request;

class AadbKategoriController extends Controller
{
    public function show()
    {
        $data = AadbKategori::get();
        return view('pages.aadb.kategori.show', compact('data'));
    }

    public function store(Request $request)
    {
        $id = AadbKategori::withTrashed()->count() + 1;
        $tambah = new AadbKategori();
        $tambah->id_kategori    = $id;
        $tambah->nama_kategori  = $request->kategori;
        $tambah->deskripsi      = $request->deskripsi;
        $tambah->icon           = $request->icon;
        $tambah->status         = $request->status;
        $tambah->save();

        return redirect()->route('aadb-kategori')->with('success', 'Berhasil Menambahkan');
    }

    public function update(Request $request, $id)
    {
        AadbKategori::where('id_kategori', $id)->update([
            'nama_kategori' => $request->kategori,
            'deskripsi'     => $request->deskripsi,
            'icon'          => $request->icon,
            'status'        => $request->status
        ]);

        return redirect()->route('aadb-kategori')->with('success', 'Berhasil Memperbaharui');
    }
}
