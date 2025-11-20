<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UjianAttempt extends Model
{
    protected $fillable = [
        'ujian_id',
        'siswa_id',
        'nilai',
        'mulai',
        'selesai',
    ];

    public function ujian(){
        return $this->belongsTo(Ujian::class);
    }

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class,'siswa_id');
    }

    public function answers()
    {
        return $this->hasMany(UjianAttemptAnswer::class);

    }
}
