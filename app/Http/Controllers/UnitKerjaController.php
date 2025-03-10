<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    public function show()
    {
        $data = UnitKerja::get();
        return view('pages.pegawai.uker.show', compact('data'));
    }

    public function store(Request $request)
    {
        $id = UnitKerja::withTrashed()->count() + 1;
        $tambah = new UnitKerja();
        $tambah->id_unit_kerja = $id;
        $tambah->unit_kerja    = $request->uker;
        $tambah->save();

        return redirect()->route('uker')->with('success', 'Berhasil Menambahkan');
    }

    public function update(Request $request, $id)
    {
        UnitKerja::where('id_unit_kerja', $id)->update([
            'unit_kerja' => $request->uker
        ]);

        return redirect()->route('uker')->with('success', 'Berhasil Memperbaharui');
    }
}
