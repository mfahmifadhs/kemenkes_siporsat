<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsulanBmhp extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table        = "t_usulan_bmhp";
    protected $primaryKey   = "id_detail";
    public $timestamps      = false;

    protected $fillable = [
        'usulan_id',
        'bmhp_id',
        'jumlah',
        'satuan_id',
        'harga',
        'keterangan',
        'status'
    ];

    public function usulan() {
        return $this->belongsTo(Usulan::class, 'usulan_id');
    }

    public function bmhp() {
        return $this->belongsTo(Bmhp::class, 'bmhp_id');
    }

    public function satuan() {
        return $this->belongsTo(AtkSatuan::class, 'satuan_id');
    }
}
