<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_pegawai";
    protected $primaryKey = "id_pegawai";
    public $timestamps = false;

    protected $fillable = [
        'uker_id',
        'nip',
        'nama_pegawai',
        'jabatan_id',
        'tim_kerja',
        'status'
    ];

    public function uker() {
        return $this->belongsTo(UnitKerja::class, 'uker_id');
    }

    public function jabatan() {
        return $this->belongsTo(PegawaiJabatan::class, 'jabatan_id');
    }
}
