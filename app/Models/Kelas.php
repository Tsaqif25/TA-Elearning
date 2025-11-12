<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function dataSiswa()
    {
        return $this->hasMany(DataSiswa::class);
    }

    public function kelasMapels()
    {
        return $this->hasMany(KelasMapel::class);
    }

    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'kelas_mapels', 'kelas_id', 'mapel_id');
    }
}
