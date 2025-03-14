<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AtkDistribusiDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_atk_distribusi_detail";
    protected $primaryKey = "id_detail";
    public $timestamps = false;

    protected $fillable = [
        'distribusi_id',
        'atk_id',
        'jumlah',
        'satuan_id',
        'status'
    ];

    public function distribusi() {
        return $this->belongsTo(AtkDistribusi::class, 'distribusi_id');
    }

    public function atk() {
        return $this->belongsTo(Atk::class, 'atk_id');
    }

    public function satuan() {
        return $this->belongsTo(AtkSatuan::class, 'satuan_id');
    }
}
