<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    use HasFactory;

protected $fillable = [
    'name',
    'nis',
    'kelas_id',
    'no_telp',
    'user_id',
];

  

public function user()
{
    return $this->hasOne(User::class, 'id', 'user_id');
}


    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
