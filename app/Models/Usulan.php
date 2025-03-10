<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usulan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_usulan";
    protected $primaryKey = "id_usulan";
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'pegawai_id',
        'verif_id',
        'form_id',
        'kode_usulan',
        'tanggal_usulan',
        'nomor_usulan',
        'keterangan',
        'keterangan_tolak',
        'tanggal_selesai',
        'nama_penerima',
        'status_persetujuan',
        'status_proses',
        'otp_1',
        'otp_2',
        'otp_3',
        'otp_4'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function verif() {
        return $this->belongsTo(Pegawai::class, 'verif_id');
    }

    public function form() {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function detail() {
        return $this->hasMany(UsulanDetail::class, 'usulan_id');
    }
}
