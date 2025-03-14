<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\AtkDistribusi;
use App\Models\AtkDistribusiDetail;
use App\Models\AtkKategori;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Str;

class AtkDistribusiController extends Controller
{
    public function show(Request $request)
    {
        $uker     = $request->uker;
        $bulan    = $request->bulan;
        $tahun    = $request->tahun;
        $data     = AtkDistribusi::orderBy('id_distribusi', 'asc');
        $listUker = UnitKerja::where('utama_id', '46593')->orderBy('unit_kerja', 'asc')->get();

        if (Auth::user()->role_id == 4) {
            $data = $data->where('user_id', Auth::user()->id)->count();
        } else {
            $data = $data->count();
        }

        return view('pages.atk.distribusi.show', compact('data', 'uker', 'tahun', 'bulan', 'listUker'));
    }

    public function detail($id)
    {
        $data = AtkDistribusi::where('id_distribusi', $id)->first();

        return view('pages.atk.distribusi.detail', compact('data'));
    }

    public function select(Request $request)
    {
        $role   = Auth::user()->role_id;
        $uker   = $request->uker;
        $bulan  = $request->bulan;
        $tahun  = $request->tahun;
        $search = $request->search;

        $data   = AtkDistribusi::orderBy('id_distribusi', 'asc');

        if ($role == 4) {
            $data = $data->where('user_id', Auth::user()->id);
        }

        if ($uker || $bulan || $tahun || $search) {
            if ($bulan) {
                $res = $data->whereMonth('tanggal', $request->bulan);
            }

            if ($tahun) {
                $res = $data->whereYear('tanggal', $request->tahun);
            }

            if ($uker) {
                $res = $data->whereHas('user.pegawai', function ($query) use ($uker) {
                    $query->where('uker_id', $uker);
                });
            }

            if ($search) {
                $res = $data->where('nama_pegawai', 'like', '%' . $search . '%');
            }

            $result = $res->get();
        } else {
            $result = $data->get();
        }

        $no         = 1;
        $response   = [];
        foreach ($result as $row) {
            $aksi   = '';
            $status = '';

            $aksi .= '
                <a href="' . route('atk-distribusi.detail', $row->id_distribusi) . '" class="btn btn-default btn-xs bg-primary rounded border-dark">
                    <i class="fas fa-info-circle p-1" style="font-size: 12px;"></i>
                </a>
            ';

            if ($role == 4) {
                $aksi .= '
                    <a href="' . route('atk-distribusi.edit', $row->id_distribusi) . '" class="btn btn-default btn-xs bg-warning rounded border-dark">
                        <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                    </a>
                ';
            }

            $response[] = [
                'no'         => $no,
                'id'         => $row->id_distribusi,
                'aksi'       => $aksi,
                'uker'       => $row->user->pegawai->uker->unit_kerja,
                'kode'       => $row->kode,
                'tanggal'    => Carbon::parse($row->tanggal)->isoFormat('DD MMM Y'),
                'keterangan' => $row->keterangan,
                'total'      => $row->detail->count().' barang',
                'detail'     => $row->detail->map(function ($item) {
                    return $item->atk->nama_barang . ', ' . $item->jumlah . $item->satuan->nama_satuan;
                }),
            ];

            $no++;
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $id = AtkDistribusi::withTrashed()->count() + 1;
        $tambah = new AtkDistribusi();
        $tambah->id_distribusi = $id;
        $tambah->user_id       = $request->user;
        $tambah->kode          = strtoupper(Str::random(6));
        $tambah->tanggal       = $request->tanggal;
        $tambah->keterangan    = $request->keterangan;
        $tambah->save();

        return redirect()->route('atk-distribusi.detail', $id)->with('success', 'Berhasil Menambahkan');
    }

    public function edit($id)
    {
        $data     = AtkDistribusi::where('id_distribusi', $id)->first();
        $uker     = UnitKerja::orderBy('unit_kerja', 'asc')->get();
        $kategori = AtkKategori::get();

        return view('pages.atk.distribusi.edit', compact('id', 'data', 'uker', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        AtkDistribusiDetail::where('distribusi_id', $id)->update([
            'status' => 'true',
        ]);

        AtkDistribusi::where('id_distribusi', $id)->update([
            'user_id'    => $request->user,
            'kode'       => $request->kode,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('atk-distribusi.detail', $id)->with('success', 'Berhasil Memperbaharui');
    }

    // ===========================================================
    //                           ITEM
    // ===========================================================

    public function itemStore(Request $request)
    {
        $distribusi = $request->distribusi_id;

        $atk  = AtkDistribusiDetail::where('atk_id', $request->id_atk)->where('distribusi_id', $distribusi)->first();
        $qty  = (int)str_replace('.', '', $request->jumlah);

        if ($atk) {
            return back()->with('failed', 'Barang Terdaftar');
        }

        $atk = Atk::where('id_atk', $request->id_atk)->first();
        $id_detail = AtkDistribusiDetail::withTrashed()->count() + 1;
        $tambah = new AtkDistribusiDetail();
        $tambah->id_detail     = $id_detail;
        $tambah->distribusi_id = $distribusi;
        $tambah->atk_id        = $request->id_atk;
        $tambah->jumlah        = $qty;
        $tambah->satuan_id     = $atk->satuan_id;
        $tambah->save();

        return redirect()->back()->with('success', 'Berhasil Menyimpan');
    }

    public function itemUpdate(Request $request, $id)
    {
        $detail = AtkDistribusiDetail::where('id_detail', $id)->first();
        $atk    = Atk::where('id_atk', $detail->atk_id)->first();
        $qty    = (int)str_replace('.', '', $request->jumlah);

        if ($request->jumlah > $request->stok) {
            return back()->with('failed', 'Melebihi Stok');
        }

        AtkDistribusiDetail::where('id_detail', $id)->update([
            'atk_id'    => $atk->id_atk,
            'jumlah'    => $qty,
            'satuan_id' => $atk->satuan_id
        ]);

        return redirect()->back()->with('success', 'Berhasil Menyimpan');
    }

    public function itemDelete($id)
    {
        AtkDistribusiDetail::where('id_detail', $id)->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus');
    }
}
