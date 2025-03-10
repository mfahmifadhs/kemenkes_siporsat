<?php

namespace App\Http\Controllers;

use App\Models\UserAkses;
use Illuminate\Http\Request;

class UserAksesController extends Controller
{
    public function show()
    {
        $data = UserAkses::get();
        return view('pages.users.akses.show', compact('data'));
    }

    public function store(Request $request)
    {
        $id = UserAkses::withTrashed()->count() + 1;
        $tambah = new UserAkses();
        $tambah->id_akses   = $id;
        $tambah->nama_akses = $request->akses;
        $tambah->save();

        return redirect()->route('akses')->with('success', 'Berhasil Menambahkan');
    }

    public function update(Request $request, $id)
    {
        UserAkses::where('id_akses', $id)->update([
            'nama_akses' => $request->akses
        ]);

        return redirect()->route('akses')->with('success', 'Berhasil Memperbaharui');
    }
}
