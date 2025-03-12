<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AtkKeranjang extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table        = "t_atk_keranjang";
    protected $primaryKey   = "id_keranjang";
    public $timestamps      = false;

    protected $fillable = [
        'user_id',
        'atk_id',
        'jumlah',
        'status'
    ];

    public function atk() {
        return $this->belongsTo(Atk::class, 'atk_id');
    }
}
