<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PegawaiJabatan;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function show(Request $request)
    {
        $data    = Pegawai::count();
        $uker    = $request->uker;
        $jabatan = $request->jabatan;
        $status  = $request->status;

        $listUker    = UnitKerja::orderBy('unit_kerja','asc')->get();
        $listJabatan = PegawaiJabatan::get();

        return view('pages.pegawai.show', compact('data','uker','jabatan','status','listUker','listJabatan'));
    }

    public function detail($id)
    {
        $data = Pegawai::where('id_pegawai', $id)->first();

        return view('pages.pegawai.detail', compact('data'));
    }

    public function select(Request $request)
    {
        $uker       = $request->uker;
        $jabatan    = $request->jabatan;
        $status     = $request->status;
        $search     = $request->search;

        $data       = Pegawai::orderBy('status', 'desc');

        if ($uker || $jabatan || $status || $search) {

            if ($uker) {
                $res = $data->where('uker_id', $uker);
            }

            if ($jabatan) {
                $res = $data->where('jabatan_id', $jabatan);
            }

            if ($status) {
                $res = $data->where('status', $status);
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
                <a href="' . route('pegawai.detail', $row->id_pegawai) . '" class="btn btn-default btn-xs bg-primary rounded border-dark">
                    <i class="fas fa-info-circle p-1" style="font-size: 12px;"></i>
                </a>

                <a href="' . route('pegawai.edit', $row->id_pegawai) . '" class="btn btn-default btn-xs bg-warning rounded border-dark">
                    <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                </a>
            ';

            $response[] = [
                'no'      => $no,
                'id'      => $row->id_pegawai,
                'aksi'    => $aksi,
                'uker'    => $row->uker->unit_kerja,
                'nip'     => $row->nip,
                'nama'    => $row->nama_pegawai,
                'jabatan' => $row->jabatan->jabatan,
                'timker'  => $row->tim_kerja ?? '',
                'status'  => $row->status
            ];

            $no++;
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $id = Pegawai::withTrashed()->count() + 1;
        $tambah = new Pegawai();
        $tambah->id_pegawai     = $id;
        $tambah->uker_id        = $request->uker;
        $tambah->nip            = $request->nip;
        $tambah->nama_pegawai   = $request->pegawai;
        $tambah->jabatan_id     = $request->jabatan;
        $tambah->tim_kerja      = $request->timker;
        $tambah->status         = $request->status;
        $tambah->save();

        return redirect()->route('pegawai.detail', $id)->with('success', 'Berhasil Menambahkan');
    }

    public function edit($id)
    {

        $data    = Pegawai::where('id_pegawai', $id)->first();
        $uker    = UnitKerja::orderBy('unit_kerja','asc')->get();
        $jabatan = PegawaiJabatan::get();

        return view('pages.pegawai.edit', compact('data','uker','jabatan'));
    }

    public function update(Request $request, $id)
    {
        Pegawai::where('id_pegawai', $id)->update([
            'uker_id'      => $request->uker,
            'nip'          => $request->nip,
            'nama_pegawai' => $request->pegawai,
            'jabatan_id'   => $request->jabatan,
            'tim_kerja'    => $request->timker,
            'status'       => $request->status
        ]);

        return redirect()->route('pegawai.detail', $id)->with('success', 'Berhasil Memperbaharui');
    }
}
