<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Bmhp extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_bmhp";
    protected $primaryKey = "id_bmhp";
    public $timestamps = false;

    protected $fillable = [
        'kategori_id',
        'nama_barang',
        'deskripsi',
        'satuan_id',
        'jumlah_maks',
        'jumlah_pcs',
        'harga',
        'keterangan',
        'foto_barang',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(BmhpKategori::class, 'kategori_id');
    }

    public function satuan()
    {
        return $this->belongsTo(AtkSatuan::class, 'satuan_id');
    }

    public function stokMasuk()
    {
        return $this->hasMany(BmhpStokDetail::class, 'bmhp_id');
    }

    public function stokKeluar()
    {
        return $this->hasMany(UsulanBmhp::class, 'bmhp_id')->where('status', 'true');
    }

    public function stok()
    {
        $totalMasuk = $this->stokMasuk()->sum('jumlah');

        $totalKeluar = $this->stokKeluar()->sum('jumlah');

        return $totalMasuk - $totalKeluar;
    }
}
