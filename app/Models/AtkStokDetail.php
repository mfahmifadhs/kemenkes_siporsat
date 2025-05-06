<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AtkStokDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table        = "t_atk_stok_detail";
    protected $primaryKey   = "id_detail";
    public $timestamps      = false;

    protected $fillable = [
        'id_detail',
        'stok_id',
        'atk_id',
        'jumlah'
    ];

    public function stok() {
        return $this->belongsTo(AtkStok::class, 'stok_id');
    }

    public function atk() {
        return $this->belongsTo(Atk::class, 'atk_id');
    }
}
