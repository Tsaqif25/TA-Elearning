<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];



    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function dataSiswa()
    {
        return $this->hasMany(DataSiswa::class);
    }

    public function kelasMapel()
    {
        return $this->hasMany(KelasMapel::class);
    }

    public function mapels()
{
    return $this->belongsToMany(Mapel::class, 'kelas_mapels', 'kelas_id', 'mapel_id');
}


   
}
