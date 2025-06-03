<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Carbon\Carbon;

class Atk extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_atk";
    protected $primaryKey = "id_atk";
    public $timestamps = false;

    protected $fillable = [
        'kategori_id',
        'nama_barang',
        'deskripsi',
        'satuan_id',
        'jumlah_maks',
        'harga',
        'keterangan',
        'foto_barang',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(AtkKategori::class, 'kategori_id');
    }

    public function satuan()
    {
        return $this->belongsTo(AtkSatuan::class, 'satuan_id');
    }

    // =====================================================================
    //                          STOK BARANG
    // =====================================================================

    public function stokMasuk()
    {
        return $this->hasMany(AtkStokDetail::class, 'atk_id');
    }

    public function stokKeluar()
    {
        return $this->hasMany(UsulanAtk::class, 'atk_id')->join('t_usulan', 'id_usulan', 'usulan_id')
            ->where('t_usulan_atk.status', 'true')->where('status_persetujuan', 'true');
    }

    public function stok()
    {
        $totalMasuk = $this->stokMasuk()->sum('jumlah');

        $totalKeluar = $this->stokKeluar()->sum('jumlah');

        return $totalMasuk - $totalKeluar;
    }


    public function stokPermintaan()
    {
        return $this->hasMany(UsulanAtk::class, 'atk_id')->where('t_usulan_atk.status', 'true')
            ->join('t_usulan', 'id_usulan', 'usulan_id')
            ->join('users', 'id', 'user_id')
            ->join('t_pegawai', 'id_pegawai', 'pegawai_id');
    }

    public function permintaanAkhir($id = null)
    {
        $data   = UsulanAtk::where('id_detail', $id)->first();
        $ukerId = $data->usulan->pegawai->uker_id;

        $latest = UsulanAtk::whereHas('usulan.user.pegawai', function ($query) use ($ukerId) {
            $query->where('status_persetujuan', 'true');
            $query->where('uker_id', $ukerId);
        })
            ->where('atk_id', $data->atk_id)
            ->where('usulan_id', '!=', $data->usulan_id)
            ->orderByDesc('id_detail')
            ->first();

        return $latest ? Carbon::parse($latest->usulan->tanggal_usulan)->isoFormat('DD MMMM Y') : null;
    }

    // =====================================================================
    //                          STOK BARANG UKER
    // =====================================================================

    public function stokMasukUker()
    {
        $ukerId = Auth::user()->pegawai->uker_id;

        return UsulanAtk::whereHas('usulan.user.pegawai', function ($query) use ($ukerId) {
            $query->where('status_persetujuan', 'true');
            if ($ukerId) {
                $query->where('uker_id', $ukerId);
            }
        })->where('atk_id', $this->id_atk)->sum('jumlah');
    }

    public function stokKeluarUker()
    {
        $ukerId = Auth::user()->pegawai->uker_id;

        return AtkDistribusiDetail::whereHas('distribusi.user.pegawai', function ($query) use ($ukerId) {
            if ($ukerId) {
                $query->where('uker_id', $ukerId);
            }
        })->where('atk_id', $this->id_atk)->where('status', 'true')->sum('jumlah');

        // return AtkDistribusiDetail::whereHas('distribusi.user.pegawai', function ($query) use ($ukerId) {
        //     if ($ukerId) {
        //         $query->where('uker_id', $ukerId);
        //     }
        // })->whereHas('usulan', function ($q) {
        //     $q->where('status_proses', 'diproses');
        // })->where('atk_id', $this->id_atk)->where('status', 'true')->sum('jumlah');
    }

    public function stokUker($id = null)
    {
        $ukerId = $id ?? Auth::user()->pegawai->uker_id;
        $dataMasuk = UsulanAtk::whereHas('usulan.user.pegawai', function ($query) use ($ukerId) {
            $query->where('status_persetujuan', 'true');
            if ($ukerId) {
                $query->where('uker_id', $ukerId);
            }
        })->where('atk_id', $this->id_atk)->sum('jumlah');

        $dataKeluar = AtkDistribusiDetail::whereHas('distribusi.user.pegawai', function ($query) use ($ukerId) {
            if ($ukerId) {
                $query->where('uker_id', $ukerId);
            }
        })->where('atk_id', $this->id_atk)->where('status', 'true')->sum('jumlah');
        return $dataMasuk - $dataKeluar;
    }

    public function distribusiAtk($id)
    {
        return $this->hasMany(AtkDistribusiDetail::class, 'atk_id')->whereHas('distribusi.user.pegawai', function ($query) use ($id) {
            if ($id) {
                $query->where('uker_id', $id);
            }
        });
    }
}
