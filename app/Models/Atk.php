<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

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
        return $this->hasMany(UsulanAtk::class, 'atk_id')->where('status', 'true');
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

    }

    public function stokUker()
    {
        $ukerId = Auth::user()->pegawai->uker_id;
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
}
