<?php

namespace App\Http\Controllers;

use App\Models\AtkKategori;
use Illuminate\Http\Request;

class AtkKategoriController extends Controller
{
    public function show()
    {
        $data = AtkKategori::get();
        return view('pages.atk.kategori.show', compact('data'));
    }

    public function store(Request $request)
    {
        $id = AtkKategori::withTrashed()->count() + 1;
        $tambah = new AtkKategori();
        $tambah->id_kategori    = $id;
        $tambah->nama_kategori  = $request->kategori;
        $tambah->deskripsi      = $request->deskripsi;
        $tambah->icon           = $request->icon;
        $tambah->status         = $request->status;
        $tambah->save();

        return redirect()->route('atk-kategori')->with('success', 'Berhasil Menambahkan');
    }

    public function update(Request $request, $id)
    {
        AtkKategori::where('id_kategori', $id)->update([
            'nama_kategori' => $request->kategori,
            'deskripsi'     => $request->deskripsi,
            'icon'          => $request->icon,
            'status'        => $request->status
        ]);

        return redirect()->route('atk-kategori')->with('success', 'Berhasil Memperbaharui');
    }
}
