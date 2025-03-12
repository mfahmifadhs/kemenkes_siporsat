<?php

namespace App\Http\Controllers;

use App\Models\PegawaiJabatan;
use App\Models\Role;
use App\Models\UnitKerja;
use App\Models\User;
use App\Models\UserAkses;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Hash;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $data    = User::count();
        $role    = Role::get();
        $akses   = UserAkses::get();
        $uker    = $request->uker;
        $jabatan = $request->jabatan;
        $status  = $request->status;

        $listUker    = UnitKerja::orderBy('unit_kerja','asc')->get();
        $listJabatan = PegawaiJabatan::get();

        return view('pages.users.show', compact('role','akses','data','uker','jabatan','status','listUker','listJabatan'));
    }

    public function detail($id)
    {
        $data = User::where('id', $id)->first();

        return view('pages.users.detail', compact('data'));
    }

    public function select(Request $request)
    {
        $uker       = $request->uker;
        $jabatan    = $request->jabatan;
        $status     = $request->status;
        $search     = $request->search;

        $data       = User::with('pegawai')->orderBy('status', 'desc');

        if ($uker || $jabatan || $status || $search) {

            if ($uker) {
                $res = $data->whereHas('pegawai.uker', function ($query) use ($uker) {
                    $query->where('uker_id', $uker);
                });
            }

            if ($jabatan) {
                $res = $data->whereHas('pegawai', function ($query) use ($jabatan) {
                    $query->where('jabatan_id', $jabatan);
                });
            }

            if ($status) {
                $res = $data->where('status', $status);
            }

            if ($search) {
                $res = $data->whereHas('pegawai.uker', function ($query) use ($search) {
                    $query->where('nama_pegawai', 'like', '%' . $search . '%');
                });
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
                <a href="' . route('pegawai.detail', $row->pegawai_id) . '" class="btn btn-default btn-xs bg-primary rounded border-dark">
                    <i class="fas fa-info-circle p-1" style="font-size: 12px;"></i>
                </a>

                <a href="' . route('users.edit', $row->id) . '" class="btn btn-default btn-xs bg-warning rounded border-dark">
                    <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                </a>
            ';

            $response[] = [
                'no'         => $no,
                'id'         => $row->id,
                'aksi'       => $aksi,
                'role'       => $row->role->nama_role,
                'uker'       => $row->pegawai->uker->unit_kerja,
                'nip'        => $row->pegawai->nip,
                'nama'       => $row->pegawai->nama_pegawai,
                'jabatan'    => $row->pegawai->jabatan->jabatan,
                'timker'     => $row->pegawai->tim_kerja ?? '',
                'username'   => $row->username,
                'keterangan' => $row->keterangan ?? '',
                'akses'      => $row->akses?->nama_akses ?? '',
                'status'     => $row->status,
            ];

            $no++;
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $user = User::where('username', $request->username)->orWhere('pegawai_id', $request->pegawai_id)->count();

        if ($user != 0) {
            return back()->with('failed', 'Username sudah terdaftar');
        }

        $id_user = User::withTrashed()->count() + 1;
        $user = new User();
        $user->id            = $id_user;
        $user->role_id       = $request->role;
        $user->pegawai_id    = $request->pegawai;
        $user->username      = $request->username;
        $user->password      = Hash::make($request->password);
        $user->password_teks = $request->password;
        $user->keterangan    = $request->keterangan;
        $user->akses_id      = $request->akses;
        $user->status        = $request->status ?? 'true';
        $user->created_at    = Carbon::now();
        $user->save();

        return redirect()->route('users.detail', $id_user)->with('success', 'Berhasil Menambahkan');
    }

    public function edit($id)
    {
        $data  = User::where('id', $id)->first();
        $role  = Role::get();
        $akses = UserAkses::get();
        return view('pages.users.edit', compact('data','role','akses'));
    }

    public function update(Request $request, $id)
    {
        User::where('id', $id)->update([
            'role_id'       => $request->role,
            'pegawai_id'    => $request->pegawai,
            'username'      => $request->username,
            'password'      => Hash::make($request->password),
            'password_teks' => $request->password,
            'keterangan'    => $request->keterangan,
            'akses_id'      => $request->akses,
            'status'        => $request->status
        ]);

        return redirect()->route('users.detail', $id)->with('success', 'Berhasil Memperbaharui');
    }
}
