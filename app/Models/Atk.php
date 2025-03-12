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
}
