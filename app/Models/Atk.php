<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function kategori() {
        return $this->belongsTo(AtkKategori::class, 'kategori_id');
    }

    public function satuan() {
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
        return $this->hasMany(UsulanAtk::class, 'atk_id')->where('t_usulan_atk.status', 'true')
            ->join('t_usulan', 'id_usulan', 'usulan_id')
            ->join('users', 'id', 'user_id')
            ->join('t_pegawai', 'id_pegawai', 'pegawai_id')
            ->where('uker_id', Auth::user()->pegawai->uker_id);
    }

    public function stokKeluarUker()
    {
        return $this->hasMany(KegiatanDetail::class, 'snc_id')
            ->join('t_kegiatan', 'id_kegiatan', 'kegiatan_id')
            ->join('users', 'id', 'user_id')
            ->join('t_pegawai', 'id_pegawai', 'pegawai_id')
            ->where('t_kegiatan_detail.status', 'true')
            ->where('uker_id', Auth::user()->pegawai->uker_id);
    }

    public function stokUker($ukerId)
    {
        $dataMasuk  = $this->stokMasukUker();
        $dataKeluar = $this->stokKeluarUker();

        if ($ukerId) {
            $totalMasuk  = $dataMasuk->where('uker_id', $ukerId)->sum('jumlah_permintaan');
            $totalKeluar = $dataKeluar->where('uker_id', $ukerId)->sum('jumlah');
        } else {
            $totalMasuk  = $dataMasuk->sum('jumlah_permintaan');
            $totalKeluar = $dataKeluar->sum('jumlah');
        }

        return $totalMasuk - $totalKeluar;
    }
}
