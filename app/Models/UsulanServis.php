<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsulanServis extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_usulan_servis";
    protected $primaryKey = "id_servis";
    public $timestamps = false;

    protected $fillable = [
        'usulan_id',
        'aadb_id',
        'uraian',
        'keterangan',
        'foto'
    ];

    public function usulan() {
        return $this->belongsTo(Usulan::class, 'usulan_id');
    }

    public function aadb() {
        return $this->belongsTo(Aadb::class, 'aadb_id');
    }
}
