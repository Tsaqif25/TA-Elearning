<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 🔹 Relasi ke siswa dan guru
    public function dataSiswa()
    {
        return $this->hasOne(DataSiswa::class);
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    public function repositories()
    {
        return $this->hasMany(Repository::class);
    }

    public function pengumumans()
    {
        return $this->hasMany(Pengumuman::class);
    }
}
