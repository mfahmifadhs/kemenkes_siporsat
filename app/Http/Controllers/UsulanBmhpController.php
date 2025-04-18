<?php

namespace App\Http\Controllers;

use App\Models\Bmhp;
use App\Models\Usulan;
use App\Models\UsulanBmhp;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UsulanBmhpController extends Controller
{
    public function store(Request $request)
    {
        $usulanBmhp = UsulanBmhp::where('bmhp_id', $request->id_bmhp)->where('usulan_id', $request->usulan_id)->first();
        $usulan     = Usulan::where('id_usulan', $request->usulan_id)->first();

        if ($usulanBmhp) {
            $total = $usulanBmhp->jumlah + $request->jumlah;
            UsulanBmhp::where('id_detail', $usulanBmhp->id_detail)->update([
                'jumlah' => $total,
                'status' => $usulanBmhp->usulan->status_persetujuan == 'true' ? 'true' : 'false'
            ]);
        } else {
            $bmhp = Bmhp::where('id_bmhp', $request->id_bmhp)->first();
            $id_detail = UsulanBmhp::withTrashed()->count() + 1;
            $tambah = new UsulanBmhp();
            $tambah->id_detail  = $id_detail;
            $tambah->usulan_id  = $request->usulan_id;
            $tambah->bmhp_id    = $request->id_bmhp;
            $tambah->jumlah     = $request->jumlah;
            $tambah->satuan_id  = $bmhp->satuan_id;
            $tambah->status     = $usulan->status_persetujuan == 'true' ? 'true' : 'false';
            $tambah->created_at = Carbon::now();
            $tambah->save();
        }

        return redirect()->back()->with('success', 'Berhasil Menyimpan');
    }

    public function update(Request $request)
    {
        $usulanBmhp = UsulanBmhp::where('bmhp_id', $request->id_bmhp)->where('usulan_id', $request->usulan_id)->first();

        $bmhp       = Bmhp::where('id_bmhp', $request->id_bmhp)->first();
        if ($usulanBmhp) {
            $total = $usulanBmhp->jumlah + $request->jumlah;
            UsulanBmhp::where('id_detail', $usulanBmhp->id_detail)->update([
                'jumlah'    => $request->jumlah,
                'satuan_id' => $bmhp->satuan_id,
                'status'    => $usulanBmhp->usulan->status_persetujuan == 'true' ? 'true' : 'false'
            ]);
        } else {
            UsulanBmhp::where('id_detail', $request->id_detail)->update([
                'bmhp_id'    => $request->id_bmhp,
                'jumlah'    => $request->jumlah,
                'satuan_id' => $bmhp->satuan_id,
                'status'    => 'true'
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil Menyimpan');
    }

    public function delete($id)
    {
        UsulanBmhp::where('id_detail', $id)->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus');
    }
}
