<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JawabanSiswa extends Model
{
    use HasFactory;

    protected $fillable = ['multiple_id', 'siswa_id', 'soal_ujian_answer_id', 'nilai'];

    public function multiple()
    {
        return $this->belongsTo(SoalUjianMultiple::class, 'multiple_id');
    }

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    public function jawabanBenar()
    {
        return $this->belongsTo(SoalUjianAnswer::class, 'soal_ujian_answer_id');
    }
}
