<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BmhpStok extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table        = "t_bmhp_stok";
    protected $primaryKey   = "id_stok";
    public $timestamps      = false;

    protected $fillable = [
        'kode_stok',
        'tanggal_beli',
        'no_kwitansi',
        'total_harga',
        'keterangan'
    ];

    public function detail() {
        return $this->hasMany(AtkStokDetail::class, 'stok_id');
    }
}
