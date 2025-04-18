<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BmhpKategori extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_bmhp_kategori";
    protected $primaryKey = "id_kategori";
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'icon',
        'status'
    ];
}
