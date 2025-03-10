<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsulanDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_usulan_detail";
    protected $primaryKey = "id_detail";
    public $timestamps = false;

    protected $fillable = [
        'usulan_id',
        'judul',
        'uraian',
        'keterangan',
    ];

    public function gdn() {
        return $this->belongsTo(GdnPerbaikan::class, 'kategori_id');
    }

    public function usulan() {
        return $this->belongsTo(Usulan::class, 'usulan_id');
    }
}
