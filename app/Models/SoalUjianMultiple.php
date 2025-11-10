<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SoalUjianMultiple extends Model
{
    use HasFactory;

    protected $fillable = ['ujian_id', 'soal'];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function answers()
    {
        return $this->hasMany(SoalUjianAnswer::class);
    }

    public function jawabanSiswas()
    {
        return $this->hasMany(JawabanSiswa::class, 'multiple_id');
    }
}
