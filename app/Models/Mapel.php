<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mapel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'deskripsi'];

    public function kelasMapels()
    {
        return $this->hasMany(KelasMapel::class);
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mapels', 'mapel_id', 'kelas_id');
    }
}
