<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GdnPerbaikan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_gdn";
    protected $primaryKey = "id_gdn";
    public $timestamps = false;

    protected $fillable = [
        'jenis_perbaikan',
        'nama_perbaikan'
    ];
}
