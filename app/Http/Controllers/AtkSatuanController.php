<?php

namespace App\Http\Controllers;

use App\Models\AtkSatuan;
use Illuminate\Http\Request;

class AtkSatuanController extends Controller
{
    public function show()
    {
        $data = AtkSatuan::get();
        return view('pages.atk.satuan.show', compact('data'));
    }

    public function store(Request $request)
    {
        $id = AtkSatuan::withTrashed()->count() + 1;
        $tambah = new AtkSatuan();
        $tambah->id_satuan   = $id;
        $tambah->nama_satuan = $request->satuan;
        $tambah->deskripsi   = $request->deskripsi;
        $tambah->save();

        return redirect()->route('atk-satuan')->with('success', 'Berhasil Menambahkan');
    }

    public function update(Request $request, $id)
    {
        AtkSatuan::where('id_satuan', $id)->update([
            'nama_satuan' => $request->satuan,
            'deskripsi'   => $request->deskripsi,
            'icon'        => $request->icon
        ]);

        return redirect()->route('atk-satuan')->with('success', 'Berhasil Memperbaharui');
    }
}
