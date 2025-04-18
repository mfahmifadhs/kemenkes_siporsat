<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BmhpKeranjang extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table        = "t_bmhp_keranjang";
    protected $primaryKey   = "id_keranjang";
    public $timestamps      = false;

    protected $fillable = [
        'user_id',
        'bmhp_id',
        'jumlah',
        'status'
    ];

    public function bmhp() {
        return $this->belongsTo(Bmhp::class, 'bmhp_id');
    }
}
