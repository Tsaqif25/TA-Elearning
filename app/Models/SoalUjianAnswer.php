<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SoalUjianAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['soal_ujian_id', 'jawaban', 'is_correct'];

    public function soal()
    {
        return $this->belongsTo(SoalUjianMultiple::class, 'soal_ujian_id');
    }
}
