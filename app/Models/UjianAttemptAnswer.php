<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UjianAttemptAnswer extends Model
{
    protected $fillable = [
        'ujian_attempt_id',
        'soal_ujian_id',
        'answer',
        'is_corret',
    ];

    public function attempt()
    {
        return $this->belongsTo(UjianAttempt::class,'ujian_attempt_id');
    }

    public function soal()
    {
        return $this->belongsTo(SoalUjian::class,'soal_ujian_id');
    }
}
