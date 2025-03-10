<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserAkses extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $table = "users_akses";
    protected $primaryKey = "id_akses";
    public $timestamps = false;

    protected $fillable = [
        'nama_akses',
    ];

    public function user() {
        return $this->hasMany(User::class, 'akses_id');
    }
}
