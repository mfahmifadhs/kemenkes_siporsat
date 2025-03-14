<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AtkDistribusi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_atk_distribusi";
    protected $primaryKey = "id_distribusi";
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'kode',
        'tanggal',
        'keterangan'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detail() {
        return $this->hasMany(AtkDistribusiDetail::class, 'distribusi_id');
    }
}
