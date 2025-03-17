<?php

namespace App\Http\Controllers;

use App\Models\Aadb;
use App\Models\AadbKategori;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Auth;

class AadbController extends Controller
{
    public function index(Request $request)
    {
        $data     = Aadb::orderBy('id_aadb', 'asc');
        $user     = Auth::user();

        $uker         = $request->uker;
        $kategori     = $request->kategori;
        $jenis        = $request->jenis;
        $kualifikasi  = $request->kualifikasi;
        $status       = $request->status;
        $listUker     = UnitKerja::where('utama_id', 46593)->get();
        $listKategori = AadbKategori::where('status', 'true')->orderBy('nama_kategori', 'asc')->get();

        if ($user->role_id == 4) {
            $data = $data->where('uker_id', $user->pegawai->uker_id)->count();
        } else {
            $data = $data->count();
        }

        return view('pages.aadb.show', compact('kategori', 'data', 'uker', 'jenis', 'kualifikasi', 'status', 'listUker', 'listKategori'));
    }

    public function select(Request $request)
    {
        $role         = Auth::user()->role_id;
        $uker         = $request->uker;
        $kategori     = $request->kategori;
        $jenis        = $request->jenis;
        $kualifikasi  = $request->kualifikasi;
        $status       = $request->status;
        $search       = $request->search;

        $data     = Aadb::orderBy('id_aadb', 'asc')->orderBy('status', 'desc');
        $no       = 1;
        $response = [];

        if ($role == 4) {
            $data = $data->where('uker_id', Auth::user()->pegawai->uker_id);
        }

        if ($uker || $kategori || $jenis || $kualifikasi || $status || $search) {
            if ($uker) {
                $res = $data->whereHas('uker', function ($query) use ($uker) {
                    $query->where('id_unit_kerja', $uker);
                });
            }

            if ($kategori) {
                $res = $data->where('kategori_id', $kategori);
            }

            if ($jenis) {
                $res = $data->where('jenis_aadb', $jenis);
            }

            if ($kualifikasi) {
                $res = $data->where('kualifikasi', $kualifikasi);
            }

            if ($status) {
                $res = $data->where('status', $status);
            }

            if ($search) {
                $res = $data->where('merk_tipe', 'like', '%' . $search . '%');
            }

            $result = $res->get();
        } else {
            $result = $data->get();
        }

        foreach ($result as $row) {
            $aksi   = '';
            $status = '';

            if ($row->foto_barang) {
                $foto = '<img src="' . asset('dist/img/foto_aadb/' . $row->foto_barang) . '" class="img-fluid" alt="">';
            } else {
                $foto = '<img src="https://cdn-icons-png.flaticon.com/128/7571/7571054.png" class="img-fluid" alt="">';
            }

            if ($role != 4) {
                $aksi .= '
                    <a href="' . route('aadb.detail', $row->id_aadb) . '" class="btn btn-default btn-xs bg-primary rounded border-dark">
                        <i class="fas fa-info-circle p-1" style="font-size: 12px;"></i>
                    </a>
                ';
            }

            if ($row->status == 'true') {
                $status = '<i class="fas fa-check-circle text-success"></i>';
            } else {
                $status = '<i class="fas fa-times-circle text-danger"></i>';
            }

            $response[] = [
                'no'          => $no,
                'id'          => $row->id_aadb,
                'aksi'        => $aksi,
                'foto'        => $foto,
                'fileFoto'    => $row->foto_barang,
                'kategori'    => $row->kategori->nama_kategori,
                'jenis'       => $row->jenis_aadb,
                'kualifikasi' => $row->kualifikasi,
                'merktipe'    => $row->merk_tipe,
                'deskripsi'   => $row->deskripsi,
                'nopolisi'    => $row->no_polisi,
                'nobpkp'      => $row->no_bpkp,
                'tanggal'     => $row->tanggal_perolehan,
                'nilai'       => 'Rp' . number_format($row->nilai_perolehan, 0, '.'),
                'keterangan'  => $row->keterangan ?? ''
            ];

            $no++;
        }

        return response()->json($response);
    }
}
