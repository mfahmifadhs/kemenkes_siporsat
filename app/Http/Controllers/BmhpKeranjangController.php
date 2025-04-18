<?php

namespace App\Http\Controllers;

use App\Models\BmhpKeranjang;
use App\Models\UsulanBmhp;
use Illuminate\Http\Request;
use Auth;

class BmhpKeranjangController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->uker) {
            return redirect()->route('usulan.store', 'bmhp');
        }
    }

    public function reusul($id)
    {
        $data = UsulanBmhp::where('usulan_id', $id)->get();
        foreach ($data as $bmhp) {
            $id_keranjang = BmhpKeranjang::withTrashed()->count() + 1;
            $tambah = new BmhpKeranjang();
            $tambah->id_keranjang = $id_keranjang;
            $tambah->user_id      = Auth::user()->id;
            $tambah->bmhp_id      = $bmhp->bmhp_id;
            $tambah->jumlah       = (int) str_replace('.', '', $bmhp->jumlah);
            $tambah->status       = 'false';
            $tambah->save();
        }

        return redirect()->route('bmhp')->with('success', 'Berhasil Menambahkan');

    }

    public function create(Request $request)
    {
        $bucket = BmhpKeranjang::where('user_id', Auth::user()->id)->where('bmhp_id', $request->bmhp_id)->first();

        if ($bucket) {
            BmhpKeranjang::where('id_keranjang', $bucket->id_keranjang)->update([
                'jumlah' => $bucket->jumlah + (int) str_replace('.', '', $request->qty)
            ]);
        } else {
            $id_keranjang = BmhpKeranjang::withTrashed()->count() + 1;
            $tambah = new BmhpKeranjang();
            $tambah->id_keranjang = $id_keranjang;
            $tambah->user_id      = Auth::user()->id;
            $tambah->bmhp_id       = $request->bmhp_id;
            $tambah->jumlah       = (int) str_replace('.', '', $request->qty);
            $tambah->status       = $request->status;
            $tambah->save();
        }

        $dataCartCount  = BmhpKeranjang::where('user_id', Auth::user()->id);
        $dataCartBasket = BmhpKeranjang::where('user_id', Auth::user()->id)
            ->join('t_bmhp', 'id_bmhp', 'bmhp_id')
            ->join('t_bmhp_kategori', 'id_kategori', 'kategori_id')
            ->join('t_atk_satuan', 'id_satuan', 'satuan_id')
            ->orderBy('id_keranjang', 'ASC');

        if ($request->status_id) {
            $cartCount  = $dataCartCount->where('t_bmhp_keranjang.status', $request->status_id)->count();
            $cartBasket = $dataCartBasket->where('t_bmhp_keranjang.status', $request->status_id)->get();
        } else {
            $cartCount  = $dataCartCount->count();
            $cartBasket = $dataCartBasket->get();
        }

        return response()->json(['message' => 'Item berhasil ditambahkan ke keranjang', 'cartCount' => $cartCount, 'cartBasket' => $cartBasket]);
    }

    public function update(Request $request, $aksi, $id)
    {
        $bucket = BmhpKeranjang::where('id_keranjang', $id)->first();

        if ($aksi == 'min') {
            $jumlah = $bucket->jumlah - 1;
        } else {
            $jumlah = $bucket->jumlah + 1;
        }

        if ($bucket) {
            BmhpKeranjang::where('id_keranjang', $id)->update([
                'jumlah' => $jumlah
            ]);

            $updated = BmhpKeranjang::where('id_keranjang', $id)->first();
        } else {
            UsulanBmhp::where('id_detail', $id)->update([
                'jumlah_permintaan' => $jumlah
            ]);

            $updated = UsulanBmhp::where('id_detail', $id)->first();
        }

        return response()->json(['updatedKuantitas' => $updated]);
    }

    public function remove($id)
    {
        BmhpKeranjang::where('id_keranjang', $id)->delete();

        $cartCount  = BmhpKeranjang::where('user_id', Auth::user()->id)->count();
        $cartBasket = BmhpKeranjang::where('user_id', Auth::user()->id)
            ->join('t_bmhp', 'id_bmhp', 'bmhp_id')->join('t_bmhp_kategori', 'id_kategori', 'kategori_id')
            ->orderBy('id_keranjang', 'ASC')
            ->get();

        return response()->json(['message' => 'Item berhasil ditambahkan ke keranjang', 'cartCount' => $cartCount, 'cartBasket' => $cartBasket]);
    }
}
