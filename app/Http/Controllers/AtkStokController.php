<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\AtkKategori;
use App\Models\AtkKeranjang;
use App\Models\AtkStok;
use App\Models\AtkStokDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Str;

class AtkStokController extends Controller
{
    public function show()
    {
        $data = AtkStok::get();
        return view('pages.atk.stok.show', compact('data'));
    }

    public function detail($id)
    {
        $data = AtkStok::where('id_stok', $id)->first();
        return view('pages.atk.stok.detail', compact('data'));
    }

    public function store(Request $request)
    {
        $id_stok = AtkStok::withTrashed()->count() + 1;

        $detail = $request->id_keranjang;
        foreach ($detail as $i => $keranjang_id) {
            $id_detail = AtkStokDetail::withTrashed()->count() + 1;
            $detail = new AtkStokDetail();
            $detail->id_detail  = $id_detail;
            $detail->stok_id    = $id_stok;
            $detail->atk_id     = $request->id_atk[$i];
            $detail->jumlah     = $request->jumlah[$i];
            $detail->created_at = Carbon::now();
            $detail->save();

            AtkKeranjang::where('id_keranjang', $keranjang_id)->delete();
        }

        $stok = new AtkStok();
        $stok->id_stok       = $id_stok;
        $stok->kode_stok     = strtoupper(Str::random(6));
        $stok->tanggal_masuk = $request->tanggal;
        $stok->keterangan    = $request->keterangan;
        $stok->created_at    = Carbon::now();
        $stok->save();

        return redirect()->route('atk-stok.detail', $id_stok)->with('success', 'Berhasil Menambahkan');
    }

    public function edit($id)
    {
        $kategori = AtkKategori::where('status', 'true')->orderBy('status', 'asc')->get();
        $data = AtkStok::where('id_stok', $id)->first();
        return view('pages.atk.stok.edit', compact('kategori', 'data'));
    }

    public function update(Request $request, $id)
    {
        AtkStok::where('id_stok', $id)->update([
            'tanggal_masuk' => $request->tanggal_masuk,
            'no_kwitansi'   => $request->no_kwitansi,
            'total_harga'   => (int)str_replace('.', '', $request->total_harga),
            'keterangan'    => $request->keterangan,
            'created_at'    => Carbon::now()
        ]);

        return redirect()->route('atk-stok.detail', $id)->with('success', 'Berhasil Menyimpan');
    }

    public function delete($id)
    {
        AtkStokDetail::where('stok_id', $id)->delete();
        AtkStok::where('id_stok', $id)->delete();

        return redirect()->route('atk-stok')->with('success', 'Berhasil Menghapus');
    }

    // ===========================================================
    //                           ITEM
    // ===========================================================

    public function itemStore(Request $request)
    {
        $stok = $request->stok_id;

        $atk  = AtkStokDetail::where('atk_id', $request->id_atk)->where('stok_id', $stok)->first();
        $qty  = (int)str_replace('.', '', $request->jumlah);

        if ($atk) {
            $total = $atk->jumlah + $qty;
            AtkStokDetail::where('id_detail', $atk->id_detail)->update([
                'jumlah' => $total
            ]);
        } else {
            $id_detail = AtkStokDetail::withTrashed()->count() + 1;
            $tambah = new AtkStokDetail();
            $tambah->id_detail    = $id_detail;
            $tambah->stok_id      = $stok;
            $tambah->atk_id       = $request->id_atk;
            $tambah->jumlah       = $qty;
            $tambah->created_at   = Carbon::now();
            $tambah->save();
        }

        return redirect()->back()->with('success', 'Berhasil Menyimpan');
    }

    public function itemUpdate(Request $request, $id)
    {
        $stok = $request->stok_id;

        $snc  = AtkStokDetail::where('atk_id', $request->id_atk)->where('stok_id', $stok)->first();
        $qty  = (int)str_replace('.', '', $request->jumlah);

        if ($snc) {
            AtkStokDetail::where('id_detail', $snc->id_detail)->update([
                'jumlah' => $qty
            ]);
        } else {
            AtkStokDetail::where('id_detail', $id)->update([
                'atk_id' => $request->id_atk,
                'jumlah' => $qty
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil Menyimpan');
    }

    public function itemDelete($id)
    {
        AtkStokDetail::where('id_detail', $id)->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus');
    }


    // ===========================================================
    //                         STOK READY
    // ===========================================================

    public function ready()
    {
        $role = Auth::user()->role_id;
        $data = Atk::all()->map(function ($item) {
            return [
                'id'            => $item->id_atk,
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
