<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aadb extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_aadb";
    protected $primaryKey = "id_aadb";
    public $timestamps = false;

    protected $fillable = [
        'uker_id',
        'kategori_id',
        'jenis_aadb',
        'kualifikasi',
        'merk_tipe',
        'no_polisi',
        'no_bpkp',
        'tanggal_perolehan',
        'nilai_perolehan',
        'keterangan',
        'foto_barang',
        'status'
    ];

    public function uker() {
        return $this->hasMany(UnitKerja::class, 'uker_id');
    }

    public function kategori() {
        return $this->hasMany(AadbKategori::class, 'kategori_id');
    }
}
