<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BmhpStokDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table        = "t_bmhp_stok_detail";
    protected $primaryKey   = "id_detail";
    public $timestamps      = false;

    protected $fillable = [
        'id_detail',
        'stok_id',
        'bmhp_id',
        'jumlah'
    ];

    public function stok() {
        return $this->belongsTo(BmhpStok::class, 'stok_id');
    }

    public function atk() {
        return $this->belongsTo(Bmhp::class, 'bmhp_id');
    }
}
