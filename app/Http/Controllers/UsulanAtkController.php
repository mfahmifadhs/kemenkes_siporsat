<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\Usulan;
use App\Models\UsulanAtk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UsulanAtkController extends Controller
{
    public function store(Request $request)
    {
        $usulanAtk = UsulanAtk::where('atk_id', $request->id_atk)->where('usulan_id', $request->usulan_id)->first();
        $usulan    = Usulan::where('id_usulan', $request->usulan_id)->first();

        if ($usulanAtk) {
            $total = $usulanAtk->jumlah + $request->jumlah;
            UsulanAtk::where('id_detail', $usulanAtk->id_detail)->update([
                'jumlah' => $total,
                'status' => $usulanAtk->usulan->status_persetujuan == 'true' ? 'true' : 'false'
            ]);
        } else {
            $atk = Atk::where('id_atk', $request->id_atk)->first();
            $id_detail = UsulanAtk::withTrashed()->count() + 1;
            $tambah = new UsulanAtk();
            $tambah->id_detail  = $id_detail;
            $tambah->usulan_id  = $request->usulan_id;
            $tambah->atk_id     = $request->id_atk;
            $tambah->jumlah     = $request->jumlah;
            $tambah->satuan_id  = $atk->satuan_id;
            $tambah->status     = $usulan->status_persetujuan == 'true' ? 'true' : 'false';
            $tambah->created_at = Carbon::now();
            $tambah->save();
        }

        return redirect()->back()->with('success', 'Berhasil Menyimpan');
    }

    public function update(Request $request)
    {
        $usulanAtk = UsulanAtk::where('atk_id', $request->id_atk)->where('usulan_id', $request->usulan_id)->first();

        $atk       = Atk::where('id_atk', $request->id_atk)->first();
        if ($usulanAtk) {
            $total = $usulanAtk->jumlah + $request->jumlah;
            UsulanAtk::where('id_detail', $usulanAtk->id_detail)->update([
                'jumlah'    => $request->jumlah,
                'satuan_id' => $atk->satuan_id,
                'status'    => $usulanAtk->usulan->status_persetujuan == 'true' ? 'true' : 'false'
            ]);
        } else {
            UsulanAtk::where('id_detail', $request->id_detail)->update([
                'atk_id'    => $request->id_atk,
                'jumlah'    => $request->jumlah,
                'satuan_id' => $atk->satuan_id,
                'status'    => 'true'
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil Menyimpan');
    }

    public function delete($id)
    {
        UsulanAtk::where('id_detail', $id)->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus');
    }
}
