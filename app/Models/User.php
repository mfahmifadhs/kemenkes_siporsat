<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $table = "users";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'pegawai_id',
        'email',
        'username',
        'password',
        'password_text',
        'akses_id',
        'status'
    ];

    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function akses() {
        return $this->belongsTo(UserAkses::class, 'akses_id');
    }

    public function usulan() {
        return $this->hasMany(Usulan::class, 'user_id');
    }

    public function keranjang() {
        return $this->hasMany(AtkKeranjang::class, 'user_id');
    }
}
