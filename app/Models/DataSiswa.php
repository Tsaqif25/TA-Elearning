<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataSiswa extends Model
{
    use HasFactory;

 protected $fillable = [
        'name',
        'nis',
        'kelas_id',
        'no_telp',
        'email',
        'password',
        'user_id',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'siswa_id');
    }

    public function jawabanSiswas()
    {
        return $this->hasMany(JawabanSiswa::class, 'siswa_id');
    }
}
