<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AtkSatuan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_atk_satuan";
    protected $primaryKey = "id_satuan";
    public $timestamps = false;

    protected $fillable = [
        'nama_satuan',
        'deskripsi'

    ];
}
