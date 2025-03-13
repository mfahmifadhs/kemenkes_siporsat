<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\Review;
use App\Models\Pegawai;
use App\Models\Penilaian;
use App\Models\Usulan;
use Illuminate\Support\Facades\Auth;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $role   = Auth::user()->role_id;
        $usulan = Usulan::get();
        $atk    = Atk::where('status', 'true')->orderBy('nama_barang', 'asc')->get();

        if ($role != 4) {
            return view('pages.index', compact('usulan','atk'));
        } else {
            return view('pages.user');
        }
    }
}
