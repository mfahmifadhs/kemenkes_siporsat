<?php

namespace App\Http\Controllers;

use App\Models\Aadb;
use App\Models\Atk;
use App\Models\Review;
use App\Models\Pegawai;
use App\Models\Penilaian;
use App\Models\Usulan;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = request('tahun', now()->year);
        $bulan = request('bulan', now()->month);

        $usulan = Usulan::query()
            ->whereYear('created_at', $tahun)
            ->when($bulan, function ($query) use ($bulan) {
                $query->whereMonth('created_at', $bulan);
            })
            ->get();

        // Data lainnya tetap seperti sebelumnya
        $aadb = Aadb::get();
        $atk  = Atk::get();
        $role = Auth::user()->role_id;


        if ($role != 4) {
            return view('pages.index', compact('usulan','atk','aadb','tahun','bulan'));
        } else {
            return view('pages.user', compact('aadb','atk'));
        }
    }
}
