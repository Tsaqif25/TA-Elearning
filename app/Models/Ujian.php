<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ujian extends Model
{
    use HasFactory;

    protected $fillable = ['kelas_mapel_id', 'name', 'due'];

    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class);
    }

    public function soalMultiples()
    {
        return $this->hasMany(SoalUjianMultiple::class);
    }
}
