<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\AtkKategori;
use App\Models\AtkSatuan;
use App\Models\Usulan;
use Illuminate\Http\Request;
use Auth;

class AtkController extends Controller
{
    public function index()
    {
        $kategori = AtkKategori::where('status', 'true')->orderBy('nama_kategori', 'asc')->get();
        $atk      = Atk::where('status', 'true')->orderBy('nama_barang', 'asc')->get();
        $user     = Auth::user();
        $data     = Usulan::where('form_id', '3');

        if ($user->role_id == 4) {
            $usulan = $data->where('user_id', $user->id)->get();
        } else {
            $usulan = $data->get();
        }

        return view('pages.usulan.atk.create', compact('kategori', 'atk', 'usulan'));
    }

    public function detail($id)
    {
        $data = Atk::where('id_atk', $id)->first();
        return view('pages.atk.detail', compact('data'));
    }

    public function selectById($id)
    {
        $data = Atk::with('kategori')->find($id);

        if ($data) {
            return response()->json($data);
        }

        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    public function selectByCategory($id)
    {
        $data = Atk::orderBy('nama_barang', 'ASC');
        $response = array();

        if ($id) {
            $result = $data->where('kategori_id', $id)->get();
        } else {
            $result = $data->get();
        }

        $response[] = array(
            "id"    => "",
            "text"  => "-- Pilih Barang --"
        );

        foreach ($result as $row) {
            $response[] = array(
                "id"     => $row->id_atk,
                "text"   => $row->nama_barang . ' ' . $row->deskripsi,
                "satuan" => $row->satuan->nama_satuan
            );
        }

        return response()->json($response);
    }

    public function select(Request $request)
    {
        $role     = Auth::user()->role_id;
        $kategori = $request->kategori;
        $barang   = $request->barang;
        $status   = $request->status;
        $search   = $request->search;

        $data    = Atk::orderBy('id_atk', 'asc')->orderBy('status', 'desc');
        $no       = 1;
        $response = [];

        if ($kategori || $barang || $search) {
            if ($kategori) {
                $res = $data->whereHas('kategori', function ($query) use ($kategori) {
                    $query->where('id_kategori', $kategori);
                });
            }

            if ($barang) {
                $res = $data->where('id_atk', $barang);
            }

            if ($search) {
                $res = $data->where('nama_barang', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            }

            $result = $res->get();
        } else {
            $result = $data->get();
        }

        if ($status) {
            if (Auth::user()->role_id == 4) {
                // Jika Role 4, maka filter berdasarkan stok Uker
                $result = $result->filter(function ($row) {
                    return $row->stokUker(Auth::user()->pegawai->uker_id) > 0;
                });
            } else {
                // Jika bukan Role 4, filter berdasarkan stok umum
                $result = $result->filter(function ($row) use ($status) {
                    $stok = $row->stok();

                    if ($status == 'true') {
                        return $stok > 0;
                    } elseif ($status == 'false') {
                        return $stok == 0;
                    }

                    return true;
                });
            }
        }

        foreach ($result as $row) {
            $aksi   = '';
            $status = '';

            if ($role == 4) {
                $stok   = number_format($row->stokUker(Auth::user()->pegawai->uker_id), 0, '.');
            } else {
                $stok = number_format($row->stok(), 0, '.');
            }

            if ($row->foto_barang) {
                $foto = '<img src="' . asset('dist/img/foto_atk/' . $row->foto_barang) . '" class="img-fluid" alt="">';
            } else {
                $foto = '<img src="https://cdn-icons-png.flaticon.com/512/679/679821.png" class="img-fluid" alt="">';
            }

            if ($stok > 0) {
                $stokStatus = '<span class="badge badge-success p-1 w-100"><i class="fas fa-check-circle"></i> Tersedia</span>';
            } else {
                $stokStatus = '<span class="badge badge-danger p-1 w-100"><i class="fas fa-times-circle"></i> Tidak Tersedia</span>';
            }

            if ($role != 4) {
                $aksi .= '
                    <a href="' . route('atk-barang.detail', $row->id_atk) . '" class="btn btn-default btn-xs bg-primary rounded border-dark">
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
                'no'         => $no,
                'id'         => $row->id_atk,
                'aksi'       => $aksi,
                'foto'       => $foto,
                'fileFoto'   => $row->foto_barang,
                'kategori'   => $row->kategori->nama_kategori,
                'barang'     => $row->nama_barang,
                'deskripsi'  => $row->deskripsi,
                'harga'      => 'Rp' . number_format($row->harga, 0, '.'),
                'satuan'     => $row->satuan->nama_satuan,
                'maksimal'   => $row->jumlah_maks,
                'stok'       => $stok,
                'keterangan' => $row->keterangan ?? '',
                'stokStatus' => $stokStatus,
                'status'     => $status,
                'role'       => $role
            ];

            $no++;
        }

        return response()->json($response);
    }

    public function show(Request $request)
    {
        $data     = Atk::orderBy('id_atk', 'asc')->get();
        $kategori = $request->get('kategori');
        $barang   = $request->get('barang');
        $status   = $request->get('status');

        $listKategori = AtkKategori::orderBy('nama_kategori', 'asc')->get();
        $listSatuan   = AtkSatuan::orderBy('nama_satuan', 'asc')->get();

        return view('pages.atk.show', compact('data', 'kategori', 'barang', 'status', 'listKategori', 'listSatuan'));
    }

    public function edit($id)
    {
        $data     = Atk::where('id_atk', $id)->first();
        $kategori = AtkKategori::where('status', 'true')->orderBy('status', 'asc')->get();
        $satuan   = AtkSatuan::orderBy('nama_satuan', 'asc')->get();
        return view('pages.atk.edit', compact('data','kategori','satuan'));
    }

    public function update(Request $request)
    {
        $data = Atk::where('id_atk', $request->id_atk)->first();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = $file->getClientOriginalName();
            $request->foto->move(public_path('dist/img/foto_atk'), $fileName);
        }

        Atk::where('id_atk', $request->id_atk)->update([
            'kategori_id' => $request->kategori,
            'nama_barang' => $request->nama_barang,
            'deskripsi'   => $request->deskripsi,
            'satuan_id'   => $request->satuan,
            'jumlah_maks' => $request->maksimal,
            'harga'       => (int)str_replace('.', '', $request->harga),
            'keterangan'  => $request->keterangan,
            'foto_barang' => $fileName ?? $data->foto_barang,
            'status'      => $request->status
        ]);

        return redirect()->back()->with('success', 'Berhasil Menyimpan Perubahan');
    }

    public function create()
    {
        $kategori = AtkKategori::where('status', 'true')->orderBy('status', 'asc')->get();
        $satuan   = AtkSatuan::orderBy('nama_satuan', 'asc')->get();
        return view('pages.atk.create', compact('kategori','satuan'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = $file->getClientOriginalName();
            $request->foto->move(public_path('dist/img/foto_atk'), $fileName);
        }

        $id_atk = Atk::withTrashed()->count() + 1;
        $tambah = new Atk();
        $tambah->id_atk = $id_atk;
        $tambah->kategori_id = $request->kategori;
        $tambah->nama_barang = $request->nama_barang;
        $tambah->deskripsi   = $request->deskripsi;
        $tambah->satuan_id   = $request->satuan;
        $tambah->jumlah_maks = $request->maksimal;
        $tambah->harga       = (int)str_replace('.', '', $request->harga);
        $tambah->keterangan  = $request->keterangan;
        $tambah->foto_barang = $fileName ?? null;
        $tambah->status      = $request->status;
        $tambah->save();

        return redirect()->route('atk-barang.detail', $id_atk)->with('success', 'Berhasil Menambah');
    }
}
