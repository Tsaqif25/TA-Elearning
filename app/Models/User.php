<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser; 
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'kelas_id',
        'password',
        'deskripsi',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];

public function dataSiswa()
{
    return $this->hasOne(DataSiswa::class);
}



    // public function contact()
    // {
    //     return $this->hasOne(Contact::class);
    // }

    public function editorAccess()
    {
        return $this->hasMany(EditorAccess::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    public function userTugas()
    {
        return $this->hasMany(UserTugas::class);
    }

    // public function userMateri()
    // {
    //     return $this->hasMany(UserMateri::class);
    // }

    public function userJawaban()
    {
        return $this->hasMany(UserJawaban::class);
    }

      public function canAccessPanel(\Filament\Panel $panel): bool
    {
        // Hanya Admin & Pengajar yang boleh masuk ke /admin
         return $this->hasRole(['Admin', 'Pengajar', 'Wakur']);
    }











}
