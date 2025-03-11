<?php

namespace App\Http\Controllers;

use App\Mail\mailToken;
use App\Models\Form;
use App\Models\GdnPerbaikan;
use App\Models\UnitKerja;
use App\Models\Usulan;
use App\Models\UsulanDetail;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Carbon\Carbon;
use Str;
use Auth;
use Illuminate\Support\Facades\Mail;

class UsulanController extends Controller
{
    public function show(Request $request, $id)
    {
        $user = Auth::user();
        $role = Auth::user()->role_id;
        $data = Usulan::orderBy('id_usulan', 'desc');
        $listUker = UnitKerja::get();

        $form   = Form::where('kode_form', $id)->first();
        $bulan  = $request->bulan;
        $tahun  = $request->tahun;
        $uker   = $request->uker;
        $status = $request->status;

        if ($role == 4) {
            $data = $data->where('user_id', $user->id)->count();
        } else {
            $data = $data->count();
        }

        return view('pages.usulan.show', compact('form', 'bulan', 'tahun', 'uker', 'status', 'data', 'uker', 'listUker'));
    }

    public function detail($id)
    {
        $data = Usulan::where('id_usulan', $id)->first();
        return view('pages.usulan.detail', compact('data'));
    }

    public function select(Request $request, $id)
    {
        $role    = Auth::user()->role_id;
        $bulan   = $request->bulan;
        $tahun   = $request->tahun;
        $uker    = $request->uker;
        $status  = $request->status;

        $aksi    = $request->aksi;
        $id      = $request->id;
        $data    = Usulan::orderBy('status_persetujuan', 'asc')->orderBy('status_proses', 'asc')->orderBy('tanggal_usulan', 'desc')
            ->join('t_form', 'id_form', 'form_id')
            ->where('kode_form', $id);
        $no       = 1;
        $response = [];

        if ($bulan || $tahun || $uker || $status) {
            if ($bulan) {
                $res = $data->whereMonth('tanggal_usulan', $request->bulan);
            }

            if ($tahun) {
                $res = $data->whereYear('tanggal_usulan', $request->tahun);
            }

            if ($uker) {
                $res = $data->whereHas('user.pegawai', function ($query) use ($uker) {
                    $query->where('uker_id', $uker);
                });
            }

            if ($status == 'verif') {
                $res = $data->whereNull('status_persetujuan');
            }

            if ($status == 'false') {
                $res = $data->where('status_persetujuan', $status);
            }

            if ($status == 'proses' || $status == 'selesai') {
                $res = $data->where('status_proses', $status);
            }

            $result = $res;
        } else if ($aksi == 'status_proses_id') {
            $result = $data->where($aksi, $id);
        } else if ($aksi == 'status_pengajuan_id') {
            $result = $data->where($aksi, $id);
        } else {
            $result = $data;
        }

        if ($role == 4) {
            $result = $result->where('user_id', Auth::user()->id)->get();
        } else {
            $result = $result->get();
        }

        foreach ($result as $row) {

            if ($row->status_persetujuan == 'true') {
                $status = '<span class="badge badge-success p-1 w-100"><i class="fas fa-check-circle"></i> Setuju</span>';
            } else if ($row->status_persetujuan == 'false') {
                $status = '<span class="badge badge-danger p-1 w-100"><i class="fas fa-times-circle"></i> Tolak</span>';
            } else if (!$row->otp_1) {
                $status = '<span class="badge badge-danger p-1 w-100"><i class="fas fa-exclamation-circle"></i> Verif</span>';
            } else {
                $status = '<span class="badge badge-warning p-1 w-100"><i class="fas fa-clock"></i> Pending</span>';
            }

            if ($row->status_proses == 'proses') {
                $proses = '<span class="badge badge-warning p-1 w-100"><i class="fas fa-clock"></i> Proses</span>';
            } else if ($row->status_proses == 'selesai') {
                $proses = '<span class="badge badge-success p-1 w-100"><i class="fas fa-check-circle"></i> Selesai</span>';
            } else {
                $proses = '';
            }

            $aksi = '';


            $aksi .= '
                <a href="' . route('usulan.detail', $row->id_usulan) . '" class="btn btn-default btn-xs bg-primary rounded border-dark">
                    <i class="fas fa-info-circle p-1" style="font-size: 12px;"></i>
                </a>';

            if (Auth::user()->akses_id == 1 && !$row->status_persetujuan) {
                $aksi .= '
                    <a href="' . route('usulan.verif', $row->id_usulan) . '" class="btn btn-default btn-xs bg-warning rounded border-dark">
                        <i class="fas fa-file-signature p-1" style="font-size: 12px;"></i>
                    </a>';
            }

            if (Auth::user()->akses_id == 2 && $row->status_proses == 'proses') {
                $aksi .= '
                    <a href="' . route('usulan.proses', $row->id_usulan) . '" class="btn btn-default btn-xs bg-warning rounded border-dark">
                        <i class="fas fa-file-import p-1" style="font-size: 12px;"></i>
                    </a>';
            }

            $response[] = [
                'no'        => $no,
                'id'        => $row->id_usulan,
                'aksi'      => $aksi,
                'kode'      => $row->kode_usulan,
                'tanggal'   => Carbon::parse($row->tanggal_usulan)->isoFormat('DD MMM Y'),
                'uker'      => ucwords(strtolower($row->user?->pegawai->uker->unit_kerja)),
                'nosurat'   => $row->no_surat_usulan ?? '-',
                'totalItem' => $row->detail->count(),
                'hal'       => $row->detail->map(function ($item) {
                    return Str::limit(' ' . $item->judul, 150);
                }),
                'deskripsi' => $row->detail->map(function ($item) {
                    return $item->uraian . ', ' . $item->keterangan;
                }),
                'status'     => $status . '<br>' . $proses
            ];

            $no++;
        }

        return response()->json($response);
    }

    // ===========================================================
    //                            VERIF
    // ===========================================================

    public function verif(Request $request, $id)
    {
        $cekData = Usulan::where('id_usulan', $id)->first();

        if (!$request->all() && $cekData->status_persetujuan) {
            return redirect()->route('usulan.detail', $id)->with('failed', 'Permintaan tidak dapat di proses');
        }

        if (!$request->all()) {
            $data = Usulan::where('id_usulan', $id)->first();
            $form = $data->form->kode_form;
            return view('pages.usulan.verif', compact('id', 'data', 'form'));
        } else {
            $data = Usulan::with('form', 'user.pegawai.uker')->where('id_usulan', $id)->first();

            $otp3 = rand(111111, 999999);
            $tokenMail = Str::random(32);
            // $logMail = new LogMail();
            // $logMail->token   = $tokenMail;
            // $logMail->save();

            $dataMail = [
                'token' => $tokenMail,
                'nama'  => $data->user->pegawai->nama_pegawai,
                'uker'  => $data->user->pegawai->uker->unit_kerja,
                'otp'   => $otp3
            ];

            // Mail::to($data->user->email)->send(new mailToken($dataMail));

            $klasifikasi = $data->form->klasifikasi;
            $kodeSurat   = $data->user->pegawai->uker->kode_surat;
            $nomorSurat  = Usulan::whereHas('pegawai', function ($query) use ($data) {
                $query->where('status_persetujuan', 'true')->where('uker_id', $data->pegawai->uker_id)->whereYear('tanggal_usulan', Carbon::now()->format('Y'));
            })->count() + 1;
            $tahunSurat  = Carbon::now()->format('Y');

            $format = $klasifikasi . '/' . $kodeSurat . '/' . $nomorSurat . '/' . $tahunSurat;

            Usulan::where('id_usulan', $id)->update([
                'verif_id'           => Auth::user()->pegawai_id,
                'nomor_usulan'       => $request->persetujuan == 'true' ? $format : null,
                'status_persetujuan' => $request->persetujuan,
                'status_proses'      => $request->persetujuan == 'true' ? 'proses' : null,
                'keterangan_tolak'   => $request->alasan_penolakan ?? null,
                'tanggal_selesai'    => $request->tanggal_selesai ?? null,
                'otp_2'              => $request->persetujuan == 'true' ? rand(111111, 999999) : null,
                'otp_3'              => $otp3,
                'tanggal_usulan'     => Carbon::parse($request->tanggal_ambil . ' ' . now()->toTimeString()) ?? Carbon::now()
            ]);
            return redirect()->route('usulan.detail', $id)->with('success', 'Berhasil Melakukan Verifikasi');
        }
    }

    // ===========================================================
    //                           CREATE
    // ===========================================================

    public function create($id)
    {
        $gdn = GdnPerbaikan::orderBy('jenis_perbaikan', 'asc')->get();
        return view('pages.usulan.' . $id . '.create', compact('gdn'));
    }

    public function store(Request $request, $id)
    {
        $form = Form::where('kode_form', $id)->first();
        $kode = Str::random(6);
        $id_usulan = Usulan::withTrashed()->count() + 1;

        $tambah = new Usulan();
        $tambah->id_usulan      = $id_usulan;
        $tambah->user_id        = Auth::user()->id;
        $tambah->pegawai_id     = Auth::user()->pegawai_id;
        $tambah->form_id        = $form->id_form;
        $tambah->kode_usulan    = $kode;
        $tambah->tanggal_usulan = Carbon::now();
        $tambah->otp_1          = rand(111111, 999999);
        $tambah->created_at     = Carbon::now();
        $tambah->save();

        if ($form->id_form == 1 || $form->id_form == 2) {
            $this->storeDetail($request, $id_usulan);
        }

        return redirect()->route('usulan.detail', $id_usulan)->with('success', 'Berhasil Menambahkan');
    }

    public function storeDetail(Request $request, $id)
    {
        $uraian = $request->uraian;
        foreach ($uraian as $i => $uraian) {
            $id_detail = UsulanDetail::withTrashed()->count() + 1;
            $detail = new UsulanDetail();
            $detail->id_detail   = $id_detail;
            $detail->usulan_id   = $id;
            $detail->kategori_id = $request->kategori[$i] ?? null;
            $detail->judul       = $request->judul[$i];
            $detail->uraian      = $uraian;
            $detail->keterangan  = $request->keterangan[$i];
            $detail->created_at  = Carbon::now();
            $detail->save();
        }

        return;
    }

    // ===========================================================
    //                            EDIT
    // ===========================================================

    public function edit($id)
    {
        $data = Usulan::where('id_usulan', $id)->first();
        $form = $data->form->kode_form;
        $gdn  = GdnPerbaikan::orderBy('jenis_perbaikan', 'asc')->get();

        return view('pages.usulan.' . $form . '.edit', compact('id', 'data', 'gdn'));
    }

    public function update(Request $request, $id)
    {
        $judul = $request->judul;

        foreach ($judul as $i => $judul) {
            $id_detail = $request->id_detail[$i];

            if ($id_detail) {
                UsulanDetail::where('id_detail', $id_detail)->update([
                    'kategori_id' => $request->kategori[$i] ?? null,
                    'judul'       => $judul,
                    'uraian'      => $request->uraian[$i],
                    'keterangan'  => $request->keterangan[$i],
                ]);
            } else {
                $id_detail = UsulanDetail::withTrashed()->count() + 1;
                $detail = new UsulanDetail();
                $detail->id_detail   = $id_detail;
                $detail->usulan_id   = $id;
                $detail->kategori_id = $request->kategori[$i] ?? null;
                $detail->judul       = $request->judul[$i];
                $detail->uraian      = $request->uraian[$i];
                $detail->keterangan  = $request->keterangan[$i];
                $detail->created_at  = Carbon::now();
                $detail->save();
            }
        }

        return redirect()->route('usulan.detail', $id)->with('success', 'Berhasil Menyimpan');
    }

    // ===========================================================
    //                            DELETE
    // ===========================================================

    public function delete($id)
    {
        $data = Usulan::where('id_usulan', $id)->first();
        $form = $data->form->kode_form;

        UsulanDetail::where('usulan_id', $id)->delete();
        Usulan::where('id_usulan', $id)->delete();

        return redirect()->route('usulan', $form)->with('success', 'Berhasil Menghapus');
    }

    public function deleteItem($id)
    {
        $data = UsulanDetail::where('id_detail', $id)->first();
        UsulanDetail::where('id_detail', $id)->delete();

        return redirect()->route('usulan.edit', $data->usulan_id)->with('success', 'Berhasil Menghapus');
    }

    // ===========================================================
    //                            SURAT
    // ===========================================================

    public function surat($id, Request $request)
    {
        $data  = Usulan::where('id_usulan', $id)->first();
        $utama = $data->user->pegawai->uker->utama_id;
        $temp  = public_path('dist/format/format-' . $utama . '.pdf');
        $form  = $data->form->nama_form;

        return view('pages.usulan.surat', compact('data'));
    }

    // ===========================================================
    //                            PROSES
    // ===========================================================

    public function proses(Request $request, $id)
    {
        $cekData = Usulan::where('id_usulan', $id)->first();

        if (!$request->all() && $cekData->status_proses != 'proses') {
            return redirect()->route('usulan.detail', $id)->with('failed', 'Permintaan tidak dapat di proses');
        }

        if (!$request->all()) {
            $data = Usulan::where('id_usulan', $id)->first();
            $form = $data->form->kode_form;
            return view('pages.usulan.proses', compact('id', 'data', 'form'));
        } else {
            $data = Usulan::with('form', 'user.pegawai.uker')->where('id_usulan', $id)->first();

            $otp = rand(111111, 999999);

            Usulan::where('id_usulan', $id)->update([
                'tanggal_selesai' => $request->tanggal_selesai,
                'nama_penerima'   => $request->penerima,
                'status_proses'   => $request->proses,
                'otp_4'           => $otp,
            ]);

            return redirect()->route('usulan.detail', $id)->with('success', 'Berhasil Melakukan Serah Terima');
        }
    }
}
