<?php

namespace App\Http\Controllers;

use App\Models\Bmhp;
use App\Models\BmhpKategori;
use App\Models\BmhpKeranjang;
use App\Models\BmhpStok;
use App\Models\BmhpStokDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Str;

class BmhpStokController extends Controller
{
    public function show()
    {
        $data = BmhpStok::get();
        return view('pages.bmhp.stok.show', compact('data'));
    }

    public function detail($id)
    {
        $data = BmhpStok::where('id_stok', $id)->first();
        return view('pages.bmhp.stok.detail', compact('data'));
    }

    public function store(Request $request)
    {
        $id_stok = BmhpStok::withTrashed()->count() + 1;

        $detail = $request->id_keranjang;
        foreach ($detail as $i => $keranjang_id) {
            $id_detail = BmhpStokDetail::withTrashed()->count() + 1;
            $detail = new BmhpStokDetail();
            $detail->id_detail  = $id_detail;
            $detail->stok_id    = $id_stok;
            $detail->bmhp_id    = $request->id_bmhp[$i];
            $detail->jumlah     = $request->jumlah[$i];
            $detail->created_at = Carbon::now();
            $detail->save();

            BmhpKeranjang::where('id_keranjang', $keranjang_id)->delete();
        }

        $stok = new BmhpStok();
        $stok->id_stok       = $id_stok;
        $stok->kode_stok     = strtoupper(Str::random(6));
        $stok->tanggal_masuk = $request->tanggal;
        $stok->keterangan    = $request->keterangan;
        $stok->created_at    = Carbon::now();
        $stok->save();

        return redirect()->route('bmhp-stok.detail', $id_stok)->with('success', 'Berhasil Menambahkan');
    }

    public function edit($id)
    {
        $kategori = BmhpKategori::where('status', 'true')->orderBy('status', 'asc')->get();
        $data = BmhpStok::where('id_stok', $id)->first();
        return view('pages.bmhp.stok.edit', compact('kategori', 'data'));
    }

    public function update(Request $request, $id)
    {
        BmhpStok::where('id_stok', $id)->update([
            'tanggal_beli'  => $request->tanggal_masuk,
            'no_kwitansi'   => $request->no_kwitansi,
            'total_harga'   => (int)str_replace('.', '', $request->total_harga),
            'keterangan'    => $request->keterangan,
            'created_at'    => Carbon::now()
        ]);

        return redirect()->route('bmhp-stok.detail', $id)->with('success', 'Berhasil Menyimpan');
    }

    public function delete($id)
    {
        BmhpStokDetail::where('stok_id', $id)->delete();
        BmhpStok::where('id_stok', $id)->delete();

        return redirect()->route('bmhp-stok')->with('success', 'Berhasil Menghapus');
    }

    // ===========================================================
    //                           ITEM
    // ===========================================================

    public function itemStore(Request $request)
    {
        $stok = $request->stok_id;

        $bmhp  = BmhpStokDetail::where('bmhp_id', $request->id_bmhp)->where('stok_id', $stok)->first();
        $qty  = (int)str_replace('.', '', $request->jumlah);

        if ($bmhp) {
            $total = $bmhp->jumlah + $qty;
            BmhpStokDetail::where('id_detail', $bmhp->id_detail)->update([
                'jumlah' => $total
            ]);
        } else {
            $id_detail = BmhpStokDetail::withTrashed()->count() + 1;
            $tambah = new BmhpStokDetail();
            $tambah->id_detail    = $id_detail;
            $tambah->stok_id      = $stok;
            $tambah->bmhp_id      = $request->id_bmhp;
            $tambah->jumlah       = $qty;
            $tambah->created_at   = Carbon::now();
            $tambah->save();
        }

        return redirect()->back()->with('success', 'Berhasil Menyimpan');
    }

    public function itemUpdate(Request $request, $id)
    {
        $stok = $request->stok_id;

        $snc  = BmhpStokDetail::where('bmhp_id', $request->id_bmhp)->where('stok_id', $stok)->first();
        $qty  = (int)str_replace('.', '', $request->jumlah);

        if ($snc) {
            BmhpStokDetail::where('id_detail', $snc->id_detail)->update([
                'jumlah' => $qty
            ]);
        } else {
            BmhpStokDetail::where('id_detail', $id)->update([
                'bmhp_id' => $request->id_bmhp,
                'jumlah'  => $qty
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil Menyimpan');
    }

    public function itemDelete($id)
    {
        BmhpStokDetail::where('id_detail', $id)->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus');
    }


    // ===========================================================
    //                         STOK READY
    // ===========================================================

    public function ready()
    {
        $role = Auth::user()->role_id;
        $data = Bmhp::all()->map(function ($item) {
            return [
                'id'            => $item->id_bmhp,
                'nama_barang'   => $item->nama_barang,
                'stok_tersedia' => $item->stokUker(),
                'satuan'        => $item->satuan->nama_satuan
            ];
        })->filter(function ($item) {
            return $item['stok_tersedia'] > 0;
        })->values();

        return response()->json($data);
    }
}
