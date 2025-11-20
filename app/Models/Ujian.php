<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ujian extends Model
{
    use HasFactory;

    protected $fillable = ['kelas_mapel_id', 'guru_id','judul','deskripsi','durasi_menit','random_question','random_answer','show_answer'];

    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class);
    }

  public function guru()
  {
    return $this->belongsTo(Guru::class);
  }

  public function soal(){
    return $this->hasMany(SoalUjian::class);
  }

  public function attempts(){
    return $this->hasMany(UjianAttempt::class);
  }
}
