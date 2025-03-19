<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsulanBbm extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_usulan_bbm";
    protected $primaryKey = "id_detail";
    public $timestamps = false;

    protected $fillable = [
        'usulan_id',
        'aadb_id',
    ];

    public function aadb() {
        return $this->belongsTo(Aadb::class, 'aadb_id');
    }

    public function usulan() {
        return $this->belongsTo(Usulan::class, 'usulan_id');
    }
}
