<?php

namespace App\Http\Controllers;

use App\Models\BmhpKategori;
use Illuminate\Http\Request;

class BmhpKategoriController extends Controller
{
    public function show()
    {
        $data = BmhpKategori::get();
        return view('pages.bmhp.kategori.show', compact('data'));
    }

    public function store(Request $request)
    {
        $id = BmhpKategori::withTrashed()->count() + 1;
        $tambah = new BmhpKategori();
        $tambah->id_kategori    = $id;
        $tambah->nama_kategori  = $request->kategori;
        $tambah->deskripsi      = $request->deskripsi;
        $tambah->icon           = $request->icon;
        $tambah->status         = $request->status;
        $tambah->save();

        return redirect()->route('bmhp-kategori')->with('success', 'Berhasil Menambahkan');
    }

    public function update(Request $request, $id)
    {
        BmhpKategori::where('id_kategori', $id)->update([
            'nama_kategori' => $request->kategori,
            'deskripsi'     => $request->deskripsi,
            'icon'          => $request->icon,
            'status'        => $request->status
        ]);

        return redirect()->route('bmhp-kategori')->with('success', 'Berhasil Memperbaharui');
    }
}
