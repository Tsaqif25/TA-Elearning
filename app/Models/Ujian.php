<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
use HasFactory;


protected $fillable = ['kelas_mapel_id','name','due'];


// Konvensi nama method relasi (lowerCamelCase)
public function kelasMapel() { return $this->belongsTo(KelasMapel::class); }
public function soalUjianMultiple() { return $this->hasMany(SoalUjianMultiple::class); }



public function user() { return $this->belongsTo(User::class); }
}
