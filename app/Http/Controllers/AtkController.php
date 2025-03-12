<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\AtkKategori;
use App\Models\Usulan;
use Illuminate\Http\Request;
use Auth;

class AtkController extends Controller
{
    public function index()
    {
        $kategori = AtkKategori::where('status', 'true')->orderBy('nama_kategori','asc')->get();
        $atk      = Atk::where('status', 'true')->orderBy('nama_barang','asc')->get();
        $user     = Auth::user();
        $data     = Usulan::where('form_id', '3');

        if ($user->role_id == 4) {
            $usulan = $data->where('user_id', $user->id)->get();
        } else {
            $usulan = $data->get();
        }

        return view('pages.usulan.atk.create', compact('kategori','atk','usulan'));
    }
}
