<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $fillable = [
   
        'name',
        'deskripsi',
    ];



    public function kelasMapel()
    {
        return $this->hasMany(KelasMapel::class);
    }

    public function kelas(){
        return $this->belongsToMany(Kelas::class,'kelas_mapels','mapel_id','kelas_id');
    }



}
