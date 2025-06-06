<?php

namespace App\Http\Controllers;

use App\Models\AtkKeranjang;
use App\Models\Usulan;
use App\Models\UsulanAtk;
use Illuminate\Http\Request;
use Auth;

class AtkKeranjangController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->uker) {
            return redirect()->route('usulan.store', 'atk');
        }
    }

    public function reusul($id)
    {
        $usulan = Usulan::where('id_usulan', $id)->first();
        $data   = UsulanAtk::where('usulan_id', $id)->get();
        foreach ($data as $atk) {
            $id_keranjang = AtkKeranjang::withTrashed()->count() + 1;
            $tambah = new AtkKeranjang();
            $tambah->id_keranjang = $id_keranjang;
            $tambah->user_id      = Auth::user()->id;
            $tambah->atk_id       = $atk->atk_id;
            $tambah->jumlah       = (int) str_replace('.', '', $atk->jumlah);
            $tambah->status       = 'false';
            $tambah->save();
        }

        // if ($usulan->status_persetujuan == 'false') {
        //     Usulan::where('id_usulan', $id)->update([
        //         'status_persetujuan' => null,
        //         'keterangan_tolak'   => null
        //     ]);
        // }

        return redirect()->route('atk')->with('success', 'Berhasil Menambahkan');

    }

    public function create(Request $request)
    {
        $bucket = AtkKeranjang::where('user_id', Auth::user()->id)->where('atk_id', $request->atk_id)->first();

        if ($bucket) {
            AtkKeranjang::where('id_keranjang', $bucket->id_keranjang)->update([
                'jumlah' => $bucket->jumlah + (int) str_replace('.', '', $request->qty)
            ]);
        } else {
            $id_keranjang = AtkKeranjang::withTrashed()->count() + 1;
            $tambah = new AtkKeranjang();
            $tambah->id_keranjang = $id_keranjang;
            $tambah->user_id      = Auth::user()->id;
            $tambah->atk_id       = $request->atk_id;
            $tambah->jumlah       = (int) str_replace('.', '', $request->qty);
            $tambah->status       = $request->status;
            $tambah->save();
        }

        $dataCartCount  = AtkKeranjang::where('user_id', Auth::user()->id);
        $dataCartBasket = AtkKeranjang::where('user_id', Auth::user()->id)
            ->join('t_atk', 'id_atk', 'atk_id')
            ->join('t_atk_kategori', 'id_kategori', 'kategori_id')
            ->join('t_atk_satuan', 'id_satuan', 'satuan_id')
            ->orderBy('id_keranjang', 'ASC');

        if ($request->status_id) {
            $cartCount  = $dataCartCount->where('t_atk_keranjang.status', $request->status_id)->count();
            $cartBasket = $dataCartBasket->where('t_atk_keranjang.status', $request->status_id)->get();
        } else {
            $cartCount  = $dataCartCount->count();
            $cartBasket = $dataCartBasket->get();
        }

        return response()->json(['message' => 'Item berhasil ditambahkan ke keranjang', 'cartCount' => $cartCount, 'cartBasket' => $cartBasket]);
    }

    public function update(Request $request, $aksi, $id)
    {
        $bucket = AtkKeranjang::where('id_keranjang', $id)->first();

        if ($aksi == 'min') {
            $jumlah = $bucket->jumlah - 1;
        } else {
            $jumlah = $bucket->jumlah + 1;
        }

        if ($bucket) {
            AtkKeranjang::where('id_keranjang', $id)->update([
                'jumlah' => $jumlah
            ]);

            $updated = AtkKeranjang::where('id_keranjang', $id)->first();
        } else {
            UsulanAtk::where('id_detail', $id)->update([
                'jumlah_permintaan' => $jumlah
            ]);

            $updated = UsulanAtk::where('id_detail', $id)->first();
        }

        return response()->json(['updatedKuantitas' => $updated]);
    }

    public function remove($id)
    {
        AtkKeranjang::where('id_keranjang', $id)->delete();

        $cartCount  = AtkKeranjang::where('user_id', Auth::user()->id)->count();
        $cartBasket = AtkKeranjang::where('user_id', Auth::user()->id)
            ->join('t_atk', 'id_atk', 'atk_id')->join('t_atk_kategori', 'id_kategori', 'kategori_id')
            ->orderBy('id_keranjang', 'ASC')
            ->get();

        return response()->json(['message' => 'Item berhasil ditambahkan ke keranjang', 'cartCount' => $cartCount, 'cartBasket' => $cartBasket]);
    }
}
