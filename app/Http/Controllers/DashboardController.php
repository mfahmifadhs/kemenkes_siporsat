<?php

namespace App\Http\Controllers;

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

        if ($role != 4) {
            return view('pages.index', compact('usulan'));
        } else {
            return view('pages.user');
        }
    }
}
