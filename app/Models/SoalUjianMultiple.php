<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalUjianMultiple extends Model
{
use HasFactory;


protected $fillable = ['ujian_id','soal'];


public function ujian() { return $this->belongsTo(Ujian::class); }


// relasi ke jawaban opsi (FK = soal_ujian_id)
public function answer() { return $this->hasMany(SoalUjianAnswer::class, 'soal_ujian_id'); }


// relasi ke jawaban user (FK = multiple_id)
public function userJawaban() { return $this->hasMany(UserJawaban::class, 'multiple_id'); }
}
